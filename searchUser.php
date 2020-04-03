<div id="user" class="tab-pane fade in active bootstrap-iso" style="margin-top: 10px">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <h3 class="card-category">Full Name</h3>
                    <div id="overdue"><?php include('fetchOverdue.php') ?></div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <!--                                    <i class="material-icons text-danger">warning</i>-->
                        <a href="overdue.php">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <h3 class="card-category">Username</h3>
                    <div id="overdue"><?php include('fetchOverdue.php') ?></div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <!--                                    <i class="material-icons text-danger">warning</i>-->
                        <a href="overdue.php">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <h3 class="card-category">Currently Borrowing</h3>
                    <div id="overdue"><?php include('fetchOverdue.php') ?></div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <!--                                    <i class="material-icons text-danger">warning</i>-->
                        <a href="overdue.php">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <h3 class="card-category">Borrowed Total</h3>
                    <div id="overdue"><?php include('fetchOverdue.php') ?></div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <!--                                    <i class="material-icons text-danger">warning</i>-->
                        <a href="overdue.php">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="card card-chart">
                <div class="card-header card-header-danger">
                    <div class="ct-chart" id="websiteViewsChart"></div>
                </div>
                <div class="card-body" id="currentCO">
                    <h4 class="card-title">Currently Checked Out:</h4>
                    <p>Hello</p>
                </div>
                <div class="card-footer">
                    <div class="stats">

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
                    <h4 class="card-title">Weekly Checkout</h4>
                    <p class="card-category">Checkout performance of last 7 days</p>
                </div>
                <div id="chartContainer2" style="height: 150px; width: 100%;"></div>
                <div class="card-footer">
                    <div class="stats">
                        <!--                                    <i class="material-icons">access_time</i> campaign sent 2 days ago-->
                        <a href="">View log</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>