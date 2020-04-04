<?php
include('serverconnect.php');
?>

<!--TODO Complete Dashboard-->
<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <?php include('adminHeader.php') ?>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- Material Kit CSS -->
    <link href="assets/css/dashboardstyle.css" rel="stylesheet" />
    <script src="assets/js/select2.min.js"></script>
    <link rel="stylesheet" href="assets/css/select2.min.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap-iso.css">
    <script src="assets/js/select2.min.js"></script>

</head>

<body>

<div class="wrapper ">

    <div class="main-panel">
        <!-- Navbar -->

        <?php include('adminNavbar.php')?>
        <!-- End Navbar -->

        <div class="content ">
            <h2 class="text-center">Search</h2>


            <div class="container-fluid bootstrap-iso" id="container">

                <!-- your content here -->

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#user">User</a></li>
                    <li><a data-toggle="tab" href="#eq">Equipment</a></li>
                    <li><a data-toggle="tab" href="#cat">Category</a></li>
                    <li><a data-toggle="tab" href="#log">Log</a></li>
                    <li><a data-toggle="tab" href="#rq">Requests</a></li>
                </ul>

            <div class="tab-content">
                <?php include('searchUser.php'); ?>
<!--                --><?php //include('searchEq.php'); ?>
            </div>
        </div>
    </div>
</div>

</body>

</html>

<script>
    $("#eqSelect").select2( {
        placeholder: "Scan Barcode or enter Equipment ID",
        allowClear: true,

    } );
    $("#userSelect").select2( {
        placeholder: "Enter user ID",
        allowClear: true,

    } );
</script>