<div id="user_button" class="tab-pane fade in active bootstrap-iso user" style="margin-top: 10px">
    <div style="position: center" align="center" id="searchUser">
        <label for="userSelect" style="margin-top: 20px">Search:</label>
        <select id="userSelect" style="width: 20%; text-align: left;margin-bottom: 10px" onchange="change()">

                <?php
                $returnResult = mysqli_query($db,"select * from EqManage.users");
                while ($row = mysqli_fetch_array($returnResult)){

                    echo "<option value=\"\">Select User</option>";
                    $userID = $row['id'];
                    $fullname = $row['fullname'];
                    echo "<option value='$userID'>ID: $userID | Name: $fullname</option>";
                };
                ?>

        </select>
    </div>
</div>

<div id="user" class="tab-pane fade in active bootstrap-iso user" style="margin-top: 10px">
        <?php
        include ('fetchSearchUser.php');
        ?>
    </div>
</div>


<script>

    $(document).ready(function() {

        $("#userSelect").change(function () {
            var id = $(this).val();
            console.log("Working");

            var url = 'fetchSearchUser.php?' + 'id=' + id;
            console.log(url);

            $("#user").load(url);
            console.log("Done");

        })});

    $("#userSelect").select2( {
        placeholder: "Enter user ID",
        allowClear: true,

    } );

    function change() {
        var e = document.getElementById("userSelect");
        var id = e.options[e.selectedIndex].value;
        console.log(id);

        var url = 'fetchSearchUser.php?' + 'id=' + id;
        console.log(url);

        $("#user").load(url);
        console.log("Done");
    }
</script>