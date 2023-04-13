<?php

include 'config/connection.php';
$vid = getVendorID();

$qry = "SELECT * FROM admin WHERE site_id = $this_site_id";
$res = mysqli_query($conn, $qry);
if (!$res) {
    errlog(mysqli_error($conn), $qry);
}
$row = mysqli_fetch_assoc($res);
$admin_id = realEscape($row['vendor_id']);

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['message'])) {
    $name = realEscape($_POST['name']);
    $email = realEscape($_POST['email']);
    $phone = realEscape($_POST['phone']);
    $message = realEscape($_POST['message']);
    $subject = realEscape($_POST['subject']);
    $sql = "INSERT into messages(site_id,sender,receiver,direct_mail,message,status,marketplace_id,msg_type) values('$this_site_id','$vid','$admin_id','$email','$message','1','5','message')";
    $rs = mysqli_query($conn, $sql);
    if (!$rs) {
        errlog(mysqli_error($conn), $sql);
    } else {
        echo 1;
    }
    die;
}

?>
<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">


<!-- /contact.html / [XR&CO'2014],  19:56:49 GMT -->
<?php include 'template_head.php'; ?>

<body>
    <!--================= Preloader Section Start Here =================-->
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
    <!--contact-area start-->
    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">

                    <form class="contact-form mb-10" id="contact_form" method="post" action="#">
                        <div class="section-header section-header5 text-start">
                            <div class="wrapper">
                                <div class="sub-content">
                                    <img class="line-1" src="assets/images/banner/wvbo-icon.png" alt="">
                                    <span class="sub-text">Contact Us</span>
                                </div>
                                <h2 class="title">MAKE CUSTOM REQUEST</h2>
                            </div>
                        </div>
                        <div class="info-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="input-box mb-20">
                                        <input type="text" id="name" name="name" placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="input-box mail-input mb-20">
                                        <input type="email" id="email1" name="email" placeholder="E-mail Address">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="input-box number-input mb-30">
                                        <input type="number" id="phone" name="phone" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="input-box sub-input mb-30">
                                        <input type="text" id="subject" name="subject" placeholder="Subject...">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="input-box text-input mb-20">
                                        <textarea id="message" cols="30" rows="10" placeholder="Enter message" name="message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mb-15">
                                    <button type="submit" class="form-btn form-btn4">
                                        Get A Quote
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="right-side">
                        <div class="get-in-touch">
                            <h3 class="section-title2">
                                GET IN TOUCH
                            </h3>
                            <div class="contact">
                                <ul>
                                    <li class="one">
                                        <?= htmlspecialchars($site_row['city']); ?>,<?= htmlspecialchars($site_row['state']); ?>
                                    </li>
                                    <li class="two"><a href="tel:+0989057868978">+ 98 <?= htmlspecialchars($site_row['phone_number']); ?></a>
                                        <a href="tel:61463895748"></a>
                                    </li>
                                    <li class="three">Store Hours: <br>
                                        10 am - 10 pm EST, 7 days a week</li>
                                </ul>
                            </div>
                        </div>
                        <div class="section-button">
                            <div class="btn-1">
                                <a href="#">Get Support On Call <i class="fal fa-headphones-alt"></i></a>
                            </div>
                            <div class="btn-2">
                                <a href="#">Get Direction <i class="rt-location-dot"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="map">
            <p><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3651.0452483624595!2d90.424043!3d23.781403!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3cc42b4e4b430164!2sReacThemes!5e0!3m2!1sen!2sbd!4v1656420500360!5m2!1sen!2sbd" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
        </div>
    </div>
    <!--contact-area end-->

    <!--================= Footer Start Here =================-->
    <?php include 'footer.php'; ?>
    <!--================= Footer End Here =================-->


    <!--================= Scroll to Top Start =================-->
    <div class="scroll-top-btn scroll-top-btn1"><i class="fas fa-angle-up arrow-up"></i><i class="fas fa-circle-notch"></i></div>
    <!--================= Scroll to Top End =================-->

    <!--================= Jquery latest version =================-->
    <?php include 'common_scripts.php'; ?>
    <script>
        $("#contact_form").on("submit", function(e) {
            e.preventDefault();

            if ($('#name').val() == '') {
                Swal.fire("Error!", "Your Name is Compulsory.", "error");
                return;
            }
            if ($('#email1').val() == '') {
                Swal.fire("Error!", "Email is Mandatory.", "error");
                return;
            }
            if ($('#phone').val() == '') {
                Swal.fire("Error!", "Please Fill your Mobile number.", "error");
                return;
            }
            if ($('#message').val() == '') {
                Swal.fire("Error!", "Please Write Some Message.", "error");
                return;
            }

            $.ajax({
                type: 'POST',
                data: $('#contact_form').serialize(),
                success: function(data) {
                    if (data == '1') {
                        $('#contact_form')[0].reset();
                        Swal.fire("Message Sent.", "", "success");
                    } else {
                        Swal.fire("Something went Wrong.", "", "error");
                    }
                }
            });

        });
    </script>
</body>


<!-- /contact.html / [XR&CO'2014],  19:56:49 GMT -->

</html>