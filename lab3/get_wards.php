<?php
    include 'queries.php';
    include 'config.php';

    $selected_wards = array();
    $stmt = $dbh->prepare($nurse_wards);
    $stmt->execute(array('id_nurse'=>$_GET['id_nurse']));
    foreach ($stmt->fetchAll() as $row) {
        array_push($selected_wards, $row['fid_ward']);
    }
?>

<caption>Wards Table</caption>
<tr>
    <th>Id</th>
    <th>Name</th>
    <th>Add nurse</th>
</tr>
<?php foreach ($dbh->query($wards_sql) as $row) { ?>
    <tr
        <?php
            if (in_array($row['id_ward'], $selected_wards)) {
                echo 'class="active"';
            }
        ?>
    >
        <td><?php echo $row['id_ward'] ?></td>
        <td><?php echo $row['name'] ?></td>
        <td>
            <form id="add-nurse-ward-form" action="insert_nurse_ward.php" method="post">
                <input type="hidden" name="id_ward" value="<?php echo $row['id_ward'] ?>">
                <input type="number" name="id_nurse" placeholder="Nurse Id" min="0" required>
                <input type="submit">
            </form>
        </td>
    </tr>
<?php } ?>