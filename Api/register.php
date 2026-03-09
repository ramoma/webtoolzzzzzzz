<?php
    session_start();
    require("connection.php");
    header("Content-Type: application/json");

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $fullname       = ucwords($data["fullname"] ?? "");
    $username       = $data["username"] ?? "";
    $password       = $data["password"] ?? "";
    $hashed         = password_hash($password, PASSWORD_BCRYPT)  ?? "";
    $email          = $data["email"] ?? "";
    $filtered_email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $gender         = $data["gender"] ?? "";
    $membership     = $data["membership"] ?? "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_SESSION['username'])){

            echo json_encode([
                "Status" => "account_logged",
                "message" => "account still logged in"
            ]);
            exit;
        }
        
        if(isset($data["c_submit"])){

            if(filter_var($filtered_email, FILTER_VALIDATE_EMAIL)){

                $stmt = $conn->prepare("select
                    count(case when username = ? then 1 end) as check_username, 
                    count(case when email = ? then 1 end) as check_email
                    from user_accounts"
                );

                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $stmt->bind_result($resulting_username, $resulting_email);
                $stmt->fetch();
                $stmt->close();
            
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
            }else{
                echo json_encode([
                    "Status" => "invalid email",
                    "message" => "email is invalid"
                ]);
                exit;
            }
            
        }
        
        if(isset($data["status"])){

            $stmt = $conn->prepare("insert into user_accounts(full_name, username, email, password, gender) values(?,?,?,?,?)");
            $stmt->bind_param("sssss",$fullname, $username, $email, $hashed, $gender);
            $stmt->execute();
            $stmt->close();
            

            echo json_encode([
                "Status" => "success",
                "message" => "something", // this will output in the console dont worry
                "location" => "logint_page.html"
            ]); 
            exit;
        }

        if(isset($data["register"])){
            
            $stmt = $conn->prepare("insert into user_accounts(full_name, username, email, password, gender, membership) values(?,?,?,?,?,?)");
            $stmt->bind_param("ssssss",$fullname, $username, $email, $hashed, $gender, $membership);
            $stmt->execute();
            $stmt->close();
            

            echo json_encode([
                "Status" => "success",
                "message" => "the api is successfull!: username", // this will output in the console dont worry
                "location" => "login_page.html"
            ]); 
            exit;
        }
    }
?>