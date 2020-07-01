<?php
include ('serverconnect.php');
require 'vendor/autoload.php';


$getEqName = mysqli_query($db, "select * from EqManage.equipment");
while ($row = mysqli_fetch_array($getEqName)) {
    $filepath = $_SERVER['DOCUMENT_ROOT']."/EqManage/assets/barcode/".$row['id']."_barcode.png";
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $white = [255, 255, 255];
    file_put_contents($filepath, $generator->getBarcode($row['barcodeID'], $generator::TYPE_CODE_128, 3, 50));
}

if (isset($_GET['download']) && isset($_GET['id']) && $_GET['download'] == 1){
$eqID = $_GET['id'];
$file = $_SERVER['DOCUMENT_ROOT'] . "/EqManage/assets/barcode/" . $eqID . "_barcode.png";
echo $file;
if (file_exists($file)) {
    echo "hello";
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
}};


?>
<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
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
    <?php if (isset($_GET['verify']) && $_GET['verify'] == 1){
        echo '<h2>Message</h2><p style="color: red" >Successfully Verified</p>';
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


<?php $getCategory = mysqli_query($db, "SELECT * FROM EqManage.categories");

?>


<div class="features-boxed" style="height: 787px;">
    <div class="container">
        <div class="intro" style="text-align: center">

            <h2 class="text-center">Barcode</h2>
            <p class="text-center">In this page, you can print/download the barcodes</p>
            <button type="button" class="btn btn-info" style="margin-top:10px" onclick="window.location.href='barcodePDF.php'">Download PDF</button>

        </div>


        <div class="row justify-content-center features" id="box">

                <?php
                $getEqName = mysqli_query($db, "select * from EqManage.equipment");
                while ($row = mysqli_fetch_array($getEqName)) {
                    $eqname = $row['equipment'];
                    $barcodeID = $row['barcodeID'];
                ?>
            <div class="col-sm-6 col-md-5 col-lg-4 item">
                <div class="box" id='box2'>
                    <h3 class="name"><?php echo $eqname ?></h3>
                    <?php
                    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                    echo '<img style="margin-bottom:20px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcodeID, $generator::TYPE_CODE_128)) . '">';
                    echo '<button type=\'button\' class=\'btn btn-link\' value=\''.$row['id'].'\' onclick="downloadBarcode(this.value)">Download This Barcode</button>'
                    ?>
                </div>
            </div>
               <?php } ?>
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

                // document.getElementById("add-cart").onclick(function() {
                //     $(".dropdown-toggle").dropdown("toggle");
                //     console.log("opened");
                // });
                // $('.trigger_button').click(function(e){
                //     // Kill click event:
                //     e.stopPropagation();
                //
                //     console.log("pressed");
                //     $('.dropdown-toggle').dropdown('toggle');
                // });

            });







            /* $(document).ready(function getIndex(){
                 $("#select-box1").onchange(function getIndex1(){
                     var e = document.getElementById("select-box1");
                     var cat = e.options[e.selectedIndex].value;
                     $.ajax({
                         url: "fetchindex.php",
                         type: "POST",
                         async: false,
                         data:{
                             "filterCat":cat
                         },
                         success: function(data){
                             displayFromDatabase();
                         }

                     });
                 });
             });*/

            function getIndex1(){
                var e = document.getElementById("select-box1");
                var cat = e.options[e.selectedIndex].value;
                var e2 = document.getElementById("select-box2");
                var sortC = e2.options[e2.selectedIndex].value;
                var e3 = document.getElementById("select-box3");
                var sortE = e3.options[e3.selectedIndex].value;
                $.ajax({
                    url: "fetchIndex.php",
                    type: "POST",
                    async: false,
                    data: {
                    },
                    success:function(data){

                        displayFromDatabase(cat,sortC,sortE);
                    }

                })
            }
            function displayFromDatabase(filter,sortC,sortE){
                $.ajax({
                    url: "fetchIndex.php",
                    type: "POST",
                    async: false,
                    data: {
                        "display": 1,
                        "filterCat": filter,
                        "sortC":sortC,
                        "sortE":sortE
                    },
                    success:function (data) {
                        $("#box").html(data);
                    }

                })
            }

            function addCart(eqID) {
                console.log(eqID);
                var idname = eqID + "_qty";
                var qty = document.getElementById(idname).value;
                console.log(qty);

                $.ajax({
                    url:"navbarCart.php",
                    type:"POST",
                    data:{
                        "eqID":eqID,
                        "qty":qty
                    },
                    success:function (data) {
                        console.log("added to cart");
                        $("#cartDiv").html(data);
                        console.log(data);
                    }
                })
            }

            function clearCart() {
                $.ajax({
                    url:"navbarCart.php",
                    type:"POST",
                    data:{
                        "destroy_cart":"1",
                    },
                    success:function (data) {
                        console.log("cleared cart");
                        $("#cartDiv").html(data);
                    }
                })
            }

            function deleteItem(eqID) {
                console.log(eqID);
                $.ajax({
                    url:"navbarCart.php",
                    type:"POST",
                    data:{
                        "delete":"1",
                        "eqID":eqID
                    },
                    success:function (data) {
                        console.log("deleted item");
                        $("#cartDiv").html(data);
                        console.log(data);
                    }
                })
            }

            function updateQty(eqID, qty) {
                console.log(qty);
                console.log(eqID);
                $.ajax({
                    url:"navbarCart.php",
                    type:"POST",
                    data:{
                        "update":"1",
                        "qty":qty,
                        "eqID":eqID
                    },
                    success:function (data) {
                        $("#cartDiv").html(data);
                        console.log(data);
                    }
                })

            }

            function downloadBarcode(id) {
                console.log(id);
                var url = "barcode.php?download=1&id="+id;
                window.location.replace(url);


            }


        </script>

</body>



