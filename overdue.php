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

<!DOCTYPE html>
<html>
<?php
include('header.php')
?>
<body class="form-v8 loggedin" id="fade">

<div id="loader">
    <div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php
include('adminNavbar.php');
include('serverconnect.php');
?>


<div class="content">

    <div style="height: 63px; opacity: 0; padding: 0; margin: 0" ></div>
    <div id="sentAlert" style="color: red;" class="name">Notification & Email sent to the user</div>
    <div style="padding-top: 0;">
        <h2 style="padding-bottom: 10px; margin-bottom: 20px">Overdue</h2>
        <?php $results = mysqli_query($db, "SELECT * FROM EqManage.equipment inner join EqManage.categories on equipment.category = categories.id"); ?>

        <table width="100%" id="table">
            <thead>
            <tr>
                <th scope="col">User ID</th>
                <th scope="col">Equipment</th>
                <th scope="col">Qty</th>
                <th scope="col">Note</th>
                <th scope="col">Check Out Date</th>
                <th scope="col">Expected Return Date</th>
                <th scope="col">Request ID</th>
                <th scope="col">Notify</th>
                <th scope="col">Return</th>
            </tr>
            </thead>
            <tbody id="table2">


            <?php include('fetchOverdueTable.php') ?>



            </tbody>
        </table>

    </div>

</div>
<div id="returnModal2" class="modal" style="display: none">

    <!-- Modal content -->
    <div class="modal-content" style="min-width: 600px; width: fit-content">
        <div onclick="closeModal()"><span class="close"  data-dismiss="modal" onclick="closeModal()" style="float: left; margin-bottom: 10px">×</span></div>

        <div class="select-style" style="width:80%; margin: auto;" align="center">
            <div id="overdueReturnDiv">
                <?php include('overdueReturn.php') ?>
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

    var sentAlert = document.getElementById("sentAlert");
    sentAlert.style.display = "none";

    function loadTable(){
        $("#table2").load("fetchOverdueTable.php");
    }
    setInterval(function () {

        loadTable();
    },1500);

    $('#returnEqSelect').val('20');
    $('#returnStudentSelect').val('2');
    $('#returnSelect').val('102');

    //
    //
    // var returnbtn = document.getElementById("confirmReturnBtn");
    //
    // // Get the <span> element that closes the modal
    var returnspan2 = document.getElementsByClassName("close")[0];
    var returnmodal2 = document.getElementById("returnModal2");
    // // When the user clicks on the button, open the modal
    // returnbtn.onclick = function() {
    //     returnmodal.style.display = "block";
    // };
    returnspan2.onclick = function() {
        returnmodal2.style.display = "none";
    }
    function closeModal() {
        console.log("test");
        returnmodal2.style.display = "none";
    }

    function confirmReturn(id){
        $.ajax({
            url: "overdueReturn.php",
            type: "POST",
            async: false,
            data: {
                "id": id
            },
            success:function (data) {
                $("#overdueReturnDiv").html(data);
                var returnmodal2 = document.getElementById("returnModal2");
                returnmodal2.style.display = "block";
            }
        })
    }

    function overdueReturn(id) {
        var rqID = id;

        document.getElementById("overdueReturn").setAttribute("value", "...");

        $.ajax({
            url: "adminReturn.php",
            type: "POST",
            async: false,
            data: {
                "rqID": rqID,
            },
            success: function (data) {
                console.log(data);


                setTimeout(() => {
                    document.getElementById("overdueReturn").setAttribute("value", "Return successful");
                }, 1000);


                setTimeout(() => {

                    $("#table2").load("fetchOverdueTable.php");
                    var returnmodal2 = document.getElementById("returnModal2");
                    returnmodal2.style.display = "none";
                    console.log("reloaded");
                }, 2000);
                // pipe(eqID,userID,checkoutID)

            }

        });
    }

    function showMessage() {
        waitAlert.style.display = "block";
    }

    function notifyOverdue(id) {

        $.ajax({
            url: "notifyOverdue.php",
            type: "POST",
            async: false,
            data: {
                "notify": 1,
                "id":id
            },
            success: function (data) {
                console.log(data);
                sentAlert.style.display = "block";
            }

        });
    }




</script>
