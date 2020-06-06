<?php
    include 'queries.php';
    include 'config.php';

    header('Content-Type: text/xml');
    header("Cache-Control: no-cache, must-revalidate");

    $selected_nurses = array();
    $stmt = $dbh->prepare($department_nurses);
    $stmt->execute(array('department'=>$_GET['department']));
    foreach ($stmt->fetchAll() as $row) {
        array_push($selected_nurses, $row['id_nurse']);
    }

    echo '<?xml version="1.0" encoding="utf8" ?>';
    echo "<root>";
    foreach ($selected_nurses as $id)
    {
        print "<id_nurse>$id</id_nurse>";
    }
    echo "</root>";
?>