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
        <h2>Return</h2>

        <p>
            <?php
            include('serverconnect.php');
            $name = $_SESSION['name'];
            $resultset = mysqli_query($db, "select Equipment from equipments where Availability = 0 and Name='$name'");
            ?>
        <div class="select-style" style="width:500px; margin: auto">
            <form action="confirmation.php" style="width: 100%;" method="POST">
                <select name="Equipments" class="select-picker" >
                    <option value="" disabled selected>Select the Equipment</option>
                    <?php
                    while ($row = mysqli_fetch_array($resultset)){
                        $Equipment = $row['Equipment'];
                        echo "<option value='$Equipment' >$Equipment</option>";
                    }
                    ?>
                </select>
                <input name="request" type="submit" value="Return" style="width: 100%; margin-top: 20px">
            </form>
        </div>
        </p>

    </div>

</div>

