<?php


$dataPoints = array();

include('serverconnect.php');
$equipmentID = $_POST['id'];
$result = mysqli_query($db, "select * from EqManage.log");

$users_arr = array();
$today = date("Y-m-d H:i:s");
$todayExplode = explode(" ", $today);
$oneday = date('Y-m-d', strtotime('now - 1 day'));
$twoday = date('Y-m-d', strtotime('now - 2 day'));
$threeday = date('Y-m-d', strtotime('now - 3 day'));
$fourday = date('Y-m-d', strtotime('now - 4 day'));
$fiveday = date('Y-m-d', strtotime('now - 5 day'));
$sixday = date('Y-m-d', strtotime('now - 6 day'));

$onecount = 0;
$twocount = 0;
$threecount = 0;
$fourcount = 0;
$fivecount = 0;
$sixcount = 0;
$todaycount = 0;

//echo $sevenday;


while ($row = mysqli_fetch_array($result)) {
    $checkoutDate = $row['checkoutDate'];
    $checkoutDateExplode = explode(" ", $checkoutDate);
//    echo "-----", $checkoutDateExplode[0],"----" ,$row['checkoutRequests_id'];

    if ($checkoutDateExplode[0] == $oneday){
//        echo "====================", $checkoutDateExplode[0], $oneday;
        $onecount++;
    } elseif ($checkoutDateExplode[0] == $twoday){
        $twocount++;
    } elseif ($checkoutDateExplode[0] == $threeday){
        $threecount++;
    }elseif ($checkoutDateExplode[0] == $fourday){
        $fourcount++;
    }elseif($checkoutDateExplode[0] == $fiveday){
        $fivecount++;
    }elseif ($checkoutDateExplode[0] == $sixday){
        $sixcount++;
    } elseif ($checkoutDateExplode[0] == $todayExplode[0]){
        $todaycount++;
    }

}

$dataPoints = array(
    array("label"=> $sixday, "y"=> $sixcount),
    array("label"=> $fiveday, "y"=> $fivecount),
    array("label"=> $fourday, "y"=> $fourcount),
    array("label"=> $threeday, "y"=> $threecount),
    array("label"=> $twoday, "y"=> $twocount),
    array("label"=> $oneday, "y"=> $onecount),
    array("label"=> $todayExplode[0], "y"=> $todaycount),
);

echo json_encode($dataPoints, JSON_NUMERIC_CHECK);

