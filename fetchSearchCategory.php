<?php
include('serverconnect.php');
$catID = $_GET['id'];

$query = "
Select * from EqManage.categories c
left join equipment e on c.id = e.category
where c.id = '$catID'
";

$total = 0;
$categoryName = "";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result)) {

    $total++;
    $categoryName = $row['categoryName'];

};

if ($catID == null){
   $total = "-";
   $categoryName = "-";

};


echo "
<h1>Searching ID: $catID</h1>
    <div class=\"row\">
        <div class=\"col-lg-3 col-md-6 col-sm-6\">
            <div class=\"card card-stats\">
                <div class=\"card-header card-header-warning card-header-icon\">
                    <h3 class=\"card-category\">Category Name</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$categoryName</h4></div>
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
                    <h3 class=\"card-category\">Number of equipment in this Category</h3>
                    <div id=\"overdue\"><h4 class=\"card-title\">$total</h4></div>
                </div>
                <div class=\"card-footer\">
                    <div class=\"stats\">
                        <!--                                    <i class=\"material-icons text-danger\">warning</i>-->
                        <a href=\"overdue.php\">View overdue >></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class=\"col-md-4\">
                        <div class=\"card card-chart\">
                            <div class=\"card-header card-header-danger\">
                                <div class=\"ct-chart\" id=\"websiteViewsChart\"> </div>
                            </div>
                            <div class=\"card-body\" style='padding-top: 5px'>
                                <h3 class=\"card-title\">Equipment in this category</h3> ";
$result = mysqli_query($db, $query);
if ($catID == null){echo "-";};
while ($row = mysqli_fetch_array($result)) {
    $eqName = $row['equipment'];

    $getEqID = "select * from EqManage.equipment where equipment = '$eqName'";
    while ($row = mysqli_fetch_array($result)) {
        $eqID = $row['id'];
    };
    echo "<ul><li>";
    echo "<a href=\"tempSearch.php?type=2&id=$eqID\">$eqName</a>";
    echo "</li></ul>";

};


                                echo "
                            </div>
                            <div id=\"chartContainer2\"></div>
                            <div class=\"card-footer\">
                                <div class=\"stats\">
<!--                                    <i class=\"material-icons\">access_time</i> campaign sent 2 days ago-->
                                    <a href=\"\">View log</a>
                                </div>
                            </div>
                        </div>
                    </div>


    </div>
    
  
    
      

";
//$finalcontent = $content1.$content2.$content3;
//echo $finalcontent;