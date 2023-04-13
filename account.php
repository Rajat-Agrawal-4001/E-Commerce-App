<?php
session_start();
include 'config/connection.php';

$vid = getVendorID();
//$vid=1;


if (isset($_GET['orders'])) {
    $sql = "select * from orders where site_id=$this_site_id and vendor_id=$vid";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        errlog(mysqli_error($conn), $sql);
    }
    if (mysqli_num_rows($res) > 0) {

        while ($row = mysqli_fetch_assoc($res)) {
?>

            <tr>
                <td>#<?= htmlspecialchars($row['id']); ?></td>
                <td><?php echo date("F d, Y", strtotime($row['order_date'])); ?></td>
                <td><?= htmlspecialchars($row['order_status']); ?></td>
                <td>$<?= htmlspecialchars($row['amount']); ?></td>
                <td><a href="#" class="btn-small d-block">View</a></td>
            </tr>
<?php
        }
    }
    die;
}

?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /account.html / [XR&CO'2014],  19:56:37 GMT -->

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
    <?php
    if (isset($_SESSION['RECENT_ORDER_ID'])) {
        $o_id = $_SESSION['RECENT_ORDER_ID'];
        // $o_id=7;
    ?>
        <div class="thanks-area" style="padding:15px;">
            <div class="container">
                <div class="section-inner">
                    <div class="section-icon">
                        <i class="fal fa-check"></i>
                    </div>
                    <div class="section-title">
                        <h2 class="sub-title">Thanks For your Order</h2>
                        <h6 class="">Your Order Id #<?php if (isset($o_id)) {
                                                        echo $o_id;
                                                    } ?></h6>

                    </div>
                    <table class="table">
                        <tbody>
                            <?php
                            $sql = "select * from order_details where site_id=$this_site_id and order_id=$o_id";
                            $res = mysqli_query($conn, $sql);
                            if (!$res) {
                                errlog(mysqli_error($conn), $sql);
                            }
                            if (mysqli_num_rows($res) > 0) {

                                while ($row = mysqli_fetch_assoc($res)) {

                                    $pid = realEscape($row['item_id']);
                                    $var_id = realEscape($row['variant_id']);
                                    $m_id = realEscape($row['marketplace_id']);
                                    if ($m_id != '5') {
                                        continue;
                                    }
                                    $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid from marketplace_products mp inner join product_variants v on mp.id=v.product_id where mp.site_id=$this_site_id and mp.status='1' and mp.verified='1' and mp.id=$pid and v.id=$var_id";
                                    $rs = mysqli_query($conn, $sql);
                                    if (!$rs) {
                                        errlog(mysqli_error($conn), $sql);
                                    } else {
                                        $row2 = mysqli_fetch_assoc($rs);
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
                                <?php
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
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="section-button">
                        <a class="btn-1" href="index.html"><i class="fal fa-long-arrow-left"></i> Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="rts-account-section section-gap">

        <div class="container">
            <!--thanks-area start-->

            <!--thanks-area end-->
            <div class="account-inner">
                <div class="account-side-navigation">
                    <button class="filter-btn active" data-show=".dashboard"><i class="fal fa-chart-bar"></i>
                        Dashboard</button>
                    <button class="filter-btn" data-show=".orders" onclick="orders()"><i class="fal fa-shopping-cart"></i> Orders</button>
                    <button class="filter-btn" data-show=".address"><i class="fal fa-map-marker-alt"></i>
                        Address</button>
                    <button class="filter-btn" data-show=".accountdtls"><i class="fal fa-user"></i> Account
                        Details</button>
                    <a href="wishlist.html" class="filter-btn" data-show=".dashboard"><i class="fal fa-shopping-basket"></i>
                        Wishlist</a>
                    <a href="login.html" class="filter-btn" data-show=".dashboard"><i class="fal fa-long-arrow-left"></i>
                        Logout</a>
                </div>
                <div class="account-main-area">
                    <div class="account-main dashboard filterd-items">
                        <?php
                        if ($vid != -1) {

                            $sql = "select * from vendor where id=$vid";
                            $res = mysqli_query($conn, $sql);
                            if (!$res) {
                                errlog(mysqli_error($conn), $sql);
                            } else {
                                $v = mysqli_fetch_assoc($res);
                            }
                        }

                        ?>
                        <div class="account-profile-area">
                            <div class="profile-dp"><img src="<?php if (isset($v['profile_pic'])) {
                                                                    echo $v['profile_pic'];
                                                                } else {
                                                                    echo "images/usr_avatar.png";
                                                                } ?>" alt="profile-dp"></div>
                            <div class="d-block">
                                <span class="profile-name"><span>Hi,</span> <?php if (isset($v['name'])) {
                                                                                echo $v['name'];
                                                                            } else {
                                                                                echo "Guest";
                                                                            }
                                                                            ?></span>
                                <span class="profile-date d-block"><?php if (isset($v['created_date'])) {
                                                                        echo date("F d, Y", strtotime($v['name']));
                                                                    } else {
                                                                        echo "Febuary 23, 2015";
                                                                    }
                                                                    ?></span>
                            </div>
                        </div>
                        <p>From your account dashboard you can view your recent orders, manage your shipping and billing
                            addresses, and edit your password and account details.</p>

                        <div class="activity-box">
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-box-check"></i></div>
                                <span class="title">Active Orders</span>
                                <span class="value">33</span>
                            </div>
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-download"></i></div>
                                <span class="title">Downloads</span>
                                <span class="value">10</span>
                            </div>
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                                <span class="title">Address</span>
                                <span class="value"><?php if (isset($v['city'])) {
                                                        echo $v['city'] . " ," . $v['state'] . " ," . $v['country'];
                                                    } else {
                                                        echo "12/A, New Castle, NY";
                                                    }
                                                    ?></span>
                            </div>
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-user"></i></div>
                                <span class="title">Account Details</span>
                                <span class="value">33</span>
                            </div>
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-heart"></i></div>
                                <span class="title">Wishlist</span>
                                <span class="value">33</span>
                            </div>
                            <a href="login.html" class="activity-item">
                                <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
                                <span class="title">Logout</span>
                            </a>
                        </div>
                    </div>
                    <div class="account-main orders filterd-items hide">
                        <h2 class="mb--30">My Orders</h2>
                        <table class="table">
                            <thead>
                                <tr class="top-tr">
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="content">

                                <tr>
                                    <td>#1357</td>
                                    <td>March 45, 2020</td>
                                    <td>Processing</td>
                                    <td>$125.00 for 2 item</td>
                                    <td><a href="#" class="btn-small d-block">View</a></td>
                                </tr>
                                <tr>
                                    <td>#2468</td>
                                    <td>June 29, 2020</td>
                                    <td>Completed</td>
                                    <td>$364.00 for 5 item</td>
                                    <td><a href="#" class="btn-small d-block">View</a></td>
                                </tr>
                                <tr>
                                    <td>#2366</td>
                                    <td>August 02, 2020</td>
                                    <td>Completed</td>
                                    <td>$280.00 for 3 item</td>
                                    <td><a href="#" class="btn-small d-block">View</a></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="account-main address filterd-items hide">
                        <div class="row">
                            <div class="col-xl-5 col-md-5">
                                <div class="billing-address">
                                    <h2 class="mb--30">Billing Address</h2>
                                    <address>
                                        3522 Interstate<br>
                                        75 Business Spur,<br>
                                        Sault Ste. <br>Marie, MI 49783
                                    </address>
                                    <p class="mb--10">New York</p>
                                    <a href="#" class="btn-small">Edit</a>
                                </div>
                            </div>
                            <div class="col-xl-5 col-md-5">
                                <div class="shipping-address">
                                    <h4 class="mb--30">Shipping Address</h4>
                                    <address>
                                        4299 Express Lane<br>
                                        Sarasota, <br>FL 34249 USA <br>Phone: 1.941.227.4444
                                    </address>
                                    <p class="mb--10">Sarasota</p>
                                    <a href="#" class="btn-small">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="account-main accountdtls filterd-items hide">
                        <div class="login-form">
                            <div class="section-title">
                                <h2>Login</h2>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <div class="form">
                                            <input type="text" class="form-control" id="username" placeholder="Username or email address*" required="">
                                        </div>
                                        <div class="form">

                                            <div class="password-input">
                                                <input type="password" class="form-control" id="password" placeholder="Password*" required="">
                                                <span class="show-password-input"></span>
                                            </div>
                                        </div>
                                        <div class="form">
                                            <input type="checkbox" class="form-check-input" id="remember">
                                            <label for="remember" class="form-label">Remember Me</label>
                                        </div>
                                        <div class="form">
                                            <button type="submit" class="btn">Login <i class="fal fa-long-arrow-right"></i></button>
                                        </div>
                                        <a class="forgot-password" href="#">Lost your password?</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="offer-ad mt--40"><img src="assets/images/banner/45Offer.jpg" alt="ad"></div>
                </div>
            </div>
        </div>
    </div>

    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->




    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->

    <!--================= Jquery latest version =================-->

    <?php include 'common_scripts.php'; ?>

    <script>
        function orders() {
            $.ajax({
                method: "GET",
                data: {
                    orders: true
                },
                success: function(data) {
                    $('#content').html(data);
                }
            })

        }
    </script>
</body>


<!-- /account.html / [XR&CO'2014],  19:56:38 GMT -->

</html>