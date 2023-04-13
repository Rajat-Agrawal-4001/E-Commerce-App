<?php
session_start();
if (!isset($_SESSION['vendor_id'])  &&  !isset($_SESSION['user_id'])) {
    die(json_encode(array("error" => "Unknown User")));
}
require_once "../config/connection.php";
require_once("razorpay-php/config.php");
require_once("razorpay-php/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api(RAZORPAY_KEY, RAZORPAY_SECRET);

require_once "../vendor/payment_processor.php";
require_once("../config/generalMailer.php");

if (!isset($_SESSION['vendor_id'])) {
    die(json_encode(array("error" => "Login as vendor and try again")));
}

$vendor_id = getVendorID();

if (isset($_POST['purchaseCurrentModule'])) {

    $module_id = (int)realEscape($_SESSION['purchaseCurrentModule']);
    $use_from_ebanking = (float)realEscape($_POST['ebanking']);
    $use_from_ewallet = (float)realEscape($_POST['ewallet']);

    $coups_used = isset($_SESSION['USING_COUPON']) ? $_SESSION['USING_COUPON'] : "";

    $qry = "SELECT * FROM integration_modules WHERE id = '$module_id' ";
    $rs = mysqli_query($conn, $qry);
    if (!$rs) {
        errlog(mysqli_error($conn), $qry);
    }

    $data = mysqli_fetch_assoc($rs);
    if (!isset($data['id'])) {
        die(json_encode(array("error" => "Invalid Module ID")));
    }

    $amount = (float)($data['price']);
    $_SESSION['validity'] = $validity = (int)($data['validity']);
    $_SESSION['marketplace_id'] = $marketplace_id = $data['marketplace_id'];

    $_SESSION['module_dets'] = $data;

    $discount = $coupon_discount = 0;
    if ($data['discount'] > 0) {
        $data['discount'] = (float)$data['discount'];
        if ($data['discount_type'] == '%') {
            $discount = ($amount * $data['discount'] / 100);
        } else {
            $discount = $data['discount'];
        }

        $amount -= $discount;
    }

    $coupon_id = -1;
    if (trim($coups_used) != '') {
        $coup_det = checkCoupon($coups_used, 'MODULE');
        if (isset($coup_det['id'])) {
            $coupon_id = $coup_det['id'];

            if ($data['discount_type'] == '%') {
                $coupon_discount = ($price * $data['discount']) / 100;
            } else {
                $coupon_discount = $data['discount'];
            }
            $amount -= $coupon_discount;
        }
    }

    $_SESSION['split'] = $split = splitPayment($amount, $use_from_ebanking, $use_from_ewallet);
    $amount = $split['REMAINING'];

    $qry = "INSERT INTO `orders`(`site_id`, `item_type`, `item_id`, `validity`, `vendor_id`, `quantity`, `amount`, `paid_from_ewallet`, `paid_from_ebanking`, `item_discount`, `coupon_id`, `coupon_discount`, `payment_status`, `payment_mode`, `order_status`, `order_date`, `updated_date`) VALUES ('$this_site_id', 'MODULE', '$module_id', '$validity', '$vendor_id', '1', '$amount', '" . $split['EWALLET'] . "', '" . $split['EBANKING'] . "', '$discount', '$coupon_id', '$coupon_discount', 'PENDING', 'RAZOR-PAY', 'PENDING', '$curr_date', '$curr_date') ";

    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
    }

    $order_id = mysqli_insert_id($conn);
    if ($amount == 0) {
        deduct_from_ewallet($use_from_ewallet, getVendorID(), "Purchased a Module");
        deduct_from_ebanking($use_from_ewallet, getVendorID(), "Purchased a Module");
        $qry = "UPDATE orders SET payment_status = 'PAID', order_status = 'COMPLETED', payment_mode = 'EWALLET' WHERE id = '$order_id' ";

        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        } else {
            $permissions['UPDATE'] = 1;
            $permissions['MANAGER'] = 1;
            $permissions['DELETE'] = 1;
            $permissions['INSERT'] = 1;
            $permissions['VIEW'] = 1;
            $qry = "INSERT INTO `purchased_packages`(`site_id`, `vendor_id`, `order_id`, `package_type`, `package_description`, `package_title`, `no_of_posts`, `no_of_profile`, `response_per_post`, `access_to_response`, `filter`, `downloadable`, `validity`, `package_image`, `created_date`) VALUES ($this_site_id, $vendor_id, $order_id, $marketplace_id, 'This is your trial package', 'Trial package', 5, 5, 5, 5, '', 1, '$validity', '', '$curr_date')";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }

            if (addPermission($marketplace_id, $permissions, $validity, $order_id)) {
                die(json_encode(array("wallet" => true)));
            }
        }
        die(json_encode(array("error" => "Internal Server Error")));
    }

    $amount = round($amount, 2);

    $_SESSION['module_purchase_in_progress'] = $order_id;
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
} else if (isset($_POST['verifyModulePurchase'])  &&  isset($_SESSION['module_purchase_in_progress'])) {

    $order_id = $_SESSION['module_purchase_in_progress'];
    $success = true;

    // ! uncomment in live mode
    // $id = $_POST['payment_status']['razorpay_payment_id'];
    // $order_id = $_POST['payment_status']['razorpay_order_id'];
    // $sign = $_POST['payment_status']['razorpay_signature'];


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

    if ($success === true) {
        $validity = $_SESSION['validity'];
        $marketplace_id = $_SESSION['marketplace_id'];

        $module_det = $_SESSION['module_dets'];
        $vendor_det = getVendorInfo();

        sendMailTo($vendor_det['email'], "Purchased a module", '<h6>You have purchased \'' . $module_det['title'] . '\' module.</h6>');
        deduct_from_ewallet($_SESSION['split']['EWALLET'], getVendorID(), "Purchased a Module");
        deduct_from_ebanking($_SESSION['split']['EBANKING'], getVendorID(), "Purchased a Module");
        $qry = "UPDATE orders SET payment_status = 'PAID', order_status = 'COMPLETED' WHERE id = '$order_id' ";

        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        } else {
            $permissions['UPDATE'] = 1;
            $permissions['MANAGER'] = 1;
            $permissions['DELETE'] = 1;
            $permissions['INSERT'] = 1;
            $permissions['VIEW'] = 1;
            $qry = "INSERT INTO `purchased_packages`(`site_id`, `vendor_id`, `order_id`, `package_type`, `package_description`, `package_title`, `no_of_posts`, `no_of_profile`, `response_per_post`, `access_to_response`, `filter`, `downloadable`, `validity`, `package_image`, `created_date`) VALUES ($this_site_id, $vendor_id, $order_id, $marketplace_id, 'This is your trial package', 'Trial package', 5, 5, 5, 5, '', 1, '$validity', '', '$curr_date')";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }

            if (addPermission($marketplace_id, $permissions, $validity, $order_id)) {
                echo 1;
                die;
            }
        }
        die(json_encode(array("error" => "Internal Server Error")));
    } else {
        die(json_encode(array("error" => $html)));
    }
}
