<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
include ('serverconnect.php');
?>
<!DOCTYPE html>
<html>
<?php
include('header.php');
?>

<body class="form-v8 loggedin" id="fade">

<div id="loader">
<div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php include('navbar.php'); ?>

<div class="content">
    <div>
        <h2>Check Out</h2>

            <?php

            $resultset = mysqli_query($db, "select * from equipment where leftQuantity >= 1");
            ?>
        <div class="select-style" style="width:500px; margin: auto; margin-top: 4%;margin-bottom: 2%" >
            <form action="checkout-process.php" style="width: 100%;" align="left" method="POST">
<!--                //old select-->
<!--                <select name="equipment" class="select-picker" >-->
<!--                    <option value="" disabled selected>Select the Equipment</option>-->
<!--                    --><?php
//                        while ($row = mysqli_fetch_array($resultset)) {
//                            $Equipment = $row['equipment'];
//                            $equip_id = $row['id'];
//
//
//                            if (isset($_GET['selected']) && $_GET['selected'] == $equip_id) {
//                                echo "<option value='$Equipment' selected='selected'>$Equipment</option>";
//                            } else echo "<option value='$Equipment' >$Equipment</option>";
//                    }
//                    ?>
<!--                </select>-->

                <?php


                if (empty($_SESSION['cart'])) {
                    $sql = "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity
                      FROM EqManage.categories C
                      LEFT JOIN EqManage.equipment E ON C.id=E.category
                      GROUP BY C.id,E.id
                      ORDER BY C.categoryName,E.equipment;";

                    if ($result = mysqli_query($db, $sql)) {
                        if (mysqli_num_rows($result)) {
                            $last_group = null;
                            $select = "<select name=\"equipment\" id='eq' onchange=\"getQty(this)\"> <option value=\"\" disabled selected>Select the Equipment</option>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row["categoryName"] != $last_group) {
                                    $select .= ($last_group != null ? "</optgroup>" : "") . "<optgroup label=\"{$row["categoryName"]}\">"; //Category Spacer
                                    $last_group = $row["categoryName"];
                                }
                                if ($row["id"] == null) {
                                    $select .= "<option disabled>No Available Equipment From This Category</option>";
                                } elseif ($row['leftQuantity'] == 0) {
                                    $select .= "<option id='optionvalue' disabled value=\"{$row["id"]}\" data-leftQty=\"{$row['leftQuantity']}\">{$row["equipment"]} | {$row['leftQuantity']} Left</option>";
                                } else {
                                    $select .= "<option id='optionvalue' value=\"{$row["id"]}\" data-leftQty=\"{$row['leftQuantity']}\">{$row["equipment"]} | {$row['leftQuantity']} Left</option>";
                                }

                            }
                            $select .= "</optgroup></select>";

                            echo $select;
                            mysqli_free_result($result);
                        } else {
                            echo "Empty Resultset From Query";
                        }
                    } else {
                        echo mysqli_error($db);
                    }

                    ?>
                    <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="padding: 10px 15px; border: 1px solid #ccc;
  border-radius: 4px; margin-top: 10px;margin-bottom: 10px"></textarea>


                    Quantity: <input type="number" min="1" max="100" name="quantity" id="qty" style="margin-bottom: 15px;" value=""/>
                    <div></div>
                    Date of Return: <input id="datefield" name="date" type='date' min='1899-01-01' max='2000-13-13' width="100%" style="margin-bottom: 15px">
                    <div></div>
                    Time of Return: <input id="timefield" name="time" type="time" value="15:30">
                    <input name="request" type="submit" value="Check Out" style="width: 100%;">

                <?php
                } elseif (isset($_SESSION['cart'])){
                ?>
                    <table width="100%" id="table">
                        <thead>
                        <tr>
                            <th scope="col">Equipment</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody id="cartTable">

                        <?php include('fetchCartTable.php') ?>

                        </tbody>
                    </table>


                    <button type="button" class="btn btn-info btn-group-justified" style="margin: 10px 0px; float: right; font-size: 13px; margin-left: 100%">Add more >></button>
                    <div style="text-align: center" >
                    <label style="margin: 0; margin-top: 10px">
                        <input type="checkbox" id="applyAllCheck" name="applyAllCheck" value="1" checked onchange="applyAll()"> Apply to all equipment
                    </label>
                    </div>
                    <div id="single">
                    <input type="text" name="location" placeholder="Location to be used" id="location"/>
                    <textarea type="text" id="purpose" name="purpose" placeholder="Purpose" style="padding: 10px 15px; border: 1px solid #ccc;
  border-radius: 4px; margin-top: 10px;margin-bottom: 10px"></textarea>
                    Date of Return: <input id="datefield" name="date" type='date' min='1899-01-01' max='2000-13-13' width="100%" style="margin-bottom: 15px">
                    <div></div>
                    Time of Return: <input id="timefield" name="time" type="time" value="15:30">
                    <div></div>
                    <hr style="margin: 30px">
                    <input name="request" type="submit" value="Check Out" style="width: 100%;">
                    </div>

                    <div id="multi">
                    <?php

                    foreach ($_SESSION['cart'] as $i){
                        $result = mysqli_query($db,"Select * from EqManage.equipment where id =".$i['id']);
                        while ($row = mysqli_fetch_array($result)) {
                            $eqName = $row['equipment'];
                        } ?>
                        <h3 style="margin:0"><?php echo $eqName ?></h3>
                        <input type="text" name="location_<?php echo $i['id'] ?>" placeholder="Location to be used" id="location"/>
                        <textarea type="text" id="purpose_<?php echo $i['id'] ?>" name="purpose_<?php echo $i['id'] ?>" placeholder="Purpose" style="padding: 10px 15px; border: 1px solid #ccc;
  border-radius: 4px; margin-top: 10px;margin-bottom: 10px" onkeyup="emptyCheck(this.value)"></textarea>
                        Date of Return: <input id="datefield_<?php echo $i['id'] ?>" name="date_<?php echo $i['id'] ?>" type='date' min='<?php echo date('Y-m-d');?>' max='2000-13-13' width="100%" style="margin-bottom: 15px" onchange="emptyCheck(this.value)" value="<?php echo date('Y-m-d');?>">
                        <div></div>
                        Time of Return: <input id="timefield_<?php echo $i['id'] ?>" name="time_<?php echo $i['id'] ?>" type="time" value="15:30">
                        <hr style="margin: 30px">

                    <?php } ?>
                        <button name="request" type="submit" class="btn btn-info" value="Check Out" style="width: 100%;">Send Request</button>
                    </div>
                <?php } ?>




            </form>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        applyAll();
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }



        today = yyyy+'-'+mm+'-'+dd;

        document.getElementById("datefield").setAttribute("min", today);
        document.getElementById("datefield").setAttribute("value", today);
    });




    function getQty(eq) {
        qty = eq.options[eq.selectedIndex].getAttribute('data-leftQty');
        console.log(qty);
        document.getElementById("qty").setAttribute("max",qty);
        document.getElementById("qty").setAttribute("value",qty);

    }
    
    function applyAll() {
        var checked = document.getElementById("applyAllCheck").checked;
        var single=document.getElementById('single');
        var multi=document.getElementById('multi');
        console.log(checked);
        if (checked === false){
            single.style.display='none';
            multi.style.display='block';
            console.log("Shwoign");
        } else {
            single.style.display='block';
            multi.style.display='none';
            console.log("Hidden");
        }
    }


    function updateQty(eqID, qty) {
        console.log(qty);
        console.log(eqID);
        $.ajax({ //This handles the update of the cart and session
            url:"navbarCart.php",
            type:"POST",
            data:{
                "update":"1",
                "qty":qty,
                "eqID":eqID
            },
            success:function (data) {
                $("#cartDiv").html(data);
                console.log(data);
            }
        })
    }


    function deleteItem(eqID) {
        console.log(eqID);
        $.ajax({
            url:"navbarCart.php",
            type:"POST",
            data:{
                "delete":"1",
                "eqID":eqID
            },
            success:function (data) {
                console.log("deleted item");
                $("#cartDiv").html(data);
                $("#cartTable").load("fetchCartTable.php");
                $("#multi").load(" #multi");
                console.log(data);
            }
        })
    }

    function emptyCheck() {
        var purposeField = document.getElementById("purpose").value;
    }

</script>
</body>

