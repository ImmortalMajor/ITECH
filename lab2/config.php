<?php
    // $username = 'root';
    // $password = '';
    // $dsn = 'mysql:host=localhost;dbname=iteh2lb1var4';

    // try {
    //     $dbh = new PDO($dsn, $username, $password);
    // }
    // catch (PDOException $e) {
    //     echo "Error!: " . $e->getMessage() . "<br/>"; die();
    // }
    require_once __DIR__ . "/vendor/autoload.php";
    $db = (new MongoDB\Client)->test;
    $collection = $db->hospital;
?>