<?php
define('PAYMENT_INDEX', 999999);
define('DEFAULT_ENC_KEY', '7362175432648732');

date_default_timezone_set('Asia/Kolkata');
$curr_date = date('Y-m-d H:i:s');
$site_name = 'Ideal Village';
$vendor_icon = '../assets/images/favicon.ico';
$admin_icon = '../assets/images/favicon.ico';
$web_desc = '';

$this_site_url = 'https://localhost/shop/e-commerce';
$this_site_id = 2;
$favicon = $site_logo = "https://res.cloudinary.com/dza7mzhl1/image/upload/v1643883798/emp2nuha6lpromvurltb.png";
$placeholder_image = 'https://getuikit.com/v2/docs/images/placeholder_600x400.svg';
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



$qry = "UPDATE vendor SET last_online = '$curr_date' WHERE id = '" . getVendorID() . "' ";
mysqli_query($conn, $qry);


function getVendorInfo(Int $vendorID = -1)
{
    global $conn;

    if ($vendorID == -1) {
        $vendorID = getVendorID();
    }

    $qry = "SELECT * FROM vendor WHERE id = '$vendorID' ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_assoc($res);

    return $data;
}


function currentVendorLevel(): array
{
    $response = array();
    if (isset($_SESSION['admin_id'])) {
        $response['ADMIN_ID'] = $_SESSION['admin_id'];
        $response['VENDOR_ID'] = $_SESSION['vendor_id'];

        $response['IS_ADMIN'] = true;
        $response['IS_VENDOR'] = true;
        $response['IS_USER'] = true;
    } else if (isset($_SESSION['vendor_id'])) {
        $response['ADMIN_ID'] = -1;
        $response['VENDOR_ID'] = $_SESSION['vendor_id'];

        $response['IS_ADMIN'] = false;
        $response['IS_VENDOR'] = true;
        $response['IS_USER'] = true;
    } else if (isset($_SESSION['user_id'])) {
        $response['ADMIN_ID'] = -1;
        $response['VENDOR_ID'] = -1;
        $response['USER_ID'] = $_SESSION['user_id'];

        $response['IS_ADMIN'] = false;
        $response['IS_VENDOR'] = false;
        $response['IS_USER'] = true;
    } else {
        $response['ADMIN_ID'] = -1;
        $response['VENDOR_ID'] = -1;
        $response['USER_ID'] = -1;

        $response['IS_ADMIN'] = false;
        $response['IS_VENDOR'] = false;
        $response['IS_USER'] = false;
    }

    return $response;
}


function realEscape($val)
{
    global $conn;
    return mysqli_escape_string($conn, $val);
}


function agoTime($time, $chat_time = false, $show_online = false)
{
    global $curr_date;

    if ($chat_time) {
        $chat_date = new DateTime(date('Y-m-d H:i:s', strtotime($time)));
        $curr_time = new DateTime($curr_date);

        $diff = $curr_time->diff($chat_date);
        if ($diff->y > 0  ||  $diff->m > 0   ||  $diff->d > 14) {
            return (date('D-M-y', strtotime($time)));
        }

        if ($diff->d == 1) {
            return ($diff->d . " Day ago");
        }

        if ($diff->d > 0) {
            return ($diff->d . " Days ago");
        }


        if ($diff->h == 1) {
            return ($diff->h . " hr ago");
        }

        if ($diff->h > 0) {
            return ($diff->h . " hrs ago");
        }

        if ($diff->i > 0) {
            return ($diff->i . " min ago");
        }

        if ($show_online) {
            return "Online";
        }

        return "Just Now";
    }

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


function getMarketplaceName(Int $marketplace_id): string
{
    global $conn;
    $qry = "SELECT * FROM marketplace_list WHERE id = '$marketplace_id' ";
    return mysqli_fetch_assoc(mysqli_query($conn, $qry))['display_name'];
}


function getVendorTypeInfo(Int $vendor_id = -1): array
{
    global $conn;
    $vendor_type = implode(",", getVendorType($vendor_id));

    $qry = "SELECT id, title, parent_type as group_type FROM vendor_type WHERE id IN ($vendor_type) ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    if (count($data) == 0) {
        return array();
    }
    return $data;
}


