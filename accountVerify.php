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
        if (mysqli_affected_rows($db) == 0){
            $_SESSION['msg'] = "Account is already activated, please login with your credentials";
        } else{
            $_SESSION['msg'] = "Account is activated, you may now login";

            $sql = "SELECT email FROM EqManage.users WHERE hash = ?";
            if ($stmt = mysqli_prepare($db, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_hash);

                // Set parameters
                $param_hash = $hash;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)){
                        $email = $row['email'];
                    }

                } else {
                    echo "Oops! Something went wrong. Please try again later";
                }
                mysqli_stmt_close($stmt);
            }


            $mail = new PHPMailer;
            $mail->isSMTP();                            // Set mailer to use SMTP
            $mail->Host = 'smtp-relay.sendinblue.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                     // Enable SMTP authentication
            $mail->Username = 'noreply@remocademy.com';          // SMTP username
            $mail->Password = 't4XRdhqg1EC5j0Dm'; // SMTP password
            $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                          // TCP port to connect to
            // TCP port to connect to

            $mail->setFrom('noreply@remocademy.com', 'Notification System');
            $mail->addAddress($email);   // Add a recipient

            $mail->isHTML(true);  // Set email format to HTML

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
