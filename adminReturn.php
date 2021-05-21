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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['rqID'])) {
        $today = date('Y-m-d H:i:s');
        $userID = $_POST['userID'];
        $eqID = $_POST['eqID'];
        $requestOption = $_POST['checkoutID'];

        $QtyArray = array();
        $totalReturnQty = 0;
        $query = "";

        if ($requestOption == 0) {//When "All" is selected, all the request send from that user on that equipment is processed for return
            $query = "UPDATE EqManage.log set returnDate = '$today' where users_id = '$userID' AND checkoutDate IS NOT NULL AND returnDate IS NULL AND equipment_id = '$eqID'";

            $getCheckoutQty = mysqli_query($db, "select * from EqManage.log l left join requests r on l.checkoutRequests_id = r.id where l.users_id = '$userID' AND l.checkoutDate IS NOT NULL AND l.returnDate IS NULL 
                                                        AND l.equipment_id = '$eqID'");//Get how many equipment was checked out
            while ($row = mysqli_fetch_array($getCheckoutQty)) {
                array_push($QtyArray, $row['checkoutQty']);
            };
            foreach ($QtyArray as $Qty) {
                $totalReturnQty += $Qty; //Get the total quantity checked out for one equipment
            }
            $equipmentUpdateQuery = "UPDATE EqManage.equipment set leftQuantity = leftQuantity + '$totalReturnQty' where id = '$eqID'"; //Restore the quantity
        } else {
            $query = "UPDATE EqManage.log set returnDate = '$today' where checkoutRequests_id = '$requestOption'";
            $getCheckoutQty = mysqli_query($db, "SELECT * FROM EqManage.requests where id = '$requestOption'");
            while ($row = mysqli_fetch_array($getCheckoutQty)) {
                $totalReturnQty = $row['checkoutQty'];//Total quantity to be restored
            }
            $equipmentUpdateQuery = "UPDATE EqManage.equipment set leftQuantity = leftQuantity + '$totalReturnQty' where id = '$eqID'";
        }

        $updateAvailability = "Update EqManage.equipment set availability = 1 where id = '$eqID'"; //It will always be available after return



        //Sending notification
        $getEqName = mysqli_query($db, "select * from EqManage.equipment where id = '$eqID'");
        while ($row = mysqli_fetch_array($getEqName)) {
            $eqName = $row['equipment'];
        }
        $message = $eqName.' was successfully returned';
        $checkNotif = mysqli_query($db, "Select * from notification where message = '$message' and target = '$userID'");
        if(mysqli_num_rows($checkNotif) != null){//If same notification was set before, reuse it to save space and speedup query
            $updateNotif = "Update EqManage.notification set status = 0 where message = '$message' and target = '$userID'";
            if (mysqli_query($db, $updateNotif)) {
                $last_id = mysqli_insert_id($db);
                echo "Notification updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $updateNotif . "<br>" . mysqli_error($db);
            }
        } else{//If notification was not set before, insert the notification into the database
            $notif_query = "INSERT into EqManage.notification (message,target,status,datetime) values ('$message' ,'$userID',0, '$today')";
            if (mysqli_query($db, $notif_query)) {
                $last_id = mysqli_insert_id($db);
                echo "Notification updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $notif_query . "<br>" . mysqli_error($db);
            }
        }


        //Update Log
        if (mysqli_query($db, $query)) {
            echo "Successfully updated table";
        } else {
            echo mysqli_error($db);
        }

        //Update Equipment
        if (mysqli_query($db, $equipmentUpdateQuery)) {
            echo "Successfully updated table";
        } else {
            echo mysqli_error($db);
        }

        //Update Availability
        if (mysqli_query($db, $updateAvailability)) {
            echo "Successfully updated table";
        } else {
            echo mysqli_error($db);
        }
    }elseif (isset($_POST['rqID'])){//If request ID is specified, return process for that particular requestID (checkoutID) will run
        echo "rqID";
        $checkoutRequestsID = $_POST['rqID'];
        echo $checkoutRequestsID;
        $today = date('Y-m-d H:i:s');
        $logQuery = "Update EqManage.log set returnDate = '$today' where checkoutRequests_id = '$checkoutRequestsID'";
        if (mysqli_query($db, $logQuery)) {
            echo "Successfully updated table";
        } else {
            echo mysqli_error($db);
        }
        $query = mysqli_query($db,"Select * from EqManage.requests where id='$checkoutRequestsID'");
        while ($row = mysqli_fetch_array($query)) {
            $totalReturnQty = $row['checkoutQty'];
            $eqID = $row['equipment_id'];
        }
        $equipmentUpdateQuery = "UPDATE EqManage.equipment set leftQuantity = leftQuantity + '$totalReturnQty' where id = '$eqID'";

        if (mysqli_query($db, $equipmentUpdateQuery)) {
            echo "Successfully updated table";
        } else {
            echo mysqli_error($db);
        }
    }

}
