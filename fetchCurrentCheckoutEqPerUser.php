<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}
include('serverconnect.php');

$query = mysqli_query($db,"select * from EqManage.log l
left join equipment e on l.equipment_id = e.id
where l.users_id = $userID and returnDate is null ");


$NumberCheckedOut = mysqli_num_rows($query);


echo "<h3 class=\"card-title\">Currently Checked Out:</h3>";
echo  "<ul style='margin-bottom: 0px'>";

while ($row = mysqli_fetch_array($query)) {
    echo "<li class=\"card-category\" style=\"padding-bottom: 0px; margin-bottom: 0px\"><a href='idsearch.php?logid=", $row['id'] ,"'>", $row['equipment'], " | ";
}
echo "</a></ul>";
if (mysqli_num_rows($query) == null){
    $NumberCheckedOut = 0;
    echo "-";
}
