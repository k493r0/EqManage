<?php
include('serverconnect.php');
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}



        $string2 = $_POST['hash'];

if (isset($_POST['accept'])) {

    echo $string2;

    $query = "UPDATE EqManage.requests SET active='1',state='approved' WHERE hash='$string2'";
    mysqli_query($db, $query);


    $request_query = "Select * from EqManage.requests where hash='$string2'";
    $result = mysqli_query($db, $request_query);
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

    $checkoutQty = $request['checkoutQty'];


    $log_query = "INSERT into EqManage.log (checkoutRequests_id, equipment_id,users_id,notes,checkoutDate,expectedReturnDate) values ('$checkoutRequest_id','$equipment_id','$users_id','$note','$date', '$expectedReturnDate')";


    if (mysqli_query($db, $log_query)) {
        $last_id = mysqli_insert_id($db);
        echo "Log updated. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $log_query . "<br>" . mysqli_error($db);
    }

//        mysqli_query($db,$log_query);
    echo "equipment id:", $equipment_id;
    $checkQty = "Select * from EqManage.equipment where id = '$equipment_id'";
    $result2 = mysqli_query($db, $checkQty);
    $checkQtyArray = mysqli_fetch_assoc($result2);

    $leftQty = $checkQtyArray['leftQuantity'];
    echo "left qty: ", $leftQty, "------";
    $newleftQty = $leftQty - $checkoutQty;
    echo $newleftQty;
    if ($newleftQty <= 0) {
        $updateEq_query = "UPDATE EqManage.equipment SET availability=0,users_id='$users_id',lastLog_id='$last_id',leftQuantity='$newleftQty' WHERE id='$equipment_id'";
    } else $updateEq_query = "UPDATE EqManage.equipment SET users_id='$users_id',lastLog_id='$last_id',leftQuantity='$newleftQty' WHERE id='$equipment_id'";


    mysqli_query($db, $updateEq_query);

} elseif (isset($_POST['reject'])){

    $updateEq_query = "UPDATE EqManage.requests SET state='rejected' WHERE hash='$string2'";
    mysqli_query($db, $updateEq_query);
    echo $string2;
    echo "rejected";

}

//        header('Location: new_index.php?check-out=1');