function getVendorGroupInfo(Int $vendor_id = -1): array
{
    global $conn;
    $vendor_types = getVendorType($vendor_id);
    $vendor_type = '';
    $flag = 0;
    foreach ($vendor_types as $vd) {
        if ($vd == '') {
            continue;
        }

        if ($flag == 0) {
            $vendor_type = " vt.id = '$vd' ";
        } else {
            $vendor_type .= " OR vt.id = '$vd' ";
        }

        $flag++;
    }

    $qry = "SELECT DISTINCT(pvt.title), pvt.id FROM parent_vendor_type pvt INNER JOIN vendor_type vt ON vt.parent_type = pvt.id WHERE $vendor_type ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    if (count($data) == 0) {
        return array();
    }
    return $data;
}


function getGroupTitle(Int $group_id): String
{
    global $conn;
    $qry = "SELECT title FROM parent_vendor_type WHERE id = '$group_id' ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_assoc($res);

    return $data['title'];
}


function getVendorType(Int $vendor_id = -1): array
{
    $vid = $vendor_id;
    if ($vid == -1) {
        $vid = getVendorID();
    }

    if ($vid == -1) {
        return array();
    }
    global $conn;
    $qry = "SELECT * FROM vendor WHERE id = '$vid' ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_assoc($res);

    return explode(",", $data['vendor_type']);
}


function checkGroupType(Int $group_type): bool
{
    global $conn;
    $vendor_types = getVendorType();
    $qry = "SELECT * FROM vendor_type WHERE parent_type = '$group_type' AND id IN ( '" . implode("','", $vendor_types) . "' ) ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_assoc($res);
    if (isset($data['id'])) {
        return true;
    }
    return false;
}


function checkVendorType(Int $vendor_type): bool
{
    $data = getVendorType();
    if (array_search($vendor_type, $data) !== false) {
        return true;
    }

    return false;
}


function findParentVendor(Int $vendor_type): bool
{
    global $conn;
    $qry = "SELECT * FROM vendor_type WHERE id = '$vendor_type' ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_assoc($res);
    if (!isset($data['id'])) {
        return -1;
    }

    return $data['parent_type'];
}


