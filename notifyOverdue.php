<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/src/Exception.php';
require 'assets/src/PHPMailer.php';
require 'assets/src/SMTP.php';

include('serverconnect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['notify']) && $_POST['notify'] == 1){
        $id = $_POST['id'];
        $today = date("Y-m-d H:i:s");
        echo $id;

        $query = mysqli_query($db, "select requests.users_id, equipment.equipment from EqManage.requests left join EqManage.equipment on requests.equipment_id = equipment.id where requests.id = '$id'");
        while ($row = mysqli_fetch_array($query)) {
            $eqname = $row['equipment'];
            echo $eqname;
            $userID = $row['users_id'];
        }
        echo $userID;

        $message = $eqName.' is overdue. Please return it as soon as possible';
        $checkNotif = mysqli_query($db, "Select * from notification where message = '$message' and target = '$userID'");
        if(mysqli_num_rows($checkNotif) != null){
            echo "present";
            $updateNotif = "Update EqManage.notification set status = 0 where message = '$message' and target = '$userID'";
            if (mysqli_query($db, $updateNotif)) {
                $last_id = mysqli_insert_id($db);
                echo "Notification updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $updateNotif . "<br>" . mysqli_error($db);
            }
        } else{
            echo "empty";
            $notif_query = "INSERT into EqManage.notification (message,target,status,datetime) values ('$message' ,'$userID',0, '$today')";
            if (mysqli_query($db, $notif_query)) {
                $last_id = mysqli_insert_id($db);
                echo "Notification updated. Last inserted ID is: " . $last_id;
            } else {
                echo "Error: " . $notif_query . "<br>" . mysqli_error($db);
            }
        }




        $sql = "SELECT email FROM users WHERE id = ?";
        if ($stmt = mysqli_prepare($db, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $userID;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)){
                    $email = $row['email'];
                    echo "Test";
                }

            } else {
                echo "Oops! Something went wrong. Please try again later";
            }
            mysqli_stmt_close($stmt);
        }

        echo $email;


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
        $mail->addAddress("$email");   // Add a recipient

        $mail->isHTML(true);  // Set email format to HTML

        $bodyContent = '<p>You have an equipment overdue<br>Please return '.$eqname.' as soon as possible</p>';

        $mail->Subject = 'Equipment Overdue';
        $mail->Body = $bodyContent;

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }


    }
}
