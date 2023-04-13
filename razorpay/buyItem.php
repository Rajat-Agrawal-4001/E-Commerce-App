<?php
session_start();
if (!isset($_SESSION['vendor_id'])  &&  !isset($_SESSION['user_id'])) {
    die(json_encode(array("error" => "Unknown User"))) ;
}
require_once "../config/connection.php" ;
require_once("razorpay-php/config.php");
require_once("razorpay-php/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api(RAZORPAY_KEY, RAZORPAY_SECRET);

require_once "../vendor/payment_processor.php";
require_once("../config/generalMailer.php");

if (isset($_POST['make_payment'])) {

    if (!isset($_SESSION['use_from_ewallet'])  ||  !isset($_SESSION['use_from_ebanking'])) {
        die(json_encode(array("error" => "Unknown request"))) ;
    }

    $use_from_ebanking = $_SESSION['use_from_ebanking'];
    $use_from_ewallet = $_SESSION['use_from_ewallet'];
    $coups_used = isset($_SESSION['APPLIED_COUPON']) ? $_SESSION['APPLIED_COUPON']['coupon_code'] : "";
    $address_id = $_SESSION['use_address'];

    $total_price = $total_discount = $total_shipping_price = $total_coupon_discount = 0;
    $item_types = '';
    $item_ids = '';
    $quantities = '';
    $variants = '';

    $item_array = array();
    $price_array = array();
    $discount_array = array();
    $variant_array = array();
    $bundle_array = array();
    $marketplace_array = array();
    $add_array = array();
    $quantity_array = array();


    $vid = -1;

    if (isset($_SESSION['user_id'])) {
        $vid = $_SESSION['user_id'];
    } else if (isset($_SESSION['vendor_id'])) {
        $vid = $_SESSION['vendor_id'];
    }


    $coups_used = explode(',', $coups_used);



    $qry = "SELECT * from cart_n_wishlist where save_type = 'CART' AND save_status = '1' AND quantity > 0 AND vendor_id = '$vid' AND site_id = '$this_site_id' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }

    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);

    foreach ($data as $datum) {
        $prod_id = realEscape($datum['item_id']);
        $var_id = realEscape($datum['variant_id']);

        $qry = "";
        switch (($datum['marketplace_id'])) {
            case "5":
            case '6':
                $qry = "SELECT *, marketplace_products.id as prod_id, product_variants.id as var_id from marketplace_products, product_variants where marketplace_products.id = '" . realEscape($datum['item_id']) . "' AND marketplace_products.site_id = '$this_site_id' AND product_variants.id = '$var_id' ";
                break;
            case "16":
                $qry = "SELECT *, marketplace_services.id as prod_id from marketplace_services where id = '" . realEscape($datum['item_id']) . "' ";
                break;
        }

        if ($qry == "") {
            continue;
        }

        if ($item_types == "") {
            $item_types = ($datum['marketplace_id']);
        } else {
            $item_types .= "," . ($datum['marketplace_id']);
        }



        if ($quantities == "") {
            $quantities = ($datum['quantity']);
        } else {
            $quantities .= "," . ($datum['quantity']);
        }

        $res = mysqli_query($conn, $qry);
        if (!$res) {
            errlog(mysqli_error($conn), $qry);
        }

        $item_det = mysqli_fetch_assoc($res);

        // echo $item_det['price'] . "<br>" ;
        // print_r($item_det) ;
        // die;

        $temp_pr = 0;

        if ($item_ids == "") {
            $item_ids = ($datum['item_id']);
            $tmp_add = '';

            if (($datum['marketplace_id']) == '16'  &&  $datum['bundle'] == '1') {
                $idd = $prod_id;

                $sql89 = " SELECT * FROM addon WHERE marketplace_id = '16' AND item_id = '$idd' AND type = 'ADDON' ";
                $result89 = mysqli_query($conn, $sql89);
                if (!$result89) {
                    errlog(mysqli_error($conn), $sql89);
                } else {
                    while ($row89 = mysqli_fetch_assoc($result89)) {
                        $variants .= $row89['id'] . "+";
                        $temp_pr += (float) $row89['price'];
                    }
                }
            } else {
                $variants = $var_id;
            }
            array_push($add_array, $tmp_add);
        } else {
            $item_ids .= "," . ($datum['item_id']);
            $tmp_add = '';

            if (($datum['marketplace_id']) == '16'  &&  $datum['bundle'] == '1') {
                $idd = $prod_id;

                $sql89 = " SELECT * FROM addon WHERE marketplace_id = '16' AND item_id = '$idd' AND type = 'ADDON' ";
                $result89 = mysqli_query($conn, $sql89);
                if (!$result89) {
                    errlog(mysqli_error($conn), $sql89);
                } else {
                    $variants .= ',';
                    while ($row89 = mysqli_fetch_assoc($result89)) {
                        $variants .= "+" . $row89['id'];
                        $tmp_add .= $row89['id'] . ",";
                        $temp_pr += (float) $row89['price'];
                    }
                }
            } else {
                $variants .= ',' . $var_id;
            }

            array_push($add_array, $tmp_add);
        }


        if ($datum['marketplace_id'] == '6') {
            $qry = "SELECT * FROM btbprice WHERE id = '" . realEscape($datum['bundle']) . "' ";
            $res = mysqli_query($conn, $qry);
            if (!$res) {
                errlog(mysqli_error($conn), $qry);
            }

            $d = mysqli_fetch_assoc($res);
            $item_det['price'] = $d['price'];
        }



        $tmp_price_for_array = ((float)(realEscape($item_det['price'])) + $temp_pr) * $datum['quantity'];

        $total_price += ((float)(realEscape($item_det['price'])) + $temp_pr) * $datum['quantity'];

        $qry = "SELECT * from discounts where product_id = '" . $prod_id . "' AND discount_for = 'GENERAL' AND marketplace_id = '" . $datum['marketplace_id'] . "' ";

        // die ($qry) ;
        $res = mysqli_query($conn, $qry);
        if (!$res) {
            errlog(mysqli_error($conn), $qry);
        }
        $dis = mysqli_fetch_all($res, MYSQLI_ASSOC);

        $d = 0;
        foreach ($dis as $row) {
            $d += $row['discount_percent'];
        }

        $d = ($d * $item_det['price']) / 100;
        $d *= $datum['quantity'];

        array_push($price_array, $tmp_price_for_array - $d);
        array_push($item_array, $datum['item_id']);
        array_push($quantity_array, $datum['quantity']);
        array_push($variant_array, $datum['variant_id']);
        array_push($marketplace_array, $datum['marketplace_id']);
        array_push($bundle_array, $datum['bundle']);
        array_push($discount_array, $d);

        $total_discount += $d;

        // if (isset($item_det['shipping_cost'])) {
        //     $total_shipping_price += (float)(realEscape($item_det['shipping_cost']));
        // }


        $prod_coup = explode(',', $item_det['coupon_id']);
        foreach ($prod_coup as $c) {
            if (array_search($c, $coups_used) !== false) {

                $qry = "SELECT * from coupons where id = '$c' AND start_date <= '$curr_date' AND end_date >= '$curr_date' ";
                $res = mysqli_query($conn, $qry);

                if (!$res) {
                    errlog(mysqli_error($conn), $qry);
                }

                $response = mysqli_fetch_assoc($res);

                $d = 0;
                if (isset($response['id'])) {
                    $d = (float)realEscape($response['discount']);
                    if ($response['type'] == '%') {
                        $d = ($d * $item_det['price']) / 100;
                    }
                }

                $total_coupon_discount += (float)($d);
            }
        }
    }





    $payment_mode = $_SESSION['payment_mode'];

    $amount = ($total_price + $total_shipping_price) - ($total_coupon_discount + $total_discount);

    $available_ewallet = available_ewallet($vid);
    $available_ebanking = total_n_available_ebanking($vid)['available'];

    if ($available_ewallet < $use_from_ewallet) {
        $use_from_ewallet = $available_ewallet;
    }

    if ($available_ebanking < $use_from_ebanking) {
        $use_from_ebanking = $available_ebanking;
    }

    if ($use_from_ebanking + $use_from_ewallet > $amount) {
        if ($use_from_ebanking > $amount) {
            $use_from_ebanking = $amount;
            $amount = 0;
            $use_from_ewallet = 0;
        } else {
            $amount -= $use_from_ebanking;
        }

        if ($use_from_ewallet > $amount) {
            $use_from_ewallet = $amount;
            $amount = 0;
            $use_from_ebanking = 0;
        } else {
            $amount -= $use_from_ewallet;
        }
    } else {
        if ($use_from_ebanking > $amount) {
            $use_from_ebanking = $amount;
            $amount = 0;
            $use_from_ewallet = 0;
        } else {
            $amount -= $use_from_ebanking;
        }

        if ($use_from_ewallet > $amount) {
            $use_from_ewallet = $amount;
            $amount = 0;
            $use_from_ebanking = 0;
        } else {
            $amount -= $use_from_ewallet;
        }
    }

    $coups_used = isset($_SESSION['APPLIED_COUPON']) ? $_SESSION['APPLIED_COUPON']['coupon_code'] : "";

    $qry = "INSERT INTO `orders`(`site_id`, `item_type`, `item_id`, `vendor_id`, `quantity`, `variant`, `amount`, `coupon_id`, `coupon_discount`, `item_discount`, `payment_status`, `payment_mode`, `address`, `order_status`, `refer_by`, `referral_id`, `order_date`, `updated_date`, `paid_from_ewallet`, `paid_from_ebanking`) VALUES ('$this_site_id', '$item_types', '$item_ids', '$vid', '$quantities', '$variants', '$amount', '$coups_used', '$total_coupon_discount', '$total_discount', 'PENDING', '$payment_mode', '$address_id', 'PENDING', '', '', '$curr_date', '$curr_date', '$use_from_ewallet', '$use_from_ebanking')";

    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
        die();
    }

    $insID = mysqli_insert_id($conn);
    $vid = getVendorID();

    $affiliate_data = array();
    if (isset($_SESSION['affiliated_items']))
        $affiliate_data = ($_SESSION["affiliated_items"]);

    for ($i = 0; $i < count($item_array); $i++) {
        $aff_id = '';
        if ($marketplace_array[$i] == 5) {
            if (isset($affiliate_data[$marketplace_array[$i]][$item_array[$i]][$variant_array[$i]])) {
                $aff_id = realEscape(urldecode(base64_decode($affiliate_data[$marketplace_array[$i]][$item_array[$i]][$variant_array[$i]])));
            }
        } else {
            if (isset($affiliate_data[$marketplace_array[$i]][$item_array[$i]])) {
                $aff_id = realEscape(urldecode(base64_decode($affiliate_data[$marketplace_array[$i]][$item_array[$i]])));
            }
        }

        $qry = "INSERT INTO `order_details`(`site_id`, `order_id`, `marketplace_id`, `item_id`, `quantity`, `price`, `discount`, `order_date`, `variant_id`, `add_on`, vendor_id, affiliate_code) VALUES ('$this_site_id', '$insID', '" . realEscape($marketplace_array[$i]) . "', '" . realEscape($item_array[$i]) . "',  '" . realEscape($quantity_array[$i]) . "', '" . realEscape($price_array[$i]) . "', '" . realEscape($discount_array[$i]) . "', '$curr_date', '" . realEscape($variant_array[$i]) . "', '" . realEscape($add_array[$i]) . "', $vid, '$aff_id')";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }
    }

    if ($payment_mode == 'COD') {
        $_SESSION['recent_order_id'] = $insID;
        if (isset($_SESSION['user_id'])) {
            $vid = $_SESSION['user_id'];
        }

        if (isset($_SESSION['vendor_id'])) {
            $vid = $_SESSION['vendor_id'];
        }

        $qry = "UPDATE cart_n_wishlist set save_status = 0 where save_type = 'CART' AND vendor_id = '" . $vid . "' ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }
        die(json_encode(array("cod" => true)));
    }

    if ($amount <= 0) {
        deduct_from_ebanking($use_from_ebanking, $vid, 'Used to buy items');
        deduct_from_ewallet($use_from_ewallet, $vid, 'Used to buy items');

        $total = $use_from_ebanking + $use_from_ewallet;
        $a = "SELECT vendor.id FROM admin INNER JOIN vendor ON admin.vendor_id = vendor.id WHERE admin.site_id = '$this_site_id' ";
        $a = mysqli_query($conn, $a);
        $a = mysqli_fetch_assoc($a);
        if ($total > 0)
            credit_ebanking($a['id'], $total, $order_id, "Item(s) Sold");

        $qry = "UPDATE orders set payment_status = 'PAID' where id = '$insID' ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }
        $_SESSION['recent_order_id'] = $insID;
        die(json_encode(array("wallet" => true)));
    }

    if (isset($_SESSION['admin_id'])) {
        setcookie("is_admin", "yes", time() + 60 * 60, '/');
    }

    $amount = round($amount, 2) * 100;

    $_SESSION['order_in_progress'] = $insID;
    $_SESSION['amount_to_be_paid'] = $amount;

    $orderData = [
        'receipt'         => 'rcptid_11',
        'amount'          => $amount,  // in paise
        'currency'        => 'INR'
    ];

    $razorpayOrder = $api->order->create($orderData);
    $newArray = array();
    foreach ($razorpayOrder as $key => $value) {
        if (is_object($key)  ||  is_object($value))   continue;
        $newArray[$key] = $value;
    }

    echo json_encode($newArray);
} else if (isset($_POST['verifyItemPayment'])  &&  isset($_SESSION['order_in_progress'])) {
    // ! uncomment in live mode


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

    $order_id = $_SESSION['order_in_progress'];

    $affiliate_data = array();

    if (isset($_COOKIE['affiliated_items'])) {
        $affiliate_data = unserialize($_COOKIE['affiliated_items']);
    }

    $_SESSION['recent_order_id'] = $order_id;

    $qry = "SELECT order_details.marketplace_id, order_details.item_id, order_details.variant_id, (product_margin.margin * order_details.quantity) as margin_given, order_details.price, order_details.affiliate_code FROM order_details INNER JOIN product_margin ON product_margin.product_id = order_details.item_id WHERE order_details.marketplace_id = product_margin.marketplace_id AND product_margin.user_type = 31 AND order_details.order_id = '$order_id' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);

    foreach ($data as $datum) {
        $price = $datum['price'] - $datum['margin_given'];

        if ($datum['margin_given'] > 0) {
            $aff_id = $datum['affiliate_code'];

            $qry = "SELECT * FROM vendor WHERE affiliate_code = '$aff_id' AND site_id = $this_site_id AND status = 1 AND verified = 1 ";
            $res = mysqli_query($conn, $qry);
            $aff_data = mysqli_fetch_assoc($res);

            if (isset($aff_data['id'])) {
                credit_ebanking($aff_data['id'], $datum['margin_given'], $order_id, 'Item sold using your referal link');
                sendMailTo($aff_data['email'], "E-Banking", "Received margin of &#8377; " . $datum['margin_given']) ;
            }

            switch ($datum['marketplace_id']) {
                case 5:
                case 6:
                case 7:
                    $qry = "SELECT marketplace_products.vendor_id, product_variants.price FROM marketplace_products INNER JOIN product_variants ON product_variants.product_id = marketplace_products.id WHERE marketplace_products.id = '" . $datum['item_id'] . "' ";
                    $r = mysqli_query($conn, $qry);
                    if (!$r) {
                        errlog(mysqli_error($conn), $qry);
                    }

                    $r = mysqli_fetch_assoc($r);
                    credit_ebanking($r['vendor_id'], $price, $order_id, "Product sold.");
                    break;
                case 16:
                    $qry = "SELECT * FROM marketplace_services  WHERE id = '" . $datum['item_id'] . "' ";
                    $r = mysqli_query($conn, $qry);
                    if (!$r) {
                        errlog(mysqli_error($conn), $qry);
                    }

                    $r = mysqli_fetch_assoc($r);
                    credit_ebanking($r['vendor_id'], $price, $order_id, "Product sold.");

                    break;
            }
        }
    }

    $qry = "SELECT * from orders where id = '$order_id' ";
    $res = mysqli_fetch_assoc(mysqli_query($conn, $qry));

    $vendor_id = $res['vendor_id'];

    deduct_from_ewallet($res['paid_from_ewallet'], $res['vendor_id'], 'Used to buy items');
    deduct_from_ebanking($res['paid_from_ebanking'], $res['vendor_id'], 'Used to buy items');

    $total = $res['paid_from_ewallet'] + $res['paid_from_ebanking'] + $res['amount'];

    $a = "SELECT vendor.id FROM admin INNER JOIN vendor ON admin.vendor_id = vendor.id WHERE admin.site_id = '$this_site_id' ";
    $a = mysqli_query($conn, $a);
    $a = mysqli_fetch_assoc($a);
    if ($total > 0)
        credit_ebanking($a['id'], $total, $order_id, "Item Sold");

    $item_array = explode(',', $res['item_id']);
    $type_array = explode(',', $res['item_type']);
    $qty_array = explode(',', $res['quantity']);
    $variant_array = explode(',', $res['variant']);

    $affiliate_data = array();
    if (isset($_COOKIE['affiliated_items'])) {
        $affiliate_data = unserialize($_COOKIE['affiliated_items']);
    }

    $qry = "UPDATE orders set payment_status = 'PAID' where id = '$order_id' ";
    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
    }

    $qry = "SELECT * from vendor where id = '" . $vendor_id . "' ";
    $res = mysqli_fetch_assoc(mysqli_query($conn, $qry));

    if (array_search('500', explode(",", $res['vendor_type'])) !== false) {
        $_SESSION['user_id'] = $res['id'];
    } else {
        $_SESSION['vendor_id'] = $res['id'];


        if (isset($_COOKIE['is_admin'])  &&  $_COOKIE['is_admin'] == 'yes') {
            setcookie("is_admin", "yes", time() - 1, '/');
            $qry = "SELECT * from admin where vendor_id = '" . $_SESSION['vendor_id'] . "' ";
            $res = mysqli_query($conn, $qry);
            if (!$res) {
                errlog(mysqli_error($conn), $qry);
            }
            $data = mysqli_fetch_assoc($res);
            if (isset($data['id'])) {
                $_SESSION['admin_id'] = $data['id'];
            }
        }
    }

    $qry = "UPDATE cart_n_wishlist set save_status = 0 where save_type = 'CART' AND vendor_id = '" . $vendor_id . "' ";
    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
    }

    echo 1;
}
