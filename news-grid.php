<?php
session_start();
include 'config/connection.php'; ?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /news-grid.html / [XR&CO'2014],  19:56:46 GMT -->
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

    <!--news-feed-area start-->
    <div class="rts-featured-product-section3">
        <div class="container">
            <div class="rts-featured-product-section-inner">
                <div class="row">
                    <?php
                    $sql = "SELECT * from post WHERE site_id=$this_site_id";
                    if (isset($_POST['blog_keyword']) && $_POST['blog_keyword'] != '') {
                        $keyword = realEscape($_POST['blog_keyword']);
                        $sql .= " AND post_title like '%$keyword%' OR category like '%$keyword%'";
                    } else if (isset($_GET['cat']) && $_GET['cat'] != '') {
                        $cat = realEscape($_GET['cat']);
                        $sql .= " AND category = '$cat'";
                    }
                    $sql .= " order by created_date desc";
                    //  echo $sql;
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        errlog(mysqli_error($conn), $sql);
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $v_id = realEscape($row['vendor_id']);
                            $sql2 = "SELECT name, profile_pic from vendor where id='$v_id'";
                            $result2 = mysqli_query($conn, $sql2);
                            if (!$result2) {
                                errlog(mysqli_error($conn), $sql2);
                            }
                            $row2 = mysqli_fetch_assoc($result2);
                    ?>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="full-wrapper wrapper-1 wrapper-4">
                                    <div class="image-part">
                                        <a href="news-details?id=<?= $row['id'] ?>" class="image"><img src="<?= htmlspecialchars($row['featured_image']); ?>" alt="Featured Image"></a>
                                    </div>
                                    <div class="blog-content">
                                        <span class="date-full">
                                            <span class="day"><?= date("d", strtotime($row['created_date'])) ?></span>
                                            <br>
                                            <span class="month"><?= date("F", strtotime($row['created_date'])) ?></span>
                                        </span>
                                        <ul class="blog-meta">
                                            <li><a href="#"><?= htmlspecialchars($row['category']); ?></a></li>
                                        </ul>
                                        <div class="title">
                                            <a href="news-details?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['post_title']); ?></a>
                                        </div>
                                        <div class="author-info d-flex align-items-center">
                                            <div class="avatar"><img src="<?= htmlspecialchars($row2['profile_pic']); ?>" alt="Author Image">
                                            </div>
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
                        <div class="alert alert-warning alert-dismissible fade show text-center text-center" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <b> No Result Found.</b>
                        </div>
                    <?php } ?>

                </div>

            </div>
        </div>
    </div>
    <!--news-feed-area end-->

    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->


    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->

    <!--================= Jquery latest version =================-->
    <?php include 'common_scripts.php'; ?>
</body>


<!-- /news-grid.html / [XR&CO'2014],  19:56:47 GMT -->

</html>