<?php
$sql = "select * from site_details where id=$this_site_id";
                        $site = mysqli_query($conn, $sql);
                        if(!$site){
                          errlog(mysqli_error($conn), $sql);
                      }
                      $site_row=mysqli_fetch_assoc($site);
                            ?> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?php echo htmlspecialchars($site_row["seo_keywords"]);?>">
    <meta name="description" content="<?php echo htmlspecialchars($site_row["seo_description"]);?>">
         <!-- Favicon -->
         <link href="<?php echo htmlspecialchars($site_row["favicon"]);?>" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <title><?= htmlspecialchars($site_row['site_name']); ?></title>

    <!--================= Bootstrap V5 CSS =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!--================= Font Awesome 5 CSS =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/all.min.css">
    <!--================= RT Icons CSS =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/rt-icons.css">
    <!--================= Animate css =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css">
    <!--================= Magnific popup Plugin =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/magnific-popup.css">
    <!--================= Swiper Slider Plugin =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/swiper-bundle.min.css">
    <!--================= Mobile Menu CSS =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/metisMenu.css">
    <!--================= Main Menu CSS =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/rtsmenu.css">
    <!--================= Preloader CSS =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/preloader.css">
    <!--================= Main Stylesheet =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/variables/variable1.css">
    <!--================= Main Stylesheet =================-->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
/* doesnt work funnly on firefox or edge, need to fix */

.range-slider {
  width: 200px;
  text-align: center;
  position: relative;
  margin-bottom:1rem;
  }
  .rangeValues {
    display: block;
	
  }
  

input[type="range"] {
  -webkit-appearance: none;
  border: 1px solid white;
  width: 300px;
  position: absolute;
  left: 0;
}

input[type="range"]::-webkit-slider-runnable-track {
  width: 300px;
  height: 5px;
  background: #ddd;
  border: none;
  border-radius: 3px;
}

input[type="range"]::-webkit-slider-thumb {
  -webkit-appearance: none;
  border: none;
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: #f02011;
  margin-top: -4px;
  cursor: pointer;
  position: relative;
  z-index: 1;
}

input[type="range"]:focus {
  outline: none;
}

input[type="range"]:focus::-webkit-slider-runnable-track {
  background: #ccc;
}

input[type="range"]::-moz-range-track {
  width: 300px;
  height: 5px;
  background: #ddd;
  border: none;
  border-radius: 3px;
}

input[type="range"]::-moz-range-thumb {
  border: none;
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: #21c1ff;
}

/*hide the outline behind the border*/

input[type="range"]:-moz-focusring {
  outline: 1px solid white;
  outline-offset: -1px;
}

input[type="range"]::-ms-track {
  width: 300px;
  height: 5px;
  /*remove bg colour from the track, we'll use ms-fill-lower and ms-fill-upper instead */
  background: transparent;
  /*leave room for the larger thumb to overflow with a transparent border */
  border-color: transparent;
  border-width: 6px 0;
  /*remove default tick marks*/
  color: transparent;
  z-index: -4;
}

input[type="range"]::-ms-fill-lower {
  background: #777;
  border-radius: 10px;
}

input[type="range"]::-ms-fill-upper {
  background: #ddd;
  border-radius: 10px;
}

input[type="range"]::-ms-thumb {
  border: none;
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: #21c1ff;
}

input[type="range"]:focus::-ms-fill-lower {
  background: #888;
}

input[type="range"]:focus::-ms-fill-upper {
  background: #ccc;
}

</style>
</head>