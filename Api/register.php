<?php
    session_start();
    require("connection.php");
    header("Content-Type: application/json");

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);
    
    if(isset($data["c_submit"])){

        $email = $data["email"];
        $username = $data["username"];
        

        $stmt = $conn->prepare("select count(*) from user_accounts where email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($resulting_email);
        $stmt->fetch();
        $stmt->close();

        $stmt2 = $conn->prepare("select count(*) from user_accounts where username = ?");
        $stmt2->bind_param("s",$username);
        $stmt2->execute();
        $stmt2->bind_result($resulting_username);
        $stmt2->fetch();
        $stmt2->close();


        if($resulting_email > 0 && $resulting_username > 0){
           echo json_encode([
            "Status" => "account error",
            "message" => "account already exists"
            ]); 
            exit;
        }
        else if($resulting_username > 0){
            echo json_encode([
                "Status" => "user error",
                "message" => "username is already in use"
            ]);
            exit;
        }
        else if($resulting_email > 0){
            echo json_encode([
                "Status" => "email error",
                "message" => "email already in use"
            ]);
            exit;
        }
        else{
            echo json_encode([
            "Status" => "Success",
            "message"=> "email is available" 
            ]);
            exit;
        }
    }

    if(isset($data["status"])){

        $fullname = $data["fullname"];
        $username = $data["username"];
        $password = $data["password"];
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $email = $data["email"];
        $gender = $data["gender"];


        $stmt = $conn->prepare("insert into user_accounts(full_name, username, email, password, gender) values(?,?,?,?,?)");
        $stmt->bind_param("sssss",$fullname, $username, $email, $hashed, $gender);
        $stmt->execute();
        $stmt->close();
        

        echo json_encode([
            "Status" => "success",
            "message" => "the api is successfull!: username" // this will output in the console dont worry
        ]); 
        exit;
    }

    if(isset($data["register"])){
        $fullname = $data["fullname"];
        $username = $data["username"];
        $password = $data["password"];
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $email = $data["email"];
        $gender = $data["gender"];
        $membership = $data["membership"];

        $stmt = $conn->prepare("insert into user_accounts(full_name, username, email, password, gender, membership) values(?,?,?,?,?,?)");
        $stmt->bind_param("ssssss",$fullname, $username, $email, $hashed, $gender, $membership);
        $stmt->execute();
        $stmt->close();
        

        echo json_encode([
            "Status" => "success",
            "message" => "the api is successfull!: username" // this will output in the console dont worry
        ]); 
        exit;
    }
?>