<?php

    session_start();
    require_once("connection.php");

    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == "GET"){

        if(isset($_SESSION['username'])){
            $stmt = $conn->prepare("select count(*) from user_accounts where id is not null");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();


            $stmt2 = $conn->prepare("select
                count(case when duration_sess is not null then 1 end) as sessions_count,
                count(case when payment_status = 'Unpaid' then 1 end) as payment_status
                from sessions
            ");
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($sessions_count, $payment_status);
            $stmt2->fetch();
            $stmt2->close();

            echo json_encode([
                "Status" => "success",
                "user_count" => $count,
                "sessions_count" => $sessions_count,
                "payment_status" => $payment_status
            ]);
            exit;
        }else{
            echo json_encode([
                "Status" => "not_logged",
                "redirect" => "../pages/login_page.html"
            ]);
            exit;
        }


    }

?>
