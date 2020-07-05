<?php
include('serverconnect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add']) && $_POST['add'] == 1) {

        //    $user = $_SESSION['name'];
        //    $equipment = $_POST['equipment'];
        //    $notes = $_POST['purpose'];
        //    $hash = md5(rand(0, 1000));
        //    $requestdate = date('Y-m-d H:i:s');

        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $category = $_POST['category_id'];
        $new_category = $_POST['other'];
        $imgID = $_POST['img'];


        $randomNumber = mt_rand(10000000, 99999999);

        //    echo $name;
        //    echo $quantity;
        //    echo $new_category;

        if ($new_category == NULL && $category != NULL) { //If cateogory is selected and no new category is made
            $query1 = "insert into EqManage.equipment (equipment,category,totalQuantity,leftQuantity,barcodeID,imgID) values ('$name','$category','$quantity','$quantity','$randomNumber', '$imgID')";
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


            $query2 = "insert into EqManage.equipment (equipment,category,totalQuantity,leftQuantity,barcodeID,imgID) values ('$name','$last_id','$quantity','$quantity','$randomNumber','$imgID')";
            if (mysqli_query($db, $query2)) {
                echo "Successfully added equipment into database";
            } else {
                echo "Error: " . $query2 . "<br>" . mysqli_error($db);
            }
            exit;
        }


    }
    if (isset($_POST['remove']) && $_POST['remove'] == 1 && $_POST['type'] == 1){
        $eqID = $_POST['id'];
        $getImgID = mysqli_query($db, "Select imgID from EqManage.equipment where id = '$eqID'");
        while ($row = mysqli_fetch_array($getImgID)) {
            $imgID = $row['imgID'];
        }
        $directory = $_SERVER['DOCUMENT_ROOT']."/EqManage/assets/images/".$imgID. '.png';
        echo $directory;
        unlink($directory);

        $query2 = "Delete from EqManage.equipment where id="."$eqID";
        echo $query2;
        if (mysqli_query($db, $query2)) {
            echo "Successfully removed equipment from the database";
        } else {
            echo "Error: " . $query2 . "<br>" . mysqli_error($db);
        }
        exit;
    }

    if (isset($_POST['remove']) && $_POST['remove'] == 1 && $_POST['type'] == 2){
        $catID = $_POST['id'];
        $query2 = "Delete from EqManage.categories where id="."$catID";
        echo $query2;
        if (mysqli_query($db, $query2)) {
            echo "Successfully removed category from the database";
        } else {
            echo "Error: " . $query2 . "<br>" . mysqli_error($db);
        }
        exit;
    }

    if (isset($_POST['display']) && $_POST['display'] == 1) {


        $results = mysqli_query($db, "SELECT equipment.id, equipment, totalQuantity, leftQuantity, users_id, lastLog_id, categoryName FROM EqManage.equipment inner join EqManage.categories on equipment.category = categories.id");
        while ($row = mysqli_fetch_array($results)) {

            $catName = $row['categoryName'];
            $tqty = $row['totalQuantity'];

            ?>
            <tr>
                <td><?php echo $row['equipment']; ?></td>
                <td><?php echo "<a href='#'>$catName</a>";?></td>
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
                <td><?php echo $row['users_id']; ?></td>
                <td><?php echo $row['lastLog_id']; ?></td>
                <td><button type='button' class='btn btn-link' id="removeEq" style="padding: 0; margin: 0" onclick="removeEq(this.value)" value="<?php echo $row['id']; ?>">Remove</button></td>

            </tr>
        <?php }
    }


}
    ?>
