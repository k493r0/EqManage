<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1'); //Redirects to the main page if students attempts to login
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {//When POST request was sent

    include('serverconnect.php');
    $today = date('Y-m-d H:i:s');
    $userID = $_POST['userID'];
    $eqID = $_POST['eqID'];
    $requestOption = $_POST['checkoutID'];

    $getEqName = mysqli_query($db, "select * from EqManage.equipment where id = '$eqID'");
    while ($row = mysqli_fetch_array($getEqName)) {
        $eqName = $row['equipment'];
    } //Get name of the equipment to send notification

    $checkNotif = mysqli_query($db, "Select * from notification where message = '$eqName was successfully checked out' and target = '$userID'");
    if(mysqli_num_rows($checkNotif) != null){ //If same notification was sent before, reuse the notification, it saves storage space
        $updateNotif = "Update EqManage.notification set status = 0, datetime = '$today' where message = '$eqName was successfully checked out' and target = '$userID'";
        if (mysqli_query($db, $updateNotif)) {
            $last_id = mysqli_insert_id($db);
            echo "Notification updated. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $updateNotif . "<br>" . mysqli_error($db);
        }
    } else{ //If the notification was never sent before, add notification to the database
        echo "empty";
        $notif_query = "INSERT into EqManage.notification (message,target,status,datetime) values ('$eqName was successfully checked out' ,'$userID',0, '$today')";
        if (mysqli_query($db, $notif_query)) {
            $last_id = mysqli_insert_id($db);
            echo "Notification updated. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $notif_query . "<br>" . mysqli_error($db);
        }
    }


    if ($requestOption == 0) {//When "check out all request" option is selected
        $getLogID = mysqli_query($db, "select * from EqManage.log where users_id = '$userID' AND checkoutDate IS NULL AND returnDate IS NULL AND equipment_id = '$eqID'");
        while ($row = mysqli_fetch_array($getLogID)) {
            $logID = $row['id'];
        }
        echo  "logID".$logID;
        $query = "UPDATE EqManage.log set checkoutDate = '$today' where users_id = '$userID' AND checkoutDate IS NULL AND returnDate IS NULL and equipment_id = '$eqID'";
        $updateEquipment = "Update EqManage.equipment set popularity = popularity + 1, lastLog_id = '$logID', users_id = '$userID' where id = '$eqID'";
    } else {//When the request ID is specified
        $getLogID = mysqli_query($db, "select * from EqManage.log where checkoutRequests_id = '$requestOption' and equipment_id = '$eqID'");
        while ($row = mysqli_fetch_array($getLogID)) {
            $logID = $row['id'];
        }
        $query = "UPDATE EqManage.log set checkoutDate = '$today' where checkoutRequests_id = '$requestOption' and equipment_id = '$eqID'";
        $updateEquipment = "Update EqManage.equipment set popularity = popularity + 1, lastLog_id = '$logID', users_id = '$userID' where id = '$eqID'";
    }

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
