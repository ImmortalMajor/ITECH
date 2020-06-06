<?php
    include 'queries.php';
    include 'config.php';

    $stmt = $dbh->prepare($insert_nurse_ward);
    $stmt->execute(array($_POST['id_nurse'], $_POST['id_ward']));

    echo 'Nurse successfully added to ward';
?>