<?php
session_start();
if(!isset($_SESSION['loggedin'])){
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

<?php
if ($_SESSION['username'] == 'administrator'){
    include ('adminNavbar.php');
} else{
    include ('navbar.php');
} ?>

<div class="content">
    <div style="height: 63px; opacity: 0; padding: 0; margin: 0" ></div>
    <div  style="padding-top: 0;">
        <h2 style="padding-bottom: 10px; margin-bottom: 20px">Check Out</h2>
        <div class="select-style" style="width:500px; margin: auto; margin-top: 4%;margin-bottom: 2%" >
            <form action="checkout-process.php" style="width: 100%;" align="left" method="POST" name="form" onsubmit="return emptyCheck(event)">
                <?php
                if (empty($_SESSION['cart'])) {
                    $query = "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity
                      FROM EqManage.categories C
                      LEFT JOIN EqManage.equipment E ON C.id=E.category
                      GROUP BY C.id,E.id, C.categoryName, E.equipment
                      ORDER BY C.categoryName,E.equipment";

                    if ($result = mysqli_query($db, $query)) {
                        if (mysqli_num_rows($result)) {
                            $last_group = null;
                            $select = "<select name=\"equipment\" id='eq' onchange=\"getQty(this)\" class='select'> <option value=\"\" disabled selected>Select the Equipment</option>";
                            while ($row = mysqli_fetch_assoc($result)) { //Filling select with data
                                if ($row["categoryName"] != $last_group) {//If the category name is not the same as the last equipment, add the category name as a spacer
                                    $select .= ($last_group != null ? "</optgroup>" : "") . "<optgroup label=\"{$row["categoryName"]}\">"; //Ternary Operator, one category
                                    //if $last_group is null (so first item), it does not close optgroup
                                    $last_group = $row["categoryName"];
                                }
                                if ($row["id"] == null) {//If there is no equipment
                                    $select .= "<option disabled>No Available Equipment From This Category</option>";
                                } elseif ($row['leftQuantity'] == 0) {//If there is no equipment left
                                    $select .= "<option id='optionvalue' disabled value=\"{$row["id"]}\" data-leftQty=\"{$row['leftQuantity']}\">{$row["equipment"]} | {$row['leftQuantity']} Left</option>";
                                } else { //There is an equipment with left quantity > 0
                                    $select .= "<option id='optionvalue' value=\"{$row["id"]}\" data-leftQty=\"{$row['leftQuantity']}\"";
                                    if (isset($_GET['select']) && $_GET['select'] == $row['id']){//If selection is specified in the url
                                        $select .= "selected";//Add selected in the option tag to make it pre-selected
                                    }
                                    $select .= ">{$row["equipment"]} | {$row['leftQuantity']} Left</option>";
                                }
                            }
                            $select .= "</optgroup></select>";
                            echo $select;
                            mysqli_free_result($result);
                        } else {echo "Empty Resultset From Query";}
                    } else {echo mysqli_error($db);}
                    ?>
<!--Input fields for when there is nothing in the cart-->
                <input type="text" name="location" placeholder="Location to be used" id="location" style="
                border-radius: 4px; margin-top: 20px;margin-bottom: 10px"/>
                <textarea type="text" id="purpose" name="purpose" placeholder="Purpose" style="padding: 10px 15px; border: 1px solid #ccc;
                border-radius: 4px; margin-top: 10px;margin-bottom: 10px"></textarea>
                Quantity: <input type="number" min="1" max="100" name="quantity" id="qty" style="margin-bottom: 15px;" value=""/>
                <div></div>
                Date of Return: <input id="datefield" name="date" type='date' min='1899-01-01' max='2000-13-13' width="100%" style="margin-bottom: 15px">
                <div></div>
                Time of Return: <input id="timefield" name="time" type="time" value="15:30">
                <input name="request" type="submit" value="Send Request" style="width: 100%;">
                    <?php
                        }elseif (isset($_SESSION['cart'])){
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
                <button type="button" class="btn btn-info btn-group-justified" style="margin: 10px 0px; float: right; font-size: 13px; margin-left: 100%" onclick="window.location.href='index.php'">Add more >></button>
                <div style="text-align: center" >
                <label style="margin: 0; margin-top: 10px">
                    <input type="checkbox" id="applyAllCheck" name="applyAllCheck" value="1" checked onchange="applyAll()"> Apply to all equipment
                </label>
                </div>
<!--Input fields when user chooses to apply the same information for all the equipments in the cart-->
                <div id="single">
                <input type="text" name="location_single" placeholder="Location to be used" id="location_single"/>
                <textarea type="text" id="purpose_single" name="purpose" placeholder="Purpose" style="padding: 10px 15px; border: 1px solid #ccc;
border-radius: 4px; margin-top: 10px;margin-bottom: 10px"></textarea>
                Date of Return: <input id="datefield" name="date_single" type='date' min='1899-01-01' max='2000-13-13' width="100%" style="margin-bottom: 15px">
                <div></div>
                Time of Return: <input id="timefield" name="time_single" type="time" value="15:30">
                <div></div>
                <hr style="margin: 30px">
                <input name="request" type="submit" value="Send Request" style="width: 100%;">
                </div>
<!--When user selects "apply to all", it creates input fields for each equipment in cart-->
                <div id="multi">
                    <?php
                    foreach ($_SESSION['cart'] as $i){//Creating input fields with all the equipment in the cart with unique identifiers (equipment ID)
                        $result = mysqli_query($db,"Select * from EqManage.equipment where id =".$i['id']);
                        while ($row = mysqli_fetch_array($result)) {
                            $eqName = $row['equipment'];
                        } ?>
                        <h3 style="margin:0"><?php echo $eqName ?></h3>
                        <input type="text" name="location_<?php echo $i['id'] ?>" placeholder="Location to be used" id="location_<?php echo $i['id'] ?>"/>
                        <textarea type="text" id="purpose_<?php echo $i['id'] ?>" name="purpose_<?php echo $i['id'] ?>" placeholder="Purpose" style="padding: 10px 15px; border: 1px solid #ccc;
  border-radius: 4px; margin-top: 10px;margin-bottom: 10px"></textarea>
                        Date of Return: <input id="datefield_<?php echo $i['id'] ?>" name="date_<?php echo $i['id'] ?>" type='date' min='<?php echo date('Y-m-d');?>' max='2000-13-13' width="100%" style="margin-bottom: 15px" value="<?php echo date('Y-m-d');?>">
                        <div></div>
                        Time of Return: <input id="timefield_<?php echo $i['id'] ?>" name="time_<?php echo $i['id'] ?>" type="time" value="15:30">
                        <hr style="margin: 30px">

                    <?php } ?>
                        <button name="request" type="submit" class="btn btn-info" value="Send Request" style="width: 100%;">Send Request</button>
                </div>
                    <?php } ?>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {//On page load
        <?php
        if(isset($_SESSION['cart'])){//Apply all function only needs triggering when there is items in cart
            echo "applyAll();";
        }
        ?>

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }
        today = yyyy+'-'+mm+'-'+dd;
        document.getElementById("datefield").setAttribute("min", today); //Set the minimum value to today so that user can't select date earlier
        document.getElementById("datefield").setAttribute("value", today);//Set the default value to today
    });

    function getQty(eq) {//get the value from custom tag: data-leftQty, where it is selected in the selection list
        qty = eq.options[eq.selectedIndex].getAttribute('data-leftQty');//this value is equal to how much equipment is left in the inventory
        console.log(qty);
        document.getElementById("qty").setAttribute("max",qty); //set maximum possible value of qty box to the remaining number of equipment
        document.getElementById("qty").setAttribute("value",qty);//set the default of qty to the maximum possible checkout quantity
    }

    function applyAll() {//handles showing and hiding of all input fields for all equipments in the cart
        var checked = document.getElementById("applyAllCheck").checked;//returns boolean value
        var single=document.getElementById('single'); //Div containing the input fields that applies to all equipment
        var multi=document.getElementById('multi');//Div containing the input fields for all equipment in the cart
        console.log(checked);
        if (checked === false){//When user is not selecting "Apply all" (So different information for each equipment)
            single.style.display='none'; //Hide single
            multi.style.display='block';//Show multi
            console.log("Showing");
        } else {
            single.style.display='block';
            multi.style.display='none';
            console.log("Hidden");
        }
    }

    function updateQty(eqID, qty) {//Triggered whenever the quantity field is changed
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


    function deleteItem(eqID) {//Triggered when item delete button is pressed
        console.log(eqID);
        $.ajax({
            url:"navbarCart.php",
            type:"POST",
            data:{
                "delete":"1", //Pass which action to perform
                "eqID":eqID //Pass which equipment to perform action on
            },
            success:function (data) {
                console.log("deleted item");
                $("#cartDiv").html(data);//Reload cart div
                $("#cartTable").load("fetchCartTable.php");//Reload cart table
                $("#multi").load("#multi");//Reload the input fields
                console.log(data);
            }
        })
    }

    function emptyCheck(e) {//Check for empty fields before submitting form
        <?php
            if (isset($_SESSION['cart'])){ //If cart exists
                $php_array = array();
                foreach ($_SESSION['cart'] as $i){
                    array_push($php_array, $i);
                }
                $js_array = json_encode($php_array); //Add cart element in PHP array
                echo "var javascript_array = ". $js_array . ";\n"; //Then pass variable to javascript
            }else{echo "var javascript_array = null;";} //If Cart doesn't exist, set to null

        ?>
        if (javascript_array!=null){ //If javascript array is not empty (If cart exists)
            var checked = document.getElementById("applyAllCheck").checked; //
            //Note: this element is not present when cart is empty thus it will throw an error if its called when cart is empty
        }
        if (javascript_array!=null && checked === false){//If Apply to all is not selected
            javascript_array.forEach(validation);
        }else if(javascript_array!=null && checked === true){//If apply to all is selected

            var location = document.forms["form"]["location_single"].value; //Getting data from form input field
            var purpose = document.forms["form"]["purpose_single"].value;
            var date = document.forms["form"]["date_single"].value;
            var time = document.forms["form"]["time_single"].value;

            if (location === "" || location == null || purpose === "" || purpose == null
                || date === "" || date == null || time === "" || time == null) { //Check if fields are filled in
                alert("All fields must be filled out");
                return false; //Returning false will stop forms from submitting
            }else {
                return true;
            }
        }else if(javascript_array==null){//If there is no equipment in cart (Single equipment checkout)
            var location = document.forms["form"]["location"].value;//Getting data from form input field
            var purpose = document.forms["form"]["purpose"].value;
            var date = document.forms["form"]["date"].value;
            var time = document.forms["form"]["time"].value;
            var select = true;
            $('.select').each(function () { //Check if equipment is selected
                if ($(this).val() === '') {
                    select = false;
                } else select = true;
            });

            if (location === "" || location == null || purpose === "" || purpose == null || date === "" || date == null
                || time === "" || time == null || select === false) {
                alert("All fields must be filled out");
                return false;  //Returning false will stop forms from submitting
            }else {
                return true; //Continue submitting the form
            }
        }
        function validation(item){//Function to check empty fields for individual equipment
            console.log(item['id']);//item['id'] identifies input fields of each equipment
            var locationString = "location_"+item['id']; //Getting the exact id for selected equipment
            var purposeString = "purpose_"+item['id'];
            var dateString = "date_"+item['id'];
            var timeString = "time_"+item['id'];
            var location = document.forms["form"][locationString].value; //Retrieve the value in the form field
            var purpose = document.forms["form"][purposeString].value;
            var date = document.forms["form"][dateString].value;
            var time = document.forms["form"][timeString].value;
            if (location === "" || location == null || purpose === "" || purpose == null
                || date === "" || date == null || time === "" || time == null) {
                alert("All fields must be filled out");
                e.preventDefault();//Abort submitting the form
                //Return false does not work here because this function is called by another function
            }else{return true;}
        }
    }

</script>
</body>

