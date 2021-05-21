<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1');
}

$type = $_GET['type'];
$type = $_REQUEST['type'];
//echo $type;

$userQuery = "select * from EqManage.users";
$eqQuery = "select * from EqManage.equipment";
$logQuery = "select * from EqManage.log";
$rqQuery = "select * from EqManage.requests";
$catQuery = "select * from EqManage.categories";

$finalQuery = "";
//1=user, 2=equiment,3 =log, 4=request, 5=category

switch ($type) {
    case 1 : $finalQuery = $userQuery; break;
    case 2 : $finalQuery = $eqQuery; break;
    case 3 : $finalQuery = $logQuery; break;
    case 4 : $finalQuery = $rqQuery; break;
    case 5 : $finalQuery = $catQuery; break;
    default : $finalQuery = $userQuery;
};

echo "<label for=\"select\" style=\"margin-top: 20px; margin-right: 5px\">Search: </label>";
echo "<select id=\"select\" style=\"width: 20%; text-align: left;margin-bottom: 10px\" >";
$query = mysqli_query($db,$finalQuery);
while ($row = mysqli_fetch_array($query)){
    echo "<option value=\"\">Type/Select ID</option>";
    $ID = $row['id'];
    switch ($type){
        case 1 : $name = "Name: ".$row['fullname']; break;
        case 2 : $name = "Name: ".$row['equipment']; break;
        case 3: $name = "Initial Insert Date : ".$row['checkoutRequestDate']; break;
        case 4: $name = "Request Date: ".$row['requestDate']; break;
        case 5 : $name = "Name: ".$row['categoryName']; break;
        default : $name = "error";
    };
    echo "<option value='$ID'>ID: $ID | $name</option>";
};

echo "</select>";
//echo $finalQuery;
echo "<script>$(\"#select\").select2( {
        placeholder: \"Scan Barcode or enter Equipment ID\",
        allowClear: true,

    } );</script>";
