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
$eqID = $_GET['id'];

$query = "
Select e.equipment,c.categoryName,e.totalQuantity,e.leftQuantity,c.id from EqManage.equipment e
left join categories c on e.category = c.id
where e.id = '$eqID'
";
$borrowing = 0;
$borrowed =0;
$overdue = 0;
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result)) {
    $eqName = $row['equipment'];
    $catName = $row['categoryName'];
    $totalQty = $row['totalQuantity'];
    $leftQuantity = $row['leftQuantity'];
    $catID = $row['id'];
};

if ($eqID == null){
    $totalQty = "-";
    $leftQuantity ="-";
    $overdue = "-";
    $catName = "-";
    $eqName = "-";
    $eqID = "-";
};

echo "
<h1>Searching ID: $eqID</h1>
    <div class=\"row\">
        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Equipment Name</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$eqName</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"manageEq.php\">Manage Equipment >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Category</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$catName</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"search.php?type=5&id=$catID\">View this Category >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Total Qty</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$totalQty</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"manageEq.php\">Manage Equipments >></a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Left Qty</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$leftQuantity</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"manageEq.php\">Manage Equipments >></a>
                    </div>
                </div>
            </div>
        </div>

    </div>


";
//$finalcontent = $content1.$content2.$content3;
//echo $finalcontent;
