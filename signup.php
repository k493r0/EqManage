<?php
session_start();

// initializing variables
$username = "";
$fullname = "";
$email    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('bowij1jp1qu5kwy79igt-mysql.services.clever-cloud.com', 'u9tgb8b4hu8gxlsy', 'tViTNqqvk2MwXcFx2Gj5', 'bowij1jp1qu5kwy79igt');

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $fullname = mysqli_real_escape_string($db,$_POST['fullname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($fullname)) { array_push($errors, "Full Name is required"); }
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database

        $query = "INSERT INTO users (fullname,username, email, password) 
  			  VALUES('$fullname','$username', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['loggedin'] = "You are now logged in";
        $_SESSION['msg']="Updation successfully completed";
        header("Location: login.php?success=1");
    }
}
