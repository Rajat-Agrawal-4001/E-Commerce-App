<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['PRINTED_ADS'])) {
    $_SESSION['PRINTED_ADS'] = array();
}

if (!isset($conn)) {
    require_once "connection.php";
}


// <div style="border: 1px solid black; padding: 1rem;" data-enable-ad="true" data-ad-type="popup"></div>


function getAd($position, Bool $refresh = false)
{
    global $conn, $curr_date, $this_site_id;

    $qry = "SELECT vendor_id FROM admin WHERE site_id = $this_site_id ";
    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }

    $data = mysqli_fetch_assoc($res);

    if (!isset($data['vendor_id'])) {
        die("Invalid Site");
    }
    $admin_id = $data['vendor_id'];

    $position = realEscape($position);
    $qry = "SELECT * FROM selected_ads WHERE site_id = $this_site_id AND vendor_id = '" . $admin_id . "' AND position = '$position' AND (validity = -1 OR created_date + INTERVAL `validity` day >= '$curr_date' ) ";
    if ($refresh === true) {
        if (isset($_SESSION['PRINTED_ADS'][$position])) {
            foreach ($_SESSION['PRINTED_ADS'][$position] as $id => $extra) {
                $qry .= " AND id <> $id ";
            }
        }
    }

    $res = mysqli_query($conn, $qry);
    if (!$res) {
        errlog(mysqli_error($conn), $qry);
    }

    $data = mysqli_fetch_assoc($res);
    if (!isset($data['id'])  &&  $refresh === true) {
        $qry = "SELECT * FROM selected_ads WHERE site_id = $this_site_id AND vendor_id = '" . $admin_id . "' AND position = '$position' AND (validity = -1 OR created_date + INTERVAL `validity` day >= '$curr_date' ) ";
        $res = mysqli_query($conn, $qry);
        if (!$res) {
            errlog(mysqli_error($conn), $qry);
        }

        $_SESSION['PRINTED_ADS'][$position] = array();

        $data = mysqli_fetch_assoc($res);
        if (isset($data['id'])) {
            $_SESSION['PRINTED_ADS'][$position][$data['id']] = true;
        }
        return $data;
    }

    if (isset($data['id'])) {
        $_SESSION['PRINTED_ADS'][$position][$data['id']] = true;
    }
    return $data;
}


if (isset($_POST['increaseView'])) {
    $id = (int)($_POST['increaseView']);

    $total_amount = 0;

    $sql = "SELECT ad_id,views from selected_ads where site_id = $this_site_id and id='$id'";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        errlog(mysqli_error($conn), $sql);
    }
    $row = mysqli_fetch_assoc($res);
    if (isset($row['ad_id'])) {

        $ad_id = realEscape($row['ad_id']);
        $views = (int)(realEscape($row['views']));
        $views = $views + 1;
        $sql = "SELECT * FROM ad_earning WHERE site_id=$this_site_id and earning_scale='views' and ad_id='$ad_id'";
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            errlog(mysqli_error($conn), $sql);
        }
        $r = mysqli_fetch_assoc($res);
        if (isset($r['id'])) {

            $amount = (int)(realEscape($r['performance_amount']));
            $count = (int)(realEscape($r['count']));

            // per views price 
            $per_view = intdiv($amount, $count);

            $total_amount = $views * $per_view;

            $qry = "UPDATE selected_ads SET views = views+1,views_earning=$total_amount WHERE id = '$id' AND site_id = $this_site_id ";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }
            die;
        } else {
            $qry = "UPDATE selected_ads SET views = views+1 WHERE id = '$id' AND site_id = $this_site_id ";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }
            die;
        }
    } else {
        $qry = "UPDATE selected_ads SET views = views+1 WHERE id = '$id' AND site_id = $this_site_id ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }
    }

    die;
}

if (isset($_POST['increaseClick'])) {
    $id = (int)($_POST['increaseClick']);

    $total_amount = 0;

    $sql = "SELECT ad_id,click from selected_ads where site_id = $this_site_id and id='$id'";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        errlog(mysqli_error($conn), $sql);
    }
    $row = mysqli_fetch_assoc($res);
    if (isset($row['ad_id'])) {

        $ad_id = realEscape($row['ad_id']);
        $click = (int)(realEscape($row['click']));
        $click = $click + 1;
        $sql = "SELECT * FROM ad_earning WHERE site_id=$this_site_id and earning_scale='clicks' and ad_id='$ad_id'";
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            errlog(mysqli_error($conn), $sql);
        }
        $r = mysqli_fetch_assoc($res);
        if (isset($r['id'])) {

            $amount = (int)(realEscape($r['performance_amount']));
            $count = (int)(realEscape($r['count']));

            // per click price 
            $per_click = intdiv($amount, $count);

            $total_amount = $click * $per_click;

            $qry = "UPDATE selected_ads SET click = click+1,click_earning=$total_amount WHERE id = '$id' AND site_id = $this_site_id ";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }
            die;
        } else {
            $qry = "UPDATE selected_ads SET click = click+1 WHERE id = '$id' AND site_id = $this_site_id ";
            if (!mysqli_query($conn, $qry)) {
                errlog(mysqli_error($conn), $qry);
            }
            die;
        }
    } else {
        $qry = "UPDATE selected_ads SET click = click+1 WHERE id = '$id' AND site_id = $this_site_id ";
        if (!mysqli_query($conn, $qry)) {
            errlog(mysqli_error($conn), $qry);
        }
    }

    die;
}


