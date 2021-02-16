<?php
include('serverconnect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add']) && $_POST['add'] == 1) { //If add action is called

        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $category = $_POST['category_id'];
        $new_category = $_POST['other'];
        $imgID = $_POST['img'];

        $randomNumber = mt_rand(10000000, 99999999);

        if ($new_category == NULL && $category != NULL) { //If cateogory is selected and no new category is made
            $query1 = "insert into EqManage.equipment (equipment,category,totalQuantity,leftQuantity,barcodeID,imgID) 
                        values ('$name','$category','$quantity','$quantity','$randomNumber', '$imgID')";

            if (mysqli_query($db, $query1)) {
                echo "Successfully added equipment";
            } else {
                echo "Error: " . $query1 . "<br>" . mysqli_error($db);
            }

        } elseif ($new_category != NULL) { //If new category is made
            $cat_query = "Insert into EqManage.categories (categoryName) values ('$new_category')";
            if (mysqli_query($db, $cat_query)) {
                $last_id = mysqli_insert_id($db); //The inserted item's ID
                echo "New record created successfully. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $cat_query . "<br>" . mysqli_error($db);
            }


            $query2 = "Insert into EqManage.equipment (equipment,category,totalQuantity,leftQuantity,barcodeID,imgID) 
                        values ('$name','$last_id','$quantity','$quantity','$randomNumber','$imgID')";
            if (mysqli_query($db, $query2)) {
                echo "Successfully added equipment into database";
            } else {
                echo "Error: " . $query2 . "<br>" . mysqli_error($db);
            }
            exit;
        }
    }
    if (isset($_POST['remove']) && $_POST['remove'] == 1 && $_POST['type'] == 1){ //Equipment remove action called
        $eqID = $_POST['id'];
        $getImgID = mysqli_query($db, "Select imgID from EqManage.equipment where id = '$eqID'");
        while ($row = mysqli_fetch_array($getImgID)) {
            $imgID = $row['imgID'];
        } //Get image ID of the equipment to remove
        $directory = $_SERVER['DOCUMENT_ROOT']."/EqManage/assets/images/".$imgID. '.png';
        unlink($directory); //Removing image from directory where filename = imgID.png

        $query2 = "Delete from EqManage.equipment where id="."$eqID";
        if (mysqli_query($db, $query2)) {
            echo "Successfully removed equipment from the database";
        } else {
            echo "Error: " . $query2 . "<br>" . mysqli_error($db);
        }
        exit;
    }

    if (isset($_POST['remove']) && $_POST['remove'] == 1 && $_POST['type'] == 2){//Category remove action called
        $catID = $_POST['id'];
        $query2 = "Delete from EqManage.categories where id="."$catID";
        if (mysqli_query($db, $query2)) {
            echo "Successfully removed category from the database";
        } else {
            echo "Error: " . $query2 . "<br>" . mysqli_error($db);
        }
        exit;
    }

    if (isset($_POST['display']) && $_POST['display'] == 1) {//If the request 'display' is sent with post, fetch and display the newest table
        $results = mysqli_query($db, "SELECT equipment.id, equipment, equipment.totalQuantity, equipment.leftQuantity, equipment.users_id, 
                                                    equipment.lastLog_id, categories.categoryName, categories.id as catID 
                                            FROM EqManage.equipment 
                                            inner join EqManage.categories 
                                            on equipment.category = categories.id");
        while ($row = mysqli_fetch_array($results)) {

            $catName = $row['categoryName'];
            $tqty = $row['totalQuantity'];

            ?>
            <tr>
                <td><?php echo $row['equipment']; ?></td>
                <td><?php echo "<a href='search.php?type=5&id=".$row['catID']."'>$catName</a>";?></td>
                <td><?php echo $row['totalQuantity']; ?></td>
                <td><?php echo $row['leftQuantity']; ?></td>
                <td>
                    <?php

                    if ($row['leftQuantity'] >= 1) {
                        echo "Available";
                    } elseif ($row['leftQuantity'] <= 0){
                        echo "Not Available";
                    } else echo "Error";

                    ?>
                </td>
                <td><?php if ($row['users_id'] != null){
                    echo "<a href='search.php?type=1&id=".$row['users_id']."'>".$row['users_id']."</a>";
                } else echo "-";

                    ?></td>
                <td><?php if ($row['users_id'] != null){
                        echo "<a href='search.php?type=3&id=".$row['lastLog_id']."'>".$row['lastLog_id']."</a>";
                    } else echo "-"; ?></td>
                <td><button type='button' class='btn btn-link' id="removeEq" style="padding: 0; margin: 0" onclick="removeEq(this.value)" value="<?php echo $row['id']; ?>">Remove</button></td>

            </tr>
        <?php }
    }
}
    ?>
