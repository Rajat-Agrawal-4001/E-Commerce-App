<?php
session_start();

require_once "../config/connection.php";
require_once "../vendor/payment_processor.php";
require_once("razorpay-php/config.php");
require_once("razorpay-php/Razorpay.php");

if (getVendorID() == -1) {
    die(json_encode(array("ERROR" => "UNKNOWN USER")));
}

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api(RAZORPAY_KEY, RAZORPAY_SECRET);

if (isset($_POST['addTo']) && isset($_POST['addTo'])  && isset($_POST['amount'])  && isset($_POST['description'])) {

    $addTo = realEscape($_POST['addTo']);
    $amount = realEscape($_POST['amount']);
    $description = realEscape($_POST['description']);
    $vid = $_SESSION['vendor_id'];

    $qry = "INSERT INTO wallet_transactions (vendor_id, transact_from, nature, date, status, amount, description, site_id) VALUES ('$vid', '$addTo', 'CREDIT', '$curr_date', 'PENDING', '$amount', '$description', '$this_site_id') ";
    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
    }

    $insID = mysqli_insert_id($conn);

    $_SESSION['CURRENT_TRANSACTION_ID'] = $insID;  // can be used as order id in production
    $_SESSION['TXNAMOUNT'] = $amount;

    if (isset($_POST['self'])) {
        setcookie("generated_from", "admin_dashboard", time() + 60 * 60, "/");
    }

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
} else if (isset($_POST['verifyWalletAddMoney'])  &&  isset($_SESSION['CURRENT_TRANSACTION_ID'])) {

    $order_id = $_SESSION['CURRENT_TRANSACTION_ID'];
    $amount = $_SESSION['TXNAMOUNT'];

    unset($_SESSION['CURRENT_TRANSACTION_ID']);
    unset($_SESSION['TXNAMOUNT']);

    $qry = "SELECT * from wallet_transactions where id = '$order_id' ";
    $res = mysqli_fetch_assoc(mysqli_query($conn, $qry));

    if ($res['transact_from'] == 'ewallet') {
        $qry = "INSERT INTO ewallet (vendor_id, cashback, validity) VALUES ('" . $res['vendor_id'] . "', '$amount', '36500') ";
        mysqli_query($conn, $qry);
    }

    $qry = "UPDATE wallet_transactions set amount = '$amount', status = 'COMPLETED', date = '$curr_date' where id = '$order_id' ";
    if (mysqli_query($conn, $qry)) {
        echo 1;
    } else {
        errlog(mysqli_error($conn), $qry);
        echo 0;
    }
}