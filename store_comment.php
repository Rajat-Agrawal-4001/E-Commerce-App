<?php
include 'config/connection.php';

$vid = getVendorID();

if (isset($_POST['name'], $_POST['message'], $_POST['post_id'], $_POST['email'])) {

    $name = realEscape($_POST['name']);
    $message = realEscape($_POST['message']);
    $post_id = realEscape($_POST['post_id']);
    $owner_id = realEscape($_POST['owner_id']);
    $email = realEscape($_POST['email']);

    $sql = "INSERT into messages(site_id,sender,receiver,item_id,message,status,msg_type,marketplace_id) values('$this_site_id','$vid','$owner_id','$post_id','$message','1','comment','21')";
    $rs = mysqli_query($conn, $sql);
    if (!$rs) {
        errlog(mysqli_error($conn), $sql);
    } else {
        echo 1;
    }
    die;
}

if (isset($_POST['subscribe'], $_POST['e_mail'])) {

    $email = realEscape($_POST['e_mail']);
    $sql = "INSERT into subscribe(site_id,email_id,marketplace_id) values('$this_site_id','$email','5')";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        errlog(mysqli_error($conn), $sql);
    } else {
        echo 1;
    }
    die;
}
