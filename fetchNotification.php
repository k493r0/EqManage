<?php
include('serverconnect.php');
if(isset($_POST['view'])){

    $userID = $_SESSION['id'];
// $con = mysqli_connect("localhost", "root", "", "notif");

    $query = "SELECT * FROM notification where target = '$userID' and status = 0 ORDER BY id DESC";
    $result = mysqli_query($db, $query);
    $output = '';
    $output .= "<li><strong>Message</strong></li><hr>";
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
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
    }
    else{
        $output .= '<li><p>No Notification Found</p></li>';
    }
    $status_query = "SELECT * FROM notification WHERE status=0 and target = '$userID'";
    $result_query = mysqli_query($db, $status_query);
    $count = mysqli_num_rows($result_query);
    $data = array(
        'notification' => $output,
        'unread_count'  => $count
    );

    if($_POST["read"] == "read")
    {
        $update_query = "UPDATE notification SET status = 1 WHERE status=0 and target = '$userID'";
        mysqli_query($db, $update_query);
    }

    echo json_encode($data);
}
