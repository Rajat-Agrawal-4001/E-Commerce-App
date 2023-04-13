<?php
session_start();
include "config/connection.php";
require_once "config/generalMailer.php";
require_once "config/logo_maker.php";

function isMobile($mobile)
{
    if ($mobile[0] == '+') {
        if (strlen($mobile) != 13) {
            return false;
        }

        if ((int)($mobile[3]) < 6) {
            return false;
        }
    } else {
        if ((int)($mobile[0]) < 6) {
            return false;
        }

        if (strlen($mobile) != 10) {
            return false;
        }
    }

    return true;
}

function generatePassword()
{
    $string = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "!", "@", "#", "+", "-", "$", "%", "&", "*", "(", ")", ",", ".", "/", "{", "}", "[", "]", "~", "_", "=", "^");
    $newPassword = "";
    for ($i = 0; $i < 10; $i++) {
        $index = rand(0, count($string) - 1);
        $newPassword .= $string[$index];
    }
    return $newPassword;
}

// user login
if (isset($_POST['userLogin'])) {
    $email = $_POST['email'];
    $password = realEscape($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)  &&  !isMobile($email)) {
        die("4");
    }

    $email = realEscape($email);

    $qry = "SELECT * FROM vendor where vendor_type = '500' AND (email = '$email' OR (mobile = '$email' AND mobile_verified = 1)) AND site_id = $this_site_id AND status = 1 AND verified = 1 ";

    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    } else {
        $result = mysqli_fetch_assoc($res);
        if (isset($result['id'])) {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                $verify_code = password_hash($result['id'], PASSWORD_DEFAULT);
                $qry = "UPDATE vendor SET verify_code = '" . realEscape($verify_code) . "' WHERE id = '" . $result['id'] . "' ";
                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                }

                if (isset($_POST['rememberMe'])) {
                    setcookie('rememberForIdealVillageUser', $verify_code, time() + 60 * 60 * 24 * 7, '/');
                    setcookie('verificationFlagUser1', password_hash($result['password'], PASSWORD_DEFAULT), time() + 60 * 60 * 24 * 7, '/');
                    setcookie('verificationFlagUser2', password_hash($result['email'], PASSWORD_DEFAULT), time() + 60 * 60 * 24 * 7, '/');
                }
                echo '1';
            } else {
                echo "2";
            }
        } else {
            $qry = "SELECT * FROM vendor where vendor_type = '500' AND (email = '$email' OR (mobile = '$email' AND mobile_verified = 1)) AND site_id = $this_site_id ";
            $res = mysqli_query($conn, $qry);
            if (!$res) {
                errlog(mysqli_error($conn), $qry);
            } else {
                $res = mysqli_fetch_assoc($res);
                if (isset($res['id'])) {
                    echo "5";
                } else {
                    echo "3";
                }
            }
        }
    }
} else if (isset($_POST['signup'])) {
    $email = realEscape($_POST['emailID']);
    $username = realEscape($_POST['username']);

    $qry = "SELECT * from vendor where email = '$email' AND vendor_type = '500' AND site_id = $this_site_id ";
    $res = mysqli_query($conn, $qry);
    if ($res) {
        $result = mysqli_fetch_assoc($res);
        if (isset($result['id'])  &&  $result['status'] == '1') {
            echo "Email is already registered .";
        } else if (isset($result['id'])  &&  $result['status'] == '2') {
            echo "Account had been suspended.";
        } else if (!isset($result['id'])) {
            $_SESSION['tmp_email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['tmp_otp'] = $otp = rand(100000, 999999);
            $_SESSION['create_time'] = $curr_date;
            $_SESSION['passwordString'] = $password = generatePassword();
            $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);

            $main_body_text = "verify your email";

            $body = '<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style=" @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: ' . "'Open Sans'" . ', sans-serif; ">
                    <tr>
                        <td>
                            <table style="background-color: #f2f3f8; max-width: 670px; margin: 0 auto" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="height: 80px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center">
                                        <a href="" title="logo" target="_blank">
                                            <img width="60" src="' . $site_logo . '" title="logo" alt="logo" />
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 20px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style=" max-width: 670px; background: #fff; border-radius: 3px; text-align: center; -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); ">
                                            <tr>
                                                <td style="height: 40px">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0 35px">
                                                    <h1 style="color: #1e1e2d; font-weight: 500; margin: 0; font-size: 32px; font-family: ' . "'Rubik'" . ', sans-serif; "> Email Verification </h1> <span style=" display: inline-block; vertical-align: middle; margin: 29px 0 26px; border-bottom: 1px solid #cecece; width: 100px; "></span>
                                                    <p style="color: #455056; font-size: 15px; line-height: 24px; margin: 0; "> Thank you for choosing ' . $site_name . '. Use the following OTP to ' . $main_body_text . '. OTP is valid for 5 minutes </p> <a href="javascript:void(0);" style=" background: #20e277; text-decoration: none !important; font-weight: 700; margin-top: 35px; color: #fff; text-transform: uppercase; font-size: 22px; padding: 10px 24px; display: inline-block; border-radius: 50px; ">' . $otp . '</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height: 40px">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 20px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center">
                                        <p style=" font-size: 14px; color: rgba(69, 80, 86, 0.7411764705882353); line-height: 18px; margin: 0 0 0; "> &copy; <strong>' . $site_name . '</strong> </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 80px">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </body>';
            if (sendMailTo($email, "OTP", $body)) {
                echo "1";
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    } else {
        errlog(mysqli_error($conn), $qry);
    }
}

//otp verify section

else if (isset($_POST['verifyEmail'])) {
    if ($_SESSION['tmp_otp'] == realEscape($_POST['verifyEmail'])  &&  $_SESSION['create_time'] >= date("Y-m-d h:i:s", strtotime($curr_date . "-5 minute"))) {
       // $profile = getLogoURL(substr($_SESSION['username'], 0, 1));
       $profile="";
        $qry = "INSERT INTO vendor (site_id, name, email, password, vendor_type, created_by, status, verified, login_status, last_online, profile_pic) VALUES ($this_site_id, '" . realEscape($_SESSION['username']) . "', '" . realEscape($_SESSION['tmp_email']) . "', '" . realEscape($_SESSION['password']) . "', '500', 'SELF', 1, 1, 'LOGIN', '$curr_date', '$profile') ";
        // echo $qry ;

        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        } else {
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $main_body_text = "Your account has been created and password to login into your account is <b>" . $_SESSION['passwordString'] . "</b>";

            $body = '<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style=" @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: ' . "'Open Sans'" . ', sans-serif; ">
                    <tr>
                        <td>
                            <table style="background-color: #f2f3f8; max-width: 670px; margin: 0 auto" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="height: 80px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center">
                                        <a href="" title="logo" target="_blank">
                                            <img width="60" src="' . $site_logo . '" title="logo" alt="logo" />
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 20px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style=" max-width: 670px; background: #fff; border-radius: 3px; text-align: center; -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); ">
                                            <tr>
                                                <td style="height: 40px">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0 35px">
                                                    <h1 style="color: #1e1e2d; font-weight: 500; margin: 0; font-size: 32px; font-family: ' . "'Rubik'" . ', sans-serif; "> New One Time Password(OTP) </h1> <span style=" display: inline-block; vertical-align: middle; margin: 29px 0 26px; border-bottom: 1px solid #cecece; width: 100px; "></span>
                                                    <p style="color: #455056; font-size: 15px; line-height: 24px; margin: 0; "> Thank you for choosing ' . $site_name . '.' . $main_body_text . '  </p> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height: 40px">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 20px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center">
                                        <p style=" font-size: 14px; color: rgba(69, 80, 86, 0.7411764705882353); line-height: 18px; margin: 0 0 0; "> &copy; <strong>' . $site_name . '</strong> </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 80px">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </body>';

            sendMailTo($_SESSION['tmp_email'], "Account Created", $body);

            unset($_SESSION['tmp_otp']);
            unset($_SESSION['username']);
            unset($_SESSION['tmp_email']);
            unset($_SESSION['create_time']);
            unset($_SESSION['password']);
            unset($_SESSION['passwordString']);

            echo "1";
        }
    } else {
        echo "Invalid OTP ";
    }
} else if (isset($_POST['vendorLogin'])) {
    $email = $_POST['email'];
    $password = realEscape($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)  &&  !isMobile($email)) {
        die("4");
    }

    $email = realEscape($email);

    $qry = "SELECT * from vendor where site_id = $this_site_id AND (email = '$email' OR (mobile = '$email' AND mobile_verified = 1)) AND vendor_type <> 500 AND status = 1 AND verified = 1 ";
    $res = mysqli_query($conn, $qry);

    $response = -1;

    if ($res) {
        $response = 3;

        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
        foreach ($data as $res) {
            if (isset($res['id'])) {
                if (password_verify($password, $res['password'])) {
                    $verify_code = password_hash($res['id'], PASSWORD_DEFAULT);

                    if (isset($_POST['rememberMe'])) {
                        setcookie('rememberForIdealVillageVendor', $verify_code, time() + 60 * 60 * 24 * 7, '/');
                        setcookie('verificationFlagVendor1', password_hash($res['password'], PASSWORD_DEFAULT), time() + 60 * 60 * 24 * 7, '/');
                        setcookie('verificationFlagVendor2', password_hash($res['email'], PASSWORD_DEFAULT), time() + 60 * 60 * 24 * 7, '/');
                    }

                    $qry = "UPDATE vendor set verify_code = '$verify_code' where id = '" . $res['id'] . "' ";
                    if (mysqli_query($conn, $qry)) {
                        $_SESSION['vendor_id'] = $res['id'];
                        $_SESSION['verify_code'] = $verify_code;
                        $response = 1;
                        setOnlineStatus($res['id'], 'Login'); // type = 1 for admin and 0 (default for vendor)
                    } else {
                        errlog(mysqli_error($conn), $qry);
                        $response = 0;
                    }
                } else {
                    $response = 2;
                }
            } else {
                $qry = "SELECT * FROM vendor where vendor_type <> '500' AND (email = '$email' OR (mobile = '$email' AND mobile_verified = 1)) AND site_id = $this_site_id ";
                $res = mysqli_query($conn, $qry);
                if (!$res) {
                    errlog(mysqli_error($conn), $qry);
                } else {
                    $res = mysqli_fetch_assoc($res);
                    if (isset($res['id'])) {
                        $response = "5";
                    } else {
                        $response = "3";
                    }
                }
            }
        }
    } else {
        $response = 0;
        errlog(mysqli_error($conn), $qry);
    }

    echo $response;
} else if (isset($_POST['sendOtp'])) {

    if (isset($_SESSION['tmp_otp'])  &&  isset($_SESSION['otp_created_on'])  &&  $_SESSION['otp_created_on'] > date("Y-m-d H:i:s", strtotime($curr_date . "-2 minute"))) {
        die("-5");
    }

    $email = $_POST['sendOtp'];
    if (!isMobile($email)  &&  !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid data");
    }

    $email = realEscape($email);
    $otpfor = realEscape($_POST['otpfor']);

    if ($otpfor == 'vendor') {
        $_SESSION['type'] = 1;
        $qry = "SELECT * FROM vendor WHERE site_id = $this_site_id AND (email = '$email' OR (mobile = '$email' AND mobile_verified = 1)) AND vendor_type <> 500 AND status = 1 AND verified = 1 ";
    } else if ($otpfor == 'user') {
        $_SESSION['type'] = 2;
        $qry = "SELECT * FROM vendor where vendor_type = '500' AND (email = '$email' OR (mobile = '$email' AND mobile_verified = 1)) AND site_id = $this_site_id AND status = 1 AND verified = 1 ";
    } else {
        die("Invalid type");
    }

    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }

    $data = mysqli_fetch_assoc($res);
    if (isset($data['id'])) {
        $email = $data['email'];
        $_SESSION['otp_created_on'] = $curr_date;
        $_SESSION['pending_id'] = $data['id'];
        $_SESSION['tmp_otp'] = $otp = rand(100000, 999999);

        $main_body_text = "login";

        $body = '<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style=" @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: ' . "'Open Sans'" . ', sans-serif; ">
                    <tr>
                        <td>
                            <table style="background-color: #f2f3f8; max-width: 670px; margin: 0 auto" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="height: 80px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center">
                                        <a href="" title="logo" target="_blank">
                                            <img width="60" src="' . $site_logo . '" title="logo" alt="logo" />
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 20px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style=" max-width: 670px; background: #fff; border-radius: 3px; text-align: center; -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06); ">
                                            <tr>
                                                <td style="height: 40px">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0 35px">
                                                    <h1 style="color: #1e1e2d; font-weight: 500; margin: 0; font-size: 32px; font-family: ' . "'Rubik'" . ', sans-serif; ">Login OTP</h1> <span style=" display: inline-block; vertical-align: middle; margin: 29px 0 26px; border-bottom: 1px solid #cecece; width: 100px; "></span>
                                                    <p style="color: #455056; font-size: 15px; line-height: 24px; margin: 0; "> Thank you for choosing ' . $site_name . '. Use the following OTP to ' . $main_body_text . '. OTP is valid for 5 minutes </p> <a href="javascript:void(0);" style=" background: #20e277; text-decoration: none !important; font-weight: 700; margin-top: 35px; color: #fff; text-transform: uppercase; font-size: 22px; padding: 10px 24px; display: inline-block; border-radius: 50px; ">' . $otp . '</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height: 40px">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 20px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center">
                                        <p style=" font-size: 14px; color: rgba(69, 80, 86, 0.7411764705882353); line-height: 18px; margin: 0 0 0; "> &copy; <strong>' . $site_name . '</strong> </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 80px">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </body>';
        if (sendMailTo($email, "OTP", $body)) {
            echo "1";
        } else {
            echo "Something went wrong. Please try again later.";
        }
    } else {
        die("2");
    }
} else if (isset($_POST['verifyLoginOtp'])) {
    if (isset($_SESSION['tmp_otp'])  &&  isset($_SESSION['otp_created_on'])  &&  isset($_SESSION['type'])) {
        if ($_SESSION['tmp_otp'] == realEscape($_POST['verifyLoginOtp'])  &&  $_SESSION['otp_created_on'] >= date("Y-m-d H:i:s", strtotime($curr_date . "-5 minute"))) {
            if ($_SESSION['type'] == 1) {
                $_SESSION['vendor_id'] = $_SESSION['pending_id'];
            } else if ($_SESSION['type'] == 2) {
                $_SESSION['user_id'] = $_SESSION['pending_id'];
            }
            echo 1;
            unset($_SESSION['tmp_otp']);
            unset($_SESSION['otp_created_on']);
            unset($_SESSION['type']);
        } else {
            echo 2;
        }
    } else {
        die("Invalid Request");
    }
}