<?php
session_start();
function generateCaptchaCode($length = 6) {
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    return substr(str_shuffle($characters), 0, $length);
}
$captcha = generateCaptchaCode();
$_SESSION['captcha'] = $captcha;
$width = 150;
$height = 50;
$image = imagecreatetruecolor($width, $height);
$bgColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);    
imagefill($image, 0, 0, $bgColor);
$font = 5;
$spacing = 22;
$baseX = 10;
$baseY = 15;
for ($i = 0; $i < strlen($captcha); $i++) {
    $xOffset = rand(-2, 2);
    $yOffset = rand(-3, 3);
    imagestring($image, $font, $baseX + $i * $spacing + $xOffset, $baseY + $yOffset, $captcha[$i], $textColor);
}
for ($i = 0; $i < 12; $i++) {
    $lineColor = imagecolorallocate($image, 0, 0, 0);
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
}

// Output the image
header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
?>