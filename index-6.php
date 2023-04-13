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
if (isset($_POST['wish']) && isset($_POST['variant'])) {

    $item_id = realEscape($_POST['wish']);
    $variant_id = realEscape($_POST['variant']);

    $result = modify_cart_n_wishlist('5', $item_id, 'WISHLIST', false, $variant_id);
    echo $result;

    die;
}
?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /index-six.html / [XR&CO'2014],  19:56:13 GMT -->

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

    <div class="anywere anywere-home"></div>

    <!--================= Header Section Start Here =================-->
    <?php include 'header2.php'; ?>

    <!--================= Header Section End Here =================-->


    <!--================= Product Category Section Start Here =================-->
    <div class="rts-product-category-section section-gap">
        <div class="container">
            <div class="row">
                <div class="col-xl-2">
                    <a href="category.html" class="product-item product-item-vertical">
                        <div class="product-thumb"><img src="assets/images/products/home5/category/1.png" alt="product-image"></div>
                        <div class="contents">
                            <span class="item-qnty">10 Items</span>
                            <h3 class="product-title">Fresh Vegetables</h3>
                            <div class="icon"><i class="fal fa-long-arrow-right"></i></div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-8">
                    <div class="row">
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
                                $sql = "select mp.*,v.*,mp.id as pid from marketplace_products mp join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.cat_id='$cat'";
                                $rs3 = mysqli_query($conn, $sql);
                                if (!$rs3) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                $sql = "select image_url from categories where category_title='$cat' and marketplace_id='5' and category_type='main' and site_id=$this_site_id";
                                $rs2 = mysqli_query($conn, $sql);
                                if (!$rs2) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                $row2 = mysqli_fetch_assoc($rs2);
                        ?>
                                <div class="col-xl-4 col-md-6 col-sm-6">
                                    <a href="category.html" class="product-item product-item-horizontal">
                                        <div class="product-thumb"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image"></div>
                                        <div class="contents">
                                            <span class="item-qnty"><?= mysqli_num_rows($rs3) ?> Items</span>
                                            <h3 class="product-title"><?= $cat ?></h3>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                        } else { ?>

                            <div class="col-xl-4 col-md-6 col-sm-6">
                                <a href="category.html" class="product-item product-item-horizontal">
                                    <div class="product-thumb"><img src="assets/images/products/home5/category/2.png" alt="product-image"></div>
                                    <div class="contents">
                                        <span class="item-qnty">10 Items</span>
                                        <h3 class="product-title">Breads & Bakery</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-6">
                                <a href="category.html" class="product-item product-item-horizontal">
                                    <div class="product-thumb"><img src="assets/images/products/home5/category/3.png" alt="product-image"></div>
                                    <div class="contents">
                                        <span class="item-qnty">10 Items</span>
                                        <h3 class="product-title">Butter</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-6">
                                <a href="category.html" class="product-item product-item-horizontal">
                                    <div class="product-thumb"><img src="assets/images/products/home5/category/4.png" alt="product-image"></div>
                                    <div class="contents">
                                        <span class="item-qnty">10 Items</span>
                                        <h3 class="product-title">Chips</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-6">
                                <a href="category.html" class="product-item product-item-horizontal">
                                    <div class="product-thumb"><img src="assets/images/products/home5/category/5.png" alt="product-image"></div>
                                    <div class="contents">
                                        <span class="item-qnty">10 Items</span>
                                        <h3 class="product-title">Chocolate & Ice-cream</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-6">
                                <a href="category.html" class="product-item product-item-horizontal">
                                    <div class="product-thumb"><img src="assets/images/products/home5/category/6.png" alt="product-image"></div>
                                    <div class="contents">
                                        <span class="item-qnty">10 Items</span>
                                        <h3 class="product-title">Fish & Meat</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-6">
                                <a href="category.html" class="product-item product-item-horizontal">
                                    <div class="product-thumb"><img src="assets/images/products/home5/category/7.png" alt="product-image"></div>
                                    <div class="contents">
                                        <span class="item-qnty">10 Items</span>
                                        <h3 class="product-title">Masala</h3>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12">
                    <a href="category.html" class="product-item product-item-vertical product-item-bg">
                        <div class="product-thumb"><img src="assets/images/products/home5/category/8.png" alt="product-image"></div>
                        <div class="contents">
                            <span class="item-qnty">-50%</span>
                            <h3 class="product-title">Pure Egg</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--================= Product Category Section End Here =================-->



    <!--================= Product Category Section Start Here =================-->
    <div class="rts-featured-product-section rts-featured-product-section2 section-gap">
        <div class="container">
            <div class="section-header section-header4">
                <span class="section-title section-title-2 mb--5
                ">Featured Products</span>
                <a href="shop-main.html" class="go-btn">All Products <i class="fal fa-long-arrow-right"></i></a>
            </div>
            <div class="row justify-content-center" id="content">
                <?php
                $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid,ad.id as admin from marketplace_products mp inner join product_variants v on mp.id=v.product_id 
                 inner join vendor vd on vd.id=mp.vendor_id 
                 LEFT JOIN admin ad ON ad.vendor_id = vd.id
                 
                 WHERE 
                     (
                         (mp.site_id = $this_site_id AND mp.status = 1 AND mp.verified = 1) 
                 
                         OR (mp.site_id = ad.site_id AND (mp.status = 1 OR mp.status = 0) AND (mp.verified = 1 OR mp.verified = 0) )
                     ) AND mp.label=1 LIMIT 5";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    errlog(mysqli_error($conn), $sql);
                }
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $pid = $row['pid'];
                        $vid = $row['vid'];
                        $sql = "select image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and variant_id=$vid";
                        $result2 = mysqli_query($conn, $sql);
                        if (!$result2) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        $row2 = mysqli_fetch_assoc($result2);
                        $sql = "select discount_percent from discounts where product_id=$pid and marketplace_id='5'";
                        $result3 = mysqli_query($conn, $sql);
                        if (!$result3) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        $row3 = mysqli_fetch_assoc($result3);
                        $price = $row['price'];
                        $qry = "
                    SELECT
                        (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,
                        (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
                        FROM marketplace_products mrp 
                        INNER JOIN product_variants pv ON pv.product_id = mrp.id
                    WHERE mrp.id = '" . $pid . "' ";

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
                ?>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item">
                                <div class="product-status-bar">
                                    <?php
                                    $arr = getProductRating($pid, $vid, 5);
                                    $rating = $arr[0];
                                    ?>

                                    <div class="rating-stars-group">
                                        <div class="rating-star"><i class="<?php if ($rating >= 1) {
                                                                                echo 'fas';
                                                                            } else {
                                                                                echo 'fal';
                                                                            } ?> fa-star"></i></div>
                                        <div class="rating-star"><i class="<?php if ($rating >= 2) {
                                                                                echo 'fas';
                                                                            } else {
                                                                                echo 'fal';
                                                                            } ?> fa-star"></i></div>
                                        <div class="rating-star"><i class="<?php if ($rating >= 3) {
                                                                                echo 'fas';
                                                                            } else {
                                                                                echo 'fal';
                                                                            } ?> fa-star"></i></div>
                                        <div class="rating-star"><i class="<?php if ($rating >= 4) {
                                                                                echo 'fas';
                                                                            } else {
                                                                                echo 'fal';
                                                                            } ?> fa-star"></i></div>
                                        <div class="rating-star"><i class="<?php if ($rating >= 5) {
                                                                                echo 'fas';
                                                                            } else {
                                                                                echo 'fal';
                                                                            } ?> fa-star"></i></div>
                                    </div>
                                    <span class="stock"><?php if ($row['available'] == 1) {
                                                            echo "In Stock";
                                                        }
                                                        if ($row['available'] == 0) {
                                                            echo "Out of Stock";
                                                        }
                                                        ?></span>
                                </div>
                                <a href="product-details?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-thumb"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image"></a>
                                <div class="contents">
                                    <span class="product-type"><?= htmlspecialchars($row['cat_id']); ?></span>
                                    <a href="product-details?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-title"><?= htmlspecialchars($row['product_title']); ?></a>
                                    <div class="product-bottom-content">
                                        <span class="product-price"><?php
                                                                    if ($discount > 0) {
                                                                        echo "&#8377;" . htmlspecialchars(round($row['price'] - ($discount), 2));
                                                                    } else {
                                                                        echo "&#8377;" . htmlspecialchars($row['price']);
                                                                    }
                                                                    ?> <span class="old-price"><?php
                                                                                                if ($discount > 0) {
                                                                                                    echo "&#8377;" . htmlspecialchars($row['price']);
                                                                                                } ?></span></span>
                                        <button class="wishlist" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>"><i class="rt-heart"></i></button>
                                    </div>
                                    <div class="product-features product-features3">
                                        <div class="new-tag product-tag">NEW</div>
                                        <?php
                                        if ($discount > 0) {
                                        ?>
                                            <div class="discount-tag product-tag"><?php
                                                                                    echo ($discount * 100) / $price;  ?>%</div>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="product-actions product-actions3">
                                        <a href="javascript:void(0)" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>" class="product-action"><i class="fal fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product-bottom-action">

                                    <button class="product-action" style="color:white;" onclick="fun1(this)" value="<?= $vid; ?>"><i class="fal fa-eye"></i></button>

                                    <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i>
                                        Add
                                        To
                                        Cart</a>


                                </div>
                            </div>
                        </div>

                        <?php
                        $sql = "select mp.*,v.*,mp.id as pid,v.id as vid from marketplace_products mp join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.id='$pid' and v.id='$vid'";
                        $resultb = mysqli_query($conn, $sql);
                        if (!$resultb) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        $rowb = mysqli_fetch_assoc($resultb);
                        $sql = "select image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and variant_id=$vid";
                        $result2b = mysqli_query($conn, $sql);
                        if (!$result2b) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        $row2b = mysqli_fetch_assoc($result2b);

                        $sql = "select image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and main='0'";
                        $result3b = mysqli_query($conn, $sql);
                        if (!$result3b) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        $arr = array();
                        while ($row3b = mysqli_fetch_assoc($result3b)) {
                            $arr[] = $row3b['image_url'];
                        }
                        ?>
                        <div class="product-details-popup-wrapper" id="div2<?= $vid; ?>">
                            <div class="rts-product-details-section rts-product-details-section2 product-details-popup-section">
                                <div class="product-details-popup">
                                    <button class="product-details-close-btn"><i class="fal fa-times"></i></button>
                                    <div class="details-product-area">
                                        <div class="product-thumb-area" style="height:300px; width:450px;">
                                            <div class="cursor"></div>
                                            <div class="thumb-wrapper one filterd-items figure">
                                                <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url(<?= htmlspecialchars($row2b['image_url']); ?>)"><img src="<?= htmlspecialchars($row2b['image_url']); ?>" alt="product-thumb" height="350px" width="200px">
                                                </div>
                                            </div>
                                            <div class="thumb-wrapper two filterd-items hide">
                                                <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url(<?php if (isset($arr[0])) {
                                                                                                                                            echo $arr[0];
                                                                                                                                        } else {
                                                                                                                                            echo '';
                                                                                                                                        } ?>)"><img src="<?php if (isset($arr[0])) {
                                                                                                                                                                echo $arr[0];
                                                                                                                                                            } else {
                                                                                                                                                                echo '';
                                                                                                                                                            } ?>" alt="product-thumb">
                                                </div>
                                            </div>
                                            <div class="thumb-wrapper three filterd-items hide">
                                                <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url(<?php if (isset($arr[1])) {
                                                                                                                                            echo $arr[1];
                                                                                                                                        } else {
                                                                                                                                            echo '';
                                                                                                                                        } ?>)"><img src="<?php if (isset($arr[1])) {
                                                                                                                                                                echo $arr[1];
                                                                                                                                                            } else {
                                                                                                                                                                echo '';
                                                                                                                                                            } ?>" alt="product-thumb">
                                                </div>
                                            </div>
                                            <div class="product-thumb-filter-group">

                                                <div class="thumb-filter filter-btn active" data-show=".one"><img src="<?= htmlspecialchars($row2b['image_url']); ?>" alt="product-thumb-filter"></div>
                                                <div class="thumb-filter filter-btn" data-show=".two"><img src="<?php if (isset($arr[0])) {
                                                                                                                    echo $arr[0];
                                                                                                                } else {
                                                                                                                    echo '';
                                                                                                                } ?>" alt="product-thumb-filter"></div>
                                                <div class="thumb-filter filter-btn" data-show=".three"><img src="<?php if (isset($arr[1])) {
                                                                                                                        echo $arr[1];
                                                                                                                    } else {
                                                                                                                        echo '';
                                                                                                                    } ?>" alt="product-thumb-filter"></div>
                                            </div>
                                        </div>
                                        <div class="contents">
                                            <div class="product-status">
                                                <span class="product-catagory"><?= htmlspecialchars($rowb['cat_id']); ?></span>
                                                <div class="star-rating">
                                                    <?php
                                                    $arr = getProductRating($pid, $vid, 5);
                                                    $rating = $arr[0];
                                                    while ($rating) {
                                                    ?>
                                                        <i class="fas fa-star" style="color: #ffcd00;"></i>
                                                    <?php
                                                        $rating--;
                                                    } ?>
                                                </div>
                                            </div>
                                            <h2 class="product-title"><?= htmlspecialchars($rowb['product_title']); ?> <span class="stock"><?php
                                                                                                                                            if ($rowb['available'] == 1) {
                                                                                                                                                echo "In Stock";
                                                                                                                                            }
                                                                                                                                            if ($rowb['available'] == 0) {
                                                                                                                                                echo "Out of Stock";
                                                                                                                                            }
                                                                                                                                            ?></span></h2>
                                            <span class="product-price"><span class="old-price"> <?php
                                                                                                    if ($discount > 0) {
                                                                                                        echo "Rs &#8377;" . htmlspecialchars($rowb['price']);
                                                                                                    }
                                                                                                    ?></span> <?php
                                                                                                                if ($discount > 0) {
                                                                                                                    echo "Rs &#8377;" . htmlspecialchars(round($rowb['price'] - ($discount), 2));
                                                                                                                } else {
                                                                                                                    echo "Rs &#8377;" . htmlspecialchars($rowb['price']);
                                                                                                                }
                                                                                                                ?></span>
                                            <p>
                                                <?= htmlspecialchars($rowb['product_title']); ?>
                                            </p>
                                            <div class="product-bottom-action">
                                                <div class="cart-edit">
                                                    <!-- <div class="quantity-edit action-item">
                                                            <button class="button minus"><i class="fal fa-minus minus"></i></button>
                                                            <input type="text" class="input" value="0" />
                                                            <button class="button plus">+<i class="fal fa-plus plus"></i></button>
                                                        </div> -->
                                                </div>
                                                <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart-btn action-item"><i class="rt-basket-shopping"></i> Add To
                                                    Cart</a>
                                                <a href="javascript:void(0)" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>" class="wishlist-btn action-item"><i class="rt-heart"></i></a>
                                            </div>
                                            <div class="product-uniques">
                                                <span class="sku product-unipue"><span>SKU: </span> <?= htmlspecialchars($rowb['SUK']); ?></span>
                                                <span class="catagorys product-unipue"><span>Categories: </span> <?= htmlspecialchars($rowb['cat_id']); ?></span>
                                                <span class="tags product-unipue"><span>Tags: </span> <?= htmlspecialchars($rowb['tags']); ?></span>
                                            </div>
                                            <div class="share-social">
                                                <span>Share:</span>
                                                <a class="platform" href="http://www.facebook.com/sharer?u=<?php echo $this_site_url . '/product-details?id=' . urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                                <a class="platform" href="http://twitter.com/share?text=share&url=<?php echo $this_site_url . '/product-details?id=' . urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                                                <!-- <a class="platform" href="http://behance.com/" target="_blank"><i class="fab fa-behance"></i></a> -->
                                                <a class="platform" href="http://youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                                                <a class="platform" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $this_site_url . '/product-details?id=' . urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)); ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    ?>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/1.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Sweet Onion Salsa</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00</span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                                <div class="product-features product-features2">
                                    <div class="hot-tag product-tag">HOT</div>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/2.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Chocolate Chips</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00 <span class="old-price">$460,00</span></span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-features product-features3">
                                    <div class="new-tag product-tag">NEW</div>
                                    <div class="discount-tag product-tag">-35%</div>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/3.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Meatless Chicken Tender</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00</span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/4.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Cherry Spoiling Water</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00 <span class="old-price">$460,00</span></span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-features product-features3">
                                    <div class="new-tag product-tag">NEW</div>
                                    <div class="discount-tag product-tag">-35%</div>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/5.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Mixed Vegetables</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00</span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/6.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Jerry Jam Bites</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00 <span class="old-price">$460,00</span></span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-features product-features3">
                                    <div class="new-tag product-tag">NEW</div>
                                    <div class="discount-tag product-tag">-35%</div>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/7.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Organic Broccoli Cuts</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00</span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/8.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Mango Chunks</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00</span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/9.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Turkey Burgers</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00 <span class="old-price">$460,00</span></span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-features product-features3">
                                    <div class="hot-tag product-tag">HOT</div>
                                    <div class="discount-tag product-tag">-35%</div>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-status-bar">
                                <div class="rating-stars-group">
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fas fa-star"></i></div>
                                    <div class="rating-star"><i class="fal fa-star"></i></div>
                                </div>
                                <span class="stock">In Stock</span>
                            </div>
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/10.png" alt="product-image"></a>
                            <div class="contents">
                                <span class="product-type">Cookie</span>
                                <a href="product-details.html" class="product-title">Rising Cust Pizza</a>
                                <div class="product-bottom-content">
                                    <span class="product-price">$230,00</span>
                                    <button class="wishlist"><i class="rt-heart"></i></button>
                                </div>
                                <div class="product-actions product-actions3">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-bottom-action">
                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-bag mr--5"></i> Add To
                                    Cart</a>
                                <button class="view-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--================= Product Category Section End Here =================-->


    <!--================= Discount Code Section Start Here =================-->
    <div class="rts-discount-code-section section-space">
        <div class="container">
            <div class="discount-code-box">
                <div class="icon"><img src="assets/images/icons/percent-tag-xl.png" alt="discount-icon"></div>
                <div class="discount-content">
                    <span class="pretitle">Use discount code in checkout!</span>
                    <h3 class="discound-title">Super discount for your first purchase.</h3>
                </div>
                <span class="discount-code">WEIBOO64%</span>
            </div>
        </div>
    </div>
    <!--================= Discount Code End Here =================-->


    <!--================= Picked Category Section Start Here =================-->
    <div class="rts-picked-product-section section-gap">
        <div class="container">
            <div class="section-header section-header4">
                <span class="section-title section-title-2 mb--5
                ">Hand Picked Products</span>
                <a href="shop-main.html" class="go-btn">All Products <i class="fal fa-long-arrow-right"></i></a>
            </div>
            <div class="row">
                <?php
                $title = array();
                $image = array();
                $price = array();
                $pid = array();
                $vid = array();
                $dis = array();
                $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid,ad.id as admin from marketplace_products mp inner join product_variants v on mp.id=v.product_id 
                inner join vendor vd on vd.id=mp.vendor_id 
                LEFT JOIN admin ad ON ad.vendor_id = vd.id
                
                WHERE 
                    (
                        (mp.site_id = $this_site_id AND mp.status = 1 AND mp.verified = 1) 
                
                        OR (mp.site_id = ad.site_id AND (mp.status = 1 OR mp.status = 0) AND (mp.verified = 1 OR mp.verified = 0) )
                    ) AND mp.label=2 LIMIT 4";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    errlog(mysqli_error($conn), $sql);
                }
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $pid[] = $row['pid'];
                        $vid[] = $row['vid'];
                        $sql = "select image_url from product_images where product_id=" . $row['pid'] . " and marketplace_id='5' and type='IMAGE' and variant_id=" . $row['vid'] . "";
                        $result2 = mysqli_query($conn, $sql);
                        if (!$result2) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        $row2 = mysqli_fetch_assoc($result2);
                        $sql = "select discount_percent from discounts where product_id=" . $row['pid'] . " and marketplace_id='5'";
                        $result3 = mysqli_query($conn, $sql);
                        if (!$result3) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        $row3 = mysqli_fetch_assoc($result3);

                        $price1 = $row['price'];
                        $qry = "SELECT (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,(SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
            FROM marketplace_products mrp 
            INNER JOIN product_variants pv ON pv.product_id = mrp.id
            WHERE mrp.id = '" . $row['pid'] . "' ";

                        $res = mysqli_query($conn, $qry);
                        if (!$res) {
                            errlog(mysqli_error($conn), $qry);
                        }

                        $dis_res = mysqli_fetch_assoc($res);
                        $discount = 0;
                        if ($dis_res['discount_per'] > 0) {
                            $discount = ((float)$dis_res['discount_per']) * $price1 / 100;
                        }

                        if ($dis_res['discount_amount'] > 0) {
                            $discount += ((float)$dis_res['discount_amount']);
                        }

                        $title[] = $row['product_title'];
                        $price[] = $row['price'];
                        $image[] = $row2['image_url'];
                        $dis[] = $discount;
                    }
                ?>

                    <?php if (isset($pid[0]) && $pid[0] != '') { ?>
                        <div class="col-d-35 col-xl-6 col-lg-6 col-md-6">
                            <div class="product detail-product one filterd-items">
                                <a href="product-details?id=<?= urlencode(base64_encode($pid[0])) ?>&vid=<?= urlencode(base64_encode($vid[0])) ?>" class="product-thumb"><img src="<?= $image[0] ?>" alt="product-thumb"></a>
                                <div class="contents">
                                    <div class="rating-area">
                                        <div class="rating-stars-group">
                                            <?php
                                            $arr = getProductRating($pid[0], $vid[0], 5);
                                            $rating = $arr[0];
                                            while ($rating) {
                                            ?>
                                                <div class="rating-star"><i class="fas fa-star"></i></div>
                                            <?php
                                                $rating--;
                                            } ?>
                                            <?php if ($arr[1] > 0) { ?> <span class="rating-qnty">(<?= $arr[1]; ?> Reviews)</span><?php } ?>
                                        </div>
                                    </div>
                                    <a href="product-details?id=<?= urlencode(base64_encode($pid[0])) ?>&vid=<?= urlencode(base64_encode($vid[0])) ?>" class="product-title"><?= $title[0] ?> <br>
                                    </a>
                                    <span class="product-price">&#8377; <?php if ($dis[0] > 0) {
                                                                            echo $price[0] - $dis[0];
                                                                        } else {
                                                                            echo $price[0];
                                                                        } ?> <span class="old-price"><?php if ($dis[0] > 0) {
                                                                                                        echo $price[0];
                                                                                                    } ?></span></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($pid[1]) && $pid[1] != '') { ?>
                        <div class="col-d-35 col-xl-6 col-lg-6 col-md-6">
                            <div class="product detail-product one filterd-items">
                                <a href="product-details?id=<?= urlencode(base64_encode($pid[1])) ?>&vid=<?= urlencode(base64_encode($vid[1])) ?>" class="product-thumb"><img src="<?= $image[1] ?>" alt="product-thumb"></a>
                                <div class="contents">
                                    <div class="rating-area">
                                        <div class="rating-stars-group">
                                            <?php
                                            $arr = getProductRating($pid[1], $vid[1], 5);
                                            $rating = $arr[0];
                                            while ($rating) {
                                            ?>
                                                <div class="rating-star"><i class="fas fa-star"></i></div>
                                            <?php
                                                $rating--;
                                            } ?>
                                            <?php if ($arr[1] > 0) { ?> <span class="rating-qnty">(<?= $arr[1]; ?> Reviews)</span><?php } ?>
                                        </div>
                                    </div>
                                    <a href="product-details?id=<?= urlencode(base64_encode($pid[1])) ?>&vid=<?= urlencode(base64_encode($vid[1])) ?>" class="product-title"><?= $title[1] ?> <br>
                                    </a>
                                    <span class="product-price">&#8377; <?php if ($dis[1] > 0) {
                                                                            echo $price[1] - $dis[1];
                                                                        } else {
                                                                            echo $price[1];
                                                                        } ?> <span class="old-price"><?php if ($dis[1] > 0) {
                                                                                                        echo $price[1];
                                                                                                    } ?></span></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-d-3 col-md-12">
                        <div class="row m-0">
                            <?php if (isset($pid[2]) && $pid[2] != '') { ?>
                                <div class="col-xl-12 col-md-6">
                                    <div class="product-item">
                                        <a href="product-details?id=<?= urlencode(base64_encode($pid[2])) ?>&vid=<?= urlencode(base64_encode($vid[2])) ?>" class="product-thumb"><img src="<?= $image[2] ?>" alt="product-image"></a>
                                        <div class="contents">
                                            <!-- <span class="product-type">Seafood</span> -->
                                            <a href="product-details?id=<?= urlencode(base64_encode($pid[2])) ?>&vid=<?= urlencode(base64_encode($vid[2])) ?>" class="product-title"><?= $title[2] ?>
                                            </a>
                                            <span class="product-price">&#8377; <?php if ($dis[2] > 0) {
                                                                                    echo $price[2] - $dis[2];
                                                                                } else {
                                                                                    echo $price[2];
                                                                                } ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($pid[3]) && $pid[3] != '') { ?>
                                <div class="col-xl-12 col-md-6 last-col">
                                    <div class="product-item">
                                        <a href="product-details?id=<?= urlencode(base64_encode($pid[3])) ?>&vid=<?= urlencode(base64_encode($vid[3])) ?>" class="product-thumb"><img src="<?= $image[3] ?>" alt="product-image"></a>
                                        <div class="contents">
                                            <!-- <span class="product-type">Seafood</span> -->
                                            <a href="product-details?id=<?= urlencode(base64_encode($pid[3])) ?>&vid=<?= urlencode(base64_encode($vid[3])) ?>" class="product-title"><?= $title[3] ?>
                                            </a>
                                            <span class="product-price">&#8377;<?php if ($dis[3] > 0) {
                                                                                    echo $price[3] - $dis[3];
                                                                                } else {
                                                                                    echo $price[3];
                                                                                } ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                <?php
                } else {
                ?>

                    <div class="col-d-35 col-xl-6 col-lg-6 col-md-6">
                        <div class="product detail-product one filterd-items">
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/7.png" alt="product-thumb"></a>
                            <div class="contents">
                                <div class="rating-area">
                                    <div class="rating-stars-group">
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <span class="rating-qnty">(120 Reviews)</span>
                                    </div>
                                </div>
                                <a href="#" class="product-title">Organic Broccoli Cuts <br>
                                    Android 10.0 OS</a>
                                <span class="product-price">$129.99 <span class="old-price">$349.99</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-d-35 col-xl-6 col-lg-6 col-md-6">
                        <div class="product detail-product one filterd-items">
                            <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/9.png" alt="product-thumb"></a>
                            <div class="contents">
                                <div class="rating-area">
                                    <div class="rating-stars-group">
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                        <span class="rating-qnty">(120 Reviews)</span>
                                    </div>
                                </div>
                                <a href="product-details.html" class="product-title">Turkey Burgers <br>
                                    Android 10.0 OS</a>
                                <span class="product-price">$129.99 <span class="old-price">$349.99</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-d-3 col-md-12">
                        <div class="row m-0">
                            <div class="col-xl-12 col-md-6">
                                <div class="product-item">
                                    <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/6.png" alt="product-image"></a>
                                    <div class="contents">
                                        <span class="product-type">Seafood</span>
                                        <a href="product-details.html" class="product-title">Chicok Butter with Canola Oil
                                            400ML</a>
                                        <span class="product-price">$230,00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-6 last-col">
                                <div class="product-item">
                                    <a href="product-details.html" class="product-thumb"><img src="assets/images/products/home5/5.png" alt="product-image"></a>
                                    <div class="contents">
                                        <span class="product-type">Seafood</span>
                                        <a href="product-details.html" class="product-title">Chicok Butter with Canola Oil
                                            400ML</a>
                                        <span class="product-price">$230,00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--================= Picked Category Section End Here =================-->


    <!--================= Ad Banner Section Start Here =================-->
    <div class="rts-ad-banner-section section-space">
        <div class="container">
            <div class="ad-banner-inner">
                <div class="ad-banner mr--20"><img src="assets/images/banner/giftcard.jpg" alt="ad"></div>
                <div class="ad-banner"><img src="assets/images/banner/moneyback.jpg" alt="ad"></div>
            </div>
        </div>
    </div>
    <!--================= Ad Banner Section End Here =================-->


    <!--================= Feeds Section Start Here =================-->
    <div class="rts-feeds-section rts-feeds-section2 rts-feeds-section3 section-gap">
        <div class="container">
            <div class="section-header section-header4">
                <span class="section-title section-title-2 mb--5
            ">Cour Blog & Insights</span>
                <a href="shop-main.html" class="go-btn">Other Category <i class="fal fa-long-arrow-right"></i></a>
            </div>
            <div class="row justify-content-center">
                <?php
                $sql = "select * from post WHERE site_id=$this_site_id and featured=1 order by created_date DESC limit 3";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    errlog(mysqli_error($conn), $sql);
                }
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $v_id = $row['vendor_id'];
                        $sql2 = "select name, profile_pic from vendor where id=$v_id";
                        $result2 = mysqli_query($conn, $sql2);
                        if (!$result2) {
                            errlog(mysqli_error($conn), $sql2);
                        }
                        $row2 = mysqli_fetch_assoc($result2);
                ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="feed-item">
                                <a href="news-details?id=<?= $row['id'] ?>" class="image"><img src="<?= htmlspecialchars($row['featured_image']); ?>" alt="Featured Image"></a>
                                <div class="date">
                                    <span class="day"><?= date("d", strtotime($row['created_date'])) ?></span>

                                    <span class="month"><?= date("M", strtotime($row['created_date'])) ?></span>
                                </div>
                                <div class="contents">
                                    <div class="feed-info">
                                        <a href="category.html" class="feed-catagory"><?= htmlspecialchars($row['category']); ?></a>
                                    </div>
                                    <h2 class="feed-title"><a href="news-details.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['post_title']); ?></a></h2>
                                    <div class="author">
                                        <div class="author-dp"><img src="<?= htmlspecialchars($row2['profile_pic']); ?>" alt="Author Image" style="border-radius: 50%; height: 40px; width: 40px;">
                                        </div>
                                        <div class="content">
                                            <h4 class="author-name"><?= htmlspecialchars($row2['name']); ?></h4>
                                            <span class="title">Author</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else { ?>

                    <div class="col-xl-4 col-md-6">
                        <div class="feed-item">
                            <a href="news-details.html" class="feed-image"><img src="assets/images/post/feed4.jpg" alt="feed-image"></a>
                            <div class="date">
                                <span class="day">24</span>
                                <span class="month">JAN</span>
                            </div>
                            <div class="contents">
                                <div class="feed-info">
                                    <a href="category.html" class="feed-catagory">Electronics</a>
                                </div>
                                <h2 class="feed-title"><a href="news-details.html">The post-pandemic consumer is
                                        embracing
                                        secondhand clothes</a></h2>
                                <div class="author">
                                    <div class="author-dp"><img src="assets/images/items/author1.png" alt="author-dp">
                                    </div>
                                    <div class="content">
                                        <h4 class="author-name">Alonso D. Dowson</h4>
                                        <span class="title">Author</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="feed-item">
                            <a href="news-details.html" class="feed-image"><img src="assets/images/post/feed5.jpg" alt="feed-image"></a>
                            <div class="date">
                                <span class="day">19</span>
                                <span class="month">JAN</span>
                            </div>
                            <div class="contents">
                                <div class="feed-info">
                                    <a href="category.html" class="feed-catagory">Electronics</a>
                                </div>
                                <h2 class="feed-title"><a href="news-details.html">The post-pandemic consumer is
                                        embracing
                                        secondhand clothes</a></h2>
                                <div class="author">
                                    <div class="author-dp"><img src="assets/images/items/author1.png" alt="author-dp">
                                    </div>
                                    <div class="content">
                                        <h4 class="author-name">Alonso D. Dowson</h4>
                                        <span class="title">Author</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="feed-item last-child">
                            <a href="news-details.html" class="feed-image"><img src="assets/images/post/feed6.jpg" alt="feed-image"></a>
                            <div class="date">
                                <span class="day">22</span>
                                <span class="month">JAN</span>
                            </div>
                            <div class="contents">
                                <div class="feed-info">
                                    <a href="category.html" class="feed-catagory">Electronics</a>
                                </div>
                                <h2 class="feed-title"><a href="news-details.html">The post-pandemic consumer is
                                        embracing
                                        secondhand clothes</a></h2>
                                <div class="author">
                                    <div class="author-dp"><img src="assets/images/items/author1.png" alt="author-dp">
                                    </div>
                                    <div class="content">
                                        <h4 class="author-name">Alonso D. Dowson</h4>
                                        <span class="title">Author</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--================= Feeds Section End Here =================-->


    <!--================= Restriction Notice start Here =================-->
    <div class="rts-restriction-notice section-gap">
        <h3 class="notice"><a href="news-details.html" class="highlight"><span class="star">**</span>See offer
                details.</a> Restrictions
            apply. Pricing, promotions and availability may vary by
            location and at Target.com</h3>
    </div>
    <!--================= Restriction Notice End Here =================-->




    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->

    <!--================= Product-details Section Start Here =================-->
    <div class="product-details-popup-wrapper">
        <div class="rts-product-details-section rts-product-details-section2 product-details-popup-section">
            <div class="product-details-popup">
                <button class="product-details-close-btn"><i class="fal fa-times"></i></button>
                <div class="details-product-area">
                    <div class="product-thumb-area">
                        <div class="cursor"></div>
                        <div class="thumb-wrapper one filterd-items figure">
                            <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url(assets/images/products/product-details.jpg)"><img src="assets/images/products/product-details.jpg" alt="product-thumb">
                            </div>
                        </div>
                        <div class="thumb-wrapper two filterd-items hide">
                            <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url(assets/images/products/product-filt2.jpg)"><img src="assets/images/products/product-filt2.jpg" alt="product-thumb">
                            </div>
                        </div>
                        <div class="thumb-wrapper three filterd-items hide">
                            <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url(assets/images/products/product-filt3.jpg)"><img src="assets/images/products/product-filt3.jpg" alt="product-thumb">
                            </div>
                        </div>
                        <div class="product-thumb-filter-group">
                            <div class="thumb-filter filter-btn active" data-show=".one"><img src="assets/images/products/product-filt1.jpg" alt="product-thumb-filter"></div>
                            <div class="thumb-filter filter-btn" data-show=".two"><img src="assets/images/products/product-filt2.jpg" alt="product-thumb-filter"></div>
                            <div class="thumb-filter filter-btn" data-show=".three"><img src="assets/images/products/product-filt3.jpg" alt="product-thumb-filter"></div>
                        </div>
                    </div>
                    <div class="contents">
                        <div class="product-status">
                            <span class="product-catagory">Dress</span>
                            <div class="rating-stars-group">
                                <div class="rating-star"><i class="fas fa-star"></i></div>
                                <div class="rating-star"><i class="fas fa-star"></i></div>
                                <div class="rating-star"><i class="fas fa-star-half-alt"></i></div>
                                <span>10 Reviews</span>
                            </div>
                        </div>
                        <h2 class="product-title">Wide Cotton Tunic Dress <span class="stock">In Stock</span></h2>
                        <span class="product-price"><span class="old-price">$9.35</span> $7.25</span>
                        <p>
                            Priyoshop has brought to you the Hijab 3 Pieces Combo Pack PS23. It is a
                            completely modern design and you feel comfortable to put on this hijab.
                            Buy it at the best price.
                        </p>
                        <div class="product-bottom-action">
                            <div class="cart-edit">
                                <div class="quantity-edit action-item">
                                    <button class="button minus"><i class="fal fa-minus minus"></i></button>
                                    <input type="text" class="input" value="01" />
                                    <button class="button plus">+<i class="fal fa-plus plus"></i></button>
                                </div>
                            </div>
                            <a href="cart.html" class="addto-cart-btn action-item"><i class="rt-basket-shopping"></i>
                                Add To
                                Cart</a>
                            <a href="wishlist.html" class="wishlist-btn action-item"><i class="rt-heart"></i></a>
                        </div>
                        <div class="product-uniques">
                            <span class="sku product-unipue"><span>SKU: </span> BO1D0MX8SJ</span>
                            <span class="catagorys product-unipue"><span>Categories: </span> T-Shirts, Tops, Mens</span>
                            <span class="tags product-unipue"><span>Tags: </span> fashion, t-shirts, Men</span>
                        </div>
                        <div class="share-social">
                            <span>Share:</span>
                            <a class="platform" href="http://facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a class="platform" href="http://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a class="platform" href="http://behance.com/" target="_blank"><i class="fab fa-behance"></i></a>
                            <a class="platform" href="http://youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                            <a class="platform" href="http://linkedin.com/" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Product-details Section End Here =================-->


    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1 scroll-top-btn2"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->

    <!--================= Jquery latest version =================-->
    <?php include 'common_scripts.php'; ?>

    <script>
        function fun1(e) {
            let id = e.getAttribute("value");
            $(".product-details-popup-wrapper").removeClass("popup");
            $('#div2' + id).addClass("popup");
            $(".anywere").addClass("bgshow");
        }

        function search(e) {
            let keyword = $('#search_value').val();
            // alert(keyword);

            $.ajax({
                type: 'POST',
                url: 'shop-helper.php',
                data: {
                    keyword: keyword
                },
                beforeSend: function() {

                },
                success: function(data) {
                    $('#content').html(data);
                }
            });
        }
    </script>
    <script>
        function addCart(e) {
            let id = e.getAttribute("value");
            let v_id = $(e).data("vid");
            //  alert(id+v_id);
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
    </script>
</body>


<!-- /index-six.html / [XR&CO'2014],  19:56:27 GMT -->

</html>