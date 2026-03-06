<?php
    session_start();

    require("connection.php");
    header("Content-type: application/json");

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $username = $data["username"] ?? "";
    $password = $data["password"] ?? "";

    if(isset($_SESSION['username'])){

        echo json_encode([
            "Status" => "account_logged",
            "message" => "account still logged in"
        ]);
        exit;
    }
    if(isset($data["login"])){

        $stmt = $conn->prepare("select count(*) from user_accounts where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($check_username);
        $stmt->fetch();
        $stmt->close();

        $stmt2 = $conn->prepare("select count(*) from user_accounts where password = ?");
        $stmt2->bind_param("s", $password);
        $stmt2->execute();
        $stmt2->bind_result($check_password);
        $stmt2->fetch();
        $stmt2->close();

        if($check_password > 0 && $check_username > 0){
            
            $_SESSION["username"] = $username;

            echo json_encode([
                "Status" => "success",
                "message" => "logging in" 
            ]);
            exit;

            
        }
        else{
            echo json_encode([
                "Status" => "failed",
                "message" => "wrong email or password"
            ]);
            exit;
        }
    }else{
        echo json_encode([
            "Status" => "not_logged",
            "message" => "no logged account"
        ]);
        exit;
    }

    
?>