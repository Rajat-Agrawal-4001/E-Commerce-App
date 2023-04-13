<?php
session_start();
include 'config/connection.php';
include 'modify_cart_n_wishlist.php';
include "payment_processor.php";

$vid = -1;

if (isset($_SESSION['vendor_id']))
    $vid = $_SESSION['vendor_id'];
else if (isset($_SESSION['user_id']))
    $vid = $_SESSION['user_id'];



if (isset($_POST['clearCart'])) {
    if (isset($_SESSION['vendor_id'])  ||  isset($_SESSION['user_id'])) {
        $qry = "UPDATE cart_n_wishlist set quantity = 0, save_status = 0 WHERE vendor_id = '$vid' AND save_type = 'CART' ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
            echo 0;
        } else {
            setcookie("guestCart", "", time() - 1, '/');
            setcookie("guestCartQuantity", "", time() - 1, '/');
            unset($_SESSION['guestCart']);
            echo 1;
        }
    } else {
        setcookie("guestCart", "", time() - 1, '/');
        setcookie("guestCartQuantity", "", time() - 1, '/');
        unset($_SESSION['guestCart']);
        echo 1;
    }
} else if (isset($_POST['updateQuantity'])) {
    $update = realEscape($_POST['updateQuantity']);
    $id = realEscape($_POST['item']);
    $type = realEscape($_POST['type']);
    $curr = isset($_POST['curr']) ? realEscape($_POST['curr']) : '';

    $variant = isset($_POST['variant']) ? realEscape($_POST['variant']) : '';

    if ($variant != ''  &&  $update == 'increase') {
        $qry = "SELECT * from product_variants where id = '$variant' ";
        $res = mysqli_query($conn, $qry);
        if (!$res) {
            errlog(mysqli_error($conn), $qry);
        }
        $res = mysqli_fetch_assoc($res);
        if (isset($res['id'])) {
            if (((int)($res['s_stock'])) + ((int)($res['a_stock'])) < (int)($curr) + 1) {
                die("out");
            }
        } else {
            die("out");
        }
    }



    $qry = "";
    if ($update == 'increase') {
        if (modify_cart_n_wishlist($type, $id, 'CART', false, $variant, false)) {
            echo 1;
        } else {
            echo 0;
        }
    } else if ($update == 'decrease') {
        if (modify_cart_n_wishlist($type, $id, 'CART', false, $variant, true)) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo '
        <script>
        console.log(' . $update . ');
        </script>
        ';
        die;
    }
}


//  remove item  

else if (isset($_POST['removeItem'])) {
    if (modify_cart_n_wishlist((int)($_POST['type']), (int)($_POST['removeItem']), 'CART', true, (int)($_POST['var_id']))) {
        echo "1";
    } else {
        echo "0";
    }
} else if (isset($_POST['applyCouponCode'])) {
    $code = realEscape($_POST['applyCouponCode']);
    $data = checkCoupon($code, 'ALL');
    $price = (float)($_POST['price']);

    $response = array();
    if (isset($data['id'])) {
        $discount = 0;
        $data['discount'] = (float)($data['discount']);
        if ($data['discount_type'] == '%') {
            $discount = round($price * $data['discount'] / 100, 2);
        } else {
            $discount = $data['discount'];
        }

        $_SESSION['APPLIED_COUPON'] = $data;

        $response = array("success" => true, "discount" => $discount);
    } else {
        if (isset($_SESSION['APPLIED_COUPON'])) {
            unset($_SESSION['APPLIED_COUPON']);
        }
        $response = array("error" => true);
    }
    die(json_encode($response));
}


//  checkout_helper

else if (isset($_POST['removeAddress'])) {
    $vid = -1;
    if (isset($_SESSION['user_id'])) {
        $vid = $_SESSION['user_id'];
    } else if (isset($_SESSION['vendor_id'])) {
        $vid = $_SESSION['vendor_id'];
    }

    $id = realEscape($_POST['removeAddress']);

    $qry = "SELECT * from address  where id = '$id' and vendor_id = '$vid' and site_id = '$this_site_id' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }
    $res = mysqli_fetch_assoc($res);
    if ($res  &&  isset($res['id'])) {
        $qry = "DELETE from address where id = '$id' ";
        if (mysqli_query($conn, $qry)) {
            echo 1;
        } else {
            errlog(mysqli_error($conn), $qry);
            echo 0;
        }
    } else {
        echo -1;
    }
}


//  set parameters for checkout 

else if (isset($_POST['updateEbank'])) {
    $_SESSION['use_from_ebanking'] = realEscape($_POST['updateEbank']);
    $_SESSION['use_from_ewallet'] = realEscape($_POST['ewallet']);
    $_SESSION['use_address'] = realEscape($_POST['address']);
    $_SESSION['payment_mode'] = realEscape($_POST['payment_mode']);

    echo 1;
}
