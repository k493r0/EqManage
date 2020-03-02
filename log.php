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
    <h2>Log</h2>


    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                        <tr class="table100-head">
                            <th class="column1" style="border-bottom: 1px solid black">Log ID</th>
                            <th class="column2" style="border-bottom: 1px solid black">Check Out Request ID</th>
                            <th class="column3" style="border-bottom: 1px solid black">Return Request ID</th>
                            <th class="column4" style="border-bottom: 1px solid black">Equipment ID</th>
                            <th class="column5" style="border-bottom: 1px solid black">User ID</th>
                            <th class="column6" style="border-bottom: 1px solid black">Check Out Date</th>
                            <th class="column6" style="border-bottom: 1px solid black">Expected Return Date</th>
                            <th class="column6" style="border-bottom: 1px solid black">Return Date</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $results = mysqli_query($db, "SELECT * FROM log"); ?>

                        <?php while ($row = mysqli_fetch_array($results)) { ?>
                            <tr>
                                <td style="text-align:left"><?php echo $row['id']; ?></td>
                                <td style="text-align:left"><?php echo $row['checkoutRequests_id'] ?></td>
                                <td>
                                    <?php
                                    if ($row['returnRequests_id'] == null) {
                                        echo '<dt style="color:red; text-align: left";">Not returned yet</dt>';
                                    }else echo $row['returnRequests_id'];


                                    ?>
                                </td>
                                <td style="text-align:left"><?php echo $row['equipment_id'] ?> </td>
                                <td style="text-align:left"><?php echo $row['users_id'] ?></td>
                                <td style="text-align:left"><?php echo $row['checkoutDate'] ?></td>
                                <td style="text-align:left"><?php echo $row['expectedReturnDate'] ?></td>



                                <td>
                                    <?php
                                    if ($row['returnDate'] == null) {
                                        echo '<dt style="color:red; text-align: left";">Not returned yet</dt>';
                                    }else echo $row['returnDate'];


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

