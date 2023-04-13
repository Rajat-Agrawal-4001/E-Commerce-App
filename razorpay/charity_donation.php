<?php

session_start();

require_once "../config/connection.php";

require_once("razorpay-php/config.php");

require_once("razorpay-php/Razorpay.php");



use Razorpay\Api\Api;

use Razorpay\Api\Errors\SignatureVerificationError;



$api = new Api(RAZORPAY_KEY, RAZORPAY_SECRET);



require_once "../vendor/payment_processor.php";

require_once("../config/generalMailer.php");



$vendor_id = getVendorID();



if (isset($_POST['donation'])) {



    $use_from_ebanking = round((float)realEscape($_POST['ebanking']), 2);

    $use_from_ewallet = round((float)realEscape($_POST['ewallet']), 2);



    $_SESSION['donation_log'] = $_POST;

    $charity_id = (int)$_SESSION['CURRENT_CHARITY_ID'];





    $amount = (float)($_POST['amount']);

    $qry = "SELECT * FROM marketplace_charity WHERE id = '$charity_id' ";

    $res = mysqli_query($conn, $qry);

    $charity_dets = mysqli_fetch_assoc($res);



    $transactionCharge = transactionChargeFinder(17, $charity_dets['vendor_id'])['TRANSACTION_CHARGE'];



    $beneficiary_qty = explode(",", $_POST['beneficiaryQty']);

    $beneficiary_data = array();



    foreach (explode(',', $_POST['beneficiary']) as $index => $id) {

        if (trim($id) == '')   continue;



        $id = (int)($id);

        $qry = "SELECT * FROM beneficiary WHERE id = '$id' ";

        $res = mysqli_query($conn, $qry);

        if (!$res) {

            errlog(mysqli_error($conn), $qry);

        }

        $data = mysqli_fetch_assoc($res);



        $beneficiary_data[] = array("ID" => $id, "QTY" => $beneficiary_qty[$index], "PRICE" => round($data['amount'] * $beneficiary_qty[$index], 2));

        $amount += round($data['amount'] * $beneficiary_qty[$index], 2);

    }





    $goods_qty = explode(",", $_POST['goodsQty']);

    $goods_data = array();



    foreach (explode(',', $_POST['goods']) as $index => $id) {

        if (trim($id) == '')   continue;



        $id = (int)($id);

        $qry = "SELECT * FROM expectations WHERE id = '$id' ";

        $res = mysqli_query($conn, $qry);

        if (!$res) {

            errlog(mysqli_error($conn), $qry);

        }

        $data = mysqli_fetch_assoc($res);



        $item_amount = 0;

        $item_discount = 0;

        $item_det = $id;

        if ($data['item_id'] > 0  &&  $data['variant_id'] > 0) {

            $item_det = array("ID" => $id, "PID" => $data['item_id'], "VAR_ID" => $data['variant_id']);

            $qry = "SELECT *, 

                    (SELECT SUM(discount_percent) FROM discounts WHERE product_id = mp.id AND discount_for = 'CHARITY' ) 

                        AS discount_percent, 

                    (SELECT SUM(fixed_amount) FROM discounts WHERE product_id = mp.id AND discount_for = 'CHARITY' ) 

                        AS discount_flat 

                    FROM marketplace_products mp 

                    INNER JOIN product_variants pv ON pv.product_id = mp.id 

                    WHERE mp.save_type = 'ORG' AND mp.id = '" . (int)($data['item_id']) . "' AND pv.id = '" . (int)($data['variant_id']) . "' ";



            $res = mysqli_query($conn, $qry);

            if (!$res) {

                errlog(mysqli_error($conn), $qry);

            }

            $data = mysqli_fetch_assoc($res);



            if (!isset($data['id'])) {

                continue;

            }



            $item_det['VENDOR'] = $data['vendor_id'];



            if ($data['discount_percent'] > 0) {

                $item_discount = ((float)$data['discount_percent'] * $data['price']) / 100;

            }



            if ($data['discount_flat'] > 0) {

                $item_discount += ((float)$data['discount_flat']);

            }



            if ($data['price'] - $item_discount > 0) {

                $item_amount = $data['price'] - $item_discount;

            } else {

                $item_discount = $data['price'];

            }



            $item_det['DISCOUNT'] = $item_discount;

        } else {

            $item_amount = $data['cash_amount'];

        }



        $goods_data[] = array("ID" => $item_det, "QTY" => $goods_qty[$index], "PRICE" => round($item_amount * $goods_qty[$index], 2));

        $amount += round($item_amount * $goods_qty[$index], 2);

    }





    if (isset($_POST['transactionChargeIncluded'])  &&  $_POST['transactionChargeIncluded']) {

        $amount += ($transactionCharge * $amount / 100);

    }





    $split = splitPayment($amount, $use_from_ebanking, $use_from_ewallet);

    $_SESSION['PROCESSED_DATA'] = array("CHARITY_DETS" => $charity_dets, "GOODS" => $goods_data, "BENE" => $beneficiary_data, "TOTAL" => $amount, "SPLIT_AMOUNT" => $split);





    //die(json_encode(["error" => "test"]));

    $amount = round($split['REMAINING'], 2);

    if ($amount <= 0) {

        if (deduct_from_ewallet($split['EWALLET'], $vendor_id, "Donated for charity: '" . $charity_dets['fundraiser_title'] . "' & beneficiary name: '" . $charity_dets['beneficiary_name'] . "' ") < $split['EWALLET']) {

            errlog("Amount deduction error", "charity_donation.php");

            die(json_encode(["error" => "Internal Error"]));

        }

        if (deduct_from_ebanking($split['EBANKING'], $vendor_id, "Donated for charity: '" . $charity_dets['fundraiser_title'] . "' & beneficiary name: '" . $charity_dets['beneficiary_name'] . "' ") < $split['EBANKING']) {

            errlog("Amount deduction error", "charity_donation");

            die(json_encode(["error" => "Internal Error"]));

        }



        $qry = "INSERT INTO `orders`(`site_id`, `item_type`, `item_id`, `validity`, `vendor_id`, `quantity`, `amount`, `paid_from_ewallet`, `paid_from_ebanking`, `item_discount`, `payment_status`, `payment_mode`, `address`, `order_status`, `order_date`, `updated_date`, `name`, `email`, `anonymous`, `nationality`) VALUES ($this_site_id, '17', '$charity_id', '-1', '" . $vendor_id . "', '1', '" . $split['REMAINING'] . "', '" . $split['EWALLET'] . "', '" . $split['EBANKING'] . "', '0', 'PAID', 'EWALLET', '', 'COMPLETED', '$curr_date', '$curr_date', '" . realEscape($_POST['customName']) . "', '" . realEscape($_POST['customEmail']) . "', '" . (int)($_POST['donateAsAnonymous']) . "', '" . realEscape($_POST['nationality']) . "')";


        if (!mysqli_query($conn, $qry)) {

            errlog(mysqli_error($conn), $qry);

            die(json_encode(["error" => "Internal Error"]));

        }



        $order_id = mysqli_insert_id($conn);



        foreach ($_SESSION['PROCESSED_DATA']['BENE'] as $bene) {

            $id = (int)$bene['ID'];

            $qty = (int)$bene['QTY'];

            $price = (float)$bene['PRICE'];



            $qry = "INSERT INTO `order_details`(`site_id`, `vendor_id`, `order_id`, `marketplace_id`, `item_id`, `quantity`, `price`, `discount`, `order_date`, `status`) VALUES ($this_site_id, $vendor_id, '$order_id', 'CHARITY_BENEFICIARY', '$id', '$qty', '$price', '0', '$curr_date', 1)";

            if (!mysqli_query($conn, $qry)) {

                errlog(mysqli_error($conn), $qry);

            }



            $qry = "UPDATE beneficiary SET unit_received = unit_received + $qty WHERE id = $id ";

            if (!mysqli_query($conn, $qry)) {

                errlog(mysqli_error($conn), $qry);

            }

        }





        foreach ($_SESSION['PROCESSED_DATA']['GOODS'] as $good) {



            $qty = (int)$good['QTY'];

            $price = (float)$good['PRICE'];



            if (is_array($good['ID'])) {

                $id = (int)$good['ID']['ID'];

                $pid = (int)$good['ID']['PID'];

                $var = (int)$good['ID']['VAR_ID'];

                $discount = (float)$good['ID']['DISCOUNT'];



                $qry = "INSERT INTO `order_details`(`site_id`, `vendor_id`, `order_id`, `marketplace_id`, `item_id`, `quantity`, `price`, `discount`, `order_date`, `variant_id`, `status`) VALUES ($this_site_id, $vendor_id, $order_id, '5', $pid, $qty, $price, $discount, '$curr_date', $var, 0)";

            } else {

                $id = (int)$good['ID'];

                $qry = "INSERT INTO `order_details`(`site_id`, `vendor_id`, `order_id`, `marketplace_id`, `item_id`, `quantity`, `price`, `discount`, `order_date`, `status`) VALUES ($this_site_id, $vendor_id, $order_id, 'CHARITY_EXPECTATION', $id, $qty, $price, 0, '$curr_date', 2)";

            }

            if (!mysqli_query($conn, $qry)) {

                errlog(mysqli_error($conn), $qry);

            }



            $qry = "UPDATE expectations SET raised_amount = raised_amount + $qty WHERE id = $id ";

            if (!mysqli_query($conn, $qry)) {

                errlog(mysqli_error($conn), $qry);

            }

        }



        $qry = "UPDATE marketplace_charity SET cash_raised = cash_raised + " . $split['REMAINING'] . " WHERE id = $charity_id ";

        if (!mysqli_query($conn, $qry)) {

            errlog(mysqli_error($conn), $qry);

        }



        unset($_SESSION['PROCESSED_DATA']);

        die(json_encode(["wallet", true]));

    }

    if ($amount < 1) {
        $amount = 1;
    }



    $qry = "INSERT INTO `orders`(`site_id`, `item_type`, `item_id`, `validity`, `vendor_id`, `quantity`, `amount`, `paid_from_ewallet`, `paid_from_ebanking`, `item_discount`, `payment_status`, `payment_mode`, `address`, `order_status`, `order_date`, `updated_date`, `name`, `email`, `anonymous`, `nationality`) VALUES ($this_site_id, '17', '$charity_id', '-1', '" . $vendor_id . "', '1', '" . $split['REMAINING'] . "', '" . $split['EWALLET'] . "', '" . $split['EBANKING'] . "', '0', 'PENDING', 'RAZOR-PAY', '', 'PENDING', '$curr_date', '$curr_date', '" . realEscape($_POST['customName']) . "', '" . realEscape($_POST['customEmail']) . "', '" . (int)($_POST['donateAsAnonymous']) . "', '" . realEscape($_POST['nationality']) . "')";


    if (!mysqli_query($conn, $qry)) {

        errlog(mysqli_error($conn), $qry);

        die(json_encode(["error" => "Internal Error"]));

    }



    $order_id = mysqli_insert_id($conn);

    $_SESSION['donation_in_progress'] = $order_id;

    $_SESSION['amount_to_be_paid'] = $amount;


    $orderData = [

        'receipt'         => 'rcptid_11',

        'amount'          => $amount * 100,  // in paise

        'currency'        => 'INR'

    ];



    $razorpayOrder = $api->order->create($orderData);

    $newArray = array();

    foreach ($razorpayOrder as $key => $value) {

        if (is_object($key)  ||  is_object($value))   continue;

        $newArray[$key] = $value;

    }



    echo json_encode($newArray);

} else if (isset($_POST['verify_donation'])  &&  isset($_SESSION['donation_in_progress'])) {

    // ! uncomment in live mode



    $order_id = $_SESSION['donation_in_progress'];



    // $id = $_POST['payment_status']['razorpay_payment_id'];

    // $order_id = $_POST['payment_status']['razorpay_order_id'] ;

    // $sign = $_POST['payment_status']['razorpay_signature'] ;



    // $success = true;



    // $error = "Payment Failed";



    // if (empty($_POST['razorpay_payment_id']) === false) {

    //     $api = new Api(RAZORPAY_KEY, RAZORPAY_SECRET);



    //     try {

    //         // Please note that the razorpay _details ID must

    //         // come from a trusted source (session here, but

    //         // could be database or something else)

    //         $attributes = array(

    //             'razorpay_order_id' => $order_id,

    //             'razorpay_payment_id' => $id,

    //             'razorpay_signature' => $sign

    //         );



    //         $api->utility->verifyPaymentSignature($attributes);

    //     } catch (SignatureVerificationError $e) {

    //         $success = false;

    //         $error = 'Razorpay Error : ' . $e->getMessage();

    //     }

    // }



    // if ($success === true) {

    //     $html = "<p>Your payment was successful</p>

    //         <p>Payment ID: {$id}</p>";

    // } else {

    //     $html = "<p>Your payment failed</p>

    //         <p>{$id}</p>";

    // }



    // echo $html;





    $charity_dets = $_SESSION['PROCESSED_DATA']['CHARITY_DETS'];

    $split = $_SESSION['PROCESSED_DATA']['SPLIT_AMOUNT'];

    $charity_id = $charity_dets['id'];





    if (deduct_from_ewallet($split['EWALLET'], $vendor_id, "Donated for charity: '" . $charity_dets['fundraiser_title'] . "' & beneficiary name: '" . $charity_dets['beneficiary_name'] . "' ") < $split['EWALLET']) {

        errlog("Amount deduction error", "charity_donation.php");

        die(json_encode(["error" => "Internal Error"]));

    }

    if (deduct_from_ebanking($split['EBANKING'], $vendor_id, "Donated for charity: '" . $charity_dets['fundraiser_title'] . "' & beneficiary name: '" . $charity_dets['beneficiary_name'] . "' ") < $split['EBANKING']) {

        errlog("Amount deduction error", "charity_donation");

        die(json_encode(["error" => "Internal Error"]));

    }





    $qry = "UPDATE orders SET payment_status = 'PAID', order_status = 'COMPLETED' WHERE id = '$order_id' ";





    if (!mysqli_query($conn, $qry)) {

        errlog(mysqli_error($conn), $qry);

    }



    foreach ($_SESSION['PROCESSED_DATA']['BENE'] as $bene) {

        $id = (int)$bene['ID'];

        $qty = (int)$bene['QTY'];

        $price = (float)$bene['PRICE'];



        $qry = "INSERT INTO `order_details`(`site_id`, `vendor_id`, `order_id`, `marketplace_id`, `item_id`, `quantity`, `price`, `discount`, `order_date`, `status`) VALUES ($this_site_id, $vendor_id, '$order_id', 'CHARITY_BENEFICIARY', '$id', '$qty', '$price', '0', '$curr_date', 1)";

        if (!mysqli_query($conn, $qry)) {

            errlog(mysqli_error($conn), $qry);

        }



        $qry = "UPDATE beneficiary SET unit_received = unit_received + $qty WHERE id = $id ";

        if (!mysqli_query($conn, $qry)) {

            errlog(mysqli_error($conn), $qry);

        }

    }





    foreach ($_SESSION['PROCESSED_DATA']['GOODS'] as $good) {



        $qty = (int)$good['QTY'];

        $price = (float)$good['PRICE'];



        if (is_array($good['ID'])) {

            $id = (int)$good['ID']['ID'];

            $pid = (int)$good['ID']['PID'];

            $var = (int)$good['ID']['VAR_ID'];

            $discount = (float)$good['ID']['DISCOUNT'];



            $qry = "INSERT INTO `order_details`(`site_id`, `vendor_id`, `order_id`, `marketplace_id`, `item_id`, `quantity`, `price`, `discount`, `order_date`, `variant_id`, `status`) VALUES ($this_site_id, $vendor_id, $order_id, '5', $pid, $qty, $price, $discount, '$curr_date', $var, 0)";

        } else {

            $id = (int)$good['ID'];

            $qry = "INSERT INTO `order_details`(`site_id`, `vendor_id`, `order_id`, `marketplace_id`, `item_id`, `quantity`, `price`, `discount`, `order_date`, `status`) VALUES ($this_site_id, $vendor_id, $order_id, 'CHARITY_EXPECTATION', $id, $qty, $price, 0, '$curr_date', 2)";

        }

        if (!mysqli_query($conn, $qry)) {

            errlog(mysqli_error($conn), $qry);

        }



        $qry = "UPDATE expectations SET raised_amount = raised_amount + $qty WHERE id = $id ";

        if (!mysqli_query($conn, $qry)) {

            errlog(mysqli_error($conn), $qry);

        }

    }





    $qry = "UPDATE marketplace_charity SET cash_raised = cash_raised + " . $split['REMAINING'] . " WHERE id = $charity_id ";

    if (!mysqli_query($conn, $qry)) {

        errlog(mysqli_error($conn), $qry);

    }





    unset($_SESSION['PROCESSED_DATA']);

    die("1");

}

