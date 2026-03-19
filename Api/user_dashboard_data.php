<?php
    session_start();
    require_once('connection.php');

    $username = $_SESSION['username'];

    if($_SERVER['REQUEST_METHOD'] == "GET"){


        if(isset($_SESSION['username'])){
            $stmt = $conn->prepare("select count(*) from transactions where username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($sess_count);
            $stmt->fetch();
            $stmt->close();

            echo json_encode([
                "Status" => "success",
                "sess_count" => $sess_count
            ]);
            exit;

        }else{
            echo json_encode([
                "Status" => "not_logged",
                "redirect" => "login_page.html"
            ]);
            exit;
        }




    }


?>
