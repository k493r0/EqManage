<div id="checkoutModal" class="modal" style="display: none;">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" data-dismiss="modal" onclick="resetCoOption();">×</span>

        <div class="select-style" style="width:500px; margin: auto;" align="center">


            <div id="eqselectDiv">
                <?php include('fetchCheckoutEq.php') ?>
            </div>





            <!--                            <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="padding: 10px 15px; border: 1px solid #ccc;-->
            <!--  border-radius: 4px; margin-top: 10px"></textarea>-->
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
                include('fetchAllCheckOut.php');

                ?>

            </select>


            <input id="checkout" name="request" type="submit" value="Confirm Checkout" style="width: 100%;" >
        </div>
    </div>

</div>
<div id="returnModal" class="modal" style="display: none;">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" data-dismiss="modal" onclick="resetReturnOption();">×</span>

        <div class="select-style" style="width:500px; margin: auto;" align="center">


            <div id="returnEqSelectDiv">
                <?php
                include('fetchReturnEq.php');
                ?>
            </div>





            <!--                            <textarea type="text" id="purpose" name="purpose" placeholder="Purpose/Location/Date to be returned" style="padding: 10px 15px; border: 1px solid #ccc;-->
            <!--  border-radius: 4px; margin-top: 10px"></textarea>-->
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
                include('fetchReturnAllCheckout.php');

                ?>

            </select>


            <input id="return" name="request" type="submit" value="Return" style="width: 100%;" >
        </div>
    </div>

</div>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/adminScript.js"></script>
