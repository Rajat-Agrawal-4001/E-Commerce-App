<?php
require_once "cloudinaryConfig.php";
$logo_font = "../assets/fonts/auto_icon_font.ttf";

function randomColor($color = 'LIGHT OR DARK'): int
{
    if ($color == 'LIGHT') {
        return rand(200, 255);
    }

    return rand(0, 100);
}



function getLogoURL($alphabet): string
{
    $alphabet = substr($alphabet, 0, 1);
    global $logo_font;
    $new_logo = time() . time() . rand(0, 999999999999) . rand(0, 999999999999) . ".png";
    $image = imagecreatetruecolor(500, 500);
    $background_color = imagecolorallocate($image,  randomColor('LIGHT'), randomColor('LIGHT'), randomColor('LIGHT'));

    imagefill($image, 0, 0, $background_color);
    $font_color = imagecolorallocate($image, randomColor(), randomColor(), randomColor());

    $tb = imagettfbbox(300, 0, $logo_font, $alphabet,);
    $x = ceil((500 - $tb[2]) / 2);

    imagettftext($image, 300, 0, $x, 380, $font_color, $logo_font, $alphabet);
    imagepng($image, $new_logo);

    $logo_url = getURL($new_logo);
    unlink($new_logo);
    return $logo_url;
}
