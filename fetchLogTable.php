<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}

include('serverconnect.php');

$range = $_GET['filter']; //Can use _Request
$filter = $_GET['range'];
$userID = $_GET['user'];
$query = "";
$today = date("Y-m-d H:i:s");
$todayExplode = explode(" ", $today);
$yesturday = date('Y-m-d', strtotime('now - 1 day'));
$weekago = date('Y-m-d', strtotime('now - 7 day'));
//echo $weekago;
//echo $todayExplode[0];
//echo $yesturday;
//
//echo $range;
//echo $filter;

if ($range == null){
    $range = 0;
};
if ($filter == null){
    $filter = 0;
};

//set default


//    If select = 0, filter with checkoutDate
//If radio = 0 - all time, 1 - today, 2-yesturday, 3-a week ago
$originalQuery = "Select log.id as logid, log.users_id, u.fullname, log.checkoutRequests_id, log.equipment_id, log.checkoutDate, log.returnDate, log.expectedReturnDate from EqManage.log left join users u on log.users_id = u.id ";
$query = $originalQuery;
if ($filter == 0){
    switch ($range){
        case 0 : $query = "Select log.id as logid, log.users_id, u.fullname, log.checkoutRequests_id, log.equipment_id, log.checkoutDate, log.returnDate, log.expectedReturnDate from EqManage.log left join users u on log.users_id = u.id "; break;
        case 1 : $query = $originalQuery."where DATE(checkoutDate) = '$todayExplode[0]'"; break;
        case 2 : $query = $originalQuery."where DATE(checkoutDate) = '$yesturday'"; break;
        case 3 : $query = $originalQuery."where DATE(checkoutDate) >= '$weekago'"; break;
        default: $query = null;
    }
};
if ($filter == 1){
    switch ($range){
        case 0 : $query = "Select log.id as logid, log.users_id, u.fullname, log.checkoutRequests_id, log.equipment_id, log.checkoutDate, log.returnDate, log.expectedReturnDate from EqManage.log left join users u on log.users_id = u.id "; break;
        case 1 : $query = $originalQuery."where DATE(returnDate) = '$todayExplode[0]'"; break;
        case 2 : $query = $originalQuery."where DATE(returnDate) = '$yesturday'"; break;
        case 3 : $query = $originalQuery."where DATE(returnDate) >= '$weekago'"; break;
        default: $query = null;
    }
};

//echo $userID;
//$query = $query." where users_id = $userID";

//echo "Select", $range;
//echo "Radio", $filter;
//echo $query;

if ($userID != null & $query == $originalQuery & $userID != 0){//No condition in query and has user specified but not 0
    $query = $query." where log.users_id = $userID";
} elseif ($userID != null & $userID != 0){ //user id specified but not 0
//    echo "test";
    $query = $query."and log.users_id = $userID";
}

if ($query != null){
    $query .= " order by log.id asc";
}
//echo "djajdlkqjlkdqjjqlwdjqlwkjl",$userID;
//echo $query;
//
//echo $query;

//echo $userID;



$results = mysqli_query($db, $query);
if(mysqli_fetch_array($results) != null) {
//    echo "hello";
//    echo $query;
//    echo $query;
    $results = mysqli_query($db, $query);
    while($row = mysqli_fetch_array($results)) {
//        echo "test";
        echo "<tr>";
        echo "<td style='text-align:left'><a href='search.php?type=3&id=".$row['logid']."'>". $row['logid']."</td>";
        echo "<td style='text-align:left'><a href='search.php?type=1&id=".$row['users_id']."'>(".$row['users_id'].") ".$row['fullname']."</td>";
        echo "<td style='text-align:left'><a href='search.php?type=4&id=".$row['checkoutRequests_id']."'>". $row['checkoutRequests_id']. "</td>";
        echo "<td style='text-align:left'><a href='search.php?type=2&id=".$row['equipment_id']."'>".$row['equipment_id']. "</td>";

        echo "<td style='text-align:left'>";
        if ($row['checkoutDate'] == null) {
            echo '<dt style="color:red; text-align: left";">Not checked out yet</dt>';
        } else echo $row['checkoutDate'];
        echo "</td>";
        echo "<td style='text-align:left'>".$row['expectedReturnDate']."</td>";
        echo "<td style='text-align:left'>";

        if ($row['returnDate'] == null) {
            echo '<dt style="color:red; text-align: left";">Not returned yet</dt>';
        } else echo $row['returnDate'];
        echo "</td>";
        echo "</tr>";
    }


} else echo "No records".$query;
?>

