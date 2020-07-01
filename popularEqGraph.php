<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}

$dataPoints = array();

include('serverconnect.php');
$equipmentID = $_POST['id'];
$result = mysqli_query($db,"select * from EqManage.equipment order by popularity");

$users_arr = array();
while ($row = mysqli_fetch_array($result)) {
    $popularity = $row['popularity'];

    $name = $row['equipment'];
    array_push($dataPoints, array("label" => $name, "y" => $popularity));

}

echo json_encode($dataPoints, JSON_NUMERIC_CHECK);

?>
