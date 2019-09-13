<?php
    include 'Models/DBConnection.php';
    define("SERVER", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DATABASENAME", "storesdb");

    $db= new DBConnection(SERVER, USERNAME , PASSWORD ,DATABASENAME);
    $conn=$db->getMySQLConnection();

?>