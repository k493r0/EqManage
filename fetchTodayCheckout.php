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
$query = mysqli_query($db, "Select * from EqManage.log");
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
        $overdue++;
    }
    if (strtotime($checkoutDateExplode[0]) == strtotime($todayExplode[0])) {
        $checkoutToday++;
    }
    if (strtotime($checkoutDateExplode[0]) >= strtotime($monthago)) {
        $checkoutMonth++;
    }
};


while ($row = mysqli_fetch_array($query2)) {
    $state = $row['state'];
    if ($state == null) {
        $pendingRQ++;
    }
}

//echo "Overdue: ", $overdue;
//echo " Checked out today: ", $checkoutToday;
//echo " Pending requests: ", $pendingRQ;
//echo " Checked out this month", $checkoutMonth;
echo "<h3 class=\"card-title\">",$checkoutToday,"</h3>";


