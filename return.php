<?php
session_start();
if(!isset($_SESSION['loggedin'])){
header('Location: index.php');
exit();
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

<?php include('navbar.php'); ?>

<div class="content">
    <div>
        <h2>Return</h2>

        <p>
            <?php
            include('serverconnect.php');
            $name = $_SESSION['name'];
            $user_id = $_SESSION['id'];
            $resultset = mysqli_query($db, "
SELECT l.expectedReturnDate, l.users_id,E.id, E.equipment, E.leftQuantity, E.availability, l.returnDate, R.checkoutQty, l.checkoutRequests_id, l.checkoutDate
FROM EqManage.log l
         LEFT JOIN EqManage.equipment E ON l.equipment_id=E.id
         LEFT JOIN EqManage.requests R on l.checkoutRequests_id = R.id
where l.returnDate IS NULL and l.checkoutDate IS NOT NULL
GROUP BY l.id,E.id
"); //Fetch all checkedout equipments
            echo $user_id;
//            wh
            //ile ($row = mysqli_fetch_array($resultset)){
//                if($row['users_id'] = $user_id){
//                    echo $row['equipment_id'];
//                    $equipmentName = $row['equipment'];
//                    $equipmentID = $row['equipment_id'];
//                    echo "<option value='$equipmentID' >$equipment</option>";
//                }
//
//
//
//            }


            ?>
        <div class="select-style" style="width:500px; margin: auto">
            <form action="confirmation.php" style="width: 100%;" method="POST">
                <select name="equipment" class="select-picker" onchange="getID(this)">
                    <option value=""  disabled selected>Select the Equipment</option> <!-- TODO Add support for multiple checkout&return, fix the return system, might have to record the borrwed quantity in log-->
                    <?php
                    while ($row = mysqli_fetch_array($resultset)){
                        if($row['users_id'] = $user_id){
                            echo $row['equipment_id'];
                            $equipmentName = $row['equipment'];
                            $equipmentID = $row['equipment_id'];
                            $checkoutRequestsID = $row['checkoutRequests_id'];
                            $checkoutQty = $row['checkoutQty'];
                            $checkoutDate = $row['checkoutDate'];
                            $checkoutDateExplode = explode(" ", $checkoutDate);
                            $expectedReturnDate = $row['expectedReturnDate'];
                            $expectedReturnDateEx = explode(" ", $expectedReturnDate);
                            $today = date("Y-m-d H:i:s");
                            $todayExplode = explode(" ", $today);
                            echo $checkoutRequestsID;
                            echo "<option value='$equipmentID' data-checkoutRequestsID='$checkoutRequestsID'>";
                            if (strtotime($expectedReturnDateEx[0]) < strtotime($todayExplode[0])){
                                echo "[Overdue] ";
                            }
                            echo "$equipmentName | $checkoutQty Borrowing";
                            if (strtotime($expectedReturnDateEx[0]) >= strtotime($todayExplode[0])){
                                echo " | Due: ", $expectedReturnDateEx[0];
                            }

                            echo "</option>";
                        }



                    }
                    ?>
                </select>
                <input type="hidden" id="checkoutRequestsID" name="checkoutRequestsID" value="">
                <input name="request" type="submit" value="Return" style="width: 100%; margin-top: 20px">
            </form>
        </div>
        </p>

    </div>

</div>
<script>
    function getID(id) {
        id = id.options[id.selectedIndex].getAttribute('data-checkoutRequestsID');
        console.log(id);
        document.getElementById("checkoutRequestsID").setAttribute("value",id);

    }
</script>
