<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator') {
    header('Location: index.php?adminonly=1');
}

include('serverconnect.php');
$query = mysqli_query($db, "Select * from EqManage.log where checkoutDate is not null");
$query2 = mysqli_query($db, "Select * from EqManage.requests");
$today = date("Y-m-d H:i:s");
$todayExplode = explode(" ", $today);
$monthago = date('Y-m-d', strtotime('now - 1 month'));
$overdue = 0;
$checkoutToday = 0;
$pendingRQ = 0;
$checkoutMonth = 0;

while ($row = mysqli_fetch_array($query)) {
    $expectedReturnDate = $row['expectedReturnDate'];
    $checkoutDate = $row['checkoutDate'];
    $returnDate = $row['returnDate'];
    $checkoutDateExplode = explode(" ", $checkoutDate);

    if (strtotime($expectedReturnDate) < strtotime($today) && $returnDate == null) {
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
echo "<h3 class=\"card-title\">", $overdue, "</h3>";


