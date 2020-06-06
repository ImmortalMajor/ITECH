<?php
    include 'config.php';
    $cursor = $collection->find(['department'=>intval($_POST['department'])]);
    foreach ($cursor as $document) {
        echo '<strong>Nurses: </strong><br>';
        foreach ($document['nurses'] as $nurse) {
            echo($nurse);
            echo "<br>";
        }
    }
?>