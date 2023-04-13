<?php
session_start();
include 'config/connection.php'; ?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /news.html / [XR&CO'2014],  19:56:43 GMT -->
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
    <section class="news-feed-area pt-120 pb-75 pt-md-60 pb-md-15 pt-xs-50 pb-xs-10">
        <div class="container">
            <div class="row mb-15">
                <div class="col-lg-8 pe-xl-0">
                    <div class="news-left">
                        <div class="row">
                            <?php
                            $records_per_page = 4;
                            $offset_records = 0;
                            if (isset($_GET['p'])) {
                                $offset_records = $records_per_page * (int) $_GET['p'];
                            }

                            $sql = "SELECT * from post WHERE site_id=$this_site_id";
                            if (isset($_POST['blog_keyword']) && $_POST['blog_keyword'] != '') {
                                $keyword = realEscape($_POST['blog_keyword']);
                                $sql .= " AND post_title like '%$keyword%' OR category like '%$keyword%'";
                            }
                            $sql .= " order by created_date desc limit $records_per_page offset $offset_records";
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
                                    <div class="col-xl-12">
                                        <div class="feed-item2">
                                            <a href="news-details?id=<?= $row['id'] ?>" class="feed-image"><img src="<?= htmlspecialchars($row['featured_image']); ?>" alt="feed-image"></a>
                                            <div class="feed-content">
                                                <span class="feed-catagory"><?= htmlspecialchars($row['category']); ?></span>
                                                <div class="author"><img src="<?= htmlspecialchars($row2['profile_pic']); ?>" alt=""> <?= htmlspecialchars($row2['name']); ?></div>
                                                <h2 class="feed-title"><a href="news-details?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['post_title']); ?></a></h2>
                                                <p><?= htmlspecialchars(substr($row['post_description'], 0, 400)); ?></p>
                                                <div class="feed-info">
                                                    <span class="feed-date">
                                                        <i class="rt-calendar-days"></i> <?= date("F d, Y", strtotime($row['created_date'])) ?></span>
                                                    <span class="comments"><i class="rt-comments"></i><?php
                                                                                                        $id = realEscape($row['id']);
                                                                                                        $sql = "select message from messages where item_id=$id and site_id=$this_site_id and marketplace_id='21'";
                                                                                                        $res = mysqli_query($conn, $sql);
                                                                                                        if (!$res) {
                                                                                                            errlog(mysqli_error($conn), $sql);
                                                                                                        }
                                                                                                        echo mysqli_num_rows($res);
                                                                                                        ?> Comment</span>
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
                        <?php

                        $sql = "SELECT * from post WHERE site_id=$this_site_id";
                        if (isset($_POST['blog_keyword']) && $_POST['blog_keyword'] != '') {
                            $keyword = realEscape($_POST['blog_keyword']);
                            $sql .= " AND post_title like '%$keyword%' OR category like '%$keyword%'";
                        }
                        $sql .= " order by created_date desc";
                        $res = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
                        $total_pages = (int) ((count($data) - 1) / $records_per_page);
                        $current_page = (int)($offset_records / $records_per_page);
                        ?>
                        <div class="row justify-content-center text-center mb-30">
                            <div class="col-lg-12">
                                <div class="page-navigation">
                                    <ul class="pagination">
                                        <li class="page-item <?php if ($current_page == 0) echo 'disabled' ?>"><a class="page-link" href="<?php if ($current_page > 0) echo 'news?p=' . $current_page - 1;
                                                                                                                                            else echo "#"; ?>"><i class="far fa-chevron-double-left"></i></a></li>
                                        <?php
                                        for ($i = 0; $i <= $total_pages; $i++) {
                                        ?>
                                            <li class="page-item <?php if ($current_page == $i) echo 'active' ?>"><a class="page-link" href="<?php echo 'news?p=' . $i; ?>"><?php echo $i + 1;
                                                                                                                                                                            if ($current_page == $i) echo '<span class="sr-only">(current)</span>' ?></a></li>
                                        <?php } ?>
                                        <li class="page-item <?php if ($current_page == $total_pages) echo 'disabled' ?>"><a class="page-link" href="<?php if ($current_page < $total_pages) echo 'news?p=' . $current_page + 1;
                                                                                                                                                        else echo "#"; ?>"><i class="far fa-chevron-double-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pl-30 pl-lg-15 pl-md-15 pl-xs-15">
                    <div class="news-right-widget">
                        <div class="widget widget-search mb-40">
                            <div class="widget-title-box pb-25 mb-30">
                                <h4 class="widget-sub-title2 fs-20">Search Here</h4>
                            </div>
                            <form class="subscribe-form mb-10" action="news.php" method="post">
                                <input type="text" placeholder="Searching..." name="blog_keyword" id="blog_keyword" value="">
                                <button type="submit" class="widget-btn"><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget-post mb-40">
                            <div class="widget-title-box pb-25 mb-30">
                                <h4 class="widget-sub-title2 fs-20">Recent Posts</h4>
                            </div>
                            <ul class="post-list">
                                <?php
                                $sql = "SELECT * from post WHERE site_id=$this_site_id order by created_date DESC limit 5";
                                $result = mysqli_query($conn, $sql);
                                if (!$result) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <li>
                                            <div class="blog-post mb-30">
                                                <a href="news-details.html"><img src="<?= htmlspecialchars($row['featured_image']); ?>" alt="Post Img" style="max-width: 80px; max-height: 80px;"></a>
                                                <div class="post-content">
                                                    <h6 class="mb-10"><a href="news-details.php?id=<?= $row['id']; ?>"><?= htmlspecialchars($row['post_title']); ?></a></h6>
                                                    <span class="fs-14"><i class="fal fa-calendar-alt"></i> <?= date("d M Y", strtotime($row['created_date'])) ?></span>
                                                </div>
                                            </div>
                                        </li>

                                    <?php
                                    }
                                } else {
                                    ?>
                                    <li>
                                        <div class="blog-post mb-30">
                                            <a href="news-details.html"><img src="assets/images/blog/img-14.jpg" alt="Post Img"></a>
                                            <div class="post-content">
                                                <h6 class="mb-10"><a href="news-details.html">Having education in
                                                        an area helps</a></h6>
                                                <span class="fs-14"><i class="fal fa-calendar-alt"></i> 24th March
                                                    2022</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="blog-post mb-30">
                                            <a href="news-details.html"><img src="assets/images/blog/img-15.jpg" alt="Post Img"></a>
                                            <div class="post-content">
                                                <h6 class="mb-10"><a href="news-details.html">People think, feel, &
                                                        behave in a way</a></h6>
                                                <span class="fs-14"><i class="fal fa-calendar-alt"></i> 24th March
                                                    2022</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="blog-post mb-30">
                                            <a href="news-details.html"><img src="assets/images/blog/img-16.jpg" alt="Post Img"></a>
                                            <div class="post-content">
                                                <h6 class="mb-10"><a href="news-details.html">That contributes to
                                                        their success</a></h6>
                                                <span class="fs-14"><i class="fal fa-calendar-alt"></i> 24th March
                                                    2022</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="blog-post">
                                            <a href="news-details.html"><img src="assets/images/blog/img-17.jpg" alt="Post Img"></a>
                                            <div class="post-content">
                                                <h6 class="mb-10"><a href="news-details.html">Improves not only
                                                        their personal</a></h6>
                                                <span class="fs-14"><i class="fal fa-calendar-alt"></i> 24th March
                                                    2022</span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="widget widget-categories-list mb-40">
                            <div class="widget-title-box pb-25 mb-30">
                                <h4 class="widget-sub-title2 fs-20">Categories</h4>
                            </div>
                            <ul class="list-none">
                                <?php
                                $sql = "SELECT distinct category from post where site_id=$this_site_id and status=1";
                                $rs = mysqli_query($conn, $sql);
                                if (!$rs) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                if (mysqli_num_rows($rs) > 0) {
                                    while ($row = mysqli_fetch_assoc($rs)) {
                                        $c = realEscape($row['category']);
                                        if ($c == '')
                                            continue;
                                        $sql = "select * from post where site_id=$this_site_id and category='$c'";
                                        $rs2 = mysqli_query($conn, $sql);
                                        if (!$rs2) {
                                            errlog(mysqli_error($conn), $sql);
                                        }
                                ?>
                                        <li><a href="news-grid?cat=<?= $c; ?>"><?= $c ?> <span class="f-right"><?= mysqli_num_rows($rs2) ?></span></a></li>

                                    <?php }
                                } else {
                                    ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="widget widget-categories-tag mb-40">
                            <div class="widget-title-box pb-25 mb-25">
                                <h4 class="widget-sub-title2 fs-20">Instagram Feeds</h4>
                            </div>
                            <div class="tag-list">
                                <a href="#">Popular</a>
                                <a href="#">Design</a>
                                <a href="#">UX</a>
                                <a href="#">Usability</a>
                                <a href="#">Develop</a>
                                <a href="#">Icon</a>
                                <a href="#">Business</a>
                                <a href="#">Consult</a>
                                <a href="#">Kit</a>
                                <a href="#">Keyboard</a>
                                <a href="#">Mouse</a>
                                <a href="#">Tech</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--news-feed-area end-->

    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->


    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->

    <?php include 'common_scripts.php'; ?>
</body>


<!-- /news.html / [XR&CO'2014],  19:56:46 GMT -->

</html>