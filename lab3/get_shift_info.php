<?php
    include 'queries.php';
    include 'config.php';

    header('Content-Type: application/json');

    $selected_nurses = array();
    $selected_wards = array();

    $stmt = $dbh->prepare($shift_info);
    $stmt->execute(array('shift'=>$_GET['shift']));
    foreach ($stmt->fetchAll() as $row) {
        array_push($selected_nurses, $row['id_nurse']);
        array_push($selected_wards, $row['id_ward']);
    }

    $data = array(
        'nurses'=>$selected_nurses,
        'wards'=>$selected_wards
    );

    echo json_encode($data);
?>