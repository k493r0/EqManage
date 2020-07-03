<?php
include('serverconnect.php');
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}

$hash = $_POST['hash'];
$referer = $_POST['referer'];
$today = date("Y-m-d H:i:s");
if ($result = mysqli_query($db, "Select * from EqManage.requests where hash='$hash'")){
    $numRows = mysqli_num_rows($result);
    if ($numRows > 1){
        if (isset($_POST['accept'])) {
            $query = "UPDATE EqManage.requests SET active='1',state='approved' WHERE hash='$hash'";
            mysqli_query($db, $query);
            
            $query = mysqli_query($db, "select * from EqManage.requests where hash = '$hash'");
            while ($row = mysqli_fetch_array($query)) {
                $eqID = $row['equipment_id'];
                $userID = $row['users_id'];
                $checkoutRequest_id = $row['id'];
                $returnDate = $row['expectedReturnDate'];
                $date = date('Y-m-d H:i:s');
                $log_query = "INSERT into EqManage.log (checkoutRequests_id, equipment_id,users_id,checkoutRequestDate,expectedReturnDate) values ('$checkoutRequest_id','$eqID','$userID','$date','$returnDate')";
                if (mysqli_query($db, $log_query)) {
                    $last_id = mysqli_insert_id($db);
                    echo "Log updated. Last inserted ID is: " . $last_id;
                } else {
                    echo "Error: " . $log_query . "<br>" . mysqli_error($db);
                }

            }

            $notif_query = "INSERT into EqManage.notification (message,target,status,datetime) values ('Your checkout request was accepted','$userID',0, '$today')";
            if (mysqli_query($db, $notif_query)) {
                $last_id = mysqli_insert_id($db);
                echo "Notification updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $notif_query . "<br>" . mysqli_error($db);
            }

        }elseif (isset($_POST['reject'])){
            $userID = "";
            $query = mysqli_query($db, "select * from EqManage.requests where hash = '$hash'");
            while ($row = mysqli_fetch_array($query)) {
                $checkoutQty = $row['checkoutQty'];
                $eqID = $row['equipment_id'];
                $userID = $row['users_id'];
                $updateEquipment = "UPDATE EqManage.equipment SET leftQuantity = leftQuantity + '$checkoutQty' where id = '$eqID'"; //Put back the checked out quantity
                $updateAvailability = "Update EqManage.equipment set availability = 1 where id = '$equipment_id'";
                mysqli_query($db,$updateAvailability);
                mysqli_query($db, $updateEquipment);
            }
            $updateRequest = "UPDATE EqManage.requests SET state='rejected' WHERE hash='$hash'";
             //It will always be available
            mysqli_query($db, $updateRequest);

            echo $hash;

            echo "rejected";

            $notif_query = "INSERT into EqManage.notification (message,target,status,datetime) values ('Your checkout request was rejected','$userID',0, '$today')";
            if (mysqli_query($db, $notif_query)) {
                $last_id = mysqli_insert_id($db);
                echo "Notification updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $notif_query . "<br>" . mysqli_error($db);
            }
        }

    } else{
        if (isset($_POST['accept'])){
            $query = "UPDATE EqManage.requests SET active='1',state='approved' WHERE hash='$hash'";
            mysqli_query($db, $query);
            
            $query = mysqli_query($db, "select * from EqManage.requests where hash = '$hash'");
            while ($row = mysqli_fetch_array($query)) {
                $eqID = $row['equipment_id'];
                $userID = $row['users_id'];
                $checkoutRequest_id = $row['id'];
                $returnDate = $row['expectedReturnDate'];
            }
            $date = date('Y-m-d H:i:s');
            $log_query = "INSERT into EqManage.log (checkoutRequests_id, equipment_id,users_id,checkoutRequestDate,expectedReturnDate) values ('$checkoutRequest_id','$eqID','$userID','$date','$returnDate')";
            if (mysqli_query($db, $log_query)) {
                $last_id = mysqli_insert_id($db);
                echo "Log updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $log_query . "<br>" . mysqli_error($db);
            }

            $notif_query = "INSERT into EqManage.notification (message,target,status,datetime) values ('Your checkout request was accepted','$userID',0, '$today')";
            if (mysqli_query($db, $notif_query)) {
                $last_id = mysqli_insert_id($db);
                echo "Notification updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $notif_query . "<br>" . mysqli_error($db);
            }

        } elseif (isset($_POST['reject'])){
            $query = mysqli_query($db, "select * from EqManage.requests where hash = '$hash'");
            while ($row = mysqli_fetch_array($query)) {
                $eqID = $row['equipment_id'];
                $checkoutQty = $row['checkoutQty'];
                $userID = $row['users_id'];
            }
            
            $updateRequest = "UPDATE EqManage.requests SET state='rejected' WHERE hash='$hash'";
            $updateEquipment = "UPDATE EqManage.equipment SET leftQuantity = leftQuantity + '$checkoutQty' where id = '$eqID'";
            $updateAvailability = "Update EqManage.equipment set availability = 1 where id = '$eqID'"; //It will always be available
            mysqli_query($db, $updateRequest);
            mysqli_query($db, $updateEquipment);
            mysqli_query($db,$updateAvailability);
            echo $hash;
            echo "rejected";

            $notif_query = "INSERT into EqManage.notification (message,target,status,datetime) values ('Your checkout request was rejected','$userID',0, '$today')";
            if (mysqli_query($db, $notif_query)) {
                $last_id = mysqli_insert_id($db);
                echo "Notification updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $notif_query . "<br>" . mysqli_error($db);
            }
        }
    }
}
$headerRefer = substr($referer,strrpos($referer,'/') + 1);
echo $headerRefer;

if ($referer != null){
    header("Location: $headerRefer?verify=1" );
} elseif ($referer == null){
    header('Location: new_index.php?verify=1');
} else header('Location: new_index.php');



