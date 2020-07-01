<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: index.php');
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

<?php
include('navbar.php');
include('serverconnect.php');
?>


<div class="content">
    <div id="alert" >Equipment Added</div>

    <div style="padding-top: 0; margin-top: 7%">
        <h2>Manage Equipment</h2>

            <!-- Trigger/Open The Modal -->
            <div id="wrapper" style="box-shadow: none; padd"><button id="Btn" class="btn">Add Equipment</button></div>


            <!-- The Modal -->
            <div id="Modal" class="modal">

                <!-- Modal content -->
                <div class="modal-content" style="width: fit-content">
                    <span class="close" style="margin-bottom: 10px">&times;</span>
                    <?php

                    $resultset = mysqli_query($db, "select * from EqManage.categories");
                    ?>
                    <div class="select-style" style="width:500px; margin: auto;" align="center">
                            <input type="text" name="name" placeholder="Equipment Name" id="name" required/>
                            Quantity: <input type="number" min="1" max="100" name="quantity" id="qty" style="margin-top: 5px;margin-bottom: 5px"/>
                            <select id="cat" name="category" class="select-picker" onchange="selectOther(this.value);" style="margin-bottom: 10px">


                                <option value="" disabled selected>Select the category</option>
                                <?php

                                while ($row = mysqli_fetch_array($resultset)){

                                    $category = $row['categoryName'];
                                    $category_id = $row['id'];
                                    echo $row[$category_id];

                                    if (isset($_GET['selected']) && $_GET['selected'] == $category_id){
                                        echo "<option name='category_id' value='$category_id' selected='selected'>$category</option>";
                                    } else echo "<option name='category_id' value='$category_id' >$category</option>";
                                }
                                ?>
                                <option value="Other">Other...</option>
                                <input type="text" name="other" id="other" style='display:none;' placeholder="New category name"/>

                            </select>
<!--                            <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="padding: 10px 15px; border: 1px solid #ccc;-->
<!--  border-radius: 4px; margin-top: 10px"></textarea>-->

                            <input id="add" name="request" type="submit" value="Add Equipment" style="width: 100%;">
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
            </tr>
            </thead>
            <tbody id="table2">

<!--            --><?php //while ($row = mysqli_fetch_array($results)) {
//
//                $catName = $row['categoryName'];
//                $tqty = $row['totalQuantity'];
//
//                ?>
<!--                <tr>-->
<!--                    <td>--><?php //echo $row['equipment']; ?><!--</td>-->
<!--                    <td>--><?php //echo "<a href='#'>$catName</a>";?><!--</td>-->
<!--                    <td>--><?php //echo $row['totalQuantity']; ?><!--</td>-->
<!--                    <td>--><?php //echo $row['leftQuantity']; ?><!--</td>-->
<!--                    <td>-->
<!--                        --><?php
//
//                        if ($row['leftQuantity'] >= 1) {
//                            echo "Available";
//                        } elseif ($row['leftQuantity'] <= 0){
//                            echo "Not Available";
//                        } else echo "Error";
//
//                        ?>
<!--                    </td>-->
<!--                    <td>--><?php //echo $row['users_id']; ?><!--</td>-->
<!--                    <td>--><?php //echo $row['lastLog_id']; ?><!--</td>-->
<!---->
<!---->
<!--                </tr>-->
<!--            --><?php //} ?>

            <?php include('fetchEquipmentTable.php') ?>



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

<script>
    // Get the modal
    var alert = document.getElementById("alert");
    alert.style.display = "none";
    var modal = document.getElementById("Modal");

    // Get the button that opens the modal
    var btn = document.getElementById("Btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    function selectOther(val){
        var element=document.getElementById('other');
        if(val=='Select the Category'||val=='Other')
            element.style.display='block';
        else
            element.style.display='none';
    }

    $(document).ready(function(){
        $("#add").click(function (){
            var name = document.getElementById("name").value;
            var qty = document.getElementById("qty").value;
            var e = document.getElementById("cat");
            var cat = e.options[e.selectedIndex].value;
            var ncat = document.getElementById("other").value;
            $.ajax({
                url: "addEq.php",
                type: "POST",
                async: false,
                data:{
                    "name":name,
                    "quantity":qty,
                    "category_id":cat,
                    "other":ncat


                },
                success: function(data){
                    displayFromDatabase();
                    modal.style.display = "none";
                    document.getElementById("name").value = "";
                    document.getElementById("qty").value = "";
                    document.getElementById("cat").value = "";
                    document.getElementById("other").value ="";
                    var element=document.getElementById('other');
                    element.style.display='none';
                    var alert = document.getElementById("alert");
                    alert.style.display = "block";
                }

            });
        });
    });


    function displayFromDatabase(){
        $.ajax({
            url: "addEq.php",
            type: "POST",
            async: false,
            data: {
                "display": 1
            },
            success:function (data) {
                $("#table2").html(data);
            }

        })
    }







</script>
