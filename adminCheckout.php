<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}

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
        $query = "UPDATE EqManage.log set checkoutDate = '$today' where users_id = '$userID' AND checkoutDate IS NULL AND returnDate IS NULL and equipment_id = '$eqID'";
        $updateEquipment = "Update EqManage.equipment set popularity = popularity + 1 where id = '$eqID'";
    } else $query = "UPDATE EqManage.log set checkoutDate = '$today' where checkoutRequests_id = '$requestOption' and equipment_id = '$eqID'";

    $updateEquipment = "Update EqManage.equipment set popularity = popularity + 1 where id = '$eqID'";

    if (mysqli_query($db, $query)) {
        echo "Successfully updated table";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }

    if (mysqli_query($db, $updateEquipment)) {
        echo "Successfully updated table";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }

}
