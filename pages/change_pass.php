<?php
session_start();
require_once '../Api/connection.php';
header("Content-Type: application/json");

// --- 1. PHP BACKEND LOGIC ---
// This part handles the form submissions when the page reloads
$message = "";
$current_step = $_SESSION['step'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Action: Request OTP
    if (isset($_POST['send_otp'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Check if email exists
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        $_SESSION['error'] = "No account found with that email.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $_SESSION['reset_email'] = $email;
    $_SESSION['generated_otp'] = 12345; // rand(100000, 999999);
    $_SESSION['step'] = 2;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

    // Action: Verify OTP
    if (isset($_POST['verify_otp'])) {  
        $user_otp = implode('', $_POST['otp_code']);
        if ($user_otp == $_SESSION['generated_otp']) {
            $_SESSION['step'] = 3;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $message = "Invalid Verification Code.";
        }
    }

    // Action: Reset Password
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
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
}
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Select all OTP input fields
    const inputs = document.querySelectorAll('.otp-input');

    inputs.forEach((input, index) => {
        // Auto-focus move to next box
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        // Handle Backspace
        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && e.target.value === "" && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    // Client-side Password Match Validation
    const resetForm = document.querySelector('form[name="reset_form"]');
    if (resetForm) {
        resetForm.addEventListener('submit', function(e) {
            const pass = document.getElementById('new_pass').value;
            const confirm = document.getElementById('confirm_pass').value;
            if (pass !== confirm) {
                e.preventDefault();
                alert("Passwords do not match!");
            }
        });
    }
});
</script>