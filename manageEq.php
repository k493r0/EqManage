<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1');
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

<?php

if ($_SESSION['username'] == 'administrator'){
    include ('adminNavbar.php');
} else{
    include ('navbar.php');
}

include('serverconnect.php');
?>


<div class="content">
    <div style="height: 63px; opacity: 0; padding: 0; margin: 0" ></div>
    <div id="addAlert" style="color: green;" class="name">Equipment Added</div>
    <div id="removeAlert" style="color: red;" class="name">Equipment Removed</div>
    <div id="removeCatAlert" style="color: red;" class="name">Category Removed</div>

    <div style="padding-top: 0;">
        <h2 style="padding-bottom: 10px; margin-bottom: 20px">Manage Equipment</h2>

            <!-- Trigger/Open The Modal -->
        <h1 style="font-weight: bold; margin-top: 30px; margin-bottom: 10px; text-align: center"><u>Equipment</u></h1>
            <div id="wrapper" style="box-shadow: none;"><button id="addEqBtn" class="btn">Add Equipment</button></div>


            <!-- The Modal -->
            <div id="addEqModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content" style="width: fit-content">
                    <div onclick="hideEqModal()">
                    <span class="close" style="margin-bottom: 10px; float: left">&times;</span>
                    </div>
                    <?php

                    $resultset = mysqli_query($db, "select * from EqManage.categories");
                    ?>
                    <div class="select-style" style="width:500px; margin: auto;" align="center">
                            <input type="text" name="name" placeholder="Equipment Name" id="name" required/>
                            Quantity: <input type="number" min="1" max="100" name="quantity" value="1" id="qty" style="margin-top: 5px;margin-bottom: 5px" required/>

                        <div id="categorySelect"></div>
<!--                            <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="padding: 10px 15px; border: 1px solid #ccc;-->
<!--  border-radius: 4px; margin-top: 10px"></textarea>-->

                        <div class="panel-body" align="center" id="upload-div">
                            <strong>Upload equipment image</strong><input type="file" name="upload_image" id="upload_image" onchange="imageCrop(this)" />
                            <br />
                            <div id="uploaded_image"></div>
                        </div>

                            <input id="add" name="request" type="submit" value="Add Equipment" style="width: 100%;">
                    </div>


                </div>

            </div>

        <div id="uploadimageModal" class="modal" role="dialog" style="z-index: 10000">
                <div class="modal-content" style="width:fit-content">
                        <h4 class="modal-title" style="float: left"></h4>
                        <div class="row">
                            <div class="col-md-7 text-center">
                                <div id="image" style="width:350px; margin-top:30px"></div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button class="btn btn-info crop_image">Crop & Upload Image</button>
                    </div>
                </div>
        </div>





        <?php $results = mysqli_query($db, "SELECT * FROM EqManage.equipment inner join EqManage.categories on equipment.category = categories.id"); ?>

        <table width="100%" id="table">
            <thead>
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Category</th>
                <th scope="col">Total Qty</th>
                <th scope="col">Left Qty</th>
                <th scope="col">Availability</th>
                <th scope="col">Last used user ID</th>
                <th scope="col">Last log ID</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody id="table2">
            </tbody>
        </table>
        <h1 style="font-weight: bold; margin-top: 30px;margin-bottom: 10px;text-align: center"><u>Categories</u></h1>
        <table width="100%" id="table">
            <thead>
            <tr>
                <th scope="col">Category Name</th>
                <th scope="col">Number of equipment in this cateogry</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody id="cattable">
            </tbody>
        </table>



