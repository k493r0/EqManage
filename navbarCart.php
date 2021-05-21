<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
include('serverconnect.php');

$addEqID = $_POST['eqID'];
$addQty = $_POST['qty'];

if (isset($_POST['eqID']) && isset($_POST['qty']) && empty($_POST['destroy_cart']) && empty($_POST['delete']) && empty($_POST['update'])){
    //When 'add to cart' action is called
    $addEqID = $_POST['eqID'];
    $addQty = $_POST['qty'];
    if (isset($_SESSION['cart'])){ //If cart already exists
        $index = 0;
        $oldQty = 0;
        $exists = 0;
        $leftQty = 0;

        $prequery = "SELECT * FROM EqManage.equipment where id = '$addEqID'";
        $queryEq = mysqli_query($db, $prequery);
        while ($row = mysqli_fetch_array($queryEq)) {
            $leftQty = $row['leftQuantity']; //Storing the left quantity of the selected equipment into a variable
        }
        foreach ($_SESSION['cart'] as $i){//Scan if equipment exists in the cart
            if ($i['id'] == $addEqID){
                $exists = 1;
                $oldQty = $i['qty'];
                $addQty += $oldQty;
                if ($addQty > $leftQty){
                    $addQty = $leftQty; //Anything bigger than leftQty will be reduced down to the largest possible number (stock)
                }
                $_SESSION['cart'][$index]['qty'] = $addQty;//Overwrite the quantity of the selected equipment with addQty
                if ($exists == 1){
                    break;
                }
            } elseif ($i['id'] != $addEqID){ //Equipment not found in cart
                $exists = 0;
            };
            $index++;
        };
        if ($exists == 0) {//If cart exists but equipment was not found in cart
            array_push($_SESSION['cart'], array("id" => "$addEqID", "qty" => "$addQty")); //Pushing array of new equipment into cart array
        }

    } else{//When cart does not exist
        $_SESSION['cart'] = array(array("id" => "$addEqID", "qty" => "$addQty"));//Creates new cart session with two dimensional array and add equipment array
    }
} elseif (isset($_POST['destroy_cart']) && $_POST['destroy_cart'] == 1){//Clear cart selected
    unset($_SESSION['cart']); //Delete cart SESSION
} elseif (isset($_POST['delete']) && isset($_POST['eqID']) && $_POST['delete'] == 1){//If delete action called
    $tempArray = $_SESSION['cart'];//Copying whole cart array to temporary variable
    $eqID = $_POST['eqID'];
    $i=0;
    foreach ($_SESSION['cart'] as $cart){
        if ($cart['id'] == $eqID){//If equipment found in cart
            unset($tempArray[$i]);//Remove item where eqID equals to the equipment selected
        }
        $i++;
    }
    $newArray = array_values($tempArray); //Returns an indexed array of values
    $_SESSION['cart'] = $newArray;
} elseif (isset($_POST['update']) && isset($_POST['qty']) && isset($_POST['eqID']) && $_POST['update'] == "1"){//If update action called
    $targetEqID = $_POST['eqID'];
    $replaceQty = $_POST['qty'];
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
echo "<div class=\"row total-header-section\">
                <h2 style='font-weight: bold; font-size: 25px; margin-left: 5%'>Cart</h2><p style='font-weight: lighter;color: grey; margin-left:auto; margin-right: 5%'>".$max." Equipment Added</p>
        </div>
                
                ";
foreach ($_SESSION['cart'] as $i) {
    $eqID = $i['id'];
    $qty = $i['qty'];
    $eqName = "";
    $prequery = "SELECT * FROM EqManage.equipment e left join categories c on e.category = c.id where e.id=".$eqID;
    $queryEq = mysqli_query($db, $prequery);
    while ($row = mysqli_fetch_array($queryEq)) {
        echo "<div class='row cart-detail'>";
        echo "<div class='col-lg-4 col-sm-4 col-4 cart-detail-img' id='imgContainer'>";
        echo "<img src=\"assets/images/".$row['imgID'].".png\">";
        echo "</div>";
        echo "<div class='col-lg-8 col-sm-8 col-8 cart-detail-product'>";
        echo "<span class='price text-info'>" . $row["categoryName"] . "</span> <h3 class='name' style='font-weight: bold; font-size: 20px; margin-bottom: 0;'>" . $row['equipment'] . "</h3>";
        echo "<span class='count'> Quantity: </span><input id='cartInput' type='number' min='1' max=".$row['leftQuantity']." name='quantity' id=".$row['id']."_qty"." value='$qty' style='margin-bottom: 10px' onchange='updateQty($eqID,this.value)'/>";
        echo "<button class='btn btn-danger btn-block' style='display: inline-block; padding-left: 5px; font-size: 12px' onclick='deleteItem($eqID)'>Delete</button>
                </div>
                </div><hr>";
    }
}

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

