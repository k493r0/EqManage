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
include('header.php');
?>
<body class="form-v8 loggedin" id="fade">

<div id="loader">
<div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php include('navbar.php'); ?>

<div class="content">
    <h2>Equipment Status</h2>



    <?php $results = mysqli_query($db, "SELECT * FROM equipment"); ?>
    <table align="center" cellpadding="10px" cellspacing="6px" width="100%" border="2px"  id="table" style="border-collapse: collapse;margin-top: 10px;border-color: black">
        <thead>
        <tr>
            <th style="padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #2f9395;
                color: white;"
            >
                Equipment
            </th>
            <th style="padding-top: 12px;
padding-bottom: 12px;
text-align: left;
background-color: #2f9395;
color: white;">Availability</th>
        </tr>
        </thead>

        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr style="background-color: #f2f2f2 ">
                <td style=" border: 1px solid black;
padding: 15px;"><?php echo $row['equipment']; ?></td>
                <td style=" border: 1px solid black;
padding: 15px;">
                    <?php

                    if ($row['Availability'] == 1) {
                        echo '<dt style="color:red";">
                                Available </dt>';
                    } elseif ($row['Availability'] == 0){
                        echo "Not Available";
                    } else echo "Error";


                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>


</body>

