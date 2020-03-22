<?php


    include('serverconnect.php');

    $select = $_REQUEST['filter'];
    $radio = $_REQUEST['range'];
    $query = "";
$today = date("Y-m-d H:i:s");
$todayExplode = explode(" ", $today);
$yesturday = date('Y-m-d', strtotime('now - 1 day'));
$weekago = date('Y-m-d', strtotime('now - 7 day'));
//echo $weekago;
//echo $todayExplode[0];
//echo $yesturday;

    //If select = 0, filter with checkoutDate
//If radio = 0 - all time, 1 - today, 2-yesturday, 3-a week ago
if ($radio == 0){
    switch ($select){
        case 0 : $query = "Select * from EqManage.log"; break;
        case 1 : $query = "Select * from EqManage.log where DATE(checkoutDate) = '$todayExplode[0]'"; break;
        case 2 : $query = "Select * from EqManage.log where DATE(checkoutDate) = '$yesturday'"; break;
        case 3 : $query = "Select * from EqManage.log where DATE(checkoutDate) >= '$weekago'"; break;
        break;
    }
}
if ($radio == 1){
    switch ($select){
        case 0 : $query = "Select * from EqManage.log"; break;
        case 1 : $query = "Select * from EqManage.log where DATE(returnDate) = '$todayExplode[0]'"; break;
        case 2 : $query = "Select * from EqManage.log where DATE(returnDate) = '$yesturday'"; break;
        case 3 : $query = "Select * from EqManage.log where DATE(returnDate) >= '$weekago'"; break;
        break;
    }
}
$results = mysqli_query($db, $query);
if(mysqli_fetch_array($results) != null) {

    $results = mysqli_query($db, $query);
    while($row = mysqli_fetch_array($results)) {
//        echo "test";
        echo "<tr>";
        echo "<td style='text-align:left'>", $row['id'], "</td>";
        echo "<td style='text-align:left'>", $row['checkoutRequests_id'], "</td>";
        echo "<td style='text-align:left'>", $row['equipment_id'], "</td>";
        echo "<td style='text-align:left'>", $row['users_id'], "</td>";
        echo "<td style='text-align:left'>", $row['checkoutDate'], "</td>";
        echo "<td style='text-align:left'>", $row['expectedReturnDate'], "</td>";
        echo "<td style='text-align:left'>";

        if ($row['returnDate'] == null) {
            echo '<dt style="color:red; text-align: left";">Not returned yet</dt>';
        } else echo $row['returnDate'];
        echo "</td>";
        echo "</tr>";
    }

} elseif (mysqli_fetch_array($results) == null){
    echo "No records";
}
?>

