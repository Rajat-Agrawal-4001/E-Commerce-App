<header id="rtsHeader">
    <div class="header-topbar header-topbar2 header-topbar5">
        <div class="container header-container">
            <div class="header-top-inner">
                <h3 class="welcome-text">35% Exclusive discount plus free next day delivery, <a href="shop" class="value">Excludes Sale <i class="fal fa-long-arrow-right"></i></a></h3>
                <div class="topbar-action">
                    <div class="close">CLose <i class="fal fa-times"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-topbar header-topbar2 header-lower-topbar header-lower-topbar5">
        <div class="container header-container">
            <div class="header-top-inner">
                <ul class="topbar-navs">
                    <li><a href="about">About Us</a></li>
                    <li><a href="account">My Account</a></li>
                    <li><a href="wishlist">Wishlist</a></li>
                    <li><a href="order">Order Tracking</a></li>
                </ul>
                <div class="topbar-select-area">
                    <select class="topbar-select custom-select">
                        <option value="eng">English</option>
                        <option value="esp">español</option>
                        <option value="ban">Bangla</option>
                    </select>
                    <select class="topbar-select custom-select">
                        <option value="usd">USD</option>
                        <option value="eur">Euro</option>
                        <option value="tk">Taka</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-wrap">
        <div class="navbar-part navbar-part3 navbar-part5">
            <div class="container header-container">
                <div class="navbar-inner navbar-inner2">
                    <a href="#" class="logo"><img src="<?= htmlspecialchars($site_row['site_logo']); ?>" alt="weiboo-logo" height="50px" width="50px"></a>
                    <div class="navbar-search-area">
                        <div class="search-input-inner">
                            <div class="input-div">
                                <form action="shop.php" id="search_form" method="post">
                                    <button type="submit" class="search-input-icon icon2"><i class="rt-search mr--10"></i></button>
                                    <input class="search-input" type="text" value="" name="keyword" id="keyword" placeholder="Search Keyword...">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="header-action-items header-action-items1">
                        <!-- <div class="search-part">
                            <div class="search-icon action-item icon"><i class="rt-search"></i></div>
                            <div class="search-input-area">
                                <div class="container">
                                    <div class="search-input-inner inner-2">
                                        <div class="input-div">
                                            <input class="search-input" type="text" placeholder="Search by keyword or #">
                                        </div>
                                        <div class="search-close-icon"><i class="rt-xmark"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="cart action-item">
                            <div class="cart-nav">
                                <div class="cart-icon icon"><i class="rt-cart"></i><span class="wishlist-dot icon-dot">3</span></div>
                            </div>
                        </div>
                        <div class="wishlist action-item">
                            <div class="favourite-icon icon"><a href="wishlist"><i class="rt-heart"></i></a>
                            </div>
                        </div>
                        <a href="#" class="account" data-toggle="modal" data-target="#myModal"><i class="rt-user-2"></i></a>
                    </div>
                    <div class="hamburger"><span></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-sticky lower-navbar-sticky lower-navbar-sticky5">
        <div class="container header-container">
            <div class="navbar-part navbar-part2 lower-navbar lower-navbar5">
                <div class="navbar-inner">
                    <a href="index.html" class="logo"><img src="assets/images/logo2.svg" alt="umart-logo"></a>
                    <div class="catagory-select-area">
                        <select class="custom-select">
                            <option value="">All Catagory</option>
                            <?php
                            $sql = "select distinct cat_id from marketplace_products WHERE site_id=$this_site_id";
                            $result = mysqli_query($conn, $sql);
                            if (!$result) {
                                errlog(mysqli_error($conn), $sql);
                            }
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $cat = $row['cat_id'];
                                    if ($cat == '')
                                        continue;
                            ?>
                                    <option value="<?= $cat ?>"><?= $cat ?></option>
                                <?php }
                            } else { ?>
                                <option value="all">All</option>
                                <option value="men">Men</option>
                                <option value="women">Women</option>
                                <option value="shoes">Shoes</option>
                                <option value="shoes">Glasses</option>
                                <option value="shoes">Bags</option>
                                <option value="shoes">Assesories</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="rts-menu">
                        <nav class="menus menu-toggle">
                            <ul class="nav__menu">
                                <li class="has-dropdown"><a class="menu-item active1" href="index">Home <i class="rt-plus"></i></a>
                                    <ul class="dropdown-ul">
                                        <li class="dropdown-li"><a class="dropdown-link active" href="index">Main
                                                Home</a>
                                        </li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="index-2">Fashion
                                                Home</a>
                                        </li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="index-3">Furniture
                                                Home</a>
                                        </li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="index-4">Decor
                                                Home</a>
                                        </li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="index-5">Electronics
                                                Home</a>
                                        </li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="index-6">Grocery
                                                Home</a>
                                        </li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="index-7">Footwear
                                                Home</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-dropdown"><a class="menu-item" href="shop">Shop <i class="rt-plus"></i></a>
                                    <ul class="dropdown-ul mega-dropdown">
                                        <li class="mega-dropdown-li">
                                            <ul class="mega-dropdown-ul">
                                                <li class="dropdown-li"><a class="dropdown-link" href="shop">Shop</a>
                                                </li>
                                                <li class="dropdown-li"><a class="dropdown-link" href="slidebar-left.html">Left Sidebar Shop</a>
                                                </li>
                                                <li class="dropdown-li"><a class="dropdown-link" href="slidebar-right.html">Right Sidebar Shop</a>
                                                </li>
                                                <li class="dropdown-li"><a class="dropdown-link" href="full-width-shop.html">Full Width Shop</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mega-dropdown-li">
                                            <ul class="mega-dropdown-ul">
                                                <li class="dropdown-li"><a class="dropdown-link" href="product-details.html">Single Product Layout
                                                        One</a>
                                                </li>
                                                <li class="dropdown-li"><a class="dropdown-link" href="product-details2.html">Single Product Layout
                                                        Two</a>
                                                </li>
                                                <li class="dropdown-li"><a class="dropdown-link" href="variable-products.html">Variable Product</a>
                                                </li>
                                                <li class="dropdown-li"><a class="dropdown-link" href="grouped-products.html">Grouped Product</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mega-dropdown-li last-child">
                                            <ul class="mega-dropdown-ul">
                                                <li class="dropdown-li"><a class="dropdown-link" href="cart">Cart</a>
                                                </li>
                                                <li class="dropdown-li"><a class="dropdown-link" href="client-checkout">Checkout</a>
                                                </li>
                                                <li class="dropdown-li"><a class="dropdown-link" href="account">My Account</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-dropdown"><a class="menu-item" href="#">Pages <i class="rt-plus"></i></a>
                                    <ul class="dropdown-ul">
                                        <li class="dropdown-li"><a class="dropdown-link" href="about">About</a>
                                        </li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="faq.html">FAQ's</a></li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="error.html">Error 404</a></li>
                                    </ul>
                                </li>

                                <li class="has-dropdown"><a class="menu-item" href="#">Blog <i class="rt-plus"></i></a>
                                    <ul class="dropdown-ul">
                                        <li class="dropdown-li"><a class="dropdown-link" href="news">Blog</a></li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="news-grid">Blog Grid</a></li>
                                        <li class="dropdown-li"><a class="dropdown-link" href="news-details.html">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li><a class="menu-item" href="contact">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="navbar-coupon-code">
                        <div class="icon"><img src="assets/images/icons/percent-tag2.png" alt="tag-icon"></div>
                        <div class="content">
                            <span class="title">COUPON CODE</span>
                            <span class="code">WEIBOO45%</span>
                        </div>
                    </div>
                    <div class="hamburger ml-auto"><span></span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-bar">
        <div class="cart-header">
            <h3 class="cart-heading">MY CART <?= getCartItems('5', 'CART'); ?> ITEMS)</h3>
            <div class="close-cart"><i class="fal fa-times"></i></div>
        </div>
        <div class="product-area">
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
                    if ($item['marketplace_id'] != '5') {
                        continue;
                    }
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
                    $qry = "SELECT * from product_images where product_id = '" . realEscape($item_det['prod_id']) . "' AND main = '0' AND marketplace_id = '" . $item['marketplace_id'] . "' AND type = 'IMAGE'";
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
                        $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '0' AND type = 'IMAGE'  AND marketplace_id = '5'";
                        //  echo $qry; die;
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
                        $qry = "SELECT * from product_images where product_id = '" . $item['item_id'] . "' AND variant_id = '" . $item['variant_id'] . "' AND marketplace_id = 5 ";
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
                    <tr class="cart__row border-bottom line1 cart-flex border-top">
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
                        <div class="product-item">
                            <div class="product-detail">
                                <div class="product-thumb"><img src="<?php echo $main_image ?>" alt="product-thumb"></div>
                                <div class="item-wrapper">
                                    <span class="product-name"><?php
                                                                switch ($marketplace_id) {
                                                                    case 5:
                                                                        echo htmlspecialchars($item_det['product_title']);
                                                                        break;
                                                                    case 16:
                                                                        echo htmlspecialchars($item_det['service_name']);
                                                                        break;
                                                                }
                                                                ?></span>
                                    <?php if ($marketplace_id == '5') { ?>
                                        <div class="item-wrapper">
                                            <span class="product-variation"><span class="color"><?= htmlspecialchars($item_det['color']); ?> /</span>
                                                <span class="size"><?= htmlspecialchars($item_det['size']); ?></span></span>
                                        </div>
                                    <?php } ?>
                                    <div class="item-wrapper">
                                        <?php $total_mrp += $item_det['price'] * $item['quantity']; ?>
                                        <span class="product-qnty"><?php echo (int)$item['quantity'] ?> ×</span>
                                        <span class="product-price">&#8377; <?= htmlspecialchars($item_det['price']); ?></span>
                                    </div>
                                </div>
                            </div>
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

                                <div class="item-wrapper d-flex mr--5 align-items-center">
                                    <a href="#" class="product-edit"><i class="fal fa-edit"></i></a>
                                    <a href="javascript:void(0)" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>" class="delete-cart removeItem"><i class="fal fa-times"></i></a>
                                </div>
                            </div>
                        </div>
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
                    <tr class="cart__row border-bottom line1 cart-flex border-top">
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
                        <div class="product-item">
                            <div class="product-detail">
                                <div class="product-thumb"><img src="<?php echo $main_image ?>" alt="product-thumb"></div>
                                <div class="item-wrapper">
                                    <span class="product-name"><?php
                                                                switch ($marketplace_id) {
                                                                    case 5:
                                                                        echo htmlspecialchars($item_det['product_title']);
                                                                        break;
                                                                    case 16:
                                                                        echo htmlspecialchars($item_det['service_name']);
                                                                        break;
                                                                }
                                                                ?></span>
                                    <?php if ($marketplace_id == '5') { ?>
                                        <div class="item-wrapper">
                                            <span class="product-variation"><span class="color"><?= htmlspecialchars($item_det['color']); ?> /</span>
                                                <span class="size"><?= htmlspecialchars($item_det['size']); ?></span></span>
                                        </div>
                                    <?php } ?>
                                    <div class="item-wrapper">
                                        <?php $total_mrp += $item_det['price'] * $item['quantity']; ?>
                                        <span class="product-qnty"><?php echo (int)$item['quantity'] ?> ×</span>
                                        <span class="product-price">&#8377; <?= htmlspecialchars($item_det['price']); ?></span>
                                    </div>
                                </div>
                            </div>
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

                                <div class="item-wrapper d-flex mr--5 align-items-center">
                                    <a href="#" class="product-edit"><i class="fal fa-edit"></i></a>
                                    <a href="javascript:void(0)" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>" class="delete-cart removeItem"><i class="fal fa-times"></i></a>
                                </div>
                            </div>
                        </div>
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
                                    $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '1' AND type = 'IMAGE'  AND marketplace_id = 5 AND variant_id = '" . $item['variant_id'] . "'";
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
                    <tr class="cart__row border-bottom line1 cart-flex border-top">
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
                        <div class="product-item">
                            <div class="product-detail">
                                <div class="product-thumb"><img src="<?php echo $main_image ?>" alt="product-thumb"></div>
                                <div class="item-wrapper">
                                    <span class="product-name"><?php
                                                                switch ($marketplace_id) {
                                                                    case 5:
                                                                        echo htmlspecialchars($item_det['product_title']);
                                                                        break;
                                                                    case 16:
                                                                        echo htmlspecialchars($item_det['service_name']);
                                                                        break;
                                                                }
                                                                ?></span>
                                    <?php if ($marketplace_id == '5') { ?>
                                        <div class="item-wrapper">
                                            <span class="product-variation"><span class="color"><?= htmlspecialchars($item_det['color']); ?> /</span>
                                                <span class="size"><?= htmlspecialchars($item_det['size']); ?></span></span>
                                        </div>
                                    <?php } ?>
                                    <div class="item-wrapper">
                                        <?php $total_mrp += $item_det['price'] * $item['quantity']; ?>
                                        <span class="product-qnty"><?php echo (int)$item['quantity'] ?> ×</span>
                                        <span class="product-price">&#8377; <?= htmlspecialchars($item_det['price']); ?></span>
                                    </div>
                                </div>
                            </div>
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

                                <div class="item-wrapper d-flex mr--5 align-items-center">
                                    <a href="#" class="product-edit"><i class="fal fa-edit"></i></a>
                                    <a href="javascript:void(0)" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>" class="delete-cart removeItem"><i class="fal fa-times"></i></a>
                                </div>
                            </div>
                        </div>
        <?php

                                }
                            }
                        }
                    }
                }

                if ($row_counter == 0) {
        ?>

    <?php
                }
    ?>



        </div>
        <div class="cart-bottom-area">
            <span class="spend-shipping"><i class="fal fa-truck"></i> SPENT <span class="amount">$199.00</span> MORE
                FOR FREE SHIPPING</span>
            <span class="total-price">TOTAL: <span class="price" id="grandTotal">Rs
                    <?php echo round($total_mrp - $total_discount, 2); ?>
                    .00</span></span>
            <a href="client-checkout" class="checkout-btn cart-btn">PROCEED TO CHECKOUT</a>
            <a href="cart" class="view-btn cart-btn">VIEW CART</a>
        </div>
    </div>
    <!-- slide-bar start -->
    <aside class="slide-bar">
        <div class="offset-sidebar">
            <a class="hamburger-1 mobile-hamburger-1 mobile-hamburger-2 ml--30" href="#"><span><i class="rt-xmark"></i></span></a>
        </div>
        <!-- offset-sidebar start -->
        <div class="offset-sidebar-main">
            <div class="offset-widget mb-40">
                <div class="info-widget">
                    <img src="<?= htmlspecialchars($site_row['site_logo']); ?>" height="50px" width="50px" alt="">
                    <p class="mb-30">
                        <?= htmlspecialchars($site_row['about_site']); ?>
                    </p>
                </div>
                <div class="info-widget info-widget2">
                    <h4 class="offset-title mb-20">Get In Touch </h4>
                    <ul>
                        <li class="info phone"><a href="tel:78090790890208806803">780 907 908 90, 208 806 803</a></li>
                        <li class="info email"><a href="email:info@webmail.com"><?= htmlspecialchars($site_row['contact_email']); ?></a></li>
                        <li class="info web"><a href="www.webexample.html">www.webexample.com</a></li>
                        <li class="info location"><?= htmlspecialchars($site_row['address']); ?></li>
                    </ul>
                    <div class="offset-social-link">
                        <h4 class="offset-title mb-20">Follow Us </h4>
                        <ul class="social-icon">
                            <li><a href="<?php echo htmlspecialchars($site_row["fb_link"]); ?>"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($site_row["twitter_link"]); ?>"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($site_row["youtube_link"]); ?>"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($site_row["linkedin_link"]); ?>"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($site_row["insta_link"]); ?>"><i class="fab fa-insta"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- offset-sidebar end -->
        <!-- side-mobile-menu start -->
        <nav class="side-mobile-menu side-mobile-menu1 side-mobile-menu2">
            <ul id="mobile-menu-active">
                <li class="has-dropdown firstlvl">
                    <a class="mm-link" href="index.html">Home <i class="rt-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li><a href="index.html">Main Home</a></li>
                        <li><a href="index-two.html">Fashion Home</a></li>
                        <li><a href="index-three.html">Furniture Home</a></li>
                        <li><a href="index-four.html">Decor Home</a></li>
                        <li><a href="index-five.html">Electronics Home</a></li>
                        <li><a href="index-six.html">Grocery Home</a></li>
                        <li><a href="index-seven.html">Footwear Home</a></li>
                    </ul>
                </li>
                <li class="has-dropdown firstlvl">
                    <a class="mm-link" href="shop.html">Shop <i class="rt-angle-down"></i></a>
                    <ul class="sub-menu mega-dropdown-mobile">
                        <li class="mega-dropdown-li">
                            <ul class="mega-dropdown-ul mm-show">
                                <li class="dropdown-li"><a class="dropdown-link" href="shop.html">Shop</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="slidebar-left.html">Left Sidebar
                                        Shop</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="slidebar-right.html">Right Sidebar
                                        Shop</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="full-width-shop.html">Full
                                        Width Shop</a>
                                </li>
                            </ul>
                        </li>
                        <li class="mega-dropdown-li">
                            <ul class="mega-dropdown-ul mm-show">
                                <li class="dropdown-li"><a class="dropdown-link" href="product-details.html">Single Product
                                        Layout
                                        One</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="product-details2.html">Single Product Layout
                                        Two</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="variable-products.html">Variable Product</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="grouped-products.html">Grouped Product</a>
                                </li>
                            </ul>
                        </li>
                        <li class="mega-dropdown-li">
                            <ul class="mega-dropdown-ul mm-show">
                                <li class="dropdown-li"><a class="dropdown-link" href="cart.html">Cart
                                    </a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="checkout.html">Checkout</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="account.html">My
                                        Account</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="has-dropdown firstlvl">
                    <a class="mm-link" href="index.html">Pages <i class="rt-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li><a href="about.html">About</a></li>
                        <li><a href="faq.html">FAQ's</a></li>
                        <li><a href="error.html">Error 404</a></li>
                    </ul>
                </li>
                <li class="has-dropdown firstlvl">
                    <a class="mm-link" href="news.html">Blog <i class="rt-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li><a href="news.html">Blog</a></li>
                        <li><a href="news-grid.html">Blog Grid</a></li>
                        <li><a href="news-details.html">Blog Details</a></li>
                    </ul>
                </li>
                <li><a class="mm-link" href="contact.html">Contact</a></li>
            </ul>
        </nav>
        <div class="header-action-items header-action-items1 header-action-items-side">
            <div class="search-part">
                <div class="search-icon action-item icon"><i class="rt-search"></i></div>
                <div class="search-input-area">
                    <div class="container">
                        <div class="search-input-inner">
                            <select id="custom-select">
                                <option value="hide">All Catagory</option>
                                <option value="all">All</option>
                                <option value="men">Men</option>
                                <option value="women">Women</option>
                                <option value="shoes">Shoes</option>
                                <option value="shoes">Glasses</option>
                                <option value="shoes">Bags</option>
                                <option value="shoes">Assesories</option>
                            </select>
                            <div class="input-div">
                                <form id="search_form2" method="post" action="shop.php">
                                    <button type="submit" id="" class="search-input-icon"><i class="rt-search mr--10"></i></button>
                                    <input class="search-input" onkeyup="search(this)" type="text" id="keyword2" name="keyword" placeholder="Search by keyword or #">
                                </form>
                            </div>
                            <div class="search-close-icon"><i class="rt-xmark"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart action-item">
                <div class="cart-nav">
                    <div class="cart-icon icon"><i class="rt-cart"></i><span class="wishlist-dot icon-dot">3</span>
                    </div>
                </div>
            </div>
            <div class="wishlist action-item">
                <div class="favourite-icon icon"><i class="rt-heart"></i><span class="cart-dot icon-dot">0</span>
                </div>
            </div>
            <a href="#" data-toggle="modal" data-target="#myModal" class="account"><i class="rt-user-2"></i></a>
        </div>
        <!-- side-mobile-menu end -->
    </aside>
    <!--================= Banner Section Start Here =================-->
    <div class="banner banner-3 banner-5">
        <div class="swiper bannerSlidee">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="banner-single bg-image-5 balo">
                        <div class="container">
                            <div class="single-inner">
                                <div class="contents">
                                    <span class="banner-pretitle-box">Don’t Miss! Only For This Week <span class="cate">Organic Juice</span></span>
                                    <h1 class="banner-heading mb--30">Todays Best Deal <br>
                                        In Our Store</h1>
                                    <div class="banner-action">
                                        <p>From</p>
                                        <span class="product-price">$29.00</span>
                                    </div>
                                </div>
                                <div class="banner-product-thumb"><img src="assets/images/products/banner-product5.png" alt="banner-product"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-single bg-image-5">
                        <div class="container">
                            <div class="single-inner">
                                <div class="contents">
                                    <span class="banner-pretitle-box">Hot Deal In This Week</span>
                                    <h1 class="banner-heading mb--30">Elegance <br>
                                        Hand Craft</h1>
                                    <div class="banner-action">
                                        <a class="banner-btn banner-btn2" href="#0"><i class="rt-cart-shopping"></i>Shop
                                            Now</a>
                                        <div class="banner-review">
                                            <div class="review">
                                                <div class="star"><i class="fas fa-star"></i></div>
                                                <div class="star"><i class="fas fa-star"></i></div>
                                                <div class="star"><i class="fas fa-star"></i></div>
                                                <div class="star"><i class="fas fa-star"></i></div>
                                                <div class="star"><i class="fal fa-star"></i></div>
                                            </div>
                                            <span class="review-text"><span class="value">100+</span> Review</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner-product-thumb"><img src="assets/images/products/banner-product2.png" alt="banner-product"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner5 floating-elements">
            <div class="floating-item item1"><img src="assets/images/items/gros1.png" alt="floating-element"></div>
            <div class="floating-item item2"><img src="assets/images/items/gros2.png" alt="floating-element"></div>
            <div class="floating-item item3"><img src="assets/images/items/gros3.png" alt="floating-element"></div>
        </div>
    </div>
    <!--================= Banner Section End Here =================-->

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="rts-product-details-section section-gap">
                    <div class="product-full-details-area">
                        <div class="details-filter-bar2">
                            <button class="details-filter filter-btn active" data-show=".dls-one">Login as User</button>
                            <button class="details-filter filter-btn" data-show=".dls-two">Login as Vendor</button>
                            <button class="details-filter filter-btn" data-show=".dls-three">Sign Up as User</button>
                        </div>
                        <div class="full-details dls-one filterd-items">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 mr-10">
                                    <div class="login-form">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Logo -->
                                                <center> <a href="index.html">
                                                        <img src="<?php if (isset($site_row["site_logo"])) {
                                                                        echo htmlspecialchars($site_row["site_logo"]);
                                                                    } else {
                                                                        echo "img/black-logo.png";
                                                                    } ?>" class="cm-logo" alt="black-logo" height="60px" width="60px">
                                                    </a></center>
                                                <br>
                                                <center> <a class="btn btn--icon btn-sm btn-warning toggleVisibility text-white" data-type="v" data-onclick-show="#userEmailBlock" data-onclick-hide="#userLoginForm">Login with OTP</a></center>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12 text-center">
                                                        OR
                                                    </div>
                                                </div>
                                                <form action="#" method="POST" id="userLoginForm">
                                                    <div class="form">
                                                        <input type="text" id="email" name="email" class="form-control" placeholder="Mobile or email address" />
                                                    </div>
                                                    <div class="form">

                                                        <div class="password-input">
                                                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
                                                            <span class="show-password-input"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form">
                                                        <input type="checkbox" class="form-check-input" id="remember" />
                                                        <label for="remember" class="form-label">Remember Me</label>
                                                    </div>
                                                    <div class="form">
                                                        <button type="submit" id="login_btn" class="btn">Login</button>
                                                    </div>
                                                    <a class="forgot-password" href="#">Lost your password?</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="full-details dls-two filterd-items hide">

                        </div>
                        <div class="full-details dls-three filterd-items hide">

                            <div class="row">
                                <div class="col-lg-12 col-md-12 mr-10">
                                    <div class="login-form">
                                        <div class="card">
                                            <div class="card-body">
                                                <center> <a href="#">
                                                        <img src="<?php if (isset($site_row["site_logo"])) {
                                                                        echo htmlspecialchars($site_row["site_logo"]);
                                                                    } else {
                                                                        echo "img/black-logo.png";
                                                                    } ?>" class="cm-logo" alt="black-logo" height="60px" width="60px">
                                                    </a></center>
                                                <form action="" id="signupForm" method="post">
                                                    <div id="div2">
                                                        <div class="form">
                                                            <input type="text" name="username" id="username" class="form-control" placeholder="Username or email address" />
                                                        </div>
                                                        <div class="form">
                                                            <input type="email" class="form-control" name="emailID" id="emailID" placeholder="Email address" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4" id="div1" style="display: none;">

                                                        <div class="col-sm-12">
                                                            <div class="alert alert-success">
                                                                OTP has been sent to your E-mail <span class="currentUserEmail">vkg360.vikas@gmail.com</span>

                                                            </div>
                                                            <p id="para"></p>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <input type="number" class="form-control" name="signup_otp" id="signup_otp" placeholder="OTP"><br>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="signup_button" class="btn btn--icon btn-sm btn--round btn-info pl-3 pr-3 confirmOtp" style="float: right; margin-left: 1rem;">Verify</button>

                                                    </div>
                                                    <div id="div3">
                                                        <div class="form">
                                                            <input type="checkbox" id="agree" name="agree" class="form-check-input" />
                                                            <label for="agree" class="form-label">I Agree with privacy policy</label>
                                                        </div>
                                                        <div class="form">
                                                            <button type="submit" id="btn1" class="btn">Sign Up</button>
                                                        </div>
                                                    </div>
                                                    <a class="forgot-password" href="#">Lost your password?</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <script>
        $("#signupForm").on("submit", function(e) {
            e.preventDefault();
            var name = $('#username').val();
            var email = $('#emailID').val();

            if ($('#username').val() == '' || $('#username').val() == 'null') {
                Swal.fire("User Name is Required.", "", "warning");
                return;
            }
            if ($('#emailID').val() == '' || $('#emailID').val() == 'null') {
                Swal.fire("Email ID is Required.", "", "warning");
                return;
            }
            if ($('#agree').prop('checked') != true) {
                Swal.fire("Please Agree with Privacy Policy.", "", "warning");
                return;
            }
            $.ajax({
                type: 'POST',
                url: 'login_helper.php',
                data: {
                    signup: true,
                    emailID: email,
                    username: name
                },
                beforeSend: function() {
                    $("#btn1").addClass('disabled');
                    $("#btn1").html('Loading..');
                },
                success: function(data) {
                    $("#btn1").removeClass('disabled');
                    $("#btn1").html('SIGN UP');
                    if (data == '1') {
                        $('#div2').hide();
                        $('#div3').hide();
                        $('#div1').show();
                        $("#div1").find("span").html(email);
                        Swal.fire("OTP sent to your Email Address.", "", "success");
                        var timer = 120;
                        var timerInterval = setInterval(function() {
                            $("#para").html("Try again in " + timer + " seconds");
                            timer--;
                            if (timer == 0) {
                                clearTimeInterval(timerInterval);
                            }
                        }, 999);
                    } else {
                        Swal.fire(data, "", "error");
                    }

                }
            });

        });

        $("#signup_button").on("click", function(e) { // verify otp

            var otp = $('#signup_otp').val();

            if ($('#signup_otp').val() == '' || $('#signup_otp').val() == null) {
                Swal.fire("OTP is Required.", "", "error");
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'login_helper.php',
                data: {
                    verifyEmail: otp
                },
                beforeSend: function() {
                    $("#signup_button").addClass('disabled');
                    $("#signup_button").html('Loading..');
                },
                success: function(data) {
                    $("#signup_button").removeClass('disabled');
                    if (data == '1') {
                        $('#div2').show();
                        $('#div3').show();
                        $('#div1').hide();
                        $("#signupForm").trigger("reset");
                        Swal.fire({
                            icon: 'success',
                            title: 'Account Created Successful.',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        }).then(result => {
                            location.reload();
                        })
                        setTimeout(() => {
                            location.reload();
                        }, 4000);
                    } else {
                        Swal.fire(data, "", "warning");
                    }

                }
            });

        });

        $("#userLoginForm").on("submit", function(e) {
            e.preventDefault();
            var email = $('#email').val();
            var pass = $('#password').val();

            if ($('#email').val() == '' || $('#email').val() == 'null') {
                Swal.fire("Email is Required.", "", "warning");
                return;
            }
            if ($('#password').val() == '' || $('#password').val() == 'null') {
                Swal.fire("Password is Required.", "", "warning");
                return;
            }
            $.ajax({
                type: 'POST',
                url: 'login_helper.php',
                data: {
                    userLogin: true,
                    email: email,
                    password: pass
                },
                success: function(data) {
                    if (data == '1') {
                        $("#userLoginForm").trigger("reset");
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful..',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        }).then(result => {
                            location.reload();
                        })
                        setTimeout(() => {
                            location.reload();
                        }, 4000);
                    }
                    if (data == '2') {
                        Swal.fire("Invalid Details.", "", "error");
                    }
                    if (data == '3') {
                        Swal.fire("You are not Resitered.", "", "error");
                    }
                    if (data == '4') {
                        Swal.fire("Your Account has been Suspended.", "", "error");
                    }


                }
            });

        });
    </script>

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
                    url: "cart_helper.php",
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
                // alert(id);
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
                            url: "cart_helper.php",
                            method: "post",
                            data: {
                                removeItem: id,
                                var_id,
                                type,
                            },
                            success: function(data) {
                                if (data.trim() == '1') {
                                    Swal.fire("Removed", "Item removed from cart!", "success");
                                    $(th).parent().parent().parent().remove();
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
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
                    url: "cart_helper.php",
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

                        $(th).prev().val(parseInt($(th).prev().val()));

                        if (((parseInt(curr) + 1) * (parseFloat(price))).toFixed(2) > ((parseInt(curr) + 1) * (parseFloat(price)) - parseFloat(discount)).toFixed(2)) {
                            $(th).parent().parent().parent().siblings(".cart-price").children(".discountBlock").children("del").html("&#8377; " + ((parseInt(curr) + 1) * (parseFloat(price))).toFixed(2));
                        }


                        $(th).parent().parent().parent().siblings(".cart-price").children(".amountBlock").html("&#8377; " + (((parseInt(curr) + 1) * (parseFloat(price) - parseFloat(discount)))).toFixed(2));
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

                $(this).prev().val(parseInt($(this).prev().val()));
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
                    url: "cart_helper.php",
                    method: "POST",
                    data: {
                        updateQuantity: "decrease",
                        item: id,
                        type: type,
                        variant: v,
                    },
                    success: function(data) {
                        if (((parseInt(curr) - 1) * (parseFloat(price))).toFixed(2) > ((parseInt(curr) - 1) * (parseFloat(price)) - parseFloat(discount)).toFixed(2)) {
                            $(th).parent().parent().parent().siblings(".cart-price").children(".discountBlock").children("del").html("&#8377; " + ((parseInt(curr) - 1) * (parseFloat(price))).toFixed(2));
                        }

                        $(th).parent().parent().parent().siblings(".cart-price").children(".amountBlock").html("&#8377; " + (((parseInt(curr) - 1) * (parseFloat(price) - parseFloat(discount)))).toFixed(2));

                        updateInvoice();
                    }
                })
            })
        })

        function search(e) {

            alert('ok')
            // let val=e.value;

            // alert(val)

        }


        $('#search_form').on("submit", (e) => {
            e.preventDefault();

            if ($('#keyword').val() == '') {
                Swal.fire("Error!", "Please Enter a Keyword.", "error");
                return;
            } else {
                $('#search_form').trigger("submit");
            }
        });

        $('#search_form2').on("submit", (e) => {
            e.preventDefault();

            if ($('#keyword2').val() == '') {
                Swal.fire("Error!", "Please Enter a Keyword.", "error");
                return;
            } else {
                $('#search_form2').trigger("submit");
            }
        });
    </script>
</header>