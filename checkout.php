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
<head>
    <meta charset="utf-8">
    <title>Media Team Equipment Management System</title>
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="assets/css/sourcesanspro-font.css">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="assets/css/loaderstyle.css"/>
    <link rel="stylesheet" href="assets/css/corestyle.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/js/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <script>
        $(function () {
            setTimeout(function () {
                $("#loader").fadeOut(500);
            }, 1500)
        })

    </script>



</head>
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
                <select name="Equipments" class="select-picker" >
                    <option value="" disabled selected>Select the Equipment</option>
                    <?php

                    while ($row = mysqli_fetch_array($resultset)){
                        $Equipment = $row['Equipment'];
                        $equip_id = $row['id'];

                        if (isset($_GET['selected']) && $_GET['selected'] == $equip_id){
                            echo "<option value='$Equipment' selected='selected'>$Equipment</option>";
                        } else echo "<option value='$equip_id' >$Equipment</option>";
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

