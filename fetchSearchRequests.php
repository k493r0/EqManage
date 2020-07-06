<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1');
}
include('serverconnect.php');
$rqID = $_GET['id'];
//echo $rqID;
$query = "
Select r.users_id, r.purpose, r.location, r.equipment_id, e.equipment, u.fullname, r.state,r.requestDate, r.expectedReturnDate, r.checkoutQty from EqManage.requests r
left join equipment e on r.equipment_id = e.id
left join users u on r.users_id = u.id
where r.id = '$rqID'
";

$eqID = "";
$userID = "";
$checkoutRequestDate = "";
$expectedReturnDate = "";
$checkoutDate = "";
$returnDate = "";
$purpose = "";
$checkoutQty = 0;
$state = "";
$eqName = "";
$username = "";

$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result)) {

    $checkoutQty = $row['checkoutQty'];
    $eqID = $row['equipment_id'];
    $userID = $row['users_id'];
    $purpose = $row['purpose'];
    $location = $row['location'];
    $state = $row['state'];
    $username = $row['fullname'];
    $eqName = $row['equipment'];

    $requestDate = explode(" ",$row['requestDate']);
    $expectedReturnDate = explode(" ",$row['expectedReturnDate']);

};

if ($eqID == null){
    $rqID = "-";
    $eqID = "-";
    $userID = "-";
    $checkoutRequestDate = "-";
    $expectedReturnDate = "-";
    $checkoutDate = "-";
    $returnDate = "-";
    $purpose = "-";
    $requestDate = "-";
    $state = "-";
    $checkoutQty = "-";
    $eqName = "-";
    $username = "-";
    $location = "-";

};
if ($returnDate[0] == null){
    $returnDate[0] = "Not returned yet";
}
if ($checkoutDate[0] == null){
    $checkoutDate[0] = "Not checked out yet";
}
if ($state == "approved"){
    $state = "Approved";
} elseif ($state == "rejected"){
    $state = "Rejected";
} elseif ($state == "waiting"){
    $state = "Waiting";
}

echo "
<h1>Searching ID: $rqID</h1>
    <div class=\"row\">
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

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Equipment ID</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$eqID ($eqName)</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"search.php?type=2&id=$eqID\">Search this ID in Equipment >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Checkout Quantity</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$checkoutQty</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"requests.php\">View all Requests >></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">State</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$state</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"requests.php\">View all Requests >></a>
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
                        <h3 class=\"card-title\">Location</h3>
                        <h4 class=\"card-category\">$location</h4>
                    </div>
                    <div id=\"chartContainer2\"></div>
                    <div class=\"card-footer\">
                        <div class=\"stats\">
                            <a href=\"requests.php\">View all Requests >></a>
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
                        <h3 class=\"card-title\">Purpose</h3>
                        <h4 class=\"card-category\">$purpose</h4>
                    </div>
                    <div id=\"chartContainer2\"></div>
                    <div class=\"card-footer\">
                        <div class=\"stats\">
                            <a href=\"requests.php\">View all Requests >></a>
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
                        <h3 class=\"card-title\">Request Date</h3>
                        <h4 class=\"card-category\">$requestDate[0]</h4>
                    </div>
                    <div id=\"chartContainer2\"></div>
                    <div class=\"card-footer\">
                        <div class=\"stats\">
                            <a href=\"requests.php\">View all Requests >></a>
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
                            <a href=\"requests.php\">View all Requests >></a>
                        </div>
                    </div>
                </div>
            </div>
           
    </div>
      

";
//$finalcontent = $content1.$content2.$content3;
//echo $finalcontent;
