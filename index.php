<?php
session_start();
include 'config/connection.php';

include 'modify_cart_n_wishlist.php';
// print_r($_SESSION);

// if(isset($_COOKIE['guestCart'])){
//     print_r(unserialize($_COOKIE['guestCart']));
//     echo "<br>";
//     print_r(unserialize($_COOKIE['guestCartQuantity']));
//  }

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

<!-- /index.html / [XR&CO'2014],  19:55:16 GMT -->
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
    <!--================= Banner Section Start Here =================-->
    <div class="banner banner-2 bg-image">
        <div class="container">
            <div class="banner-inner">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                        <div class="rts-heading">
                            <div class="react-image">
                                <img src="assets/images/banner/dot.png" alt="">
                            </div>
                            <div class="title-inner">
                                <div class="sub-content">
                                    <img class="line-1-img" src="assets/images/banner/wvbo-icon.png" alt="">
                                    <span class="sub-text">Spring summer 22 women’s collection</span>
                                </div>
                                <h2 class="title">
                                    <span class="watermark">
                                        Hot Collection <br> For Women
                                    </span>
                                </h2>
                            </div>
                            <p class="description">Easy & safe payment with PayPal. sequins & embroidered for all
                            </p>
                            <a href="shop.html" class="section-btn2">View Collections</a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="product-item2 element-item2">
                            <a href="product-details.html" class="product-image2 image-slider-variations">
                                <div class="swiper productSlide2">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/1-1.webp" alt="product-image">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/2-1.webp" alt="product-image">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/3-1.webp" alt="product-image">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/4-1.webp" alt="product-image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-xl-10 col-lg-12 col-12">
                                <div class="product-item element-item2">
                                    <a href="product-details.html" class="product-image image-slider-variations">
                                        <div class="hot">HOT</div>
                                        <div class="swiper productSlide">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img8.webp" alt="product-image">
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img8_2.jpg" alt="product-image">
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img8_3.jpg" alt="product-image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slider-buttons">
                                            <div class="button-prev slider-btn"><i class="rt-arrow-left-long"></i>
                                            </div>
                                            <div class="button-next slider-btn"><i class="rt-arrow-right-long"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <div class="star-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <a href="product-details.html" class="product-name">Maidenform Bra</a>
                                        <div class="action-wrap">
                                            <span class="price">$31.00</span>
                                        </div>
                                    </div>
                                    <div class="quick-action-button">
                                        <div class="cta-single cta-plus">
                                            <a href="#"><i class="rt-plus"></i></a>
                                        </div>
                                        <div class="cta-single cta-quickview">
                                            <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                        </div>
                                        <div class="cta-single cta-wishlist">
                                            <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="cta-single cta-addtocart">
                                            <a href="cart.html"><i class="rt-basket-shopping"></i></a>
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
    <!--================= Banner Section End Here =================-->
    <!--================= Banner Section Start Here =================-->
    <div class="banner banner-1 bg-image">
        <div class="container">
            <div class="banner-inner">
                <div class="row">
                    <div class="col-xl-2 col-md-4 col-sm-12 gutter-1">
                        <div class="catagory-sidebar">
                            <div class="widget-bg">
                                <h2 class="widget-title">All Categories <i class="rt-angle-down"></i></h2>
                                <nav>
                                    <ul>
                                        <?php
                                        $sql = "SELECT distinct cat_id from marketplace_products WHERE site_id=$this_site_id";
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
                                                <li><a href="shop.php?cat=<?= $cat ?>"><?= $cat ?> <i class="rt rt-arrow-right-long"></i></a></li>
                                            <?php }
                                        } else { ?>
                                            <li><a href="shop.html">Activewear <i class="rt rt-arrow-right-long"></i></a></li>
                                            <li><a href="shop.html">Bikinis <i class="rt rt-arrow-right-long"></i></a></li>
                                            <li><a href="shop.html">Dresses <i class="rt rt-arrow-right-long"></i></a></li>
                                            <li><a href="shop.html">Jumpsuits <i class="rt rt-arrow-right-long"></i></a></li>
                                            <li><a href="shop.html">Smart Dress <i class="rt rt-arrow-right-long"></i></a></li>
                                            <li><a href="shop.html">Sneakers <i class="rt rt-arrow-right-long"></i></a></li>
                                            <li><a href="shop.html">Sweetshirts <i class="rt rt-arrow-right-long"></i></a></li>
                                            <li><a href="shop.html">Trousers <i class="rt rt-arrow-right-long"></i></a></li>
                                            <li><a href="shop.html">Furniture <i class="rt rt-arrow-right-long"></i></a></li>
                                        <?php } ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-10 col-md-8 col-sm-12 gutter-2">
                        <div class="swiper bannerSlide2">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="banner-single bg-image bg-image-3-1">
                                        <div class="container">
                                            <div class="single-inner">
                                                <div class="content-box">
                                                    <p class="slider-subtitle"><img src="assets/images/banner/wvbo-icon.png" alt=""> Spring
                                                        summer 22 women’s collection </p>
                                                    <h2 class="slider-title"> HOT COLLECTION <br> FOR WOMEN</h2>
                                                    <div class="slider-description">
                                                        <p>Easy & safe payment with PayPal. sequines & embroidered
                                                            for all</p>
                                                    </div>
                                                    <a href="shop.html" class="slider-btn2">View Collections</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="banner-single bg-image bg-image-3-3">
                                        <div class="container">
                                            <div class="single-inner">
                                                <div class="content-box">
                                                    <p class="slider-subtitle"><img src="assets/images/banner/wvbo-icon.png" alt=""> Spring
                                                        summer 22 women’s collection </p>
                                                    <h2 class="slider-title"> NEW COLLECTION <br> FOR WOMEN</h2>
                                                    <div class="slider-description">
                                                        <p>Easy & safe payment with PayPal. sequines & embroidered
                                                            for all</p>
                                                    </div>
                                                    <a href="shop.html" class="slider-btn2">View Collections</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="banner-single bg-image bg-image-3-4">
                                        <div class="container">
                                            <div class="single-inner">
                                                <div class="content-box">
                                                    <p class="slider-subtitle"><img src="assets/images/banner/wvbo-icon.png" alt=""> Spring
                                                        summer 22 women’s collection </p>
                                                    <h2 class="slider-title"> WINTER DRESS <br> FOR WOMEN</h2>
                                                    <div class="slider-description">
                                                        <p>Easy & safe payment with PayPal. sequines & embroidered
                                                            for all</p>
                                                    </div>
                                                    <a href="shop.html" class="slider-btn2">View Collections</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="slider-navigation">
                                <div class="swiper-button-prev slider-btn prev"><i class="rt rt-arrow-left-long"></i></div>
                                <div class="swiper-button-next slider-btn next"><i class="rt rt-arrow-right-long"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Banner Section End Here =================-->
    <!--================= Offer Section Start Here =================-->
    <div class="rts-offer-section">
        <div class="container">
            <div class="rts-offer-inner">
                <p class="description">Super discount for your 100$ purchase. Use this code <a href="shop.html">OFFER100</a>
                </p>
            </div>
        </div>
    </div>
    <!--================= Offer Section End Here =================-->

    <!--================= New Collection Section Start Here =================-->
    <div class="rts-new-collection-section section-gap">
        <div class="container">
            <div class="recent-products-header section-header">
            </div>
            <div class="swiper rts-cmmnSlider-over" data-swiper="pagination">
                <div class="swiper-wrapper">
                    <?php
                    $sql = "SELECT distinct cat_id from marketplace_products WHERE site_id=$this_site_id";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        errlog(mysqli_error($conn), $sql);
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $cat = $row['cat_id'];
                            if ($cat == '')
                                continue;
                            $sql = "SELECT mp.*,v.*,mp.id as pid from marketplace_products mp join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.cat_id='$cat'";
                            $rs3 = mysqli_query($conn, $sql);
                            if (!$rs3) {
                                errlog(mysqli_error($conn), $sql);
                            }
                            $sql = "SELECT image_url from categories where category_title='$cat' and marketplace_id='5' and category_type='main' and site_id=$this_site_id";
                            $rs2 = mysqli_query($conn, $sql);
                            if (!$rs2) {
                                errlog(mysqli_error($conn), $sql);
                            }
                            $row2 = mysqli_fetch_assoc($rs2);
                    ?>
                            <div class="swiper-slide">
                                <div class="collection-item">
                                    <a href="category.html"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="collection-image">
                                    </a>
                                    <p class="item-quantity"><?= mysqli_num_rows($rs3) ?> <span>items</span></p>
                                    <a href="category.html" class="item-catagory-box">
                                        <h3 class="title"><?= $cat ?></h3>
                                    </a>
                                </div>
                            </div>
                        <?php }
                    } else {
                        ?>
                        <div class="swiper-slide">
                            <div class="collection-item">
                                <a href="category.html"><img src="assets/images/catagory/item-1.png" alt="collection-image">
                                </a>
                                <p class="item-quantity">20 <span>items</span></p>
                                <a href="category.html" class="item-catagory-box">
                                    <h3 class="title">FOR WOMEN'S</h3>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item">
                                <a href="category.html"><img src="assets/images/catagory/item-2.png" alt="collection-image">
                                </a>
                                <p class="item-quantity">33 <span>items</span></p>
                                <a href="category.html" class="item-catagory-box">
                                    <h3 class="title">FOR MAN'S</h3>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item">
                                <a href="category.html"><img src="assets/images/catagory/item-3.png" alt="collection-image">
                                </a>
                                <p class="item-quantity">25 <span>items</span></p>
                                <a href="category.html" class="item-catagory-box">
                                    <h3 class="title">FOR KIDS</h3>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item">
                                <a href="category.html"><img src="assets/images/catagory/item-4.png" alt="collection-image">
                                </a>
                                <p class="item-quantity">33 <span>items</span></p>
                                <a href="category.html" class="item-catagory-box">
                                    <h3 class="title">ACCESORIES</h3>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!--================= New Collection Section End Here =================-->

    <!--================= Hand Picked Section Start Here =================-->
    <div class="rts-hand-picked-products-section">
        <div class="container">
            <div class="section-header section-header3 text-center">
                <div class="wrapper">
                    <div class="sub-content">
                        <img class="line-1" src="assets/images/banner/wvbo-icon.png" alt="">
                        <span class="sub-text">Featured</span>
                        <img class="line-2" src="assets/images/banner/wvbo-icon.png" alt="">
                    </div>
                    <h2 class="title">HAND-PICKED PRODUCT</h2>
                </div>
            </div>
            <div class="slider-div">
                <div class="swiper rts-sixSlide-over">
                    <div class="swiper-wrapper">
                        <?php
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
                                <div class="swiper-slide">
                                    <div class="product-item element-item1">
                                        <a href="product-details?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-image image-hover-variations">
                                            <div class="image-vari1 image-vari"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image">
                                            </div>
                                            <div class="image-vari2 image-vari"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image">
                                            </div>
                                        </a>
                                        <div class="bottom-content">
                                            <div class="star-rating">
                                                <?php
                                                $arr = getProductRating($pid, $vid, 5);
                                                $rating = $arr[0];
                                                while ($rating) {
                                                ?>
                                                    <i class="fas fa-star"></i>
                                                <?php
                                                    $rating--;
                                                } ?>
                                            </div>
                                            <a href="product-details?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-name"><?= htmlspecialchars($row['product_title']); ?></a>
                                            <div class="action-wrap">
                                                <span class="price"> <?php
                                                                                        if ($discount > 0) {
                                                                                            echo "&#8377;" . htmlspecialchars(round($row['price'] - ($discount), 2));
                                                                                        } else {
                                                                                            echo "&#8377;" . htmlspecialchars($row['price']);
                                                                                        }
                                                                                        ?></span>
                                            </div>
                                        </div>
                                        <div class="quick-action-button">
                                            <div class="cta-single cta-plus">
                                                <a href="#"><i class="rt-plus"></i></a>
                                            </div>
                                            <div class="cta-single cta-quickview">
                                                <button class="product-action" onclick="fun2(this)" value="<?= $vid; ?>"><i class="fal fa-eye"></i></button>
                                            </div>
                                            <div class="cta-single cta-wishlist">
                                                <a href="javascript:void(0)" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>" class="product-action"><i class="far fa-heart"></i></a>

                                            </div>
                                            <div class="cta-single cta-addtocart">
                                                <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart"><i class="rt-basket-shopping"></i> Add To
                                                    Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="swiper-slide">
                                <div class="product-item element-item1">
                                    <a href="product-details.html" class="product-image image-hover-variations">
                                        <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img8.webp" alt="product-image">
                                        </div>
                                        <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img8_1.webp" alt="product-image">
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <a href="product-details.html" class="product-name">Underarm Smoothing Bra</a>
                                        <div class="action-wrap">
                                            <span class="price">$31.00</span>
                                        </div>
                                    </div>
                                    <div class="quick-action-button">
                                        <div class="cta-single cta-plus">
                                            <a href="#"><i class="rt-plus"></i></a>
                                        </div>
                                        <div class="cta-single cta-quickview">
                                            <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                        </div>

                                        <div class="cta-single cta-wishlist">
                                            <a href="javascript:void(0)" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>" class="product-action"><i class="far fa-heart"></i></a>

                                        </div>
                                        <div class="cta-single cta-addtocart">
                                            <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart"><i class="rt-basket-shopping"></i> Add To
                                                Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item element-item1">
                                    <a href="product-details.html" class="product-image image-hover-variations">
                                        <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img11.webp" alt="product-image">
                                        </div>
                                        <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img11_1.webp" alt="product-image">
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <a href="product-details.html" class="product-name">Bali Underwire Bra</a>
                                        <div class="action-wrap">
                                            <span class="price">$31.00</span>
                                        </div>
                                    </div>
                                    <div class="quick-action-button">
                                        <div class="cta-single cta-plus">
                                            <a href="#"><i class="rt-plus"></i></a>
                                        </div>
                                        <div class="cta-single cta-quickview">
                                            <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                        </div>
                                        <div class="cta-single cta-wishlist">
                                            <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="cta-single cta-addtocart">
                                            <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item element-item1">
                                    <a href="product-details.html" class="product-image image-hover-variations">
                                        <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img1.jpg" alt="product-image">
                                        </div>
                                        <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img1-1.jpg" alt="product-image">
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <a href="product-details.html" class="product-name">Bali Underwire Bra</a>
                                        <div class="action-wrap">
                                            <span class="price">$31.00</span>
                                        </div>
                                    </div>
                                    <div class="quick-action-button">
                                        <div class="cta-single cta-plus">
                                            <a href="#"><i class="rt-plus"></i></a>
                                        </div>
                                        <div class="cta-single cta-quickview">
                                            <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                        </div>
                                        <div class="cta-single cta-wishlist">
                                            <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="cta-single cta-addtocart">
                                            <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item element-item1">
                                    <a href="product-details.html" class="product-image image-hover-variations">
                                        <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img13.webp" alt="product-image">
                                        </div>
                                        <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img13-1.webp" alt="product-image">
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <a href="product-details.html" class="product-name">Bali Underwire Bra</a>
                                        <div class="action-wrap">
                                            <span class="price">$31.00</span>
                                        </div>
                                    </div>
                                    <div class="quick-action-button">
                                        <div class="cta-single cta-plus">
                                            <a href="#"><i class="rt-plus"></i></a>
                                        </div>
                                        <div class="cta-single cta-quickview">
                                            <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                        </div>
                                        <div class="cta-single cta-wishlist">
                                            <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="cta-single cta-addtocart">
                                            <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item element-item1">
                                    <a href="product-details.html" class="product-image image-hover-variations">
                                        <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img7.webp" alt="product-image">
                                        </div>
                                        <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img7_1.webp" alt="product-image">
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <a href="product-details.html" class="product-name">Maidenform Bra</a>
                                        <div class="action-wrap">
                                            <span class="price">$31.00</span>
                                        </div>
                                    </div>
                                    <div class="quick-action-button">
                                        <div class="cta-single cta-plus">
                                            <a href="#"><i class="rt-plus"></i></a>
                                        </div>
                                        <div class="cta-single cta-quickview">
                                            <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                        </div>
                                        <div class="cta-single cta-wishlist">
                                            <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="cta-single cta-addtocart">
                                            <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-features">
                                        <div class="discount-tag product-tag">-38%</div>
                                        <div class="new-tag product-tag">HOT</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item element-item1">
                                    <a href="product-details.html" class="product-image image-hover-variations">
                                        <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img9.webp" alt="product-image">
                                        </div>
                                        <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img9_1.webp" alt="product-image">
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <a href="product-details.html" class="product-name">Champion Bra</a>
                                        <div class="action-wrap">
                                            <span class="price">$31.00</span>
                                        </div>
                                    </div>
                                    <div class="quick-action-button">
                                        <div class="cta-single cta-plus">
                                            <a href="#"><i class="rt-plus"></i></a>
                                        </div>
                                        <div class="cta-single cta-quickview">
                                            <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                        </div>
                                        <div class="cta-single cta-wishlist">
                                            <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="cta-single cta-addtocart">
                                            <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Hand Picked Section End Here =================-->


    <!--================= Deal Section Start Here =================-->
    <div class="rts-deal-section1">
        <div class="container">
            <div class="section-inner">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="single-inner">
                            <div class="content-box">
                                <div class="sub-content">
                                    <img class="line-1" src="assets/images/banner/wvbo-icon.png" alt="">
                                    <span class="sub-text">Deal Of The Week</span>
                                </div>
                                <h2 class="slider-title">Roland Grand White <br> short T-shirt </h2>
                                <div class="slider-description">
                                    <p>Our intent and our actions have always been informed by progress. We
                                        look at an impact report as a way to measure.</p>
                                </div>
                                <div class="countdown" id="countdown">
                                    <ul>
                                        <li><span id="days"></span>D</li>
                                        <li><span id="hours"></span>H</li>
                                        <li><span id="minutes"></span>M</li>
                                        <li><span id="seconds"></span>S</li>
                                    </ul>
                                </div>
                                <div class="content-bottom">
                                    <div class="img-box"><img src="assets/images/hand-picked/deal-icon.png" alt="">
                                    </div>
                                    <p class="content">Limited time offer. The deal will expires <br>
                                        on November 12, 2022 HURRY UP!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Deal Section End Here =================-->


    <!--================= Featured Product Section Start Here =================-->
    <div class="rts-featured-product-section1">
        <div class="container">
            <div class="rts-featured-product-section-inner">
                <div class="section-header section-header3 text-center">
                    <div class="wrapper">
                        <div class="sub-content">
                            <img class="line-1" src="assets/images/banner/wvbo-icon.png" alt="">
                            <span class="sub-text">Featured</span>
                            <img class="line-2" src="assets/images/banner/wvbo-icon.png" alt="">
                        </div>
                        <h2 class="title">FEATURED PRODUCT</h2>
                    </div>
                </div>
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
                            <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                                <div class="product-item element-item1">
                                    <a href="product-details?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-image image-hover-variations">
                                        <div class="image-vari1 image-vari"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image">
                                        </div>
                                        <div class="image-vari2 image-vari"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image">
                                        </div>
                                    </a>
                                    <div class="bottom-content">
                                        <div class="star-rating">
                                            <?php
                                            $arr = getProductRating($pid, $vid, 5);
                                            $rating = $arr[0];
                                            while ($rating) {
                                            ?>
                                                <i class="fas fa-star"></i>
                                            <?php
                                                $rating--;
                                            } ?>
                                        </div>
                                        <a href="product-details.php?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-name"><?= htmlspecialchars($row['product_title']); ?></a>
                                        <div class="action-wrap">
                                            <span class="price"><?php
                                                                                        if ($discount > 0) {
                                                                                            echo "&#8377;" . htmlspecialchars(round($row['price'] - ($discount), 2));
                                                                                        } else {
                                                                                            echo "&#8377;" . htmlspecialchars($row['price']);
                                                                                        }
                                                                                        ?></span>
                                        </div>
                                    </div>
                                    <div class="quick-action-button">
                                        <div class="cta-single cta-plus">
                                            <a href="#"><i class="rt-plus"></i></a>
                                        </div>
                                        <div class="cta-single cta-quickview">
                                            <button class="product-action" onclick="fun1(this)" value="<?= $vid; ?>"><i class="fal fa-eye"></i></button>
                                        </div>
                                        <div class="cta-single cta-wishlist">
                                            <a href="javascript:void(0)" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>" class="product-action"><i class="far fa-heart"></i></a>

                                        </div>
                                        <div class="cta-single cta-addtocart">
                                            <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart"><i class="rt-basket-shopping"></i> Add To
                                                Cart</a>
                                        </div>
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

                        <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item element-item1">
                                <a href="product-details.html" class="product-image image-hover-variations">
                                    <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img13-1.webp" alt="product-image">
                                    </div>
                                    <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img13.webp" alt="product-image">
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <a href="product-details.html" class="product-name">Girl's Sport Bra</a>
                                    <div class="action-wrap">
                                        <span class="price">$31.00</span>
                                    </div>
                                </div>
                                <div class="quick-action-button">
                                    <div class="cta-single cta-plus">
                                        <a href="#"><i class="rt-plus"></i></a>
                                    </div>
                                    <div class="cta-single cta-quickview">
                                        <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                    <div class="cta-single cta-wishlist">
                                        <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="cta-single cta-addtocart">
                                        <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item element-item1">
                                <a href="product-details.html" class="product-image image-hover-variations">
                                    <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img14.webp" alt="product-image">
                                    </div>
                                    <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img14-1.webp" alt="product-image">
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <a href="product-details.html" class="product-name">Girl's Sport Bra</a>
                                    <div class="action-wrap">
                                        <span class="price">$31.00</span>
                                    </div>
                                </div>
                                <div class="quick-action-button">
                                    <div class="cta-single cta-plus">
                                        <a href="#"><i class="rt-plus"></i></a>
                                    </div>
                                    <div class="cta-single cta-quickview">
                                        <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                    <div class="cta-single cta-wishlist">
                                        <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="cta-single cta-addtocart">
                                        <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item element-item2">
                                <a href="product-details.html" class="product-image image-slider-variations">
                                    <div class="swiper productSlide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img12-1.webp" alt="product-image">
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img11_1.webp" alt="product-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-buttons">
                                        <div class="button-prev slider-btn"><i class="rt-arrow-left-long"></i></div>
                                        <div class="button-next slider-btn"><i class="rt-arrow-right-long"></i></div>
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <a href="product-details.html" class="product-name">Maidenform Bra</a>
                                    <div class="action-wrap">
                                        <span class="price">$31.00</span>
                                    </div>
                                </div>
                                <div class="quick-action-button">
                                    <div class="cta-single cta-plus">
                                        <a href="#"><i class="rt-plus"></i></a>
                                    </div>
                                    <div class="cta-single cta-quickview">
                                        <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                    <div class="cta-single cta-wishlist">
                                        <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="cta-single cta-addtocart">
                                        <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item element-item1">
                                <a href="product-details.html" class="product-image image-hover-variations">
                                    <div class="image-vari1 image-vari"><img src="assets/images/hand-picked/slider-img12.webp" alt="product-image">
                                    </div>
                                    <div class="image-vari2 image-vari"><img src="assets/images/hand-picked/slider-img12-3.webp" alt="product-image">
                                    </div>
                                </a>
                                <div class="bottom-content">
                                    <div class="star-rating">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <a href="product-details.html" class="product-name">Hanes Women's Bra</a>
                                    <div class="action-wrap">
                                        <span class="price">$31.00</span>
                                    </div>
                                </div>
                                <div class="quick-action-button">
                                    <div class="cta-single cta-plus">
                                        <a href="#"><i class="rt-plus"></i></a>
                                    </div>
                                    <div class="cta-single cta-quickview">
                                        <button class="product-details-popup-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                    <div class="cta-single cta-wishlist">
                                        <a href="wishlist.html"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="cta-single cta-addtocart">
                                        <a href="cart.html"><i class="rt-basket-shopping"></i></a>
                                    </div>
                                </div>
                                <div class="product-features">
                                    <div class="discount-tag product-tag">-38%</div>
                                    <div class="new-tag product-tag">HOT</div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!--================= Featured Product Section End Here =================-->


    <!--================= Posters Section Start Here =================-->
    <div class="rts-posters-section1">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
                    <a href="product-details.html" class="product-box product-box-medium product-box-medium5">
                        <div class="contents">
                            <span class="pretitle">50% Offer</span>
                            <h1 class="product-title">Last call for up <br> to 30% off</h1>
                            <div class="view-collections go-btn">VIEW COLLECTIONS <i class="rt-arrow-right-long"></i>
                            </div>
                        </div>
                        <div class="product-thumb"><img src="assets/images/featured/pot.png" alt="product-thumb">
                        </div>
                    </a>
                </div>
                <div class="col-xl-6 col-lg-12 col-sm-12 col-12 last-child">
                    <a href="product-details.html" class="product-box product-box-medium mid">
                        <div class="contents">
                            <span class="pretitle">-45% Offer</span>
                            <h1 class="product-title">SUMMER COLLECTION</h1>
                            <p>Don't miss the last opportunity</p>
                        </div>
                        <div class="product-thumb product-thumb1"><img src="assets/images/products/dress.png" alt="product-thumb"></div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
                    <a href="product-details.html" class="product-box product-box-medium product-box-medium3">
                        <div class="contents">
                            <span class="pretitle">SUMMER DRESS</span>
                            <h1 class="product-title">BEST COLLECTION</h1>
                            <div class="view-collections go-btn">Shop Now <i class="rt-arrow-right-long"></i></div>
                        </div>
                        <div class="product-thumb"><img src="assets/images/featured/3rd-image.png" alt="product-thumb"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--================= Posters Section End Here =================-->


    <!--================= Brand Section Start Here =================-->
    <div class="rts-brands-section1 brand-bg3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="slider-div">
                        <div class="swiper rts-brandSlide1">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a class="brand-front" href="#"><img src="assets/images/brands/client-01.png" alt="Brand Logo"></a>
                                </div>
                                <div class="swiper-slide">
                                    <a class="brand-front" href="#"><img src="assets/images/brands/client-02.png" alt="Brand Logo"></a>
                                </div>
                                <div class="swiper-slide">
                                    <a class="brand-front" href="#"><img src="assets/images/brands/client-03.png" alt="Brand Logo"></a>
                                </div>
                                <div class="swiper-slide">
                                    <a class="brand-front" href="#"><img src="assets/images/brands/client-04.png" alt="Brand Logo"></a>
                                </div>
                                <div class="swiper-slide">
                                    <a class="brand-front" href="#"><img src="assets/images/brands/client-05.png" alt="Brand Logo"></a>
                                </div>
                                <div class="swiper-slide">
                                    <a class="brand-front" href="#"><img src="assets/images/brands/client-06.png" alt="Brand Logo"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Brand Section End Here =================-->


    <!--================= Featured Product Section Start Here =================-->
    <div class="rts-featured-product-section3">
        <div class="container">
            <div class="rts-featured-product-section-inner">
                <div class="section-header section-header3 text-center">
                    <div class="wrapper">
                        <div class="sub-content">
                            <img class="line-1" src="assets/images/banner/wvbo-icon.png" alt="">
                            <span class="sub-text">Featured</span>
                            <img class="line-2" src="assets/images/banner/wvbo-icon.png" alt="">
                        </div>
                        <h2 class="title">LATEST BLOG</h2>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $sql = "SELECT * from post WHERE site_id=$this_site_id and featured=1 order by created_date DESC limit 3";
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
                                <div class="full-wrapper wrapper-1">
                                    <div class="image-part">
                                        <a href="news-details.php?id=<?= $row['id'] ?>" class="image"><img src="<?= htmlspecialchars($row['featured_image']); ?>" alt="Featured Image"></a>
                                    </div>
                                    <div class="blog-content">
                                        <span class="date-full">
                                            <span class="day"><?= date("d", strtotime($row['created_date'])) ?></span>
                                            <br>
                                            <span class="month"><?= date("M", strtotime($row['created_date'])) ?></span>
                                        </span>
                                        <ul class="blog-meta">
                                            <li><a href="#"><?= htmlspecialchars($row['category']); ?></a></li>
                                        </ul>
                                        <div class="title">
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
                                    <span class="date-full">
                                        <span class="day">25</span>
                                        <br>
                                        <span class="month">Jul</span>
                                    </span>
                                    <ul class="blog-meta">
                                        <li><a href="#">WINTER DRESS</a></li>
                                    </ul>
                                    <div class="title">
                                        <a href="#">Once that’s determined with a good, you need to come up with a name</a>
                                    </div>
                                    <div class="author-info d-flex align-items-center">
                                        <div class="avatar"><img src="assets/images/featured/author.png" alt="Author Image"></div>
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
                                    <span class="date-full">
                                        <span class="day">25</span>
                                        <br>
                                        <span class="month">Jul</span>
                                    </span>
                                    <ul class="blog-meta">
                                        <li><a href="#">WINTER DRESS</a></li>
                                    </ul>
                                    <div class="title">
                                        <a href="#">Once determined, you need to come up with a name a legal structure</a>
                                    </div>
                                    <div class="author-info d-flex align-items-center">
                                        <div class="avatar"><img src="assets/images/featured/author.png" alt="Author Image"></div>
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
                                    <span class="date-full">
                                        <span class="day">25</span>
                                        <br>
                                        <span class="month">Jul</span>
                                    </span>
                                    <ul class="blog-meta">
                                        <li><a href="#">WINTER DRESS</a></li>
                                    </ul>
                                    <div class="title">
                                        <a href="#">At the limit, statically generated, edge delivered a food</a>
                                    </div>
                                    <div class="author-info d-flex align-items-center">
                                        <div class="avatar"><img src="assets/images/featured/author.png" alt="Author Image"></div>
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
    ) AND mp.label=2 LIMIT 4";
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
                                                                                                        echo "&#8377;" . htmlspecialchars(round($rowb['price'] - ($discount), 2));
                                                                                                    } else {
                                                                                                        echo "&#8377;" . htmlspecialchars($rowb['price']);
                                                                                                    }
                                                                                                    ?></span>
                                <p>
                                    <?= htmlspecialchars($rowb['product_title']); ?>
                                </p>
                                <div class="product-bottom-action">
                                    <div class="cart-edit">
                                        <!-- <div class="quantity-edit action-item">
                                            <button class="button minus"><i class="fal fa-minus minus"></i></button>
                                            <input type="text" class="input" value="01" />
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


<!-- /index.html / [XR&CO'2014],  19:55:22 GMT -->

</html>