<?php
session_start();

include 'config/connection.php';
$o_id=7;

?>
<!DOCTYPE html>
<html lang="en">

<?php // include 'site_head.php';
 include 'template_head.php';
?>

<body class="preload dashboard-purchase">

    <!--================================
        START MENU AREA
    =================================-->
    <!-- start menu-area -->
    <?php include 'header.php'; ?>



    <!--================================
        START BREADCRUMB AREA
    =================================-->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb">
                        <ul>
                            <li>
                                <a href="index">Home</a>
                            </li>
                        </ul>
                    </div>
                    <h1 class="page-title">Orders</h1>
                </div>
                <!-- end /.col-md-12 -->
            </div>
            <!-- end /.row -->
        </div>
        <!-- end /.container -->
    </section>
    <!--================================
        END BREADCRUMB AREA
    =================================-->

    <!--================================
            START DASHBOARD AREA
    =================================-->
    <section class="dashboard-area dashboard_purchase">
        <?php
        if (isset($_SESSION['RECENT_ORDER_ID'])) {
            $o_id = $_SESSION['RECENT_ORDER_ID'];
            // $o_id=7;
        }
        ?>
        <div class="dashboard_contents">
            <div class="container">
                <div class="shortcode_modules">
                    <div class="modules__title ">
                        <h3 class="text-center scolor">Thanks For your Order</h3>
                    </div>

                    <h6 class="text-center pcolor" style="padding:2rem;">Your Order Id #9876</h6>
                </div>
                <div class="product_archive">

                    <div class="title_area">
                        <div class="row">
                            <div class="col-md-5">
                                <h4>Item Details</h4>
                            </div>
                            <div class="col-md-3">
                                <h4 class="add_info">Additional Info</h4>
                            </div>
                            <div class="col-md-2">
                                <h4>Price</h4>
                            </div>
                            <div class="col-md-2">
                                <h4>Rate Product</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">

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
                                $sql = "SELECT mp.id as pid,mp.site_id as psid,mp.*,v.*,v.id as vid from marketplace_products mp inner join product_variants v on mp.id=v.product_id where mp.id=$pid and v.id=$var_id";
                                $rs = mysqli_query($conn, $sql);
                                if (!$rs) {
                                    errlog(mysqli_error($conn), $sql);
                                } else {
                                    $row2 = mysqli_fetch_assoc($rs);
                                }


                                $sql = "select image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and variant_id=$var_id ";
                                $result2 = mysqli_query($conn, $sql);
                                if (!$result2) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                $row3 = mysqli_fetch_assoc($result2);
                        ?>
                                <div class="col-md-12">
                                    <div class="single_product clearfix">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="product__description">
                                                    <img src="<?= htmlspecialchars($row3['image_url']); ?>" width="120px" alt="Purchase image">
                                                    <div class="short_desc">
                                                        <h4><?= htmlspecialchars($row2['product_title']); ?></h4>
                                                        <p>Nunc placerat mi id nisi inter dum mollis. Praesent phare...</p>
                                                    </div>
                                                </div>
                                                <!-- end /.product__description -->
                                            </div>
                                            <!-- end /.col-md-5 -->

                                            <div class="col-lg-3 col-md-3 col-6 xs-fullwidth">
                                                <div class="product__additional_info">
                                                    <ul>
                                                        <li>
                                                            <p>
                                                                <span>Date: </span> <?php echo date("F d, Y", strtotime($row['order_date'])); ?>
                                                            </p>
                                                        </li>
                                                        <li class="license">
                                                            <p>
                                                                <span>Status:</span> <?php if ($row['status'] == 0) {
                                                                                            echo "Default";
                                                                                        }
                                                                                        if ($row['status'] == 1) {
                                                                                            echo "Placed";
                                                                                        }
                                                                                        if ($row['status'] == 2) {
                                                                                            echo "Confirmed";
                                                                                        } ?>
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                <span>Qty:</span> <?= htmlspecialchars($row['quantity']); ?>
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <img src="images/catword.png" alt=""><?= htmlspecialchars($row2['cat_id']); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- end /.product__additional_info -->
                                            </div>
                                            <!-- end /.col-md-3 -->

                                            <div class="col-lg-4 col-md-4 col-6 xs-fullwidth">
                                                <div class="product__price_download">
                                                    <div class="item_price v_middle">
                                                        <span>$ <?php $total = 0;
                                                                $total = htmlspecialchars($row['price']) + htmlspecialchars($row['discount']);
                                                                echo number_format($total, 2);
                                                                ?></span>
                                                    </div>
                                                    <div class="item_action v_middle">
                                                        <a href="#" class="btn btn--md btn--round btn--white rating--btn not--rated" data-toggle="modal" data-target="#myModal">
                                                            <P class="rate_it">Rate Now</P>
                                                            <div class="rating product--rating">
                                                                <ul>
                                                                    <li>
                                                                        <span class="fa fa-star-o"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="fa fa-star-o"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="fa fa-star-o"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="fa fa-star-o"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="fa fa-star-o"></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </a>
                                                        <!-- end /.rating_btn -->
                                                    </div>
                                                    <!-- end /.item_action -->
                                                </div>
                                                <!-- end /.product__price_download -->
                                            </div>
                                            <!-- end /.col-md-4 -->
                                        </div>
                                    </div>
                                    <!-- end /.single_product -->
                                </div>
                            <?php
                            }
                        } else {
                            ?>


                            <div class="col-md-12">
                                <div class="single_product clearfix">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="product__description">
                                                <img src="images/pur1.jpg" alt="Purchase image">
                                                <div class="short_desc">
                                                    <h4>Finance and Consulting Business Theme</h4>
                                                    <p>Nunc placerat mi id nisi inter dum mollis. Praesent phare...</p>
                                                </div>
                                            </div>
                                            <!-- end /.product__description -->
                                        </div>
                                        <!-- end /.col-md-5 -->

                                        <div class="col-lg-3 col-md-3 col-6 xs-fullwidth">
                                            <div class="product__additional_info">
                                                <ul>
                                                    <li>
                                                        <p>
                                                            <span>Date: </span> 26 Jun 2016
                                                        </p>
                                                    </li>
                                                    <li class="license">
                                                        <p>
                                                            <span>Status:</span> Processing
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <span>Qty:</span> 1
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <img src="images/catword.png" alt="">Wordpress</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- end /.product__additional_info -->
                                        </div>
                                        <!-- end /.col-md-3 -->

                                        <div class="col-lg-4 col-md-4 col-6 xs-fullwidth">
                                            <div class="product__price_download">
                                                <div class="item_price v_middle">
                                                    <span>$59</span>
                                                </div>
                                                <div class="item_action v_middle">
                                                    <a href="#" class="btn btn--md btn--round btn--white rating--btn not--rated" data-toggle="modal" data-target="#myModal">
                                                        <P class="rate_it">Rate Now</P>
                                                        <div class="rating product--rating">
                                                            <ul>
                                                                <li>
                                                                    <span class="fa fa-star-o"></span>
                                                                </li>
                                                                <li>
                                                                    <span class="fa fa-star-o"></span>
                                                                </li>
                                                                <li>
                                                                    <span class="fa fa-star-o"></span>
                                                                </li>
                                                                <li>
                                                                    <span class="fa fa-star-o"></span>
                                                                </li>
                                                                <li>
                                                                    <span class="fa fa-star-o"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                    <!-- end /.rating_btn -->
                                                </div>
                                                <!-- end /.item_action -->
                                            </div>
                                            <!-- end /.product__price_download -->
                                        </div>
                                        <!-- end /.col-md-4 -->
                                    </div>
                                </div>
                                <!-- end /.single_product -->
                            </div>
                        <?php } ?>
                        <div class="col-md-12">
                            <button class="btn btn-lg btn--round btn-secondary" style="margin-left:30rem;">Continue Shopping</button>
                        </div>
                        <!-- end /.col-md-12 -->
                    </div>
                    <!-- end /.row -->
                </div>
                <!-- end /.product_archive2 -->
            </div>
            <!-- end /.container -->
        </div>
        <!-- end /.dashboard_menu_area -->
    </section>
    <!--================================
            END DASHBOARD AREA
    =================================-->

    <!--================================
        START FOOTER AREA
    =================================-->
    <?php include 'footer.php'; ?>
    <!--================================
        END FOOTER AREA
    =================================-->

    <!-- Modals -->
    <div class="modal fade rating_modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="rating_modal">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" id="rating_modal">Rating this Item</h3>
                    <h4>Product Enquiry Extension</h4>
                    <p>by
                        <a href="author.html">AazzTech</a>
                    </p>
                </div>
                <!-- end /.modal-header -->

                <div class="modal-body">
                    <form action="#">
                        <ul>
                            <li>
                                <p>Your Rating</p>
                                <div class="right_content btn btn--round btn--white btn--md">
                                    <select name="rating" class="give_rating">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </li>

                            <li>
                                <p>Rating Causes</p>
                                <div class="right_content">
                                    <div class="select-wrap">
                                        <select name="review_reason">
                                            <option value="design">Design Quality</option>
                                            <option value="customization">Customization</option>
                                            <option value="support">Support</option>
                                            <option value="performance">Performance</option>
                                            <option value="documentation">Well Documented</option>
                                        </select>

                                        <span class="lnr lnr-chevron-down"></span>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div class="rating_field">
                            <label for="rating_field">Comments</label>
                            <textarea name="rating_field" id="rating_field" class="text_field" placeholder="Please enter your rating reason to help the author"></textarea>
                            <p class="notice">Your review will be ​publicly visible​ and the author may reply to your comments. </p>
                        </div>
                        <button type="submit" class="btn btn--round btn--default">Submit Rating</button>
                        <button class="btn btn--round modal_close" data-dismiss="modal">Close</button>
                    </form>
                    <!-- end /.form -->
                </div>
                <!-- end /.modal-body -->
            </div>
        </div>
    </div>

    <!-- inject:js -->
    <?php include 'common_scripts.php'; ?>
    <!-- endinject -->
</body>

</html>