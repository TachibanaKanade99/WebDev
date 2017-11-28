<?php
    $scale = $_POST["scale"];
    $angle = $_POST["angle"];
    $x = $_POST["x"];
    $y = $_POST["y"];
    $w = $_POST["w"];
    $h = $_POST["h"];

    $result = "";
    $result .= "Scale: " . $scale . "<br />";
    $result .= "Angle: " . $angle . "<br />";
    $result .= "x: " . $x . "<br />";
    $result .= "y: " . $y . "<br />";
    $result .= "w: " . $w . "<br />";
    $result .= "h: " . $h . "<br />";
    echo $result;

    // File
    $imageFile = "img/itmo.png";
    $resizedFile = "img/resized.png";
    $newFile = "img/new.png";

    // Old size
    list($oldWidth, $oldHeight) = getimagesize($imageFile);
    // New size
    $newWidth = $oldWidth * $scale;
    $newHeight = $oldHeight * $scale;
    // New Image
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    $oldImage = imagecreatefrompng($imageFile);
    imagecopyresampled($newImage, $oldImage,  0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
    imagepng($newImage, $resizedFile, 6);

    $cropImage = imagecreatetruecolor(250, 250);
    $newImage = imagecreatefrompng($resizedFile);
    imagecopyresampled($cropImage, $newImage,  0, 0, $x, $y, 250, 250, 250, 250);
    imagepng($cropImage, $newFile, 6);
?>
