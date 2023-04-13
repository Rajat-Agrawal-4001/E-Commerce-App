<?php
require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/Exception.php";
require_once "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function sendMailTo($target, $subject, $body, $attachment = false)
{
    global $conn;
    $mail = new PHPMailer();
    if (isset($attachment['tmp_name'])) {
        $ext = "";
        $name = explode(".", $attachment['name']);
        $ext = $name[count($name) - 1];
        $path = "upload/" . time() . "." . $ext;
        move_uploaded_file($attachment['tmp_name'], $path);
        $mail->addAttachment($path);
        // echo $url;
    }
    $mail->isSMTP();
    $mail->Host = "mail.ewiz.gq";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
    $mail->Username = 'mail@ewiz.gq';
    $mail->Password = "Mail12*()";
    $mail->isHTML(true);
    $mail->setFrom("mail@ewiz.gq");
    $mail->addReplyto = "mail@ewiz.gq";
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->addAddress($target);
    if ($mail->send()) {
        return true;
    } else {
        errlog('', $mail->ErrorInfo);
        return false;
    }
}
