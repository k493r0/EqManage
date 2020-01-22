<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
include ('serverconnect.php');
?>
<!DOCTYPE html>
<html>

<?php
include('header.php')
?>


<body class="form-v8 loggedin" id="fade">

<div id="loader">
<div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php include('navbar.php'); ?>

<div class="content">
    <?php if (isset($_GET['sent']) && $_GET['sent'] == 1){
        echo '<h2>Message</h2><p style="color: red" >Your request is sent</p>';
    } ?>
    <?php if (isset($_GET['check-out']) && $_GET['check-out'] == 1){
        echo '<h2>Message</h2><p style="color: red" >Successfully Checked Out</p>';
    } ?>
    <?php if (isset($_GET['return']) && $_GET['return'] == 1){
        echo '<h2>Message</h2><p style="color: red" >Successfully Returned</p>';
    } ?>
    <?php if (isset($_GET['return']) && $_GET['return'] == 0){
        echo '<h2>Message</h2><p style="color: red" >Error occurred, please login with the user you borrowed the equipment with</p>';
    } ?>
    <?php if (isset($_GET['adminonly']) && $_GET['adminonly'] == 1){
        echo '<h2>Message</h2><p style="color: red" >This page is only accessible by site admin</p>';
    } ?>

</div>


<div class="features-boxed" style="height: 787px;">
    <div class="container">
        <div class="intro">
            <h2 class="text-center">Availability Status</h2>
            <p class="text-center">In this page, you can check whether the equipment is available or not</p>
            <input id="input" type="text" placeholder="Search.." style="padding-top: 10px;margin-top: 50px">


        </div>









        <div class="row justify-content-center features" id="box">
            <!--<div class="col-sm-6 col-md-5 col-lg-4 item">
                <div class="box">
                    <h3 class="name">Equipment Name</h3>
                    <p class="description">Details</p><a href="#" class="learn-more">Borrow This Equipment »</a></div>
            </div>-->
            <?php $results = mysqli_query($db, "SELECT * FROM equipments"); ?>

            <?php while ($row = mysqli_fetch_array($results)) { ?>

                <?php echo "<div class=\"col-sm-6 col-md-5 col-lg-4 item\">"; ?>



                <?php if ($row['Availability'] == 1) {
                    echo "<div class=\"box\" id='box2'>";
                } elseif ($row['Availability'] == 0){
                    echo "<div class=\"box\" id='box2'>";
                } else echo "Error"; ?>




                <?php /*echo "<h3 class=\"name\">".$row['Equipment']."</h3>"; */?>

                <?php if ($row['Availability'] == 1) {
                    echo "<h3 class=\"name\">".$row['Equipment']."</h3>";
                } elseif ($row['Availability'] == 0){
                    echo "<h3 class=\"name\" style='color: orangered'>".$row['Equipment']."</h3>";
                } else echo "Error"; ?>



                <?php if ($row['Availability'] == 1) {
                    echo "<p class=\"description\">Available";
                } elseif ($row['Availability'] == 0){
                    echo "<p class=\"description\" style='color: red'>Not Available";
                } else echo "Error"; ?>


                <?php echo "</p>"; ?>



                <?php if ($row['Availability'] == 1) {
                    echo "<a href=\"direct-checkout.php?selected=".$row['id']."\" class=\"learn-more\">Borrow This Equipment »</a>";
                } elseif ($row['Availability'] == 0){
                    echo "";
                } else echo "Error"; ?>

                <?php echo "</div>"; ?>
                <?php echo "</div>"; ?>

            <?php } ?>

            <style>

            </style>

        </div>
    </div>

</div>
<script>
    $(document).ready(function(){
        $("#input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#box div").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

</body>

