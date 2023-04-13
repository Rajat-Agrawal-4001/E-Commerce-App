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


<!-- /index-five.html / [XR&CO'2014],  19:55:56 GMT -->
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
    <div class="banner banner-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="swiper bannerSlider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="product-details.html" class="product-box product-box-large">
                                    <div class="contents">
                                        <span class="pretitle">Weekend Discount</span>
                                        <h1 class="product-title">Big screens in <br>
                                            incredibly slim <br>
                                            <span>designs...</span>
                                        </h1>
                                        <span class="product-price">
                                            <span>Starts From</span>
                                            $499.99
                                        </span>
                                    </div>
                                    <div class="product-thumb"><img src="assets/images/products/home4/laptop.webp" alt="product-thumb"></div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-box product-box-large">
                                    <div class="contents">
                                        <span class="pretitle">Weekend Discount</span>
                                        <h1 class="product-title">Big screens in <br>
                                            incredibly slim <br>
                                            <span>designs...</span>
                                        </h1>
                                        <span class="product-price">
                                            <span>Starts From</span>
                                            $499.99
                                        </span>
                                    </div>
                                    <div class="product-thumb"><img src="assets/images/products/home4/laptop.webp" alt="product-thumb"></div>
                                </div>
                            </div>
                        </div>
                        <div class="slider-navigation">
                            <div class="swiper-button-prev slider-btn prev"><i class="fal fa-long-arrow-up"></i></div>
                            <div class="swiper-button-next slider-btn next"><i class="fal fa-long-arrow-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <a href="product-details.html" class="product-box product-box-medium">
                                <div class="contents">
                                    <span class="pretitle">-45% Offer</span>
                                    <h1 class="product-title">New
                                        <span>Smartphone</span>
                                    </h1>
                                    <p>Don't miss the last opportunity</p>
                                </div>
                                <div class="product-thumb"><img src="assets/images/products/home4/iphone-13.webp" alt="product-thumb"></div>
                            </a>
                        </div>
                        <div class="col-xl-12">
                            <a href="product-details.html" class="product-box product-box-medium product-box-medium2">
                                <div class="contents">
                                    <span class="pretitle">Great Stores</span>
                                    <h1 class="product-title">Call for up to 30% off</h1>
                                    <div class="view-collections go-btn">View Collections <i class="fal fa-long-arrow-right"></i></div>
                                </div>
                                <div class="product-thumb"><img src="assets/images/products/home4/headphone.webp" alt="product-thumb"></div>
                            </a>
                        </div>
                        <div class="col-xl-12">
                            <a href="product-details.html" class="product-box product-box-medium product-box-medium3 product-box-bg">
                                <div class="contents">
                                    <span class="pretitle">SUPER DISCOUNT</span>
                                    <h1 class="product-title">Home Speaker</h1>
                                    <div class="view-collections go-btn">Shop Now <i class="fal fa-long-arrow-right"></i></div>
                                </div>
                                <div class="product-thumb"><img src="assets/images/products/home4/speaker.webp" alt="product-thumb"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Banner Section End Here =================-->


    <!--================= Newsletter Section Start Here =================-->
    <div class="rts-services-section section-gap">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="service-item">
                        <div class="service-icon"><img src="assets/images/icons/shipment.svg" alt="service-icon"></div>
                        <div class="contents">
                            <h3 class="service-title">International Shipment</h3>
                            <p>Orders are shipped seamlessly
                                between countries</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="service-item">
                        <div class="service-icon"><img src="assets/images/icons/support.svg" alt="service-icon">
                        </div>
                        <div class="contents">
                            <h3 class="service-title">Online Support 24/7</h3>
                            <p>Orders are shipped seamlessly
                                between countries</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="service-item">
                        <div class="service-icon"><img src="assets/images/icons/return.svg" alt="service-icon">
                        </div>
                        <div class="contents">
                            <h3 class="service-title">Money Return</h3>
                            <p>Orders are shipped seamlessly
                                between countries</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="service-item">
                        <div class="service-icon"><img src="assets/images/icons/discount.svg" alt="service-icon"></div>
                        <div class="contents">
                            <h3 class="service-title">Member Discount</h3>
                            <p>Orders are shipped seamlessly
                                between countries</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Newsletter Section End Here =================-->


    <!--================= Featured Products Section Start Here =================-->
    <div class="rts-featured_products-section section-5 section-gap">
        <div class="container">
            <div class="section-header section-header4">
                <span class="section-title section-title-2 mb--5
                ">Featured Products</span>
                <a href="shop-main.html" class="go-btn">All Products <i class="fal fa-long-arrow-right"></i></a>
            </div>
            <div class="products-area">
                <div class="swiper rts-fiveSlide">
                    <div class="swiper-wrapper">
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
                                <div class="swiper-slide">
                                    <div class="product-item product-item4">
                                        <a href="product-details.php?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-image">
                                            <img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image">
                                        </a>
                                        <div class="bottom-content">
                                            <span class="product-catagory"><?= htmlspecialchars($row['cat_id']); ?></span>
                                            <a href="product-details.php?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-name"><?= htmlspecialchars($row['product_title']); ?></a>
                                            <div class="flex-wrap">
                                                <div class="action-wrap">
                                                    <span class="product-price"><?php
                                                                                        if ($discount > 0) {
                                                                                            echo "&#8377;" . htmlspecialchars(round($row['price'] - ($discount), 2));
                                                                                        } else {
                                                                                            echo "&#8377;" . htmlspecialchars($row['price']);
                                                                                        }
                                                                                        ?></span>
                                                    <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart"><i class="fal fa-shopping-cart"></i>
                                                        Add
                                                        To
                                                        Cart</a>
                                                </div>
                                                <button class="wishlist-btn" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>"><i class="rt-heart"></i></button>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php }
                        } else {
                            ?>


                            <div class="swiper-slide">
                                <div class="product-item product-item4">
                                    <a href="product-details.html" class="product-image">
                                        <img src="assets/images/products/home4/1.png" alt="product-image">
                                    </a>
                                    <div class="bottom-content">
                                        <span class="product-catagory">Electronics</span>
                                        <a href="product-details.html" class="product-name">Pronix Smart Laptop</a>
                                        <div class="flex-wrap">
                                            <div class="action-wrap">
                                                <span class="product-price">$230,00</span>
                                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i>
                                                    Add
                                                    To
                                                    Cart</a>
                                            </div>
                                            <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item product-item4">
                                    <a href="product-details.html" class="product-image">
                                        <img src="assets/images/products/home4/2.png" alt="product-image">
                                    </a>
                                    <div class="bottom-content">
                                        <span class="product-catagory">Electronics</span>
                                        <a href="product-details.html" class="product-name">Pronix Smart Laptop</a>
                                        <div class="flex-wrap">
                                            <div class="action-wrap">
                                                <span class="product-price">$230,00</span>
                                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i>
                                                    Add
                                                    To
                                                    Cart</a>
                                            </div>
                                            <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item product-item4">
                                    <a href="product-details.html" class="product-image">
                                        <img src="assets/images/products/home4/3.png" alt="product-image">
                                    </a>
                                    <div class="bottom-content">
                                        <span class="product-catagory">Electronics</span>
                                        <a href="product-details.html" class="product-name">Pronix Camera</a>
                                        <div class="flex-wrap">
                                            <div class="action-wrap">
                                                <span class="product-price">$230,00</span>
                                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i>
                                                    Add
                                                    To
                                                    Cart</a>
                                            </div>
                                            <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item product-item4">
                                    <a href="product-details.html" class="product-image">
                                        <img src="assets/images/products/home4/5.png" alt="product-image">
                                    </a>
                                    <div class="bottom-content">
                                        <span class="product-catagory">Electronics</span>
                                        <a href="product-details.html" class="product-name">Extra Powerful PC Cooler</a>
                                        <div class="flex-wrap">
                                            <div class="action-wrap">
                                                <span class="product-price">$230,00</span>
                                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i>
                                                    Add
                                                    To
                                                    Cart</a>
                                            </div>
                                            <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-item product-item4">
                                    <a href="product-details.html" class="product-image">
                                        <img src="assets/images/products/home4/6.png" alt="product-image">
                                    </a>
                                    <div class="bottom-content">
                                        <span class="product-catagory">Electronics</span>
                                        <a href="product-details.html" class="product-name">Extra Powerful PC Cooler</a>
                                        <div class="flex-wrap">
                                            <div class="action-wrap">
                                                <span class="product-price">$230,00</span>
                                                <a href="cart.html" class="addto-cart"><i class="fal fa-shopping-cart"></i>
                                                    Add
                                                    To
                                                    Cart</a>
                                            </div>
                                            <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="pagination-area">
                        <div class="swiper-pag"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Featured Products Section End Here =================-->


    <!--================= Posters Section Start Here =================-->
    <div class="rts-posters-section section-5 section-gap">
        <div class="container">
            <div class="row">
                <div class="col-xl-3">
                    <a href="product-details.html" class="product-box product-box-medium product-box-medium2">
                        <div class="contents">
                            <span class="pretitle">Great Stores</span>
                            <h1 class="product-title">Last Call for up <br> to 30% off</h1>
                            <div class="view-collections go-btn">View Collections <i class="fal fa-long-arrow-right"></i></div>
                        </div>
                        <div class="product-thumb"><img src="assets/images/products/home4/pot.png" alt="product-thumb">
                        </div>
                    </a>
                </div>
                <div class="col-xl-6">
                    <a href="product-details.html" class="product-box product-box-medium mid">
                        <div class="contents">
                            <span class="pretitle">-45% Offer</span>
                            <h1 class="product-title">New
                                <span>Smartphone</span>
                            </h1>
                            <p>Don't miss the last opportunity</p>
                        </div>
                        <div class="product-thumb"><img src="assets/images/products/home4/phones.png" alt="product-thumb"></div>
                    </a>
                </div>
                <div class="col-xl-3">
                    <a href="product-details.html" class="product-box product-box-medium product-box-medium3">
                        <div class="contents">
                            <span class="pretitle">ELECTRONICS</span>
                            <h1 class="product-title">Home Speaker</h1>
                            <div class="view-collections go-btn">Shop Now <i class="fal fa-long-arrow-right"></i></div>
                        </div>
                        <div class="product-thumb"><img src="assets/images/products/home4/machine.png" alt="product-thumb"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--================= Posters Section End Here =================-->


    <!--================= Deal Section Start Here =================-->
    <div class="rts-deal-section section-gap">
        <div class="container position-relative">
            <div class="section-header section-header4">
                <div class="flex-wrapper">
                    <span class="section-title section-title-2 mb--5
                ">Super Deals Of The Week</span>
                    <div class="countdown" id="countdown">
                        <ul>
                            <li><span id="days"></span>D</li>
                            <li><span id="hours"></span>H</li>
                            <li><span id="minutes"></span>M</li>
                            <li><span id="seconds"></span>S</li>
                        </ul>
                    </div>
                </div>
                <a href="shop-main.html" class="go-btn">All Products <i class="fal fa-long-arrow-right"></i></a>
            </div>
            <div class="swiper oneSlide">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="deal-box">
                            <div class="deal-box-inner">
                                <div class="deal-product">
                                    <div class="filter-buttons">
                                        <div class="filter-btn" data-show=".one"><img src="assets/images/products/home4/deal/1.png" alt="filter-image"></div>
                                        <div class="filter-btn" data-show=".two"><img src="assets/images/products/home4/deal/2.png" alt="filter-image"></div>
                                        <div class="filter-btn" data-show=".three"><img src="assets/images/products/home4/deal/3.png" alt="filter-image"></div>
                                        <div class="filter-btn last-child" data-show=".four"><img src="assets/images/products/home4/deal/4.png" alt="filter-image"></div>
                                    </div>
                                    <div class="product-area">
                                        <div class="product detail-product one filterd-items">
                                            <div class="product-thumb"><img src="assets/images/products/home4/deal/product.png" alt="product-thumb"></div>
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
                                                <h2 class="product-title">Dragon Touch Max10 Tablet
                                                    Android 10.0 OS</h2>
                                                <span class="product-price">$129.99 <span class="old-price">$349.99</span></span>
                                                <div class="product-buttons">
                                                    <button class="select-option-btn"><i class="fal fa-shopping-cart mr--5"></i> Select
                                                        Option</button>
                                                    <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                                    <button class="exchange-btn"><i class="fal fa-exchange"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product detail-product two filterd-items hide">
                                            <div class="product-thumb"><img src="assets/images/products/home4/deal/product.png" alt="product-thumb"></div>
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
                                                <h2 class="product-title">Dragon Touch Max10 Tablet
                                                    Android 10.0 OS</h2>
                                                <span class="product-price">$129.99 <span class="old-price">$349.99</span></span>
                                                <div class="product-buttons">
                                                    <button class="select-option-btn"><i class="fal fa-shopping-cart mr--5"></i> Select
                                                        Option</button>
                                                    <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                                    <button class="exchange-btn"><i class="fal fa-exchange"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product detail-product three filterd-items hide">
                                            <div class="product-thumb"><img src="assets/images/products/home4/deal/product.png" alt="product-thumb"></div>
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
                                                <h2 class="product-title">Dragon Touch Max10 Tablet
                                                    Android 10.0 OS</h2>
                                                <span class="product-price">$129.99 <span class="old-price">$349.99</span></span>
                                                <div class="product-buttons">
                                                    <button class="select-option-btn"><i class="fal fa-shopping-cart mr--5"></i> Select
                                                        Option</button>
                                                    <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                                    <button class="exchange-btn"><i class="fal fa-exchange"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product detail-product four filterd-items hide">
                                            <div class="product-thumb"><img src="assets/images/products/home4/deal/product.png" alt="product-thumb"></div>
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
                                                <h2 class="product-title">Dragon Touch Max10 Tablet
                                                    Android 10.0 OS</h2>
                                                <span class="product-price">$129.99 <span class="old-price">$349.99</span></span>
                                                <div class="product-buttons">
                                                    <button class="select-option-btn"><i class="fal fa-shopping-cart mr--5"></i> Select
                                                        Option</button>
                                                    <button class="wishlist-btn"><i class="rt-heart"></i></button>
                                                    <button class="exchange-btn"><i class="fal fa-exchange"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-box">
                                    <div class="product">
                                        <div class="product-thumb"><img src="assets/images/products/home4/deal/side-product.png" alt="product-thumb"></div>
                                        <div class="contents">
                                            <span class="product-catagory">Electronics</span>
                                            <h2 class="product-title">Samsung Ultra Wide 92” Monitor</h2>
                                            <span class="product-price">$230,00<span class="old-price">$460,00</span></span>
                                            <button class="cart-btn"><i class="fal fa-shopping-cart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-navigation">
            <div class="swiper-button-prev slider-btn prev"><i class="fal fa-long-arrow-left"></i></div>
            <div class="swiper-button-next slider-btn next"><i class="fal fa-long-arrow-right"></i></div>
        </div>
    </div>
    <!--================= Deal Section End Here =================-->


    <!--================= Newsletter Section Start Here =================-->
    <div class="rts-best-catagory-section section-gap">
        <div class="container">
            <div class="section-header section-header4">
                <span class="section-title section-title-2 mb--5
                ">Best Category</span>
                <a href="shop-main.html" class="go-btn">Other Category <i class="fal fa-long-arrow-right"></i></a>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Cell Phones</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.html">iPhone <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Phone Accessories <i class="fal fa-angle-right"></i></a>
                                </li>
                                <li><a href="category.html">Phone Cases <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Postpaid Phones <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.html" class="all-btn">All Cell Phones <i class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="assets/images/products/home4/catagory/1.png" alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Headphones</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.html">Noise Canceling <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Over-EAR <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Premium Headphones <i class="fal fa-angle-right"></i></a>
                                </li>
                                <li><a href="category.html">Sports & Fitness <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.html" class="all-btn">Headphones <i class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="assets/images/products/home4/catagory/2.png" alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Watches</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.html">Sport Watches <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Timex Watches <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Watch Brands <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Women Watches <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.html" class="all-btn">All Watches <i class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="assets/images/products/home4/catagory/3.png" alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Monitors</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.html">Gaming <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Ultra Wide <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">Office <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.html">TV <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.html" class="all-btn">All Monitors <i class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="assets/images/products/home4/catagory/4.png" alt="category-thumb"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Newsletter Section End Here =================-->


    <!--================= Feeds Section Start Here =================-->
    <div class="rts-feeds-section rts-feeds-section2 section-gap">
        <div class="container">
            <div class="section-header section-header4">
                <span class="section-title section-title-2 mb--5
                ">Blog & Insights</span>
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
                                <a href="news-details.php?id=<?= $row['id'] ?>" class="feed-image"><img src="<?= htmlspecialchars($row['featured_image']); ?>" alt="Featured Image"></a>
                                <div class="contents">
                                    <div class="feed-info">
                                        <a href="category.html" class="feed-catagory"><?= htmlspecialchars($row['category']); ?></a>
                                    </div>
                                    <h2 class="feed-title"><a href="news-details.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['post_title']); ?></a></h2>
                                    <div class="author">
                                        <div class="author-dp"><img src="<?= htmlspecialchars($row2['profile_pic']); ?>" alt="author-dp" style="border-radius: 50%; height: 40px; width: 40px;"></div>
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
                            <div class="contents">
                                <div class="feed-info">
                                    <a href="category.html" class="feed-catagory">Electronics</a>
                                </div>
                                <h2 class="feed-title"><a href="news-details.html">The post-pandemic consumer is embracing
                                        secondhand clothes</a></h2>
                                <div class="author">
                                    <div class="author-dp"><img src="assets/images/items/author1.png" alt="author-dp"></div>
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
                            <div class="contents">
                                <div class="feed-info">
                                    <a href="category.html" class="feed-catagory">Electronics</a>
                                </div>
                                <h2 class="feed-title"><a href="news-details.html">The post-pandemic consumer is embracing
                                        secondhand clothes</a></h2>
                                <div class="author">
                                    <div class="author-dp"><img src="assets/images/items/author1.png" alt="author-dp"></div>
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
                            <div class="contents">
                                <div class="feed-info">
                                    <a href="category.html" class="feed-catagory">Electronics</a>
                                </div>
                                <h2 class="feed-title"><a href="news-details.html">The post-pandemic consumer is embracing
                                        secondhand clothes</a></h2>
                                <div class="author">
                                    <div class="author-dp"><img src="assets/images/items/author1.png" alt="author-dp"></div>
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


    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->


    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1 scroll-top-btn2"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->
    <?php include 'common_scripts.php'; ?>
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


<!-- /index-five.html / [XR&CO'2014],  19:56:13 GMT -->

</html>