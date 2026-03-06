<?php
session_start();
require_once '../Api/connection.php';

$message = "";
$current_step = $_SESSION['step'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Step 1 — Send OTP
    if (isset($_POST['send_otp'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 0) {
            $_SESSION['error'] = "No account found with that email.";
            header("Location: changepass.php");
            exit;
        }

        $_SESSION['reset_email'] = $email;
        $_SESSION['generated_otp'] = 12345; // swap to rand(100000, 999999) when going live
        $_SESSION['step'] = 2;
        header("Location: changepass.php");
        exit;
    }

    // Step 2 — Verify OTP
    if (isset($_POST['verify_otp'])) {
        $user_otp = implode('', $_POST['otp_code']);
        if ($user_otp == $_SESSION['generated_otp']) {
            $_SESSION['step'] = 3;
            header("Location: changepass.php");
            exit;
        } else {
            $_SESSION['error'] = "Invalid Verification Code.";
            header("Location: changepass.php");
            exit;
        }
    }

    // Step 3 — Reset Password
    if (isset($_POST['update_password'])) {
        $new_pass = $_POST['new_password'];
        $confirm  = $_POST['con_new_pass'];

        if ($new_pass === $confirm) {
            $hashed = password_hash($new_pass, PASSWORD_BCRYPT);
            $email  = $_SESSION['reset_email'];

            $stmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE email = ?");
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
    }
}

// Handle Resend Code
if (isset($_GET['resend'])) {
    session_destroy();
    header("Location: changepass.php");
    exit;
}
?>