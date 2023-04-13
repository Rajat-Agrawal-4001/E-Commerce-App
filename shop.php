<?php
session_start();
$_SESSION['items'] = array();

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

if (isset($_SESSION['items'])) {
    // print_r($_SESSION['items']);
    // die;
}
?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /slidebar-left.html / [XR&CO'2014],  19:56:35 GMT -->
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


    <!--================= Shop Section Start Here =================-->
    <div class="rts-shop-section section-gap">
        <div class="container">
            <div class="row">
                <div class="col-xl-3">
                    <div class="side-sticky">
                        <div class="shop-side-action">
                            <div class="action-item">
                                <?php
                                $sql = "select distinct cat_id from marketplace_products WHERE site_id=$this_site_id";
                                $result = mysqli_query($conn, $sql);
                                if (!$result) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $cat = realEscape($row['cat_id']);
                                        if ($cat == '')
                                            continue;
                                        $sql = "select distinct sub_cat_id from marketplace_products WHERE site_id=$this_site_id and cat_id='$cat'";
                                        $result2 = mysqli_query($conn, $sql);
                                        if (!$result2) {
                                            errlog(mysqli_error($conn), $sql);
                                        }

                                        $sql = "select mp.*,v.*,mp.id as pid from marketplace_products mp join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.cat_id='$cat'";
                                        $rs3 = mysqli_query($conn, $sql);
                                        if (!$rs3) {
                                            errlog(mysqli_error($conn), $sql);
                                        }
                                        if (mysqli_num_rows($rs3) <= 0) {
                                            continue;
                                        }

                                ?>
                                        <div class="category-item">
                                            <div class="category-item-inner">
                                                <div class="category-title-area">
                                                    <span class="point"></span>
                                                    <span class="category-title"><?= $cat ?> (<?= mysqli_num_rows($rs3); ?>)</span>
                                                </div>
                                                <div class="down-icon"><i class="far fa-angle-down"></i></div>
                                            </div>
                                            <div class="sub-categorys">
                                                <ul class="sub-categorys-inner">
                                                    <?php
                                                    while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                                                        <li><span class="point"></span><a href="javascript:void(0)" class="sub_cat" value="<?= $row2['sub_cat_id'] ?>"><?= $row2['sub_cat_id'] ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="action-top">
                                        <span class="action-title">category</span>
                                    </div>
                                    <div class="category-item">
                                        <div class="category-item-inner">
                                            <div class="category-title-area">
                                                <span class="point"></span>
                                                <span class="category-title">Kids (10)</span>
                                            </div>
                                            <div class="down-icon"><i class="far fa-angle-down"></i></div>
                                        </div>
                                        <div class="sub-categorys">
                                            <ul class="sub-categorys-inner">
                                                <li><span class="point"></span><a href="shop.html">Clothes</a></li>
                                                <li><span class="point"></span><a href="shop.html">Shoes</a></li>
                                                <li><span class="point"></span><a href="shop.html">Toys</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="category-item">
                                        <div class="category-item-inner">
                                            <div class="category-title-area">
                                                <span class="point"></span>
                                                <span class="category-title">Mens (23)</span>
                                            </div>
                                            <div class="down-icon"><i class="far fa-angle-down"></i></div>
                                        </div>
                                        <div class="sub-categorys">
                                            <ul class="sub-categorys-inner">
                                                <li><span class="point"></span><a href="shop.html">Clothes</a></li>
                                                <li><span class="point"></span><a href="shop.html">Shoes</a></li>
                                                <li><span class="point"></span><a href="shop.html">Glasses</a></li>
                                                <li><span class="point"></span><a href="shop.html">Watches</a></li>
                                                <li><span class="point"></span><a href="shop.html">Assesories</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="category-item">
                                        <div class="category-item-inner">
                                            <div class="category-title-area">
                                                <span class="point"></span>
                                                <span class="category-title">Women (14)</span>
                                            </div>
                                            <div class="down-icon"><i class="far fa-angle-down"></i></div>
                                        </div>
                                        <div class="sub-categorys">
                                            <ul class="sub-categorys-inner">
                                                <li><span class="point"></span><a href="shop.html">Clothes</a></li>
                                                <li><span class="point"></span><a href="shop.html">Shoes</a></li>
                                                <li><span class="point"></span><a href="shop.html">Glasses</a></li>
                                                <li><span class="point"></span><a href="shop.html">Makeups</a></li>
                                                <li><span class="point"></span><a href="shop.html">Assesories</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="action-item">
                                <div class="action-top">
                                    <span class="action-title">Filter</span>
                                </div>

                                <div class="range-slider">
                                    <span class="rangeValues"></span>
                                    <input value="0" min="0" max="50000" step="500" type="range" id="min_val" class="filter">
                                    <input value="50000" min="0" max="50000" step="500" type="range" id="max_val" class="filter">
                                </div>

                                <!--div class="nstSlider" data-range_min="50" data-range_max="20000" data-cur_min="20"
                                    data-cur_max="10000">
    
                                    <div class="bar"></div>
                                    <div class="leftGrip price-range-grip"></div>
                                    <div class="rightGrip price-range-grip"></div>
                                </div>
                                <div class="range-label-area">
                                    <div class="min-price d-flex">
                                        <span class="range-lbl">Min:</span>
                                        <span class="currency-symbol">$</span>
                                        <div class="leftLabel price-range-label"></div>
                                    </div>
                                    <div class="min-price d-flex">
                                        <span class="range-lbl">Max:</span>
                                        <span class="currency-symbol">$</span>
                                        <div class="rightLabel price-range-label"></div>
                                    </div>
                                </div-->

                            </div>
                            <div class="action-item">
                                <div class="action-top">
                                    <span class="action-title">Color</span>
                                </div>
                                <?php
                                $sql = "select distinct color from product_variants WHERE site_id=$this_site_id";
                                $result = mysqli_query($conn, $sql);
                                if (!$result) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $color = $row['color'];
                                        if ($color == '') {
                                            continue;
                                        }
                                ?>
                                        <div class="color-item">
                                            <div class="color blue" style="background-color:<?= $color ?>;"><i class="fas fa-check"></i></div>
                                            <span class="color-name" data-value="<?= $color ?>">blue</span>
                                            <div class="color-arrow"><i class="far fa-long-arrow-right"></i></div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="color-item">
                                        <div class="color black"><i class="fas fa-check"></i></div>
                                        <span class="color-name">Black</span>
                                        <div class="color-arrow"><i class="far fa-long-arrow-right"></i></div>
                                    </div>
                                    <div class="color-item">
                                        <div class="color blue"><i class="fas fa-check"></i></div>
                                        <span class="color-name">blue</span>
                                        <div class="color-arrow"><i class="far fa-long-arrow-right"></i></div>
                                    </div>
                                    <div class="color-item selected">
                                        <div class="color gray"><i class="fas fa-check"></i></div>
                                        <span class="color-name">Gray</span>
                                        <div class="color-arrow"><i class="far fa-long-arrow-right"></i></div>
                                    </div>
                                    <div class="color-item">
                                        <div class="color green"><i class="fas fa-check"></i></div>
                                        <span class="color-name">Green</span>
                                        <div class="color-arrow"><i class="far fa-long-arrow-right"></i></div>
                                    </div>
                                    <div class="color-item">
                                        <div class="color red"><i class="fas fa-check"></i></div>
                                        <span class="color-name">Red</span>
                                        <div class="color-arrow"><i class="far fa-long-arrow-right"></i></div>
                                    </div>
                                    <div class="color-item">
                                        <div class="color yellow"><i class="fas fa-check"></i></div>
                                        <span class="color-name">Yellow</span>
                                        <div class="color-arrow"><i class="far fa-long-arrow-right"></i></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="action-item">
                                <div class="action-top">
                                    <span class="action-title">Brand</span>
                                </div>
                                <div class="product-brands">
                                    <div class="brands-inner">
                                        <ul>
                                            <?php
                                            $sql = "select distinct brand_name from marketplace_products WHERE site_id=$this_site_id";
                                            $result = mysqli_query($conn, $sql);
                                            if (!$result) {
                                                errlog(mysqli_error($conn), $sql);
                                            }
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $brand = $row['brand_name'];
                                            ?>
                                                    <li><a class="product-brand" href="javascript:void(0)" value="<?= $brand ?>"><?= $brand ?></a></li>
                                                <?php }
                                            } else { ?>

                                                <li><a class="product-brand" href="shop.html">Alexander McQueen</a></li>
                                                <li><a class="product-brand" href="shop.html">Adidas</a></li>
                                                <li><a class="product-brand" href="shop.html">Balenciaga</a></li>
                                                <li><a class="product-brand" href="shop.html">Balmain</a></li>
                                                <li><a class="product-brand" href="shop.html">Burberry</a></li>
                                                <li><a class="product-brand" href="shop.html">Chloé</a></li>
                                                <li><a class="product-brand" href="shop.html">Dsquared2</a></li>
                                                <li><a class="product-brand" href="shop.html">Givenchy</a></li>
                                                <li><a class="product-brand" href="shop.html">Kenzo</a></li>
                                                <li><a class="product-brand" href="shop.html">Leo</a></li>
                                                <li><a class="product-brand" href="shop.html">Maison Margiela</a></li>
                                                <li><a class="product-brand" href="shop.html">Moschino</a></li>
                                                <li><a class="product-brand" href="shop.html">Nike</a></li>
                                                <li><a class="product-brand" href="shop.html">Versace</a></li>
                                                <li><a class="product-brand" href="shop.html">Alexander McQueen</a></li>
                                                <li><a class="product-brand" href="shop.html">Adidas</a></li>
                                                <li><a class="product-brand" href="shop.html">Balenciaga</a></li>
                                                <li><a class="product-brand" href="shop.html">Balmain</a></li>
                                                <li><a class="product-brand" href="shop.html">Burberry</a></li>
                                                <li><a class="product-brand" href="shop.html">Chloé</a></li>
                                                <li><a class="product-brand" href="shop.html">Dsquared2</a></li>
                                                <li><a class="product-brand" href="shop.html">Givenchy</a></li>
                                                <li><a class="product-brand" href="shop.html">Kenzo</a></li>
                                                <li><a class="product-brand" href="shop.html">Leo</a></li>
                                                <li><a class="product-brand" href="shop.html">Maison Margiela</a></li>
                                                <li><a class="product-brand" href="shop.html">Moschino</a></li>
                                                <li><a class="product-brand" href="shop.html">Nike</a></li>
                                                <li><a class="product-brand" href="shop.html">Versace</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a href="shop.html" class="banner-item">
                                    <div class="banner-inner">
                                        <span class="pretitle">Winter Fashion</span>
                                        <h1 class="title">Behind the
                                            deseart</h1>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="shop-product-topbar">
                        <span class="items-onlist">Showing 1-12 of 70 results</span>
                        <div class="filter-area">
                            <p class="select-area">
                                <select class="select filter" id="price" name="price">
                                    <option value="old">Sort by :</option>
                                    <option value="popular">Sort by popularity</option>
                                    <option value="latest">Sort by latest</option>
                                    <option value="low">Sort by price: low to high</option>
                                    <option value="high">Sort by price: high to low</option>
                                </select>
                            </p>
                        </div>
                    </div>
                    <script>
                        function addCart(e) {
                            let id = e.getAttribute("value");
                            let v_id = $(e).data("vid");
                            // alert(id+v_id);
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
                            // alert(id+variant);
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
                    <div class="products-area products-area3">
                        <div class="row justify-content-center" id="content">
                            <?php
                            $i = 0;
                            $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid,ad.id as admin from marketplace_products mp inner join product_variants v on mp.id=v.product_id 
inner join vendor vd on vd.id=mp.vendor_id 
LEFT JOIN admin ad ON ad.vendor_id = vd.id

WHERE (mp.site_id = $this_site_id AND mp.status = 1 AND mp.verified = 1)";

                            if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
                                $keyword = realEscape($_POST['keyword']);
                                $sql .= " AND (mp.product_title like '%$keyword%' OR mp.cat_id like '%$keyword%' OR mp.description like '%$keyword%')";
                                //  echo $sql;  die;
                            } else if (isset($_GET['cat']) && !empty($_GET['cat'])) {
                                $cat = realEscape($_GET['cat']);
                                $sql .= " AND mp.cat_id='$cat'";
                            } else {
                                $sql .= " OR (mp.site_id = ad.site_id AND (mp.status = 1 OR mp.status = 0) AND (mp.verified = 1 OR mp.verified = 0) ) LIMIT 10";
                            }
                            $result = mysqli_query($conn, $sql);
                            if (!$result) {
                                errlog(mysqli_error($conn), $sql);
                            }
                            if (mysqli_num_rows($result) > 0) {
                                $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                shuffle($data);
                                foreach ($data as $row) {

                                    $i++;
                                    $pid = realEscape($row['pid']);
                                    $vid = realEscape($row['vid']);
                                    $arr = array(
                                        'vid' => $vid
                                    );
                                    array_push($_SESSION['items'], $arr);
                                    $sql = "select image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and variant_id=$vid";
                                    $result2 = mysqli_query($conn, $sql);
                                    if (!$result2) {
                                        errlog(mysqli_error($conn), $sql);
                                    }
                                    $row2 = mysqli_fetch_assoc($result2);
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
                                    <div class="col-xl-4 col-md-4 col-sm-6">
                                        <div class="product-item product-item2 element-item1 sidebar-left">
                                            <a href="product-details.php?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-image">
                                                <img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image" style="max-height:18rem;">
                                            </a>
                                            <div class="bottom-content">
                                                <a href="product-details.php?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-name"><?= htmlspecialchars($row['product_title']); ?></a>
                                                <div class="action-wrap">
                                                    <span class="product-price">&#8377; <?= htmlspecialchars($row['price']); ?>.00</span>
                                                    <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                                                        Cart</a>

                                                </div>
                                            </div>
                                            <div class="product-features">
                                                <div class="new-tag product-tag">NEW</div><?php
                                                                                            if ($discount > 0) {
                                                                                            ?>

                                                    <div class="discount-tag product-tag"><?php
                                                                                                echo ($discount * 100) / $price;  ?>%</div>
                                                <?php
                                                                                            } ?>
                                            </div>
                                            <div class="product-actions">
                                                <a href="javascript:void(0)" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>" class="product-action"><i class="fal fa-heart"></i></a>
                                                <button class="product-action" onclick="fun1(this)" value="<?= $vid; ?>"><i class="fal fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $sql = "SELECT mp.*,v.*,mp.id as pid,v.id as vid from marketplace_products mp join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.id='$pid' and v.id='$vid'";
                                    $resultb = mysqli_query($conn, $sql);
                                    if (!$resultb) {
                                        errlog(mysqli_error($conn), $sql);
                                    }
                                    $rowb = mysqli_fetch_assoc($resultb);
                                    $sql = "SELECT image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and variant_id=$vid";
                                    $result2b = mysqli_query($conn, $sql);
                                    if (!$result2b) {
                                        errlog(mysqli_error($conn), $sql);
                                    }
                                    $row2b = mysqli_fetch_assoc($result2b);

                                    $sql = "SELECT image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and main='0'";
                                    $result3b = mysqli_query($conn, $sql);
                                    if (!$result3b) {
                                        errlog(mysqli_error($conn), $sql);
                                    }
                                    $arr = array();
                                    while ($row3b = mysqli_fetch_assoc($result3b)) {
                                        $arr[] = $row3b['image_url'];
                                    }
                                    ?>
                                    <div class="product-details-popup-wrapper" id="div<?= $vid; ?>">
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
                                                            <div class="rating-stars-group">
                                                                <div class="rating-star"><i class="fas fa-star"></i></div>
                                                                <div class="rating-star"><i class="fas fa-star"></i></div>
                                                                <div class="rating-star"><i class="fas fa-star-half-alt"></i></div>
                                                                <span>10 Reviews</span>
                                                            </div>
                                                        </div>
                                                        <h2 class="product-title"><?= htmlspecialchars($rowb['product_title']); ?> <span class="stock">In Stock</span></h2>
                                                        <span class="product-price"><span class="old-price">Rs 9.35</span> Rs <?= htmlspecialchars($rowb['price']); ?></span>
                                                        <p>
                                                            <?= htmlspecialchars($rowb['product_title']); ?>
                                                        </p>
                                                        <div class="product-bottom-action">
                                                            <div class="cart-edit">
                                                                <div class="quantity-edit action-item">
                                                                    <button class="button minus"><i class="fal fa-minus minus"></i></button>
                                                                    <input type="text" class="input" value="01" />
                                                                    <button class="button plus">+<i class="fal fa-plus plus"></i></button>
                                                                </div>
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
                                <?php }
                            } else { ?>
                                <div class="alert alert-warning alert-dismissible fade show text-center text-center" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <b> No Result Found.</b>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!--<div class="product-pagination-area mt--20">
                        <button class="prev"><i class="far fa-long-arrow-left"></i></button>
                        <button class="number active">01</button>
                        <button class="number">02</button>
                        <button class="skip-number">---</button>
                        <button class="number">07</button>
                        <button class="number">08</button>
                        <button class="next"><i class="far fa-long-arrow-right"></i></button>
                    </div>-->
                </div>

            </div>
        </div>
    </div>
    <!--================= Shop Section Section End Here =================-->


    <!--================= Product-details Section Start Here =================-->

    <!--================= Product-details Section End Here =================-->


    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->




    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->
    <?php include 'common_scripts.php'; ?>
    <script>
        function getVals() {
            // Get slider values
            let parent = this.parentNode;
            let slides = parent.getElementsByTagName("input");
            let slide1 = parseFloat(slides[0].value);
            let slide2 = parseFloat(slides[1].value);
            // Neither slider will clip the other, so make sure we determine which is larger
            if (slide1 > slide2) {
                let tmp = slide2;
                slide2 = slide1;
                slide1 = tmp;
            }

            let displayElement = parent.getElementsByClassName("rangeValues")[0];
            displayElement.innerHTML = "&#8377;" + slide1 + " - &#8377;" + slide2;

        }

        window.onload = function() {
            // Initialize Sliders
            let sliderSections = document.getElementsByClassName("range-slider");
            for (let x = 0; x < sliderSections.length; x++) {
                let sliders = sliderSections[x].getElementsByTagName("input");
                for (let y = 0; y < sliders.length; y++) {
                    if (sliders[y].type === "range") {
                        sliders[y].oninput = getVals;
                        // Manually trigger event first time to display values
                        sliders[y].oninput();
                    }
                }
            }
        };
    </script>
    <script>
        function fun1(e) {
            let id = e.getAttribute("value");
            $(".product-details-popup-wrapper").removeClass("popup");
            $('#div' + id).addClass("popup");
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
    <script type="text/javascript">
        $(document).ready(function() {


            $(".filter").on("change", function(e) {
                var min_price = $('#min_val').val();
                var max_price = $('#max_val').val();
                //  alert(min_price+max_price);

                var price = $('#price').val();

                $.ajax({
                    type: 'POST',
                    url: 'shop-helper.php',
                    data: {
                        price: price,
                        min_price: min_price,
                        max_price: max_price
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        $('#content').html(data);
                    }
                });
            });


            $(".sub_cat").on("click", function(e) {

                var sub_cat = $(this).attr("value");

                $.ajax({
                    type: 'POST',
                    url: 'shop-helper.php',
                    data: {
                        sub_cat: sub_cat
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        $('#content').html(data);
                    }
                });
            });

            $(".product-brand").on("click", function(e) {

                var brand = $(this).attr("value");
                //alert(brand);
                $.ajax({
                    type: 'POST',
                    url: 'shop-helper.php',
                    data: {
                        brand: brand
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        $('#content').html(data);
                    }
                });
            });

            $(".color-name").on("click", function(e) {

                var color = $(this).data("value");
                //alert(color);
                $.ajax({
                    type: 'POST',
                    url: 'shop-helper.php',
                    data: {
                        color: color
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        $('#content').html(data);
                    }
                });
            });

            var windowHeight = $(window).height();

            $(window).on("scroll", function() {
                var windowTop = $(window).scrollTop() + 1;

                if (windowTop >= windowHeight) {
                    windowHeight = $(window).height() + windowTop - 100;

                    var price = $('#price').val();
                    var min_price = $('#min_val').val();
                    var max_price = $('#max_val').val();

                    $.ajax({
                        type: 'POST',
                        url: 'shop-helper.php',
                        data: {
                            loadMoreProds: true,
                            price: price,
                            min_price: min_price,
                            max_price: max_price,
                            keyword: '<?php if (isset($_POST['keyword']) && $_POST['keyword'] != '') echo $_POST['keyword'];
                                        else echo ""; ?>',
                            category: '<?php if (isset($_GET['cat']) && $_GET['cat'] != '') echo $_GET['cat'];
                                        else echo ""; ?>'
                        },
                        beforeSend: function() {
                            // $('#loader').show();
                        },
                        success: function(html) {
                            // $('#loader').hide();
                            $('#content').append(html);
                        }
                    });
                }
            });


        });
    </script>

</body>


<!-- /slidebar-left.html / [XR&CO'2014],  19:56:35 GMT -->

</html>