<?php
    session_start();

    require("connection.php");
    header("Content-Type: application/json");

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $username = $data["username"] ?? "";
    $password = $data["password"] ?? "";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_SESSION['username'])){

            echo json_encode([
                "Status" => "account_logged",
                "message" => "account still logged in"
            ]);
            exit;
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($data["logout"])){

            session_destroy();

            echo json_encode([
                "message" => "something testing testing"
            ]);

            exit;
        }

        if(isset($data["login"])){

            $stmt = $conn->prepare("select password, role from user_accounts where username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0){

                $stmt->bind_result($check_password, $role);
                $stmt->fetch();

                if(password_verify($password, $check_password)){
                    $_SESSION['username'] = $username;

                    // $stmt = $conn->prepare("update user_accounts set activity_status = 'Active' where username = ? ");
                    // $stmt->bind_param("s",$username);
                    // $stmt->execute();

                    switch($role){
                        case "Admin":
                            echo json_encode([
                                "Status" => "success",
                                "message" => "logging in",
                                "redirect" => "admin_dashboard.html"
                            ]);
                            break;
                        case "User":
                            echo json_encode([
                                "Status" => "success",
                                "message" => "logging in",
                                "redirect" => "user_dashboard.html"
                            ]);
                            break;
                        case "Trainer":
                            echo json_encode([
                                "Status" => "success",
                                "message" => "logging in",
                                "redirect" => "trainer_dashboard.html"
                            ]);
                            break;

                    }
                    $stmt->close();

                    exit;
                }else{
                    echo json_encode([
                        "Status"=>"failed",
                        "message" => "wrong password"
                    ]);
                    exit;
                }
            }else{
                echo json_encode([
                    "Status" => "failed",
                    "message" => "wrong username"
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
    }
?>
