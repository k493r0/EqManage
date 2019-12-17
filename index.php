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
<?php include('navbar.php'); ?>
<div id="loader">
<div class="loader"><div></div><div></div><div></div><div></div></div>
</div>
    <div class="content">
        <h2>Equipment Status</h2>



        <?php $results = mysqli_query($db, "SELECT * FROM equipments"); ?>
        <table align="center" cellpadding="10px" cellspacing="6px" width="100%" border="2px"  id="table" style="border-collapse: collapse;margin-top: 10px;border-color: black">
            <thead>
            <tr>
                <th style="padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #2f9395;
  color: white;">Equipment</th>
                <th style="padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #2f9395;
  color: white;">Availability</th>
            </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($results)) { ?>
                <tr style="background-color: #f2f2f2 ">
                    <td style=" border: 1px solid black;
  padding: 15px;"><?php echo $row['Equipment']; ?></td>
                    <td style=" border: 1px solid black;
  padding: 15px;">
                        <?php

                        if ($row['Availability'] == 1) {
                            echo '<dt style="color:red";">
      Available </dt>';
                        } elseif ($row['Availability'] == 0){
                            echo "Not Available";
                        } else echo "Error";


                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>




    </div>


    </div>
</body>

