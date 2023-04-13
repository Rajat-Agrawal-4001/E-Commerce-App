<?php
session_start();
include 'config/connection.php';

$sql = "SELECT mp.id as pid,mp.*,v.*,v.id as vid,ad.id as admin from marketplace_products mp inner join product_variants v on mp.id=v.product_id inner join vendor vd on vd.id=mp.vendor_id LEFT JOIN admin ad ON ad.vendor_id = vd.id WHERE (mp.site_id = $this_site_id AND mp.status = 1 AND mp.verified = 1)";

if (isset($_POST['sub_cat']) && !empty($_POST['sub_cat'])) {
    $sql .= " AND mp.sub_cat_id IN ('" . $_POST['sub_cat'] . "')";
}
if (isset($_POST['category']) && !empty($_POST['category'])) {
    $sql .= " AND mp.cat_id IN ('" . realEscape($_POST['category']) . "')";
}
if (isset($_POST['keyword']) && $_POST['keyword'] != '') {
    $value = realEscape($_POST['keyword']);
    $sql .= " AND (mp.product_title like '%$value%' OR mp.cat_id like '%$value%' OR mp.description like '%$value%')";
}

if (isset($_POST['min_price']) && $_POST['min_price'] != '' && isset($_POST['max_price']) && $_POST['max_price'] != '') {
    $value1 = realEscape($_POST['min_price']);
    $value2 = realEscape($_POST['max_price']);
    $sql .= " AND v.price between $value1 and $value2";
}

if (isset($_POST['brand']) && !empty($_POST['brand'])) {
    $brand = realEscape($_POST['brand']);
    $sql .= " AND mp.brand_name='$brand'";
}
if (isset($_POST['color']) && !empty($_POST['color'])) {
    $color = realEscape($_POST['color']);
    $sql .= " AND v.color='$color'";
}
if (isset($_POST['loadMoreProds'])) {
    $items_on_page = $_SESSION['items'];

    foreach ($items_on_page as $key => $value) {
        $vid = $items_on_page[$key]['vid'];
        $sql .= " AND v.id <> $vid";
    }
} else {
    $_SESSION['items'] = array();
}

if (isset($_POST['price']) && !empty($_POST['price'])) {
    $value = realEscape($_POST['price']);
    if ($value == 'popular') {
        $sql .= " order by mp.views DESC";
    } else if ($value == 'low') {
        $sql .= " order by v.price ASC";
    } else if ($value == 'high') {
        $sql .= " order by v.price DESC";
    } else if ($value == 'latest') {
        $sql .= " order by v.created_date DESC";
    } else if ($value == 'old') {
        $sql .= " order by v.created_date ASC";
    }
}

$sql.=" limit 10";
  // echo $sql; exit;
$result = mysqli_query($conn, $sql);
if (!$result) {
    errlog(mysqli_error($conn), $sql);
}
if (mysqli_num_rows($result) > 0) {

   

    while ($row = mysqli_fetch_assoc($result)) {
        $pid = $row['pid'];
        $vid = $row['vid'];
        $arr = array(
            'vid' => $vid
        );
        array_push($_SESSION['items'], $arr);
        $sql = "select image_url from product_images where product_id=$pid and marketplace_id='5' and type='IMAGE' and variant_id=$vid";
        $result2 = mysqli_query($conn, $sql);
        if (!$result2) {
            errlog(mysqli_error($conn), $sql);
        }
        $row2 = mysqli_fetch_assoc($result2);
        $sql = "select discount_percent from discounts where product_id=$pid and marketplace_id='5'";
        $result3 = mysqli_query($conn, $sql);
        if (!$result3) {
            errlog(mysqli_error($conn), $sql);
        }
        $row3 = mysqli_fetch_assoc($result3);
?>

        <div class="col-xl-4 col-md-4 col-sm-6">
            <div class="product-item product-item2 element-item1 sidebar-left">
                <a href="product-details.php?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-image">
                    <img src="<?= htmlspecialchars($row2['image_url']); ?>" alt="product-image" style="max-height:18rem;">
                </a>
                <div class="bottom-content">
                    <a href="product-details.php?id=<?= urlencode(base64_encode($pid)) ?>&vid=<?= urlencode(base64_encode($vid)) ?>" class="product-name"><?= htmlspecialchars($row['product_title']); ?></a>
                    <div class="action-wrap">
                        <span class="product-price">Rs. <?= htmlspecialchars($row['price']); ?>.00</span>
                        <a href="javascript:void(0)" data-vid="<?= $vid ?>" onclick="addCart(this)" value="<?= $pid ?>" class="addto-cart"><i class="fal fa-shopping-cart"></i> Add To
                            Cart</a>

                    </div>
                </div>
                <div class="product-features">
                    <div class="new-tag product-tag">NEW</div><?php
                                                                if (isset($row3['discount_percent']) && $row3['discount_percent'] != 0) {
                                                                ?>

                        <div class="discount-tag product-tag"><?php
                                                                    echo htmlspecialchars($row3['discount_percent']);  ?>%</div>
                    <?php
                                                                } ?>
                </div>
                <div class="product-actions">
                    <a href="javascript:void(0)" data-variant="<?= $vid ?>" onclick="addWishlist(this)" value="<?= $pid ?>" class="product-action"><i class="fal fa-heart"></i></a>
                    <button class="product-action" value="<?= $i ?>" onclick="fun1(this)"><i class="fal fa-eye"></i></button>
                </div>
            </div>
        </div>
    <?php }
} else { ?>
<?php } ?>