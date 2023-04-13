<?php
session_start();
require_once "../config/connection.php";
require_once("razorpay-php/config.php");
require_once("razorpay-php/Razorpay.php");
require_once "../vendor/membership_n_package_processor.php";

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api(RAZORPAY_KEY, RAZORPAY_SECRET);

if (getVendorID() == -1) {
    die("Session Expired");
}

function getDomain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}

function getDefaultDomain()
{
    global $conn, $this_site_url;
    $vendor_id = getVendorID();
    $qry = "SELECT * FROM vendor WHERE id = $vendor_id ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_assoc($res);

    $domain_name = urlencode(strtolower(stringShortner($data['name'], 30)));

    $new_domain = '';
    for ($i = 0; $i < strlen($domain_name); $i++) {
        if (!preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name[$i])) {
            continue;
        }

        $new_domain .= $domain_name[$i];
    }

    $new_domain  .= "-" . $data['affiliate_code'] . "t" . time() . "." . getDomain($this_site_url);

    return $new_domain;
}

if (isset($_POST['make_payment'])) {

    $_SESSION['domain1'] = getDefaultDomain();

    $id = realEscape((($_POST['make_payment'])));

    $amount = 0;


    $qry = "SELECT * FROM marketplace_digital_products WHERE id = '$id' AND status = 1 AND site_id = $this_site_id ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }
    $data = mysqli_fetch_assoc($res);

    if (!isset($data['id'])) {
        die(json_encode(array("ERROR" => "Invalid ID 2")));
    }

    $amount += (float)$data['price'];


    $amount = round($amount, 2) * 100;

    $_SESSION['template_in_progress'] = $id;
    $_SESSION['initiative_in_progress'] = isset($_POST['initiative_id']) ? (int)($_POST['initiative_id']) : -1;
    
    $vid = getVendorID();
    $mkt = (int)$data['marketplace_id'];

    $memberships = membership_finder() ;
    $validity = -1;

    foreach ($memberships['FREE_WEBSITE'] as $key => $member) {
        if (!isset($member['WEBSITE'])) continue;

        if ($member['SPECIFIC'] == 'NO'  ||  array_search($mkt, $member['ALLOWED_MARKETPLACE']) !== false) {
            $mem_id = $memberships['BASIC'][$key]['id'];
            $validity = $member['VALIDITY'] ;

            $qry = "UPDATE membership SET number_of_websites = number_of_websites - 1 WHERE id = '$mem_id' " ;
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            } else {
                $qry = "INSERT INTO `orders`(`site_id`, `item_type`, `item_id`, `validity`, `vendor_id`, `affiliate_code`, `quantity`, `variant`, `variant_value`, `amount`, `paid_from_ewallet`, `paid_from_ebanking`, `item_discount`, `coupon_id`, `coupon_discount`, `payment_status`, `payment_mode`, `order_status`, `order_date`, `updated_date`) VALUES ($this_site_id, '27', '$id', '$validity', '$vid', '', 1, 'MEMBERSHIP_ID', '$mem_id', '0', 0, 0, '$amount', '', 0, 'PAID', 'MEMBERSHIP', 'COMPLETED', '$curr_date', '$curr_date')" ;
                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                }
            }
            
            $amount = 0;
            break;
        }
    }


    if ($amount == 0) {

        $template_price = (float)realEscape($data['price']);
        $template_id = $data['id'];
        $marketplace_id = (int)$data['marketplace_id'];

        $initiative_id = $_SESSION['initiative_in_progress'];




        $qry = "INSERT INTO `site_orders`(`site_id`, `vendor_id`, `initiative_id`, `marketplace_ids`, `template_ids`, `domain1`, `domain2`, `package_used`, `commission_type`, `commission_amount`, `discount_received`, `total_paid`, `request_type`, `status`, `created_date`, validity) VALUES ('$this_site_id', '$vid', '$initiative_id', '" . realEscape($marketplace_id) . "', '" . realEscape($template_id) . "', '" . realEscape($_SESSION['domain1']) . "', '', 0, '%', 50, 0, '" . ($template_price) . "', 'INSTALL', 0, '$curr_date', '$validity' )";

        if (!mysqli_query($conn, $qry)) {
            echo '0';
            errlog(mysqli_error($conn), $qry);
        } else {
            $order_id = mysqli_insert_id($conn);
            $permissions['UPDATE'] = 1;
            $permissions['MANAGER'] = 1;
            $permissions['DELETE'] = 1;
            $permissions['INSERT'] = 1;
            $permissions['VIEW'] = 1;

            addPermission(25, $permissions, -1, $order_id);
            die(json_encode(array("wallet" => true)));
        }
        die(json_encode(array("error" => true)));
    }

    // $_SESSION['initiative_in_progress'] = $ins;


    $orderData = [
        'receipt'         => 'rcptid_11',
        'amount'          => $amount,  // in paise
        'currency'        => 'INR'
    ];

    $razorpayOrder = $api->order->create($orderData);
    // $_SESSION['LOG'] = $razorpayOrder ;
    $newArray = array();
    foreach ($razorpayOrder as $key => $value) {
        if (is_object($key)  ||  is_object($value))   continue;
        $newArray[$key] = $value;
    }

    echo json_encode($newArray);
} else if (isset($_POST['payment_status'])  &&  isset($_SESSION['template_in_progress'])) {


    // ! uncomment in live mode


    // $id = $_POST['payment_status']['razorpay_payment_id'];
    // $order_id = $_POST['payment_status']['razorpay_order_id'] ;
    // $sign = $_POST['payment_status']['razorpay_signature'] ;

    // $success = true;

    // $error = "Payment Failed";

    // if (empty($_POST['razorpay_payment_id']) === false) {
    //     $api = new Api(RAZORPAY_KEY, RAZORPAY_SECRET);

    //     try {
    //         // Please note that the razorpay order ID must
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

    $id = $_SESSION['template_in_progress'];

    $qry = "SELECT * FROM marketplace_digital_products WHERE id = '$id' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }
    $data = mysqli_fetch_assoc($res);
    $template_price = (float)realEscape($data['price']);
    $template_id = $data['id'];
    $marketplace_id = (int)$data['marketplace_id'];

    $initiative_id = $_SESSION['initiative_in_progress'];


    $vid = getVendorID();

    $qry = "INSERT INTO `site_orders`(`site_id`, `vendor_id`, `initiative_id`, `marketplace_ids`, `template_ids`, `domain1`, `domain2`, `package_used`, `commission_type`, `commission_amount`, `discount_received`, `total_paid`, `request_type`, `status`, `created_date`) VALUES ('$this_site_id', '$vid', '$initiative_id', '" . realEscape($marketplace_id) . "', '" . realEscape($template_id) . "', '" . realEscape($_SESSION['domain1']) . "', '', 0, '%', 50, 0, '" . ($template_price) . "', 'INSTALL', 0, '$curr_date' )";

    if (!mysqli_query($conn, $qry)) {
        echo '0';
        errlog(mysqli_error($conn), $qry);
    } else {
        $order_id = mysqli_insert_id($conn);
        $permissions['UPDATE'] = 1;
        $permissions['MANAGER'] = 1;
        $permissions['DELETE'] = 1;
        $permissions['INSERT'] = 1;
        $permissions['VIEW'] = 1;

        addPermission(25, $permissions, -1, $order_id);
        echo '1';
    }
}
