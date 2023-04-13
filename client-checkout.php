<?php
session_start();
include "config/connection.php";

if (getVendorID() == -1) {
    header("Location: client-cart");
}

require_once "razorpay/razorpay-php/config.php";
include "payment_processor.php";

$checkout = true; // flag to access header


if (!isset($_SESSION['vendor_id']) && !isset($_SESSION['user_id'])) {
    header("Location: product_module");
}

$show_address_add_msg = 0;

if (isset($_POST['updateAddress'])) {
    $id = realEscape($_POST['updateAddress']);
    $vid = -1;
    if (isset($_SESSION['user_id'])) {
        $vid = $_SESSION['user_id'];
    } else if (isset($_SESSION['vendor_id'])) {
        $vid = $_SESSION['vendor_id'];
    }

    $qry = "SELECT * FROM address WHERE id = '$id' AND vendor_id = '$vid' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    } else {
        $res = mysqli_fetch_assoc($res);
        if (!$res) {
            die("Bad request");
        } else {
            $pincode = realEscape($_POST['pincode' . $id]);
            $address = realEscape($_POST['address1' . $id]) . "?" . "" . "?" . realEscape($_POST['address4' . $id]);
            $name = realEscape($_POST['firstName' . $id]) . "?" . realEscape($_POST['lastName' . $id]);
            $mobile = realEscape($_POST['mobileNumber' . $id]);
            $additional_mobile = realEscape($_POST['addMobileNumber' . $id]);
            $address_type = realEscape($_POST['addressType' . $id]);
            $availability = "";
            foreach ($_POST['availability' . $id] as $ava) {
                if ($availability == "") {
                    $availability = realEscape($ava);
                } else {
                    $availability .= "?" . realEscape($ava);
                }
            }
            $landmark = realEscape($_POST['landmark' . $id]);



            $qry = "UPDATE `address` set `name` = '$name', `address` = '$address', `pincode` = '$pincode', `mobile` = '$mobile', `additional_mobile` = '$additional_mobile', `address_type` = '$address_type', `availability` = '$availability', `landmark` = '$landmark' Where id = '$id' ";

            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            } else {
                $show_address_add_msg = 2;
            }
        }
    }
}

/// insert new address

