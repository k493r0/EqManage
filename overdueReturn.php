<?php
include('serverconnect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $rqID = $_POST['id'];
    $query = mysqli_query($db, "select * from EqManage.requests left join EqManage.equipment on requests.equipment_id = equipment.id left join users u on requests.users_id = u.id where requests.id = '$rqID'");
    while ($row = mysqli_fetch_array($query)) {
        $eqname = $row['equipment'];
        $username = $row['fullname'];
        $qty = $row['checkoutQty'];
        $rqDate = $row['requestDate'];
        $returnDate = $row['expectedReturnDate'];
        $purpose = $row['purpose'];
        $location = $row['location'];
    }


    echo "<h5 style=\"font-weight: bolder\">User: </h5>
        <h5>".$username."</h5>
        <h5 style=\"font-weight: bolder\">Equipment: </h5>
        <h5>".$eqname."</h5>
        <h5 style=\"font-weight: bolder\">Quantity: </h5>
        <h5 >".$qty."</h5>
        <h5 style=\"font-weight: bolder\">Purpose: </h5>
        <h5>".$purpose."</h5>
        <h5 style=\"font-weight: bolder\">Location: </h5>
        <h5>".$location."</h5>
        <h5 style=\"font-weight: bolder\">Checkout Date: </h5>
        <h5>".$rqDate."</h5>
        <h5 style=\"font-weight: bolder\">Expected Return Date: </h5>
        <h5>".$returnDate."</h5>";

    echo '<input id="overdueReturn" name="return" type="submit" value="Confirm Return" onclick="overdueReturn('.$rqID.')" style="width: 100%;">';

}