function getTableName(Int $marketplace_id): string
{
    global $conn;
    $qry = "SELECT * FROM marketplace_list WHERE id = '$marketplace_id' ";
    return mysqli_fetch_assoc(mysqli_query($conn, $qry))['table_name'];
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


function stringShortner($str, $desired_length = 15)
{
    if (strlen($str) > $desired_length) {
        return substr($str, 0, $desired_length) . "...";
    }

    return $str;
}


// ! PERMISSIONS
function accessToThisFile()
{
    return true;
    global $conn, $this_site_id, $curr_date;

    $path_var = $_SERVER['PHP_SELF'];
    $path_var = explode("/ideal_village", $path_var)[1];

    $path_var = explode(".", $path_var)[0];

    $qry = "SELECT * FROM file_list WHERE filepath = '" . $path_var . "' ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }

    $data = mysqli_fetch_assoc($res);

    $file_id = -1;
    if (isset($data['id'])) {
        $file_id = $data['id'];

        if (strtoupper($data['access_type']) == 'PUBLIC') {
            return true;
        } else if (strtoupper($data['access_type']) == 'PROTECTED') {
            $permission = '';
            $permission_type = strtoupper($data['type']);

            switch ($permission_type) {
                case "INSERT":
                case "VIEW":
                case "UPDATE":
                case "DELETE":
                case "MANAGER":
                    $permission = " AND permission_type = '$permission_type' ";
                    break;
                case 'OTHER':
                    if (getVendorID() == -1) {
                        return false;
                    }
                    return true;
                case 'HELPER':
                    if (getVendorID() == -1) {
                        return false;
                    }
                    return true;
                default:
                    errlog("accessToThisFile()", "Invalid permission in table file_list: " . $permission_type . "\nPermission can only be INSERT, VIEW, UPDATE, DELETE or MANAGER");
                    return false;
            }

            $vid = getVendorID();
            $marketplace_id = $data['marketplace_id'];

            $qry = "SELECT * FROM enabled_permissions WHERE marketplace_id = $marketplace_id AND site_id = '$this_site_id' AND (validity = -1 OR (created_date + INTERVAL `validity` day >= '$curr_date' ) ) AND vendor_id = '$vid' $permission ";
            $res = mysqli_query($conn, $qry);
            if (!$res) {
                errlog(mysqli_error($conn), $qry);
            }

            $data = mysqli_fetch_assoc($res);

            if (isset($data['id'])) {
                return true;
            }

            $qry = "SELECT * FROM enabled_permissions enp INNER JOIN additional_permission_list apl ON apl.id = enp.additional_permission_id WHERE enp.vendor_id = '$vid' AND enp.marketplace_id = $marketplace_id AND enp.site_id = '$this_site_id' AND (enp.validity = -1 OR (enp.created_date + INTERVAL enp.`validity` day >= '$curr_date' ) ) AND apl.page_id = '$file_id' AND apl.marketplace_id = $marketplace_id ";
            $res = mysqli_query($conn, $qry);
            if (!$res) {
                errlog(mysqli_error($conn), $qry);
            }

            $data = mysqli_fetch_assoc($res);

            if (isset($data['id'])) {
                return true;
            }

            return false;
        } else {
            if (isset($_SESSION['admin_id'])) {
                return true;
            }
            return false;
        }
    } else {
        die("File not registered");
    }
    return false;
}



if (!accessToThisFile()) {
    die("You do not have permission to access this file");
}


// *   given_for -> team id
// *   '*' means => should have at least 1 permission
// *   'ALL' means => should have all permissions
// *   << file_id >>  => File ID (Integer)
function havePermission(Int $marketplace_id, String $permission_type = "*, ALL, INSERT, VIEW, UPDATE, DELETE, MANAGER, <<file_id>>", Int $vendor_id = -1, Int $given_for = 0): bool
{
    if (isset($_SESSION["admin_id"])) {
        return true;
    }

    if ($vendor_id == -1) {
        $vendor_id = getVendorID();
    }

    global $conn, $this_site_id, $curr_date;

    // * Simple permissions check
    $qry = "SELECT * FROM enabled_permissions WHERE marketplace_id = '$marketplace_id' AND site_id = $this_site_id AND vendor_id = '$vendor_id' AND (validity = -1 OR created_date + INTERVAL validity day >= '$curr_date' ) ";

    if ($given_for > 0) {
        $qry .= " AND given_for = '$given_for' ";
    }

    $permission = ' AND permission_type = ';
    switch ($permission_type) {
        case 'INSERT':
            $permission .= " 'INSERT' ";
            break;
        case 'VIEW':
            $permission .= " 'VIEW' ";
            break;
        case 'UPDATE':
            $permission .= " 'UPDATE' ";
            break;
        case 'DELETE':
            $permission .= " 'DELETE' ";
            break;
        case 'MANAGER':
            $permission .= " 'MANAGER' ";
            break;
        case '*':
            $permission = " AND ( permission_type = 'INSERT' OR permission_type = 'VIEW' OR permission_type = 'DELETE' OR permission_type = 'UPDATE' OR permission_type = 'MANAGER' ) ";
            break;
        case 'ALL':
            $permission = " AND ( permission_type = 'INSERT' AND permission_type = 'VIEW' AND permission_type = 'DELETE' AND permission_type = 'UPDATE' AND permission_type = 'MANAGER' ) ";
            break;
        default:
            $pt = (int)($permission_type);
            if ($pt <= 0) {
                errlog("Invalid Permission:", $permission_type);
                return false;
            }

            $permission = " AND page_id = '$pt' ";
    }

    $qry .= $permission;
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }
    $data = mysqli_fetch_assoc($res);
    if (isset($data['id'])) {
        return true;
    }

    return false;
}


