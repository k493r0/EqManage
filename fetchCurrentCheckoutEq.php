<?php
include('serverconnect.php');

$query = mysqli_query($db,"select e.equipment, u.fullname, l.id
from log l
left join equipment e on e.id = l.equipment_id
left join users u on l.users_id = u.id
where l.checkoutDate IS NOT NULL AND l.returnDate IS NULL");


$NumberCheckedOut = mysqli_num_rows($query);
if (mysqli_num_rows($query) == null){
    $NumberCheckedOut = 0;
}

echo "<h4 class=\"card-title\">Currently Checked Out: ", $NumberCheckedOut,"</h4>";
echo "<ul style='margin-bottom: 0px'>";

while ($row = mysqli_fetch_array($query)) {
    echo "<li class=\"card-category\" style=\"padding-bottom: 0px; margin-bottom: 0px\"><a href='search.php?type=3&id=", $row['id'] ,"'>", $row['equipment'], " | ", $row['fullname'];
}
echo "</a></ul>";