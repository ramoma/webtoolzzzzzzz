<?php
    $host = 'localhost';
    $db   = 'gym_database';
    $user = 'root';
    $pass = '';
    $conn = mysqli_connect($host, $user, $pass, $db);

    if(!$conn){
        die("error");
    }

?>