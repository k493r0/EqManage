<?php
include('serverconnect.php');
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
        $string1 = $_SERVER['QUERY_STRING'];
        $string2 = str_replace("hash=","",$string1);
        echo $string2;

        $query = "UPDATE EqManage.requests SET Active='1' WHERE Hash='$string2'";
        mysqli_query($db,$query);


        $request_query = "Select * from EqManage.requests where Hash='$string2'";
        $result = mysqli_query($db,$request_query);
        $request = mysqli_fetch_assoc($result);
//        echo $request['equipment_id'];
//        $request_independent = $request['Equipment'];
//        echo $request_independent;
//        $user_independent = $request['User'];
//        $notes_independent = $request['Notes'];

        $equipment_id = $request['equipment_id'];
        $users_id = $request['users_id'];
        $note = $request['note'];
        $checkoutRequest_id = $request['id'];
        $expectedReturnDate = $request['expectedReturnDate'];
        $date = date('Y-m-d H:i:s');

        $minusQty = 1;



        $log_query = "INSERT into EqManage.log (checkoutRequests_id, equipment_id,users_id,notes,checkoutDate,expectedReturnDate) values ('$checkoutRequest_id','$equipment_id','$users_id','$note','$date', '$expectedReturnDate')";


if (mysqli_query($db, $log_query)) {
    $last_id = mysqli_insert_id($db);
    echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
    echo "Error: " . $log_query . "<br>" . mysqli_error($db);
}

//        mysqli_query($db,$log_query);
$checkQty = "Select * from EqManage.equipment where id = '$equipment_id'";
mysqli_query($db,$checkQty);
$checkQtyArray = mysqli_fetch_assoc($result);
$leftQty = $checkQtyArray['leftQuantity'];
$newleftQty = $leftQty - $minusQty;




$updateEq_query = "UPDATE EqManage.equipment SET availability=0,users_id='$users_id',lastLog_id='$last_id',leftQuantity='$newleftQty' WHERE id='$equipment_id'";

        mysqli_query($db,$updateEq_query);


//        header('Location: new_index.php?check-out=1');