function listPermissions(Int $marketplace_id = 0, Int $given_for = 0)
{

    global $conn, $curr_date, $this_site_id;
    $vid = getVendorID();

    $qry = "SELECT * FROM enabled_permissions WHERE site_id = '$this_site_id' AND (validity = -1 OR (validity + 'created_date' >= '$curr_date' ) ) AND vendor_id = '$vid' ";

    if ($given_for > 0) {
        $qry .= " AND given_for = '$given_for' ";
    }
    if ($marketplace_id > 0) {
        $qry .= " AND marketplace_id = '$marketplace_id' ";
    }

    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }

    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $result = array();

    foreach ($data as $datum) {

        $enabled_permissions = array('INSERT' => false, 'VIEW' => false, 'DELETE' => false, 'UPDATE' => false, 'MANAGER' => false);

        // previous permission
        if (isset($result['OTHER'][$datum['given_for']][$datum['marketplace_id']])) {
            $enabled_permissions = $result['OTHER'][$datum['given_for']][$datum['marketplace_id']];
            $datum['given_by'] .= "," . $result['OTHER'][$datum['given_for']][$datum['marketplace_id']]['GIVEN_BY'];
            $datum['id'] .= "," . $result['OTHER'][$datum['given_for']][$datum['marketplace_id']]['PERMISSION_ID'];
        } else if (isset($result['SELF'][$datum['marketplace_id']])) {
            $enabled_permissions = $result['SELF'][$datum['marketplace_id']];
            $datum['given_by'] .= "," . $result['SELF'][$datum['marketplace_id']]['GIVEN_BY'];
            $datum['id'] .= "," . $result['SELF'][$datum['marketplace_id']]['PERMISSION_ID'];
        }

        // permission merge
        if ($datum['insert'] == 1) {
            $enabled_permissions['INSERT'] |= true;
        }
        if ($datum['view'] == 1) {
            $enabled_permissions['VIEW'] |= true;
        }
        if ($datum['update'] == 1) {
            $enabled_permissions['UPDATE'] |= true;
        }
        if ($datum['delete'] == 1) {
            $enabled_permissions['DELETE'] |= true;
        }
        if ($datum['manager'] == 1) {
            $enabled_permissions['MANAGER'] |= true;
        }

        // update result
        if ($datum['given_for'] > 0  &&  $datum['given_by'] > 0) {
            $result['OTHER'][$datum['given_for']][$datum['marketplace_id']] = $enabled_permissions;
            $result['OTHER'][$datum['given_for']][$datum['marketplace_id']]['GIVEN_BY'] = $datum['given_by'];
            $result['OTHER'][$datum['given_for']][$datum['marketplace_id']]['PERMISSION_ID'] = $datum['id'];
        } else {
            $result['SELF'][$datum['marketplace_id']] = $enabled_permissions;
            $result['SELF'][$datum['marketplace_id']]['GIVEN_BY'] = $datum['given_by'];
            $result['SELF'][$datum['marketplace_id']]['PERMISSION_ID'] = $datum['id'];
        }
    }

    return $result;
}


function addPermission(Int $marketplace_id, array $permissions, Int $validity, Int $order_id = -1, Int $given_to = -1, Int $team_id = -1): bool
{
    global $conn, $this_site_id, $curr_date;
    $vid = getVendorID();
    if ($vid == -1) {
        return false;
    }

    if ($given_to != -1) {
        $vid = $given_to;
        $given_to = getVendorID();
    }

    if ($order_id == -1) {
        $vid = getVendorID();
        $given_to = -2;
    }

    foreach ($permissions as $perm => $val) {

        switch (strtoupper($perm)) {
            case 'ADDITIONAL':
            case 'INSERT':
            case 'DELETE':
            case 'UPDATE':
            case 'MANAGER':
            case 'VIEW':
                break;
            default:
                errlog("Invalid Permission triggered in addPermission()", json_encode($perm));
                break;
        }

        if ($perm == 'ADDITIONAL') {
            $page_id = (int)(isset($perm['PAGE']) ? $perm['PAGE'] : 0);

            $qry = "INSERT INTO `enabled_permissions`(`site_id`, `vendor_id`, `marketplace_id`, `additional_permission_id`, `page_id`, `validity`, `given_by`, `given_for`, `order_id`, `created_date`) VALUES ($this_site_id, $vid, $marketplace_id, '" . realEscape($val) . "', '$page_id', '$validity', '$given_to', '$team_id', '$order_id', '$curr_date')";
        } else if ($val == 1) {
            $qry = "INSERT INTO `enabled_permissions`(`site_id`, `vendor_id`, `marketplace_id`, `permission_type`, `validity`, `given_by`, `given_for`, `order_id`, `created_date`) VALUES ($this_site_id, $vid, $marketplace_id, '" . realEscape($perm) . "', '$validity', '$given_to', '$team_id', '$order_id', '$curr_date')";
        }
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
            return false;
        }
    }

    return true;
}


