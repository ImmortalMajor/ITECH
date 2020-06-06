<?php
    include 'queries.php';
    include 'config.php';

    $stmt = $dbh->prepare($insert_nurse);
    $stmt->execute(array($_POST['id_nurse'], $_POST['name'], $_POST['date'], $_POST['department'], $_POST['shift']));

    echo 'Nurse added successfully';
?>