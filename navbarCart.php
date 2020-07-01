<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
include('serverconnect.php');
//$_SESSION['cart'] = array(array());
//    $addEqID = $_POST['eqID'];
//    $addQty = $_POST['qty'];
//    $addArray = array("eqID" => '1', "qty" => '1');
//    array_push($_SESSION['cart'], $addArray);
//    if (isset($_SESSION['cart'])){
//        array_push($_SESSION['cart'], $addArray);
//        echo "cart exists";
//    } else{
//        $_SESSION['cart'] = array(array());
//        array_push($_SESSION['cart'], $addArray);
//        echo "cart does not exist";
//    }

//print_r($_SESSION['cart']);
//$_SESSION['cart'] = array(array());
//$test = array("eqID" => '24', "qty" => '6');
//array_push($_SESSION['cart'], $test);
//$test2 = array("eqID" => '22', "qty" => '8');
//array_push($_SESSION['cart'], $test2);
//
//$test3 = array("eqID" => '2', "qty" => '1');
//array_push($_SESSION['cart'], $test3);

//echo $max;
$addEqID = $_POST['eqID'];
$addQty = $_POST['qty'];
//echo $addEqID;
//echo $addQty;
//unset($_SESSION['cart']);

//$_SESSION['cart'] = array(array("id" => "20", "qty" => "1"));
//array_push($_SESSION['cart'],array("id" => "$addEqID", "qty" => "$addQty"));

//print_r($_SESSION['cart']);

foreach ($_SESSION['cart'] as $i){
//    echo "eqID: ".$i['id'];
//    echo "Quantity: ".$i['qty'];
}



if (isset($_POST['eqID']) && isset($_POST['qty']) && empty($_POST['destroy_cart']) && empty($_POST['delete']) && empty($_POST['update'])){
    $addEqID = $_POST['eqID'];
    $addQty = $_POST['qty'];

    if (isset($_SESSION['cart'])){ //Cart already exists
        $index = 0;
        $oldQty = 0;
        $exists = false;
        $leftQty = 0;

        $prequery = "SELECT * FROM EqManage.equipment where id = '$addEqID'";
        $queryEq = mysqli_query($db, $prequery);
        while ($row = mysqli_fetch_array($queryEq)) {
            $leftQty = $row['leftQuantity'];
        }

        foreach ($_SESSION['cart'] as $i){
            if ($i['id'] == $addEqID){
                $oldQty = $i['qty'];
                $addQty += $oldQty;
                if ($addQty > $leftQty){
                    $addQty = $leftQty; //Anything bigger than leftQty will be reduced down to the maximum borrowable number
                }
                $_SESSION['cart'][$index]['qty'] = $addQty;
                $exists = true;
            } else{$exists = false;};
            $index++;
        };

//        print_r($_SESSION['cart']);

        if ($exists == false) {
            array_push($_SESSION['cart'], array("id" => "$addEqID", "qty" => "$addQty")); //if cart already exists, add more equipment in the array
        }

    } else{
        $_SESSION['cart'] = array(array("id" => "$addEqID", "qty" => "$addQty"));
    }
} elseif (isset($_POST['destroy_cart']) && $_POST['destroy_cart'] == 1){
    unset($_SESSION['cart']);
} elseif (isset($_POST['delete']) && isset($_POST['eqID']) && $_POST['delete'] == 1){
    $tempArray = $_SESSION['cart'];

    $eqID = $_POST['eqID'];
    $i=0;
//    echo $eqID;
    foreach ($_SESSION['cart'] as $cart){
//        print_r($tempArray);
        if ($cart['id'] == $eqID){
            unset($tempArray[$i]);
        }
        $i++;
    }
    $newArray = array_values($tempArray);
    $_SESSION['cart'] = $newArray;
} elseif (isset($_POST['update']) && isset($_POST['qty']) && isset($_POST['eqID']) && $_POST['update'] == "1"){
    $targetEqID = $_POST['eqID'];
//    echo $targetEqID;
    $replaceQty = $_POST['qty'];
//    echo $replaceQty;
    $leftQty = 0;
    $index = 0;

    $prequery = "SELECT * FROM EqManage.equipment where id = '$targetEqID'";
    $queryEq = mysqli_query($db, $prequery);
    while ($row = mysqli_fetch_array($queryEq)) {
        $leftQty = $row['leftQuantity'];
    }

    foreach ($_SESSION['cart'] as $i){
        if ($i['id'] == $targetEqID){
            if ($replaceQty > $leftQty){
                $replaceQty = $leftQty; //Anything bigger than leftQty will be reduced down to the maximum borrowable number
            }
            $_SESSION['cart'][$index]['qty'] = $replaceQty;
        }
        $index++;
    };


}


