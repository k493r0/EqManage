<div id="checkoutModal" class="modal" style="display: none;">
    <!-- Modal content -->
    <div class="modal-content" style="width: fit-content">
        <span class="close" style="margin-bottom: 10px;" data-dismiss="modal" onclick="resetCoOption();">×</span>
        <div class="select-style" style="width:500px; margin: auto;" align="center">
            <div id="eqselectDiv">
                <?php include('fetchCheckoutEq.php') ?>
            </div>
            <p>  </p>
            <select id="studentselect" style="width: 100%; margin-bottom: 10px">
                <option value="">Student Name</option>
                <?php
                include('fetchName.php');
                ?>
            </select>
            <p>  </p>
            <select id="checkOutSelect" style="width: 100%; margin-bottom: 10px">
                <option value=""></option>
                <?php
                include('fetchAllRq.php');
                ?>
            </select>
            <input id="checkout" name="request" type="submit" value="Confirm Checkout" style="width: 100%;" >
        </div>
    </div>
</div>
<div id="returnModal" class="modal" style="display: none;">
    <div class="modal-content" style="width: fit-content">
        <span class="close" style="margin-bottom: 10px;" data-dismiss="modal" onclick="resetReturnOption();">×</span>
        <div class="select-style" style="width:500px; margin: auto;" align="center">
            <div id="returnEqSelectDiv">
                <?php
                include('fetchReturnEq.php');
                ?>
            </div>
            <p>  </p>
            <select id="returnStudentSelect" style="width: 100%; margin-bottom: 10px">
                <option value="">Student Name</option>
                <?php
                include('fetchReturnName.php');
                ?>
            </select>
            <p>  </p>
            <select id="returnSelect" style="width: 100%; margin-bottom: 10px">
                <option value=""></option>
                <?php
                include('fetchReturnAllRq.php');
                ?>
            </select>
            <input id="return" name="request" type="submit" value="Return" style="width: 100%;" >
        </div>
    </div>
</div>
<!--Third party script for the 'Select' function-->
<script src="assets/js/select2.min.js"></script>
<!--Scripts only required by Admin Pages-->
<script src="assets/js/adminScript.js"></script>

