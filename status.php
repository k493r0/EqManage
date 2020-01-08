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

    <h2>All Requests</h2>


    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                        <tr class="table100-head">
                            <th class="column1" style="border-bottom: 1px solid black">ID</th>
                            <th class="column2" style="border-bottom: 1px solid black">User</th>
                            <th class="column3" style="border-bottom: 1px solid black">Equipment</th>
                            <th class="column4" style="border-bottom: 1px solid black">Notes</th>
                            <th class="column5" style="border-bottom: 1px solid black">Date Requested</th>
                            <th class="column6" style="border-bottom: 1px solid black">State</th>
                            <th class="column6" style="border-bottom: 1px solid black">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $results = mysqli_query($db, "SELECT * FROM allrequests"); ?>

                        <?php while ($row = mysqli_fetch_array($results)) { ?>
                            <tr>
                                <td style="text-align:left"><?php echo $row['Equipment']; ?></td>
                                <td style="text-align:left"><?php echo $row['User'] ?></td>
                                <td style="text-align:left"><?php echo $row['Equipment'] ?></td>
                                <td style="text-align:left"><?php echo $row['Notes'] ?>
                                <td style="text-align:left"><?php echo $row['DateRequested'] ?></td>


                                <td>
                                    <?php

                                    if ($row['Active'] == 1) {
                                        echo '<dt style="color:green; text-align: left";">Passed</dt>';
                                    } elseif ($row['Active'] == 0){
                                        echo '<dt style="color:red; text-align: left";">Pending/Rejected</dt>';
                                    } else echo "Error";


                                    ?>
                                </td>
                                <td><?php echo $row['Action'] ?></td>


                            </tr>
                        <?php }; ?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>


</body>

