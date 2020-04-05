<div id="eq_button" class=" bootstrap-iso eq" style="margin-top: 10px">
    <div style="position: center" align="center" id="searchEq">
        <label for="eqSelect" style="margin-top: 20px">Search:</label>
        <select id="eqSelect" style="width: 20%; text-align: left;margin-bottom: 10px" onchange="change()">
                <?php

                $returnResult = mysqli_query($db,"select * from EqManage.equipment");
                while ($row = mysqli_fetch_array($returnResult)){

                    echo "<option value=\"\">Select User</option>";
                    $ID = $row['id'];
                    $name = $row['equipment'];
                    echo "<option value='$ID'>ID: $ID | Name: $name</option>";
                };
                ?>
        </select>
    </div>
</div>

<div id="eq" class="bootstrap-iso eq" style="margin-top: 10px">
        <?php  include('fetchSearchEq.php') ?>
    </div>
</div>

<script>

    $(document).ready(function() {

        $("#eqSelect").change(function () {
            var id = $(this).val();
            console.log("Working");

            var url = 'fetchSearchEq.php?' + 'id=' + id;
            console.log(url);

            $("#user").load(url);
            console.log("Done");

        })});

    $("#eqSelect").select2( {
        placeholder: "Enter user ID",
        allowClear: true,

    } );

    function change() {
        var e = document.getElementById("eqSelect");
        var id = e.options[e.selectedIndex].value;
        console.log(id);

        var url = 'fetchSearchEq.php?' + 'id=' + id;
        console.log(url);

        $("#eq").load(url);
        console.log("Done");
    }
</script>