<?php
session_start();
include 'config/connection.php';

$vid = getVendorID();
//$vid = 1;
//$order_id = 1;
?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /thank-you.html / [XR&CO'2014],  19:57:12 GMT -->

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


    <!--thanks-area start-->
    <div class="thanks-area">
        <div class="container">
            <div class="section-inner">
                <div class="section-icon">
                    <i class="fal fa-check"></i>
                </div>
                <div class="section-title">
                    <h2 class="sub-title">Thanks For your Order</h2>
                    <h6 class="">Your Order Id #9876</h6>

                </div>
                <table class="table">
                    <tbody>
                        <?php
                        $sql = "SELECT * from orders where site_id=$this_site_id and vendor_id=$vid";
                        $result = mysqli_query($conn, $sql);
                        if (!$result) {
                            errlog(mysqli_error($conn), $sql);
                        }
                        if (mysqli_num_rows($result) > 0) {

                            while ($r = mysqli_fetch_assoc($result)) {
                                $o_id = realEscape($r['id']);
                                $sql = "select * from order_details where site_id=$this_site_id and order_id=$o_id";
                                $rs = mysqli_query($conn, $sql);
                                if (!$rs) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                if (mysqli_num_rows($rs) > 0) {

                                    while ($row = mysqli_fetch_assoc($rs)) {

                                        $pid = realEscape($row['item_id']);
                                        $var_id = realEscape($row['variant_id']);
                                        $m_id = realEscape($row['marketplace_id']);
                                        if ($m_id != '5') {
                                            continue;
                                        }
                                        $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid from marketplace_products mp inner join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.status='1' and mp.verified='1' and mp.id=$pid and v.id=$var_id";
                                        $res = mysqli_query($conn, $sql);
                                        if (!$res) {
                                            errlog(mysqli_error($conn), $sql);
                                        } else {
                                            $row2 = mysqli_fetch_assoc($res);
                                        }
                                        $sql = "select image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and variant_id=$var_id";
                                        $result2 = mysqli_query($conn, $sql);
                                        if (!$result2) {
                                            errlog(mysqli_error($conn), $sql);
                                        }
                                        $row3 = mysqli_fetch_assoc($result2);

                        ?>

                                        <tr>
                                            <td class="first-child"><a href="product-details.html"><img src="<?= htmlspecialchars($row3['image_url']); ?>" alt="" height="100px" width="100px"></a>
                                                <a href="product-details.html" class="pretitle"><?= htmlspecialchars($row2['product_title']); ?></a>
                                            </td>

                                            <td><span class="product-price"> X <?= htmlspecialchars($row['quantity']); ?> </span></td>
                                            <td><span class="product-price"> <?php $total = 0;
                                                                                $total = htmlspecialchars($row['price']) + htmlspecialchars($row['discount']);
                                                                                echo number_format($total, 2);
                                                                                ?></span></td>
                                            <td><span class="product-price"> <?php if ($row['status'] == 0) {
                                                                                    echo "Default";
                                                                                }
                                                                                if ($row['status'] == 1) {
                                                                                    echo "Placed";
                                                                                }
                                                                                if ($row['status'] == 2) {
                                                                                    echo "Confirmed";
                                                                                } ?></span></td>
                                            <td><span class="product-price"> <?php echo date("F d, Y", strtotime($row['order_date'])); ?></span></td>
                                            <td><span class="product-price"> Contact Seller</span></td>

                                        </tr>

                            <?php }
                                }
                            }
                        } else {
                            ?>

                            <tr>
                                <td class="first-child"><a href="product-details.html"><img src="assets/images/products/inner/cart/1.jpg" alt=""></a>
                                    <a href="product-details.html" class="pretitle">Travel Large Trifold Wallet</a>
                                </td>

                                <td><span class="product-price"> X 1 </span></td>
                                <td><span class="product-price"> $99.00</span></td>
                                <td><span class="product-price"> Processing</span></td>
                                <td><span class="product-price"> March 45, 2020</span></td>
                                <td><span class="product-price"> Contact Seller</span></td>

                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
                <div class="section-button">
                    <a class="btn-1" href="index"><i class="fal fa-long-arrow-left"></i> Go To Homepage</a>
                </div>
            </div>
        </div>
    </div>
    <!--thanks-area end-->

    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->


    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->
    <?php include 'common_scripts.php'; ?>
    <!--================= Jquery latest version =================-->

</body>


<!-- /thank-you.html / [XR&CO'2014],  19:57:12 GMT -->

</html>