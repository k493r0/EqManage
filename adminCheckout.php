<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('serverconnect.php');
    $today = date('Y-m-d H:i:s');
    $userID = $_POST['userID'];
    $eqID = $_POST['eqID'];
    $requestOption = $_POST['checkoutID'];

    echo $userID;
    echo $eqID;
    echo $requestOption;

    if ($requestOption == 0) {
        $query = "UPDATE EqManage.log set checkoutDate = '$today' where users_id = '$userID' AND checkoutDate IS NULL AND returnDate IS NULL";
    } else $query = "UPDATE EqManage.log set checkoutDate = '$today' where checkoutRequests_id = '$requestOption'";


    if (mysqli_query($db, $query)) {
        echo "Successfully updated table";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }

}