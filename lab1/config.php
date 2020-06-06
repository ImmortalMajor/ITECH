<?php
    $username = 'root';
    $password = '';
    $dsn = 'mysql:host=localhost;dbname=iteh2lb1var4';

    try {
        $dbh = new PDO($dsn, $username, $password);
    }
    catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>"; die();
    }
?>