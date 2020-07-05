<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}

include('serverconnect.php');
$logID = $_GET['id'];

$query = "
Select * from EqManage.log l
left join equipment e on l.equipment_id = e.id
left join users u on l.users_id = u.id
where l.id = '$logID'
";

$rqID = "";
$eqID = "";
$userID = "";
$checkoutRequestDate = "";
$expectedReturnDate = "";
$checkoutDate = "";
$returnDate = "";
$eqName = "";
$username = "";

$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result)) {

    $rqID = $row['checkoutRequests_id'];
    $eqID = $row['equipment_id'];
    $userID = $row['users_id'];
    $username = $row['fullname'];
    $eqName = $row['equipment'];

    $checkoutRequestDate = explode(" ",$row['checkoutRequestDate']);
    $expectedReturnDate = explode(" ",$row['expectedReturnDate']);
    $checkoutDate = explode(" ",$row['checkoutDate']);
    $returnDate = explode(" ",$row['returnDate']);

};

if ($eqID == null){
    $rqID = "-";
    $eqID = "-";
    $userID = "-";
    $checkoutRequestDate = "-";
    $expectedReturnDate = "-";
    $checkoutDate = "-";
    $returnDate = "-";
};
if ($returnDate[0] == null){
    $returnDate[0] = "Not returned yet";
}
if ($checkoutDate[0] == null){
    $checkoutDate[0] = "Not checked out yet";
}

echo "
<h1>Searching ID: $logID</h1>
    <div class=\"row\">
        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Checkout Requests ID</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$rqID</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"search.php?type=4&id=$rqID\">Search this ID in Request >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Equipment ID</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$eqID ($eqName)</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"search.php?type=2&id=$eqID\">Search this ID in Log >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Borrowing User ID</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$userID ($username)</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"search.php?type=1&id=$userID\">Search this ID in User >></a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    
    <div class=\"row\">
    <div class=\"col-md-4\">
                <div class=\"card card-chart\">
                    <div class=\"card-header card-header-danger\">
                        <div class=\"ct-chart\" id=\"websiteViewsChart\"> </div>
                    </div>
                    <div class=\"card-body\">
                        <h3 class=\"card-title\">Checkout Request Date</h3>
                        <h4 class=\"card-category\">$checkoutRequestDate[0]</h4>
                    </div>
                    <div id=\"chartContainer2\"></div>
                    <div class=\"card-footer\">
                        <div class=\"stats\">
                            <a href=\"log.php\">View all Log >></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class=\"col-md-4\">
                <div class=\"card card-chart\">
                    <div class=\"card-header card-header-danger\">
                        <div class=\"ct-chart\" id=\"websiteViewsChart\"> </div>
                    </div>
                    <div class=\"card-body\">
                        <h3 class=\"card-title\">Checkout Date</h3>
                        <h4 class=\"card-category\">$checkoutDate[0]</h4>
                    </div>
                    <div id=\"chartContainer2\"></div>
                    <div class=\"card-footer\">
                        <div class=\"stats\">
                            <a href=\"log.php\">View all Log >></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class=\"col-md-4\">
                <div class=\"card card-chart\">
                    <div class=\"card-header card-header-danger\">
                        <div class=\"ct-chart\" id=\"websiteViewsChart\"> </div>
                    </div>
                    <div class=\"card-body\">
                        <h3 class=\"card-title\">Expected Return Date</h3>
                        <h4 class=\"card-category\">$expectedReturnDate[0]</h4>
                    </div>
                    <div id=\"chartContainer2\"></div>
                    <div class=\"card-footer\">
                        <div class=\"stats\">
                        <a href=\"log.php\">View all Log >></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class=\"col-md-4\">
                <div class=\"card card-chart\">
                    <div class=\"card-header card-header-danger\">
                        <div class=\"ct-chart\" id=\"websiteViewsChart\"> </div>
                    </div>
                    <div class=\"card-body\">
                        <h3 class=\"card-title\">Return Date</h3>
                        <h4 class=\"card-category\">$returnDate[0]</h4>
                    </div>
                    <div id=\"chartContainer2\"></div>
                    <div class=\"card-footer\">
                        <div class=\"stats\">
                            <a href=\"log.php\">View all Log >></a>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    

      

";
//$finalcontent = $content1.$content2.$content3;
//echo $finalcontent;
