<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: new_index.php");
    exit;
}
include ('serverconnect.php');
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $confirm_password_err = $email_err = $fullname_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup']) && $_POST['signup'] == "signup") {
        if (empty(trim($_POST["regUsername"]))) {
            $username_err = "Please enter a username";
            $_SESSION['error'] .= $username_err." | ";
        } elseif (empty(trim($_POST["regFullname"]))) {
            $fullname_err = "Please enter your name";
            $_SESSION['error'] .= $fullname_err." | ";
        } elseif (empty(trim($_POST["regEmail"]))) {
            $email_err = "Please enter an email";
            $_SESSION['error'] .= $username_err." | ";
        } else {
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($db, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = trim($_POST["regUsername"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "This username is already taken";
                    } else {
                        $username = trim($_POST["regUsername"]);
                        $fullname = trim($_POST["regFullname"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later";
                }


                $sql = "SELECT id FROM users WHERE email = ?";

                if ($stmt = mysqli_prepare($db, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_fullname);

                    // Set parameters
                    $param_email = trim($_POST["regEmail"]);

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        /* store result */
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            $email_err = "This email is already in use";
                        } else {
                            $email = trim(mysqli_real_escape_string($db, $_POST['regEmail']));
                            $domain = substr($email, strpos($email, "@") + 1);
                            if ($domain != "remocademy.com") {
                                $email_err = "Please use the school email";
                                $_SESSION['error'] .= $email_err . " | ";
                            } else {
                                $email = trim($_POST["regEmail"]);
                            };
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }
            }



            // Validate password
            if (empty(trim(mysqli_real_escape_string($db, $_POST["regPassword_1"])))) {
                $password_err = "Please enter a password";
                $_SESSION['error'] .= $password_err." | ";
            } elseif (strlen(trim(mysqli_real_escape_string($db, $_POST["regPassword_1"]))) < 6) {
                $password_err = "Password must have atleast 6 characters";
                $_SESSION['error'] .= $password_err." | ";
            } else {
                $password = trim(mysqli_real_escape_string($db, $_POST["regPassword_1"]));
            }

            // Validate confirm password
            if (empty(trim(mysqli_real_escape_string($db, $_POST["regPassword_2"])))) {
                $confirm_password_err = "Please confirm password";
                $_SESSION['error'] .= $confirm_password_err." | ";
            } else {
                $confirm_password = trim($_POST["regPassword_2"]);
                if (empty($password_err) && ($password != $confirm_password)) {
                    $confirm_password_err = "Password did not match";
                    $_SESSION['error'] .= $confirm_password_err." | ";
                }
            }

            // Check input errors before inserting in database
            if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($fullname_err)) {

                // Prepare an insert statement
                $sql = "INSERT INTO users (fullname, username, password, email) VALUES (?, ?,?,?)";

                if ($stmt = mysqli_prepare($db, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssss",  $param_fullname,$param_username, $param_password, $param_email);

                    // Set parameters
                    $param_username = $username;
                    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                    $param_fullname = $fullname;
                    $param_email = $email;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect to login page
                        unset($_SESSION['error']);
                        header("location: login.php?tab=1");
                    } else {
                        $_SESSION['error'] = "Something went wrong. Please try again later";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            } else {
                header("Location: login.php?tab=0");
            };
            // Close connection
            mysqli_close($db);
        }


        if (isset($_POST['signin']) && $_POST['signin'] == "signin") { //Sign in
            // Check if username is empty
            if (empty(trim(mysqli_real_escape_string($db, $_POST['logUsername'])))) {
                $username_err = "Please enter username";
            } else {
                $username = trim(mysqli_real_escape_string($db, $_POST['logUsername']));
            }

            // Check if password is empty
            if (empty(trim(mysqli_real_escape_string($db, $_POST['logPassword'])))) {
                $password_err = "Please enter your password";
            } else {
                $password = trim(mysqli_real_escape_string($db, $_POST['logPassword']));
            }

            // Validate credentials
            if (empty($username_err) && empty($password_err)) {
                // Prepare a select statement
                $sql = "SELECT id, username, password FROM users WHERE username = ?";

                if ($stmt = mysqli_prepare($db, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_username);

                    // Set parameters
                    $param_username = $username;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Store result
                        mysqli_stmt_store_result($stmt);

                        // Check if username exists, if yes then verify password
                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            // Bind result variables
                            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                            if (mysqli_stmt_fetch($stmt)) {
                                if (password_verify($password, $hashed_password)) {
                                    // Password is correct, so start a new session
                                    session_start();

                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                    unset($_SESSION['error']);

                                    // Redirect user to welcome page

                                    if ($_SESSION['username'] == 'administrator'){
                                        header("location: dashboard.php");
                                    } else{
                                        header("location: new_index.php");
                                    }
                                } else {
                                    // Display an error message if password is not valid
                                    $_SESSION["error"] = "The password you entered was not valid";
                                    header("location: login.php?tab=1");
                                }
                            }
                        } else {
                            // Display an error message if username doesn't exist
                            $_SESSION["error"] = "No account found";
                            header("location: login.php?tab=1");
                        }
                    } else {
                        $_SESSION["error"] = "Something went wrong. Please try again";
                        header("location: login.php?tab=1");
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }

            // Close connection
            mysqli_close($db);
        }
}
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
                    <button class="tablinks <?php if ($_GET['tab']== 0){echo "active";}; ?>" onclick="openTab(event, 'signup')" id="defaultOpen">Sign Up</button>
                </div>
                <div class="tab-inner">
                    <button class="tablinks <?php if ($_GET['tab']== 1){echo "active";}; ?>" onclick="openTab(event, 'signin')">Sign In</button>
                </div>
            </div>


                <div class="tabcontent" id="signup" style="<?php if ($_GET['tab']== 0){echo "display:block";}elseif($_GET['tab'] == 1){echo "display: none";}else{echo "";}; ?>">
                    <form class="form-detail" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="text" name="regFullname" id="regFullname" class="input-text" required>
                            <span class="label">Full Name</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="text" name="regUsername" id="regUsername" class="input-text" required>
                            <span class="label">Username</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="email" name="regEmail" id="regEmail" class="input-text" required>
                            <span class="label">E-Mail</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="password" name="regPassword_1" id="regPassword_1" class="input-text" required>
                            <span class="label">Password</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="password" name="regPassword_2" id="regPassword_2" class="input-text" required>
                            <span class="label">Comfirm Password</span>
                            <span class="border"></span>
                        </label>
                    </div>

                    <div class="form-row-last">
                        <input type="hidden" name="signup" id="signup" value="signup">
                        <input type="submit" name="reg_user" class="register" value="Register">
                    </div>
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
                        <span class="help-block"><?php
                            if (isset($_SESSION['error'])){
                                echo $_SESSION["error"];
                            }
                            ;?></span>
                </div>
            </form>


            <div class="tabcontent" id="signin" style="<?php if ($_GET['tab']== 1){echo "display:block";}elseif($_GET['tab'] == 0){echo "display: none";}else{echo "";}; ?>">
            <form class="form-detail" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="text" name="logUsername" id="username" class="input-text" required>
                            <span class="label">Username</span>
                            <span class="border"></span>
                        </label>
                    </div>
                    <div class="form-row">
                        <label class="form-row-inner">
                            <input type="password" name="logPassword" id="password" class="input-text" required>
                            <span class="label">Password</span>
                            <span class="border"></span>
                        </label>
                    </div>
                    <div class="form-row-last">
                        <input type="hidden" name="signin" id="signin" value="signin">
                        <input type="submit" name="login" class="register" value="Login">

                    </div>
                    <span class="help-block"><?php
                        if (isset($_SESSION['error'])){
                            echo $_SESSION["error"];
                        }
                        ;?></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    <?php
    if (!isset($_GET['tab'])){
        echo "document.getElementById(\"defaultOpen\").click();";
    }

    ?>
    //

</script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
