<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}

include ('serverconnect.php');
require 'vendor/autoload.php';


$getEqName = mysqli_query($db, "select * from EqManage.equipment");
while ($row = mysqli_fetch_array($getEqName)) {
    $filepath = $_SERVER['DOCUMENT_ROOT']."/EqManage/assets/barcode/".$row['id']."_barcode.png";
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $white = [255, 255, 255];
    file_put_contents($filepath, $generator->getBarcode($row['barcodeID'], $generator::TYPE_CODE_128, 3, 50));
}

if (isset($_GET['download']) && isset($_GET['id']) && $_GET['download'] == 1){
$eqID = $_GET['id'];
$file = $_SERVER['DOCUMENT_ROOT'] . "/EqManage/assets/barcode/" . $eqID . "_barcode.png";
echo $file;
if (file_exists($file)) {
    echo "hello";
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
}};


?>
<?php


?>
<!DOCTYPE html>
<html>

<?php
include('header.php')
?>


<body class="form-v8 loggedin" id="fade">

<div id="loader">
    <div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php
if ($_SESSION['username'] == 'administrator'){
    include ('adminNavbar.php');
} else{
    include ('navbar.php');
}
?>
<div style="height: 63px; opacity: 0; padding: 0; margin: 0" ></div>



<div class="content">
    <?php if (isset($_GET['sent']) && $_GET['sent'] == 1){
        echo '<h2>Message</h2><p style="color: red" >Your request is sent</p>';
    } ?>
    <?php if (isset($_GET['verify']) && $_GET['verify'] == 1){
        echo '<h2>Message</h2><p style="color: red" >Successfully Verified</p>';
    } ?>
    <?php if (isset($_GET['return']) && $_GET['return'] == 1){
        echo '<h2>Message</h2><p style="color: red" >Successfully Returned</p>';
    } ?>
    <?php if (isset($_GET['return']) && $_GET['return'] == 0){
        echo '<h2>Message</h2><p style="color: red" >Error occurred, please login with the user you borrowed the equipment with</p>';
    } ?>
    <?php if (isset($_GET['adminonly']) && $_GET['adminonly'] == 1){
        echo '<h2>Message</h2><p style="color: red" >This page is only accessible by site admin</p>';
    } ?>

</div>


<?php $getCategory = mysqli_query($db, "SELECT * FROM EqManage.categories");

?>


<div class="features-boxed" style="height: 787px;">
    <div class="container">
        <div class="intro" style="text-align: center">

            <h2 class="text-center">Barcode</h2>
            <p class="text-center">In this page, you can print/download the barcodes</p>
            <button type="button" class="btn btn-info" style="margin-top:10px" onclick="window.location.href='barcodePDF.php'">Download PDF</button>

        </div>


        <div class="row justify-content-center features" id="box">

                <?php
                $getEqName = mysqli_query($db, "select * from EqManage.equipment");
                while ($row = mysqli_fetch_array($getEqName)) {
                    $eqname = $row['equipment'];
                    $barcodeID = $row['barcodeID'];
                ?>
            <div class="col-sm-6 col-md-5 col-lg-4 item">
                <div class="box" id='box2'>
                    <h3 class="name"><?php echo $eqname ?></h3>
                    <?php
                    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                    echo '<img style="margin-bottom:20px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcodeID, $generator::TYPE_CODE_128)) . '">';
                    echo '<button type=\'button\' class=\'btn btn-link\' value=\''.$row['id'].'\' onclick="downloadBarcode(this.value)">Download This Barcode</button>'
                    ?>
                </div>
            </div>
               <?php } ?>
            </div>
        </div>

        <script>
            function downloadBarcode(id) {
                console.log(id);
                var url = "barcode.php?download=1&id="+id;
                window.location.replace(url);


            }
        </script>

</body>
<?php

if ($_SESSION['username'] == 'administrator'){
    include ('adminModal.php');
}

?>


