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

        <p>
            <?php

            $resultset = mysqli_query($db, "select * from equipment where leftQuantity >= 1");
            ?>
        <div class="select-style" style="width:500px; margin: auto;" >
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
                $sql="SELECT C.categoryName, E.id, E.equipment, E.leftQuantity
      FROM EqManage.categories C
      LEFT JOIN EqManage.equipment E ON C.id=E.category
      GROUP BY C.id,E.id
      ORDER BY C.categoryName,E.equipment;";
                if($result=mysqli_query($db,$sql)){
                    if(mysqli_num_rows($result)){
                        $last_group=null;
                        $select="<select name=\"equipment\" id='eq' onchange=\"getQty(this)\"> <option value=\"\" disabled selected>Select the Equipment</option>";

                        while($row=mysqli_fetch_assoc($result)){
                            if($row["categoryName"]!=$last_group){
                                $select.=($last_group!=null?"</optgroup>":"")."<optgroup label=\"{$row["categoryName"]}\">";
                                $last_group=$row["categoryName"];
                            }
                            if($row["id"]==null){
                                $select.="<option disabled>No Available Equipment From This Category</option>";
                            }else{
                                $select.="<option id='optionvalue' value=\"{$row["id"]}\" data-leftQty=\"{$row['leftQuantity']}\">{$row["equipment"]} | {$row['leftQuantity']} Left</option>";
                            }
                        }
                        $select.="</optgroup></select>";

                        echo $select;
                        mysqli_free_result($result);
                    }else{
                        echo "Empty Resultset From Query";
                    }
                }else{
                    echo mysqli_error($db);
                }

//                $sql="SELECT M.manufacturer_name,P.product_id,P.model_number
//      FROM manufacturer M
//      LEFT JOIN product P ON M.manufacturer_id=P.manufacturer_id
//      GROUP BY M.manufacturer_id,P.product_id
//      ORDER BY M.manufacturer_name,P.model_number;";
//                if($result=mysqli_query($con,$sql)){
//                    if(mysqli_num_rows($result)){
//                        $last_group=null;
//                        $select="<select name=\"products\">";
//                        while($row=mysqli_fetch_assoc($result)){
//                            if($row["manufacturer_name"]!=$last_group){
//                                $select.=($last_group!=null?"</optgroup>":"")."<optgroup label=\"{$row["manufacturer_name"]}\">";
//                                $last_group=$row["manufacturer_name"];
//                            }
//                            if($row["product_id"]==null){
//                                $select.="<option disabled>No Products</option>";
//                            }else{
//                                $select.="<option value=\"{$row["product_id"]}\">{$row["model_number"]}</option>";
//                            }
//                        }
//                        $select.="</optgroup></select>";
//                        echo $select;
//                        mysqli_free_result($result);
//                    }else{
//                        echo "Empty Resultset From Query";
//                    }
//                }else{
//                    echo mysqli_error($con);
//                }

                ?>




                <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="padding: 10px 15px; border: 1px solid #ccc;
  border-radius: 4px; margin-top: 10px;margin-bottom: 10px"></textarea>


                Quantity: <input type="number" min="1" max="100" name="quantity" id="qty" style="margin-bottom: 15px;" value=""/>
                <div></div>
                Date of Return: <input id="datefield" name="date" type='date' min='1899-01-01' max='2000-13-13' width="100%" style="margin-bottom: 15px">
                <div></div>
                Time of Return: <input id="timefield" name="time" type="time" value="15:30">
                <input name="request" type="submit" value="Check Out" style="width: 100%;">
            </form>
        </div>
        </p>

    </div>
</div>

<script>
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


    function getQty(eq) {
        qty = eq.options[eq.selectedIndex].getAttribute('data-leftQty');
        console.log(qty);
        document.getElementById("qty").setAttribute("max",qty);
        document.getElementById("qty").setAttribute("value",qty);

    }
</script>
</body>

