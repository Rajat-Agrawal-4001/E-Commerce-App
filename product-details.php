<?php
session_start();
include 'config/connection.php';
include 'modify_cart_n_wishlist.php';


if (isset($_GET['id']) && isset($_GET['vid'])) {
    $p_id = urldecode(base64_decode($_GET['id']));
    $v_id = urldecode(base64_decode($_GET['vid']));
}
$vendor_id = getVendorID();
if (isset($_POST['qty'])) {
$result='';
    $qty = realEscape($_POST['qty']);
    for ($i = 0; $i < $qty; $i++) {
        $result .= modify_cart_n_wishlist('5', $p_id, 'CART', false, $v_id);
    }
    echo $result;
    die;
}
if (isset($_POST['wish'])) {

    $result = modify_cart_n_wishlist('5', $p_id, 'WISHLIST', false, $v_id);
    echo $result;

    die;
}
if (isset($_POST['buy']) && isset($_POST['quantity'])) {

    $qty = realEscape($_POST['quantity']);
    for ($i = 0; $i < $qty; $i++) {
        $r = modify_cart_n_wishlist('5', $p_id, 'CART', false, $v_id);
    }
    die;
}

if (isset($_POST['counter'])) {
    $sql = "update marketplace_products set views= views + 1 where site_id=$this_site_id and id='$p_id'";
    $rs = mysqli_query($conn, $sql);
    if (!$rs) {
        errlog(mysqli_error($conn), $sql);
    }
    die;
}

if (isset($_POST['message'], $_POST['name'], $_POST['email2'], $_POST['rating'])) {

    $msg = realEscape($_POST['message']);
    $name = realEscape($_POST['name']);
    $email = realEscape($_POST['email2']);
    $rate = realEscape($_POST['rating']);
    $vendor_id = getVendorID();

    $sql1 = "SELECT * from product_rating where site_id=$this_site_id and marketplace_id=5 and item_id=$p_id and vendor_id=$vendor_id";
    $rs = mysqli_query($conn, $sql1);
    if (!$rs) {
        errlog(mysqli_error($conn), $sql1);
    }
    if (mysqli_num_rows($rs) > 0) {

        $sql = "UPDATE product_rating set rating='$rate',comment='$msg',modified='$curr_date' where site_id=$this_site_id and marketplace_id=5 and item_id=$p_id and vendor_id=$vendor_id";
    } else {
        $sql = "INSERT into product_rating(site_id,marketplace_id,item_id,vendor_id,rating,title,comment,status,created,modified) values('$this_site_id','5','$p_id','$vendor_id','$rate','$name','$msg','1','$curr_date','$curr_date')";
    }

    $res1 = mysqli_query($conn, $sql);
    if (!$res1) {
        errlog(mysqli_error($conn), $sql);
    } else {
        echo 1;
    }
    die;
}

$sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid,ad.id as admin from marketplace_products mp inner join product_variants v on mp.id=v.product_id 
inner join vendor vd on vd.id=mp.vendor_id 
LEFT JOIN admin ad ON ad.vendor_id = vd.id

WHERE 
    (
        (mp.site_id = $this_site_id AND mp.status = 1 AND mp.verified = 1) 

        OR (mp.site_id = ad.site_id AND (mp.status = 1 OR mp.status = 0) AND (mp.verified = 1 OR mp.verified = 0) )
    ) AND mp.id='$p_id' AND v.id='$v_id'";

