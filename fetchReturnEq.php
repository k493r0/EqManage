<?php
$returnResult = mysqli_query($db,"select distinct e.equipment, e.barcodeID, e.id
from equipment e
inner join log l
on e.id = l.equipment_id
where l.returnDate IS NULL AND l.checkoutDate IS NOT NULL");

while ($row = mysqli_fetch_array($returnResult)){

echo "<option value=\"\">Select equipment</option>";

echo $row['equipment_id'];
$equipmentName = $row['equipment'];
$equipmentID = $row['id'];
$barcodeID = $row['barcodeID'];
echo "<option value='$equipmentID' data-checkoutRequestsID='$equipmentID'>$barcodeID | $equipmentName </option>";

};

?>