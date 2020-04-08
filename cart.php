<?php
$test = array("eqID" => '5', "qty" => '6');
$eqID = 4;
$qty = 3;
$_SESSION['cart'] = array(array("eqID" => $eqID, "qty" => $qty));
array_push($_SESSION['cart'], $test);


//foreach ($_SESSION['cart'] as $temp){
//    echo $temp['eqID'];
//}

$max=sizeof($_SESSION['cart']);
//echo $max;
for($i=0; $i<$max; $i++) {

    while (list ($key, $val) = each ($_SESSION['cart'][$i])) {
        echo "$key -> $val ,";
    } // inner array while loop
    echo "<br>";
} // outer array for loop