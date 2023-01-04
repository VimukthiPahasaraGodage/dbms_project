<?php
    // Please update the username and password for the server login if changed
    // Please log into phpMyAdmin and run the SQL statements in DDL.txt and DML.txt
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'supplychain';

    // Create a connection with the server
    $connection = mysqli_connect($servername, $username, $password, $database);
    if(!$connection){
        // TODO: handle the error
        die('Connection to the database failed!');
    }

