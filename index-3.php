<?php
session_start();
include 'config/connection.php';
include 'modify_cart_n_wishlist.php';

if (isset($_POST['item']) && isset($_POST['variant_id'])) {

    $item_id = realEscape($_POST['item']);
    $variant_id = realEscape($_POST['variant_id']);

    $result = modify_cart_n_wishlist('5', $item_id, 'CART', false, $variant_id);
    $items = getCartItems('5', 'CART');

    class Resp
    {
        public $num;
        public $res;

        function set_num($no)
        {
            $this->num = $no;
        }
        function set_resp($resp)
        {
            $this->res = $resp;
        }
    }
    $obj = new Resp();
    $obj->set_num($items);
    $obj->set_resp($result);
    echo json_encode($obj);
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


<!-- /index-three.html / [XR&CO'2014],  19:55:23 GMT -->
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
    <?php include 'header.php'; ?>
    <!--================= Header Section End Here =================-->


    <!--================= Collection Section Start Here =================-->
    <div class="rts-collections-section section-gap">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-4 col-sm-6 col-12 shop">
                    <div class="shop-now-box shop-now-box2 collection-section-item box-1">
                        <a href="category.html" class="picture"><img src="assets/images/products/home3/s19-2.webp" alt="shop-now"></a>
                        <div class="contents">
                            <h4 class="collection-text2">Collection AW 2022</h4>
                            <h2 class="title">Table & Lamps</h2>
                            <a href="shop.html" class="shop-now-btn shop-now-btn1">Shop now <i class="fal fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-12 shop">
                    <div class="shop-now-box shop-now-box2 collection-section-item box-2">
                        <a href="category.html" class="box-bg"><img src="assets/images/products/home3/s20.webp" alt="boxbg"></a>
                        <div class="contents">
                            <h4 class="collection-text2">Collection AW 2022</h4>
                            <h2 class="title">Wood & Chair</h2>
                            <a href="shop.html" class="shop-now-btn shop-now-btn1">Shop now <i class="fal fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-12 shop">
                    <div class="shop-now-box shop-now-box2 collection-section-item box-3">
                        <a href="category.html" class="picture"><img src="assets/images/products/home3/s16.webp" alt="shop-now"></a>
                        <div class="contents">
                            <h4 class="collection-text2">Collection AW 2022</h4>
                            <h2 class="title">Box & Wood</h2>
                            <a href="shop.html" class="shop-now-btn shop-now-btn1">Shop now <i class="fal fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Collection Section End Here =================-->


    <!--================= Recent Products Section End Here =================-->
    <div class="rts-recent_products-section section-gap">
        <div class="container">
            <div class="recent-products-header section-header section-header2">
                <span class="section-pretitle mb--10">Featured</span>
                <span class="section-title-2
                ">Recently added products</span>
                <div class="filter-buttons-group section-header-item">
                    <button class="filter-btn checked" data-show=".all">All</button>
                    <button class="filter-btn checked" data-show=".popular">Popular</button>
                    <button class="filter-btn checked" data-show=".onsale">On sale</button>
                    <button class="filter-btn checked" data-show=".bestrated">Best Rated</button>
                </div>
            </div>
            <div class="products-area all filterd-items">
                <div class="row">
                    <?php
                    $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid,ad.id as admin from marketplace_products mp inner join product_variants v on mp.id=v.product_id 
inner join vendor vd on vd.id=mp.vendor_id 
LEFT JOIN admin ad ON ad.vendor_id = vd.id

WHERE 
    (
        (mp.site_id = $this_site_id AND mp.status = 1 AND mp.verified = 1) 

        OR (mp.site_id = ad.site_id AND (mp.status = 1 OR mp.status = 0) AND (mp.verified = 1 OR mp.verified = 0) )
    ) AND mp.label=1 LIMIT 4";
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
                            $qry = "SELECT (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,(SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
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
                                <div class="product-item element-item1">
                                    <a href="product-details?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-image image-hover-variations">
                                        <div class="image-vari1 image-vari"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image">
                                        </div>
                                        <div class="image-vari2 image-vari"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image">
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <a href="product-details?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-name"><?= htmlspecialchars($row['product_title']); ?></a>
                                        <div class="action-wrap">
                                            <span class="product-price"> <?php
                                                                            if ($discount > 0) {
                                                                                echo "&#8377;" . htmlspecialchars(round($row['price'] - ($discount), 2));
                                                                            } else {
                                                                                echo "&#8377;" . htmlspecialchars($row['price']);
                                                                            }
                                                                            ?> <span class="old-price"><?php
                                                                                                        if ($discount > 0) {
                                                                                                            echo "&#8377;" . htmlspecialchars($row['price']);
                                                                                                        }
                                                                                                        ?></span></span>
                                            <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                                Cart</a>
                                        </div>
                                    </div>
                                    <div class="product-features product-features2">
                                        <div class="new-tag product-tag">NEW</div>
                                        <?php if ($discount > 0) {
                                            $dis = $discount * 100 / ((int)($row['price']));
                                        ?>
                                            <div class="discount-tag product-tag"><?= $dis; ?>%</div>
                                        <?php } ?>
                                    </div>
                                    <div class="product-actions">
                                        <a href="javascript:void(0)" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>" class="product-action"><i class="fal fa-heart"></i></a>
                                        <button class="product-action" onclick="fun2(this)" value="<?= $vid; ?>"><i class="fal fa-eye"></i></button>
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
                    } else { ?>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item2">
                                <a href="product-details.html" class="product-image image-slider-variations">
                                    <div class="swiper productSlide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/2.jpg" alt="product-image">
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/2_1.jpg" alt="product-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-buttons">
                                        <div class="button-prev slider-btn"><i class="fal fa-long-arrow-left"></i></div>
                                        <div class="button-next slider-btn"><i class="fal fa-long-arrow-right"></i></div>
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Bauhaus chair</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00</span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item3 popular">
                                <a href="product-details.html" class="product-image image-gallery-variations">
                                    <div class="swiper productGallerySlide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/3.jpg" alt="product-image">
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/3_1.jpg" alt="product-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="thumbs-area">
                                    <div class="swiper productGallerySlideThumb">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/3.jpg" alt="product-image">
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/3_1.jpg" alt="product-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Aeron Dining Chair</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-features product-features2">
                                    <div class="discount-tag product-tag">-35%</div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item1">
                                <a href="product-details.html" class="product-image image-hover-variations">
                                    <div class="image-vari1 image-vari"><img src="assets/images/products/home2/4.jpg" alt="product-image">
                                    </div>
                                    <div class="image-vari2 image-vari"><img src="assets/images/products/home2/4_1.jpg" alt="product-image">
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Italian Leather Band Watch</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00</span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item1">
                                <a href="product-details.html" class="product-image image-hover-variations">
                                    <div class="image-vari1 image-vari"><img src="assets/images/products/home2/5.jpg" alt="product-image">
                                    </div>
                                    <div class="image-vari2 image-vari"><img src="assets/images/products/home2/5_1.jpg" alt="product-image">
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Trending Accent Chair</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00</span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item1">
                                <a href="product-details.html" class="product-image image-hover-variations">
                                    <div class="image-vari1 image-vari"><img src="assets/images/products/home2/6.jpg" alt="product-image">
                                    </div>
                                    <div class="image-vari2 image-vari"><img src="assets/images/products/home2/6_1.jpg" alt="product-image">
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Wooden Stylish Chair</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00</span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item1">
                                <a href="product-details.html" class="product-image image-hover-variations">
                                    <div class="image-vari1 image-vari"><img src="assets/images/products/home2/7.jpg" alt="product-image">
                                    </div>
                                    <div class="image-vari2 image-vari"><img src="assets/images/products/home2/7_1.jpg" alt="product-image">
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Wooden Stylish Chair</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00</span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item1">
                                <a href="product-details.html" class="product-image image-hover-variations">
                                    <div class="image-vari1 image-vari"><img src="assets/images/products/home2/8.jpg" alt="product-image">
                                    </div>
                                    <div class="image-vari2 image-vari"><img src="assets/images/products/home2/8_1.jpg" alt="product-image">
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Office Chair</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00</span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item2">
                                <a href="product-details.html" class="product-image image-slider-variations">
                                    <div class="swiper productSlide2">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/9.jpg" alt="product-image">
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/9_1.jpg" alt="product-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-buttons">
                                        <div class="button-prev2 slider-btn"><i class="fal fa-long-arrow-left"></i></div>
                                        <div class="button-next2 slider-btn"><i class="fal fa-long-arrow-right"></i></div>
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Scandinavian Oak Chair</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00</span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-15 col-md-4 col-sm-6">
                            <div class="product-item element-item3 popular">
                                <a href="product-details.html" class="product-image image-gallery-variations">
                                    <div class="swiper productGallerySlide2">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/10.jpg" alt="product-image">
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/10_1.jpg" alt="product-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="thumbs-area">
                                    <div class="swiper productGallerySlideThumb2">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/10.jpg" alt="product-image">
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/10_1.jpg" alt="product-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-content">
                                    <a href="product-details.html" class="product-name">Stylish Office chair</a>
                                    <div class="action-wrap">
                                        <span class="product-price">$31.00</span>
                                        <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                            Cart</a>
                                    </div>
                                </div>
                                <div class="product-features product-features2">
                                    <div class="hot-tag product-tag">HOT</div>
                                </div>
                                <div class="product-actions">
                                    <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                    <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="products-area popular filterd-items hide">
                <div class="row">
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/1.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/1_2.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/2.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/2_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/3.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/3_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/4.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/4_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/5.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/5_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/6.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/6_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/7.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/7_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/8.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/8_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/9.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/9_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/10.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/10_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products-area onsale filterd-items hide">
                <div class="row">
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/1.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/1_2.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/2.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/2_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/3.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/3_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/4.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/4_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/5.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/5_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/6.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/6_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/7.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/7_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/8.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/8_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/9.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/9_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/10.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/10_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products-area bestrated filterd-items hide">
                <div class="row">
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/1.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/1_2.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00 <span class="old-price">$43.00</span></span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="new-tag product-tag">NEW</div>
                                <div class="hot-tag product-tag">HOT</div>
                                <div class="discount-tag product-tag">-35%</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/2.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/2_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/3.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/3_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/4.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/4_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Marl Seamless Long Sleeve Crop
                                    Top</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/5.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/5_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/6.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/6_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Seamless Sports Bra Smokey Grey
                                    Mar</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/7.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/7_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Vital Seamless 2.0 Vest Yellow
                                    Marl</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/9.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/9_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6">
                        <div class="product-item element-item1">
                            <a href="product-details.html" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img src="assets/images/products/home2/10.jpg" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img src="assets/images/products/home2/10_1.jpg" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <a href="product-details.html" class="product-name">Adapt Camo Seamless Shorts</a>
                                <div class="action-wrap">
                                    <span class="product-price">$31.00</span>
                                    <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                        Cart</a>
                                </div>
                            </div>
                            <div class="product-features product-features2">
                                <div class="hot-tag product-tag">HOT</div>
                            </div>
                            <div class="product-actions">
                                <a href="wishlist.html" class="product-action"><i class="fal fa-heart"></i></a>
                                <button class="product-action product-details-popup-btn"><i class="fal fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <a href="shop.php" class="all-products-link">All products</a>
            </div>
        </div>
    </div>
    <!--================= Recent Products Section End Here =================-->


    <!--================= Newsletter Section Start Here =================-->
    <div class="newsletter-banner newsletter-banner2">
        <div class="container">
            <div class="newsletter-contents">
                <span class="section-pretitle">Newsletter</span>
                <span class="section-title-2 mb--20">Join Our Newsletter</span>
                <p class="mb--30">Hey you, sign up it only takes a second to be the first to find out about
                    our latest news and promotions…</p>

                <div class="newsletter-input">
                    <input type="email" placeholder="Enter email address" name="s_email3" id="s_email3">
                    <button type="button" class="subscribe-btn" id="s_btn3"><i class="fas fa-envelope-open mr--10"></i>
                        Subscribe</button>
                </div>
            </div>
        </div>
    </div>
    <!--================= Newsletter Section End Here =================-->


    <!--================= brands Section Start Here =================-->
    <div class="rts-brands-section">
        <div class="container">
            <div class="recent-products-header section-header section-header2">
                <span class="section-pretitle mb--10">Sponsors</span>
                <span class="section-title-2">100+ Happy Users</span>
            </div>
            <div class="brands-section-inner">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/1.png" alt="brand"></a>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/2.png" alt="brand"></a>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/3.png" alt="brand"></a>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/4.png" alt="brand"></a>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/5.png" alt="brand"></a>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/6.png" alt="brand"></a>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/7.png" alt="brand"></a>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/8.png" alt="brand"></a>
                        </div>
                    </div>
                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-6 col-xxs-6">
                        <div class="brand-item">
                            <a href="#0" class="front"><img src="assets/images/brands/9.png" alt="brand"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= brands Section End Here =================-->


    <!--================= Featured Product Section Start Here =================-->
    <div class="rts-featured-product-section3 section-3">
        <div class="container">
            <div class="rts-featured-product-section-inner">
                <div class="newsletter-contents">
                    <h4 class="section-pretitle">News</h4>
                    <h2 class="section-title-2 mb--20">Shop insights & feeds</h2>
                </div>
                <div class="row">
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
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="full-wrapper wrapper-2">
                                    <div class="image-part">
                                        <a href="news-details?id=<?= $row['id'] ?>" class="image"><img src="<?= htmlspecialchars($row['featured_image']); ?>" alt="Featured Image"></a>
                                    </div>
                                    <div class="blog-content">
                                        <span class="date-full date-full2">
                                            <span class="day"><?= date("d", strtotime($row['created_date'])) ?></span>
                                            <br>
                                            <span class="month"><?= date("M", strtotime($row['created_date'])) ?></span>
                                        </span>
                                        <ul class="blog-meta blog-meta2">
                                            <li><a href="#"><?= htmlspecialchars($row['category']); ?></a></li>
                                        </ul>
                                        <div class="title title-2">
                                            <a href="news-details.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['post_title']); ?></a>
                                        </div>
                                        <div class="author-info d-flex align-items-center">
                                            <div class="avatar"><img src="<?= htmlspecialchars($row2['profile_pic']); ?>" alt="Author Image"></div>
                                            <div class="info">
                                                <p class="author-name"><?= htmlspecialchars($row2['name']); ?></p>
                                                <p class="author-dsg">Author</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>

                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="full-wrapper wrapper-1">
                                <div class="image-part">
                                    <a href="#" class="image"><img src="assets/images/featured/img-1.jpg" alt="Featured Image"></a>
                                </div>
                                <div class="blog-content">
                                    <span class="date-full date-full2">
                                        <span class="day">25</span>
                                        <br>
                                        <span class="month">Jul</span>
                                    </span>
                                    <ul class="blog-meta blog-meta2">
                                        <li><a href="#">WINTER DRESS</a></li>
                                    </ul>
                                    <div class="title title-2">
                                        <a href="#">Once that’s determined with a good, you need to come up with a name</a>
                                    </div>
                                    <div class="author-info d-flex align-items-center">
                                        <div class="avatar"><img src="assets/images/featured/author.png" alt="Author Image">
                                        </div>
                                        <div class="info">
                                            <p class="author-name">REACTHEMES</p>
                                            <p class="author-dsg">Author</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="full-wrapper wrapper-2">
                                <div class="image-part">
                                    <a href="#" class="image"><img src="assets/images/featured/img-2.jpg" alt="Featured Image"></a>
                                </div>
                                <div class="blog-content">
                                    <span class="date-full date-full2">
                                        <span class="day">25</span>
                                        <br>
                                        <span class="month">Jul</span>
                                    </span>
                                    <ul class="blog-meta blog-meta2">
                                        <li><a href="#">WINTER DRESS</a></li>
                                    </ul>
                                    <div class="title title-2">
                                        <a href="#">Once determined, you need to come up with a name a legal structure</a>
                                    </div>
                                    <div class="author-info d-flex align-items-center">
                                        <div class="avatar"><img src="assets/images/featured/author.png" alt="Author Image">
                                        </div>
                                        <div class="info">
                                            <p class="author-name">REACTHEMES</p>
                                            <p class="author-dsg">Author</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="full-wrapper wrapper-3">
                                <div class="image-part">
                                    <a href="#" class="image"><img src="assets/images/featured/img-3.jpg" alt="Featured Image"></a>
                                </div>
                                <div class="blog-content">
                                    <span class="date-full date-full2">
                                        <span class="day">25</span>
                                        <br>
                                        <span class="month">Jul</span>
                                    </span>
                                    <ul class="blog-meta blog-meta2">
                                        <li><a href="#">WINTER DRESS</a></li>
                                    </ul>
                                    <div class="title title-2">
                                        <a href="#">At the limit, statically generated, edge delivered a food</a>
                                    </div>
                                    <div class="author-info d-flex align-items-center">
                                        <div class="avatar"><img src="assets/images/featured/author.png" alt="Author Image">
                                        </div>
                                        <div class="info">
                                            <p class="author-name">REACTHEMES</p>
                                            <p class="author-dsg">Author</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!--================= Featured Product Section End Here =================-->


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
                                    <button class="button"><i class="fal fa-minus minus"></i></button>
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

    <?php
    $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid,ad.id as admin from marketplace_products mp inner join product_variants v on mp.id=v.product_id 
inner join vendor vd on vd.id=mp.vendor_id 
LEFT JOIN admin ad ON ad.vendor_id = vd.id

WHERE 
    (
        (mp.site_id = $this_site_id AND mp.status = 1 AND mp.verified = 1) 

        OR (mp.site_id = ad.site_id AND (mp.status = 1 OR mp.status = 0) AND (mp.verified = 1 OR mp.verified = 0) )
    ) AND mp.label=1 LIMIT 4";
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
            $qry = "SELECT (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,(SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
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
            <div class="product-details-popup-wrapper" id="div1<?= $vid; ?>">
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
    } ?>
    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->



    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1 scroll-top-btn2"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->
    <?php include 'common_scripts.php'; ?>

    <script>
        function fun1(e) {
            let id = e.getAttribute("value");
            $(".product-details-popup-wrapper").removeClass("popup");
            $('#div2' + id).addClass("popup");
            $(".anywere").addClass("bgshow");
        }

        function fun2(e) {
            let pid = e.getAttribute("value");
            // alert(pid);
            $(".product-details-popup-wrapper").removeClass("popup");
            $('#div1' + pid).addClass("popup");
            $(".anywere").addClass("bgshow");
        }

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
                    // alert(data);
                    let obj = JSON.parse(data);
                    if (obj.res == '1') {
                        document.getElementById('dots').innerHTML = obj.num;
                        Swal.fire("Item added in Cart.", "", "success");
                    } else if (obj.res == '0') {
                        Swal.fire("Error.", "", "error");
                    } else {
                        Swal.fire(obj.res, "", "success");
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


<!-- /index-three.html / [XR&CO'2014],  19:55:41 GMT -->

</html>