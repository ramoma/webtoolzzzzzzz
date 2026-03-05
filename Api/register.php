<?php

    require("connection.php");
    header("Content-Type: application/json");

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);
    
    if(isset($data["c_submit"])){

        $email = $data["email"];
        

        $stmt = $conn->prepare("select count(*) from user_accounts where email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($resulting_email);

        $result = $stmt->fetch();

        if($resulting_email > 0){
           echo json_encode([
            "Status" => "error",
            "message" => "Email already in use"
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
    // else{

        
    // }


    if(isset($data["status"])){

        $username = $data["username"];
        $password = $data["password"];
        $email = $data["email"];

        // $stmt = $conn->prepare("select * from user_accounts where email = ?");
        // $stmt->bind_param("s", $email);
        // $stmt->execute();

        // $result = $stmt->fetch();

        // if($result){
        //    echo json_encode([
        //     "Status" => "error",
        //     "message" => "Email already in use!"
        //     ]); 
        //     exit;
        // }
        // else{
            $stmt = $conn->prepare("insert into user_accounts(full_name, username, email, password) values(?,?,?,?)");
            $stmt->bind_param("ssss",$username, $username, $email, $password);
            $stmt->execute();
            

            echo json_encode([
                "Status" => "successful",
                "message" => "the api is successfull!: username {$username}, {$password}, {$email}" // this will output in the console dont worry
            ]); 
            exit;
        // }
        

    }
    else{
         echo json_encode([
            "message" => "sorry what?"
        ]);
        exit;
    }

    // function check_indexes($username, $email){
    //     $stmt = $conn->prepare("select username from user_accounts where username = (?)");
    //     $stmt->bind_param("s", $username);
    //     $stmt->execute();

    //     $result = $stmt->get_result();

    //     if(!empty($result)){
    //         echo json_encode([
    //             "message" => "user already exists"
    //         ]);
    //     }
    //     else{
    //         echo json_encode([
    //             "message" => "okay"
    //         ]);
    //     }
    // }


?>