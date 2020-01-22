<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
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

<?php include('navbar.php'); ?>

<div class="content">
    <div>
        <h2>Check Out</h2>

        <p>
            <?php

            $resultset = mysqli_query($db, "select * from equipments where Availability = 1");
            ?>
        <div class="select-style" style="width:500px; margin: auto;" align="center">
            <form action="checkout-process.php" style="width: 100%;" align="center" method="POST">
                <select name="equipment" class="select-picker" >
                    <option value="" disabled selected>Select the Equipment</option>
                    <?php

                    while ($row = mysqli_fetch_array($resultset)){
                        $Equipment = $row['Equipment'];
                        $equip_id = $row['id'];

                        if (isset($_GET['selected']) && $_GET['selected'] == $equip_id){
                            echo "<option value='$Equipment' selected='selected'>$Equipment</option>";
                        } else echo "<option value='$Equipment' >$Equipment</option>";
                    }
                    ?>
                </select>
                <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="padding: 10px 15px; border: 1px solid #ccc;
  border-radius: 4px; margin-top: 10px"></textarea>
                <input name="request" type="submit" value="Check Out" style="width: 100%;">
            </form>
        </div>
        </p>

    </div>
</div>


</body>

