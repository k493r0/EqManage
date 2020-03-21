<?php

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