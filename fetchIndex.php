<?php


include ('serverconnect.php');


$results = mysqli_query($db, "SELECT * FROM equipment");
$results2 = mysqli_query($db, "SELECT C.categoryName, E.id, E.equipment, E.leftQuantity, E.availability
      FROM EqManage.categories C
      LEFT JOIN EqManage.equipment E ON C.id=E.category
      GROUP BY C.id,E.id, C.categoryName, E.equipment
      ORDER BY C.categoryName,E.equipment");

?>

<?php while ($row = mysqli_fetch_array($results2)) { ?>


    <?php echo "<div class=\"col-sm-6 col-md-5 col-lg-4 item\">"; ?>



    <?php if ($row['availability'] == 1) {
        echo "<div class=\"box\" id='box2'>";
    } elseif ($row['availability'] == 0){
        echo "<div class=\"box\" id='box2'>";
    } else echo "Error"; ?>




    <?php /*echo "<h3 class=\"name\">".$row['Equipment']."</h3>"; */?>



    <?php if ($row['availability'] == 1) {
        echo "<a style='font-style: italic; text-decoration: underline'>".$row['categoryName']."<a/><h3 class=\"name\">".$row['equipment']."</h3>";
    } elseif ($row['availability'] == 0){
        echo "<h3 class=\"name\" style='color: orangered'>".$row['equipment']."</h3>";
    } else echo "Error"; ?>



    <?php if ($row['availability'] == 1) {
        echo "<p class=\"description\">".$row['leftQuantity']." Available";
    } elseif ($row['availability'] == 0){
        echo "<p class=\"description\" style='color: red'>Not Available";
    } else echo "Error"; ?>


    <?php echo "</p>"; ?>



    <?php if ($row['availability'] == 1) {
        echo "<a href=\"direct-checkout.php?selected=".$row['id']."\" class=\"learn-more\">Borrow This Equipment »</a>";
    } elseif ($row['availability'] == 0){
        echo "";
    } else echo "Error"; ?>

    <?php echo "</div>"; ?>
    <?php echo "</div>"; ?>

<?php } ?>

