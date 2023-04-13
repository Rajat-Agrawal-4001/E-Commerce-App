<?php

define('PAYMENT_INDEX', 999999);

date_default_timezone_set('Asia/Kolkata');

$curr_date = date('Y-m-d H:i:s');

$site_name = 'Ideal Village';
$vendor_icon = '../assets/images/favicon.ico';
$admin_icon = '../assets/images/favicon.ico';
$web_desc = '';
$this_site_url = 'https://localhost/shop/e-commerce';
$this_site_id = 2;
$site_logo = "https://res.cloudinary.com/dza7mzhl1/image/upload/v1643883798/emp2nuha6lpromvurltb.png";

$avatar = $this_site_url . '/assets/images/avatar.png';


$dbname = 'idealvillage';
$password = '';
$username = 'root';
$conn = mysqli_connect('localhost', $username, $password, $dbname);

if (!$conn) {
    echo "Connection Error.";
    die;
}

$s = '';
if (isset($_GET['s'])) {
    $s = $_GET['s'];
}

// if ((isset($_SESSION['vendor_id']) ||  isset($_SESSION['user_id']))  &&  $s !=  urlencode(base64_encode("inactivity")) ) {
//     if (isset($_SESSION['session_expiry_date'])) {
//         if ($_SESSION['session_expiry_date'] < $curr_date) {
//             header("Location: " . $this_site_url . "/logout?s=" . urlencode(base64_encode("inactivity"))) ;
//         } else {
//             $_SESSION['session_expiry_date'] = date("Y-m-d H:i:s", strtotime($curr_date . " + 15 min")) ;
//         }
//     } else {
//         $_SESSION['session_expiry_date'] = date("Y-m-d H:i:s", strtotime($curr_date . " + 15 min")) ;
//     }
// }

function getProductRating($item_id, $var_id, $marketplace)
{
    global $this_site_id, $conn;
    $p_rating = 0;
    $sql = "SELECT avg(rating) as num, count(id) as reviews from product_rating where site_id=$this_site_id and marketplace_id=$marketplace and item_id=$item_id and status=1";

    $res2 = mysqli_query($conn, $sql);
    if (!$res2) {
        errlog(mysqli_error($conn), $sql);
    } else {
        $res = mysqli_fetch_assoc($res2);
        $p_rating = round($res['num']);
        $review = $res['reviews'];
    }

    return array($p_rating, $review);
}


function getCartItems($marketplace_id, $save_type)
{
    global $this_site_id, $conn;

    $total_cart_items = 0;
    if (isset($_SESSION['vendor_id'])  ||  isset($_SESSION['user_id'])) {
        $vid = getVendorID();
        $qry = "SELECT count(*) from cart_n_wishlist where site_id = $this_site_id AND save_status = '1' AND marketplace_id = '$marketplace_id' AND vendor_id = '$vid' and save_type = '$save_type' ";

        $res = '';
        if (!$res = mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
            return false;
        }
        $wishes = mysqli_fetch_assoc($res);
        $total_cart_items = $wishes['count(*)'];
        return $total_cart_items;
    } else {
        $data = array();
        if (isset($_COOKIE['guestCart'])) {
            $data = unserialize($_COOKIE['guestCart']);
        }
        if (isset($data[$marketplace_id])) {
            if ($marketplace_id == '5'  ||  $marketplace_id == '6') {
                $total_cart_items = count($data[$marketplace_id]);
            } else {
                $arr = explode(',', $data[$marketplace_id]);
                $total_cart_items = count($arr);
            }
            return $total_cart_items;
        } else {
            return 0;
        }
    }
}


function getVendorID()
{
    $vendor_id = -1;
    if (isset($_SESSION['vendor_id'])) {
        $vendor_id = $_SESSION['vendor_id'];
    } else if (isset($_SESSION['user_id'])) {
        $vendor_id = $_SESSION['user_id'];
    }

    return $vendor_id;
}


function getMarketplaceName($marketplace_id)
{
    switch ($marketplace_id) {
        case 1:
            return "Recruiter Connect";
        case 2:
            return "Seekers";
        case 5:
            return "E-Commerce";
        case 15:
            return "Service";
        default:
            return "Unknown Marketplace ID.";
    }
}

function realEscape($val)
{
    global $conn;
    return mysqli_escape_string($conn, $val);
}



function agoTime($time)    // time  = 2022:03:02 13:00:00
{
    $time = strtotime($time);
    $time_difference = time() - $time;

    if ($time_difference < 1) {
        return 'less than 1 second ago';
    }
    $condition = array(
        12 * 30 * 24 * 60 * 60  =>  'year',
        30 * 24 * 60 * 60       =>  'month',
        24 * 60 * 60            =>  'day',
        60 * 60                 =>  'hour',
        60                      =>  'minute',
        1                       =>  'second'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}


function errlog($error, $qry)
{
    global $curr_date;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    $url .= $_SERVER['HTTP_HOST'];
    $url .= $_SERVER['REQUEST_URI'];

    $handle = fopen('error.txt', 'a');
    $txt = $curr_date . " ERROR : [URL:" . $url . "] " . $error . " [SQL:" . $qry . "]\r\n";
    fwrite($handle, $txt);
    fclose($handle);
    echo '<script> location.replace("error.html"); </script>';
}



function setOnlineStatus($status = "Online")
{
    $vendor_id = -1;
    $type = 0;
    if (isset($_SESSION['user_id'])) {
        $vendor_id = $_SESSION['user_id'];
    }

    if (isset($_SESSION['vendor_id'])) {
        $vendor_id = $_SESSION['vendor_id'];
    }

    if (isset($_SESSION['admin_id'])) {
        $vendor_id = $_SESSION['admin_id'];
        $type = 1;
    }

    global $conn, $curr_date;
    $table_name = '';
    if ($type == 0) {
        $table_name = 'vendor';
    } else if ($type == 1) {
        $table_name = 'admin';
    }


    $vendor_id = realEscape($vendor_id);
    $status = realEscape($status);
    $curr_date = realEscape($curr_date);
    $qry = "UPDATE $table_name set login_status = '$status', last_online = '$curr_date' where id = '$vendor_id' ";
    if (mysqli_query($conn, $qry)) {
        return true;
    } else {
        errlog(mysqli_error($conn), $qry);
    }
    return false;
}


setOnlineStatus();



function encoder($str)
{
    $str = str_replace("'", "'+" . '"' . "'" . '"' . "+'", $str);
    return $str;
}

function decoder($str)
{
    $str = str_replace("'+" . '"' . "'" . '"' . "+'", "'", $str);
    $str = str_replace("<script>", htmlspecialchars("<script>"), $str);
    $str = str_replace("</script>", htmlspecialchars("</script>"), $str);
    return $str;
}


function encryptor($str, $encryptionKey = '7362175432648732')
{
    $key = 'shjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%gfdsgsrstrs%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&65555555zgfdsgfds555555555555555fdsafds55555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555gfsgfdsgydFDs555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%ccdgvfdgfsgfdsgfd%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suy';

    $cipher = "AES-128-CTR";

    $options = 0;

    return openssl_encrypt($str, $cipher, $key, $options, $encryptionKey);
}


function decryptor($str, $decryptionKey = '7362175432648732')
{
    $key = 'shjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%gfdsgsrstrs%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&65555555zgfdsgfds555555555555555fdsafds55555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555gfsgfdsgydFDs555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%ccdgvfdgfsgfdsgfd%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suy';

    $cipher = "AES-128-CTR";

    $options = 0;

    return openssl_decrypt($str, $cipher, $key, $options, $decryptionKey);
}
