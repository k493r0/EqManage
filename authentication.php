<?php
session_start();
$HOST = 'remotemysql.com';
$USER = 'tgsK9nTZNV';
$PASSWORD = 'UFJLMZcF2L';
$DBNAME = 'tgsK9nTZNV';
// Try and connect using the info above.
$con = mysqli_connect($HOST, $USER, $PASSWORD, $DBNAME);
if ( mysqli_connect_errno() ) {
    // If there is an error with the connection, stop the script and display the error.
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    die ('Please fill both the username and password field!');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

}
if ($stmt->num_rows > 0) {
    ob_start();
    $stmt->bind_result($id, $password);
    $stmt->fetch();
    // Account exists, now we verify the password.
    // Note: remember to use password_hash in your registration file to store the hashed passwords.
    if (password_verify($_POST['password'], $password)) {
        // Verification success! User has loggedin!
        // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;

        $fullusername = $_POST['username'];
        echo $fullusername;

        $lastlog = mysqli_query($con,"select * from accounts where username ='$fullusername'");

        $row = mysqli_fetch_array($lastlog);

        echo $row['fullname'];

        $fullname = $row['fullname'];
        echo $fullname;





//        $_SESSION['name'] = $_POST['username'];
        $_SESSION['name'] = $fullname;
        $_SESSION['username'] = $fullusername;
        echo $_SESSION['name'];
        $_SESSION['id'] = $id;
        header('Location: index.php');
    } else {
        ob_start(); //Without it, it lead to no redirection
        echo 'Incorrect password!';
        header('Location: login.php?success=0');
    }
} else {
    ob_start();
    echo 'Incorrect username!';
    header('Location: login.php?username=0');
}
$stmt->close();