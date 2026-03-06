<?php
session_start();
require_once '../Api/connection.php';

header("Content-Type: application/json");

$current_step = $_SESSION['step'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Step 1 — Send OTP
    if (isset($_POST['send_otp'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        $stmt = mysqli_prepare($conn, "SELECT id FROM user_accounts WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 0) {
            echo json_encode(["success" => false, "message" => "No account found with that email."]);
            exit;
        }

        $_SESSION['reset_email'] = $email;
        $_SESSION['generated_otp'] = 123456; // swap to rand(100000, 999999) when going live
        $_SESSION['step'] = 2;
        echo json_encode(["success" => true, "step" => 2]);
        exit;
    }

    // Step 2 — Verify OTP
    if (isset($_POST['verify_otp'])) {
        $user_otp = implode('', $_POST['otp_code']);

        if ($user_otp == $_SESSION['generated_otp']) {
            $_SESSION['step'] = 3;
            echo json_encode(["success" => true, "step" => 3]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid Verification Code."]);
        }
        exit;
    }

    // Step 3 — Reset Password
    if (isset($_POST['update_password'])) {
        $new_pass = $_POST['new_password'];
        $confirm  = $_POST['con_new_pass'];

        if ($new_pass === $confirm) {
            $hashed = password_hash($new_pass, PASSWORD_BCRYPT);
            $email  = $_SESSION['reset_email'];

            $stmt = mysqli_prepare($conn, "UPDATE user_accounts SET password = ? WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "ss", $hashed, $email);
            mysqli_stmt_execute($stmt);

            $_SESSION['error'] = "Password updated successfully!";
            session_destroy();
            header("Location: changepass.php");
            exit;
        } else {
            $_SESSION['error'] = "Passwords do not match!";
            header("Location: changepass.php");
            exit;
        }

        $hashed = password_hash($new_pass, PASSWORD_BCRYPT);
        $email  = $_SESSION['reset_email'];

        $stmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $hashed, $email);
        mysqli_stmt_execute($stmt);

        session_destroy();
        echo json_encode(["success" => true, "message" => "Password updated successfully!", "redirect" => "login_page.php"]);
        exit;
    }
}

// Resend OTP
if (isset($_GET['resend'])) {
    session_destroy();
    echo json_encode(["success" => true, "step" => 1]);
    exit;
}
?>