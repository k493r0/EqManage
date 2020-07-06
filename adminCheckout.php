<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1');
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

    $getEqName = mysqli_query($db, "select * from EqManage.equipment where id = '$eqID'");
    while ($row = mysqli_fetch_array($getEqName)) {
        $eqName = $row['equipment'];
    }

    $checkNotif = mysqli_query($db, "Select * from notification where message = '$eqName was successfully checked out' and target = '$userID'");
    if(mysqli_num_rows($checkNotif) != null){ //Saves storage space
        echo "present";
        $updateNotif = "Update EqManage.notification set status = 0 where message = '$eqName was successfully checked out' and target = '$userID'";
        if (mysqli_query($db, $updateNotif)) {
            $last_id = mysqli_insert_id($db);
            echo "Notification updated. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $updateNotif . "<br>" . mysqli_error($db);
        }
    } else{
        echo "empty";
        $notif_query = "INSERT into EqManage.notification (message,target,status,datetime) values ('$eqName was successfully checked out' ,'$userID',0, '$today')";
        if (mysqli_query($db, $notif_query)) {
            $last_id = mysqli_insert_id($db);
            echo "Notification updated. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $notif_query . "<br>" . mysqli_error($db);
        }
    }




    if ($requestOption == 0) {
        $getLogID = mysqli_query($db, "select * from EqManage.log where users_id = '$userID' AND checkoutDate IS NULL AND returnDate IS NULL and equipment_id = '$eqID'");
        while ($row = mysqli_fetch_array($getLogID)) {
            $logID = $row['id'];
        }
        echo  "logID".$logID;
        $query = "UPDATE EqManage.log set checkoutDate = '$today' where users_id = '$userID' AND checkoutDate IS NULL AND returnDate IS NULL and equipment_id = '$eqID'";
        $updateEquipment = "Update EqManage.equipment set popularity = popularity + 1, lastLog_id = '$logID', users_id = '$userID' where id = '$eqID'";
    } else {
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
