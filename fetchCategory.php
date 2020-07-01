<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}

include ("serverconnect.php");

$categoryid = $_POST['categoryID'];

$query = "SELECT * FROM EqManage.categories WHERE id=".$categoryid;

$result = mysqli_query($db,$query);

$html = '<div>';
while($row = mysqli_fetch_array($result)){
    $name = $row['categoryName'];

    $html .= "<span class='head'>Category Name : </span><span>".$name."</span><br/>";

}
$html .= '</div>';

echo $html;
