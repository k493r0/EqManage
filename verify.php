<?php
include('serverconnect.php');
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
        $string1 = $_SERVER['QUERY_STRING'];
        $string2 = str_replace("hash=","",$string1);
        echo $string2;

        $db = mysqli_connect('remotemysql.com', 'tgsK9nTZNV', 'UFJLMZcF2L', 'tgsK9nTZNV');

        $query = "UPDATE allrequests SET Active='1' WHERE Hash='$string2'";
        mysqli_query($db,$query);


        $equipment_query = "Select * from allrequests where Hash='$string2'";
        $result = mysqli_query($db,$equipment_query);
        $equipment = mysqli_fetch_assoc($result);
        echo $equipment['Equipment'];
        $equipment_independent = $equipment['Equipment'];
        echo $equipment_independent;
        $user_independent = $equipment['User'];
        $notes_independent = $equipment['Notes'];
        $date = date('Y-m-d H:i:s');


        $intolog_query = "INSERT into `log` (`Name`,`Equipment`,`Notes`,`CheckOut`) values ('$user_independent','$equipment_independent', '$notes_independent','$date')";
        $intoequipments_query = "UPDATE equipments SET Equipment='$equipment_independent', Name='$user_independent', Notes='$notes_independent', CheckOut='$date', CheckIn=null,Availability=FALSE WHERE Equipment='$equipment_independent'";

        mysqli_query($db,$intolog_query);
        mysqli_query($db,$intoequipments_query);


//        header('Location: index.php?check-out=1');