$result = mysqli_query($conn, $sql);
if (!$result) {
    errlog(mysqli_error($conn), $sql);
}
$row = mysqli_fetch_assoc($result);
$sql = "select image_url from product_images where product_id=$p_id and marketplace_id='5' and type='IMAGE' and variant_id=$v_id";
$result2 = mysqli_query($conn, $sql);
if (!$result2) {
    errlog(mysqli_error($conn), $sql);
}
$row2 = mysqli_fetch_assoc($result2);
$price1 = $row['price'];
$qry = "
                    SELECT
                        (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,
                        
                        (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
                        
                        FROM marketplace_products mrp 
                        INNER JOIN product_variants pv ON pv.product_id = mrp.id
                        
                    WHERE mrp.id = '" . $p_id . "' ";


$res2 = mysqli_query($conn, $qry);
if (!$res2) {
    errlog(mysqli_error($conn), $qry);
}

$dis_res = mysqli_fetch_assoc($res2);
$discount1 = 0;
if ($dis_res['discount_per'] > 0) {
    $discount1 = ((float)$dis_res['discount_per']) * $price1 / 100;
}

if ($dis_res['discount_amount'] > 0) {
    $discount1 += ((float)$dis_res['discount_amount']);
}

$flag = false;
if (isset($_POST['review'])) {

    $vid = -1;
    if (isset($_SESSION['vendor_id']) || isset($_SESSION['user_id'])) {
        $id = realEscape($row['pid']);
        if (isset($_SESSION['vendor_id'])) {
            $vid = $_SESSION['vendor_id'];
        }
        if (isset($_SESSION['user_id'])) {
            $vid = $_SESSION['user_id'];
        }
        $site_id = realEscape($row['psid']);

        $sql = "SELECT * from orders where site_id=$site_id and vendor_id=$vid and item_id=$id";
        $res2 = mysqli_query($conn, $sql);
        if (!$res2) {
            errlog(mysqli_error($conn), $sql);
        }
        if (mysqli_num_rows($res2) > 0) {
            $flag = true;
        }
        if ($flag == false) {
            echo 0;
        }
        if ($flag == true) {
            echo 1;
        }
    } else if (getVendorID() < 0) {

        echo -1;
    }
    die;
}
?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /product-details.html / [XR&CO'2014],  19:56:35 GMT -->
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
    <!--================= Product-details Section Start Here =================-->
    <div class="rts-product-details-section section-gap">
        <div class="container">
            <?php
            $sql = "SELECT image_url from product_images where product_id=$p_id and marketplace_id='5' and type='IMAGE' and main='0'";
            $result3 = mysqli_query($conn, $sql);
            if (!$result3) {
                errlog(mysqli_error($conn), $sql);
            }
            $arr = array();
            while ($row3 = mysqli_fetch_assoc($result3)) {
                $arr[] = $row3['image_url'];
            };
            ?>
            <div class="details-product-area mb--70">
                <div class="product-thumb-area" style="height:300px; width:450px;">
                    <div class="cursor"></div>
                    <div class="thumb-wrapper one filterd-items figure">
                        <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url(<?= htmlspecialchars($row2['image_url']); ?>)"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-thumb">
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

                        <div class="thumb-filter filter-btn active" data-show=".one"><img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-thumb-filter"></div>
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
                        <span class="product-catagory"><?= htmlspecialchars($row['cat_id']); ?></span>
                        <div class="rating-stars-group">
                            <?php
                            $arr = getProductRating($p_id, $v_id, 5);
                            $rating = $arr[0];
                            while ($rating) {
                            ?>
                                <div class="rating-star"><i class="fas fa-star"></i></div>
                            <?php
                                $rating--;
                            } ?>
                            <!--<div class="rating-star"><i class="fas fa-star-half-alt"></i></div>-->
                            <?php if ($arr[1] > 0) { ?> <span><?= $arr[1]; ?> Reviews</span><?php } ?>
                        </div>
                    </div>
                    <h2 class="product-title"><?= htmlspecialchars($row['product_title']); ?> <span class="stock"><?php
                                                                                                                    if ($row['available'] == 1) {
                                                                                                                        echo "In Stock";
                                                                                                                    }
                                                                                                                    if ($row['available'] == 0) {
                                                                                                                        echo "Out of Stock";
                                                                                                                    }
                                                                                                                    ?></span></h2>
                    <span class="product-price"><span class="old-price"> <?php
                                                                            if ($discount1 > 0) {
                                                                                echo "&#8377;" . htmlspecialchars($price1);
                                                                            }
                                                                            ?></span> <?php
                                                                                        if ($discount1 > 0) {
                                                                                            echo "&#8377;" . htmlspecialchars(round($price1 - ($discount1), 2));
                                                                                        } else {
                                                                                            echo "&#8377;" . htmlspecialchars($price);
                                                                                        }
                                                                                        ?></span>
                    <?php
                    if ($discount1 > 0) {
                    ?>
                        <span style="margin-left: 20px; color: #777777;">

                            <?php echo  htmlspecialchars(($discount1 * 100 / $price1)) . "  % Off"; ?>
                        </span>
                    <?php } ?>
                    <p>
                        <?= decoder($row['description']); ?>
                    </p>
                    <div class="product-bottom-action">
                        <div class="cart-edit">
                            <div class="quantity-edit action-item">
                                <button class="button"><i class="fal fa-minus minus"></i></button>
                                <input type="text" id="qty" class="input" value="1" />
                                <button class="button plus">+<i class="fal fa-plus plus"></i></button>
                            </div>
                        </div>
                        <script>
                            function addCart(e) {
                                var qty = document.getElementById("qty").value;
                                $.ajax({
                                    method: "POST",
                                    data: {
                                        qty: qty
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        if (data == '1') {
                                            Swal.fire("Item added in Cart.", "", "success");
                                        } else if (data == '0') {
                                            Swal.fire("Not Added.", "", "error");
                                        } else {
                                            Swal.fire(data, "", "success");
                                        }
                                    }
                                })
                                //  alert(qty);
                            }

                            function addWishlist(e) {
                                $.ajax({
                                    method: "POST",
                                    data: {
                                        wish: true
                                    },
                                    success: function(data) {
                                        if (data == '1') {
                                            Swal.fire("Item added in Wishlist.", "", "success");
                                        } else if (data == '0') {
                                            Swal.fire("Not Added.", "", "error");
                                        } else {
                                            Swal.fire(data, "", "success");
                                        }
                                    }
                                })
                                //  alert(qty);
                            }

                            function buy(e) {
                                var qty = document.getElementById("qty").value;
                                $.ajax({
                                    method: "POST",
                                    data: {
                                        buy: true,
                                        quantity: qty
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        window.location.href = 'cart.php';
                                    }
                                })
                                //  alert(qty);
                            }
                        </script>
                        <a href="javascript:void(0)" value="" onclick="addCart(this)" class="addto-cart-btn action-item"><i class="rt-basket-shopping"></i> Add To
                            Cart</a>
                        <a href="javascript:void(0)" value="" onclick="buy(this)" class="addto-cart-btn border action-item" style="background-color: green;"><i class="rt-basket-shopping"></i> Buy </a>

                        <a href="javascript:void(0)" onclick="addWishlist(this)" class="wishlist-btn action-item"><i class="rt-heart"></i></a>
                    </div>
                    <div class="product-uniques">
                        <span class="sku product-unipue"><span>SKU: </span> <?= htmlspecialchars($row['SUK']); ?></span>
                        <span class="catagorys product-unipue"><span>Categories: </span> <?= htmlspecialchars($row['cat_id']); ?></span>
                        <span class="tags product-unipue"><span>Tags: </span> <?= htmlspecialchars($row['tags']); ?>

                        </span>
                    </div>
                    <div class="action-item2">
                        <div class="action-top">
                            <span class="action-title">Color : <strong> <?= htmlspecialchars($row['color']); ?></strong> </span>
                        </div>
                        <?php
                        $sql = "SELECT mp.*,v.*,mp.id as pid,v.id as vid from marketplace_products mp join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.id='$p_id'";
                        $res = mysqli_query($conn, $sql);
                        if (!$res) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        if (mysqli_num_rows($res) > 0) {
                            while ($r = mysqli_fetch_assoc($res)) {
                                if ($r['color'] == '') {
                                    continue;
                                }
                                $c_id = realEscape($r['pid']);
                                $cv_id = realEscape($r['vid']);
                        ?>
                                <a href="product-details.php?id=<?= urlencode(base64_encode($c_id)) ?>&vid=<?= urlencode(base64_encode($cv_id)) ?>">
                                    <div class="color-item2">
                                        <div class="color black" style="background-color:<?= $r['color'] ?>;" data-bs-toggle="tooltip" data-bs-placement="top" title="Black"></div>
                                    </div>
                                </a>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="color-item2">
                                <div class="color black" data-bs-toggle="tooltip" data-bs-placement="top" title="Black"></div>
                            </div>
                            <div class="color-item2">
                                <div class="color blue" data-bs-toggle="tooltip" data-bs-placement="top" title="Blue"></div>
                            </div>
                            <div class="color-item2">
                                <div class="color gray" data-bs-toggle="tooltip" data-bs-placement="top" title="Gray"></div>
                            </div>
                            <div class="color-item2">
                                <div class="color green" data-bs-toggle="tooltip" data-bs-placement="top" title="Green"></div>
                            </div>
                            <div class="color-item2">
                                <div class="color red" data-bs-toggle="tooltip" data-bs-placement="top" title="Red"></div>
                            </div>
                            <div class="color-item2">
                                <div class="color yellow" data-bs-toggle="tooltip" data-bs-placement="top" title="Yellow"></div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="action-item3">
                        <div class="action-top">
                            <span class="action-title">Size : <strong> <?= htmlspecialchars($row['size']); ?></strong></span>
                        </div>
                        <?php
                        $sql = "SELECT mp.*,v.*,mp.id as pid,v.id as vid from marketplace_products mp join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.id='$p_id'";
                        $res = mysqli_query($conn, $sql);
                        if (!$res) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        if (mysqli_num_rows($res) > 0) {
                            while ($r = mysqli_fetch_assoc($res)) {
                                if ($r['size'] == '') {
                                    continue;
                                }
                        ?>
                                <div class="color-item2">
                                    <div class="size" data-bs-toggle="tooltip" data-bs-placement="top" title="XXL"><?= $r['size'] ?></div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>


                            <div class="color-item2">
                                <div class="size" data-bs-toggle="tooltip" data-bs-placement="top" title="XXL">XXL</div>
                            </div>
                            <div class="color-item2">
                                <div class="size" data-bs-toggle="tooltip" data-bs-placement="top" title="XL">XL</div>
                            </div>
                            <div class="color-item2">
                                <div class="size" data-bs-toggle="tooltip" data-bs-placement="top" title="L">L</div>
                            </div>
                            <div class="color-item2">
                                <div class="size" data-bs-toggle="tooltip" data-bs-placement="top" title="M">M</div>
                            </div>
                            <div class="color-item2">
                                <div class="size" data-bs-toggle="tooltip" data-bs-placement="top" title="S">S</div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="share-social">
                        <span>Share:</span>
                        <a class="platform" href="http://facebook.com/sharer.php?u=<?php echo $this_site_url . '/product-details?id=' . urlencode(base64_encode($p_id)) . '&vid=' . urlencode(base64_encode($v_id)); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a class="platform" href="http://twitter.com/share?text=share&url=<?php echo $this_site_url . '/product-details?id=' . urlencode(base64_encode($p_id)) . '&vid=' . urlencode(base64_encode($v_id)); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a class="platform" href="http://behance.com/" target="_blank"><i class="fab fa-behance"></i></a>
                        <a class="platform" href="http://youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a class="platform" href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo $this_site_url . '/product-details?id=' . urlencode(base64_encode($p_id)) . '&vid=' . urlencode(base64_encode($v_id)); ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <?php
            $sql = "SELECT * from product_rating where site_id=$this_site_id and marketplace_id=5 and item_id='$p_id'";
            $rating_res = mysqli_query($conn, $sql);
            if (!$rating_res) {
                errlog(mysqli_error($conn), $sql);
            }
            ?>
            <div class="product-full-details-area">
                <div class="details-filter-bar2">
                    <button class="details-filter filter-btn active" data-show=".dls-one">Description</button>
                    <button class="details-filter filter-btn" data-show=".dls-two">Additional information</button>
                    <button class="details-filter filter-btn" data-show=".dls-three">Reviews (<?= mysqli_num_rows($rating_res); ?>)</button>
                </div>
                <div class="full-details dls-one filterd-items">
                    <div class="full-details-inner">
                        <p class="mb--30"><?= decoder($row['description']); ?></p>

                    </div>
                </div>
                <div class="full-details dls-two filterd-items hide">
                    <div class="full-details-inner">
                        <p class="mb--30">In marketing a product is an object or system made available for consumer use
                            it is anything that can be offered to a market to satisfy the desire or need of a customer.
                            In retailing, products are
                            merchandise, and in manufacturing, products are bought as raw materials and then sold as
                            finished goods. A service is also regarded to as a type of product. Commodities are usually
                            raw material
                            and agricultural products, but a commodity can also be anything widely available in the open
                            market. In project management, products are the formal definition of the project
                            deliverables that
                            to delivering the objectives of the project.</p>

                    </div>
                </div>
                <div class="full-details dls-three filterd-items hide">
                    <div class="full-details-inner">
                        <p> <?php if (mysqli_num_rows($rating_res) <= 0) {
                                echo "There are no reveiws yet.";
                            } ?></p>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mr-10">
                                <div class="reveiw-form">
                                    <h2 class="section-title">
                                        <?php if (mysqli_num_rows($rating_res) > 0) {
                                            echo "Write review for";
                                        } else {
                                            echo "Be the first to reveiw";
                                        }
                                        ?> <strong> <a href="product-details.html">"<?= $row['product_title']; ?>"</a></strong></h2>
                                    <h4 class="sect-title">Your email address will not be published. Required fields are marked* </h4>
                                    <?php
                                    $sql1 = "SELECT * from product_rating where site_id=$this_site_id and marketplace_id=5 and item_id='$p_id' and vendor_id='$vendor_id'";
                                    $rs = mysqli_query($conn, $sql1);
                                    if (!$rs) {
                                        errlog(mysqli_error($conn), $sql1);
                                    }
                                    $r = array();
                                    $str = '';
                                    $str2 = '';
                                    if (mysqli_num_rows($rs) > 0) {
                                        $sql = "SELECT avg(rating) as rating, count(id) as reviews,title,comment from product_rating where site_id=$this_site_id and marketplace_id=5 and item_id=$p_id and status=1 and vendor_id='$vendor_id'";

                                        $res = mysqli_query($conn, $sql1);
                                        if (!$res) {
                                            errlog(mysqli_error($conn), $sql1);
                                        }
                                        $r = mysqli_fetch_assoc($res);
                                        //  die($r['rating']);
                                        $str = 'Edit Review';
                                        $str2 = 'Update';
                                        if ($vendor_id <= 0) {
                                            $str = 'Write Review';
                                            $str2 = 'Submit';
                                        }
                                    } else {
                                        $str = 'Write Review';
                                        $str2 = 'Submit';
                                        //  print_r($rs);
                                    }

                                    ?>
                                    <button class="btn btn-primary mt-2" value="" onclick="review(this)"><?= $str; ?></button>



                                    <div class="reveiw-form-main mb-10" id="reveiw_div" style="display:none;">
                                        <div class="contact-form">
                                            <form id="review_form" method="post" action="#">
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="input-box text-input mb-20">
                                                            <textarea name="message" id="message" cols="30" rows="10" placeholder="Your Review*"><?= $r['comment'] ?? ''; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="col-lg-12">
                                                            <div class="input-box mb-20">
                                                                <input type="text" value="<?= $r['title'] ?? ''; ?>" id="name" name="name" placeholder="Name*">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="input-box mail-input mb-20">
                                                                <input type="email" value="" id="email2" name="email2" placeholder="E-mail*">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="rating">
                                                                <p>Your Rating :</p>
                                                                <div class="rating-icon" id="stars">
                                                                    <span class="one" data-id="1"><a href="javascript:void(0)"> <i class="fal fa-star "></i></a></span>
                                                                    <span class="two" data-id="2"><a href="javascript:void(0)"> <i class="fal fa-star <?php if ((int)($r['rating']) >= 2) echo "fas"; ?>"></i></a></span>
                                                                    <span class="three" data-id="3"><a href="javascript:void(0)"> <i class="fal fa-star <?php if ((int)($r['rating']) >= 3) echo "fas"; ?>"></i></a></span>
                                                                    <span class="four" data-id="4"><a href="javascript:void(0)"> <i class="fal fa-star <?php if ((int)($r['rating'] >= 4)) echo "fas"; ?>"></i></a></span>
                                                                    <span class="five" data-id="5"><a href="javascript:void(0)"> <i class="fal fa-star <?php if ((int)($r['rating']) >= 5) echo "fas"; ?>"></i></a></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-15">
                                                            <input type="hidden" value="0" id="rating" name="rating">
                                                            <button class="form-btn form-btn4" type="submit">
                                                                <?= $str2; ?> <i class="fal fa-long-arrow-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
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
    <!--================= Product-details Section End Here =================-->

    <!--================= Related Product Section Start Here =================-->
    <div class="rts-featured-product-section1 related-product">
        <div class="container">
            <div class="rts-featured-product-section-inner">
                <div class="section-header section-header3 section-header6">
                    <div class="wrapper">
                        <h2 class="title">RELATED PRODUCT</h2>
                    </div>
                </div>
                <div class="row">

                    <?php
                    $cat = realEscape($row['cat_id']);
                    $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid,ad.id as admin from marketplace_products mp inner join product_variants v on mp.id=v.product_id 
inner join vendor vd on vd.id=mp.vendor_id 
LEFT JOIN admin ad ON ad.vendor_id = vd.id

WHERE 
    (
        (mp.site_id = $this_site_id AND mp.status = 1 AND mp.verified = 1) 

        OR (mp.site_id = ad.site_id AND (mp.status = 1 OR mp.status = 0) AND (mp.verified = 1 OR mp.verified = 0) )
    ) AND mp.cat_id='$cat' limit 4";

                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        errlog(mysqli_error($conn), $sql);
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            $pid = realEscape($row['pid']);
                            $vid = realEscape($row['vid']);
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
                                        <a href="product-details?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-name"><?= htmlspecialchars($row['product_title']); ?></a>
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
                                            <button><i class="far fa-eye" onclick="fun1(this)" value="<?= $vid ?>"></i></button>
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
                                                                                                                                                echo 'assets/images/products/product-filt3.jpg';
                                                                                                                                            } ?>)"><img src="<?php if (isset($arr[0])) {
                                                                                                                                                                    echo $arr[0];
                                                                                                                                                                } else {
                                                                                                                                                                    echo 'assets/images/products/product-filt3.jpg';
                                                                                                                                                                } ?>" alt="product-thumb">
                                                    </div>
                                                </div>
                                                <div class="thumb-wrapper three filterd-items hide">
                                                    <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url(<?php if (isset($arr[1])) {
                                                                                                                                                echo $arr[1];
                                                                                                                                            } else {
                                                                                                                                                echo 'assets/images/products/product-filt3.jpg';
                                                                                                                                            } ?>)"><img src="<?php if (isset($arr[1])) {
                                                                                                                                                                    echo $arr[1];
                                                                                                                                                                } else {
                                                                                                                                                                    echo 'assets/images/products/product-filt3.jpg';
                                                                                                                                                                } ?>" alt="product-thumb">
                                                    </div>
                                                </div>
                                                <div class="product-thumb-filter-group">

                                                    <div class="thumb-filter filter-btn active" data-show=".one"><img src="<?= htmlspecialchars($row2b['image_url']); ?>" alt="product-thumb-filter"></div>
                                                    <div class="thumb-filter filter-btn" data-show=".two"><img src="<?php if (isset($arr[0])) {
                                                                                                                        echo $arr[0];
                                                                                                                    } else {
                                                                                                                        echo 'assets/images/products/product-filt2.jpg';
                                                                                                                    } ?>" alt="product-thumb-filter"></div>
                                                    <div class="thumb-filter filter-btn" data-show=".three"><img src="<?php if (isset($arr[1])) {
                                                                                                                            echo $arr[1];
                                                                                                                        } else {
                                                                                                                            echo 'assets/images/products/product-filt3.jpg';
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
                                        <a href="#"><i class="far fa-eye"></i></a>
                                    </div>
                                    <div class="cta-single cta-wishlist">
                                        <a href="#"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="cta-single cta-addtocart">
                                        <a href="#"><i class="rt-basket-shopping"></i></a>
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
                                        <a href="#"><i class="far fa-eye"></i></a>
                                    </div>
                                    <div class="cta-single cta-wishlist">
                                        <a href="#"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="cta-single cta-addtocart">
                                        <a href="#"><i class="rt-basket-shopping"></i></a>
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
                                        <a href="#"><i class="far fa-eye"></i></a>
                                    </div>
                                    <div class="cta-single cta-wishlist">
                                        <a href="#"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="cta-single cta-addtocart">
                                        <a href="#"><i class="rt-basket-shopping"></i></a>
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
                                        <a href="#"><i class="far fa-eye"></i></a>
                                    </div>
                                    <div class="cta-single cta-wishlist">
                                        <a href="#"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="cta-single cta-addtocart">
                                        <a href="#"><i class="rt-basket-shopping"></i></a>
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
    <!--================= Related Product Section End Here =================-->


    <div class="rts-account-section"></div>


    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->




    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->
    <?php include 'common_scripts.php'; ?>
    <script>
        function fun1(e) {
            let id = e.getAttribute("value");
            $(".product-details-popup-wrapper").removeClass("popup");
            $('#div2' + id).addClass("popup");
            $(".anywere").addClass("bgshow");
        }

        function review(e) {

            $.ajax({
                method: "POST",
                data: {
                    review: true
                },
                success: function(data) {
                    // alert(data);
                    if (data.trim() == '0') {
                        Swal.fire("Error", "You can't add review to this product.", "error");
                    }
                    if (data.trim() == '1') {
                        $('#reveiw_div').show();
                    }
                    if (data.trim() == '-1') {
                        $('#myModal').modal('toggle');
                    }
                }
            })
        }

        function counter_fn() {
            $.ajax({
                method: "POST",
                data: {
                    counter: true
                },
                success: function(data) {}
            })
        }
        window.onload = counter_fn;

        $("#stars span").hover(
            function() { // mouseover
                $('#stars a i').removeClass("fas");
                $(this).find('i').addClass("fas");
                $(this).prevAll().find('i').addClass("fas");
                let id = $(this).data("id");
                $('#rating').val(id);
            },
            function() { // mouseleave
            }
        );

        $('#review_form').on("submit", function(e) {
            e.preventDefault();

            let form_data = $(this).serialize();
            // console.log(form_data);
            if ($('#message').val() == '') {

                Swal.fire("Error", "Review Message is Mandatory.", "error");
                return;
            }
            if ($('#name').val() == '') {

                Swal.fire("Error", "Name is Mandatory.", "error");
                return;
            }
            if ($('#email2').val() == '') {

                Swal.fire("Error", "Email is Mandatory.", "error");
                return;
            }
            $.ajax({
                method: "POST",
                data: form_data,
                success: function(data) {
                    // alert(data);
                    if (data.trim() == '1') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Your Review Added.',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        }).then(result => {
                            location.reload();
                        })
                        setTimeout(() => {
                            location.reload();
                        }, 4000);
                        $('#review_form')[0].reset();
                    } else {
                        Swal.fire("Error", "Not Added.", "error");
                    }
                }
            })

        });
    </script>

</body>


<!-- /product-details.html / [XR&CO'2014],  19:56:35 GMT -->

</html>