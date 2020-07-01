<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}
include ('serverconnect.php');
?>
<!DOCTYPE html>
<html>
<?php
include('header.php')
?>
<body class="form-v8 loggedin" id="fade">

<div id="loader">
    <div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php include('adminNavbar.php'); ?>

<div class="content">
    <div style="height: 63px; opacity: 0; padding: 0; margin: 0" ></div>


    <div class="limiter" style="padding-top: 0;">
        <h2 style="padding-bottom: 10px; margin-bottom: 20px">Log</h2>
        <div class="select-box">
            <label for="select-box1" class="label select-box1"><span class="label-desc">Filter By: </span> </label>
            <label for="checkoutDateRadio">
            <input type="radio" id="checkoutDateRadio" name="filter" value="0" <?php $filter = $_GET['filter']; if ($filter == 0 or $filter == null){echo 'checked = "checked"';}else echo null;?>  onclick="changeOption();"> Checkout Date</label>
            <label for="returnDateRadio">
            <input type="radio" id="returnDateRadio" name="filter" value="1" <?php $filter = $_GET['filter']; if ($filter == 1){echo 'checked = "checked"';}else echo null;?> onclick="changeOption();"> Return Date</label>
           <br>
            <label for="select-box1" class="label select-box1" id="selectLabel">Show checkout from: </label>
            <select id="select-box1" class="select" name="filtercat" onchange="changeOption()" style="width: 15%">
                <option value="0" <?php $range = $_GET['range']; if ($range == 0 or $range ==null){echo 'selected';}else echo null;?>>--All Time--</option>
                <option value="1" <?php $range = $_GET['range']; if ($range == 1){echo 'selected';}else echo null;?>>Today</option>
                <option value="2" <?php $range = $_GET['range']; if ($range == 2){echo 'selected';}else echo null;?>>Yesturday</option>
                <option value="3" <?php $range = $_GET['range']; if ($range == 3){echo 'selected';}else echo null;?>>Past 7 days</option>

            </select>
            <br>
            <label for="filterUser">Filter by user ID (Enter nothing or 0 to reset): </label>
            <input id="filterUser" type="number" style="width: 50px;">
            <button id="Btn" class="btn" style="height: 30px; font-size: 13px" onclick="filterClick()">Filter</button>

        </div>
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                        <tr class="table100-head">
                            <th class="column1" style="border-bottom: 1px solid black">Log ID</th>
                            <th class="column2" style="border-bottom: 1px solid black">Check Out Request ID</th>
                            <th class="column4" style="border-bottom: 1px solid black">Equipment ID</th>
                            <th class="column5" style="border-bottom: 1px solid black">User ID</th>
                            <th class="column6" style="border-bottom: 1px solid black">Check Out Date</th>
                            <th class="column6" style="border-bottom: 1px solid black">Expected Return Date</th>
                            <th class="column6" style="border-bottom: 1px solid black">Return Date</th>

                        </tr>
                        </thead>
                        <tbody id="table">
                       <?php include('fetchLogTable.php'); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>


<?php

if ($_SESSION['username'] == 'administrator'){
    include ('adminModal.php');
}

?>

<script>


    function changeOption() {
        var radioSelection = 0;
        var r = document.getElementById("selectLabel");
        // if (r.innerText === "Show checkout from: "){r.innerText = "Show from return date: ";} else r.innerText = "Show checkout from: ";
        // // r.innerText = "Show from return date: ";
        // console.log(r.value);
        if(document.getElementById('checkoutDateRadio').checked) {
            console.log("CO");
            r.innerText = "Show checkout from: ";
        }else if(document.getElementById('returnDateRadio').checked) {
            // console.log("Return");
            r.innerText = "Show from return date: ";
        }

        var e = document.getElementById("select-box1");
        var selectvalue = e.options[e.selectedIndex].value;
        var radios = document.getElementsByName("filter");


        //var userID = "<?php //$ID = $_GET['user']; if ($ID){echo $ID;}; ?>//";
        //if (userID == null){
        var f = document.getElementById("filterUser");
        userID = f.value;


        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                // do whatever you want with the checked radio
                radioSelection = radios[i].value;
                // only one radio can be logically checked, don't check the rest
                break;
            }
        }
        var url = 'fetchLogTable.php?' + 'filter=' + selectvalue + '&' + 'range=' + radioSelection + '&' + 'user=' + userID;
        console.log(url);

        $("#table").load(url);
        console.log("Done")
    }

    function filterClick(){

        var f = document.getElementById("filterUser");
        var userID = f.value;
        console.log(userID);
        var radioSelection = 0;
        var r = document.getElementById("selectLabel");
        r.innerText = "Show from return date: ";
        var e = document.getElementById("select-box1");
        var selectvalue = e.options[e.selectedIndex].value;
        var radios = document.getElementsByName("filter");

        if (userID == null){
            userID = "<?php $ID = $_GET['user']; if ($ID){echo $ID;}; ?>";
        }

        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                // do whatever you want with the checked radio
                radioSelection = radios[i].value;
                // only one radio can be logically checked, don't check the rest
                break;
            }
        }

        var url = 'fetchLogTable.php?' + 'filter=' + selectvalue + '&' + 'range=' + radioSelection + '&' + 'user=' + userID;
        console.log(url);
        $("#table").load(url);
        console.log("Done")


    }

    window.onload = function () {
        // changeOption();

        var f = document.getElementById("filterUser");


        var userID = "<?php $ID = $_GET['user']; if ($ID){echo $ID;}; ?>";
        if (userID != null){
            f.value = userID;
        }
    };


    // Get the modal
    var alert = document.getElementById("alert");
    var modal = document.getElementById("checkoutModal");

    // Get the button that opens the modal
    var btn = document.getElementById("Btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    modal.onclick = function() {
        modal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };



    var returnmodal = document.getElementById("returnModal");

    // Get the button that opens the modal
    var returnbtn = document.getElementById("Btn");

    // Get the <span> element that closes the modal
    var returnspan = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    returnbtn.onclick = function() {
        returnmodal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    returnspan.onclick = function() {
        returnmodal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target === returnmodal) {
            returnmodal.style.display = "none";
        }
    };

</script>


</body>

