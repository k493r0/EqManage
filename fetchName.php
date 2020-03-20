<?php
$equipmentID = 20;
$result = mysqli_query($db,"Select *
from users u
left join log l on u.id = l.users_id
left join equipment e on l.equipment_id = e.id
where e.id = '$equipmentID' and l.returnDate IS NULL");

while ($row = mysqli_fetch_array($result)){

    echo $row['equipment_id'];
    $equipmentName = $row['equipment'];
    $equipmentID = $row['id'];
    $barcodeID = $row['barcodeID'];
    $fullname = $row['fullname'];
    echo "<option value='$equipmentID' data-checkoutRequestsID='$equipmentID'>$fullname | $equipmentName </option>";

}; ?>