<?php
session_start();

// initializing variables
$username = "";
$fullname = "";
$email    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('remotemysql.com', 'tgsK9nTZNV', 'UFJLMZcF2L', 'tgsK9nTZNV');
