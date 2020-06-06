<?php
    include 'config.php';
    $cursor = $collection->find(['shift'=>$_POST['shift'], 'department'=>intval($_POST['department'])]);
?>

<table border="1">
    <tr>
        <th>Shift</th>
        <th>Date</th>
        <th>Department</th>
        <th>Nurses</th>
        <th>Wards</th>
    </tr>
    <?php foreach ($cursor as $document) { ?>
        <tr>
            <td><?php echo $document['shift']; ?></td>
            <td><?php echo $document['date']; ?></td>
            <td><?php echo $document['department']; ?></td>
            <td>
                <?php
                    foreach ($document['nurses'] as $nurse) { 
                        echo $nurse;
                        echo '<br>';
                    }
                ?>
            </td>
            <td>
                <?php
                    foreach ($document['wards'] as $ward) { 
                        echo $ward;
                        echo '<br>';
                    }
                ?>
            </td>
        </tr>
    <?php } ?>
</table>