if (isset($_POST['find_ad'])) {

    $css = '';
    $script = '';
    $data = '';

    $is_refresh = (isset($_POST['refresh'])) ? true : false;

    switch (strtolower($_POST['find_ad'])) {
        case 'popup':
            $css = '
            <style>
                .custom-modal-background {
                    background-color: rgba(0, 0, 0, 0.5);
                    height: 100%;
                    display: flex;
                    z-index: 9999999999;
                    position: absolute;
                    width: 100%;
                    flex-direction: column;
                    text-align: center;
                    justify-content: center;
                    top: 0;
                    left: 0;
                    bottom: 0;
                    right: 0;
                }
        
                .custom-modal-disable-body {
                    z-index: 99999999999;
                    margin: 0;
                    display: flex;
                    opacity: 0;
                    position: absolute;
                    height: 0%;
                    width: 100%;
                    flex-direction: column;
                    text-align: center;
                    justify-content: center;
                    animation-name: customModalAnimationTag;
                    animation-duration: 1s;
                    animation-fill-mode: forwards;
                }

                
                @keyframes customModalAnimationTag {
                    from {
                        opacity: 0;
                        height: 0%;
                    } to {
                        opacity: 1;
                        height: 100%;
                    }
                }

                .custom-close-modal-btn {
                    background-color: rgb(250, 250, 250);
                    padding: 0.2rem 0.3rem;
                    margin: -0.3rem 0.6rem;
                    border: none;
                    width: fit-content;
                    z-index: 999999999999;
                    position: absolute;
                    top: 1rem;
                    right: 0.5rem;
                }

                .custom-close-modal-btn:hover {
                    background-color: rgb(190, 7, 7);
                    color: white;
                }

                .custom-ads-modal-body{
                    display: none;
                }
                
                .custom-ads-modal-body > div > a {
                    width: 100% !important;
                    height: 100% !important;
                }

            </style>
            ';

            $ad = getAd("popup", $is_refresh);
            if (isset($ad['id'])) {
                $random_ad_id = "ad_id_" . $ad['id'] . time() . rand(9999, 9999999999);
                $data = '
                    <div class="custom-ads-modal-body" id="' . $random_ad_id . '">
                        <div class="" id="ad_body' . $random_ad_id . '">
                            <button class="custom-close-modal-btn" data-custom-dismiss="ad">Close &#10006;</button>
                            <a id="click_trigger' . $random_ad_id . '" href="' . $ad['url'] . '" style="height: 100%;width: 100%;" >
                                <img src="' . $ad['banner'] . '" alt="Ad Banner" style="max-height: 100%;max-width: 100%;">
                            </a>
                        </div>
                    </div>
                    ';

                $script = '
                    <script>
                        setTimeout(function() {
                            $("#' . $random_ad_id . '").removeClass("custom-ads-modal-body").addClass("custom-modal-background");
                            $("#ad_body' . $random_ad_id . '").addClass("custom-modal-disable-body");
                            $("body").css("overflow", "hidden");
                            $.ajax({
                                url: "' . $this_site_url . '/config/ad_finder",
                                method: "POST",
                                data:{
                                    increaseView: ' . $ad['id'] . ',
                                }
                            });
                        }, 3000);

                        $(document).on("click","#click_trigger' . $random_ad_id . '", function(){
                            $.ajax({
                                url: "' . $this_site_url . '/config/ad_finder",
                                method: "POST",
                                data:{
                                    increaseClick: ' . $ad['id'] . ',
                                }
                            });
                        })
                    </script>

                    ';
            }
            break;

        case 'header':
            $css = '
                <style>
                    .custom-modal-background {
                        background-color: rgba(0, 0, 0, 0.5);
                        height: 100%;
                        display: flex;
                        z-index: 9999999999;
                        position: absolute;
                        width: 100%;
                        flex-direction: column;
                        text-align: center;
                        justify-content: center;
                        top: 0;
                        left: 0;
                        bottom: 0;
                        right: 0;
                    }
            
                    .custom-modal-disable-body {
                        z-index: 99999999999;
                        margin: 0;
                        display: flex;
                        opacity: 0;
                        position: absolute;
                        height: 0%;
                        width: 100%;
                        flex-direction: column;
                        text-align: center;
                        justify-content: center;
                        animation-name: customModalAnimationTag;
                        animation-duration: 1s;
                        animation-fill-mode: forwards;
                    }
    
                    
                    @keyframes customModalAnimationTag {
                        from {
                            opacity: 0;
                            height: 0%;
                        } to {
                            opacity: 1;
                            height: 100%;
                        }
                    }
    
                    .custom-close-modal-btn {
                        background-color: rgb(250, 250, 250);
                        padding: 0.2rem 0.3rem;
                        margin: -0.3rem 0.6rem;
                        border: none;
                        width: fit-content;
                        z-index: 999999999999;
                        position: absolute;
                        top: 1rem;
                        right: 0.5rem;
                    }
    
                    .custom-close-modal-btn:hover {
                        background-color: rgb(190, 7, 7);
                        color: white;
                    }
    
                    .custom-ads-modal-body{
                        display: none;
                    }
                    
                    .custom-ads-modal-body > div > a {
                        width: 100% !important;
                        height: 100% !important;
                    }
    
                </style>
                ';

            $ad = getAd("header", $is_refresh);
            if (isset($ad['id'])) {
                $random_ad_id = "ad_id_" . $ad['id'] . time() . rand(9999, 9999999999);
                $data = '
                                <a id="click_trigger' . $random_ad_id . '" href="' . $ad['url'] . '" style="height: 100%;width: 100%;" >
                                    <img src="' . $ad['banner'] . '" alt="Ad Banner" style="max-height: 100%;max-width: 100%;">
                                </a>
                          
                        ';

                $script = '
                <script>
                    setTimeout(function() {
                      
                        $.ajax({
                            url: "' . $this_site_url . '/config/ad_finder",
                            method: "POST",
                            data:{
                                increaseView: ' . $ad['id'] . ',
                            }
                        });
                    }, 3000);

                    $(document).on("click","#click_trigger' . $random_ad_id . '", function(){
                        $.ajax({
                            url: "' . $this_site_url . '/config/ad_finder",
                            method: "POST",
                            data:{
                                increaseClick: ' . $ad['id'] . ',
                            }
                        });
                    })
                </script>

                ';
            }
            break;

        case 'sidebar':
            $css = '
                    <style>
                        .custom-modal-background {
                            background-color: rgba(0, 0, 0, 0.5);
                            height: 100%;
                            display: flex;
                            z-index: 9999999999;
                            position: absolute;
                            width: 100%;
                            flex-direction: column;
                            text-align: center;
                            justify-content: center;
                            top: 0;
                            left: 0;
                            bottom: 0;
                            right: 0;
                        }
                
                        .custom-modal-disable-body {
                            z-index: 99999999999;
                            margin: 0;
                            display: flex;
                            opacity: 0;
                            position: absolute;
                            height: 0%;
                            width: 100%;
                            flex-direction: column;
                            text-align: center;
                            justify-content: center;
                            animation-name: customModalAnimationTag;
                            animation-duration: 1s;
                            animation-fill-mode: forwards;
                        }
        
                        
                        @keyframes customModalAnimationTag {
                            from {
                                opacity: 0;
                                height: 0%;
                            } to {
                                opacity: 1;
                                height: 100%;
                            }
                        }
        
                        .custom-close-modal-btn {
                            background-color: rgb(250, 250, 250);
                            padding: 0.2rem 0.3rem;
                            margin: -0.3rem 0.6rem;
                            border: none;
                            width: fit-content;
                            z-index: 999999999999;
                            position: absolute;
                            top: 1rem;
                            right: 0.5rem;
                        }
        
                        .custom-close-modal-btn:hover {
                            background-color: rgb(190, 7, 7);
                            color: white;
                        }
        
                        .custom-ads-modal-body{
                            display: none;
                        }
                        
                        .custom-ads-modal-body > div > a {
                            width: 100% !important;
                            height: 100% !important;
                        }
        
                    </style>
                    ';

            $ad = getAd("sidebar", $is_refresh);
            if (isset($ad['id'])) {
                $random_ad_id = "ad_id_" . $ad['id'] . time() . rand(9999, 9999999999);
                $data = '
                                    <a id="click_trigger' . $random_ad_id . '" href="' . $ad['url'] . '" style="height: 100%;width: 100%;" >
                                        <img src="' . $ad['banner'] . '" alt="Ad Banner" style="max-height: 100%;max-width: 100%;">
                                    </a>
                              
                            ';
                $script = '
                            <script>
                                setTimeout(function() {
                                  
                                    $.ajax({
                                        url: "' . $this_site_url . '/config/ad_finder",
                                        method: "POST",
                                        data:{
                                            increaseView: ' . $ad['id'] . ',
                                        }
                                    });
                                }, 3000);
            
                                $(document).on("click","#click_trigger' . $random_ad_id . '", function(){
                                    $.ajax({
                                        url: "' . $this_site_url . '/config/ad_finder",
                                        method: "POST",
                                        data:{
                                            increaseClick: ' . $ad['id'] . ',
                                        }
                                    });
                                })
                            </script>
            
                            ';
            }
            break;

        case 'footer':
            $css = '
                    <style>
                        .custom-modal-background {
                            background-color: rgba(0, 0, 0, 0.5);
                            height: 100%;
                            display: flex;
                            z-index: 9999999999;
                            position: absolute;
                            width: 100%;
                            flex-direction: column;
                            text-align: center;
                            justify-content: center;
                            top: 0;
                            left: 0;
                            bottom: 0;
                            right: 0;
                        }
                
                        .custom-modal-disable-body {
                            z-index: 99999999999;
                            margin: 0;
                            display: flex;
                            opacity: 0;
                            position: absolute;
                            height: 0%;
                            width: 100%;
                            flex-direction: column;
                            text-align: center;
                            justify-content: center;
                            animation-name: customModalAnimationTag;
                            animation-duration: 1s;
                            animation-fill-mode: forwards;
                        }
        
                        
                        @keyframes customModalAnimationTag {
                            from {
                                opacity: 0;
                                height: 0%;
                            } to {
                                opacity: 1;
                                height: 100%;
                            }
                        }
        
                        .custom-close-modal-btn {
                            background-color: rgb(250, 250, 250);
                            padding: 0.2rem 0.3rem;
                            margin: -0.3rem 0.6rem;
                            border: none;
                            width: fit-content;
                            z-index: 999999999999;
                            position: absolute;
                            top: 1rem;
                            right: 0.5rem;
                        }
        
                        .custom-close-modal-btn:hover {
                            background-color: rgb(190, 7, 7);
                            color: white;
                        }
        
                        .custom-ads-modal-body{
                            display: none;
                        }
                        
                        .custom-ads-modal-body > div > a {
                            width: 100% !important;
                            height: 100% !important;
                        }
        
                    </style>
                    ';

            $ad = getAd("footer", $is_refresh);
            if (isset($ad['id'])) {
                $random_ad_id = "ad_id_" . $ad['id'] . time() . rand(9999, 9999999999);
                $data = '
                        <a id="click_trigger' . $random_ad_id . '" href="' . $ad['url'] . '" style="height: 100%;width: 100%;" >
                            <img src="' . $ad['banner'] . '" alt="Ad Banner" style="max-height: 100%;max-width: 100%;">
                        </a>
                  
                ';
                $script = '
                <script>
                    setTimeout(function() {
                      
                        $.ajax({
                            url: "' . $this_site_url . '/config/ad_finder",
                            method: "POST",
                            data:{
                                increaseView: ' . $ad['id'] . ',
                            }
                        });
                    }, 3000);

                    $(document).on("click","#click_trigger' . $random_ad_id . '", function(){
                        $.ajax({
                            url: "' . $this_site_url . '/config/ad_finder",
                            method: "POST",
                            data:{
                                increaseClick: ' . $ad['id'] . ',
                            }
                        });
                    })
                </script>

                ';
            }
            break;
    }

    die(json_encode(["css" => $css, "script" => $script, "data" => $data]));
}



?>

<script>
    $(document).ready(function() {
        setInterval(function() {
            $("[data-enable-ad='true']").each(function() {
                let th = $(this);
                let type = th.data("ad-type");
                $.ajax({
                    url: "<?php echo $this_site_url ?>/config/ad_finder",
                    method: "POST",
                    data: {
                        find_ad: type,
                        refresh: true,
                    },
                    success: function(data) {
                        // console.log(data);
                        let ad = $.parseJSON(data);
                        th.html(ad.data);
                        $("body").append(ad.script);
                        $("head").append(ad.css);
                    }
                })
            })
        }, 180000);

        $(document).on("click", "[data-custom-dismiss='ad']", function() {
            $(this).parent().parent().remove();
            $("body").css("overflow", "auto");
        });

        $("[data-enable-ad='true']").each(function() {
            let th = $(this);
            let type = th.data("ad-type");
            $.ajax({
                url: "<?php echo $this_site_url ?>/config/ad_finder",
                method: "POST",
                data: {
                    find_ad: type
                },
                success: function(data) {
                    // console.log(data);
                    let ad = $.parseJSON(data);
                    th.html(ad.data);
                    $("body").append(ad.script);
                    $("head").append(ad.css);
                }
            })
        })
    })
</script>