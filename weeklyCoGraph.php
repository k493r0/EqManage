<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1');
}

$dataPoints = array();

include('serverconnect.php');
$equipmentID = $_POST['id'];
$result = mysqli_query($db, "select * from EqManage.log");



$onecount = 0;
$twocount = 0;
$threecount = 0;
$fourcount = 0;
$fivecount = 0;
$sixcount = 0;
$todaycount = 0;

//echo $sevenday;

$users_arr = array();
$today = date('Y-m-d', strtotime('now'));
$oneday = date('Y-m-d', strtotime('now - 1 day'));
$twoday = date('Y-m-d', strtotime('now - 2 day'));
$threeday = date('Y-m-d', strtotime('now - 3 day'));
$fourday = date('Y-m-d', strtotime('now - 4 day'));
$fiveday = date('Y-m-d', strtotime('now - 5 day'));
$sixday = date('Y-m-d', strtotime('now - 6 day'));
while ($row = mysqli_fetch_array($result)) {
    $checkoutDate = $row['checkoutDate'];
    $checkoutDateExplode = explode(" ", $checkoutDate);

    switch ($checkoutDateExplode[0]){
        case $oneday : $onecount++; break;
        case $twoday : $twocount++; break;
        case $threeday : $threecount++; break;
        case $fourday : $fourcount++; break;
        case $fiveday : $fivecount++; break;
        case $sixday : $sixcount++; break;
        case $today : $todaycount++;
    }
}

$dataPoints = array(
    array("label"=> $sixday, "y"=> $sixcount),
    array("label"=> $fiveday, "y"=> $fivecount),
    array("label"=> $fourday, "y"=> $fourcount),
    array("label"=> $threeday, "y"=> $threecount),
    array("label"=> $twoday, "y"=> $twocount),
    array("label"=> $oneday, "y"=> $onecount),
    array("label"=> $today, "y"=> $todaycount),
);

echo json_encode($dataPoints, JSON_NUMERIC_CHECK);

