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

<?php include('navbar.php'); ?>

<div class="content">
    <div>
        <h2>Manage Equipment</h2>

        <p>

            <!-- Trigger/Open The Modal -->
            <button id="Btn">Open Modal</button>

            <!-- The Modal -->
            <div id="Modal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close">&times;</span>


                </div>

</div>


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

</script>
