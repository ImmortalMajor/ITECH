<?php
    include 'queries.php';
    include 'config.php';

    $stmt = $dbh->prepare($insert_ward);
    $stmt->execute(array($_POST['id_ward'], $_POST['name']));

    header("Location: index.php");
    die();
?>