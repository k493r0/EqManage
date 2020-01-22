<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {


//    $user = $_SESSION['name'];
//    $equipment = $_POST['equipment'];
//    $notes = $_POST['purpose'];
//    $hash = md5(rand(0, 1000));
//    $requestdate = date('Y-m-d H:i:s');


    $name = $_POST['name'];
    $quantity = $_POST['quantity'];

    echo $name;
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

