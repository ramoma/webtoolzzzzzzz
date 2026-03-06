<?php

    session_start();

    if(isset($_SESSION['username'])){

        echo json_encode([
            "Status" => "account_logged",
            "message" => "account still logged in"
        ]);
        exit;
    }else{
        echo json_encode([
            "Status" => "account_not_logged",
            "message" => "account is not logged in"
        ]);
        exit;
    }

?>