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
$user = $_SESSION['username'];
$equipment = "";
$purpose = "";
$errors = array();
$mailEquipmentContent = "";
$hash;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_SESSION['cart'])) {

        $user = $_SESSION['username'];
        $user_id = $_SESSION['id'];
        $equipment_id = $_POST['equipment'];
        $purpose = $_POST['purpose'];
        $hash = md5(rand(0, 1000));
        $requestdate = date('Y-m-d H:i:s');
        $returndate = date('Y-m-d', strtotime($_POST['date']));
        $returntime = $_POST['time'];
        echo $returntime;
        $combinedDT = date('Y-m-d H:i:s', strtotime("$returndate $returntime"));
        echo $combinedDT;
        $checkoutQty = $_POST['quantity'];
        echo "Quantity: ", $checkoutQty;
        $location = $_POST['location'];


        $eqname = "";
        echo "Return date: ", $returndate;
        echo "Request date", $requestdate;
        echo "Return time ", $_POST['time'];
        echo "\n Combined DT: ", $combinedDT;

        $dateTimestamp1 = strtotime($requestdate);
        $dateTimestamp2 = strtotime($returndate);

        if ($dateTimestamp1 > $dateTimestamp2)
            echo "$requestdate is latest than $returndate";
        else
            echo "$requestdate is older than $returndate";


        $getEqName = mysqli_query($db, "select * from EqManage.equipment where id = '$equipment_id'");
        while ($row = mysqli_fetch_array($getEqName)) {
            $eqname = $row['equipment'];
            echo $eqname;
        }

    //Updating Requests
        echo $eqname;
        echo $user_id;
        echo $equipment_id;

        $query = "INSERT INTO requests (users_id,equipment_id,location,purpose,checkoutQty,hash,state,requestDate,expectedReturnDate) VALUES ('$user_id','$equipment_id','$location','$purpose','$checkoutQty','$hash','waiting','$requestdate','$combinedDT')";

        mysqli_query($db, $query);

    //Updating Equipmenet
        $checkQty = "Select * from EqManage.equipment where id = '$equipment_id'";
        $result = mysqli_query($db, $checkQty);
        $checkQtyArray = mysqli_fetch_assoc($result);

        $leftQty = $checkQtyArray['leftQuantity'];
        $newLeftQty = $leftQty - $checkoutQty;
        if ($newLeftQty <= 0) {
            $updateEq_query = "UPDATE EqManage.equipment SET availability=0, users_id=null, lastLog_id=null, leftQuantity='$newLeftQty' WHERE id='$equipment_id'";
        } else $updateEq_query = "UPDATE EqManage.equipment SET users_id=null, lastLog_id=null, leftQuantity='$newLeftQty' WHERE id='$equipment_id'"; //Temporarily Subtract the Quantity to prevent double booking during request pending period

        if (mysqli_query($db, $updateEq_query)) {
            echo "Successfully updated table";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($db);
        }


        $mailEquipmentContent .= '----------------------------------------------------------<br>
                                    Equipment: ' . $eqname . ' <br>
                                    Quantity: ' . $checkoutQty . '<br>
                                    Purpose: ' . $purpose . '<br>
                                    Date of Return: ' . $combinedDT . '<br>
                                    ----------------------------------------------------------<br>';



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




    }elseif (isset($_SESSION['cart'])){
        if (isset($_POST['applyAllCheck']) && $_POST['applyAllCheck'] == "1") {
            $user = $_SESSION['username'];
            $user_id = $_SESSION['id'];
            $purpose = $_POST['purpose'];
            $hash = md5(rand(0, 1000));
            $requestdate = date('Y-m-d H:i:s');
            $returndate = date('Y-m-d', strtotime($_POST['date']));
            $returntime = $_POST['time'];
            $combinedDT = date('Y-m-d H:i:s', strtotime("$returndate $returntime"));
            $location = $_POST['location'];

            $mailEquipmentContent1 = '----------------------------------------------------------<br>';


            foreach ($_SESSION['cart'] as $i){
                $equipment_id = $i['id'];
                $quantity = $i['qty'];
                $getEqName = mysqli_query($db, "select * from EqManage.equipment where id = '$equipment_id'");
                while ($row = mysqli_fetch_array($getEqName)) {
                    $eqname = $row['equipment'];
                    echo $eqname;
                }
                //Insert Request for Each equipment
                $query = "INSERT INTO requests (users_id,equipment_id,location,purpose,checkoutQty,hash,state,requestDate,expectedReturnDate) VALUES ('$user_id','$equipment_id','$location','$purpose','$quantity','$hash','waiting','$requestdate','$combinedDT')";
                if (mysqli_query($db, $query)) {
                    echo "Successfully updated table";
                } else {
                    echo mysqli_error($db);
                }


                $checkQty = "Select * from EqManage.equipment where id = '$equipment_id'";
                $result = mysqli_query($db, $checkQty);
                $checkQtyArray = mysqli_fetch_assoc($result);
                $leftQty = $checkQtyArray['leftQuantity'];
                $newLeftQty = $leftQty - $quantity;
                if ($newLeftQty <= 0) {
                    $updateEq_query = "UPDATE EqManage.equipment SET availability=0, users_id=null, lastLog_id=null, leftQuantity='$newLeftQty' WHERE id='$equipment_id'";
                } else $updateEq_query = "UPDATE EqManage.equipment SET users_id=null, lastLog_id=null, leftQuantity='$newLeftQty' WHERE id='$equipment_id'"; //Temporarily Subtract the Quantity to prevent double booking during request pending period

                if (mysqli_query($db, $updateEq_query)) {
                    echo "Successfully updated table";
                } else {
                    echo mysqli_error($db);
                }

                $mailEquipmentContent2 .= '
                                        Equipment: ' . $eqname . ' <br>
                                        Quantity: ' . $quantity . '<br><br>';


            }
            $mailEquipmentContent3 = '
                                        Purpose: ' . $purpose . '<br>
                                        Date of Return: ' . $combinedDT . '<br>
                                        ----------------------------------------------------------<br>';
            $mailEquipmentContent = $mailEquipmentContent1.$mailEquipmentContent2.$mailEquipmentContent3;

            unset($_SESSION['cart']);
        }elseif (empty($_POST['applyAllCheck'])){
            $hash = md5(rand(0, 1000)); //Hash placed here because it can't be different for each equipment

            foreach ($_SESSION['cart'] as $i){
                $user = $_SESSION['username'];
                $user_id = $_SESSION['id'];
                $purpose = $_POST["purpose_".$i['id']];
                $location = $_POST['location_'.$i['id']];
                $returntime = $_POST['time_'.$i['id']];
                $equipment_id = $i['id'];
                $quantity = $i['qty'];

                echo $purpose;
                echo $location;
                echo $returntime;
                $eqname = "";
                $requestdate = date('Y-m-d H:i:s');
                $returndate = date('Y-m-d', strtotime($_POST['date_'.$i['id']]));
                $combinedDT = date('Y-m-d H:i:s', strtotime("$returndate $returntime"));

                $getEqName = mysqli_query($db, "select * from EqManage.equipment where id = '$equipment_id'");
                while ($row = mysqli_fetch_array($getEqName)) {
                    $eqname = $row['equipment'];
                    echo $eqname;
                }

                $query = "INSERT INTO requests (users_id,equipment_id,location,purpose,checkoutQty,hash,state,requestDate,expectedReturnDate) VALUES ('$user_id','$equipment_id','$location','$purpose','$quantity','$hash','waiting','$requestdate','$combinedDT')";
                if (mysqli_query($db, $query)) {
                    echo "Successfully updated table";
                } else {
                    echo mysqli_error($db);
                }

                //Updating Equipmenet

                $checkQty = "Select * from EqManage.equipment where id = '$equipment_id'";
                $result = mysqli_query($db, $checkQty);
                $checkQtyArray = mysqli_fetch_assoc($result);

                $leftQty = $checkQtyArray['leftQuantity'];
                $newLeftQty = $leftQty - $quantity;
                if ($newLeftQty <= 0) {
                    $updateEq_query = "UPDATE EqManage.equipment SET availability=0, users_id=null, lastLog_id=null, leftQuantity='$newLeftQty' WHERE id='$equipment_id'";
                } else $updateEq_query = "UPDATE EqManage.equipment SET users_id=null, lastLog_id=null, leftQuantity='$newLeftQty' WHERE id='$equipment_id'"; //Temporarily Subtract the Quantity to prevent double booking during request pending period

                if (mysqli_query($db, $updateEq_query)) {
                    echo "Successfully updated table";
                } else {
                    echo mysqli_error($db);
                }

                $mailEquipmentContent .= '----------------------------------------------------------<br>
                                        Equipment: ' . $eqname . ' <br>
                                        Quantity: ' . $quantity . '<br>
                                        Purpose: ' . $purpose . '<br>
                                        Date of Return: ' . $combinedDT . '<br>
                                        ----------------------------------------------------------<br>';

            }
            unset($_SESSION['cart']);

        }
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
    $mail->addAddress('administrator@remocademy.com');   // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML

    $bodyContent = '<p>'.$user.' has requested to borrow an equipment:<br>'.$mailEquipmentContent.'<br>Please click this link to approve this check out:
        http://localhost/EqManage/postverify.php?hash='.$hash.'</p>';

    $mail->Subject = 'Equipment Approval';
    $mail->Body = $bodyContent;

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }

    header("Location: new_index.php?sent=1");

}

