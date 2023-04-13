<?php
session_start();
require "config/connection.php";
unset($_SESSION['APPLIED_COUPON']);
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">

    <!-- viewport meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MartPlace - Complete Online Multipurpose Marketplace HTML Template">
    <meta name="keywords" content="app, app landing, product landing, digital, material, html5">


    <title>Shopping Cart</title>


    <style>
        .container-sajfhdjhfdgsfhdasuhfruesfhgrfjhdsbjhfgjshgfjdhsfkjahdkheusfghescjdsghd {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto
        }

        @media (min-width:576px) {
            .container-sajfhdjhfdgsfhdasuhfruesfhgrfjhdsbjhfgjshgfjdhsfkjahdkheusfghescjdsghd {
                max-width: 540px
            }
        }

        @media (min-width:768px) {
            .container-sajfhdjhfdgsfhdasuhfruesfhgrfjhdsbjhfgjshgfjdhsfkjahdkheusfghescjdsghd {
                max-width: 720px
            }
        }

        @media (min-width:992px) {
            .container-sajfhdjhfdgsfhdasuhfruesfhgrfjhdsbjhfgjshgfjdhsfkjahdkheusfghescjdsghd {
                max-width: 960px
            }
        }

        @media (min-width:1200px) {
            .container-sajfhdjhfdgsfhdasuhfruesfhgrfjhdsbjhfgjshgfjdhsfkjahdkheusfghescjdsghd {
                max-width: 1140px
            }
        }

        .container-sajfhdjhfdgsfhdasuhfruesfhgrfjhdsbjhfgjshgfjdhsfkjahdkheusfghescjdsghd-fluid {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto
        }


        .row-alksdkjsdhfjahdjksjhdjshakjdhskjahkjdshakdjhsajdhsfuyrtsuyeqyieywiuryewiuyrwueyiufdkjbxdbcnbdsnkahkjdh {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px
        }


        .breadcrumbsdfsafsdfsafasfasf {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding: .75rem 1rem;
            margin-bottom: 1rem;
            list-style: none;
            background-color: #e9ecef;
            border-radius: .25rem
        }

        .breadcrumbsdfsafsdfsafasfasf-item+.breadcrumbsdfsafsdfsafasfasf-item {
            padding-left: .5rem
        }

        .breadcrumbsdfsafsdfsafasfasf-item+.breadcrumbsdfsafsdfsafasfasf-item::before {
            display: inline-block;
            padding-right: .5rem;
            color: #6c757d;
            content: "/"
        }

        .breadcrumbsdfsafsdfsafasfasf-item+.breadcrumbsdfsafsdfsafasfasf-item:hover::before {
            text-decoration: underline
        }

        .breadcrumbsdfsafsdfsafasfasf-item+.breadcrumbsdfsafsdfsafasfasf-item:hover::before {
            text-decoration: none
        }

        .breadcrumbsdfsafsdfsafasfasf-item.active {
            color: #6c757d
        }


        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-1,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-10,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-11,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-12,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-2,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-3,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-4,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-5,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-6,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-7,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-8,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-9,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-auto,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-1,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-10,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-11,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-12,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-2,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-3,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-4,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-5,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-6,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-7,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-8,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-9,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-auto,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-1,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-10,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-11,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-12,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-2,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-3,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-4,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-5,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-6,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-7,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-8,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-9,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-auto,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-1,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-10,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-11,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-12,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-2,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-3,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-4,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-5,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-6,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-7,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-8,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-9,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-auto,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-1,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-10,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-11,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-12,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-2,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-3,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-4,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-5,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-6,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-7,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-8,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-9,
        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-auto {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-auto {
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            width: auto;
            max-width: 100%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-1 {
            -ms-flex: 0 0 8.333333%;
            flex: 0 0 8.333333%;
            max-width: 8.333333%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-2 {
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-4 {
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-5 {
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-7 {
            -ms-flex: 0 0 58.333333%;
            flex: 0 0 58.333333%;
            max-width: 58.333333%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-8 {
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-9 {
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-10 {
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-11 {
            -ms-flex: 0 0 91.666667%;
            flex: 0 0 91.666667%;
            max-width: 91.666667%
        }

        .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-12 {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%
        }



        @media (min-width:576px) {
            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm {
                -ms-flex-preferred-size: 0;
                flex-basis: 0;
                -ms-flex-positive: 1;
                flex-grow: 1;
                max-width: 100%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-auto {
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: auto;
                max-width: 100%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-1 {
                -ms-flex: 0 0 8.333333%;
                flex: 0 0 8.333333%;
                max-width: 8.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-2 {
                -ms-flex: 0 0 16.666667%;
                flex: 0 0 16.666667%;
                max-width: 16.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-3 {
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
                max-width: 25%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-4 {
                -ms-flex: 0 0 33.333333%;
                flex: 0 0 33.333333%;
                max-width: 33.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-5 {
                -ms-flex: 0 0 41.666667%;
                flex: 0 0 41.666667%;
                max-width: 41.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-6 {
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-7 {
                -ms-flex: 0 0 58.333333%;
                flex: 0 0 58.333333%;
                max-width: 58.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-8 {
                -ms-flex: 0 0 66.666667%;
                flex: 0 0 66.666667%;
                max-width: 66.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-9 {
                -ms-flex: 0 0 75%;
                flex: 0 0 75%;
                max-width: 75%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-10 {
                -ms-flex: 0 0 83.333333%;
                flex: 0 0 83.333333%;
                max-width: 83.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-11 {
                -ms-flex: 0 0 91.666667%;
                flex: 0 0 91.666667%;
                max-width: 91.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-sm-12 {
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%
            }
        }

        @media (min-width:768px) {
            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md {
                -ms-flex-preferred-size: 0;
                flex-basis: 0;
                -ms-flex-positive: 1;
                flex-grow: 1;
                max-width: 100%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-auto {
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: auto;
                max-width: 100%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-1 {
                -ms-flex: 0 0 8.333333%;
                flex: 0 0 8.333333%;
                max-width: 8.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-2 {
                -ms-flex: 0 0 16.666667%;
                flex: 0 0 16.666667%;
                max-width: 16.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-3 {
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
                max-width: 25%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-4 {
                -ms-flex: 0 0 33.333333%;
                flex: 0 0 33.333333%;
                max-width: 33.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-5 {
                -ms-flex: 0 0 41.666667%;
                flex: 0 0 41.666667%;
                max-width: 41.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-6 {
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-7 {
                -ms-flex: 0 0 58.333333%;
                flex: 0 0 58.333333%;
                max-width: 58.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-8 {
                -ms-flex: 0 0 66.666667%;
                flex: 0 0 66.666667%;
                max-width: 66.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-9 {
                -ms-flex: 0 0 75%;
                flex: 0 0 75%;
                max-width: 75%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-10 {
                -ms-flex: 0 0 83.333333%;
                flex: 0 0 83.333333%;
                max-width: 83.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-11 {
                -ms-flex: 0 0 91.666667%;
                flex: 0 0 91.666667%;
                max-width: 91.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-12 {
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%
            }

            .offset-md-1 {
                margin-left: 8.333333%
            }
        }

        @media (min-width:992px) {
            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg {
                -ms-flex-preferred-size: 0;
                flex-basis: 0;
                -ms-flex-positive: 1;
                flex-grow: 1;
                max-width: 100%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-auto {
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: auto;
                max-width: 100%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-1 {
                -ms-flex: 0 0 8.333333%;
                flex: 0 0 8.333333%;
                max-width: 8.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-2 {
                -ms-flex: 0 0 16.666667%;
                flex: 0 0 16.666667%;
                max-width: 16.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-3 {
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
                max-width: 25%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-4 {
                -ms-flex: 0 0 33.333333%;
                flex: 0 0 33.333333%;
                max-width: 33.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-5 {
                -ms-flex: 0 0 41.666667%;
                flex: 0 0 41.666667%;
                max-width: 41.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-6 {
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-7 {
                -ms-flex: 0 0 58.333333%;
                flex: 0 0 58.333333%;
                max-width: 58.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-8 {
                -ms-flex: 0 0 66.666667%;
                flex: 0 0 66.666667%;
                max-width: 66.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-9 {
                -ms-flex: 0 0 75%;
                flex: 0 0 75%;
                max-width: 75%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-10 {
                -ms-flex: 0 0 83.333333%;
                flex: 0 0 83.333333%;
                max-width: 83.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-11 {
                -ms-flex: 0 0 91.666667%;
                flex: 0 0 91.666667%;
                max-width: 91.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-lg-12 {
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%
            }
        }

        @media (min-width:1200px) {
            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl {
                -ms-flex-preferred-size: 0;
                flex-basis: 0;
                -ms-flex-positive: 1;
                flex-grow: 1;
                max-width: 100%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-auto {
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: auto;
                max-width: 100%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-1 {
                -ms-flex: 0 0 8.333333%;
                flex: 0 0 8.333333%;
                max-width: 8.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-2 {
                -ms-flex: 0 0 16.666667%;
                flex: 0 0 16.666667%;
                max-width: 16.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-3 {
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
                max-width: 25%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-4 {
                -ms-flex: 0 0 33.333333%;
                flex: 0 0 33.333333%;
                max-width: 33.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-5 {
                -ms-flex: 0 0 41.666667%;
                flex: 0 0 41.666667%;
                max-width: 41.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-6 {
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-7 {
                -ms-flex: 0 0 58.333333%;
                flex: 0 0 58.333333%;
                max-width: 58.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-8 {
                -ms-flex: 0 0 66.666667%;
                flex: 0 0 66.666667%;
                max-width: 66.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-9 {
                -ms-flex: 0 0 75%;
                flex: 0 0 75%;
                max-width: 75%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-10 {
                -ms-flex: 0 0 83.333333%;
                flex: 0 0 83.333333%;
                max-width: 83.333333%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-11 {
                -ms-flex: 0 0 91.666667%;
                flex: 0 0 91.666667%;
                max-width: 91.666667%
            }

            .col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-xl-12 {
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%
            }
        }


        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline
        }

        a:not([href]):not([tabindex]) {
            color: inherit;
            text-decoration: none
        }

        a:not([href]):not([tabindex]):focus,
        a:not([href]):not([tabindex]):hover {
            color: inherit;
            text-decoration: none
        }

        a:not([href]):not([tabindex]):focus {
            outline: 0
        }

        .lnr-trash:before {
            content: "\e811"
        }

        .lnr {
            font-family: Linearicons-Free;
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }
    </style>

    <?php // include "./site_head.php"
     include 'template_head.php'; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Rishi330/cart_n_checkout/cart-style.css">
    <link href="https://cdn.jsdelivr.net/gh/Rishi330/admin_template/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Rishi330/admin_template/plugins/sweet-alert2/sweetalert2.min.css" />

</head>

<body class="preload cart-page" style="margin: 0;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;text-align: left;background-color: #fff;">

    <?php
    include "header.php";
    ?>

    <section class="breadcrumbsdfsafsdfsafasfasf-area">
        <div class="container-sajfhdjhfdgsfhdasuhfruesfhgrfjhdsbjhfgjshgfjdhsfkjahdkheusfghescjdsghd">
            <div class="row-alksdkjsdhfjahdjksjhdjshakjdhskjahkjdshakdjhsajdhsfuyrtsuyeqyieywiuryewiuyrwueyiufdkjbxdbcnbdsnkahkjdh">
                <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-12">
                    <div class="breadcrumbsdfsafsdfsafasfasf">
                        <ul>
                            <li>
                                <a href="index.html">Home</a>
                            </li>
                            <li class="active">
                                <a href="#">Shopping Cart</a>
                            </li>
                        </ul>
                    </div>
                    <h1 class="page-titlehthjtrherwrewrewr3243454353">Shopping Cart</h1>
                </div>
            </div>
        </div>
    </section>




    <!--================================
        END breadcrumbsdfsafsdfsafasfasf AREA
    =================================-->

    <!--================================
            START DASHBOARD AREA
    =================================-->
    <section class="cart_area section--padding2 bgcolor">
        <div class="container-sajfhdjhfdgsfhdasuhfruesfhgrfjhdsbjhfgjshgfjdhsfkjahdkheusfghescjdsghd">
            <div class="row-alksdkjsdhfjahdjksjhdjshakjdhskjahkjdshakdjhsajdhsfuyrtsuyeqyieywiuryewiuyrwueyiufdkjbxdbcnbdsnkahkjdh">
                <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-12">
                    <div class="product_archive added_to__cart">
                        <div class="title_areadsafasfasd23242345dxgvdsfgds">
                            <div class="row-alksdkjsdhfjahdjksjhdjshakjdhskjahkjdshakdjhsajdhsfuyrtsuyeqyieywiuryewiuyrwueyiufdkjbxdbcnbdsnkahkjdh">
                                <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-5">
                                    <h4>Product Details</h4>
                                </div>
                                <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-3">
                                    <h4 class="add_info">Quantity</h4>
                                </div>
                                <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-2">
                                    <h4>Price</h4>
                                </div>
                                <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-1">
                                    <h4>Remove</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row-alksdkjsdhfjahdjksjhdjshakjdhskjahkjdshakdjhsajdhsfuyrtsuyeqyieywiuryewiuyrwueyiufdkjbxdbcnbdsnkahkjdh">
                            <?php
                            $total_mrp = $total_discount = 0;
                            $row_counter = 0;

                           /*$qry = "SELECT * FROM iframe_register WHERE `selected_site_id` = '$this_site_id' ORDER BY id DESC ";
                            $res = mysqli_query($conn, $qry);
                            $data = mysqli_fetch_assoc($res);

                            if (!isset($data['id'])) {
                                die("Invalid Request");
                            }
                            $this_site_id = $data['site_id'];
*/
                            if (isset($_SESSION['vendor_id'])  ||  isset($_SESSION['user_id'])) {
                                $vid = -1;
                                if (isset($_SESSION['vendor_id'])) {
                                    $vid = $_SESSION['vendor_id'];
                                } else if (isset($_SESSION['user_id'])) {
                                    $vid = $_SESSION['user_id'];
                                }

                                $qry = "SELECT * from cart_n_wishlist where save_type = 'CART' AND vendor_id = '" . $vid . "' AND quantity > 0 AND save_status = '1' AND site_id = '$this_site_id' order by created_date desc ";
                                $res = mysqli_query($conn, $qry);
                                if (!$res) {
                                    errlog(mysqli_error($conn), $qry);
                                }
                                $in_cart = mysqli_fetch_all($res, MYSQLI_ASSOC);

                                foreach ($in_cart as $item) {
                                    $qry = "";
                                    $marketplace_id = -1;
                                    $redirect_link = "#";
                                    switch (strtoupper($item['marketplace_id'])) {
                                        case '5':
                                            $marketplace_id = 5;
                                            $redirect_link = 'product_detail?pid=' . urlencode(base64_encode($item['item_id'])) . '&var='  . urlencode(base64_encode($item['variant_id']));

                                            $qry = "SELECT *, marketplace_products.id as prod_id, product_variants.id as var_id from marketplace_products, product_variants where marketplace_products.id = '" . $item['item_id'] . "' AND product_variants.id = '" . $item['variant_id'] . "' ";
                                            break;
                                        case '16':
                                            $marketplace_id = 16;
                                            $redirect_link = 'servicedetail?id=' . urlencode(base64_encode($item['item_id']));
                                            $bundle = $item['bundle'];
                                            $qry = "SELECT *, marketplace_services.id as prod_id from marketplace_services where id = '" . $item['item_id'] . "' ";
                                            break;
                                        default:
                                            die("Unknown Marketplace");
                                    }

                                    $res = mysqli_query($conn, $qry);
                                    if (!$res) {
                                        errlog(mysqli_error($conn), $qry);
                                    }

                                    $item_det = mysqli_fetch_assoc($res);

                                    if (isset($bundle)  &&  $bundle == '1') {
                                        $flag = 0;
                                        $idd = $item_det['prod_id'];
                                        $sql89 = " SELECT * FROM addon WHERE marketplace_id='16' AND item_id='$idd' AND type = 'ADDON' ";
                                        $result89 = mysqli_query($conn, $sql89);
                                        if (!$result89) {
                                            errlog(mysqli_error($conn), $sql89);
                                        } else {
                                            while ($row89 = mysqli_fetch_assoc($result89)) {
                                                $flag++;
                                                $item_det['price'] += (float)$row89['price'];
                                            }
                                        }

                                        if ($flag > 0) {
                                            $item_det['service_name'] .= " +" . $flag . " more";
                                        }
                                    }

                                    $main_image = 'x';
                                    $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND variant_id = '" . $item_det['var_id'] . "' AND main = '0' AND marketplace_id = '" . $item['marketplace_id'] . "' AND type = 'IMAGE' ";
                                    $res = mysqli_query($conn, $qry);
                                    if (!$res) {
                                        errlog(mysqli_error($conn), $qry);
                                    }

                                    $res = mysqli_fetch_assoc($res);
                                    if (isset($res['id'])) {
                                        $main_image = $res['image_url'];
                                    } else {
                                        $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '0' AND type = 'IMAGE' ";
                                        $res = mysqli_query($conn, $qry);
                                        if (!$res) {
                                            errlog(mysqli_error($conn), $qry);
                                        }

                                        $res = mysqli_fetch_assoc($res);
                                        if (isset($res['id'])) {
                                            $main_image = $res['image_url'];
                                        }
                                    }

                                    if ($item['variant_id'] != '') {
                                        $qry = "SELECT * from product_images where main = 0 AND product_id = '" . $item['item_id'] . "' AND variant_id = '" . $item['variant_id'] . "' AND marketplace_id = 5 ";
                                        $res = mysqli_query($conn, $qry);
                                        if (!$res) {
                                            errlog(mysqli_error($conn), $qry);
                                        }

                                        $res = mysqli_fetch_assoc($res);
                                        if (isset($res['id'])) {
                                            $main_image = $res['image_url'];
                                        }
                                    }
                                    $row_counter++;
                            ?>


                                    <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-12">
                                        <div class="single_productdadsadasdasdasdasdfb546643 clearfix">


                                            <?php
                                            $price = $item_det['price'];
                                            $qry = "
                                            SELECT
                                                (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,
                                                
                                                (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
                                                
                                                FROM marketplace_products mrp 
                                                INNER JOIN product_variants pv ON pv.product_id = mrp.id
                                                
                                            WHERE mrp.id = '" . $item_det['prod_id'] . "' ";



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
                                            $single_item_discount = $discount;
                                            $discount = $discount * $item['quantity'];

                                            $total_discount += $discount;

                                            ?>
                                            <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-4 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                <div class="product__descriptionsdasfd323523523523asdasdasdasd">
                                                    <img src="<?php echo $main_image ?>" alt="Purchase image" style="height:7rem; width:7rem;">
                                                    <div class="short_descdsgvsdff3r5346436ydasdsa">
                                                        <a href="product_module_details?id=<?php echo urlencode(base64_encode($item['item_id'])) . "&var=" . urlencode(base64_encode($item['variant_id'])) ?>">
                                                            <h4>
                                                                <?php
                                                                switch ($marketplace_id) {
                                                                    case 5:
                                                                        echo htmlspecialchars($item_det['product_title']);
                                                                        break;
                                                                    case 16:
                                                                        echo htmlspecialchars($item_det['service_name']);
                                                                        break;
                                                                }
                                                                ?>
                                                            </h4>
                                                        </a>
                                                        <p style="overflow:hidden;">
                                                            <?php
                                                            switch ($marketplace_id) {
                                                                case 5:
                                                                    echo decoder(strip_tags(($item_det['description'])), 30);
                                                                    break;
                                                                case 16:
                                                                    echo decoder(stringShortner(strip_tags(($item_det['description'])), 30));
                                                                    break;
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-4 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                <div class="product__additional_infosdsafsaf5765asdasdas">
                                                    <ul>
                                                        <li>
                                                            <div class="input-group product__price_download" data-value="2">
                                                                <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf quantity-minus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                                                                    echo $item_det['var_id'];
                                                                                                                                                                } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>" style="display: inline; max-height: 1rem; max-width: 1rem;">
                                                                    <span class="remove_from_cart">
                                                                        <span class="fas fa-minus"></span>
                                                                    </span>
                                                                </div>

                                                                <input class="form-control prodQuantity" type="number" min="1" max="100000" value="<?php echo (int)$item['quantity'] ?>" style="width: 5rem; margin: 0 1rem; display: inline-block;">

                                                                <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf quantity-plus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                                                                    echo $item_det['var_id'];
                                                                                                                                                                } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>" style="display: inline; max-height: 1rem; max-width: 1rem;">
                                                                    <span class="remove_from_cart">
                                                                        <span class="fas fa-plus"></span>
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-2 priceBlock v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                <div class="product__price_download">
                                                    <div class="item_price v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                        <span class="amount amountBlock">
                                                            <?php

                                                            $total_mrp += $item_det['price'] * $item['quantity'];
                                                            if ($discount > 0) {
                                                                echo "&#8377;" . htmlspecialchars(round($item_det['price'] * $item['quantity'] - ($discount), 2));
                                                            } else {
                                                                echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                            }
                                                            ?>
                                                        </span>
                                                        <span class="amount discountBlock" style="margin: 1rem; color: grey; background-color: #dddddd;">
                                                            <del>
                                                                <?php
                                                                if ($discount > 0) {
                                                                    echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                }
                                                                ?>
                                                            </del>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-1 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                <div class="product__price_download">
                                                    <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                        <a href="#" class="remove_from_cart">
                                                            <span class="far fa-trash-alt removeItem" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    <?php
                                }
                            } else if (isset($_COOKIE['guestCart'])  &&  isset($_COOKIE['guestCartQuantity'])) {

                                $all_data = unserialize($_COOKIE['guestCart']);
                                $all_quantities = unserialize($_COOKIE['guestCartQuantity']);

                                foreach ($all_data as $marketplace_id => $prods) {

                                    if ($marketplace_id == 16) {
                                        foreach (explode(',', $prods) as $id) {
                                            if ($id == '')    continue;
                                            $qry = "SELECT * FROM marketplace_services where id = '" . realEscape($id) . "' AND status = 1 AND verified = 1 AND save_type = 'ORG' AND site_id = '$this_site_id' ";
                                            $res = mysqli_query($conn, $qry);
                                            if (!$res) {
                                                errlog(mysqli_error($conn), $qry);
                                            }
                                            $item_det = mysqli_fetch_assoc($res);
                                            if (!isset($item_det['id']))   continue;

                                            $row_counter++;

                                    ?>

                                            <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-12">
                                                <div class="single_productdadsadasdasdasdasdfb546643 clearfix">


                                                    <?php
                                                    $price = $item_det['price'];
                                                    $qry = "
                                                            SELECT
                                                                (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,
                                                                
                                                                (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
                                                                
                                                                FROM marketplace_products mrp 
                                                                INNER JOIN product_variants pv ON pv.product_id = mrp.id
                                                                
                                                            WHERE mrp.id = '" . $item_det['prod_id'] . "' ";



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
                                                    $single_item_discount = $discount;
                                                    $discount = $discount * $item['quantity'];

                                                    $total_discount += $discount;

                                                    ?>
                                                    <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-4 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                        <div class="product__descriptionsdasfd323523523523asdasdasdasd">
                                                            <img src="<?php echo $main_image ?>" alt="Purchase image" style="height:7rem; width:7rem;">
                                                            <div class="short_descdsgvsdff3r5346436ydasdsa">
                                                                <a href="product_module_details?id=<?php echo urlencode(base64_encode($item['item_id'])) . "&var=" . urlencode(base64_encode($item['variant_id'])) ?>">
                                                                    <h4>
                                                                        <?php
                                                                        switch ($marketplace_id) {
                                                                            case 5:
                                                                                echo htmlspecialchars($item_det['product_title']);
                                                                                break;
                                                                            case 16:
                                                                                echo htmlspecialchars($item_det['service_name']);
                                                                                break;
                                                                        }
                                                                        ?>
                                                                    </h4>
                                                                </a>
                                                                <p style="overflow:hidden;">
                                                                    <?php
                                                                    switch ($marketplace_id) {
                                                                        case 5:
                                                                            echo decoder(stringShortner(strip_tags(($item_det['description'])), 30));
                                                                            break;
                                                                        case 16:
                                                                            echo decoder(stringShortner(strip_tags(($item_det['description'])), 30));
                                                                            break;
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-4 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                        <div class="product__additional_infosdsafsaf5765asdasdas">
                                                            <ul>
                                                                <li>
                                                                    <div class="input-group product__price_download" data-value="2">
                                                                        <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf quantity-minus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                                                                            echo $item_det['var_id'];
                                                                                                                                                                        } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>" style="display: inline; max-height: 1rem; max-width: 1rem;">
                                                                            <span class="remove_from_cart">
                                                                                <span class="fas fa-minus"></span>
                                                                            </span>
                                                                        </div>

                                                                        <input class="form-control prodQuantity" type="number" min="1" max="100000" value="<?php echo (int)$item['quantity'] ?>" style="width: 5rem; margin: 0 1rem; display: inline-block;">

                                                                        <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf quantity-plus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                                                                            echo $item_det['var_id'];
                                                                                                                                                                        } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>" style="display: inline; max-height: 1rem; max-width: 1rem;">
                                                                            <span class="remove_from_cart">
                                                                                <span class="fas fa-plus"></span>
                                                                            </span>
                                                                        </div>

                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-2 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                        <div class="product__price_download">
                                                            <div class="item_price v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                                <span class="amount amountBlock">
                                                                    <?php

                                                                    $total_mrp += $item_det['price'] * $item['quantity'];
                                                                    if ($discount > 0) {
                                                                        echo "&#8377;" . htmlspecialchars(round($item_det['price'] * $item['quantity'] - ($discount), 2));
                                                                    } else {
                                                                        echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                    }
                                                                    ?>
                                                                </span>
                                                                <span class="amount discountBlock" style="margin: 1rem; color: grey; background-color: #dddddd;">
                                                                    <del>
                                                                        <?php
                                                                        if ($discount > 0) {
                                                                            echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                        }
                                                                        ?>
                                                                    </del>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-1 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                        <div class="product__price_download">
                                                            <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                                <a href="#" class="remove_from_cart">
                                                                    <span class="far fa-trash-alt removeItem" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {

                                        foreach ($all_data[$marketplace_id] as $item_id => $items) {
                                            $qry = "";

                                            foreach (explode(",", $items) as $vars) {
if($vars=='') continue;
                                                $item = array('marketplace_id' => $marketplace_id, 'item_id' => $item_id, 'variant_id' => $vars, 'quantity' => $all_quantities[$marketplace_id][$item_id][$vars]);


                                                switch ($marketplace_id) {
                                                    case '5':
                                                        $marketplace_id = 5;
                                                        $qry = "SELECT *, marketplace_products.id as prod_id, product_variants.id as var_id from marketplace_products, product_variants where marketplace_products.id = '" . $item['item_id'] . "' AND product_variants.id = '" . $item['variant_id'] . "' AND marketplace_products.site_id = '$this_site_id' ";
                                                        break;
                                                    case '13':
                                                        break;
                                                    default:
                                                        die("Unknown Marketplace");
                                                }

                                                $res = mysqli_query($conn, $qry);
                                                if (!$res) {
                                                    errlog(mysqli_error($conn), $qry);
                                                }

                                                $item_det = mysqli_fetch_assoc($res);

                                                if (isset($bundle)  &&  $bundle == '1') {
                                                    $flag = 0;
                                                    $idd = $item_det['prod_id'];
                                                    $sql89 = " SELECT * FROM addon WHERE marketplace_id='16' AND item_id='$idd' AND type = 'ADDON' ";
                                                    $result89 = mysqli_query($conn, $sql89);
                                                    if (!$result89) {
                                                        errlog(mysqli_error($conn), $sql89);
                                                    } else {
                                                        while ($row89 = mysqli_fetch_assoc($result89)) {
                                                            $flag++;
                                                            $item_det['price'] += (float)$row89['price'];
                                                        }
                                                    }

                                                    if ($flag > 0) {
                                                        $item_det['service_name'] .= " +" . $flag . " more";
                                                    }
                                                }

                                                $main_image = 'x';
                                                $qry = "SELECT * from product_images where product_id = '" . $item_det['prod_id'] . "' AND main = '0' AND type = 'IMAGE' ";
                                                $res = mysqli_query($conn, $qry);
                                                if (!$res) {
                                                    errlog(mysqli_error($conn), $qry);
                                                }

                                                $res = mysqli_fetch_assoc($res);
                                                if (isset($res['id'])) {
                                                    $main_image = $res['image_url'];
                                                }

                                                if ($item['variant_id'] != '') {
                                                    $qry = "SELECT * from product_images where main = '0' AND product_id = '" . $item['item_id'] . "' AND variant_id = '" . $item['variant_id'] . "' AND marketplace_id = 5 ";
                                                    $res = mysqli_query($conn, $qry);
                                                    if (!$res) {
                                                        errlog(mysqli_error($conn), $qry);
                                                    }

                                                    $res = mysqli_fetch_assoc($res);
                                                    if (isset($res['id'])) {
                                                        $main_image = $res['image_url'];
                                                    }
                                                }
                                                $row_counter++;
                                            ?>

                                                <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-12">
                                                    <div class="single_productdadsadasdasdasdasdfb546643 clearfix">


                                                        <?php
                                                        $price = $item_det['price'];
                                                        $qry = "
                                                            SELECT
                                                                (SELECT SUM(discount_percent) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_per,
                                                                
                                                                (SELECT SUM(fixed_amount) FROM discounts WHERE (marketplace_id = 5 OR marketplace_id = 6 OR marketplace_id = 7) AND product_id = mrp.id AND site_id = '" . $this_site_id . "' AND discount_for = 'GENERAL' ) as discount_amount
                                                                
                                                                FROM marketplace_products mrp 
                                                                INNER JOIN product_variants pv ON pv.product_id = mrp.id
                                                                
                                                            WHERE mrp.id = '" . $item_det['prod_id'] . "' ";


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
                                                        $single_item_discount = $discount;
                                                        $discount = $discount * $item['quantity'];

                                                        $total_discount += $discount;

                                                        ?>
                                                        <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-4 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                            <div class="product__descriptionsdasfd323523523523asdasdasdasd">
                                                                <img src="<?php echo $main_image ?>" alt="Purchase image" style="height:7rem; width:7rem;">
                                                                <div class="short_descdsgvsdff3r5346436ydasdsa">
                                                                    <a href="product_module_details?id=<?php echo urlencode(base64_encode($item['item_id'])) . "&var=" . urlencode(base64_encode($item['variant_id'])) ?>">
                                                                        <h4>
                                                                            <?php
                                                                            switch ($marketplace_id) {
                                                                                case 5:
                                                                                    echo htmlspecialchars($item_det['product_title']);
                                                                                    break;
                                                                                case 16:
                                                                                    echo htmlspecialchars($item_det['service_name']);
                                                                                    break;
                                                                            }
                                                                            ?>
                                                                        </h4>
                                                                    </a>
                                                                    <p style="overflow:hidden;">
                                                                        <?php
                                                                        switch ($marketplace_id) {
                                                                            case 5:
                                                                                echo decoder(strip_tags(($item_det['description'])), 30);
                                                                                break;
                                                                            case 16:
                                                                                echo decoder(stringShortner(strip_tags(($item_det['description'])), 30));
                                                                                break;
                                                                        }
                                                                        ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-4 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                            <div class="product__additional_infosdsafsaf5765asdasdas">
                                                                <ul>
                                                                    <li>
                                                                        <div class="input-group product__price_download" data-value="2">
                                                                            <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf quantity-minus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                                                                                echo $item_det['var_id'];
                                                                                                                                                                            } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>" style="display: inline; max-height: 1rem; max-width: 1rem;">
                                                                                <span class="remove_from_cart">
                                                                                    <span class="fas fa-minus"></span>
                                                                                </span>
                                                                            </div>

                                                                            <input class="form-control prodQuantity" type="number" min="1" max="100000" value="<?php echo (int)$item['quantity'] ?>" style="width: 5rem; margin: 0 1rem; display: inline-block;">

                                                                            <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf quantity-plus" data-var="<?php if (isset($item_det['var_id'])) {
                                                                                                                                                                                echo $item_det['var_id'];
                                                                                                                                                                            } ?>" data-prod="<?php echo $item_det['prod_id'] ?>" data-type="<?php echo ($item['marketplace_id']) ?>" data-price="<?php echo $item_det['price'] ?>" data-discount="<?php echo $single_item_discount; ?>" style="display: inline; max-height: 1rem; max-width: 1rem;">
                                                                                <span class="remove_from_cart">
                                                                                    <span class="fas fa-plus"></span>
                                                                                </span>
                                                                            </div>

                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-2 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                            <div class="product__price_download">
                                                                <div class="item_price v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                                    <span class="amount amountBlock">
                                                                        <?php

                                                                        $total_mrp += $item_det['price'] * $item['quantity'];
                                                                        if ($discount > 0) {
                                                                            echo "&#8377;" . htmlspecialchars(round($item_det['price'] * $item['quantity'] - ($discount), 2));
                                                                        } else {
                                                                            echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                    <span class="amount discountBlock" style="margin: 1rem; color: grey; background-color: #dddddd;">
                                                                        <del class="greyAmount">
                                                                            <?php
                                                                            if ($discount > 0) {
                                                                                echo "&#8377;" . htmlspecialchars($item_det['price'] * $item['quantity']);
                                                                            }
                                                                            ?>
                                                                        </del>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-1 v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                            <div class="product__price_download">
                                                                <div class="item_action v_middlesdvfsdfgdsfsdf5476575gfjhfghfgsdfasdf">
                                                                    <a href="#" class="remove_from_cart">
                                                                        <span class="far fa-trash-alt removeItem" data-id="<?php echo $item['item_id'] ?>" data-var="<?php echo $item['variant_id'] ?>" data-type="<?php echo $item['marketplace_id'] ?>"></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                <?php

                                            }
                                        }
                                    }
                                }
                            }

                            if ($row_counter == 0) {
                                ?>
                                <tr>
                                    <td colspan="5">
                                        <center>
                                            <h2>Cart is Empty</h2>
                                        </center>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="row-alksdkjsdhfjahdjksjhdjshakjdhskjahkjdshakdjhsajdhsfuyrtsuyeqyieywiuryewiuyrwueyiufdkjbxdbcnbdsnkahkjdh">
                            <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-5 offset-md-1">
                                <div class="newsletter__form">
                                    <div class="field-wrapper">
                                        <input id="couponCode" class="relative-field rounded" type="text" placeholder="Enter Coupon">
                                        <button class="btn btn--round applyCouponBtn" type="submit">Apply Coupon</button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sjahdkjshfjhajkdhskajfhkahdsjkahjheusgfruyg-md-5">
                                <div class="cart_calculation" style="margin-bottom:2rem;">
                                    <div class="cart--subtotal">
                                        <p>
                                            <span>Cart Subtotal</span>
                                            &#8377;
                                            <a id="subTotal">
                                                <?php echo round($total_mrp, 2) ?>
                                            </a>
                                            -/
                                        </p>
                                    </div>
                                    <div class="cart--subtotal">
                                        <p>
                                            <span>Item Discount</span>&#8377;
                                            <a id="itemDiscount">
                                                <?php echo round($total_discount, 2) ?>
                                            </a>
                                            -/
                                        </p>
                                    </div>
                                    <div class="cart--subtotal">
                                        <p>
                                            <span>Coupon Applied</span>
                                            <a id="couponCodePreview">
                                                --NA--
                                            </a>
                                        </p>
                                    </div>
                                    <div class="cart--subtotal">
                                        <p>
                                            <span>Coupon Discount</span>
                                            &#8377;
                                            <a id="couponDiscountPreview">
                                                0 -/
                                            </a>
                                        </p>
                                    </div>
                                    <div class="cart--total">
                                        <p>
                                            <span>Total</span>&#8377;
                                            <a id="grandTotal">
                                                <?php echo round($total_mrp - $total_discount, 2) ?>
                                            </a>
                                            -/
                                        </p>
                                    </div>
                                </div>
                                <button onclick="history.back()" class="btn btn-md btn-secondary btn--round">Continue Shopping</button>
                                <?php
                                if (getVendorID() > 0) {
                                ?>
                                    <a href="client-checkout.php" class="btn btn-md btn-primary btn--round">Checkout</a>
                                <?php
                                } else {
                                ?>
                                    <button class="btn btn-md btn-primary btn--round checkoutBtn">Checkout</button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php
    include "./footer.php";
    ?>
    
     <?php  include 'common_scripts.php'; ?>
    <script src="https://cdn.jsdelivr.net/gh/Rishi330/admin_template/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {

            <?php

            if (getVendorID() == -1) {
            ?>
                $(".checkoutBtn").on("click", function() {
                    Swal.fire("Error", "Please Login And Try Again...", "error");
                })
            <?php
            }

            ?>

            var total_price = parseFloat('<?php echo $total_mrp ?>');
            var couponDiscount = 0;

            $(".applyCouponBtn").on("click", function() {
                var coupon = $("#couponCode").val();
                couponDiscount = 0;
                $("#couponCodePreview").html("--NA--");
                $("#couponDiscountPreview").html("0-/");
                $.ajax({
                    url: "cart_helper",
                    method: "POST",
                    data: {
                        applyCouponCode: coupon,
                        price: total_price,
                    },
                    success: function(data) {
                        console.log(data);
                        data = $.parseJSON(data);
                        if (data.success) {
                            $("#couponCodePreview").html(coupon.toUpperCase());
                            couponDiscount = data.discount;
                            $("#couponDiscountPreview").html(couponDiscount + "-/");
                            Swal.fire("Coupon Applied", "", "success");
                        } else {
                            Swal.fire("Error", "Invalid Coupon", "error");
                        }
                        updateInvoice();
                    }
                })
            })

            $(".removeItem").on("click", function() {
                var id = $(this).data("id");
                var var_id = $(this).data("var");
                var type = $(this).data("type");
                var th = $(this);
                Swal.fire({
                    icon: "question",
                    title: "Confirmation",
                    text: "Do you really want to remove this item from your cart ?",
                    showConfirmButton: true,
                    confirmButtonText: "Yes, Remove it",
                    showDenyButton: true,
                    denyButtonText: "No",
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "cart_helper",
                            method: "post",
                            data: {
                                removeItem: id,
                                var_id,
                                type,
                            },
                            success: function(data) {
                                if (data.trim() == '1') {
                                    Swal.fire("Removed", "Item removed from cart!", "success");
                                    $(th).parent().parent().parent().parent().parent().remove();
                                } else {
                                    console.log(data);
                                    Swal.fire("Error", "Something went wrong", "error");
                                }
                            }
                        })
                    }
                })
            })



            function updateInvoice() {
                var price = 0;
                var discount = 0;
                let p = 0,
                    d = 0;
                $(".quantity-plus").each(function() {

                    p = parseFloat($(this).data("price"));
                    d = parseFloat($(this).data("discount"));

                    var q = $(this).parent().children(".prodQuantity").val();

                    p *= q;
                    d *= q;

                    price += p;
                    discount += d;
                });

                total_price = price.toFixed(2);
                $("#subTotal").html((price).toFixed(2));
                $("#itemDiscount").html(discount.toFixed(2));
                $("#grandTotal").html((price - (discount + couponDiscount)).toFixed(2));

            }

            updateInvoice();


            $(".quantity-plus").on("click", function() {
                // console.log("Plus");


                var curr = $(this).parent().children(".prodQuantity").val();

                var id = $(this).data("prod");
                var type = $(this).data("type");
                var price = parseFloat($(this).data("price"));
                var discount = parseFloat($(this).data("discount"));

                var v = '';
                if ($(this).data("var")) {
                    v = $(this).data("var");
                }
                var th = $(this);
                // $(th).parent().parent().parent().parent().parent().siblings(".priceBlock").children("div").children("div").children(".discountBlock").children("del");
                // return;

                $.ajax({
                    url: "cart_helper",
                    method: "POST",
                    data: {
                        updateQuantity: "increase",
                        item: id,
                        type: type,
                        variant: v,
                        curr: curr,
                    },
                    success: function(data) {
                        if (data.trim() == 'out') {
                            Swal.fire("Stock limit reached for this item", "", "info");
                            return;
                        }

                        // console.log(data);

                        $(th).prev().val(parseInt($(th).prev().val()) + 1);

                        if (((parseInt(curr) + 1) * (parseFloat(price))).toFixed(2) > ((parseInt(curr) + 1) * (parseFloat(price)) - parseFloat(discount)).toFixed(2)) {
                            $(th).parent().parent().parent().parent().parent().siblings(".priceBlock").children("div").children("div").children(".discountBlock").children("del").html("&#8377; " + ((parseInt(curr) + 1) * (parseFloat(price))).toFixed(2));
                        }


                        $(th).parent().parent().parent().parent().parent().siblings(".priceBlock").children("div").children("div").children(".amountBlock").html("&#8377; " + (((parseInt(curr) + 1) * (parseFloat(price) - parseFloat(discount)))).toFixed(2));
                        updateInvoice();
                    }
                })
            })

            $(".quantity-minus").on("click", function() {
                // console.log("Minus");
                var curr = $(this).parent().children(".prodQuantity").val();


                if (curr <= 1) {
                    return;
                }

                $(this).prev().val(parseInt($(this).prev().val()) + 1);
                var id = $(this).data("prod");
                var type = $(this).data("type");
                var price = parseFloat($(this).data("price"));
                var discount = parseFloat($(this).data("discount"));


                var v = '';
                if ($(this).data("var")) {
                    v = $(this).data("var");
                }

                var th = $(this);

                $(this).siblings(".prodQuantity").each(function() {
                    $(this).val(curr - 1);
                });

                $.ajax({
                    url: "cart_helper",
                    method: "POST",
                    data: {
                        updateQuantity: "decrease",
                        item: id,
                        type: type,
                        variant: v,
                    },
                    success: function(data) {
                        if (((parseInt(curr) - 1) * (parseFloat(price))).toFixed(2) > ((parseInt(curr) - 1) * (parseFloat(price)) - parseFloat(discount)).toFixed(2)) {
                            $(th).parent().parent().parent().parent().parent().siblings(".priceBlock").children("div").children("div").children(".discountBlock").children("del").html("&#8377; " + ((parseInt(curr) - 1) * (parseFloat(price))).toFixed(2));
                        }

                        $(th).parent().parent().parent().parent().parent().siblings(".priceBlock").children("div").children("div").children(".amountBlock").html("&#8377; " + (((parseInt(curr) - 1) * (parseFloat(price) - parseFloat(discount)))).toFixed(2));

                        updateInvoice();
                    }
                })
            })
        })
    </script>
    <!--================================
            END DASHBOARD AREA
    =================================-->
</body>

</html>