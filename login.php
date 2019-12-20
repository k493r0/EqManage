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
    <link rel="stylesheet" href="assets/css/indexstyle.css"/>
    <script src="assets/js/scripts.js"></script>


</head>
<body class="form-v8">

<div class="page-content">

    <div class="form-v8-content">

        <div class="form-left">
            <img src="assets/images/icon1.jpeg" alt="form" style="object-fit: cover;width:469px;height: 584px">
        </div>

        <div class="form-right">
            <div class="tab">
                <div class="tab-inner">
                    <button class="tablinks" onclick="openTab(event, 'signup')" id="defaultOpen">Sign Up</button>
                </div>
                <div class="tab-inner">
                    <button class="tablinks" onclick="openTab(event, 'signin')">Sign In</button>
                </div>
            </div>

            <form class="form-detail" action="signup.php" method="post">
                <div class="tabcontent" id="signup">

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="text" name="fullname" id="full_name" class="input-text" value="<?php echo $fullname; ?>" required>
                            <span class="label">Full Name</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="text" name="username" id="full_name" class="input-text" value="<?php echo $username; ?>" required>
                            <span class="label">Username</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="email" name="email" id="your_email" class="input-text" value="<?php echo $email; ?>" required>
                            <span class="label">E-Mail</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="password" name="password_1" id="password" class="input-text" required>
                            <span class="label">Password</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="password" name="password_2" id="comfirm_password" class="input-text" required>
                            <span class="label">Comfirm Password</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row-last">
                        <input type="submit" name="reg_user" class="register" value="Register">
                        <?php if ( isset($_GET['success']) && $_GET['success'] == 1 )
                        {
                            // treat the succes case ex:
                            echo "      You can now login";
                        } ?>
                        <?php if ( isset($_GET['success']) && $_GET['success'] == 0 )
                        {
                            // treat the succes case ex:
                            echo "     Wrong Password";
                        } ?>
                        <?php if ( isset($_GET['username']) && $_GET['username'] == 0){
                            echo "     Wrong Username";
                        } ?>
                        <?php if ( isset($_GET['logout']) && $_GET['logout'] == 1 )
                        {
                            echo "      Successfully logged out";
                        } ?>
                    </div>
                </div>
            </form>


            <div class="tabcontent" id="signin">
            <form class="form-detail" action="authentication.php" method="post">

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="text" name="username" id="username" class="input-text" required>
                            <span class="label">Username</span>
                            <span class="border"></span>
                        </label>
                    </div>
                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="password" name="password" id="password" class="input-text" required>
                            <span class="label">Password</span>
                            <span class="border"></span>
                        </label>
                    </div>
                    <div class="form-row-last">

                        <input type="submit" name="login" class="register" value="Login">

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("defaultOpen").click();
</script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
