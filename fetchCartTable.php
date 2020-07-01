<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}

include('serverconnect.php');

if (empty($_SESSION['cart'])){
    echo "<tr><td></td><td>No equipment in Cart</td><td></td></tr>";
}
foreach ($_SESSION['cart'] as $i){
    $eqName = "";
    $leftQty = 0;
    $result = mysqli_query($db,"Select * from EqManage.equipment where id =".$i['id']);
    while ($row = mysqli_fetch_array($result)) {
        $eqName = $row['equipment'];
        $leftQty = $row['leftQuantity'];
    }
//    echo $i['id'];
    ?>
    <tr>
        <td><?php echo $eqName ?></td>
        <td><input type='number' min='1' max="<?php echo $leftQty ?>" name='quantity' id="<?php echo $i['id'] ?>_qty" value='<?php echo $i['qty'] ?>' style="width: 100%" onchange='updateQty(<?php echo $i['id'] ?>,this.value)'/></td>
        <td><?php echo "<button type='button' class='btn btn-link' style='padding: 0' id='removeBtn' onclick='deleteItem(".$i['id'].")'>Remove</button>";?></td>
    </tr>
<?php } ?>
