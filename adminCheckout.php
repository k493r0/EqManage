<?php
include('serverconnect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['studentselect'];
    $eqID = $_POST['eqselect'];
    $requestOption = $_POST['checkOutSelect'];

    echo $userID;
    echo $eqID;
    echo $requestOption;




}