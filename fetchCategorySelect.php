<?php
include('serverconnect.php');
$resultset = mysqli_query($db, "select * from EqManage.categories");
?>


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
