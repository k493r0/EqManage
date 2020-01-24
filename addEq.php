<?php
include('serverconnect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {


//    $user = $_SESSION['name'];
//    $equipment = $_POST['equipment'];
//    $notes = $_POST['purpose'];
//    $hash = md5(rand(0, 1000));
//    $requestdate = date('Y-m-d H:i:s');


    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category_id'];
    $new_category = $_POST['other'];


    echo $name;
    echo $quantity;

    echo $new_category;

    if ($new_category == NULL && $category != NULL){
        $query1 = "insert into EqManage.equipment (equipment,category,totalQuantity,leftQuantity) values ('$name','$category','$quantity','$quantity')";
        if (mysqli_query($db, $query1)) {
            $last_id = mysqli_insert_id($db);
            echo "Successfully added equipment";
        } else {
            echo "Error: " . $query1 . "<br>" . mysqli_error($db);
        }
    } elseif ($new_category != NULL){
        $cat_query = "Insert into EqManage.categories (categoryName) values ('$new_category')";

        if (mysqli_query($db, $cat_query)) {
            $last_id = mysqli_insert_id($db);
            echo "New record created successfully. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $cat_query . "<br>" . mysqli_error($db);
        }

//        $get_id = "select id from EqManage.equipment where categoryName=$new_category";



        $query2 = "insert into EqManage.equipment (equipment,category,totalQuantity,leftQuantity) values ('$name','$last_id','$quantity','$quantity')";
        if (mysqli_query($db, $query2)) {
            $last_id = mysqli_insert_id($db);
            echo "Successfully added equipment";
        } else {
            echo "Error: " . $query2 . "<br>" . mysqli_error($db);
        }

        exit;
    }





//
//
//
//
//
//    echo $equipment;
//    $query = "INSERT INTO allrequests (User,Equipment,Notes,Hash,Action) VALUES ('$user','$equipment','$notes','$hash', 'Check-Out')";
//
//    mysqli_query($db, $query);
}

if ($_POST['display'] && $_POST['display'] == 1){


$results = mysqli_query($db, "SELECT * FROM EqManage.equipment inner join EqManage.categories on equipment.category = categories.id");
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


    </tr>
<?php } }?>
}

