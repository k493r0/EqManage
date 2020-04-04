<?php
include('serverconnect.php');
$userID = $_GET['id'];

$query = "Select * from EqManage.users 
left join log l on l.users_id = users.id 
left join equipment e on e.id = l.equipment_id
where users.id=$userID";
$borrowing = 0;
$borrowed =0;
$overdue = 0;
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result)) {
    $fullname = $row['fullname'];
    if ($row['returnDate'] == null && $row['checkoutRequests_id'] != null){ //User that has a record in log
        $borrowing++;
        $borrowed++;
    } elseif($row['returnDate']!= null && $row['checkoutRequests_id'] != null ) {
        $borrowed++;
    }
    $today = date("Y-m-d H:i:s");
    $todayExplode = explode(" ", $today);
    $returnDate = $row['expectedReturnDate'];
    if (strtotime($returnDate) < strtotime($today) && $row['checkoutRequests_id'] != null && $row['returnDate'] == null) {
        $overdue++;
    }

}

if ($userID == null){
    $borrowing = "-";
    $borrowed ="-";
    $overdue = "-";
    $fullname = "-";
    $userID = "-";
}

echo "
<h1>Searching ID: $userID</h1>
    <div class=\"row\">
        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Full Name</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$fullname</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"overdue.php\">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Overdue</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$overdue</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"overdue.php\">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Currently Borrowing</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$borrowing</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"overdue.php\">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Borrowed Total</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$borrowed</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"overdue.php\">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class=\"row\">

        <div class=\"col-md-4\">
            <div class=\"card card-chart\">
                <div class=\"card-header card-header-danger\">
                    <div class=\"ct-chart\" id=\"websiteViewsChart\"></div>
                </div>
                <div class=\"card-body\" id=\"currentCO\">";

$query = mysqli_query($db,"select * from EqManage.log l
left join equipment e on l.equipment_id = e.id
where l.users_id = $userID and returnDate is null ");


$NumberCheckedOut = mysqli_num_rows($query);


echo "<h3 class=\"card-title\">Currently Checked Out:</h3>";
echo  "<ul style='margin-bottom: 0px'>";

while ($row = mysqli_fetch_array($query)) {
    echo "<li class=\"card-category\" style=\"padding-bottom: 0px; margin-bottom: 0px\"><a href='idsearch.php?logid=", $row['id'] ,"'>", $row['equipment'], " | ";
}
echo "</a></ul>";
if (mysqli_num_rows($query) == null){
    $NumberCheckedOut = 0;
    echo "-";
}





                echo "</div>
                <div class=\"card-footer\">
                    <div class=\"stats\">

                    </div>
                </div>
            </div>
        </div>

      

";
                $finalcontent = $content1.$content2.$content3;
                echo $finalcontent;