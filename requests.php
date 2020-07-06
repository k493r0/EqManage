<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1');
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

<?php if ($_SESSION['username'] == 'administrator'){
    include ('adminNavbar.php');
} else{
    include ('navbar.php');
}
?>

<div class="content">
    <div style="height: 63px; opacity: 0; padding: 0; margin: 0" ></div>
    <?php if (isset($_GET['verify']) && $_GET['verify'] == 1){
        echo '<p style="color: green" >Successfully Verified</p>';
    } ?>


    <div class="limiter" style="padding-top: 0;">
        <h2 style="padding-bottom: 10px; margin-bottom: 20px">All Requests</h2>
        <label for="select-box1" class="label select-box1"><span class="label-desc">Show: </span> </label>
        <input type="checkbox" id="approved" name="approved" value="approved" style="margin-left: 5px" onchange="changeCheckbox();" checked>
        <label for="approved" style="color: green; margin-right: 10px"> Approved</label>
        <input type="checkbox" id="rejected" name="rejected" value="rejected" onchange="changeCheckbox();" checked>
        <label for="rejected" style="color: red; margin-right: 10px"> Rejected</label>
        <input type="checkbox" id="waiting" name="waiting" value="waiting" onchange="changeCheckbox();" checked>
        <label for="waiting" style="color: black; margin-right: 10px" > Waiting</label>



        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table style="width: 100%">
                        <thead>
                        <tr class="table100-head">
                            <th class="column1" style="border-bottom: 1px solid black">Rq. ID</th>
                            <th class="column2" style="border-bottom: 1px solid black">User</th>
                            <th class="column3" style="border-bottom: 1px solid black">Equipment</th>
                            <th class="column4" style="border-bottom: 1px solid black">Location</th>
                            <th class="column4" style="border-bottom: 1px solid black">Purpose</th>
                            <th class="column4" style="border-bottom: 1px solid black">Qty</th>
                            <th class="column5" style="border-bottom: 1px solid black">Date Requested</th>
                            <th class="column6" style="border-bottom: 1px solid black">State</th>
                            <th class="column7" style="border-bottom: 1px solid black">Action <br>(<a href='postverify.php?mode=0&redirecturl=<?php echo $_SERVER["REQUEST_URI"]?>' style="font-weight: normal"><u>Verify All</u></a>)</th>

                        </tr>
                        </thead>
                        <tbody id="table">
                        <?php include('fetchRequestsTable.php'); ?>
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
function changeCheckbox() {
    var approveCheckbox = document.getElementById("approved");
    var rejectCheckbox = document.getElementById("rejected");
    var waitCheckbox = document.getElementById("waiting");

    var boolApprove;
    var boolReject;
    var boolWait;

    if (approveCheckbox.checked === true){
        boolApprove = true;
    } else boolApprove = false;
    if (rejectCheckbox.checked === true){
        boolReject = true;
    } else boolReject = false;
    if (waitCheckbox.checked === true){
        boolWait = true;
    } else boolWait = false;


    var url = 'fetchRequestsTable.php?' + 'approved=' + boolApprove + '&' + 'rejected=' + boolReject + '&' + 'waiting=' + boolWait;
    console.log(url);
    $("#table").load(url);

}

window.onload = function () {
    changeCheckbox();
}



</script>

</body>

