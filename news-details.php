<?php
session_start();
include 'config/connection.php';
if (isset($_GET['id'])) {
    $b_id = $_GET['id'];
}
if (isset($_POST['counter'])) {
    $sql = "update post set views= views + 1 where id='$b_id'";
    $rs = mysqli_query($conn, $sql);
    if (!$rs) {
        errlog(mysqli_error($conn), $sql);
    }
    die;
}

?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /news-details.html / [XR&CO'2014],  19:56:47 GMT -->
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
    <?php
    $sql = "SELECT * from post WHERE site_id=$this_site_id and id='$b_id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        errlog(mysqli_error($conn), $sql);
    }
    $detail = mysqli_fetch_assoc($result);
    $v_id = realEscape($detail['vendor_id']);

    $sql2 = "SELECT * from vendor where id='$v_id'";
    $result2 = mysqli_query($conn, $sql2);
    if (!$result2) {
        errlog(mysqli_error($conn), $sql2);
    }
    $row2 = mysqli_fetch_assoc($result2);


    ?>
    <!--news-feed-area start-->
    <section class="news-feed-area pt-120 pb-75 pt-md-60 pb-md-15 pt-xs-50 pb-xs-10">
        <div class="container">
            <div class="row mb-15">
                <div class="col-lg-8 pe-xl-0">
                    <div class="news-left2">
                        <div class="news-top">
                            <div class="mb-4">
                                <a href="#" class="blog__title">
                                    <h4><?= htmlspecialchars($detail['post_title']); ?></h4>
                                </a>
                            </div>
                            <div class="icon-text">
                                <span class="viewers fs-10"><a href="#"><i class="fal fa-eye"></i> <?= htmlspecialchars($detail['views']); ?> Views</a></span>
                                <span class="comment fs-10"><a href="#"><i class="fal fa-comments"></i> <?php
                                                                                                        $sql = "select message from messages where item_id='$b_id' and marketplace_id='21'";
                                                                                                        $res = mysqli_query($conn, $sql);
                                                                                                        if (!$res) {
                                                                                                            errlog(mysqli_error($conn), $sql);
                                                                                                        }
                                                                                                        echo mysqli_num_rows($res);
                                                                                                        ?>
                                        Comments</a></span>
                                <span class="date fs-10"><a href="#"><i class="fal fa-calendar-alt"></i> <?= date("d F Y", strtotime($detail['created_date'])) ?></a></span>
                            </div>

                            <p class="description">
                                <?= decoder($detail['post_description']); ?>
                            </p>

                            <div class="image-section">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="image-1">
                                            <img src="<?= htmlspecialchars($detail['featured_image']); ?>" alt="img">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="feature-section">
                            <h2 class="section-title">Ecommerce operates in all four of the following major market
                                segments. These are:</h2>
                            <ul class="title-inner">
                                <li class="sect-title">
                                    <h3>Business to business (B2B), which is the direct sale of goods and
                                        services between businesses</h3>
                                </li>
                                <li class="sect-title">
                                    <h3>Providing goods and services isn't as easy as it may seem. It
                                        a lot of research about the products</h3>
                                </li>
                                <li class="sect-title">
                                    <h3>Consumer to consumer, which allows individuals to sell to one
                                        usually through a third-party site like eBay</h3>
                                </li>
                                <li class="sect-title">
                                    <h3>Services you wish to sell, the market, audience, competition, as
                                        as expected business costs.</h3>
                                </li>
                            </ul>
                        </div>
                        <div class="quote-section text-center">
                            <div class="icon">
                                <img src="assets/images/blog-details/quote.png" alt="">
                            </div>
                            <div class="text">
                                <h3>“ Once that's determined, you need to come up with a name and set up a legal
                                    structure, such as a corporation. Next, set up an ecommerce site with a payment
                                    gateway.
                                    For instance, a small business owner who runs a dress shop ”</h3>
                            </div>
                            <div class="author2">
                                <span class="name">Rosalina D. William </span>
                                <span class="intro"> / Head Of Idea, Rosalina Co.</span>
                            </div>
                        </div> -->

                        <div class="button-area">
                            <div class="row justify-content-between">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="tag-area">
                                        <h3>Related Tags</h3>
                                        <div class="button-tag">
                                            <ul>
                                                <?php $tags = $detail['tags'];
                                                $arr1 = explode(',', $tags);
                                                foreach ($arr1 as $tag) {
                                                    if ($tag == '')
                                                        continue;
                                                ?>
                                                    <li><a href="#"><?= $tag ?></a></li>
                                                <?php } ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12 text-sm-end text-start">
                                    <div class="social-area">
                                        <div class="social-title">
                                            <h3>Social Share</h3>
                                        </div>
                                        <div class="social-icon">
                                            <ul>
                                                <li><a href="http://www.facebook.com/sharer?u=<?php echo $this_site_url . '/news-details?id=' . urlencode(base64_encode($b_id)); ?>"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="http://twitter.com/share?text=share&url=<?php echo $this_site_url . '/news-details?id=' . urlencode(base64_encode($b_id)); ?>"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                                <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $this_site_url . '/news-details?id=' . urlencode(base64_encode($b_id)); ?>"><i class="fab fa-linkedin-in"></i></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-area">
                                <div class="row align-items-center justify-content-between">

                                    <?php
                                    $sql = "SELECT * from post WHERE site_id=$this_site_id and id < '$b_id' LIMIT 1";
                                    $res = mysqli_query($conn, $sql);
                                    if (!$res) {
                                        errlog(mysqli_error($conn), $sql);
                                    }
                                    $prev = mysqli_fetch_assoc($res);

                                    ?>
                                    <div class="col-lg-4 col-sm-4 col-12 text-start">
                                        <div class="previous-post">
                                            <div class="post-img">
                                                <a href="#"><img src="<?= $prev['featured_image'] ?? 'assets/images/blog-details/prev-post.jpg'; ?>" alt="prev-post" style="max-height: 120px; max-width: 120px;"></a>
                                            </div>
                                            <div class="post-text">
                                                <?php if (isset($prev['id']) && $prev['id'] != '') { ?>
                                                    <a href="news-details?id=<?= $prev['id']; ?>">
                                                        <h3 class="sub-title">Prev Post</h3>
                                                    </a>
                                                <?php } else { ?>

                                                    <h3 class="sub-title">Prev Post</h3>

                                                <?php } ?>
                                                <h2 class="sect-title"><?= (isset($prev['post_title'])) ? substr($prev['post_title'], 0, 35) : ''; ?></h2>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-4 col-12 text-sm-center text-start">
                                        <div class="icon-area">
                                            <a href="#"><img src="assets/images/blog-details/shape.png" alt="img" height="60px" width="60px"></a>
                                        </div>
                                    </div>
                                    <?php
                                    $sql = "SELECT * from post WHERE site_id=$this_site_id and id > '$b_id' LIMIT 1";
                                    $res = mysqli_query($conn, $sql);
                                    if (!$res) {
                                        errlog(mysqli_error($conn), $sql);
                                    }
                                    $next = mysqli_fetch_assoc($res);
                                    ?>
                                    <div class="col-lg-4 col-sm-4 col-12 text-sm-end text-start justify-content-sm-end justify-content-start">
                                        <div class="next-post">
                                            <div class="post-text">
                                                <?php if (isset($next['id']) && $next['id'] != '') { ?>
                                                    <a href="news-details?id=<?= $next['id']; ?>">
                                                        <h3 class="sub-title">Next Post</h3>
                                                    </a>
                                                <?php } else { ?>

                                                    <h3 class="sub-title">Next Post</h3>

                                                <?php } ?>
                                                <h2 class="sect-title"><?= (isset($next['post_title'])) ? substr($next['post_title'], 0, 35) : ''; ?></h2>
                                            </div>
                                            <div class="post-img">
                                                <a href="#"><img src="<?= $next['featured_image'] ?? 'assets/images/blog-details/prev-post.jpg'; ?>" alt="next-post"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $qry1 = "SELECT * FROM messages where site_id='$this_site_id' and msg_type='comment' and item_id='$b_id' and marketplace_id='21' order by created_date desc";
                            $rs1 = mysqli_query($conn, $qry1);
                            if (!$rs1) {
                                errlog(mysqli_error($conn), $qry1);
                            }
                            ?>
                            <div class="comment-header">
                                <div class="comment">
                                    <h3><?= mysqli_num_rows($rs1) ?> Comments</h3>
                                </div>
                                <div class="icon">
                                    <a href="#"><i class="fal fa-comments"></i></a>
                                </div>
                            </div>
                            <?php
                            if (mysqli_num_rows($rs1) > 0) {
                                while ($row1 = mysqli_fetch_assoc($rs1)) {
                                    $sender = realEscape($row1['sender']);
                                    if ($sender > 0) {
                                        $sql = "SELECT name,profile_pic from vendor where id='$sender'";
                                        $res = mysqli_query($conn, $sql);
                                        $s = mysqli_fetch_assoc($res);
                                    }
                            ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="comment-section">
                                                <div class="comment-text">
                                                    <div class="commentator">
                                                        <a href="#"><img src="<?= $s['profile_pic'] ?? $avatar;  ?>" alt="commentator-img" height="60px" width="60px"></a>
                                                    </div>
                                                    <div class="text">
                                                        <div class="section-title">
                                                            <div class="title">
                                                                <h2 class="sub-title"><?= $s['name'] ?? 'Guest';  ?></h2>
                                                                <span class="sect-title"><a href="#"><i class="fal fa-calendar-alt"></i>
                                                                        <?= date("d F Y", strtotime($row1['created_date'])) ?></a></span>
                                                            </div>
                                                            <div class="button">
                                                                <a href="#"><i class="fal fa-reply"></i> Reply</a>
                                                            </div>
                                                        </div>
                                                        <p class="description"><?php echo htmlspecialchars($row1['message']) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="comment-section">
                                            <div class="comment-text">
                                                <div class="commentator">
                                                    <a href="#"><img src="assets/images/blog-details/commentator-1.jpg" alt="commentator"></a>
                                                </div>
                                                <div class="text">
                                                    <div class="section-title">
                                                        <div class="title">
                                                            <h2 class="sub-title">Rosalina Kelian</h2>
                                                            <span class="sect-title"><a href="#"><i class="fal fa-calendar-alt"></i>
                                                                    24th
                                                                    March
                                                                    2022</a></span>
                                                        </div>
                                                        <div class="button">
                                                            <a href="#"><i class="fal fa-reply"></i> Reply</a>
                                                        </div>
                                                    </div>
                                                    <p class="description">But that's not all. Not to be outdone, individual
                                                        sellers
                                                        have increasingly engaged in e-commerce transactions via their own
                                                        personal
                                                        websites. And digital marketplaces such as eBay or Etsy serve as
                                                        exchanges
                                                        where multitudes of buyers and sellers come together to conduct
                                                        business.
                                                        commerce has changed the way people shop and consume products and
                                                        services.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-10">
                                        <div class="comment-section">
                                            <div class="comment-text">
                                                <div class="commentator">
                                                    <a href="#"><img src="assets/images/blog-details/commentator-2.jpg" alt="commentator"></a>
                                                </div>
                                                <div class="text">
                                                    <div class="section-title">
                                                        <div class="title">
                                                            <h2 class="sub-title">Alonso William</h2>
                                                            <span class="sect-title"><a href="#"><i class="fal fa-calendar-alt"></i>
                                                                    24th
                                                                    March
                                                                    2022</a></span>
                                                        </div>
                                                        <div class="button">
                                                            <a href="#"><i class="fal fa-reply"></i> Reply</a>
                                                        </div>
                                                    </div>
                                                    <p class="description">Ecommerce has changed the way people shop and
                                                        consume products and services. More and more people are turning to
                                                        their computers and smart devices to order goods, which can easily
                                                        be delivered to their homes. As such, it has disrupted the retail
                                                        landscape. Amazon and Alibaba have gained considerable popularity.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-10">
                                        <div class="comment-section">
                                            <div class="comment-text">
                                                <div class="commentator">
                                                    <a href="#"><img src="assets/images/blog-details/commentator-3.jpg" alt="commentator"></a>
                                                </div>
                                                <div class="text">
                                                    <div class="section-title">
                                                        <div class="title">
                                                            <h2 class="sub-title">Miranda Halim</h2>
                                                            <span class="sect-title"><a href="#"><i class="fal fa-calendar-alt"></i>
                                                                    24th
                                                                    March
                                                                    2022</a></span>
                                                        </div>
                                                        <div class="button">
                                                            <a href="#"><i class="fal fa-reply"></i> Reply</a>
                                                        </div>
                                                    </div>
                                                    <p class="description">commerce has changed the way people shop and
                                                        consume products and services. More and more people are turning to
                                                        their computers and smart devices to order goods, which can easily
                                                        be delivered to their homes. As such, it has disrupted the retail
                                                        landscape. Amazon and Alibaba have gained considerable popularity
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="rating-area">
                                <div class="rating-text">
                                    <h2 class="text">Give Your Opinion</h2>
                                </div>
                                <!-- <div class="rating-icon">
                                    <span class="one"><a href="#"> <i class="fas fa-star"></i></a></span>
                                    <span class="two"><a href="#"> <i class="fas fa-star"></i></a></span>
                                    <span class="three"><a href="#"> <i class="fas fa-star"></i></a></span>
                                    <span class="four"><a href="#"> <i class="fal fa-star"></i></a></span>
                                    <span class="five"><a href="#"> <i class="fal fa-star"></i></a></span>
                                </div> -->
                            </div>
                            <div class="comment-form mb-10">
                                <div class="contact-form">
                                    <div class="row">
                                        <form class="cmnt_reply_form" action="#" method="post" id="comments_form">

                                            <div class="col-lg-6 col-sm-12">
                                                <div class="col-lg-12">
                                                    <div class="input-box mb-20">
                                                        <input type="text" id="username2" name="name" placeholder="Type Your Name...">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="input-box mail-input mb-20">
                                                        <input type="text" id="email2" name="email" placeholder="Type Your E-mail...">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="input-box sub-input mb-30">
                                                        <input type="text" id="validationDefault04" placeholder="Type Your Website...">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="input-box text-input mb-20">
                                                        <textarea name="message" id="comment" cols="40" rows="10" placeholder="Type Your Comments..."></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="owner_id" value="<?php echo $v_id; ?>">
                                                <input type="hidden" name="post_id" value="<?php echo $b_id; ?>">
                                                <div class="col-12 mb-15">
                                                    <button type="button" id="submit" class="form-btn form-btn4">
                                                        <i class="fal fa-comment">
                                                        </i>
                                                        Post Comments
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
                                <input type="text" placeholder="Search your keyword..." name="blog_keyword" id="blog_keyword">
                                <button type="submit" class="widget-btn"><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget-post mb-40">
                            <div class="widget-title-box pb-25 mb-30">
                                <h4 class="widget-sub-title2 fs-20">Popular Feeds</h4>
                            </div>
                            <ul class="post-list">
                                <?php
                                $sql = "SELECT * from post WHERE site_id=$this_site_id order by views DESC limit 5";
                                $result = mysqli_query($conn, $sql);
                                if (!$result) {
                                    errlog(mysqli_error($conn), $sql);
                                }
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <li>
                                            <div class="blog-post mb-30">
                                                <a href="news-details.php?id=<?= $row['id']; ?>"><img src="<?= htmlspecialchars($row['featured_image']); ?>" alt="Post Img" style="max-width: 80px; max-height: 80px;"></a>
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
                                        $sql = "SELECT * from post where site_id=$this_site_id and category='$c'";
                                        $rs2 = mysqli_query($conn, $sql);
                                        if (!$rs2) {
                                            errlog(mysqli_error($conn), $sql);
                                        }
                                ?>
                                        <li><a href="news-grid?cat=<?= $c; ?>"><?= $c ?> <span class="f-right"><?= mysqli_num_rows($rs2) ?></span></a></li>

                                    <?php }
                                } else {
                                    ?>
                                    <li><a href="#">Business <span class="f-right">26</span></a></li>
                                    <li><a href="#">Consultant <span class="f-right">30</span></a></li>
                                    <li><a href="#">Creative <span class="f-right">71</span></a></li>
                                    <li><a href="#">UI/UX <span class="f-right">56</span></a></li>
                                    <li><a href="#">Technologys <span class="f-right">60</span></a></li>
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

    <!--================= Jquery latest version =================-->
    <?php include 'common_scripts.php'; ?>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#submit').click(function(e) {

                if ($('#username2').val() == '') {

                    Swal.fire("Error!", "User Name is Mandatory!", "error");
                    return;
                }
                if ($('#email2').val() == '') {

                    Swal.fire("Error!", "Email is Mandatory!", "error");
                    return;
                }
                if ($('#comment').val() == '') {

                    Swal.fire("Error!", "Please Comment here!", "error");
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: 'store_comment.php',
                    data: $('#comments_form').serialize(),
                    success: function(html) {
                        console.log(html);
                        if (html.trim() == '1') {
                            $('#comments_form')[0].reset();
                            Swal.fire("Message Sent", "", "success");
                        } else {
                            Swal.fire("Error", "Something Wrong", "error");
                        }

                    }
                });

            });

        });

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
    </script>
</body>


<!-- /news-details.html / [XR&CO'2014],  19:56:49 GMT -->

</html>