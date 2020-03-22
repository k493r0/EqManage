<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
include ('serverconnect.php');
?>
<!DOCTYPE html>
<html>
<?php
include('header.php')
?>
<body class="form-v8 loggedin" id="fade">

<div id="loader">
    <div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php include('navbar.php'); ?>

<div class="content">
    <h2>All Requests</h2>


    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                        <tr class="table100-head">
                            <th class="column1" style="border-bottom: 1px solid black">Request ID</th>
                            <th class="column2" style="border-bottom: 1px solid black">User</th>
                            <th class="column3" style="border-bottom: 1px solid black">Equipment</th>
                            <th class="column4" style="border-bottom: 1px solid black">Notes</th>
                            <th class="column5" style="border-bottom: 1px solid black">Date Requested</th>
                            <th class="column6" style="border-bottom: 1px solid black">State</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $results = mysqli_query($db, "SELECT * FROM requests"); ?>

                        <?php while ($row = mysqli_fetch_array($results)) { ?>
                            <tr>
                                <td style="text-align:left"><?php echo $row['id']; ?></td>
                                <td style="text-align:left"><?php echo $row['users_id'] ?></td>
                                <td style="text-align:left"><?php echo $row['equipment_id'] ?></td>
                                <td style="text-align:left"><?php echo $row['note'] ?> </td>
                                <td style="text-align:left"><?php echo $row['requestDate'] ?></td>



                                <td>
                                    <?php

                                    if ($row['state'] == 'approved') {
                                        echo '<dt style="color:green; text-align: left";">Approved</dt>';
                                    } elseif ($row['state'] == 'rejected'){
                                        echo '<dt style="color:red; text-align: left";">Rejected</dt>';
                                    } elseif ($row['state'] == null){
                                        echo '<dt style="color:black; text-align: left";">Pending</dt>';
                                    }else echo "Error";


                                    ?>
                                </td>


                            </tr>
                        <?php }; ?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>


</body>

