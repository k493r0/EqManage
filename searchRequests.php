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

<div id="request_button" class=" bootstrap-iso eq" style="margin-top: 10px">
    <div style="position: center" align="center" id="searchEq">
        <label for="requestSelect" style="margin-top: 20px">Search:</label>
        <select id="requestSelect" style="width: 50%; text-align: left;margin-bottom: 10px" onchange="change()" >
                <?php

                $returnResult = mysqli_query($db,"select * from EqManage.requests");
                while ($row = mysqli_fetch_array($returnResult)){

                    echo "<option value=\"\">Select User</option>";
                    $ID = $row['id'];
                    $date = $row['requestDate'];
                    echo "<option value='$ID'>ID: $ID | Request Date: $date</option>";
                };
                ?>
        </select>
    </div>
</div>

<div id="request" class="bootstrap-iso eq" style="margin-top: 10px">
        <?php  include('fetchSearchRequests.php') ?>
    </div>
</div>

<script>

    $(document).ready(function() {

        $("#requestSelect").change(function () {
            var id = $(this).val();
            console.log("Working");

            var url = 'fetchSearchRequests.php?' + 'id=' + id;
            console.log(url);

            $("#request").load(url);
            console.log("Done");

        })});

    $("#requestSelect").select2( {
        placeholder: "Enter user ID",
        allowClear: true,

    } );

    function change() {
        var e = document.getElementById("requestSelect");
        var id = e.options[e.selectedIndex].value;
        console.log(id);

        var url = 'fetchSearchRequests.php?' + 'id=' + id;
        console.log(url);

        $("#request").load(url);
        console.log("Done");
    }
</script>
