<?php
if(isset($_POST["image"])){
    $data = $_POST["image"]; //This contains a string that looks like "data:image/png;base64,abc123••••"
    $image_array_1 = explode(";", $data); //The string is split at ;, so it separates to "data:image/png" "base64,abc1abc123••••"
    $image_array_2 = explode(",", $image_array_1[1]);//Split "base64" with "abc123••••"
    $data = base64_decode($image_array_2[1]);//Decodes base_64 encoded string back to image data
    $randomNumber = mt_rand(10000000, 99999999); //Generate random number for image name
    $imageName = "assets/images/".$randomNumber.'.png'; //setting image location (For img src for displaying image on the page), this can be relative
    $directory = $_SERVER['DOCUMENT_ROOT']."/EqManage/assets/images/".$randomNumber. '.png'; //Setting absolute directory on the server with
    //SERVER DOCUMENT ROOT (To make sure file directory stays the same between servers) for storing file to server
    file_put_contents($directory, $data); //Write data to file on the server
    echo '<input type="hidden" value="' . $randomNumber . '" id="eqImg"/>'; //Create hidden input with the image identifier
    //This hidden input is used to store the image directory of the selected when adding equipment to database
    echo '<img src="'.$imageName.'" class="img-thumbnail" value"'.$randomNumber.'" width="250" height="250" />';//Display the image
}
?>