// ! EXTRA

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


function randomKeyGenerator($length = 16)
{
    $encryptionKey = '';
    for ($i = 0; $i < $length; $i++) {
        $encryptionKey .= rand(0, 9);
    }

    return $encryptionKey;
}


function encryptor($str, $encryptionKey = DEFAULT_ENC_KEY, $payment = false)
{
    global $this_site_id;
    $key = '';
    if ($payment) {
        $key = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($payment)))));
    } else {
        $key = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($this_site_id)))));
    }

    $key .= 'shjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%gfdsgsrstrs%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&65555555zgfdsgfds555555555555555fdsafds55555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555gfsgfdsgydFDs555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%ccdgvfdgfsgfdsgfd%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suy';

    $cipher = "AES-128-CTR";

    $options = 0;

    return openssl_encrypt($str, $cipher, $key, $options, $encryptionKey);
}


function decryptor($str, $decryptionKey = DEFAULT_ENC_KEY, $payment = false)
{
    global $this_site_id;
    $key = '';
    if ($payment) {
        $key = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($payment)))));
    } else {
        $key = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($this_site_id)))));
    }
    $key .= 'shjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%gfdsgsrstrs%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&65555555zgfdsgfds555555555555555fdsafds55555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555gfsgfdsgydFDs555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%ccdgvfdgfsgfdsgfd%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suyshjf 83 878A56$%$%%$^%^iuyxsuab iusuafe 8waqq37t6y47vyewswuw7ate6%^%^%^&%&#& vroidIUHiuu*&$t$ urpdWUoauSAPI-WO-[EWIT09Q7483Q8EIT ^sR&udIOYW SIAHiud eyuayrie74t3wuyvreyfhr eu7tv7iavtV ^&VU&$R&@^#&@*&$yt878&$*&#&Fgfu shreka hfureaiufhikurvhakufrheiuahfurehufgejaku vrhabvfhdn jfdkjkldsvbfdnvfdbvfdagjroie ua8reeuit548iw2u487eywut6T^&^^#&@*$&^&#^&&$#8989y7t ev7 y&^T $yyt74 y874349t 79 98y87 T^#$*(*Y#(8yr 893yq874t crywo8 cq4y8wv y87rwq7c635t825719438t487857683268745*^*#&@&*$*&@^*(*((*y(*FHR8VBGYR8 Y89VYRE89WVYT48Y48Y8493FB 90EUT9EGREIHGIRDHKGVKJHFDKJVFKDZBVFDKJVBFZKVR IEYSTI436875643878736287v3687582746588978745878&*&$%@^*(Y(*#BYRFGSUYuUVUYf^R&^R&&^&^R67r$^%UFYfFr464rYvfuF65464^&78^v&TUgIU7byi87TBGIGUVjhVjyte556E#%54$%^&6555555555555555555555555555555&87(&988^8757%76%6^$R^$%%%%%%%%%%%%%%%%%%cyF iuvs fairy ayfyiue vfirgdjjfduys cdygsgva cdysjag dvyasfudysaufd suy';

    $cipher = "AES-128-CTR";

    $options = 0;

    return openssl_decrypt($str, $cipher, $key, $options, $decryptionKey);
}
