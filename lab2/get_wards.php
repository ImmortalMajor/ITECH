<?php
    include 'config.php';
    $cursor = $collection->find(['nurses'=>$_POST['nurses']]);
    foreach ($cursor as $document) {
        echo '<strong>Wards: </strong><br>';
        foreach ($document['wards'] as $ward) {
            echo($ward);
            echo "<br>";
        }
    }
?>