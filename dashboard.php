<?php ?>

<!--TODO Complete Dashboard-->
<!doctype html>
<html lang="en">

<head>
    <title>Hello, world!</title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

<div class="wrapper ">

    <div class="main-panel">
        <!-- Navbar -->
        <?php include('adminHeader.php') ?>
        <?php include('adminNavbar.php')?>
        <!-- End Navbar -->
        <div class="content">
            <h2 class="text-center">Dashboard</h2>
            <div class="container-fluid">
                <!-- your content here -->

                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">content_copy</i>
                                </div>
                                <p class="card-category">Overdue</p>
                                <h3 class="card-title">1
                                    <small>people</small>
                                </h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons text-danger">warning</i>
                                    <a href="javascript:;">Get More Space...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">store</i>
                                </div>
                                <p class="card-category">Checkouts Today</p>
                                <h3 class="card-title">2</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">date_range</i> Last 24 Hours
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-danger card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">info_outline</i>
                                </div>
                                <p class="card-category">Pending Requests</p>
                                <h3 class="card-title">5</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">local_offer</i> Tracked from Github
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="fa fa-twitter"></i>
                                </div>
                                <p class="card-category">Checked Out This Month</p>
                                <h3 class="card-title">13</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Just Updated
                                </div>
                            </div>
                        </div>

                    </div>

                </div> <!-- Small statiistic template -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header card-header-danger">
                                <div class="ct-chart" id="websiteViewsChart"></div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Currently Checked Out: 4</h4>
                                <p class="card-category">
                                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
                                <p class="card-category">List goes here</p>
                                <p class="card-category" style="padding-bottom: 0px; margin-bottom: 0px">List goes here</p>
                                <p class="card-category" style="padding-bottom: 0px; margin-bottom: 0px">List goes here</p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">access_time</i> updated 4 minutes ago
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header card-header-danger">
                                <div class="ct-chart" id="websiteViewsChart"> </div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Monthly Checkout</h4>
                                <p class="card-category">Checkout performance of last 30 days</p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">access_time</i> campaign sent 2 days ago
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header card-header-danger">
                                <div class="ct-chart" id="websiteViewsChart"> </div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Most Popular</h4>
                                <p class="card-category">Most frequently checked out equipment</p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">access_time</i> campaign sent 2 days ago
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Graph template -->


            </div>
        </div>
    </div>
</div>

<div id="Modal" class="modal" style="display: none;">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" data-dismiss="modal">×</span>

        <div class="select-style" style="width:500px; margin: auto;" align="center">

            <select id="eqselect" style="width: 100%; text-align: left;margin-bottom: 10px">
                <option value="">Select equipment</option>
                <option value="4">Afghanistanasdasdasdasdasd</option>
                <option value="248">Aland Islands</option>
                <option value="8">Albania</option>
                <option value="8">4941983014843</option>

            </select>
            Quantity: <input type="number" min="1" max="100" name="quantity" id="qty" style="margin-top: 5px;" value=""/>


            <!--                            <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="padding: 10px 15px; border: 1px solid #ccc;-->
            <!--  border-radius: 4px; margin-top: 10px"></textarea>-->
            <p>  </p>

            <select id="studentselect" onchange="getQty(this)" style="width: 100%; margin-bottom: 10px">
                <option value="">Student Name</option>
                <option value="4">Afghanistanasdasdasdasdasd</option>
                <option value="248">Aland Islands</option>
                <option value="8">Albania</option>
                <option value="8">4941983014843</option>

            </select>

            <input id="add" name="request" type="submit" value="Confirm Checkout" style="width: 100%;" data-dismiss="modal">
        </div>


    </div>

</div>

</body>

<script>
    // Get the modal
    var alert = document.getElementById("alert");
    alert.style.display = "none";
    var modal = document.getElementById("Modal");

    // Get the button that opens the modal
    var btn = document.getElementById("Btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

</script>
<script src="assets/js/select2.min.js"></script>
<script>
    $("#eqselect").select2( {
        placeholder: "Scan Barcode",
        allowClear: true
    } );
    $("#studentselect").select2( {
        placeholder: "Student Name",
        allowClear: true
    } );

    function getQty(studentselect) {
        qty = studentselect.options[studentselect.selectedIndex].getAttribute('value');
        console.log(qty);

    }

</script>

</html>