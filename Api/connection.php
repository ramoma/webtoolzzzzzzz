<?php
    $host = 'localhost';
    $db   = 'gym_database';
    $user = 'ramouna';
    $pass = 'password123';
    $conn = mysqli_connect($host, $user, $pass, $db);

    if(!$conn){
        die("error");
    }

?>