else if (isset($_POST['pincode'])) {
    $pincode = realEscape($_POST['pincode']);
    $address = realEscape($_POST['address1']) . "?" . "" . "?" . realEscape($_POST['address4']);
    $name = realEscape($_POST['firstName']) . "?" . realEscape($_POST['lastName']);
    $mobile = realEscape($_POST['mobileNumber']);
    $additional_mobile = realEscape($_POST['addMobileNumber']);
    $address_type = realEscape($_POST['addressType']);
    $availability = "";
    foreach ($_POST['availability'] as $ava) {
        if ($availability == "") {
            $availability = realEscape($ava);
        } else {
            $availability .= "?" . realEscape($ava);
        }
    }
    $landmark = realEscape($_POST['landmark']);

    $vid = -1;
    if (isset($_SESSION['user_id'])) {
        $vid = $_SESSION['user_id'];
    } elseif (isset($_SESSION['vendor_id'])) {
        $vid = $_SESSION['vendor_id'];
    }

    $qry = "INSERT INTO `address`(`site_id`, `vendor_id`, `name`, `address`, `pincode`, `mobile`, `additional_mobile`, `address_type`, `availability`, `created_date`, `landmark`) VALUES ('$this_site_id', '$vid', '$name', '$address', '$pincode', '$mobile', '$additional_mobile', '$address_type', '$availability', '$curr_date', '$landmark')";

    if (!mysqli_query($conn, $qry)) {
        errlog(mysqli_error($conn), $qry);
    } else {
        $show_address_add_msg = 1;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<?php // include "site_head.php"
include 'template_head.php';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Rishi330/cart_n_checkout/cart-style.css">
<link href="https://cdn.jsdelivr.net/gh/Rishi330/admin_template/css/icons.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Rishi330/admin_template/plugins/sweet-alert2/sweetalert2.min.css" />



<body class="preload checkout-page">

    <div class="menu-area">
        <?php include "header.php" ?>
        <!--================================
        START breadcrumbsdfsafsdfsafasfasf AREA
    =================================-->

        <!--================================
            START DASHBOARD AREA
    =================================-->
        <section class="dashboard-area">
            <div class="dashboard_contents">

                <div class="container">
                    <h5 style="padding:1rem; background-color:#fff; margin-bottom:1rem;">Checkout</h5>
                    <div class="row">
                        <?php

                        if (isset($_SESSION['user_id'])) {
                            $vid = $_SESSION['user_id'];
                        } else if (isset($_SESSION['vendor_id'])) {
                            $vid = $_SESSION['vendor_id'];
                        }

                        $qry = "SELECT * from address where vendor_id = '$vid' and site_id = '$this_site_id' ";
                        $res = mysqli_query($conn, $qry);
                        $address = mysqli_fetch_all($res, MYSQLI_ASSOC);
                        $counter = 0;
                        foreach ($address as $add) {
                            $margin = '';
                            if ($counter == 0) {
                                $margin = 'mt-5';
                            }
                            $counter++;
                        ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="feature2asadsad33532" style="height:10rem; width: 100%">
                                    <span class="feature2asadsad33532__count"><?php echo $counter; ?></span>

                                    <div class="feature2asadsad33532__content">
                                        <div class="custom-radio">
                                            <input type="radio" id="add<?php echo $add['id'] ?>" <?php echo ($counter == 1) ? "checked" : ""; ?> data-target-block="#addressPreviewBlock<?php echo $add['id'] ?>" class="addressSelection" name="addressSelection" value="<?php echo $add['id'] ?>">
                                            <label for="add<?php echo $add['id'] ?>">
                                                <span class="circle"></span><?php $str = $add['name'];
                                                                            $str = str_replace('?', " ", $str);
                                                                            echo htmlspecialchars($str); ?></label>
                                        </div>
                                        <p>
                                            <?php
                                            $str = $add['address'];
                                            $str = str_replace('?', " ", $str);
                                            echo htmlspecialchars($str);
                                            ?>
                                        </p>
                                        <h6 style="font-size:1rem;"><?php echo htmlspecialchars($add['mobile']) ?></h6>

                                    </div>
                                    <div class="row p-3">
                                        <div class="col-sm-12 text-end">
                                            <span class="btn btn-danger p-2 removeAddress" data-id="<?php echo $add['id'] ?>">Remove</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                        <!-- end /.col-md-4 -->
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <form action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post" id="tempForm">
                                <div class="information_moduledawdeqwe32rfdsa">
                                    <h4 style="font-weight:600; font-size:1rem; padding:1rem;">Add New Billing Address </h4>
                                    <div class="information__setasdadsasd34235423" style="padding:1rem;">
                                        <div class="information_wrappersdadasd4324234 form--fields">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="first_name">First Name
                                                            <sup>*</sup>
                                                        </label>
                                                        <input type="text" id="firstName" name="firstName" class="text_field" placeholder="First Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="last_name">last Name
                                                            <sup>*</sup>
                                                        </label>
                                                        <input type="text" id="lastname" name="lastName" class="text_field" placeholder="last name">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end /.row -->

                                            <div class="form-group">
                                                <label for="email">Mobile Number
                                                    <sup>*</sup>
                                                </label>
                                                <input type="number" name="mobileNumber" id="mobileNumber" class="text_field" placeholder="Mobile Number">
                                            </div>

                                            <div class="form-group">
                                                <label for="email1">Additional Mobile
                                                </label>
                                                <input type="number" name="addMobileNumber" id="addMobileNumber" class="text_field" placeholder="Additional Mobile">
                                            </div>

                                            <div class="form-group">
                                                <label for="country1">Country
                                                    <sup>*</sup>
                                                </label>
                                                <div class="select-wrap select-wrap2">
                                                    <select id="address4" name="address4" class="text_field">
                                                        <option value="India">India</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Uruguye">Uruguye</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Neverland">Neverland</option>
                                                        <option value="Atlantis">Atlantis</option>
                                                    </select>
                                                    <span class="lnr lnr-chevron-down"></span>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="address1">Address Line 1</label>
                                                <input type="text" placeholder="House number and street name" id="address1" name="address1" class="text_field">
                                            </div>

                                            <div class="form-group">
                                                <label for="address2">Address Line 2</label>
                                                <input type="text" id="landmark" name="landmark" placeholder="Landmark" class="text_field">
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="zipcode">Zip / Postal Code
                                                            <sup>*</sup>
                                                        </label>
                                                        <input type="text" id="pincode" name="pincode" class="text_field">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 my-1 control-label">Save Address As</label>
                                                <div class="col-md-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="addressType" id="inlineRadio1" value="Home" selected>
                                                        <label class="form-check-label" for="inlineRadio1">Home</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="addressType" id="inlineRadio2" value="Work">
                                                        <label class="form-check-label" for="inlineRadio2">Work</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-3 my-2 control-label">Delivery Timing</label>
                                                <div class="col-md-9">

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="availability[]" value="Monday-Friday 9am-6pm">
                                                        <label class="form-check-label" for="inlineCheckbox1">Monday-Friday 9am-6pm</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="availability[]" value="Open on Saturday">
                                                        <label class="form-check-label" for="inlineCheckbox2">Open on Saturday</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="availability[]" value="Open on Sunday">
                                                        <label class="form-check-label" for="inlineCheckbox3">Open on Sunday</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-sm btn--secondary" id="addAddressBtn" style="margin-bottom:0.6rem; margin-top: 2rem; float: right; ">Add new Address</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end /.information__setasdadsasd34235423 -->
                                </div>
                            </form>
                        </div>



                        <!-- end /.col-md-6 -->

                        <div class="col-lg-6">






                            <div class="information_moduledawdeqwe32rfdsa order_summary">
                                <h4 style="font-weight:600; font-size:1rem; padding:1rem;">Order Summary</h4>
                                <hr>
                                <div class="row">



                                    <?php
                                    $cod_available = false;
                                    $total_mrp = $total_discount = $ewallet_limit = $total_coupon_discount = $total_shipping_cost = 0;
                                    $total_coupons_id = "";

                                    $vid = -1;
                                    if (isset($_SESSION['user_id'])) {
                                        $vid = $_SESSION['user_id'];
                                    } else if (isset($_SESSION['vendor_id'])) {
                                        $vid = $_SESSION['vendor_id'];
                                    }
                                    $qry = "SELECT * from cart_n_wishlist where save_type = 'CART' AND vendor_id = '" . $vid . "' AND quantity > 0 AND save_status = '1' AND site_id = '$this_site_id' order by created_date desc ";
                                    $res = mysqli_query($conn, $qry);
                                    if (!$res) {
                                        errlog(mysqli_error($conn), $qry);
                                    }
                                    $in_cart = mysqli_fetch_all($res, MYSQLI_ASSOC);

                                    foreach ($in_cart as $item) {
                                        $qry = "";
                                        $continue = false;
                                        switch (($item['marketplace_id'])) {
                                            case '5':
                                            case '6':
                                                $qry = "SELECT *, marketplace_products.id as prod_id, product_variants.id as var_id from marketplace_products, product_variants where product_variants.id = '" . $item['variant_id'] . "' AND marketplace_products.id = '" . $item['item_id'] . "' ";
                                                break;
                                            case '16':
                                                $qry = "SELECT *, marketplace_services.id as prod_id from marketplace_services where id = '" . $item['item_id'] . "' ";
                                                break;
                                            default:
                                                echo "Add condition for marketplace_id: " . $item['marketplace_id'] . "<br>";
                                                $continue = true;
                                        }
                                        if ($continue) {
                                            continue;
                                        }



                                        $res = mysqli_query($conn, $qry);
                                        if (!$res) {
                                            errlog(mysqli_error($conn), $qry);
                                        }

                                        $item_det = mysqli_fetch_assoc($res);
                                        if (!isset($item_det['id'])) {
                                            echo $qry . "<br>";
                                        }

                                        if (!isset($item_det['ewallet_limit'])) {
                                            $item_det['ewallet_limit'] = -1;
                                        }

                                        if ($item_det['ewallet_limit'] != -1) {
                                            $ewallet_limit += ((float) (htmlspecialchars($item_det['ewallet_limit']))) * $item['quantity'];
                                        } else {
                                            $ewallet_limit += ((float) (htmlspecialchars($item_det['price'])) * 50 / 100) * $item['quantity'];
                                        }

                                        if (($item['marketplace_id']) == '16') {
                                            $idd = $item_det['id'];
                                            $sql89 = " SELECT * FROM addon WHERE marketplace_id='16' AND item_id='$idd' AND type = 'ADDON' ";
                                            $result89 = mysqli_query($conn, $sql89);
                                            if (!$result89) {
                                                errlog(mysqli_error($conn), $sql89);
                                            } else {
                                                while ($row89 = mysqli_fetch_assoc($result89)) {
                                                    $flag++;
                                                    $item_det['price'] += (float)$row89['price'];
                                                }
                                            }
                                        }


                                        $main_image = 'x';
                                        $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND variant_id = '" . $item_det['var_id'] . "' AND main = '0' AND marketplace_id = '" . $item['marketplace_id'] . "' AND type = 'IMAGE' ";
                                        $res = mysqli_query($conn, $qry);
                                        if (!$res) {
                                            errlog(mysqli_error($conn), $qry);
                                        }

                                        $res = mysqli_fetch_assoc($res);
                                        if (isset($res['id'])) {
                                            $main_image = $res['image_url'];
                                        } else {
                                            $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '0' AND type = 'IMAGE' ";
                                            $res = mysqli_query($conn, $qry);
                                            if (!$res) {
                                                errlog(mysqli_error($conn), $qry);
                                            }

                                            $res = mysqli_fetch_assoc($res);
                                            if (isset($res['id'])) {
                                                $main_image = $res['image_url'];
                                            }
                                        }

                                        $price = $item_det['price'];
                                        $total_mrp += (float)($price * $item['quantity']);

                                        $qry = "
                                            SELECT
                                                (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $item_det['site_id'] . "' AND discount_for = 'GENERAL' ) as discount_per,
                                                
                                                (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $item_det['site_id'] . "' AND discount_for = 'GENERAL' ) as discount_amount
                                                
                                                FROM marketplace_products mrp 
                                                INNER JOIN product_variants pv ON pv.product_id = mrp.id
                                                
                                            WHERE mrp.id = '" . $item_det['prod_id'] . "' ";



                                        $res = mysqli_query($conn, $qry);
                                        if (!$res) {
                                            errlog(mysqli_error($conn), $qry);
                                        }

                                        $dis_res = mysqli_fetch_assoc($res);
                                        $discount = 0;
                                        if ($dis_res['discount_per'] > 0) {
                                            $discount = ((float)$dis_res['discount_per']) * $price / 100;
                                        }

                                        if ($dis_res['discount_amount'] > 0) {
                                            $discount += ((float)$dis_res['discount_amount']);
                                        }
                                        $single_item_discount = $discount;
                                        $discount = $discount * $item['quantity'];

                                        $total_discount += $discount;

                                    ?>
                                        <div class="col-md-12">
                                            <div class="single_productdadsadasdasdasdasdfb546643 clearfix">
                                                <div class="col-lg-6 col-md-4 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                    <div class="product__descriptionsdasfd323523523523asdasdasdasd">
                                                        <img src="<?php echo $main_image ?>" alt="Purchase image" style="height:3rem; width:3rem;">
                                                        <div class="short_descdsgvsdff3r5346436ydasdsa">
                                                            <a href="#">
                                                                <h6 style="font-size:.9rem;"><?php echo htmlspecialchars($item_det['product_title']) ?></h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- end /.product__descriptionsdasfd323523523523asdasdasdasd -->
                                                </div>
                                                <!-- end /.col-md-5 -->
                                                <div class="col-lg-2 col-md-2 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                    <span style="font-weight:600;">X <?php echo htmlspecialchars($item['quantity']) ?></span>
                                                </div>
                                                <div class="col-lg-2 col-md-2 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                    <span style="font-weight:600;"> ₹ <?php echo htmlspecialchars($item_det['price']) ?></span>
                                                </div>
                                                <!-- end /.col-md-4 -->
                                            </div>
                                            <!-- end /.single_productdadsadasdasdasdasdfb546643 -->
                                        </div>
                                        <hr>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <!-- end /.information_moduledawdeqwe32rfdsa -->
                                <div class="information_moduledawdeqwe32rfdsa payment_options">
                                    <h4 style="font-weight:600; font-size:1rem; padding:1rem;">Apply Wallet Discount</h4>
                                    <ul>
                                        <li class="padding:.9rem;">
                                            <div class="custom-checkbox">
                                                <label for="opt1">
                                                    <span class="circle"></span> Available e-Cash ₹ <?php echo total_n_available_ebanking()['available'] ?></label>
                                                <img src="../images/cards.png" alt="Visa Cards">
                                            </div>
                                            <input type="number" id="ebanking" class="number" placeholder="Pay from ecash Amount">

                                        </li>

                                        <li>
                                            <div class="custom-checkbox">
                                                <img src="../images/paypal.png" alt="Visa Cards">
                                                <label for="opt2">
                                                    <span class="circle"></span>e-Wallet ₹ <?php echo available_ewallet(); ?></label>
                                                <small> Max Limit: &#8377;<a id="maxCreditLimit"></a></small>
                                                <input type="number" name="wallet" id="ewallet" class="number" placeholder="Pay from eWallet Amount">
                                            </div>

                                        </li>

                                    </ul>
                                    </ul>
                                </div>
                                <ul>
                                    <li style="    padding: 12px 17px;
											border-top: 1px solid #ececec;
											font-size: 1rem;">
                                        <p>Order Total:</p>
                                        <span>₹ <?php echo $total_mrp ?></span>
                                    </li>
                                    <li style="    padding: 12px 17px;
											border-top: 1px solid #ececec;
											font-size: 1rem;">
                                        <p>Item Discount:</p>
                                        <span>₹ <?php echo $total_discount ?></span>
                                    </li>
                                    <?php
                                    if (isset($_SESSION['APPLIED_COUPON']['id'])) {
                                        $price = $total_mrp;
                                        $data = $_SESSION['APPLIED_COUPON'];
                                        $discount = 0;
                                        $data['discount'] = (float)($data['discount']);
                                        if ($data['discount_type'] == '%') {
                                            $discount = round($price * $data['discount'] / 100, 2);
                                        } else {
                                            $discount = $data['discount'];
                                        }

                                        $total_coupon_discount = $discount;

                                    ?>
                                        <li style="padding: 12px 17px;
											border-top: 1px solid #ececec;
											font-size: 1rem;">
                                            <p>Coupon Code:</p>
                                            <span><?php echo strtoupper($data['coupon_code']) ?></span>
                                        </li>
                                        <li style="padding: 12px 17px;
											border-top: 1px solid #ececec;
											font-size: 1rem;">
                                            <p>Coupon Discount:</p>
                                            <span>₹ <?php echo $discount ?></span>
                                        </li>
                                    <?php
                                    } else {
                                    ?>
                                        <li style="padding: 12px 17px;
											border-top: 1px solid #ececec;
											font-size: 1rem;">
                                            <p>Coupon Code:</p>
                                            <span>--NA--</span>
                                        </li>
                                        <li style="padding: 12px 17px;
											border-top: 1px solid #ececec;
											font-size: 1rem;">
                                            <p>Coupon Code:</p>
                                            <span>&#8377; 0</span>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <li class="total_ammount">
                                        <p> Grand Total</p>
                                        <span>₹ <?php echo round((float)($total_mrp - ($total_discount + $total_coupon_discount)), 2) ?></span>
                                    </li>
                                </ul>
                            </div>
                            <!-- end /.information_moduledawdeqwe32rfdsa-->
                            <div class="row">
                                <button class="btn btn--round btn--default" id="placeOrderBtn">Place Order</button>
                            </div>

                        </div>
                    </div>
                    <!-- end /.information_moduledawdeqwe32rfdsa-->
                </div>
                <!-- end /.col-md-6 -->
            </div>
    </div>
    </section>

    <?php
    include "./footer.php";
    require_once "config/makePayment.php";
    ?>
    <script src="https://cdn.jsdelivr.net/gh/Rishi330/admin_template/plugins/sweet-alert2/sweetalert2.min.js"></script>

    <script>
        $("#maxCreditLimit").html('<?php echo $ewallet_limit; ?>');

        function updateInvoice() {
            var wallet = $("#ewallet").val();
            if (wallet.trim().length == 0) {
                wallet = 0;
            }
            wallet = parseFloat(wallet);
            $("#walletCredit").html("&#8377;");
            $("#walletCredit").append(wallet);
            $("#walletCredit").data("value", wallet);


            var banking = $("#ebanking").val();
            if (banking.trim().length == 0) {
                banking = 0;
            }
            banking = parseFloat(banking);
            $("#cashCredit").html("&#8377;");
            $("#cashCredit").append(banking);
            $("#cashCredit").data("value", banking);

            var grandTotal = parseFloat($("#grandTotal").data("value"));

            $("#grandTotal").html("&#8377;");
            $("#grandTotal").append(grandTotal - (wallet + banking));
            $("#grandTotal").data("value", grandTotal - (wallet + banking));

        }


        $(document).ready(function() {

            $("#placeOrderBtn").on("click", function() {

                var wallet = 0;
                if ($("#ewallet").val().trim().length > 0)
                    wallet = parseFloat($("#ewallet").val());
                var banking = 0;
                if ($("#ebanking").val().trim().length > 0)
                    banking = parseFloat($("#ebanking").val());


                var address = -1;
                $(".addressSelection:checked").each(function() {
                    address = $(this).val();
                })

                if (address == -1) {
                    Swal.fire("Error", "Select Address", "error");
                    return false;
                }


                var payment_mode = 'RAZOR-PAY';
                if ($("#codCheck") && $("#codCheck").is(":checked")) {
                    payment_mode = 'COD';
                }


                var formData = new FormData();
                formData.append("make_payment", true);

                var targetURL = '<?php echo $this_site_url . "/razorpay/buyItem.php" ?>';
                var finalKey = 'verifyItemPayment';
                var successMsg = 'Order has been placed successfully';
                var errorMsg = 'Something went wrong';
                var errorLink, successLink;
                successLink = "client-orders";
                errorLink = '<?php echo explode('.', $_SERVER['PHP_SELF'])[0] . "?e=" . urlencode(base64_encode("error")) ?>';

                $.ajax({
                    url: "cart_helper.php",
                    method: "POST",
                    data: {
                        updateEbank: banking,
                        ewallet: wallet,
                        address: address,
                        payment_mode: payment_mode,
                    },
                    success: function(data) {
                        makePayment(targetURL, formData, finalKey, successMsg, errorMsg, successLink, errorLink);
                    }
                })

            })

            var ebanking = parseFloat('<?php echo total_n_available_ebanking($vid)['available'] ?>');
            var ewallet = parseFloat('<?php echo available_ewallet($vid) ?>');
            var ewallet_limit = parseFloat('<?php echo $ewallet_limit; ?>');
            var grandTotal = parseFloat('<?php echo ($total_mrp + $total_shipping_cost) - ($total_coupon_discount + $total_discount) ?>');

            if (ebanking > grandTotal) {
                ebanking = grandTotal;
            }

            if (ewallet > ewallet_limit) {
                ewallet = ewallet_limit;
            }

            // $("#ewallet").val(ewallet);

            $("#ebanking").on("change", function() {
                $(this).trigger("keyup");
            })

            $("#ewallet").on("change", function() {
                $(this).trigger("keyup");
            })

            $("#ebanking").on("keyup", function() {
                $("#grandTotal").data("value", grandTotal);
                var val = parseFloat($(this).val());

                if (val > ebanking) {
                    $(this).val(ebanking);
                }

                if (val < 0) {
                    $(this).val(0);
                }
                updateInvoice();
            })


            $("#ewallet").on("keyup", function() {
                $("#grandTotal").data("value", grandTotal);
                var val = parseFloat($(this).val());
                if (val > ewallet) {
                    $(this).val(ewallet);
                }

                if (val < 0) {
                    $(this).val(0);
                }
                updateInvoice();
            })

            var flag = '<?php echo $show_address_add_msg ?>';
            if (flag == '1') {
                Swal.fire(
                    'Success!',
                    "Address added Successfully",
                    'success'
                )
            } else if (flag == '2') {
                Swal.fire(
                    'Success!',
                    "Address Updated Successfully",
                    'success'
                )
            }

            function formValidator(id = "") {
                // console.log("enter");
                if ($("#firstName" + id).val().trim().length < 2) {
                    return ("First name is mandatory.");
                }
                // console.log("1");

                if ($("#mobileNumber" + id).val().trim().length < 10) {
                    return ("Enter Valid Mobile Number ");
                }
                // console.log("2");


                if ($("#address1" + id).val().trim().length < 2) {
                    return ("Street address is mandatory.");
                }
                // console.log("3");

                if ($("#landmark" + id).val().trim().length < 2) {
                    return ("Landmark is mandatory.");
                }
                // console.log("4");

                if ($("#pincode" + id).val().trim().length < 6 || $("#pincode" + id).val().trim().length > 6) {
                    return ("Enter valid pincode.");
                }
                // console.log("5");

                var flag = false;
                $('input[name="addressType' + id + '"]:checked').each(function() {
                    flag = true;
                })

                if (!flag) {
                    return "Select Address Type.";
                }

                return true;
            }


            $(".updateAddressBtn").on("click", function() {
                var id = $(this).data("id");
                console.log(id);
                var error = formValidator(id);
                if (error === true) {
                    $("#tempForm" + id).trigger("submit");
                } else {
                    Swal.fire(
                        'Error!',
                        error,
                        'error'
                    )
                }
            })



            $("#addAddressBtn").on("click", function() {
                var error = formValidator();
                if (error === true) {
                    $("#tempForm").trigger("submit");
                } else {
                    Swal.fire(
                        'Error!',
                        error,
                        'error'
                    )
                }
            })


            $(".removeAddress").on("click", function() {
                var id = $(this).data("id");
                var th = $(this);
                Swal.fire({
                    title: 'Are you sure ?',
                    text: "Do you really want to remove this address ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Remove it!',
                    cancelButtonText: 'No, Cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "cart_helper",
                            method: "POST",
                            data: {
                                removeAddress: id,
                            },
                            success: function(data) {
                                if (data.trim() == '1') {
                                    th.parent().parent().parent().remove();
                                    Swal.fire(
                                        'Success!',
                                        "Address removed successfully",
                                        'success'
                                    )
                                } else {
                                    console.log(data);
                                    Swal.fire(
                                        'Error!',
                                        "Can't remove address at the moment",
                                        'error'
                                    )
                                }
                            }
                        })
                    }
                })
            })

        })
    </script>
</body>

</html>