$max=sizeof($_SESSION['cart']);
//echo "test";
//echo $max;


echo "<div class=\"row total-header-section\">
                <h2 style='font-weight: bold; font-size: 25px; margin-left: 5%'>Cart</h2><p style='font-weight: lighter;color: grey; margin-left:auto; margin-right: 5%'>".$max." Equipment Added</p>
        </div>
                
                ";


foreach ($_SESSION['cart'] as $i) {

    $eqID = $i['id'];
    $qty = $i['qty'];
    $eqName = "";
//echo $eqID;
//echo $qty;
    $prequery = "SELECT * FROM EqManage.equipment e left join categories c on e.category = c.id where e.id=".$eqID;
//    echo $prequery;
    $queryEq = mysqli_query($db, $prequery);
//    echo $eqID;
//    echo "Hello";

    while ($row = mysqli_fetch_array($queryEq)) {
        echo "<div class='row cart-detail'>";

        echo "<div class='col-lg-4 col-sm-4 col-4 cart-detail-img' id='imgContainer'>";
        echo "<img src=\"assets/images/icon1.jpeg\">";
        echo "</div>";
        echo "<div class='col-lg-8 col-sm-8 col-8 cart-detail-product'>";

        echo "<span class='price text-info'>" . $row["categoryName"] . "</span> <h3 class='name' style='font-weight: bold; font-size: 20px; margin-bottom: 0;'>" . $row['equipment'] . "</h3>";
        echo "<span class='count'> Quantity: </span><input id='cartInput' type='number' min='1' max=".$row['leftQuantity']." name='quantity' id=".$row['id']."_qty"." value='$qty' style='margin-bottom: 10px' onchange='updateQty($eqID,this.value)'/>";
        echo "<button class='btn btn-danger btn-block' style='display: inline-block; padding-left: 5px; font-size: 12px' onclick='deleteItem($eqID)'>Delete</button>
                </div>
                </div><hr>";

    }
}



//    while (list ($key, $val) = each ($_SESSION['cart'][$i])) {
//
//
//
//
//
//    } // inner array while loop



 // outer array for loop

$in2 = findEqIndex(7);






//echo $_SESSION['cart'][1]['qty']; // This will get the eqID of the first row
//$newEq = array("eqID" => '20', "qty", '1');
//$max=sizeof($_SESSION['cart']);
//$eqID = 7;
//for ($i=0; $i<$max; $i++){
//    echo $_SESSION['cart'][$i]['eqID'];
//
//    if ($_SESSION['cart'][$i]['eqID'] == $eqID){
//        $_SESSION['cart'][$i]['qty']++;
//        echo $_SESSION['cart'][$i]['qty'];
//    }
//}
//
//$max=sizeof($_SESSION['cart']);
//echo $max;
//
//for($i=0; $i<$max; $i++) {
//
//    while (list ($key, $val) = each ($_SESSION['cart'][$i])) {
//        echo "$key -> $val ,";
//    } // inner array while loop
//    echo "<br>";
//} // outer array for loop
//if (isset($_POST['cartID'])){
//    $eqID = $_POST['cartID'];
//    $qty = $_POST['cartQty'];
//
//    $max=sizeof($_SESSION['cart']);
//
//    for ($i=0; $i<$max; $i++){
//        echo $_SESSION['cart'][$i]['eqID'];
//    }
//
//
//    foreach ($_SESSION['cart'] as $cart){
////        echo $cart['eqID'];
//        if (!empty($_SESSION['cart'])){
//            if ($cart['eqID'] == $eqID){
//                $_SESSION['cart'][$cart]['qty']++;
//            }
//        }
//
//
//    }
//
//
//}

function findEqIndex($eqID){
    $max=sizeof($_SESSION['cart']);
    $index = -1;
    for ($i=0; $i<$max; $i++){
        if ($_SESSION['cart'][$i]['eqID'] == $eqID){
            $index = $i;
            echo "found";
            echo $index;
        }
    }

    if ($index != null){
        return $index;
    } else return null;
}

?>

