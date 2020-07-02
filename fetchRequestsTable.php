<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: new_index.php?adminonly=1');
}

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
$query = "select requests.id, requests.users_id, u.fullname, e.equipment, requests.equipment_id, requests.location, requests.purpose, requests.requestDate, requests.state, requests.hash from EqManage.requests left join users u on requests.users_id = u.id left join equipment e on requests.equipment_id = e.id ";
if ($approved == 'true'){
    if ($rejected == 'true'){
        if ($waiting == 'true'){} //true,true,true
        else $query .= "where state = 'approved' or state = 'rejected'"; //true,true,false
    }
    if ($rejected == 'false'){
        if ($waiting == 'true'){$query .= "where state = 'approved' or state = 'waiting'";}//true,false,true
        else $query .= "where state = 'approved'";//true,false,false
    }
} elseif ($approved == 'false'){
    if ($rejected == 'true'){
        if ($waiting == 'true'){$query .= "where state = 'rejected' or state = 'waiting'";} //false,true,true
        else $query .= "where state = 'rejected'"; //false,true,false
    }
if ($rejected == 'false'){
    if ($waiting == 'true'){$query .= "where state = 'waiting'";}//false,false,true
    echo "No Records";
}};
if ($rejected =='false' && $approved == 'false' && $waiting == 'false'){$query = "";};
$query .= " order by EqManage.requests.id asc ";
$results = mysqli_query($db, $query);
if ($results != null){
 while ($row = mysqli_fetch_assoc($results)) {

    echo "<tr>";
        echo "<td style='text-align:left'><a href='search.php?type=3&id=".$row['id']."'>". $row['id']."</td>";
        echo "<td style='text-align:left'><a href='search.php?type=1&id=".$row['users_id']."'>".$row['fullname']."</td>";
        echo "<td style='text-align:left'><a href='search.php?type=2&id=".$row['equipment_id']."'>".$row['equipment']. "</td>";
        echo "<td style='text-align:left'>".$row['location']."</td>";
        echo "<td style='text-align:left'>".$row['purpose']."</td>";
        echo "<td style='text-align:left'>".$row['requestDate']."</td>";

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
            echo "<td><a href='postverify.php?hash=". $row['hash']. "&redirecturl=".$_SERVER["REQUEST_URI"] ."'>Verify</a></td>";
        } else echo "<td>-</td>"
;


    echo "</tr>";
 }} else ($results = mysqli_query($db, $query)); if($results == null && $rejected !='false' && $approved != 'false' && $waiting != 'false'){echo "No Records";}elseif ($results == null){echo "";};