<!--        <table>-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th scope="col" colspan="2">Item</th>-->
<!--                <th scope="col">Qty</th>-->
<!--                <th scope="col">Price</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr>-->
<!--                <td>Don&#8217;t Make Me Think by Steve Krug</td>-->
<!--                <td>In Stock</td>-->
<!--                <td>1</td>-->
<!--                <td>$30.02</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>A Project Guide to UX Design by Russ Unger &#38; Carolyn Chandler</td>-->
<!--                <td>In Stock</td>-->
<!--                <td>2</td>-->
<!--                <td>$52.94 ($26.47 &#215; 2)</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Introducing HTML5 by Bruce Lawson &#38; Remy Sharp</td>-->
<!--                <td>Out of Stock</td>-->
<!--                <td>1</td>-->
<!--                <td>$22.23</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Bulletproof Web Design by Dan Cederholm</td>-->
<!--                <td>In Stock</td>-->
<!--                <td>1</td>-->
<!--                <td>$30.17</td>-->
<!--            </tr>-->
<!--            </tbody>-->
<!--            <tfoot>-->
<!--            <tr>-->
<!--                <td colspan="3">Subtotal</td>-->
<!--                <td>$135.36</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td colspan="3">Tax</td>-->
<!--                <td>$13.54</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td colspan="3">Total</td>-->
<!--                <td>$148.90</td>-->
<!--            </tr>-->
<!--            </tfoot>-->
        </table>

    </div>

</div>

<?php

if ($_SESSION['username'] == 'administrator'){
    include ('adminModal.php');
}

?>
<script>
    // Get the modal

    var addAlert = document.getElementById("addAlert");
    addAlert.style.display = "none";
    var removeAlert = document.getElementById("removeAlert");
    removeAlert.style.display = "none";
    var removeCatAlert = document.getElementById("removeCatAlert");
    removeCatAlert.style.display = "none";
    var addEqModal = document.getElementById("addEqModal");

    // Get the button that opens the modal
    var addEqBtn = document.getElementById("addEqBtn");

    // Get the <span> element that closes the modal
    // var span = document.getElementsByClassName("close")[0];
    //
    // // When the user clicks on <span> (x), close the modal
    // span.onclick = function() {
    //     addEqModal.style.display = "none";
    // };

    // When the user clicks on the button, open the modal
    addEqBtn.onclick = function() {
        addEqModal.style.display = "block";
    };


    function hideEqModal(){
        addEqModal.style.display = "none";
        resetFields();
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target === modal) {
            addEqModal.style.display = "none";
            resetFields();
        }
    };

    function selectOther(val){
        var element=document.getElementById('other');
        if(val==='Select the Category'||val==='Other')
            element.style.display='block';
        else
            element.style.display='none';
    }

    $(document).ready(function(){
        displayFromDatabase();
        $("#categorySelect").load("fetchCategorySelect.php");
        $("#add").click(function (e){
            var name = document.getElementById("name").value;
            var qty = document.getElementById("qty").value;
            var e = document.getElementById("cat");
            var cat = e.options[e.selectedIndex].value;
            var ncat = document.getElementById("other").value;
            var img = document.getElementById("eqImg").value;
            $.ajax({
                url: "editEq.php",
                type: "POST",
                async: false,
                data:{
                    "add":1,
                    "name":name,
                    "quantity":qty,
                    "category_id":cat,
                    "other":ncat,
                    "img":img
                },
                success: function(data){
                    displayFromDatabase();
                    addEqModal.style.display = "none";
                    resetFields();
                    var element=document.getElementById('other');
                    element.style.display='none';
                    var addAlert = document.getElementById("addAlert");
                    addAlert.style.display = "block";
                    var removeAlert = document.getElementById("removeAlert");
                    removeAlert.style.display = "none";
                    var removeCatAlert = document.getElementById("removeCatAlert");
                    removeCatAlert.style.display = "none";
                    console.log(data);

                }
            });
        });


    });


    function resetFields() {
        document.getElementById("name").value = "";
        document.getElementById("qty").value = "1";
        document.getElementById("cat").value = "";
        document.getElementById("other").value ="";
        $("#upload-div").load(" #upload-div");
    }

    function displayFromDatabase(){
        $.ajax({
            url: "editEq.php",
            type: "POST",
            async: false,
            data: {
                "display": 1
            },
            success:function (data) {
                $("#table2").html(data);
            }

        })
        $("#cattable").load("fetchCategoryTable.php");
        $("#categorySelect").load("fetchCategorySelect.php");
    }

    function removeEq(id) {
        console.log("Pressed");
        $.ajax({
            url: "editEq.php",
            type: "POST",
            async: false,
            data:{
                "id":id,
                "remove":1,
                "type":1
            },
            success: function(data){
                displayFromDatabase();
                var removeAlert = document.getElementById("removeAlert");
                removeAlert.style.display = "block";
                var addAlert = document.getElementById("addAlert");
                addAlert.style.display = "none";
                var removeCatAlert = document.getElementById("removeCatAlert");
                removeCatAlert.style.display = "none";

                console.log(data);
            }

        });
    }

    function removeCat(id) {
        $.ajax({
            url: "editEq.php",
            type: "POST",
            async: false,
            data:{
                "id":id,
                "remove":1,
                "type":2
            },
            success: function(data){
                displayFromDatabase();
                var removeAlert = document.getElementById("removeCatAlert");
                removeAlert.style.display = "block";
                var addAlert = document.getElementById("addAlert");
                addAlert.style.display = "none";
                var removeAlert = document.getElementById("removeAlert");
                removeAlert.style.display = "none";
                console.log(data);
            }

        });
    }


    $image_crop = $('#image').croppie({ //Calling croppie api on image div to set parameters
        //parameter setting
        enableExif: true,
        viewport: {
            width:250,
            height:250,
            type:'square' //circle
        },
        boundary:{
            width:310,
            height:310
        }
    });

    function imageCrop(image){ //Called when image uploaded with input
        var reader = new FileReader();
        reader.onload = function (event) {
            $image_crop.croppie('bind', {//Binding jQuery
                url: event.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        };
        reader.readAsDataURL(image.files[0]);//Display the image as a preview
        $('#uploadimageModal').modal('show');
    }


    $('.crop_image').click(function(event){ //When crop & upload image button pressed
        $image_crop.croppie('result', { //Set croppie parameters
            type: 'canvas',
            size: 'original'
        }).then(function(response){ //Send the cropped image to upload-image.php via ajax
            $.ajax({
                url:"upload-image.php",
                type: "POST",
                data:{"image": response},
                success:function(data)
                {
                    $('#uploadimageModal').modal('hide');
                    $('#uploaded_image').html(data); //Hide modal and display processed & uploaded image
                    //after processing done in upload-image.php
                }
            });
        })
    });



</script>
