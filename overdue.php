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

<script>

    function loadTable(){
        $("#table2").load("fetchOverdueTable.php");
    }
    setInterval(function () {

        loadTable();
    },1500);





</script>
