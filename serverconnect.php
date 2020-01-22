<?php
session_start();

// initializing variables
$username = "";
$fullname = "";
$email    = "";
$errors = array();

// connect to the database
//$db = mysqli_connect('remotemysql.com', 'tgsK9nTZNV', 'UFJLMZcF2L', 'tgsK9nTZNV');
$db = mysqli_connect('remotemysql.com', 'aJNhE8Tihv', '9gY0DX3OdL', 'aJNhE8Tihv');

if ( mysqli_connect_errno() ) {
    // If there is an error with the connection, stop the script and display the error.
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

