<?php
include('serverconnect.php');
     $results = mysqli_query($db, "SELECT * FROM EqManage.equipment inner join EqManage.categories on equipment.category = categories.id");
    while ($row = mysqli_fetch_array($results)) {

                $catName = $row['categoryName'];
                $tqty = $row['totalQuantity'];

                ?>
                <tr>
                    <td><?php echo $row['equipment']; ?></td>
                    <td><?php echo "<a href='#'>$catName</a>";?></td>
                    <td><?php echo $row['totalQuantity']; ?></td>
                    <td><?php echo $row['leftQuantity']; ?></td>
                    <td>
                        <?php

                        if ($row['leftQuantity'] >= 1) {
                            echo "Available";
                        } elseif ($row['leftQuantity'] <= 0){
                            echo "Not Available";
                        } else echo "Error";

                        ?>
                    </td>
                    <td><?php echo $row['users_id']; ?></td>
                    <td><?php echo $row['lastLog_id']; ?></td>


                </tr>
            <?php } ?>
