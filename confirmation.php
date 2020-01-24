<?php
session_start();
if(!isset($_SESSION['loggedin'])){
header('Location: index.php');
exit();
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

<?php include('navbar.php'); ?>

<div class="content">
    <div>
        <h2>Confirmation</h2>

        <p>
            <?php

            include('serverconnect.php');

            $user = "";
            $equipmentName = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {


                $user = $_SESSION['name'];
                $equipmentID = $_POST['equipment'];
//                echo $equipmentID;


                $query = mysqli_query($db,"select * from EqManage.equipment where id = '$equipmentID'");
            while ($row = mysqli_fetch_array($query)){
                $equipmentName = $row['equipment'];
            }
//            echo $equipmentName;

                echo '<h3 style="text-align: center"><b>Do you really want to return: </b></h3>';
                echo "<h1 style='text-align: center'><b>$equipmentName</b></h1>";



            }


            ?>

        <form method="post" action="return-process.php">
            <input type="hidden" name="name" value="<?php echo $user ?>">
            <input type="hidden" name="equipment" value="<?php echo $equipment ?>">


            <input name="confirm" type="submit" value="Confirm" style="width: 100%; margin-top: 20px">
        </form>

    </div>

</div>


