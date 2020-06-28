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
    $user_id = $_SESSION['id'];
    $equipment_id = $_POST['equipment'];
    $notes = $_POST['purpose'];
    $hash = md5(rand(0, 1000));
    $requestdate = date('Y-m-d H:i:s');
    $returndate = date('Y-m-d',strtotime($_POST['date']));
    $returntime = $_POST['time'];
    echo $returntime;
    $combinedDT = date('Y-m-d H:i:s', strtotime("$returndate $returntime"));
    echo $combinedDT;
    $checkoutQty = $_POST['quantity'];
    echo "Quantity: ", $checkoutQty;


    $eqname = "";
    echo "Return date: " ,$returndate;
    echo "Request date", $requestdate;
    echo "Return time ", $_POST['time'];
    echo "\n Combined DT: ",$combinedDT;

    $dateTimestamp1 = strtotime($requestdate);
    $dateTimestamp2 = strtotime($returndate);

    if ($dateTimestamp1 > $dateTimestamp2)
        echo "$requestdate is latest than $returndate";
    else
        echo "$requestdate is older than $returndate";



    $getEqName = mysqli_query($db, "select * from EqManage.equipment where id = $equipment_id");
    while ($row = mysqli_fetch_array($getEqName)){

    $eqname = $row['equipment'];
    echo $eqname;

}

echo $eqname;




    echo $user_id;
    echo $equipment_id;

    $query = "INSERT INTO requests (users_id,equipment_id,note,checkoutQty,hash,state,requestDate,expectedReturnDate) VALUES ('$user_id','$equipment_id','$notes','$checkoutQty','$hash','waiting','$requestdate','$combinedDT')";

    mysqli_query($db, $query);



header("Location: new_index.php?sent=1");

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
    $mail->Username = 'noreply@remocademy.com';          // SMTP username
    $mail->Password = 't4XRdhqg1EC5j0Dm'; // SMTP password
    $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                          // TCP port to connect to
                        // TCP port to connect to

    $mail->setFrom('noreply@remocademy.com', 'Notification System');
    $mail->addAddress('administrator@remocademy.com');   // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML

    $bodyContent = '<p>The following user has requested to borrow an equipment:
<br> 
----------------------------------------------------------<br>
Equipment: '. $eqname .' <br>
Quantity: ' . $checkoutQty . '<br>
Name: ' . $user . ' <br>
Notes: ' . $notes . '<br>
Date of Return: ' . $combinedDT . '<br>

----------------------------------------------------------
<br>
Please click this link to approve this check out:
http://localhost/EqManage/postverify.php?hash='.$hash.'</p>';

    $mail->Subject = 'Equipment Approval';
    $mail->Body = $bodyContent;

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }





}

