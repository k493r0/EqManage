<div style="position: center" align="center">
<label for="eqSelect" style="margin-top: 20px">Search:</label>
<select id="eqSelect" style="width: 30%; text-align: left;margin-bottom: 10px" >
    <div id="eqselectDiv">

        <?php include('fetchCheckoutEq.php') ?>
    </div>

</select>
</div>

<div id="eq" class="tab-pane fade in bootstrap-iso" style="margin-top: 10px">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <h3 class="card-category">Equipment Name</h3>
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
                    <h3 class="card-category">Equipment Category</h3>
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
                    <h3 class="card-category">Total Available Qty</h3>
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
                    <h3 class="card-category">Left Qty</h3>
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
                    <h4 class="card-title">Left Quantity</h4>
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

