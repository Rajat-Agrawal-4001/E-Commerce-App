<?php
session_start();
include 'config/connection.php';
unset($_SESSION['APPLIED_COUPON']);

//$_SESSION['vendor_id']=1;

?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">

<!-- /cart.html / [XR&CO'2014],  19:56:36 GMT -->
<?php include 'template_head.php'; ?>

<body>
    <!--================= Preloader Section Start Here =================-->
    <div id="weiboo-load">
        <div class="preloader-new">
            <svg class="cart_preloader" role="img" aria-label="Shopping cart_preloader line animation" viewBox="0 0 128 128" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8">
                    <g class="cart__track" stroke="hsla(0,10%,10%,0.1)">
                        <polyline points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80" />
                        <circle cx="43" cy="111" r="13" />
                        <circle cx="102" cy="111" r="13" />
                    </g>
                    <g class="cart__lines" stroke="currentColor">
                        <polyline class="cart__top" points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80" stroke-dasharray="338 338" stroke-dashoffset="-338" />
                        <g class="cart__wheel1" transform="rotate(-90,43,111)">
                            <circle class="cart__wheel-stroke" cx="43" cy="111" r="13" stroke-dasharray="81.68 81.68" stroke-dashoffset="81.68" />
                        </g>
                        <g class="cart__wheel2" transform="rotate(90,102,111)">
                            <circle class="cart__wheel-stroke" cx="102" cy="111" r="13" stroke-dasharray="81.68 81.68" stroke-dashoffset="81.68" />
                        </g>
                    </g>
                </g>
            </svg>
        </div>
    </div>
    <!--================= Preloader End Here =================-->

    <div class="anywere"></div>

    <!--================= Header Section Start Here =================-->
    <?php include 'header3.php'; ?>
    <!--================= Header Section End Here =================-->

    <!--================= Cart Section Start Here =================-->
    <div class="rts-cart-section">
        <div class="container">
            <h4 class="section-title">Product List</h4>
            <div class="row justify-content-between">
                <div class="col-xl-7">
                    <div class="cart-table-area">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                            </thead>
                            <tbody>
                                <?php
                                $total_mrp = $total_discount = 0;
                                $row_counter = 0;

                                /*$qry = "SELECT * FROM iframe_register WHERE `selected_site_id` = '$this_site_id' ORDER BY id DESC ";
                            $res = mysqli_query($conn, $qry);
                            $data = mysqli_fetch_assoc($res);

                            if (!isset($data['id'])) {
                                die("Invalid Request");
                            }
                            $this_site_id = $data['site_id'];
*/
                                if (isset($_SESSION['vendor_id'])  ||  isset($_SESSION['user_id'])) {
                                    $vid = -1;
                                    if (isset($_SESSION['vendor_id'])) {
                                        $vid = $_SESSION['vendor_id'];
                                    } else if (isset($_SESSION['user_id'])) {
                                        $vid = $_SESSION['user_id'];
                                    }

                                    $qry = "SELECT * from cart_n_wishlist where save_type = 'CART' AND vendor_id = '" . $vid . "' AND quantity > 0 AND save_status = '1' AND site_id = '$this_site_id' order by created_date desc ";
                                    $res = mysqli_query($conn, $qry);
                                    if (!$res) {
                                        errlog(mysqli_error($conn), $qry);
                                    }
                                    $in_cart = mysqli_fetch_all($res, MYSQLI_ASSOC);

                                    foreach ($in_cart as $item) {
                                        $qry = "";
                                        $marketplace_id = -1;
                                        $redirect_link = "#";
                                        switch (strtoupper($item['marketplace_id'])) {
                                            case '5':
                                                $marketplace_id = 5;
                                                $redirect_link = 'product_detail?pid=' . urlencode(base64_encode($item['item_id'])) . '&var='  . urlencode(base64_encode($item['variant_id']));

                                                $qry = "SELECT *, marketplace_products.id as prod_id, product_variants.id as var_id from marketplace_products, product_variants where marketplace_products.id = '" . $item['item_id'] . "' AND product_variants.id = '" . $item['variant_id'] . "' ";
                                                break;
                                            case '16':
                                                $marketplace_id = 16;
                                                $redirect_link = 'servicedetail?id=' . urlencode(base64_encode($item['item_id']));
                                                $bundle = $item['bundle'];
                                                $qry = "SELECT *, marketplace_services.id as prod_id from marketplace_services where id = '" . $item['item_id'] . "' ";
                                                break;
                                            default:
                                                die("Unknown Marketplace");
                                        }

                                        $res = mysqli_query($conn, $qry);
                                        if (!$res) {
                                            errlog(mysqli_error($conn), $qry);
                                        }

                                        $item_det = mysqli_fetch_assoc($res);

                                        if (isset($bundle)  &&  $bundle == '1') {
                                            $flag = 0;
                                            $idd = $item_det['prod_id'];
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

                                            if ($flag > 0) {
                                                $item_det['service_name'] .= " +" . $flag . " more";
                                            }
                                        }

                                        $main_image = 'x';
                                        $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '0' AND marketplace_id = '" . $item['marketplace_id'] . "' AND type = 'IMAGE' ";
                                        if (isset($item_det['var_id']) && $item_det['var_id'] != '') {
                                            $qry .= " AND variant_id = '" . $item_det['var_id'] . "'";
                                        }
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

                                        if ($item['variant_id'] != '') {
                                            $qry = "SELECT * from product_images where main = 0 AND product_id = '" . $item['item_id'] . "' AND variant_id = '" . $item['variant_id'] . "' AND marketplace_id = 5 ";
                                            $res = mysqli_query($conn, $qry);
                                            if (!$res) {
                                                errlog(mysqli_error($conn), $qry);
                                            }

                                            $res = mysqli_fetch_assoc($res);
                                            if (isset($res['id'])) {
                                                $main_image = $res['image_url'];
                                            }
                                        }
                                        $row_counter++;
                                ?>
                                        <?php
                                        $price = $item_det['price'];
                                        $qry = "
                                            SELECT
                                                (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,
                                                
                                                (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
                                                
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
                                        <tr>
                                            <td>
                                                <div class="product-thumb"><img src="<?php echo $main_image ?>" alt="product-thumb" height="100px" width="100px"></div>
                                            </td>
                                            <td class="product-price">
                                                <span class="product-price">&#8377; <?= htmlspecialchars($item_det['price']); ?> </span>
                                            </td>
                                            <td>
                                                <div class="product-title-area">
                                                    <span class="pretitle">Nighty</span>
                                                    <h4 class="product-title"><?php
                                                                                switch ($marketplace_id) {
                                                                                    case 5:
                                                                                        echo htmlspecialchars($item_det['product_title']);
                                                                                        break;
                                                                                    case 16:
                                                                                        echo htmlspecialchars($item_det['service_name']);
                                                                                        break;
                                                                                }
                                                                                ?></h4>
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><span class="product-price amountBlock"><?php

                                                                                                                    $total_mrp += $item_det['price'] * $item['quantity'];
                                                                                                                    if ($discount > 0) {
                                                                                                                        echo "&#8377; " . htmlspecialchars(round($item_det['price'] * $item['quantity'] - ($discount), 2));
                                                                                                                    } else {
                                                                                                                        echo "&#8377; " . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                                                                    }
                                                                                                                    ?></span><br>
                                                <span class="amount discountBlock" style="margin: 1rem; color: grey; background-color: #dddddd;">
                                                    <del>
                                                        <?php
                                                        if ($discount > 0) {
                                                            echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                        }
                                                        ?>
                                                    </del>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="cart-edit">
                                                    <div class="quantity-edit">
                                                        <button class="button quantity-minus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                            echo $item_det['var_id'];
                                                                                                        } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>"><i class="fal fa-minus minus"></i></button>
                                                        <input type="text" class="input prodQuantity" value="<?php echo (int)$item['quantity'] ?>" />
                                                        <button class="button plus quantity-plus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                echo $item_det['var_id'];
                                                                                                            } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>">+<i class="fal fa-plus plus"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="last-td"><button class="remove-btn removeItem" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>">Remove</button></td>
                                        </tr>
                                        <?php
                                    }
                                } else if (isset($_COOKIE['guestCart'])  &&  isset($_COOKIE['guestCartQuantity'])) {

                                    $all_data = unserialize($_COOKIE['guestCart']);
                                    $all_quantities = unserialize($_COOKIE['guestCartQuantity']);

                                    foreach ($all_data as $marketplace_id => $prods) {

                                        if ($marketplace_id == 16) {
                                            foreach (explode(',', $prods) as $id) {
                                                if ($id == '')    continue;
                                                $qry = "SELECT * FROM marketplace_services where id = '" . realEscape($id) . "' AND status = 1 AND verified = 1 AND save_type = 'ORG' AND site_id = '$this_site_id' ";
                                                $res = mysqli_query($conn, $qry);
                                                if (!$res) {
                                                    errlog(mysqli_error($conn), $qry);
                                                }
                                                $item_det = mysqli_fetch_assoc($res);
                                                if (!isset($item_det['id']))   continue;

                                                $row_counter++;

                                        ?>
                                                <?php
                                                $price = $item_det['price'];
                                                $qry = "
                                                            SELECT
                                                                (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,
                                                                
                                                                (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
                                                                
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
                                                <tr>
                                                    <td>
                                                        <div class="product-thumb"><img src="<?php echo $main_image ?>" alt="product-thumb" height="100px" width="100px"></div>
                                                    </td>
                                                    <td class="product-price">
                                                        <span class="product-price">&#8377; <?= htmlspecialchars($item_det['price']); ?> </span>
                                                    </td>
                                                    <td>
                                                        <div class="product-title-area">
                                                            <span class="pretitle">Nighty</span>
                                                            <h4 class="product-title"><?php
                                                                                        switch ($marketplace_id) {
                                                                                            case 5:
                                                                                                echo htmlspecialchars($item_det['product_title']);
                                                                                                break;
                                                                                            case 16:
                                                                                                echo htmlspecialchars($item_det['service_name']);
                                                                                                break;
                                                                                        }
                                                                                        ?></h4>
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal"><span class="product-price amountBlock"><?php

                                                                                                                            $total_mrp += $item_det['price'] * $item['quantity'];
                                                                                                                            if ($discount > 0) {
                                                                                                                                echo "&#8377; " . htmlspecialchars(round($item_det['price'] * $item['quantity'] - ($discount), 2));
                                                                                                                            } else {
                                                                                                                                echo "&#8377; " . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                                                                            }
                                                                                                                            ?></span>
                                                        <br>
                                                        <span class="amount discountBlock" style="margin: 1rem; color: grey; background-color: #dddddd;">
                                                            <del>
                                                                <?php
                                                                if ($discount > 0) {
                                                                    echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                }
                                                                ?>
                                                            </del>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="cart-edit">
                                                            <div class="quantity-edit">
                                                                <button class="button quantity-minus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                    echo $item_det['var_id'];
                                                                                                                } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>"><i class="fal fa-minus minus"></i></button>
                                                                <input type="text" class="input prodQuantity" value="<?php echo (int)$item['quantity'] ?>" />
                                                                <button class="button plus quantity-plus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                        echo $item_det['var_id'];
                                                                                                                    } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>">+<i class="fal fa-plus plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="last-td"><button class="remove-btn removeItem" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>">Remove</button></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {

                                            foreach ($all_data[$marketplace_id] as $item_id => $items) {
                                                $qry = "";

                                                foreach (explode(",", $items) as $vars) {
                                                    if ($vars == '') continue;
                                                    $item = array('marketplace_id' => $marketplace_id, 'item_id' => $item_id, 'variant_id' => $vars, 'quantity' => $all_quantities[$marketplace_id][$item_id][$vars]);


                                                    switch ($marketplace_id) {
                                                        case '5':
                                                            $marketplace_id = 5;
                                                            $qry = "SELECT *, marketplace_products.id as prod_id, product_variants.id as var_id from marketplace_products, product_variants where marketplace_products.id = '" . $item['item_id'] . "' AND product_variants.id = '" . $item['variant_id'] . "' AND marketplace_products.site_id = '$this_site_id' ";
                                                            break;
                                                        case '13':
                                                            break;
                                                        default:
                                                            die("Unknown Marketplace");
                                                    }

                                                    $res = mysqli_query($conn, $qry);
                                                    if (!$res) {
                                                        errlog(mysqli_error($conn), $qry);
                                                    }

                                                    $item_det = mysqli_fetch_assoc($res);

                                                    if (isset($bundle)  &&  $bundle == '1') {
                                                        $flag = 0;
                                                        $idd = $item_det['prod_id'];
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

                                                        if ($flag > 0) {
                                                            $item_det['service_name'] .= " +" . $flag . " more";
                                                        }
                                                    }

                                                    $main_image = 'x';
                                                    $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '0' AND type = 'IMAGE' ";
                                                    $res = mysqli_query($conn, $qry);
                                                    if (!$res) {
                                                        errlog(mysqli_error($conn), $qry);
                                                    }

                                                    $res = mysqli_fetch_assoc($res);
                                                    if (isset($res['id'])) {
                                                        $main_image = $res['image_url'];
                                                    }

                                                    if ($item['variant_id'] != '') {
                                                        $qry = "SELECT * from product_images where main = '0' AND product_id = '" . $item['item_id'] . "' AND variant_id = '" . $item['variant_id'] . "' AND marketplace_id = 5 ";
                                                        $res = mysqli_query($conn, $qry);
                                                        if (!$res) {
                                                            errlog(mysqli_error($conn), $qry);
                                                        }

                                                        $res = mysqli_fetch_assoc($res);
                                                        if (isset($res['id'])) {
                                                            $main_image = $res['image_url'];
                                                        }
                                                    }
                                                    $row_counter++;
                                                ?>
                                                    <?php
                                                    $price = $item_det['price'];
                                                    $qry = "
                                                            SELECT
                                                                (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,
                                                                
                                                                (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
                                                                
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
                                                    <tr>
                                                        <td>
                                                            <div class="product-thumb"><img src="<?php echo $main_image ?>" alt="product-thumb" height="100px" width="100px"></div>
                                                        </td>
                                                        <td class="product-price">
                                                            <span class="product-price">&#8377; <?= htmlspecialchars($item_det['price']); ?> </span>
                                                        </td>
                                                        <td>
                                                            <div class="product-title-area">
                                                                <span class="pretitle">Nighty</span>
                                                                <h4 class="product-title"><?php
                                                                                            switch ($marketplace_id) {
                                                                                                case 5:
                                                                                                    echo htmlspecialchars($item_det['product_title']);
                                                                                                    break;
                                                                                                case 16:
                                                                                                    echo htmlspecialchars($item_det['service_name']);
                                                                                                    break;
                                                                                            }
                                                                                            ?></h4>
                                                            </div>
                                                        </td>
                                                        <td class="product-subtotal"><span class="product-price amountBlock"><?php

                                                                                                                                $total_mrp += $item_det['price'] * $item['quantity'];
                                                                                                                                if ($discount > 0) {
                                                                                                                                    echo "&#8377; " . htmlspecialchars(round($item_det['price'] * $item['quantity'] - ($discount), 2));
                                                                                                                                } else {
                                                                                                                                    echo "&#8377; " . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                                                                                }
                                                                                                                                ?></span>
                                                            <br>
                                                            <span class="amount discountBlock" style="margin: 1rem; color: grey; background-color: #dddddd;">
                                                                <del>
                                                                    <?php
                                                                    if ($discount > 0) {
                                                                        echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                    }
                                                                    ?>
                                                                </del>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="cart-edit">
                                                                <div class="quantity-edit">
                                                                    <button class="button quantity-minus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                        echo $item_det['var_id'];
                                                                                                                    } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>"><i class="fal fa-minus minus"></i></button>
                                                                    <input type="text" class="input prodQuantity" value="<?php echo (int)$item['quantity'] ?>" />
                                                                    <button class="button plus quantity-plus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                            echo $item_det['var_id'];
                                                                                                                        } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>">+<i class="fal fa-plus plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="last-td"><button class="remove-btn removeItem" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>">Remove</button></td>
                                                    </tr>
                                    <?php

                                                }
                                            }
                                        }
                                    }
                                }

                                if ($row_counter == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <h2>Cart is Empty</h2>
                                            </center>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        <div class="coupon-apply">
                            <span class="coupon-text">Coupon Code:</span>
                            <div class="apply-input">
                                <input type="text" id="couponCode" name="coupon_code" placeholder="Apply coupon here">
                                <button type="button" class="apply-btn applyCouponBtn">Apply </i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="checkout-box">
                        <div class="checkout-box-inner">
                            <div class="subtotal-area">
                                <span class="title">Subtotal</span>
                                <span class="subtotal-price" id="subTotal">Rs <?php echo round($total_mrp, 2) ?></span>
                            </div>
                            <div class="subtotal-area">
                                <span class="title">Item Discount</span>
                                <span class="subtotal-price" id="itemDiscount">Rs <?php echo round($total_discount, 2) ?></span>
                            </div>
                            <div class="subtotal-area">
                                <span class="title">Coupon Discount</span>
                                <span class="subtotal-price" id="couponDiscountPreview">0 -/</span>
                            </div>
                            <!--div class="shipping-location">
                                <span class="shipping-to">Shipping to <span>NY.</span></span>
                                <span class="change-address"><i class="fal fa-map-marker-alt mr--5"></i>Change address</span>
                            </div-->
                            <div class="total-area">
                                <span class="title">Total</span>
                                <span class="total-price" id="grandTotal">Rs <?php echo round($total_mrp - $total_discount, 2) ?></span>
                            </div>
                        </div>
                        <?php
                        if (getVendorID() > 0) {
                        ?>
                            <a href="client-checkout.php" class="procced-btn checkoutBtn">Proceed to Checkout</a>
                        <?php
                        } else {
                        ?>
                            <a href="#" class="procced-btn checkoutBtn">Proceed to Checkout</a>
                        <?php
                        }
                        ?>
                        <a href="shop.php" class="continue-shopping"><i class="fal fa-long-arrow-left"></i> Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--================= Cart Section End Here =================-->


    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->



    <script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <!--================= Scroll to Top Start =================-->

    <script>
        $(document).ready(function() {

            <?php

            if (getVendorID() == -1) {
            ?>
                $(".checkoutBtn").on("click", function() {
                    Swal.fire("Error", "Please Login And Try Again...", "error");
                })
            <?php
            }

            ?>

            var total_price = parseFloat('<?php echo $total_mrp ?>');
            var couponDiscount = 0;

            $(".applyCouponBtn").on("click", function() {
                var coupon = $("#couponCode").val();
                couponDiscount = 0;
                $("#couponCodePreview").html("--NA--");
                $("#couponDiscountPreview").html("0-/");
                $.ajax({
                    url: "cart_helper",
                    method: "POST",
                    data: {
                        applyCouponCode: coupon,
                        price: total_price,
                    },
                    success: function(data) {
                        console.log(data);
                        data = $.parseJSON(data);
                        if (data.success) {
                            $("#couponCodePreview").html(coupon.toUpperCase());
                            couponDiscount = data.discount;
                            $("#couponDiscountPreview").html(couponDiscount + "-/");
                            Swal.fire("Coupon Applied", "", "success");
                        } else {
                            Swal.fire("Error", "Invalid Coupon", "error");
                        }
                        updateInvoice();
                    }
                })
            })

            $(".removeItem").on("click", function() {
                var id = $(this).data("id");
                var var_id = $(this).data("var");
                var type = $(this).data("type");
                var th = $(this);
                Swal.fire({
                    icon: "question",
                    title: "Confirmation",
                    text: "Do you really want to remove this item from your cart ?",
                    showConfirmButton: true,
                    confirmButtonText: "Yes, Remove it",
                    showDenyButton: true,
                    denyButtonText: "No",
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "cart_helper",
                            method: "post",
                            data: {
                                removeItem: id,
                                var_id,
                                type,
                            },
                            success: function(data) {
                                if (data.trim() == '1') {
                                    Swal.fire("Removed", "Item removed from cart!", "success");
                                    $(th).parent().parent().remove();
                                } else {
                                    console.log(data);
                                    Swal.fire("Error", "Something went wrong", "error");
                                }
                            }
                        })
                    }
                })
            })



            function updateInvoice() {
                var price = 0;
                var discount = 0;
                let p = 0,
                    d = 0;
                $(".quantity-plus").each(function() {

                    p = parseFloat($(this).data("price"));
                    d = parseFloat($(this).data("discount"));

                    var q = $(this).parent().children(".prodQuantity").val();

                    p *= q;
                    d *= q;

                    price += p;
                    discount += d;
                });

                total_price = price.toFixed(2);
                $("#subTotal").html((price).toFixed(2));
                $("#itemDiscount").html(discount.toFixed(2));
                $("#grandTotal").html((price - (discount + couponDiscount)).toFixed(2));

            }

            updateInvoice();


            $(".quantity-plus").on("click", function() {
                // console.log("Plus");


                var curr = $(this).parent().children(".prodQuantity").val();

                var id = $(this).data("prod");
                var type = $(this).data("type");
                var price = parseFloat($(this).data("price"));
                var discount = parseFloat($(this).data("discount"));

                var v = '';
                if ($(this).data("var")) {
                    v = $(this).data("var");
                }
                var th = $(this);
                // $(th).parent().parent().parent().parent().parent().siblings(".priceBlock").children("div").children("div").children(".discountBlock").children("del");
                // return;

                $.ajax({
                    url: "cart_helper",
                    method: "POST",
                    data: {
                        updateQuantity: "increase",
                        item: id,
                        type: type,
                        variant: v,
                        curr: curr,
                    },
                    success: function(data) {
                        if (data.trim() == 'out') {
                            Swal.fire("Stock limit reached for this item", "", "info");
                            return;
                        }

                        // console.log(data);

                        $(th).prev().val(parseInt($(th).prev().val()) + 1);

                        if (((parseInt(curr) + 1) * (parseFloat(price))).toFixed(2) > ((parseInt(curr) + 1) * (parseFloat(price)) - parseFloat(discount)).toFixed(2)) {
                            $(th).parent().parent().parent().siblings(".product-subtotal").children(".discountBlock").children("del").html("&#8377; " + ((parseInt(curr) + 1) * (parseFloat(price))).toFixed(2));
                        }


                        $(th).parent().parent().parent().siblings(".product-subtotal").children(".amountBlock").html("&#8377; " + (((parseInt(curr) + 1) * (parseFloat(price) - parseFloat(discount)))).toFixed(2));
                        updateInvoice();
                    }
                })
            })

            $(".quantity-minus").on("click", function() {
                // console.log("Minus");
                var curr = $(this).parent().children(".prodQuantity").val();


                if (curr <= 1) {
                    return;
                }

                $(this).prev().val(parseInt($(this).prev().val()) + 1);
                var id = $(this).data("prod");
                var type = $(this).data("type");
                var price = parseFloat($(this).data("price"));
                var discount = parseFloat($(this).data("discount"));


                var v = '';
                if ($(this).data("var")) {
                    v = $(this).data("var");
                }

                var th = $(this);

                $(this).siblings(".prodQuantity").each(function() {
                    $(this).val(curr - 1);
                });

                $.ajax({
                    url: "cart_helper",
                    method: "POST",
                    data: {
                        updateQuantity: "decrease",
                        item: id,
                        type: type,
                        variant: v,
                    },
                    success: function(data) {
                        if (((parseInt(curr) - 1) * (parseFloat(price))).toFixed(2) > ((parseInt(curr) - 1) * (parseFloat(price)) - parseFloat(discount)).toFixed(2)) {
                            $(th).parent().parent().parent().siblings(".product-subtotal").children(".discountBlock").children("del").html("&#8377; " + ((parseInt(curr) - 1) * (parseFloat(price))).toFixed(2));
                        }

                        $(th).parent().parent().parent().siblings(".product-subtotal").children(".amountBlock").html("&#8377; " + (((parseInt(curr) - 1) * (parseFloat(price) - parseFloat(discount)))).toFixed(2));

                        updateInvoice();
                    }
                })
            })
        })
    </script>

</body>


<!-- /cart.html / [XR&CO'2014],  19:56:37 GMT -->

</html>