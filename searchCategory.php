<div id="category_button" class=" bootstrap-iso eq" style="margin-top: 10px">
    <div style="position: center" align="center" id="searchEq">
        <label for="categorySelect" style="margin-top: 20px">Search:</label>
        <select id="categorySelect" style="width: 35%; text-align: left;margin-bottom: 10px" onchange="change()" >
                <?php

                $returnResult = mysqli_query($db,"select * from EqManage.categories");
                while ($row = mysqli_fetch_array($returnResult)){

                    echo "<option value=\"\">Select User</option>";
                    $ID = $row['id'];
                    $name = $row['categoryName'];
                    echo "<option value='$ID'>ID: $ID | Category Name: $name</option>";
                };
                ?>
        </select>
    </div>
</div>

<div id="category" class="bootstrap-iso eq" style="margin-top: 10px">
        <?php  include('fetchSearchCategory.php') ?>
    </div>
</div>

<script>

    $(document).ready(function() {

        $("#categorySelect").change(function () {
            var id = $(this).val();
            console.log("Working");

            var url = 'fetchSearchCategory.php?' + 'id=' + id;
            console.log(url);

            $("#category").load(url);
            console.log("Done");

        })});

    $("#categorySelect").select2( {
        placeholder: "Enter user ID",
        allowClear: true,

    } );

    function change() {
        var e = document.getElementById("categorySelect");
        var id = e.options[e.selectedIndex].value;
        console.log(id);

        var url = 'fetchSearchCategory.php?' + 'id=' + id;
        console.log(url);

        $("#category").load(url);
        console.log("Done");
    }
</script>