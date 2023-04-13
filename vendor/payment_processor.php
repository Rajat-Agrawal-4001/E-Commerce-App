<?php

/*
functions =>

total_n_available_ebanking($vendor_id)

deduct_from_ebanking($deduct_X_amount_from_ebanking, $vendor_id, $reason_for_transaction = 'NOT SPECIFIED')

available_ewallet($id, $type = 'vendor')

deduct_from_ewallet ($deduct_X_amount_from_ewallet, $vendor_id, $reason_for_transaction = 'NOT SPECIFIED')

credit_ebanking($vendor_id, $amount, $order_id, $reason_for_transaction = "NOT SPECIFIED")

transactionChargeFinder(Int $marketplace_id, Int $vendor_id = -1): array

*/

function total_n_available_ebanking($vendor_id = -1)
{
    global $conn, $curr_date, $this_site_id;

    if ($vendor_id == -1) {
        $vendor_id = getVendorID();
    }

    $qry = "SELECT sum(amount) from wallet_transactions where nature = 'CREDIT' and status = 'COMPLETED' and transact_from = 'ebanking' and vendor_id = '$vendor_id' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
        die("Error eb1");
    }
    $res = mysqli_fetch_assoc($res);
    $total_credit = $res['sum(amount)'];

    $qry = "SELECT sum(amount) from wallet_transactions where nature = 'DEBIT' and status = 'COMPLETED' and transact_from = 'ebanking' and vendor_id = '$vendor_id' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
        die("Error eb2");
    }
    $res = mysqli_fetch_assoc($res);
    $total_debit = $res['sum(amount)'];

    $total_ebanking = $total_credit - $total_debit;
    // -----------------------------------------------

    $qry = "SELECT sum(amount) from wallet_transactions where nature = 'CREDIT' and status = 'COMPLETED' and transact_from = 'ebanking' and vendor_id = '$vendor_id' and `date` + INTERVAL 15 day <= '$curr_date' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
        die("Error eb1");
    }
    $res = mysqli_fetch_assoc($res);
    $total_credit = $res['sum(amount)'];

    $qry = "SELECT sum(amount) from wallet_transactions where nature = 'DEBIT' and status = 'COMPLETED' and transact_from = 'ebanking' and vendor_id = '$vendor_id' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
        die("Error eb2");
    }
    $res = mysqli_fetch_assoc($res);

    $total_debit = $res['sum(amount)'];
    $total_available = $total_credit - $total_debit;

    $ret = array('available' => round($total_available, 2), 'total' => round($total_ebanking, 2));

    return $ret;
}


function deduct_from_ebanking($deduct_X_amount_from_ebanking, $vendor_id, $reason_for_transaction = 'NOT SPECIFIED', $attachment = '')
{
    global $conn, $curr_date, $this_site_id;
    $total_available = total_n_available_ebanking($vendor_id);
    $total_available = $total_available['available'];

    if ($total_available == 0  ||  $deduct_X_amount_from_ebanking <= 0) {
        return 0;
    }

    if ($total_available < $deduct_X_amount_from_ebanking) {
        $deduct_X_amount_from_ebanking = $total_available;
    }

    $qry = "INSERT INTO wallet_transactions (transact_from, vendor_id, nature, date, amount, status, description, site_id, attachment) values ('ebanking', '$vendor_id', 'DEBIT', '$curr_date', '$deduct_X_amount_from_ebanking', 'COMPLETED', '$reason_for_transaction', '$this_site_id', '$attachment') ";

    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
        return -1;
    }
    return round($deduct_X_amount_from_ebanking, 2);
}


