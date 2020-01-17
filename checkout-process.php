<?php
/*
$db = mysqli_connect('localhost','root','root','test_users');


$user = "";
$equipment = "";

$notes = "";
$errors = array();

if (isset($_POST['request'])){
    $user = $_SESSION['username'];
    $equipment = $_POST['Equipments'];
    $notes = $_POST['purpose'];

    if(empty($notes)) {array_push($errors,"This field should not be empty");}

        $hash = md5( rand(0,1000) );
        $requestdate = DateTime();

        $query = "INSERT INTO allrequests (User,Equipment,Notes,DateRequested,Hash,Action) VALUES ('$user','$equipment','$notes','$requestdate','$hash', 'Check-Out')";

        mysqli_query($db,$query);

        header("Location: index2.php?sent=1");



}
*/
include('serverconnect.php');
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: index.php');
    exit();
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/src/Exception.php';
require 'assets/src/PHPMailer.php';
require 'assets/src/SMTP.php';

$user = "";
$equipment = "";
$notes = "";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $user = $_SESSION['name'];
    $equipment = $_POST['equipment'];
    $notes = $_POST['purpose'];
    $hash = md5(rand(0, 1000));
    $requestdate = date('Y-m-d H:i:s');

    echo $equipment;
    $query = "INSERT INTO allrequests (User,Equipment,Notes,Hash,Action) VALUES ('$user','$equipment','$notes','$hash', 'Check-Out'); SELECT LAST_INSERT_ID();";

    mysqli_query($db, $query);



//    header("Location: index.php?sent=1");

    /*    $to = 'eizaemon_the_third@yahoo.co.uk'; // Send email to our user
        $subject = 'Signup | Verification'; // Give the email a subject
        $message = '

    Thanks for signing up!
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

    ------------------------
    Username: ' . $user . '
    Password: ' . $notes . '
    ------------------------

    Please click this link to activate your account:
    http://www.yourwebsite.com/verify.php?hash=' . $hash . '

    '; // Our message above including the link

        $headers = 'From:eizaemon_the_third@yahoo.co.uk' . "\r\n"; // Set from headers
        mail($to, $subject, $message, $headers); // Send our email*/


    $mail = new PHPMailer;

    $mail->isSMTP();                            // Set mailer to use SMTP
    $mail->Host = 'smtp-relay.sendinblue.com';             // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                     // Enable SMTP authentication
    $mail->Username = 'eizaemon_the_third@yahoo.co.uk';          // SMTP username
    $mail->Password = 'Ya8rKpZnS7hGzCRB'; // SMTP password
    $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                          // TCP port to connect to
                        // TCP port to connect to

    $mail->setFrom('eizaemon_the_third@yahoo.co.uk', 'NoReply');
    $mail->addAddress('l.lawliet.31415@gmail.com');   // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML

    $bodyContent = '<p>The following user has requested to borrow an equipment:
<br> 
----------------------------------------------------------<br>
Equipment: '. $equipment .' <br>
Name: ' . $user . ' <br>
Notes: ' . $notes . '<br>
----------------------------------------------------------
<br>
Please click this link to approve this check out:
http://localhost/EqManage/verify.php?hash='.$hash.'</p>';

    $mail->Subject = 'Equipment Approval';
    $mail->Body = $bodyContent;

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }





}

