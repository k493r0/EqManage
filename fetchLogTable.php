<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1');
}

include('serverconnect.php');

$range = $_GET['filter']; //Can use _Request
$filter = $_GET['range'];
$userID = $_GET['user'];
$query = "";
$today = date("Y-m-d");
$yesturday = date('Y-m-d', strtotime('now - 1 day'));
$weekago = date('Y-m-d', strtotime('now - 7 day'));
if ($range == null){
    $range = 0;
};
if ($filter == null){
    $filter = 0;
};
$originalQuery = "Select log.id as logid, log.users_id, u.fullname, log.checkoutRequests_id, log.equipment_id, log.checkoutDate, log.returnDate, log.expectedReturnDate from EqManage.log left join users u on log.users_id = u.id ";//Default
$query = $originalQuery;
if ($filter == 0){
    switch ($range){
        case 0 : $query = "Select log.id as logid, log.users_id, u.fullname, log.checkoutRequests_id, log.equipment_id, log.checkoutDate, log.returnDate, log.expectedReturnDate from EqManage.log left join users u on log.users_id = u.id "; break;//No range specified
        //and Checkout Date is selected as a method of range selection
        case 1 : $query = $originalQuery."where DATE(checkoutDate) = '$today'"; break; //When range is today, and Checkout Date is selected as a method of range selection
        case 2 : $query = $originalQuery."where DATE(checkoutDate) = '$yesturday'"; break; //When range is yesterday, and Checkout Date is selected as a method of range selection
        case 3 : $query = $originalQuery."where DATE(checkoutDate) >= '$weekago'"; break; //When range is week, and Checkout Date is selected as a method of range selection
        default: $query = null;
    }
};
if ($filter == 1){
    switch ($range){
        case 0 : $query = "Select log.id as logid, log.users_id, u.fullname, log.checkoutRequests_id, log.equipment_id, log.checkoutDate, log.returnDate, log.expectedReturnDate from EqManage.log left join users u on log.users_id = u.id "; break;//No range specified
        // and Return Date is selected as a method of range selection
        case 1 : $query = $originalQuery."where DATE(returnDate) = '$today'"; break;//When range is today, and Return Date is selected as a method of range selection
        case 2 : $query = $originalQuery."where DATE(returnDate) = '$yesturday'"; break;//When range is yesterday, and Return Date is selected as a method of range selection
        case 3 : $query = $originalQuery."where DATE(returnDate) >= '$weekago'"; break;//When range is week, and Return Date is selected as a method of range selection
        default: $query = null;
    }
};

if ($userID != null & $query == $originalQuery & $userID != 0){//No condition in query and has user specified but not 0
    $query = $query." where log.users_id = $userID";
} elseif ($userID != null & $userID != 0){ //user id specified but not 0
    $query = $query."and log.users_id = $userID";
}
if ($query != null){
    $query .= " order by log.id asc";
}
$results = mysqli_query($db, $query);
if(mysqli_fetch_array($results) != null) {
    $results = mysqli_query($db, $query);
    while($row = mysqli_fetch_array($results)) {
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


} else echo "No records";
?>

