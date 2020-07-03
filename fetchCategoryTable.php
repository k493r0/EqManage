<?php
include('serverconnect.php');
$results = mysqli_query($db, "SELECT * FROM EqManage.categories");
while ($row = mysqli_fetch_array($results)) {
    $total = 0;
    $results2 = mysqli_query($db, "SELECT categories.id, categoryName FROM EqManage.categories left join equipment e on categories.id = e.category where categories.id =".$row['id']);
    while ($row2 = mysqli_fetch_array($results2)) {
        $total++;
    };
    ?>
    <tr>
        <td><?php echo $row['categoryName']; ?></td>
        <td><?php echo $total; ?></td>
        <td><button type='button' class='btn btn-link' id="removeEq" style="padding: 0; margin: 0" onclick="removeCat(this.value)" value="<?php echo $row['id']; ?>">Remove</button></td>

    </tr>
<?php }
