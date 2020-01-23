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
        $query = "INSERT into EqManage.equipment (equipment, category) values ('$name','$category')";
    } elseif ($new_category != NULL){
        $cat_query = "Insert into EqManage.categories (categoryName) values ('$new_category')";

        if (mysqli_query($db, $cat_query)) {
            $last_id = mysqli_insert_id($db);
            echo "New record created successfully. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $cat_query . "<br>" . mysqli_error($db);
        }

        $get_id = "select id from EqManage.equipment where categoryName=$new_category";


        echo $last_id;


        $query = "insert into EqManage.equipment (equipment,category) values ('$name','')";
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

