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

    <div>
        <h2>Manage Equipment</h2>

        <p>

            <!-- Trigger/Open The Modal -->
            <div id="wrapper"><button id="Btn" class="btn">Add Equipment</button></div>


            <!-- The Modal -->
            <div id="Modal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <?php

                    $resultset = mysqli_query($db, "select * from EqManage.categories");
                    ?>
                    <div class="select-style" style="width:500px; margin: auto;" align="center">
                        <form action="addEq.php" style="width: 100%;" align="center" method="POST">
                            <input type="text" name="name" placeholder="Equipment Name" required/>
                            Quantity: <input type="number" min="1" max="100" name="quantity"/>
                            <select name="category" class="select-picker" onchange="selectOther(this.value);" style="margin-bottom: 10px">


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

                            <input name="request" type="submit" value="Add Equipment" style="width: 100%;">
                        </form>
                    </div>

                </div>

</div>





        <?php $results = mysqli_query($db, "SELECT * FROM EqManage.equipment"); ?>

        <table>
            <thead>
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Category ID</th>
                <th scope="col">Total Qty</th>
                <th scope="col">Left Qty</th>
                <th scope="col">Availability</th>
                <th scope="col">Last used user ID</th>
                <th scope="col">Last log ID</th>
            </tr>
            </thead>
            <tbody>

            <?php while ($row = mysqli_fetch_array($results)) {

                $cat = $row['category']
                ?>
                <tr>
                    <td><?php echo $row['equipment']; ?></td>
                    <td><?php echo "<a href='#' id=\"tooltipdemo\">$cat</a>";?></td>
                    <td>
                        <?php

                        if ($row['category'] == 1) {
                            echo '<dt style="color:red";">
                                Available </dt>';
                        } elseif ($row['Availability'] == 0){
                            echo "Not Available";
                        } else echo "Error";

                        ?>
                    </td>

                </tr>
            <?php } ?>



            </tbody>
        </table>

        <style>
            a#tooltipdemo {
                position: relative ;
            }
            a#tooltipdemo:hover::after {
                content: "" ;
                position: absolute ;
                top: 1.1em ;
                left: 1em ;
                min-width: 200px ;
                border: 1px #808080 solid ;
                padding: 8px ;
                color: black ;
                background-color: #cfc ;
                z-index: 1 ;
            }
        </style>



        <table>
            <thead>
            <tr>
                <th scope="col" colspan="2">Item</th>
                <th scope="col">Qty</th>
                <th scope="col">Price</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Don&#8217;t Make Me Think by Steve Krug</td>
                <td>In Stock</td>
                <td>1</td>
                <td>$30.02</td>
            </tr>
            <tr>
                <td>A Project Guide to UX Design by Russ Unger &#38; Carolyn Chandler</td>
                <td>In Stock</td>
                <td>2</td>
                <td>$52.94 ($26.47 &#215; 2)</td>
            </tr>
            <tr>
                <td>Introducing HTML5 by Bruce Lawson &#38; Remy Sharp</td>
                <td>Out of Stock</td>
                <td>1</td>
                <td>$22.23</td>
            </tr>
            <tr>
                <td>Bulletproof Web Design by Dan Cederholm</td>
                <td>In Stock</td>
                <td>1</td>
                <td>$30.17</td>
            </tr>
            </tbody>
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
        </p>

    </div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById("Modal");

    // Get the button that opens the modal
    var btn = document.getElementById("Btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function selectOther(val){
        var element=document.getElementById('other');
        if(val=='Select the Category'||val=='Other')
            element.style.display='block';
        else
            element.style.display='none';
    }
</script>