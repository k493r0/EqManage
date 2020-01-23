<?php

include ("serverconnect.php");

$categoryid = $_POST['category_id'];

$query = "SELECT * FROM EqManage.categories WHERE id=".$categoryid;

$result = mysqli_query($db,$query);

$html = '<div>';
while($row = mysqli_fetch_array($result)){
    $name = $row['categoryName'];

    $html .= "<span class='head'>Category Name : </span><span>".$name."</span><br/>";

}
$html .= '</div>';

echo $html;