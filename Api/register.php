<?php

    require("connection.php");
    header("Content-Type: application/json");

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);


    $fullname = $data["fullname"] ?? "";
    // $email = $data["email"];
    // $gender = $data["gender"];
    // $membership = $data["memberhsip"];
    // $password = $data["password"];

    if($fullname != null){

        // setcookie("fullname", $fullname, time() + (86400 * 1), "/");

        echo json_encode([
            "message" => "the api is successfull!" // this will output in the console dont worry
        ]);
        exit;

    }
    else{
         echo json_encode([
            "message" => "sorry what?"
        ]);
        exit;
    }




?>