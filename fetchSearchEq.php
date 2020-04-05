<?php
include('serverconnect.php');
$eqID = $_GET['id'];

$query = "
Select * from EqManage.equipment
left join categories c on equipment.category = c.id
where equipment.id = '$eqID'
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
                        <a href=\"overdue.php\">View overdue >></a>
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
                        <a href=\"overdue.php\">View overdue >></a>
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
                        <a href=\"overdue.php\">View overdue >></a>
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
where l.users_id = $eqID and returnDate is null ");


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
//$finalcontent = $content1.$content2.$content3;
//echo $finalcontent;