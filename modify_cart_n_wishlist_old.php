<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($conn)) {
    include "config/connection.php";
}

function modify_cart_n_wishlist($marketplace_id, $item_id, $save_type, $remove_if_exists = false, $variant_id = '', $decrease_quantity = false)
{
    global $conn, $curr_date, $this_site_id;

    if (isset($_SESSION['vendor_id'])  ||  isset($_SESSION['user_id'])) {
        $wishId = realEscape($item_id);
        if (isset($_SESSION['vendor_id'])) {
            $vid = $_SESSION['vendor_id'];
        } else if (isset($_SESSION['user_id'])) {
            $vid = $_SESSION['user_id'];
        }

        $qry = "SELECT count(*) from cart_n_wishlist where site_id = $this_site_id AND save_status = '1' AND marketplace_id = '$marketplace_id' AND item_id = '$wishId' AND vendor_id = '$vid' and save_type = '$save_type' ";

        if ($variant_id != '') {
            $qry .= " AND variant_id = '$variant_id' ";
        }

        $res = '';
        if (!$res = mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
            return false;
        }
        $wishes = mysqli_fetch_assoc($res);


        if ($wishes['count(*)'] != '0') {

            //  remove from wishlist 
            if ($remove_if_exists) {
                $qry = "UPDATE cart_n_wishlist set save_status = '0', quantity = '0' where marketplace_id = '$marketplace_id' AND item_id = '$wishId' AND site_id = $this_site_id AND vendor_id = '$vid'  and save_type = '$save_type' ";
                if ($variant_id != '') {
                    $qry .= " AND variant_id = '$variant_id' ";
                }

                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                    return false;
                }
            } else if ($decrease_quantity) {
                $qry = "SELECT * from cart_n_wishlist where save_status = '1' AND marketplace_id = '$marketplace_id' AND item_id = '$wishId' AND vendor_id = '$vid' and site_id = $this_site_id AND save_type = '$save_type' ";
                if ($variant_id != '') {
                    $qry .= " AND variant_id = '$variant_id' ";
                }

                $res = '';
                if (!$res = mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                    return false;
                }
                $wishes = mysqli_fetch_assoc($res);
                if ($wishes['quantity'] > 1) {
                    $qry = "UPDATE cart_n_wishlist set quantity = quantity-1 where marketplace_id = '$marketplace_id' AND item_id = '$wishId' AND vendor_id = '$vid' AND site_id = $this_site_id AND save_type = '$save_type' ";
                    if ($variant_id != '') {
                        $qry .= " AND variant_id = '$variant_id' ";
                    }

                    if (!mysqli_query($conn, $qry)) {
                        errlog(mysqli_error($conn), $qry);
                        return false;
                    }
                }
            } else if (strtoupper($save_type) == 'CART') {
                $qry = "UPDATE cart_n_wishlist set save_status = '1', quantity = quantity+1 where marketplace_id = '$marketplace_id' AND item_id = '$wishId' AND site_id = $this_site_id AND vendor_id = '$vid'  and save_type = '$save_type' ";
                if ($variant_id != '') {
                    $qry .= " AND variant_id = '$variant_id' ";
                }

                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                    return false;
                }
                return 'increamented';
            }
            return true;
        } else {
            // searching in wishlist  // adding new product
            $qry = "SELECT count(*) from cart_n_wishlist where marketplace_id = '$marketplace_id' AND save_status = '0' AND item_id = '$wishId' AND vendor_id = '$vid'  and site_id = $this_site_id AND save_type = '$save_type' ";
            if ($variant_id != '') {
                $qry .= " AND variant_id = '$variant_id' ";
            }
            $res = '';
            if (!$res = mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
                return false;
            }
            $res = mysqli_fetch_assoc($res);
            if ($res  &&  $res['count(*)'] != 0) {
                // updating previous entry
                $qry = "UPDATE cart_n_wishlist set save_status = '1', quantity = '1' where marketplace_id = '$marketplace_id' AND item_id = '$wishId' AND vendor_id = '$vid'  and site_id = $this_site_id AND save_type = '$save_type' ";
                if ($variant_id != '') {
                    $qry .= " AND variant_id = '$variant_id' ";
                }
                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                    return false;
                } else {
                    return true;
                }
            } else {
                // creating new entry 
                $qry = "INSERT INTO cart_n_wishlist (site_id, vendor_id, save_type, marketplace_id, item_id, save_status, quantity, created_date, variant_id) VALUES ('$this_site_id', '$vid', '$save_type', '$marketplace_id', '$wishId', '1', '1', '$curr_date', '$variant_id' ) ";
                if (!mysqli_query($conn, $qry)) {
                    errlog(mysqli_error($conn), $qry);
                    return false;
                } else {
                    return true;
                }
            }
        }
    } else {
        $wishId = realEscape($item_id);
        $marketplace_id = (realEscape($marketplace_id));

        if (strtoupper($save_type) == 'WISHLIST') {
            if (isset($_SESSION['guestWishlist'])) {
                $prods = $_SESSION['guestWishlist'][$marketplace_id];
                $data = $_SESSION['guestWishlist'];

                if ($marketplace_id == '5'  ||  $marketplace_id == '6') {

                    if (isset($data[$marketplace_id][$wishId])) {  // product in
                        if (array_search($variant_id, explode(',', $data[$marketplace_id][$wishId])) !== false) {  // variant in
                            if ($remove_if_exists) {
                                $new_variant = '';
                                foreach (explode(',', $data[$marketplace_id][$wishId]) as $var) {
                                    if ($var == ''  ||  $var == $variant_id)   continue;
                                    $new_variant = $var . ',';
                                }
                                $data[$marketplace_id][$wishId] = $new_variant;
                            }
                        } else { // variant out
                            $data[$marketplace_id][$wishId] = $data[$marketplace_id][$wishId] . ',' . $variant_id;
                        }
                    } else {  // product out
                        $data[$marketplace_id][$wishId] = $variant_id;
                    }

                    $_SESSION['guestWishlist'] = $data;
                    setcookie('guestWishlist', serialize($data), time() + 86400 * 28, '/');
                    return true;




                    //
                } else if (array_search($wishId, $prods) !== false) {
                    $prods = explode(',', $prods);
                    $new_wish = "";
                    if ($remove_if_exists) {
                        foreach ($prods as $prod) {
                            if ($prod == '') {
                                continue;
                            }
                            if ($prod == $wishId) {
                                continue;
                            }

                            $new_wish .= "," . $prod;
                        }
                    } else {
                        $new_wish = $_SESSION['guestWishlist'][$marketplace_id];
                    }
                } else {
                    $new_wish = $_SESSION['guestWishlist'][$marketplace_id] . "," . $wishId;
                }
                $_SESSION['guestWishlist'][$marketplace_id] = $new_wish;
                setcookie('guestWishlist', serialize($_SESSION['guestWishlist']), time() + 86400 * 28, '/');
            } else {
                $marketplace_id = strtolower($marketplace_id);
                $data = array();
                if (isset($_COOKIE['guestWishlist'])) {
                    $data = unserialize($_COOKIE['guestWishlist']);
                }

                if (!isset($data[$marketplace_id])) {
                    $data[$marketplace_id] = '';

                    if ($marketplace_id == '5'  ||  $marketplace_id == '6') {
                        $data[$marketplace_id] = array();
                    }
                }

                if ($marketplace_id == '5'  ||  $marketplace_id == '6') {

                    if (isset($data[$marketplace_id][$wishId])) {  // product in
                        if (array_search($variant_id, explode(',', $data[$marketplace_id][$wishId])) !== false) {  // variant in
                            if ($remove_if_exists) {
                                $new_variant = '';
                                foreach (explode(',', $data[$marketplace_id][$wishId]) as $var) {
                                    if ($var == ''  ||  $var == $variant_id)   continue;
                                    $new_variant = $var . ',';
                                }
                                $data[$marketplace_id][$wishId] = $new_variant;
                            }
                        } else { // variant out
                            $data[$marketplace_id][$wishId] = $data[$marketplace_id][$wishId] . ',' . $variant_id;
                        }
                    } else {  // product out
                        $data[$marketplace_id][$wishId] = $variant_id;
                    }

                    $_SESSION['guestWishlist'] = $data;
                    setcookie('guestWishlist', serialize($data), time() + 86400 * 28, '/');
                    return true;
                } else if (array_search($wishId, explode(',', $data[$marketplace_id])) !== false) {
                    $new_wish = "";
                    if ($remove_if_exists) {
                        foreach (explode(',', $data[$marketplace_id]) as $item) {
                            if ($item == '')   continue;
                            if ($item == $wishId)   continue;
                            if ($new_wish == '') {
                                $new_wish = $item;
                            } else {
                                $new_wish .= ',' . $item;
                            }
                        }
                    } else {
                        $new_wish = $data[$marketplace_id];
                    }

                    $data[$marketplace_id] = $new_wish;
                    $_SESSION['guestWishlist'] = $data;
                    setcookie('guestWishlist', serialize($data), time() + 86400 * 28, '/');
                    return true;
                } else {
                    $new_wish = $data[$marketplace_id] . ',' . $item_id;
                    $data[$marketplace_id] = $new_wish;
                    $_SESSION['guestWishlist'] = $data;
                    setcookie('guestWishlist', serialize($data), time() + 86400 * 28, '/');
                    return true;
                }
            }
        } else if (strtoupper($save_type) == 'CART') {

            if ($decrease_quantity) {
                $data = unserialize($_COOKIE['guestCart']);
                $quantity = unserialize($_COOKIE['guestCartQuantity']);

                if ($marketplace_id == 5) {
                    if ($quantity[$marketplace_id][$wishId][$variant_id] > 1) {
                        $quantity[$marketplace_id][$wishId][$variant_id] = $quantity[$marketplace_id][$wishId][$variant_id] - 1;
                    }
                } else {
                    if ($quantity[$marketplace_id][$wishId] > 1) {
                        $quantity[$marketplace_id][$wishId] = $quantity[$marketplace_id][$wishId] - 1;
                    }
                }

                $_SESSION['guestCart'] = $data;
                $_SESSION['guestCartQuantity'] = $quantity;

                setcookie('guestCartQuantity', serialize($quantity), time() + 86400 * 28, '/');
                setcookie('guestCart', serialize($data), time() + 86400 * 28, '/');
                return true;
            }

            if (true) {
                $marketplace_id = strtolower($marketplace_id);
                $data = array();
                $quantity = array();

                if (isset($_COOKIE['guestCart'])) {
                    $data = unserialize($_COOKIE['guestCart']);
                    $quantity = unserialize($_COOKIE['guestCartQuantity']);
                }

                if (!isset($data[$marketplace_id])) {
                    $data[$marketplace_id] = '';
                    $quantity[$marketplace_id] = '';

                    if ($marketplace_id == '5'  ||  $marketplace_id == '6') {
                        $data[$marketplace_id] = array();
                        $quantity[$marketplace_id] = array();
                    }
                }

                if ($marketplace_id == '5'  ||  $marketplace_id == '6') {

                    if (isset($data[$marketplace_id][$wishId])) {  // product in
                        if (array_search($variant_id, explode(',', $data[$marketplace_id][$wishId])) !== false) {  // variant in
                            if ($remove_if_exists) {
                                $new_variant = '';
                                foreach (explode(',', $data[$marketplace_id][$wishId]) as $var) {
                                    if ($var == ''  ||  $var == $variant_id)   continue;
                                    $new_variant = $var . ',';
                                }
                                $quantity[$marketplace_id][$wishId][$variant_id] = 0;
                                $data[$marketplace_id][$wishId] = $new_variant;
                            } else {
                                $quantity[$marketplace_id][$wishId][$variant_id] = $quantity[$marketplace_id][$wishId][$variant_id] + 1;

                                $_SESSION['guestCart'] = $data;
                                $_SESSION['guestCartQuantity'] = $quantity;

                                setcookie('guestCartQuantity', serialize($quantity), time() + 86400 * 28, '/');
                                setcookie('guestCart', serialize($data), time() + 86400 * 28, '/');
                                return 'increamented';
                            }
                        } else { // variant out
                            $data[$marketplace_id][$wishId] = $data[$marketplace_id][$wishId] . ',' . $variant_id;
                            $quantity[$marketplace_id][$wishId][$variant_id] = 1;
                        }
                    } else {  // product out
                        $data[$marketplace_id][$wishId] = $variant_id;
                        $quantity[$marketplace_id][$wishId][$variant_id] = 1;
                    }

                    $_SESSION['guestCart'] = $data;
                    $_SESSION['guestCartQuantity'] = $quantity;
                    setcookie('guestCartQuantity', serialize($quantity), time() + 86400 * 28, '/');
                    setcookie('guestCart', serialize($data), time() + 86400 * 28, '/');
                    return true;
                } else if (isset($_COOKIE['guestCart'])) {
                    $data = unserialize($_COOKIE['guestCart']);
                    $quantity = unserialize($_COOKIE['guestCartQuantity']);
                }
                if (array_search($wishId, explode(',', $data[$marketplace_id])) !== false) {
                    $new_wish = "";
                    $flag = '';
                    if ($remove_if_exists) {
                        foreach (explode(',', $data[$marketplace_id]) as $item) {
                            if ($item == '')   continue;
                            if ($item == $wishId)   continue;
                            if ($new_wish == '') {
                                $new_wish = $item;
                            } else {
                                $new_wish .= ',' . $item;
                            }
                        }
                        $flag = 'rem';
                        $quantity[$marketplace_id][$wishId] = 0;
                    } else {
                        $new_wish = $data[$marketplace_id];
                        $flag = 'inc';
                        $quantity[$marketplace_id][$wishId] = ((int) ($quantity[$marketplace_id][$wishId])) + 1;
                    }

                    $data[$marketplace_id] = $new_wish;
                    $_SESSION['guestCart'] = $data;
                    setcookie('guestCartQuantity', serialize($quantity), time() + 86400 * 28, '/');
                    setcookie('guestCart', serialize($data), time() + 86400 * 28, '/');
                    if ($flag == 'inc') {
                        return 'increamented';
                    }
                    return true;
                } else {
                    $new_wish = $data[$marketplace_id] . ',' . $item_id;
                    $data[$marketplace_id] = $new_wish;
                    $_SESSION['guestCart'] = $data;
                    $quantity[$marketplace_id][$wishId] = 1;
                    setcookie('guestCartQuantity', serialize($quantity), time() + 86400 * 28, '/');
                    setcookie('guestCart', serialize($data), time() + 86400 * 28, '/');
                    return true;
                }
            }
        }
        return true;
    }
}
