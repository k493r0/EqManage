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
$results = mysqli_query($db, "SELECT * FROM EqManage.equipment inner join EqManage.categories on equipment.category = categories.id");

$query = mysqli_query($db, "Select * from EqManage.log 
left join requests r on log.checkoutRequests_id = r.id
left join users u on log.users_id = u.id
left join equipment e on e.id = log.equipment_id
where returnDate is null and checkoutDate is not null");
$query2 = mysqli_query($db, "Select * from EqManage.requests");
$today = date("Y-m-d H:i:s");
$todayExplode = explode(" ", $today);
//echo $todayExplode[0];

$monthago = date('Y-m-d', strtotime('now - 1 month'));
//echo $monthago;

$overdue = 0;
$checkoutToday = 0;
$pendingRQ = 0;
$checkoutMonth = 0;

//                echo $today;

while ($row = mysqli_fetch_array($query)) {
    $returnDate = $row['expectedReturnDate'];
    $checkoutDate = $row['checkoutDate'];
    $checkoutDateExplode = explode(" ", $checkoutDate);

//                    echo "<p>'$returnDate'</p>";
    if (strtotime($returnDate) < strtotime($today)) {
        echo "<tr>";
        echo "<td>",$row['fullname'] ,"</td>";
        echo "<td>",$row['equipment'] ,"</td>";
        echo "<td>",$row['checkoutQty'] ,"</td>";
        echo "<td>",$row['purpose'] ,"</td>";
        echo "<td>",$row['checkoutDate'] ,"</td>";
        echo "<td>",$row['expectedReturnDate'] ,"</td>";
        echo "<td>",$row['checkoutRequests_id'] ,"</td>";
        echo "<td><a href=''>Notify</a></td>";
        echo "<td><button type='button' class='btn btn-link' style='padding: 0' id='confirmReturnBtn' onclick='confirmReturn(".$row['checkoutRequests_id'].")'>Return</button></td>";

        echo "</tr>";


    }
}

