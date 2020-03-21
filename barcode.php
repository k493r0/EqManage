<?php
require "vendor/autoload.php";
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
$redColor = [255, 0, 0];


include('serverconnect.php');
$getbarcode = mysqli_query($db,"select * from equipment");

while ($row = mysqli_fetch_array($getbarcode)){
    $equipment_name = $row['equipment'];
    echo $equipment_name;
    echo '<div></div>';
    echo '<img src="data:image/png;base64,' . base64_encode($generatorPNG->getBarcode($row['barcodeID'], $generatorPNG::TYPE_CODE_128)) . '">';
    echo '<div></div>';
}





$num =  mt_rand(10000000,99999999);
echo $num;