function available_ewallet($id = -1, $type = 'vendor')
{
    global $conn, $curr_date, $this_site_id;
    if ($id == -1) {
        $id = getVendorID();
    }
    $col = '';
    switch ($type) {
        case 'vendor':
            $col = 'vendor_id';
            break;
        case 'affiliate':
            $col = 'affiliate_id';
            break;
        default:
            return -2;
    }
    $qry = "SELECT *,added_date + INTERVAL validity day as expired_on  from ewallet where $col = '$id' and (added_date + INTERVAL validity day) < '$curr_date' ";
    $res = mysqli_query($conn, $qry);
    if ($res) {
        $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
        if (count($res) > 0) {
            foreach ($res as $row) {
                $qry = "INSERT INTO wallet_transactions (transact_from, vendor_id, nature, date, amount, site_id) values ('ewallet', '$id', 'EXPIRED', '" . $row['expired_on'] . "', '" . $row['cashback'] . "', '$this_site_id') ";
                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                } else {
                    if (!mysqli_query($conn, "DELETE FROM ewallet where id = '" . $row['id'] . "' ")) {
                        errlog(mysqli_error($conn), 'EXPIRE QUERY ERROR');
                    }
                }
            }
        }
    } else {
        errlog(mysqli_error($conn), $qry);
        return -1;
    }
    $qry = "SELECT sum(cashback) as total from ewallet where $col = '$id' and (added_date + INTERVAL validity day) >= '$curr_date' ";
    // echo $qry;
    $res = mysqli_query($conn, $qry);
    if ($res) {
        $res = mysqli_fetch_assoc($res);
        if (!isset($res['total'])) {
            return 0;
        }
        return round($res['total'], 2);
    } else {
        errlog(mysqli_error($conn), $qry);
        return -1;
    }
    return 0;
}


function deduct_from_ewallet($deduct_X_amount_from_ewallet, $vendor_id, $reason_for_transaction = 'NOT SPECIFIED')
{
    if ($deduct_X_amount_from_ewallet <= 0) {
        return 0;
    }

    global $curr_date, $conn, $this_site_id;
    $description = $reason_for_transaction;
    $use_from_ewallet = $deduct_X_amount_from_ewallet;
    if ($use_from_ewallet == ''  ||  $use_from_ewallet < 0) {
        $use_from_ewallet = 0;
    }
    $available_ewallet = available_ewallet($vendor_id);
    if ($available_ewallet < 0) {
        die("Error: " . $available_ewallet);
    }

    if ($use_from_ewallet > $available_ewallet) {
        $use_from_ewallet = $available_ewallet;
    }
    $amount_deducted = $use_from_ewallet;
    $qry = "SELECT * from ewallet where vendor_id = '$vendor_id' and cashback != '0' and added_date + INTERVAL validity day >= '$curr_date' order by (added_date + INTERVAL validity day) ASC ";

    $res = mysqli_fetch_all(mysqli_query($conn, $qry), MYSQLI_ASSOC);
    foreach ($res as $card) {
        if ($card['cashback'] > $use_from_ewallet) {
            mysqli_query($conn, "UPDATE ewallet set cashback = '" . $card['cashback'] - $use_from_ewallet . "' where id = '" . $card['id'] . "' ");
            $use_from_ewallet = 0;
        } else {
            $use_from_ewallet -= $card['cashback'];
            mysqli_query($conn, "DELETE FROM ewallet where id = '" . $card['id'] . "' ");
        }

        if ($use_from_ewallet <= 0) {
            $qry = "INSERT INTO wallet_transactions (`transact_from`, `vendor_id`, `nature`, `date`, `amount`, `status`, `description`, `site_id`) VALUES ('ewallet', '$vendor_id', 'DEBIT', '$curr_date', '$deduct_X_amount_from_ewallet', 'COMPLETED', '$description', '$this_site_id') ";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }
            return round($amount_deducted, 2);
        }
    }
    return -1;
}


function credit_ebanking($vendor_id, $amount, $order_id, $reason_for_transaction = "NOT SPECIFIED")
{
    $vendor_id = realEscape($vendor_id);
    $amount = realEscape($amount);
    $order_id = realEscape($order_id);
    $reason_for_transaction = realEscape($reason_for_transaction);

    global $conn, $curr_date, $this_site_id;


    $qry = "INSERT INTO wallet_transactions (transact_from, vendor_id, nature, date, amount, status, description, site_id, order_id) values ('ebanking', '$vendor_id', 'CREDIT', '$curr_date', '$amount', 'COMPLETED', '$reason_for_transaction', '$this_site_id', $order_id) ";

    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
        return -1;
    }
    return round($amount, 2);
}


