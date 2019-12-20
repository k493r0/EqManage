<?php

include('serverconnect.php');
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $loginuser = $_SESSION['name'];
    $equipment = $_POST['equipment'];
    $equser = $_POST['name'];
    $date = date('Y-m-d H:i:s');

    echo $equipment;
    echo $loginuser;
    echo $equser;

    if ($loginuser == $equser){
        $statusupdate = "UPDATE equipments SET CheckIn='$date', Availability=TRUE where Equipment='$equipment'";
        $allrequestsinsert = "INSERT INTO allrequests (User,Equipment,Action) VALUES ('$equser','$equipment', 'Return')";
//        $loginsert = "INSERT INTO log (Name, Equipment, CheckIn) values ('$equser', '$equipment', '$date')";

        $lastlog = mysqli_query($db,"select * from log where Name ='$equser' AND Equipment='$equipment' order by id desc limit 1 ");

        $row = mysqli_fetch_array($lastlog);

        echo $row['Equipment'];

        $lastlogid = $row['id'];
        echo $lastlogid;

        $loginsert = "update log SET CheckIn='$date' where id='$lastlogid'";


        mysqli_query($db,$statusupdate);
        mysqli_query($db,$allrequestsinsert);
        mysqli_query($db,$loginsert);

        header('Location: new_index.php?return=1');


    } else header('Location: new_index.php?return=0');


}





?>