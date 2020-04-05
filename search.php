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
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="bootstrap-iso.css">
    <script src="assets/js/select2.min.js"></script>

</head>

<body>

<div class="wrapper ">

    <div class="main-panel">
        <!-- Navbar -->

        <?php include('adminNavbar.php')?>
        <!-- End Navbar -->

        <div class="content">
            <h2 class="text-center">Search</h2>


            <div class="container-fluid bootstrap-iso" id="container">

                <!-- your content here -->

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" data-target="#user, #user_button" href=".user">User</a></li>
                    <li><a data-toggle="tab" data-target="#eq, #eq_button" href=".eq">Equipment</a></li>
                    <li><a data-toggle="tab" href="#cat">Category</a></li>
                    <li><a data-toggle="tab" href="#log">Log</a></li>
                    <li><a data-toggle="tab" href="#rq">Requests</a></li>
                </ul>

                <div class="tab-content">


                    <?php include('searchUser.php'); ?>


                    <?php include('searchEq.php'); ?>



                </div>

                <ul id="myTab" class="nav nav-tabs">
                    <li class="active"><a href="#home" data-target="#home, #home_else" data-toggle="tab">C1</a></li>
                    <li><a href="#profile" data-target="#profile, #profile_else" data-toggle="tab">C2</a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active bootstrap-iso" id="home" role="tabpanel">
                        <p>Content 1.</p>
                    </div>
                    <div class="tab-pane fade bootstrap-iso" id="profile" role="tabpanel">
                        <p>Content 2.</p>
                    </div>
                </div>

                <hr>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active bootstrap-iso" id="home_else" role="tabpanel">
                        <p>Content 111.</p>
                    </div>
                    <div class="tab-pane fade bootstrap-iso" id="profile_else" role="tabpanel">
                        <p>Content 2222.</p>
                    </div>
                </div>


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
    $(document).ready(function() {

        $("#userSelect").change(function () {
            var id = $(this).val();
            console.log("Working");

            var url = 'fetchSearchUser.php?' + 'id=' + id;
            console.log(url);

            $("#user").load(url);
            console.log("Done");

        })});

    $("#userSelect").select2( {
        placeholder: "Enter user ID",
        allowClear: true,

    } );


</script>