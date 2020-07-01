<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}
?>

<div id="log_button" class=" bootstrap-iso eq" style="margin-top: 10px">
    <div style="position: center" align="center" id="searchEq">
        <label for="logSelect" style="margin-top: 20px">Search:</label>
        <select id="logSelect" style="width: 50%; text-align: left;margin-bottom: 10px" onchange="change()" >
                <?php

                $returnResult = mysqli_query($db,"select * from EqManage.log");
                while ($row = mysqli_fetch_array($returnResult)){

                    echo "<option value=\"\">Select User</option>";
                    $ID = $row['id'];
                    $date = $row['checkoutRequestDate'];
                    echo "<option value='$ID'>ID: $ID | Initial Checkout Request Date: $date</option>";
                };
                ?>
        </select>
    </div>
</div>

<div id="log" class="bootstrap-iso eq" style="margin-top: 10px">
        <?php  include('fetchSearchLog.php') ?>
    </div>
</div>

<script>

    $(document).ready(function() {

        $("#logSelect").change(function () {
            var id = $(this).val();
            console.log("Working");

            var url = 'fetchSearchEq.php?' + 'id=' + id;
            console.log(url);

            $("#user").load(url);
            console.log("Done");

        })});

    $("#logSelect").select2( {
        placeholder: "Enter user ID",
        allowClear: true,

    } );

    function change() {
        var e = document.getElementById("logSelect");
        var id = e.options[e.selectedIndex].value;
        console.log(id);

        var url = 'fetchSearchLog.php?' + 'id=' + id;
        console.log(url);

        $("#log").load(url);
        console.log("Done");
    }
</script>
