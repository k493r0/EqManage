<?php
session_start();
if(!isset($_SESSION['loggedin'])){
header('Location: index.php');
exit();
}
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
        <h2>Confirmation</h2>

        <p>
            <?php

            include('serverconnect.php');

            $user = "";
            $equipment = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {


                $user = $_SESSION['name'];
                $equipment = $_POST['Equipments'];

                echo '<h3 style="text-align: center"><b>Do you really want to return: </b></h3>';
                echo "<h1 style='text-align: center'><b>$equipment</b></h1>";



            }


            ?>

        <form method="post" action="return-process.php">
            <input type="hidden" name="name" value="<?php echo $user ?>">
            <input type="hidden" name="equipment" value="<?php echo $equipment ?>">


            <input name="confirm" type="submit" value="Confirm" style="width: 100%; margin-top: 20px">
        </form>

    </div>

</div>


