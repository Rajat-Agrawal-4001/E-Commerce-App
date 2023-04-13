<?php
session_start();
if (!isset($_SESSION['vendor_id'])  &&  !isset($_SESSION['user_id'])  &&  !isset($_SESSION['temp_vendor_id'])) {
    die(json_encode(array("error" => "Unknown User")));
}
require_once "../config/connection.php";
require_once("razorpay-php/config.php");
require_once("razorpay-php/Razorpay.php");
require_once "../vendor/payment_processor.php";
require_once("../config/generalMailer.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api(RAZORPAY_KEY, RAZORPAY_SECRET);

$vid = (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID();
if ($vid == -1) {
    die(json_encode(array("error" => "Invalid Session.<br>Please refresh your page and try again.")));
}


function sendInvoice(array $invoice)
{
    global $conn, $this_site_id;
    $qry = "SELECT * FROM site_details WHERE id = '$this_site_id' ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_assoc($res);
    $site_title = '';
    if (isset($data['id'])) {
        $site_title = strtoupper($data['site_name']);
    }

    $target = $invoice['target'];
    $title = $invoice['title'];
    $online_payment = $invoice['online_payment'];
    $ewallet = $invoice['ewallet'];
    $ebanking = $invoice['ebanking'];
    $discount = $invoice['discount'];
    $cashback = $invoice['cashback'];
    $image = $invoice['image'];
    $membership_code = $invoice['membership_code'];

    $subject = $body = '';
    if ($membership_code !== false) {
        $subject = "Purchased new Membership";
        $validity = $invoice['validity'];
        $membership_code = strtoupper($membership_code);
        $vendor_name = getVendorInfo((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['name'];
        $new_code = '';
        for ($i = 0; $i < strlen($membership_code); $i++) {
            if ($i % 4 == 0) {
                $new_code .= " ";
            }
            $new_code .= $membership_code[$i];
        }

        $body = '<!DOCTYPE html>
        <html>
          <title>W3.CSS</title>
          <meta name="viewport" content="width=device-width, initial-scale=1" />
          <style>
            /* @import url("https://fonts.googleapis.com/css2?family=Dosis:wght@400;500&display=swap"); */
        
            .credit-card {
              position: relative;
              max-width: 520px;
              min-width: 520px;
              margin: 50px auto;
              min-height: 300px;
              border-radius: 20px;
              display: flex;
              flex-direction: column;
              padding: 24px;
              box-sizing: border-box;
              background: linear-gradient(-240deg, #b30e11, #b30e11, #df0a0a);
              justify-content: space-between;
              font-family: "Dosis", sans-serif;
              overflow: hidden;
            }
        
            .credit-card:after {
              content: "";
              position: absolute;
              height: 100%;
              width: 100%;
              left: 0;
              top: 0;
              z-index: 0;
              color: rgb(249 249 249 / 10%);
              background: linear-gradient(310deg, currentColor 25%, transparent 25%) -100px
                  0,
                linear-gradient(146deg, currentColor 25%, transparent 25%) -100px 0,
                linear-gradient(293deg, currentColor 25%, transparent 25%),
                linear-gradient(244deg, currentColor 25%, transparent 25%);
              background-size: calc(2 * 100px) calc(2 * 100px);
            }
        
            .logo {
              display: flex;
              z-index: 1;
              font-size: 30px;
              color: #ede5e5;
            }
            .logo1 {
              width: 107px;
              display: flex;
              z-index: 1;
              font-size: 1rem;
              color: #ede5e5;
              margin-top: -44px;
              margin-right: -19px;
            }
        
            .name-and-expiry {
              display: flex;
              justify-content: space-between;
              z-index: 1;
              color: #ede5e5;
              font-size: 20px;
              letter-spacing: 3px;
              filter: drop-shadow(1px 0px 1px #555);
              text-transform: uppercase;
            }
        
            .numbers {
              font-size: 36px;
              letter-spacing: 7px;
              text-align: center;
              color: #ede5e5;
              z-index: 1;
            }
            .sideqr {
              height: 1px;
            }
            img.qr {
              height: 91px;
            }
            .val {
              font-size: 14px;
              color: #fff;
            }
          </style>
          <body>
          <div class="credit-card">
                    <h3 class="logo">' . strtoupper($title) . '</h3>
                    <h4 class="logo1">' . $site_title . '</h4>
                    <div class="numbers">' . $new_code . '</div>
                    <div class="name-and-expiry">
                    <span>' . strtoupper($vendor_name) . '</span>
                    <span class="val">' . $validity . ' </span>
                    </div>
                </div>
          </body>
        </html>
        ';
    } else {



        $coupon_discount = 0;
        $coupon_row = '';
        if (isset($invoice['coupon_discount'])  &&  ($invoice['coupon_discount']) > 0  &&  isset($invoice['coupon_code'])) {
            $coupon_discount = $invoice['coupon_discount'];
            $coupon_row = '<tr>
                            <th>
                                Coupon Used
                            </th>
                            <td>
                                ' . $invoice['coupon_code'] . '
                            </td>
                        </tr>';

            $coupon_row .= '<tr>
                            <th>
                                Coupon Discount
                            </th>
                            <td>
                                ' . $invoice['coupon_discount'] . '
                            </td>
                        </tr>';
        }

        $subject = "Purchased a ";
        $membership_row = '';

        if ($cashback > 0) {
            $cashback = '
        <hr>
        <div style="margin: 1rem; color: white; background-color: green;">
            Received a cashback of &#8377; ' . $cashback . '.
        </div>
        ';
        } else {
            $cashback = '';
        }

        if ($membership_code !== false) {
            $subject .= " Membership";
            $membership_row = '
        <tr>
            <th>
                Membership Code
            </th>
            <td>
                ' . $membership_code . '
            </td>
        </tr>
        ';
        } else {
            $subject .= " Package";
        }

        $body = '
    <table border="1">
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Value
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    Title
                </th>
                <td>
                    ' . $title . '
                </td>
            </tr>
            ' . $membership_row . '
            <tr>
                <th>
                    Image
                </th>
                <td>
                    <img style="max-height: 5rem; max-width: 5rem;" src="' . $image . '" />
                </td>
            </tr>
            <tr>
                <th>
                    Total Cost
                </th>
                <td>
                    &#8377;' . round($online_payment + $ewallet + $ebanking + $discount + $coupon_discount, 2) . '
                </td>
            </tr>
            <tr>
                <th>
                    Paid Online
                </th>
                <td>
                &#8377;' . $online_payment . '
                </td>
            </tr>
            <tr>
                <th>
                    Paid From Ewallet
                </th>
                <td>
                &#8377;' . $ewallet . '
                </td>
            </tr>
            <tr>
                <th>
                    Paid From E-Banking
                </th>
                <td>
                &#8377;' . $ebanking . '
                </td>
            </tr>
            <tr>
                <th>
                    Discount Received
                </th>
                <td>
                &#8377;' . $discount . '
                </td>
            </tr>
            ' . $coupon_row . '
            <tr>
                <th>
                    Total Paid
                </th>
                <td>
                &#8377;' . round($online_payment + $ewallet + $ebanking, 2) . '
                </td>
            </tr>
        </tbody>
    </table>
    ' . $cashback . '
    ';
    }


    return sendMailTo($target, $subject, $body);
}


if (isset($_POST['buyPackage'])) {
    if (isset($_SESSION['buyMembership'])  ||  isset($_SESSION['buyPackage'])) {
        $amount = 0;
        // ! PACKAGE PAYMENT CALCULATION
        if (isset($_SESSION['buyPackage'])) {
            $qry = "SELECT * from vendor_packages where id = '" . realEscape($_SESSION['buyPackage']) . "' AND status = 1 AND verified = 1 ";
            $res = mysqli_query($conn, $qry);
            if (!$res) {
                errlog(mysqli_error($conn), $qry);
                die;
            }
            $data = mysqli_fetch_assoc($res);
            if (!isset($data['id'])) {
                die("Invalid Request");
            }


            $amount = (float)$data['package_price'];

            $discount = (float)$data['discount'] * $amount / 100;
            $amount -= $discount;

            $purchased = false;

            $deduct_from_ewallet = $deduct_from_ebanking = 0;

            if (isset($_POST['payFromEwallet'])  &&  ((float)($_POST['payFromEwallet'])) > 0) {
                $requested = ((float)($_POST['payFromEwallet']));
                if (available_ewallet((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID()) >= $requested) {
                    if ($amount >= $requested) {
                        $deduct_from_ewallet = $requested;
                    } else {
                        if (deduct_from_ewallet($amount, (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID(), "Purchased a package") == round($amount, 2)) {
                            $deduct_from_ewallet = $amount;
                            $purchased = true;
                        }
                    }
                } else {
                    $deduct_from_ewallet = available_ewallet((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID());
                }
            }


            if (isset($_POST['payFromEbanking'])  &&  ((float)($_POST['payFromEbanking'])) > 0) {
                $requested = ((float)($_POST['payFromEbanking']));
                if (total_n_available_ebanking((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['available'] >= $requested) {
                    if ($amount >= $requested) {
                        $deduct_from_ebanking = $requested;
                    } else {
                        if (deduct_from_ebanking($amount, (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID(), "Purchased a package") == round($amount, 2)) {
                            $deduct_from_ebanking = $amount;
                            $purchased = true;
                        }
                    }
                } else {
                    $deduct_from_ebanking = total_n_available_ebanking((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['available'];
                }
            }

            if (!$purchased) {
                $amount_left = $amount;

                if ($amount_left < $deduct_from_ewallet) {
                    $deduct_from_ewallet = $amount_left;
                }

                $amount_left -= deduct_from_ewallet($deduct_from_ewallet, (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID(), "Purchased a package");

                if ($amount_left < $deduct_from_ebanking) {
                    $deduct_from_ebanking = $amount_left;
                }

                if ($amount_left > 0) {
                    $amount_left -= deduct_from_ebanking($deduct_from_ebanking, (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID(), "Purchased a package");
                }

                if ($amount_left == 0) {
                    $purchased = true;
                }
            }


            if ($purchased == true) {
                $item_id = $_SESSION['buyPackage'];
                $qry = "SELECT * from vendor_packages where id = '$item_id' ";
                $res = mysqli_fetch_assoc(mysqli_query($conn, $qry));

                if ($res['cashback'] > 0) {
                    credit_ewallet((float)$res['cashback'], 'Cashback Received', (int)$res['cashback_validity']);
                }

                $marketplace_id = realEscape($res['package_type']);

                $amount = 0;

                $invoice = array();

                $invoice['target'] = getVendorInfo((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['email'];
                $invoice['ewallet'] = $deduct_from_ewallet;
                $invoice['ebanking'] = $deduct_from_ebanking;
                $invoice['membership_code'] = false;
                $invoice['title'] = $res['package_title'];
                $invoice['image'] = $res['package_image'];
                $invoice['cashback'] = $res['cashback'];
                $invoice['online_payment'] = $amount;
                $invoice['discount'] = $discount;


                $qry = "INSERT INTO `orders`(`site_id`, `item_type`, `item_id`, `vendor_id`, `quantity`, `amount`, `item_discount`, `payment_status`, `payment_mode`,`order_status`, `order_date`, `updated_date`, `paid_from_ebanking`, `paid_from_ewallet`) VALUES ('$this_site_id', 'PACKAGE', '$item_id', '$vid', '1', '$amount', '$discount', 'PAID', 'EWALLET', 'COMPLETED', '$curr_date', '$curr_date', '$deduct_from_ebanking', '$deduct_from_ewallet')";

                $insID = -1;

                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                    die;
                }
                $order_id = $insID = mysqli_insert_id($conn);

                $type = 'U';
                if (isset($_SESSION['vendor_id'])) {
                    $type = 'V';
                }

                if (isset($_SESSION['admin_id'])) {
                    $type = 'A';
                }

                $membership_code = "PID" . $item_id . $type . $vid . "RD" . $order_id;

                $qry = "INSERT INTO `purchased_packages`(transaction_charge, `site_id`, `package_type`, `package_description`, `package_title`, `no_of_posts`, `response_per_post`, `access_to_response`, `filter`, `downloadable`, `validity`, `created_date`, `no_of_profile`, `order_id`, `vendor_id`, package_image) SELECT transaction_charge, `site_id`, `package_type`, `package_description`, `package_title`, `no_of_posts`, `response_per_post`, `access_to_response`, `filter`, `downloadable`, `validity`, `created_date`, `no_of_profile`, $order_id, $vid, `package_image` FROM vendor_packages WHERE id = $item_id ";


                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                } else {
                    $i = mysqli_insert_id($conn);
                    $qry = "UPDATE purchased_packages SET created_date = '$curr_date' WHERE id = $i ";
                    if (!mysqli_query($conn, $qry)) {
                        errlog(mysqli_error($conn), $qry);
                    }

                    $qry = "SELECT * FROM marketplace_list WHERE id = '$marketplace_id' ";
                    $res = mysqli_query($conn, $qry);
                    if (!$res) {
                        errlog(mysqli_error($conn), $qry);
                    }

                    $list = mysqli_fetch_assoc($res);
                    $new_vendor_type = ',' . $list['vendor_types'] . ",";

                    $list = explode(',', $list['vendor_types']);

                    $vendor_types = getVendorType();
                    foreach ($vendor_types as $vt) {
                        if ($vt == '') {
                            continue;
                        }


                        if (array_search($vt, $list) === false) {
                            $new_vendor_type .= $vt . ',';
                        }
                    }
                    $new_vendor_type = realEscape($new_vendor_type);

                    $qry = "UPDATE vendor SET vendor_type = '$new_vendor_type' WHERE id = '$vid' ";
                    $res = mysqli_query($conn, $qry);
                    if (!$res) {
                        errlog(mysqli_error($conn), $qry);
                    }

                    sendInvoice($invoice);

                    die(json_encode(array("wallet" => true)));
                }

                die(json_encode(array("error" => "Payment Failed.<br>Please Contact admin if balance is deducted from your wallet.")));
            }

            $amount -= ($deduct_from_ewallet + $deduct_from_ebanking);

            $amount = round($amount, 2);
            $item_id = realEscape($_SESSION['buyPackage']);

            $qry = "INSERT INTO `orders`(`site_id`, `item_type`, `item_id`, `vendor_id`, `quantity`, `amount`, `item_discount`, `payment_status`, `payment_mode`,`order_status`, `order_date`, `updated_date`, `paid_from_ebanking`, `paid_from_ewallet`) VALUES ('$this_site_id', 'PACKAGE', '$item_id', '$vid', '1', '$amount', '$discount', 'PENDING', 'RAZOR-PAY', 'PENDING', '$curr_date', '$curr_date', '$deduct_from_ebanking', '$deduct_from_ewallet')";

            $insID = -1;

            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
                die;
            }
            $_SESSION['order_in_progress'] = $insID = mysqli_insert_id($conn);
        }

        // ! MEMBERSHIP PAYMENT CALCULATION
        else if (isset($_SESSION['buyMembership'])) {
            $qry = "SELECT * from membership where id = '" . $_SESSION['buyMembership'] . "' ";
            $res = mysqli_query($conn, $qry);
            if (!$res) {
                errlog(mysqli_error($conn), $qry);
                die(json_encode(array("error" => "Invalid Request.<br>Please refresh your page and try again.")));
            }

            $data = mysqli_fetch_assoc($res);
            if (!isset($data['id'])) {
                die(json_encode(array("error" => "Invalid Request.<br>Please refresh your page and try again.")));
            }

            $discount = 0;
            $amount = (float) $data['price'];
            $membership_validity = $data['validity'];

            if ($data['discount_type'] == '%') {
                $discount = $amount * $data['discount_amount'] / 100;
            } else if (strtolower($data['discount_type']) == 'flat') {
                $discount = $data['discount_amount'];
            }
            $discount = round($discount, 2);

            $coupon_discount = 0;
            $coupon_code = '';
            $coupon_id = -1;
            $_SESSION['COUPON_ID'] = -1;
            if (isset($_SESSION['USING_COUPON'])  &&  isset($_SESSION['USING_COUPON_CODE'])) {
                $coupon_data = checkCoupon($_SESSION['USING_COUPON_CODE'], 'MEMBERSHIP');
                if (isset($coupon_data['id'])) {
                    $coupon_id = $_SESSION['COUPON_ID'] = $coupon_data['id'];
                    $coupon_code = $_SESSION['USING_COUPON_CODE'];
                    if ($coupon_data['discount_type'] == '%') {
                        $coupon_discount = $amount * $coupon_data['discount'] / 100;
                    } else {
                        $coupon_discount = $coupon_data['discount'];
                    }
                }
            }

            $coupon_discount = round($coupon_discount, 2);
            $_SESSION['COUPON_DISCOUNT'] = $coupon_discount;
            $_SESSION['COUPON_CODE'] = $coupon_code;
            $amount -= $coupon_discount;
            $amount -= $discount;
            $amount = round($amount, 2);



            $purchased = false;

            $deduct_from_ewallet = $deduct_from_ebanking = 0;

            if (isset($_POST['payFromEwallet'])  &&  ((float)($_POST['payFromEwallet'])) > 0) {
                $requested = ((float)($_POST['payFromEwallet']));
                if (available_ewallet((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID()) >= $requested) {
                    if ($amount >= $requested) {
                        $deduct_from_ewallet = $requested;
                    } else {
                        if (deduct_from_ewallet($amount, (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID(), "Purchased a Membership") == round($amount, 2)) {
                            $deduct_from_ewallet = $amount;
                            $purchased = true;
                        }
                    }
                } else {
                    $deduct_from_ewallet = available_ewallet((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID());
                }
            }


            if (!$purchased && isset($_POST['payFromEbanking'])  &&  ((float)($_POST['payFromEbanking'])) > 0) {
                $requested = ((float)($_POST['payFromEbanking']));
                if (total_n_available_ebanking((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['available'] >= $requested) {
                    if ($amount >= $requested) {
                        $deduct_from_ebanking = $requested;
                    } else {
                        if (deduct_from_ebanking($amount, (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID(), "Purchased a Membership") == round($amount, 2)) {
                            $deduct_from_ebanking = $amount;
                            $purchased = true;
                        }
                    }
                } else {
                    $deduct_from_ebanking = total_n_available_ebanking((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['available'];
                }
            }

            if (!$purchased  &&  ($deduct_from_ewallet + $deduct_from_ebanking) > $amount) {
                $amount_left = $amount;

                if ($amount_left < $deduct_from_ewallet) {
                    $deduct_from_ewallet = $amount_left;
                }

                $amount_left -= deduct_from_ewallet($deduct_from_ewallet, (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID(), "Purchased a Membership");

                if ($amount_left < $deduct_from_ebanking) {
                    $deduct_from_ebanking = $amount_left;
                }

                if ($amount_left > 0) {
                    $amount_left -= deduct_from_ebanking($deduct_from_ebanking, (isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID(), "Purchased a Membership");
                }

                if ($amount_left == 0) {
                    $purchased = true;
                }
            }



            if ($purchased === true) {
                $item_id = $_SESSION['buyMembership'];
                $amount = 0;
                $qry = "SELECT * from membership where id = '$item_id' ";
                $res = mysqli_fetch_assoc(mysqli_query($conn, $qry));
                $membership_validity = $res['validity'];

                $purchased_vendor_type = $res['vendor_type'];

                if ($res['cashback_amount'] > 0) {
                    credit_ewallet((float)$res['cashback_amount'], 'Cashback Received', (int)$res['cashback_validity']);
                }

                $qry = "UPDATE available_coupons SET redeemed = 1 WHERE id = '$coupon_id' ";
                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                }

                $qry = "INSERT INTO `orders`(validity, coupon_id, coupon_discount, `site_id`, `item_type`, `item_id`, `vendor_id`, `quantity`, `amount`, `item_discount`, `payment_status`, `payment_mode`,`order_status`, `order_date`, `updated_date`, `paid_from_ebanking`, `paid_from_ewallet`) VALUES ('" . $res['validity'] . "', '$coupon_id', '$coupon_discount', '$this_site_id', 'MEMBERSHIP', '$item_id', '$vid', '1', '$amount', '$discount', 'PAID', 'EWALLET', 'COMPLETED', '$curr_date', '$curr_date', '$deduct_from_ebanking', '$deduct_from_ewallet')";

                $insID = -1;

                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                    die;
                }
                $order_id = $insID = mysqli_insert_id($conn);

                $type = 'U';
                if (isset($_SESSION['vendor_id'])) {
                    $type = 'V';
                }

                if (isset($_SESSION['admin_id'])) {
                    $type = 'A';
                }

                $membership_code = "M" . $item_id . $type . $vid . "R" . $order_id;


                $invoice = array();

                $invoice['target'] = getVendorInfo((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['email'];
                $invoice['ewallet'] = $deduct_from_ewallet;
                $invoice['ebanking'] = $deduct_from_ebanking;
                $invoice['membership_code'] = $membership_code;
                $invoice['title'] = $res['title'];
                $invoice['image'] = $res['banner'];
                $invoice['cashback'] = $res['cashback_amount'];
                $invoice['online_payment'] = $amount;
                $invoice['coupon_discount'] = $coupon_discount;
                $invoice['coupon_code'] = $coupon_code;
                $invoice['discount'] = $discount;
                if ($membership_validity == '-1') {
                    $invoice['validity'] = 'Validity: Lifetime';
                } else {
                    $invoice['validity'] = 'Valid Till: ' . date("d-m-Y", strtotime($curr_date . "+ " . $membership_validity . " day"));
                }

                $qry = "INSERT INTO `membership`(`site_id`, `vendor_id`, `order_id`, `membership_code`, `title`, `banner`, `price`, `validity`, `cashback_amount`, `cashback_validity`, `discount_type`, `discount_amount`, `number_of_websites`, `website_validity`, `specific_marketplace`, `additional_details`, `featured`, `status`, `save_type`, `last_updated`, `created_date`) SELECT `site_id`, $vid, $order_id, '$membership_code', `title`, `banner`, `price`, `validity`, `cashback_amount`, `cashback_validity`, `discount_type`, `discount_amount`, `number_of_websites`, `website_validity`, `specific_marketplace`, `additional_details`, `featured`, -1, 'BUY', '$curr_date', '$curr_date' FROM membership WHERE id = '" . $res['id'] . "' ";


                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                } else {

                    $_SESSION['RECENT_MEMBERSHIP_ID'] = $new_mem_id = mysqli_insert_id($conn);

                    $qry = "INSERT INTO `membership_details`(`membership_id`, `marketplace_id`, `posts`, `commission_type`, `commission_amount`, `access_validity`, `access_amount`, `created_date`) SELECT $new_mem_id, `marketplace_id`, `posts`, `commission_type`, `commission_amount`, `access_validity`, `access_amount`, '$curr_date' FROM membership_details WHERE membership_id = '" . $res['id'] . "' ";

                    if (!mysqli_query($conn, $qry)) {
                        errlog(mysqli_error($conn), $qry);
                    }


                    $qry = "INSERT INTO `membership_item_selection`(`membership_id`, `item_type`, `item`, `created_date`) SELECT $new_mem_id, `item_type`, `item`, '$curr_date' FROM membership_item_selection WHERE membership_id = '" . $res['id'] . "' AND item_type = 'MARKETPLACE' ";

                    if (!mysqli_query($conn, $qry)) {
                        errlog(mysqli_error($conn), $qry);
                    }

                    $qry = "SELECT * FROM membership_discounts WHERE membership_id = '" . $res['id'] . "' ";
                    $r = mysqli_query($conn, $qry);
                    $mem_dicounts = mysqli_fetch_all($r, MYSQLI_ASSOC);

                    foreach ($mem_dicounts as $row) {
                        $qry = "INSERT INTO `membership_discounts`(`membership_id`, `marketplace_id`, `discount_group`, `discount_type`, `discount_amount`, `created_date`) SELECT $new_mem_id, `marketplace_id`, `discount_group`, `discount_type`, `discount_amount`, '$curr_date' FROM membership_discounts WHERE id = '" . $row['id'] . "' ";
                        if (!mysqli_query($conn, $qry)) {
                            errlog(mysqli_error($conn), $qry);
                        }

                        $discount_id = mysqli_insert_id($conn);

                        $qry = "INSERT INTO `membership_item_selection`(`membership_id`, `membership_discounts_id`, `item_type`, `item`, `variant`, `created_date`) SELECT $new_mem_id, $discount_id, `item_type`, `item`, `variant`, '$curr_date' FROM membership_item_selection WHERE membership_id = '" . $res['id'] . "' AND membership_discounts_id = '" . $row['id'] . "' ";
                        if (!mysqli_query($conn, $qry)) {
                            errlog(mysqli_error($conn), $qry);
                        }
                    }

                    $new_vendor_type = "," . $purchased_vendor_type . ",";
                    $vendor_types = getVendorType((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID());
                    foreach ($vendor_types as $vt) {
                        if ($vt == '') {
                            continue;
                        }


                        if ($vt != $purchased_vendor_type) {
                            $new_vendor_type .= $vt . ',';
                        }
                    }
                    $new_vendor_type = realEscape($new_vendor_type);

                    $qry = "UPDATE vendor SET vendor_type = '$new_vendor_type' WHERE id = '$vid' ";
                    $res = mysqli_query($conn, $qry);
                    if (!$res) {
                        errlog(mysqli_error($conn), $qry);
                    }
                    sendInvoice($invoice);
                    die(json_encode(array("wallet" => true)));
                }

                die(json_encode(array("error" => "Payment Failed.<br>Please Contact admin if balance is deducted from your wallet.")));
            }

            $amount -= ($deduct_from_ewallet + $deduct_from_ebanking);

            $amount = round($amount, 2);

            $item_id = $_SESSION['buyMembership'];

            $qry = "INSERT INTO `orders`(validity, coupon_id, coupon_discount, `site_id`, `item_type`, `item_id`, `vendor_id`, `quantity`, `amount`, `item_discount`, `payment_status`, `payment_mode`,`order_status`, `order_date`, `updated_date`, `paid_from_ebanking`, `paid_from_ewallet`) VALUES ('$membership_validity', '$coupon_id', '$coupon_discount', '$this_site_id', 'MEMBERSHIP', '$item_id', '$vid', '1', '$amount', '$discount', 'PENDING', 'RAZOR-PAY', 'PENDING', '$curr_date', '$curr_date', '$deduct_from_ebanking', '$deduct_from_ewallet')";


            $insID = -1;
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
                die;
            }


            $_SESSION['order_in_progress'] = $insID = mysqli_insert_id($conn);
        }
    } else {
        die(json_encode(array("error" => "Invalid Request.<br>Please refresh your page and try again.")));
    }

    // $insID can be used as receipt id in live

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






    // ! PAYMENT VERIFICATION
} else if (isset($_POST['verifyPackagePayment'])  &&  isset($_SESSION['order_in_progress'])) {

    $result = '';


    // ! uncomment in live mode

    // $_SESSION['payment_log']['post_log'] = $_POST;
    // $id = $_POST['payment_status']['razorpay_payment_id'];
    // $order_id = $_POST['payment_status']['razorpay_order_id'];
    // $sign = $_POST['payment_status']['razorpay_signature'];

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
    // } else {
    //     $_SESSION['payment_log'][] = "Initial Error trigger";
    // }

    // if ($success === true) {
    //     $_SESSION['payment_log'][] = "Success Block Trigger";
    // }

    // $_SESSION['payment_log'][] = "last error";
    // die(json_encode(array("ERROR"=>"Payment Failed")));























    // ! TEST MODE


    $order_id = $_SESSION['order_in_progress'];
    $qry = "SELECT * from orders where id = '$order_id' ";
    $order_det = mysqli_fetch_assoc(mysqli_query($conn, $qry));



    $type = 'U';
    if (isset($_SESSION['vendor_id'])) {
        $type = 'V';
    }

    if (isset($_SESSION['admin_id'])) {
        $type = 'A';
    }

    // ! PACKAGE PAYMENT CONFIRMATION
    if (isset($_SESSION['buyPackage'])) {
        $item_id = $order_det['item_id'];

        $vendor_id = $vid;


        deduct_from_ewallet($order_det['paid_from_ewallet'], $order_det['vendor_id'], 'Used to buy ' . $order_det['item_type']);
        deduct_from_ebanking($order_det['paid_from_ebanking'], $order_det['vendor_id'], 'Used to buy ' . $order_det['item_type']);



        $qry = "SELECT * from vendor_packages where id = '$item_id' ";
        $res = mysqli_fetch_assoc(mysqli_query($conn, $qry));

        $marketplace_id = $res['package_type'];

        if ($res['cashback'] > 0) {
            credit_ewallet((float)$res['cashback'], 'Cashback received', (int)$res['cashback_validity']);
        }


        $invoice = array();

        $invoice['target'] = getVendorInfo((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['email'];
        $invoice['ewallet'] = $order_det['paid_from_ewallet'];
        $invoice['ebanking'] = $order_det['paid_from_ebanking'];
        $invoice['membership_code'] = false;
        $invoice['title'] = $res['package_title'];
        $invoice['image'] = $res['package_image'];
        $invoice['cashback'] = $res['cashback'];
        $invoice['online_payment'] = $order_det['amount'];
        $invoice['discount'] = $order_det['item_discount'];
        $invoice['coupon_discount'] = isset($_SESSION['COUPON_DISCOUNT']) ? $_SESSION['COUPON_DISCOUNT'] : 0;
        $invoice['coupon_code'] = isset($_SESSION['COUPON_CODE']) ? $_SESSION['COUPON_CODE'] : "";

        $coupon_id = isset($_SESSION['COUPON_ID']) ? $_SESSION['COUPON_ID'] : -1;
        $qry = "UPDATE available_coupons SET redeemed = 1 WHERE id = '$coupon_id' ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }

        $qry = "INSERT INTO `purchased_packages`(transaction_charge, `site_id`, `package_type`, `package_description`, `package_title`, `no_of_posts`, `response_per_post`, `access_to_response`, `filter`, `downloadable`, `validity`, `created_date`, `no_of_profile`, `order_id`, `vendor_id`, package_image) SELECT transaction_charge, `site_id`, `package_type`, `package_description`, `package_title`, `no_of_posts`, `response_per_post`, `access_to_response`, `filter`, `downloadable`, `validity`, `created_date`, `no_of_profile`, $order_id, $vid, `package_image` FROM vendor_packages WHERE id = $item_id ";


        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
            $result = "Please contact admin for refund";
        } else {
            $i = mysqli_insert_id($conn);
            $qry = "UPDATE purchased_packages SET created_date = '$curr_date' WHERE id = $i ";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }
        }

        $qry = "UPDATE orders set payment_status = 'PAID', order_status = 'COMPLETED' where id = '$order_id' ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }


        $qry = "SELECT * FROM marketplace_list WHERE id = '$marketplace_id' ";
        $res = mysqli_query($conn, $qry);
        if (!$res) {
            errlog(mysqli_error($conn), $qry);
        }

        $list = mysqli_fetch_assoc($res);
        $new_vendor_type = ',' . $list['vendor_types'] . ",";

        $list = explode(',', $list['vendor_types']);

        $vendor_types = getVendorType((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID());
        foreach ($vendor_types as $vt) {
            if ($vt == '') {
                continue;
            }


            if (array_search($vt, $list) === false) {
                $new_vendor_type .= $vt . ',';
            }
        }
        $new_vendor_type = realEscape($new_vendor_type);

        $qry = "UPDATE vendor SET vendor_type = '$new_vendor_type' WHERE id = '$vid' ";
        $res = mysqli_query($conn, $qry);
        if (!$res) {
            errlog(mysqli_error($conn), $qry);
        }


        sendInvoice($invoice);
        $result = '1';
    }



    // ! MEMBERSHIP PAYMENT CONFIRMATION
    else if (isset($_SESSION['buyMembership'])) {
        $item_id = $order_det['item_id'];
        $order_id = $order_det['id'];

        $qry = "SELECT * from membership where id = '$item_id' ";
        $res = mysqli_fetch_assoc(mysqli_query($conn, $qry));
        $membership_validity = $res['validity'];
        $purchased_vendor_type = '';

        deduct_from_ewallet($order_det['paid_from_ewallet'], $order_det['vendor_id'], 'Used to buy ' . $order_det['item_type']);
        deduct_from_ebanking($order_det['paid_from_ebanking'], $order_det['vendor_id'], 'Used to buy ' . $order_det['item_type']);

        if ($res['cashback_amount'] > 0) {
            credit_ewallet((float)$res['cashback_amount'], 'Cashback received', (int)$res['cashback_validity']);
        }

        $membership_code = "M" . $res['id'] . $type . $vid . "R" . $order_id;

        $invoice = array();

        $invoice['target'] = getVendorInfo((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID())['email'];
        $invoice['ewallet'] = $order_det['paid_from_ewallet'];
        $invoice['ebanking'] = $order_det['paid_from_ebanking'];
        $invoice['membership_code'] = $membership_code;
        $invoice['title'] = $res['title'];
        $invoice['image'] = $res['banner'];

        $invoice['cashback'] = $res['cashback_amount'];
        $invoice['online_payment'] = $order_det['amount'];
        $invoice['discount'] = $order_det['item_discount'];
        $invoice['coupon_discount'] = isset($_SESSION['COUPON_DISCOUNT']) ? $_SESSION['COUPON_DISCOUNT'] : 0;
        $invoice['coupon_code'] = isset($_SESSION['COUPON_CODE']) ? $_SESSION['COUPON_CODE'] : "";
        if ($membership_validity == '-1') {
            $invoice['validity'] = 'Validity: Lifetime';
        } else {
            $invoice['validity'] = 'Valid Till: ' . date("d-m-Y", strtotime($curr_date . "+ " . $membership_validity . " day"));
        }


        $coupon_id = isset($_SESSION['COUPON_ID']) ? $_SESSION['COUPON_ID'] : -1;
        $qry = "UPDATE available_coupons SET redeemed = 1 WHERE id = '$coupon_id' ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }

        $qry = "INSERT INTO `membership`(`site_id`, `vendor_id`, `order_id`, `membership_code`, `title`, `banner`, `price`, `validity`, `cashback_amount`, `cashback_validity`, `discount_type`, `discount_amount`, `number_of_websites`, `website_validity`, `specific_marketplace`, `additional_details`, `featured`, `status`, `save_type`, `last_updated`, `created_date`) SELECT `site_id`, $vid, $order_id, '$membership_code', `title`, `banner`, `price`, `validity`, `cashback_amount`, `cashback_validity`, `discount_type`, `discount_amount`, `number_of_websites`, `website_validity`, `specific_marketplace`, `additional_details`, `featured`, -1, 'BUY', '$curr_date', '$curr_date' FROM membership WHERE id = '" . $res['id'] . "' ";

        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
            $result = "Please contact admin for refund";
        }


        $_SESSION['RECENT_MEMBERSHIP_ID'] = $new_mem_id = mysqli_insert_id($conn);

        $qry = "INSERT INTO `membership_details`(`membership_id`, `marketplace_id`, `posts`, `commission_type`, `commission_amount`, `access_validity`, `access_amount`, `created_date`) SELECT $new_mem_id, `marketplace_id`, `posts`, `commission_type`, `commission_amount`, `access_validity`, `access_amount`, '$curr_date' FROM membership_details WHERE membership_id = '" . $res['id'] . "' ";

        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }


        $qry = "INSERT INTO `membership_item_selection`(`membership_id`, `item_type`, `item`, `created_date`) SELECT $new_mem_id, `item_type`, `item`, '$curr_date' FROM membership_item_selection WHERE membership_id = '" . $res['id'] . "' AND item_type = 'MARKETPLACE' ";

        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }


        $qry = "SELECT * FROM membership_discounts WHERE membership_id = '" . $res['id'] . "' ";
        $r = mysqli_query($conn, $qry);
        $mem_dicounts = mysqli_fetch_all($r, MYSQLI_ASSOC);

        foreach ($mem_dicounts as $row) {
            $qry = "INSERT INTO `membership_discounts`(`membership_id`, `marketplace_id`, `discount_group`, `discount_type`, `discount_amount`, `created_date`) SELECT $new_mem_id, `marketplace_id`, `discount_group`, `discount_type`, `discount_amount`, '$curr_date' FROM membership_discounts WHERE id = '" . $row['id'] . "' ";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }

            $discount_id = mysqli_insert_id($conn);

            $qry = "INSERT INTO `membership_item_selection`(`membership_id`, `membership_discounts_id`, `item_type`, `item`, `variant`, `created_date`) SELECT $new_mem_id, $discount_id, `item_type`, `item`, `variant`, '$curr_date' FROM membership_item_selection WHERE membership_id = '" . $res['id'] . "' AND membership_discounts_id = '" . $row['id'] . "' ";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }
        }



        $qry = "UPDATE orders set payment_status = 'PAID', order_status = 'COMPLETED' where id = '$order_id' ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }



        $new_vendor_type = "," . $purchased_vendor_type . ",";
        $vendor_types = getVendorType((isset($_SESSION['temp_vendor_id'])) ? $_SESSION['temp_vendor_id'] : getVendorID());
        foreach ($vendor_types as $vt) {
            if ($vt == '') {
                continue;
            }


            if ($vt != $purchased_vendor_type) {
                $new_vendor_type .= $vt . ',';
            }
        }
        $new_vendor_type = realEscape($new_vendor_type);

        $qry = "UPDATE vendor SET vendor_type = '$new_vendor_type' WHERE id = '$vid' ";
        $res = mysqli_query($conn, $qry);
        if (!$res) {
            errlog(mysqli_error($conn), $qry);
        }
        sendInvoice($invoice);

        $result = '1';
    }

    die($result);
}
