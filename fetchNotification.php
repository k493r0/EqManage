<?php
include('serverconnect.php');
if(isset($_POST['view'])){//When the notification is viewed/refreshed
    $userID = $_SESSION['id'];
    $query = "SELECT * FROM notification where target = '$userID' and status = 0 ORDER BY id DESC";
    $result = mysqli_query($db, $query);
    $output = '';
    $output .= "<li><strong>Message</strong></li><hr>";
    if(mysqli_num_rows($result) > 0) {//If there is more than one notification for the target user
        while($row = mysqli_fetch_array($result)) { //Echo all notification
            $date = $row['datetime'];
            $formattedDate = date('M-d H:i',strtotime($date));
            $output .= '
  <li>
  <small><strong>'.$formattedDate.'</strong></small>
  <small>'.$row["message"].'</small>
  <hr style="width:70%">
  </li>
  ';
        }
    }else{//If there is no unread notification in the database
        $output .= '<li><p>No Notification Found</p></li>';
    }
    $status_query = "SELECT * FROM notification WHERE status=0 and target = '$userID'";
    $result_query = mysqli_query($db, $status_query);
    $count = mysqli_num_rows($result_query);//Get how many unread notifications there are
    $data = array(
        'notification' => $output,
        'unread_count'  => $count
    ); //Store notification and number of unread count

    if($_POST["read"] == "read")//When the notification dropdown is closed, the message will be marked as read
    {
        $update_query = "UPDATE notification SET status = 1 WHERE status=0 and target = '$userID'"; //Set status as 'read'
        mysqli_query($db, $update_query);
    }

    echo json_encode($data);//Return to ajax (javascript) the notification data array
}
