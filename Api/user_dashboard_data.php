<?php

    session_start();
    require_once("connection.php");

    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == "GET"){

        $stmt = $conn->prepare("select count(*) from user_accounts where id is not null");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        echo json_encode([
            "user_count" => $count
        ]);
        exit;

    }

?>
