<?php
    session_start();

    require("connection.php");
    header("Content-type: application/json");

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $username = $data["username"] ?? "";
    $password = $data["password"] ?? "";

    if(isset($data["logout"])){
        
        session_destroy();

        echo json_encode([
            "message" => "something testing testing"
        ]);
        
        exit;
    }
    if(isset($_SESSION['username'])){

        echo json_encode([
            "Status" => "account_logged",
            "message" => "account still logged in"
        ]);
        exit;
    }
    if(isset($data["login"])){

        $stmt = $conn->prepare("select password from user_accounts where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){

            $stmt->bind_result($check_password);
            $stmt->fetch();

            if(password_verify($password, $check_password)){
                $_SESSION['username'] = $username;

                echo json_encode([
                    "Status" => "success",
                    "message" => "loogging in {$check_password}"
                ]);
                exit;
            }

            
        }
        else{
            echo json_encode([
                "Status" => "failed",
                "message" => "wrong email or passwordx`"
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