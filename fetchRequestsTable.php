<?php
include('serverconnect.php');

 $approved = $_REQUEST['approved'];
 $rejected = $_REQUEST['rejected'];
 $waiting = $_REQUEST['waiting'];

//switch ($approved){
//    case 'true' :
//        switch ($rejected){
//            case 'true' :
//                switch ($waiting){
//                    case 'true': $query = "select * from EqManage.requests"; break; //True,true,true
//                    case false: $query = "select * from EqManage.requests where state = 'approved' or state = 'rejected'";  break;//True, true, false
//                } break;
//
//            case false:
//                switch ($waiting){
//                    case true: $query = "select * from EqManage.requests where state = 'approved' or state = 'waiting'"; break;//true,false,true
//                    case false: $query = "select * from EqManage.requests where state = 'approved'";  break;//True,false,false
//                }break;
//
//        }break;
//
//    case false :
//        switch ($rejected){
//            case true:
//                switch ($waiting){
//                    case true: $query = "select * from EqManage.requests where state = 'rejected' or state = 'waiting'"; break;//false,true,true
//                    case false: $query = "select * from EqManage.requests where state = 'rejected'";  break;//false,true,false
//                }
//
//            break;
//            case false:
//                switch ($waiting){
//                    case true: $query = "select * from EqManage.requests where state = 'waiting'"; break;//false,false,true
//                    case false: $query = "";  break;//false,false,false
//                }
//
//            break;
//        } break;
//
//    default: $query = "select * from EqManage.requests";
//};

if ($approved == 'true'){
    if ($rejected == 'true'){
        if ($waiting == 'true'){$query = "select * from EqManage.requests";} //true,true,true
        else $query = "select * from EqManage.requests where state = 'approved' or state = 'rejected'"; //true,true,false
    }
    if ($rejected == 'false'){
        if ($waiting == 'true'){$query = "select * from EqManage.requests where state = 'approved' or state = 'waiting'";}//true,false,true
        else $query = "select * from EqManage.requests where state = 'approved'";//true,false,false
    }
} elseif ($approved == 'false'){
    if ($rejected == 'true'){
        if ($waiting == 'true'){$query = "select * from EqManage.requests where state = 'rejected' or state = 'waiting'";} //false,true,true
        else $query = "select * from EqManage.requests where state = 'rejected'"; //false,true,false
    }
if ($rejected == 'false'){
    if ($waiting == 'true'){$query = "select * from EqManage.requests where state = 'waiting'";}//false,false,true
    else echo "No Records";//false,false,false
}}

$results = mysqli_query($db, $query);
if ($results != null){
 while ($row = mysqli_fetch_assoc($results)) {

    echo "<tr>";
       echo "<td style='text-align:left'>",  $row['id'], "</td>";
        echo "<td style='text-align:left'>", $row['users_id'], "</td>";
        echo "<td style='text-align:left'>",$row['equipment_id'], "</td>";
        echo "<td style='text-align:left'>",$row['note'],  "</td>";
        echo "<td style='text-align:left'>",$row['requestDate'],"</td>";

        echo "<td>";

            if ($row['state'] == 'approved') {
                echo '<dt style="color:green; text-align: left";">Approved</dt>';
            } elseif ($row['state'] == 'rejected'){
                echo '<dt style="color:red; text-align: left";">Rejected</dt>';
            } elseif ($row['state'] == 'waiting'){
                echo '<dt style="color:black; text-align: left";">Pending</dt>';
            }else echo "Error";



        echo "</td>";
        if ($row['state'] == 'waiting'){
            echo "<td><a href=''>Verify</a></td>";
        } else echo "<td></td>"
;


    echo "</tr>";
 }} else ( $results = mysqli_query($db, $query)); if($results != null){echo "No Records";};