function credit_ewallet(float $cashback_amount, string $reason, int $validity = 36500, int $vendor_id = -1): bool
{
    if ($cashback_amount < 1) {
        return true;
    }

    if ($validity < 1) {
        return true;
    }


    global $conn, $this_site_id, $curr_date;
    if ($vendor_id == -1) {
        $vendor_id = getVendorID();
    }


    if ($vendor_id == -1) {
        return false;
    }

    $qry = "INSERT INTO ewallet(vendor_id, cashback, validity, added_date) VALUES ('$vendor_id', '" . $cashback_amount . "', '$validity', '$curr_date')  ";
    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
        return false;
    } else {
        $qry = "INSERT INTO `wallet_transactions`(`transact_from`, `vendor_id`, `nature`, `date`, `amount`, `status`, `description`, `site_id`) VALUES ('EWALLET', '$vendor_id', 'CREDIT', '$curr_date', '" . $cashback_amount . "', 'COMPLETED', '" . realEscape($reason) . "', '$this_site_id')";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
            return false;
        }
    }
    return true;
}


function margin($user_type, $item_id, $marketplace_id)
{
    global $conn, $this_site_id;
    $qry = "SELECT * FROM product_margin WHERE site_id = '$this_site_id' AND product_id = '" . realEscape($item_id) . "' AND marketplace_id = '" . realEscape($marketplace_id) . "' AND user_type = '" . realEscape($user_type) . "' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
        return false;
    }

    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $total_margin = $total_mrp = $total_markup = 0;
    foreach ($result as $row) {
        $total_margin += (float)$row['margin'];
        $total_mrp += (float)$row['MRP'];
        $total_markup += (float)$row['mark_up'];
    }

    return array("MARGIN" => round($total_margin, 2), "MRP" => round($total_mrp, 2), "MARKUP" => round($total_markup, 2));
}




function transactionChargeFinder(Int $marketplace_id, Int $vendor_id = -1): array
{
    if ($vendor_id == -1) {
        $vendor_id = getVendorID();
    }

    if ($vendor_id == -1) {
        return array("ERROR" => "Invalid Vendor ID");
    }

    global $this_site_id, $conn, $curr_date;

    $vendorInfo = getVendorInfo($vendor_id);
    $current_charge = $vendorInfo['transaction_charge'];

    $qry = "SELECT * FROM purchased_packages WHERE package_type = '$marketplace_id' AND vendor_id = '$vendor_id' AND site_id = $this_site_id AND created_date + INTERVAL `validity` day >= '$curr_date' AND transaction_charge <> -1 ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }

    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    foreach ($data as $datum) {
        if ($current_charge > (float)$datum['transaction_charge']) {
            $current_charge = (float)$datum['transaction_charge'];
        }
    }

    return array("TRANSACTION_CHARGE" => $current_charge);
}


function splitPayment(float $total, float $ebanking, float $ewallet): array
{
    $available_ewallet = available_ewallet();
    if ($ewallet > $available_ewallet) {
        $ewallet = $available_ewallet;
    }

    if ($ewallet >= $total) {
        return array("EWALLET" => $ewallet, "EBANKING" => 0, "REMAINING" => 0);
    }

    $available_ebanking = total_n_available_ebanking()['available'];
    if ($ebanking > $available_ebanking) {
        $ebanking = $available_ebanking;
    }

    if ($ebanking >= $total) {
        return array("EWALLET" => 0, "EBANKING" => $ebanking, "REMAINING" => 0);
    }

    if (($ebanking + $ewallet) == $total) {
        return array("EWALLET" => $ewallet, "EBANKING" => $ebanking, "REMAINING" => 0);
    }

    if (($ebanking + $ewallet) > $total) {
        $ebanking = $total - $ewallet;
        return array("EWALLET" => $ewallet, "EBANKING" => $ebanking, "REMAINING" => 0);
    }

    return array("EWALLET" => $ewallet, "EBANKING" => $ebanking, "REMAINING" => ($total - ($ewallet + $ebanking)));
}


function checkCoupon(string $coupon_code, $marketplace, Int $vendor_id = -1): array
{
    global $conn, $curr_date, $this_site_id;
    if ($vendor_id == -1)
        $vendor_id = getVendorID();
    $coupon_code = realEscape($coupon_code);
    $qry = "SELECT * FROM available_coupons WHERE coupon_code = '$coupon_code' AND (marketplace_id = 'ALL' OR marketplace_id = '$marketplace' ) AND vendor_id = '$vendor_id' AND site_id = '$this_site_id' AND created_date + INTERVAL validity day >= '$curr_date' AND redeemed = 0 ";
    $res = mysqli_query($conn, $qry);

    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }
    $data = mysqli_fetch_assoc($res);
    if (isset($data['id'])) {
        return $data;
    }
    return array();
}
