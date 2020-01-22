<?php
include('server.php');
?>
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
<body class="loggedin">
<?php
include("navbar.php");
?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!--<nav class="navtop">
    <div>
        <h1>Website Title</h1>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>-->
<div class="content">
    <div>
        <h2>Confirmation</h2>

        <p>
            <?php

            include ('serverconnect.php');

            $user = "";
            $equipment = "";



            $user = $_SESSION['name'];
            $equipment = $_POST['Equipments'];
            $equipment_id = $_GET['selected'];
            echo $equipment_id;


            $selected_equipment = mysqli_query($db,"select * from equipments where id=$equipment_id ");


            while ($row = mysqli_fetch_array($selected_equipment)){
                $equipment_name = $row['Equipment'];
                echo $equipment_name;
            }

            echo '<h3 style="text-align: center"><b>Equipment Selected: ',"$equipment_name",'</b></h3>';
            echo '<textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="margin: 0 auto; margin-left: 30%; margin-right: 30%; width: 40%; height: 20%;padding: 10px 15px; border: 1px solid #ccc;
  border-radius: 4px; margin-top: 10px"></textarea>';
            echo "<h1 style='text-align: center'><b>$equipment_name</b></h1>";




            ?>

            <form method="post" action="checkout-process.php">
        <p><?php echo $equipment_name; ?> </p>
        <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="margin: 0 auto; margin-left: 30%; margin-right: 30%; width: 40%; height: 20%;padding: 10px 15px; border: 1px solid #ccc;
  border-radius: 4px; margin-top: 10px"></textarea>
        <input type="hidden" name="name" value="<?php echo $user; ?>">
        <input type="hidden" name="equipment" value="<?php echo $equipment_name; ?>">

        <input name="confirm" type="submit" value="Confirm" style="width: 100%; margin-top: 20px">
        </form>

    </div>

</div>





</div>
</body>
</html>
