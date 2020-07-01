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
?>
<!DOCTYPE html>
<html>
<?php
include('header.php')
?>

<body class="form-v8 loggedin" id="fade">

<div id="loader">
    <div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php
if ($_SESSION['username'] == 'administrator'){
    include ('adminNavbar.php');
} else{
    include ('navbar.php');
}

?>

<div class="content">
    <div style="padding-top: 0; margin-top: 7%">
        <h2>Confirmation</h2>

            <?php

            include('serverconnect.php');

            $user = "";
            $equipment = "";
            $referer = $_SERVER["HTTP_REFERER"]; //shows where postverify.php was visited from, can't carry this over two pages so it is stored in a variable
//            echo $referer;
            $hash = $_GET['hash'];
//            echo $hash;





            ?>
        <table width="100%" id="table">
            <thead>
            <tr>
                <th scope="col">User</th>
                <th scope="col">Equipment</th>
                <th scope="col">Quantity</th>
                <th scope="col">Location</th>
                <th scope="col">Purpose</th>
                <th scope="col">Expected Return Date</th>
            </tr>
            </thead>
            <tbody id="cartTable">

                <?php

                $query = mysqli_query($db, "select * from EqManage.requests left join equipment e on requests.equipment_id = e.id left join users u on requests.users_id = u.id where requests.hash= '$hash'");
                while ($row = mysqli_fetch_array($query)) {
                    $eqname = $row['equipment'];
                    $qty = $row['checkoutQty'];
                    $returnDate = $row['expectedReturnDate'];
                    $username = $row['fullname'];
                    $location = $row['location'];
                    $purpose = $row['purpose'];

                    ?>
                    <tr>
                        <td><?php echo $username ?></td>
                        <td><?php echo $eqname ?></td>
                        <td><?php echo $qty ?></td>
                        <td><?php echo $location ?></td>
                        <td><?php echo $purpose ?></td>
                        <td><?php echo $returnDate ?></td>
                    </tr>


                    <?php
                }


                ?>

            </tbody>
        </table>

        <h3 style="text-align: center; margin-top: 40px"><b>Do you accept or reject the request?</b></h3>
        <form method="post" action="verify.php" style="display:flex">
            <input type="hidden" name="hash" value="<?php echo $hash ?>">
            <input type="hidden" name="referer" value="<?php echo $referer ?>">


<!--            <input name="accept" type="submit" value="Accept" style="width: 100%; margin: 20px" onclick="">-->
<!--            <input name="reject" type="submit" value="Reject" style="width: 100%; margin: 20px">-->

            <button class="btn btn-primary btn-block" name="accept" type="submit" value="Accept" style="margin: 10px;">Accept</button>
            <button class="btn btn-danger btn-block" name="reject" type="submit" value="Reject" style="margin: 10px">Reject</button>



        </form>

    </div>

</div>

<?php


//        $string1 = $_SERVER['QUERY_STRING'];
//        $string2 = str_replace("hash=","",$string1);
//        echo $string2;
//
//        $query = "UPDATE EqManage.requests SET active='1',state='approved' WHERE hash='$string2'";
//        mysqli_query($db,$query);
//
//
//        $request_query = "Select * from EqManage.requests where hash='$string2'";
//        $result = mysqli_query($db,$request_query);
//        $request = mysqli_fetch_assoc($result);
////        echo $request['equipment_id'];
////        $request_independent = $request['Equipment'];
////        echo $request_independent;
////        $user_independent = $request['User'];
////        $notes_independent = $request['Notes'];
//
//        $equipment_id = $request['equipment_id'];
//        $users_id = $request['users_id'];
//        $note = $request['note'];
//        $checkoutRequest_id = $request['id'];
//        $expectedReturnDate = $request['expectedReturnDate'];
//        $date = date('Y-m-d H:i:s');
//
//        $checkoutQty = $request['checkoutQty'];
//
//
//        $log_query = "INSERT into EqManage.log (checkoutRequests_id, equipment_id,users_id,notes,checkoutDate,expectedReturnDate) values ('$checkoutRequest_id','$equipment_id','$users_id','$note','$date', '$expectedReturnDate')";
//
//
//if (mysqli_query($db, $log_query)) {
//    $last_id = mysqli_insert_id($db);
//    echo "Log updated. Last inserted ID is: " . $last_id;
//} else {
//    echo "Error: " . $log_query . "<br>" . mysqli_error($db);
//}
//
////        mysqli_query($db,$log_query);
//echo "equipment id:",$equipment_id;
//$checkQty = "Select * from EqManage.equipment where id = '$equipment_id'";
//$result2 = mysqli_query($db,$checkQty);
//$checkQtyArray = mysqli_fetch_assoc($result2);
//
//$leftQty = $checkQtyArray['leftQuantity'];
//echo "left qty: ", $leftQty, "------";
//echo $minusQty;
//$newleftQty = $leftQty - $checkoutQty;
//echo $newleftQty;
//if ($newleftQty<=0){
//    $updateEq_query = "UPDATE EqManage.equipment SET availability=0,users_id='$users_id',lastLog_id='$last_id',leftQuantity='$newleftQty' WHERE id='$equipment_id'";
//} else $updateEq_query = "UPDATE EqManage.equipment SET users_id='$users_id',lastLog_id='$last_id',leftQuantity='$newleftQty' WHERE id='$equipment_id'";
//
//
//        mysqli_query($db,$updateEq_query);


//        header('Location: new_index.php?check-out=1');
