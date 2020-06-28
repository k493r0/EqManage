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

    $QtyArray = array();
    $totalReturnQty = 0;
    $query = "";




    if ($requestOption == 0) {
        $query = "UPDATE EqManage.log set returnDate = '$today' where users_id = '$userID' AND checkoutDate IS NOT NULL AND returnDate IS NULL AND equipment_id = '$eqID'";

        $getCheckoutQty = mysqli_query($db,"select * from EqManage.log l left join requests r on l.checkoutRequests_id = r.id where l.users_id = '$userID' AND l.checkoutDate IS NOT NULL AND l.returnDate IS NULL AND l.equipment_id = '$eqID'");

        while ($row = mysqli_fetch_array($getCheckoutQty)){
            array_push($QtyArray,$row['checkoutQty']);
        };

        foreach ($QtyArray as $Qty){
            $totalReturnQty += $Qty;
        }
        $equipmentUpdateQuery = "UPDATE EqManage.equipment set leftQuantity = leftQuantity + '$totalReturnQty' where id = '$eqID'";

    } else {
        $query = "UPDATE EqManage.log set returnDate = '$today' where checkoutRequests_id = '$requestOption'";
        $getCheckoutQty = mysqli_query($db,"SELECT * FROM EqManage.log l left join requests r on l.checkoutRequests_id = r.id where checkoutRequests_id = '$requestOption'");
        while ($row = mysqli_fetch_array($getCheckoutQty)){
            $totalReturnQty = $row['checkoutQty'];
        }
        $equipmentUpdateQuery = "UPDATE EqManage.equipment set leftQuantity = leftQuantity + '$totalReturnQty' where id = '$eqID'";
    }

    $updateAvailability = "Update EqManage.equipment set availability = 1 where id = '$eqID'"; //It will always be available after return

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

    if (mysqli_query($db, $updateAvailability)) {
        echo "Successfully updated table";
    } else {
        echo mysqli_error($db);
    }


}
