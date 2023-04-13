<?php
session_start();
include 'config/connection.php';
include 'modify_cart_n_wishlist.php';


if (isset($_POST['item']) && isset($_POST['variant_id'])) {

    $item_id = realEscape($_POST['item']);
    $variant_id = realEscape($_POST['variant_id']);

    $result = modify_cart_n_wishlist('5', $item_id, 'CART', false, $variant_id);

    echo $result;

    die;
}
if (isset($_POST['removeItem']) && isset($_POST['var_id']) && isset($_POST['type'])) {

    $item_id = realEscape($_POST['removeItem']);
    $variant_id = realEscape($_POST['var_id']);
    $type = realEscape($_POST['type']);

    if (modify_cart_n_wishlist((int)($type), (int)($item_id), 'WISHLIST', true, (int)($variant_id))) {
        echo "1";
    } else {
        echo "0";
    }

    die;
}
?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /wishlist.html / [XR&CO'2014],  19:56:50 GMT -->
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
    <?php include 'header.php'; ?>
    <!--================= Header Section End Here =================-->

    <!--================= Cart Section Start Here =================-->
    <div class="rts-wishlist-section section-gap">
        <div class="container">
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr class="heading">
                        <th></th>
                        <th>Product Name</th>
                        <th>Unit Price</th>
                        <th>Stock Status</th>
                        <th></th>
                    </tr>
                </tbody>
                <tbody>
                    <?php
                    $total_mrp = $total_discount = 0;
                    $row_counter = 0;
                    $i = 0;

                    if (isset($_SESSION['vendor_id'])  ||  isset($_SESSION['user_id'])) {
                        $vid = -1;
                        if (isset($_SESSION['vendor_id'])) {
                            $vid = $_SESSION['vendor_id'];
                        } else if (isset($_SESSION['user_id'])) {
                            $vid = $_SESSION['user_id'];
                        }

                        $qry = "SELECT * from cart_n_wishlist where save_type = 'WISHLIST' AND vendor_id = '" . $vid . "' AND quantity > 0 AND save_status = '1' AND site_id = '$this_site_id' order by created_date desc ";
                        $res = mysqli_query($conn, $qry);
                        if (!$res) {
                            errlog(mysqli_error($conn), $qry);
                        }
                        $in_cart = mysqli_fetch_all($res, MYSQLI_ASSOC);

                        foreach ($in_cart as $item) {
                            $i++;
                            $qry = "";
                            $marketplace_id = -1;
                            $redirect_link = "#";
                            switch (strtoupper($item['marketplace_id'])) {
                                case '5':
                                    $marketplace_id = 5;
                                    $redirect_link = 'product_detail.php?id=' . urlencode(base64_encode($item['item_id'])) . '&vid='  . urlencode(base64_encode($item['variant_id']));

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
                            $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND variant_id = '" . $item_det['var_id'] . "' AND main = '0' AND marketplace_id = '" . $item['marketplace_id'] . "' AND type = 'IMAGE' ";
                            $res = mysqli_query($conn, $qry);
                            if (!$res) {
                                errlog(mysqli_error($conn), $qry);
                            }

                            $res = mysqli_fetch_assoc($res);
                            if (isset($res['id'])) {
                                $main_image = $res['image_url'];
                            } else {
                                $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '1' AND type = 'IMAGE' AND marketplace_id = 5";
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
                            $discount = $discount;

                            $total_discount += $discount;

                            ?>
                            <tr id="row<?= $i ?>">
                                <td class="first-td"><button id="<?= $i ?>" data-prod="<?php echo $item['item_id']; ?>" data-var="<?php echo $item['variant_id']; ?>" data-type="<?php echo $item['marketplace_id']; ?>" class="remove-btn removeWish"><i class="fal fa-times"></i></button></td>
                                <td class="first-child"><a href="product-details.php?id=<?php echo $item['item_id']; ?>"><img src="<?php echo $main_image; ?>" alt="" style="max-width: 100px; max-height: 100px;"></a>
                                    <a href="product-details.php?id=<?php echo $item['item_id']; ?>" class="pretitle"><?= htmlspecialchars($item_det['product_title']); ?> </a>
                                </td>
                                </td>
                                <td><span class="product-price">Rs <?= htmlspecialchars($item_det['price']); ?>.00</span></td>
                                <td class="stock"><?php if ($item_det['available'] == 1) {
                                                        echo "In Stock";
                                                    }
                                                    if ($item_det['available'] == 0) {
                                                        echo "Out of Stock";
                                                    }
                                                    ?></td>
                                </td>
                                <td class="last-td"><button class="cart-btn" data-vid="<?php echo $item['variant_id']; ?>" value="<?php echo $item['item_id']; ?>" onclick="addCart(this)"><i class="rt-basket-shopping"></i> Add To
                                        Cart</button></td>
                            </tr>
                            <?php
                        }
                    } else if (isset($_COOKIE['guestWishlist'])) {

                        $all_data = unserialize($_COOKIE['guestWishlist']);

                        foreach ($all_data as $marketplace_id => $prods) {
                            foreach ($all_data[$marketplace_id] as $item_id => $items) {
                                $qry = "";

                                foreach (explode(",", $items) as $vars) {
                                    $i++;
                                    if ($vars == '') continue;
                                    $item = array('marketplace_id' => $marketplace_id, 'item_id' => $item_id, 'variant_id' => $vars);


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
                                    $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '0' AND type = 'IMAGE' AND marketplace_id = 5 AND variant_id = '" . $item['variant_id'] . "'";
                                    $res = mysqli_query($conn, $qry);
                                    if (!$res) {
                                        errlog(mysqli_error($conn), $qry);
                                    }

                                    $res = mysqli_fetch_assoc($res);
                                    if (isset($res['id'])) {
                                        $main_image = $res['image_url'];
                                    }

                                    if ($item['variant_id'] != '') {
                                        $qry = "SELECT * from product_images where main = '1' AND product_id = '" . $item['item_id'] . "' AND variant_id = '" . $item['variant_id'] . "' AND marketplace_id = 5 ";
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
                                    $discount = $discount;

                                    $total_discount += $discount;

                                    ?>
                                    <tr id="row<?= $i ?>">
                                        <td class="first-td"><button id="<?= $i ?>" data-prod="<?php echo $item['item_id']; ?>" data-var="<?php echo $item['variant_id']; ?>" data-type="<?php echo $item['marketplace_id']; ?>" class="remove-btn removeWish"><i class="fal fa-times"></i></button></td>
                                        <td class="first-child"><a href="product-details.php?id=<?php echo $item['item_id']; ?>"><img src="<?php echo $main_image; ?>" alt="" style="max-width: 100px; max-height: 100px;"></a>
                                            <a href="product-details.php?id=<?php echo $item['item_id']; ?>" class="pretitle"><?= htmlspecialchars($item_det['product_title']); ?> </a>
                                        </td>
                                        </td>
                                        <td><span class="product-price">Rs <?= htmlspecialchars($item_det['price']); ?>.00</span></td>
                                        <td class="stock"><?php if ($item_det['available'] == 1) {
                                                                echo "In Stock";
                                                            }
                                                            if ($item_det['available'] == 0) {
                                                                echo "Out of Stock";
                                                            }
                                                            ?></td>
                                        </td>
                                        <td class="last-td"><button class="cart-btn" data-vid="<?php echo $item['variant_id']; ?>" value="<?php echo $item['item_id']; ?>" onclick="addCart(this)"><i class="rt-basket-shopping"></i> Add To
                                                Cart</button></td>
                                    </tr>
                        <?php

                                }
                            }
                        }
                    }


                    if ($row_counter == 0) {
                        ?>
                        <tr>
                            <td colspan="5">
                                <center>
                                    <h2>Wish List is Empty</h2>
                                </center>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <?php if (!isset($_COOKIE['guestWishlist'])) {
                    ?>

                        <tr>
                            <td class="first-td"><button class="remove-btn"><i class="fal fa-times"></i></button></td>
                            <td class="first-child"><a href="product-details.html"><img src="assets/images/products/inner/cart/1.jpg" alt=""></a>
                                <a href="product-details.html" class="pretitle">Travel Large Trifold Wallet</a>
                            </td>
                            </td>
                            <td><span class="product-price">$99.00</span></td>
                            <td class="stock">In Stock</td>
                            </td>
                            <td class="last-td"><button class="cart-btn"><i class="rt-basket-shopping"></i> Add To
                                    Cart</button></td>
                        </tr>
                        <tr>
                            <td class="first-td"><button class="remove-btn"><i class="fal fa-times"></i></button></td>
                            <td class="first-child"><a href="product-details.html"><img src="assets/images/products/inner/cart/2.jpg" alt=""></a>
                                <a href="product-details.html" class="pretitle">Travel Large Trifold Wallet</a>
                            </td>
                            <td><span class="product-price">$99.00</span></td>
                            <td class="stock">In Stock</td>
                            <td class="last-td"><button class="cart-btn"><i class="rt-basket-shopping"></i> Add To
                                    Cart</button></td>
                        </tr>
                        <tr>
                            <td class="first-td"><button class="remove-btn"><i class="fal fa-times"></i></button></td>
                            <td class="first-child"><a href="product-details.html"><img src="assets/images/products/inner/cart/3.jpg" alt=""></a>
                                <a href="product-details.html" class="pretitle">Travel Large Trifold Wallet</a>
                            </td>
                            <td><span class="product-price">$99.00</span></td>
                            <td class="stock1">Out Of Stock</td>
                            <td class="last-td"><button class="cart-btn1"><i class="rt-basket-shopping"></i> Add to
                                    Cart</button></td>
                        </tr>
                        <tr>
                            <td class="first-td"><button class="remove-btn"><i class="fal fa-times"></i></button></td>
                            <td class="first-child"><a href="product-details.html"><img src="assets/images/products/inner/cart/4.jpg" alt=""></a>
                                <a href="product-details.html" class="pretitle">Travel Large Trifold Wallet</a>
                            </td>
                            <td><span class="product-price">$99.00</span></td>
                            <td class="stock">In Stock</td>
                            <td class="last-td"><button class="cart-btn"><i class="rt-basket-shopping"></i> Add To
                                    Cart</button></td>
                        </tr>
                    <?php } ?>


                </tbody>
            </table>
            <div class="wishlist-social">
                <div class="text">
                    <a href="#">Share Now</a>
                </div>
                <div class="icon">
                    <ul>
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-behance"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--================= Cart Section End Here =================-->


    <!--================= Footer Start Here =================-->

    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->




    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->

    <!--================= Jquery latest version =================-->
    <?php include 'common_scripts.php'; ?>
    <script>
        function addWishlist(e) {
            let id = e.getAttribute("value");
            let variant = $(e).data("variant");
            //   alert(id+variant);
            $.ajax({
                method: "POST",
                data: {
                    wish: id,
                    variant: variant
                },
                success: function(data) {
                    Swal.fire("Item Added in Wishlist.", "", "success");
                }
            })
        }



        function addCart(e) {
            let id = e.getAttribute("value");
            let v_id = $(e).data("vid");

            $.ajax({
                method: "POST",
                data: {
                    item: id,
                    variant_id: v_id
                },
                success: function(data) {
                    if (data == '1') {
                        Swal.fire("Item added in Cart.", "", "success");
                    } else if (data == '0') {
                        Swal.fire("Not Added.", "", "error");
                    } else {
                        Swal.fire(data, "", "success");
                    }

                }
            })
        }


        $(".removeWish").on("click", function() {
            var id = $(this).data("prod");
            var var_id = $(this).data("var");
            var type = $(this).data("type");
            var th = $(this);

            Swal.fire({
                icon: "question",
                title: "Confirmation",
                text: "Do you really want to remove this item from your Wish List ?",
                showConfirmButton: true,
                confirmButtonText: "Yes, Remove it",
                showDenyButton: true,
                denyButtonText: "No",
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "post",
                        data: {
                            removeItem: id,
                            var_id: var_id,
                            type: type
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
    </script>

</body>


<!-- /wishlist.html / [XR&CO'2014],  19:56:50 GMT -->

</html>