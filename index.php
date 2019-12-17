<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
echo $_SESSION['username'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Media Team Equipment Management System</title>
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="assets/css/sourcesanspro-font.css">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="assets/css/loaderstyle.css"/>
    <script src="assets/js/scripts.js"></script>


</head>
<body class="form-v8">
<div class="loader"><div></div><div></div><div></div><div></div></div>
</body>

