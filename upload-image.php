<?php

//upload.php

if(isset($_POST["image"]))
{
    $data = $_POST["image"];
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);
    $imageName = "assets/images/".time() . '.png';
    $time = time();
    $directory = $_SERVER['DOCUMENT_ROOT']."/EqManage/assets/images/".$time. '.png';
    echo $imageName;
    echo $directory;
    file_put_contents($directory, $data);

    echo '<input type="hidden" value="' . $time . '" id="eqImg"/>';
    echo '<img src="'.$imageName.'" class="img-thumbnail" value"'.$time.'" width="250" height="250" />';
}

?>
