<?php


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Media Team Equipment Management System</title>
    <link rel="stylesheet" type="text/css" href="assets/css/indexstyle.css">
    <script src="assets/js/scripts.js"></script>
</head>

<body>

<div>

    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Login')">Login</button>
        <button class="tablinks" onclick="openTab(event, 'Signup')">Signup</button>
    </div>

    <form action="authentication.php" method="post">
        <div class="tabcontent" id="Login">


            <div>
                <label>
                    <span class="label">Username</span>
                    <input type="text" name="username" id="username" class="input-text" required>
                </label>
            </div>

            <div>
                <label>
                    <span class="label">Password</span>
                    <input type="password" name="password" id="password" class="input-text" required>
                </label>
            </div>

            <div>
                <input type="submit" name="login" class="login" value="Login">
            </div>


        </div>
    </form>


    
    <form action="signup.php" method="post">
        <div class="tabcontent" id="Signup">
    
    
            <div>
                <label>
                    <span class="label">Full Name</span>
                    <input type="text" name="fullname" id="full_name" class="input-text" required>
                </label>
            </div>
    
            <div>
                <label>
                    <span class="label">Username</span>
                    <input type="text" name="username" id="username" class="input-text" required>
                </label>
            </div>
    
            <div>
                <label>
                    <span class="label">Email</span>
                    <input type="text" name="email" id="email" class="input-text" required>
                </label>
            </div>
    
            <div>
                <label>
                    <span class="label">Password</span>
                    <input type="password" name="password_1" id="password_1" class="input-text" required>
                </label>
            </div>
    
            <div>
                <label>
                    <span class="label">Confirm Password</span>
                    <input type="password" name="password_2" id="password_2" class="input-text" required>
                </label>
            </div>
    
            <div>
                <input type="submit" name="reg_user" class="register" value="Register">
            </div>
    
        </div>

    </form>
</div>


</body>
</html>
