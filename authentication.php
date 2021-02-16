<?php
session_start();
include('serverconnect.php');

if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data
    die ('Please fill both the username and password field!');
}
if ($stmt = $db->prepare('SELECT id, password FROM users WHERE username = ?')) {//Get the id and password from the users database
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

}

if ($stmt->num_rows > 0) {//account exists
    ob_start();
    $stmt->bind_result($id, $password);
    $stmt->fetch();
    if (password_verify($_POST['password'], $password)) {//Password in database is compared to the hashed input
        session_regenerate_id();
        $_SESSION['loggedin'] = true;//Creates session
        $fullusername = $_POST['username'];
        $lastlog = mysqli_query($db,"select * from users where username ='$fullusername'");
        $row = mysqli_fetch_array($lastlog);
        $fullname = $row['fullname'];
        //Setting session variables
        $_SESSION['name'] = $fullname;
        $_SESSION['username'] = $fullusername;
        $_SESSION['id'] = $id;
        header('Location: index.php');
    } else {
        ob_start(); //Without it, it lead to no redirection
        echo 'Incorrect password!';
        header('Location: login.php?success=0');
        ob_end_flush();
    }
} else {
    ob_start();
    echo 'Incorrect username!';
    header('Location: login.php?username=0');
    ob_end_flush();
}
$stmt->close();
