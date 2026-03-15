<?php
    session_start();


    if(isset($_SESSION['username'])){

        echo json_encode([
            "Status" => "account_logged",
            "message" => "account is already loggged",
        ]);
        exit;

    }
    else{
        echo json_encode([
            "Status" => "no_acc_logged",
            "message" => "no account logged"
        ]);
        exit;
    }


?>
