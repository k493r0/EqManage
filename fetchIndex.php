<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}

include ('serverconnect.php');


$filterCategory = $_POST['filterCat'];

$sortE = $_POST['sortE'];

$sortC = $_POST['sortC'];



$results = mysqli_query($db, "SELECT * FROM equipment");

$default = mysqli_query($db, "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity, E.availability, E.imgID
      FROM EqManage.equipment E
      LEFT JOIN EqManage.categories C ON C.id=E.category
      GROUP BY C.id,E.id, C.categoryName, E.equipment
      ORDER BY C.categoryName,E.equipment");




$noFilterCAscEAsc = mysqli_query($db, "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity, E.availability, E.imgID
      FROM EqManage.equipment E
      LEFT JOIN EqManage.categories C ON C.id=E.category
      GROUP BY C.id,E.id, C.categoryName, E.equipment
      ORDER BY C.categoryName asc,E.equipment asc");

$noFilterCDescEAsc = mysqli_query($db, "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity, E.availability, E.imgID
      FROM EqManage.equipment E
      LEFT JOIN EqManage.categories C ON C.id=E.category
      GROUP BY C.id,E.id, C.categoryName, E.equipment
      ORDER BY C.categoryName desc,E.equipment asc");

$noFilterCDescEDesc = mysqli_query($db, "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity, E.availability, E.imgID
      FROM EqManage.equipment E
      LEFT JOIN EqManage.categories C ON C.id=E.category
      GROUP BY C.id,E.id, C.categoryName, E.equipment
      ORDER BY C.categoryName desc,E.equipment desc");

$noFilterCAscEDesc = mysqli_query($db, "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity, E.availability, E.imgID
      FROM EqManage.equipment E
      LEFT JOIN EqManage.categories C ON C.id=E.category
      GROUP BY C.id,E.id, C.categoryName, E.equipment
      ORDER BY C.categoryName asc,E.equipment desc");

$filterEAsc = mysqli_query($db, "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity, E.availability, E.imgID
      FROM EqManage.equipment E
      LEFT JOIN EqManage.categories C ON C.id=E.category WHERE C.id='$filterCategory'
      GROUP BY C.id,E.id, C.categoryName, E.equipment 
      ORDER BY E.equipment asc");

$filterEDesc = mysqli_query($db, "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity, E.availability, E.imgID
      FROM EqManage.equipment E
      LEFT JOIN EqManage.categories C ON C.id=E.category WHERE C.id='$filterCategory'
      GROUP BY C.id,E.id, C.categoryName, E.equipment 
      ORDER BY E.equipment desc");
?>

<?php


if ($filterCategory == null or $filterCategory == 0) //if there is no filter
    switch ($sortC){
        case 1: switch ($sortE){
            case 1: $executeResult = $noFilterCAscEAsc; break; //No filter, Category Ascending, Equipment Ascending
            case 2: $executeResult = $noFilterCAscEDesc; break; //No filter, Category Ascending, Equipment Descending
            break;
        } break;
        case 2: switch ($sortE){
            case 1: $executeResult = $noFilterCDescEAsc;break; //No filter, Category Descending, Equipment Ascending
            case 2: $executeResult = $noFilterCDescEDesc;break; //No filter, Category Descending, Equipment Ascending
            break;
        }
    }
elseif ($filterCategory != null ) //If filter is selected
    switch ($sortE){ //Sort by category is ignored as category is filtered
        case 1: $executeResult = $filterEAsc;break;
        case 2: $executeResult = $filterEDesc;break;
        break;
    }
else $executeResult = $default;
















//if ($filterCategory == null or $filterCategory == 0)
//    switch ($sortby) {
//        case 1: $executeResult = $noFilterResultCAsc; break;
//        case 2: $executeResult = $noFilterResultCDesc;break;
//        case 3: $executeResult = $noFilterResultEAsc; break;
//        case 4: $executeResult = $noFilterResultEDesc;break;
//        default: $executeResult = $default; break;
//    }
//elseif ($filterCategory != null)
//    switch ($sortby){
//        case 2: $executeResult = $filterResult; break;
//        case 1: $executeResult = $filterResult; break;
//        case 3: $executeResult = $filterResultAsc; break;
//        case 4: $executeResult = $filterResultDesc; break;
//        case null: $executeResult=$filterResult; break;
//        default: $executeResult=$filterResult; break;
//    }
//elseif ($filterCategory != null && $sortby == null)
//    $executeResult = $default;
//else $executeResult = $default;
//    ;


while ($row = mysqli_fetch_array($executeResult)) {




    ?>


    <?php echo "<div class=\"col-sm-6 col-md-5 col-lg-4 item\">";?>



    <?php if ($row['availability'] == 1) {
        echo "<div class=\"box\" id='box2'><img src=\"assets/images/".$row['imgID'].".png\" style='width: 100px;height:100px'><br>";
    } elseif ($row['availability'] == 0){
        echo "<div class=\"box\" id='box2'>";
    } else echo "Error"; ?>




    <?php /*echo "<h3 class=\"name\">".$row['Equipment']."</h3>"; */?>



    <?php if ($row['availability'] == 1) {
        echo "<a style='font-style: italic; text-decoration: underline'>".$row['categoryName']."<a/><h3 class=\"name\">".$row['equipment']."</h3>";
    } elseif ($row['availability'] == 0){
        echo "<a style='font-style: italic; text-decoration: underline;color: red'>".$row['categoryName']."<a/><h3 class=\"name\" style='color: red'>".$row['equipment']."</h3>";
    } else echo "Error"; ?>



    <?php if ($row['availability'] == 1) {
        echo "<p class=\"description\">".$row['leftQuantity']." Available";
    } elseif ($row['availability'] == 0){
        echo "<p class=\"description\" style='color: red'>Not Available";
    } else echo "Error"; ?>


    <?php echo "</p>"; ?>



    <?php if ($row['availability'] == 1) {
        echo "<a href=\"checkout.php?select=".$row['id']."\" class=\"learn-more\">Borrow This Equipment »</a><br>";
    } elseif ($row['availability'] == 0){
        $query = "select expectedReturnDate from EqManage.log where log.equipment_id =".$row['id']." and returnDate is null order by expectedReturnDate asc";
        if ($results = mysqli_query($db, $query)){
            mysqli_data_seek($results, 0);
            $row = mysqli_fetch_row($results);
            $date = date('M-d H:i', strtotime($row[0]));
            if ($row[0] != null){echo "<p class=\"description\" style='color: red'>Expected to be available at: ".$date;} else echo "<p class=\"description\" style='color: red'>Availability date not determined yet";


        }
    } else echo "Error"; ?>

    <?php if ($row['availability'] == 1) {
        echo "Quantity: <input type=\"number\" min=\"1\" max=".$row['leftQuantity']." name=\"quantity\" id=".$row['id']."_qty"." style=\"margin-bottom: 15px;\" value=\"1\" /><button id=\"add-cart\" class='btn trigger_button' style='font-size: 12px; margin: 5px' value=".$row['id']." onclick='addCart(".$row['id'].")'>Add To Cart</button>";
    } elseif ($row['availability'] == 0){
        echo "";
    } else echo "Error"; ?>


    <?php echo "</div>"; ?>
    <?php echo "</div>"; ?>

<?php };?>

<?php echo "
<script>
    $(document).ready(function(){
    $('.trigger_button').click(function(e){
        // Kill click event:
        e.stopPropagation();
        console.log(\"pressed\");
        const element = document.querySelector(\"#cart-dropdown\");
        if (element.classList.contains('show') === true){
            console.log('class identified');
        } else {
            $('.dropdown-toggle').dropdown('toggle');
        }
        });   
    $('#cart-dropdown').on('hide.bs.dropdown', function (e) {
    if (e.clickEvent) {
      e.preventDefault();
    }}); 
    });
</script> 

";//Included in php file because they stop working outside after include, stop propagation



