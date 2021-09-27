<?php
include('serverconnect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'assets/src/Exception.php';
require 'assets/src/PHPMailer.php';
require 'assets/src/SMTP.php';
session_start();
if (isset($_GET['hash'])){
    $_SESSION['msg'] = "";
    $hash = mysqli_real_escape_string($db, $_GET['hash']);
    $query = "Update users set active = '1' where hash = '$hash' and active = '0'";
    if ($result = mysqli_query($db, $query)){
        if (mysqli_affected_rows($db) == 0){ //Meaning active is already = 1, and the account is activated already
            $_SESSION['msg'] = "Account is already activated, please login with your credentials"; //Set notification
        } else{
            $_SESSION['msg'] = "Account is activated, you may now login"; //Set notification

            $sql = "SELECT email FROM EqManage.users WHERE hash = ?"; //Prepared statement used as it handles with user database
            if ($stmt = mysqli_prepare($db, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_hash);

                // Set parameters
                $param_hash = $hash;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)){
                        $email = $row['email']; //If email was found with specified hash, set that as an email address
                    }

                } else {
                    echo "Oops! Something went wrong. Please try again later"; //Error Message
                }
                mysqli_stmt_close($stmt);
            }


            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.sendinblue.com';
            $mail->SMTPAuth = true;// Enable SMTP authentication
            $mail->Username = 'noreply@remocademy.com'; // SMTP username
            $mail->Password = 'password'; // SMTP password
            $mail->SMTPSecure = 'tls';  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; //TCP Port

            $mail->setFrom('noreply@remocademy.com', 'Notification System');
            $mail->addAddress($email);   //Recipient

            $mail->isHTML(true);  //Set email format to HTML

            $bodyContent = '<p>You have successfully activated your account</p>';

            $mail->Subject = 'Account Verification Success';
            $mail->Body = $bodyContent;

            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        };
        header("Location: login.php?tab=1");
    } else{
        $_SESSION['msg'] = "The link is invalid, please try again";
        header("Location: login.php?tab=1");
    }
}
