<?php
include('serverconnect.php');

$result = mysqli_query($db,"select distinct e.equipment, e.barcodeID, e.id
from equipment e
inner join log l
on e.id = l.equipment_id
where l.returnDate IS NULL and l.checkoutDate IS NULL");

echo "<option value=\"\">Select equipment</option>";

while ($row = mysqli_fetch_array($result)){

    echo $row['equipment_id'];
    $equipmentName = $row['equipment'];
    $equipmentID = $row['id'];
    $barcodeID = $row['barcodeID'];
    echo "<option value='$equipmentID' data-checkoutRequestsID='$equipmentID'>$barcodeID | $equipmentName </option>";



};