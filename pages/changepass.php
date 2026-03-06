<?php require_once 'change_pass.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A's Gym - Password Recovery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-wrapper {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1; overflow: hidden;
        }
        .bg-image-tag {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center;
        }
        .gradient-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(to right, rgba(211,84,0,0.9), rgba(192,57,43,0.8), rgba(142,68,173,0.9));
        }
        .auth-content {
            height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .card-custom {
            background-color: #e0e0e0;
            border-radius: 0;
            width: 100%; max-width: 400px;
            padding: 2.5rem; text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        .logo-img { width: 180px; margin-bottom: 15px; }
        .btn-pink {
            background-color: #ff4db8; color: white;
            border-radius: 0; width: 100%;
            font-weight: bold; border: none; padding: 10px;
        }
        .btn-pink:hover { background-color: #e03ca3; color: white; }
        .otp-input {
            width: 42px; height: 52px;
            text-align: center; margin: 0 3px;
            border: 1px solid #999; font-size: 1.25rem;
        }
        .form-control { border-radius: 0; border: 1px solid #aaa; }
    </style>
</head>
<body>

<div class="bg-wrapper">
    <img src="../images/hero_banner_2.jpg" class="bg-image-tag" alt="Gym Background Image">
    <div class="gradient-overlay"></div>
</div>

<!-- Flash message -->
<?php if (!empty($_SESSION['error'])): ?>
    <div class="position-fixed top-0 w-100 d-flex justify-content-center mt-3" style="z-index:999">
        <div class="alert alert-info alert-dismissible fade show" role="alert" style="max-width:400px">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container auth-content">

    <!-- STEP 1: Enter Email -->
    <?php if ($current_step == 1): ?>
    <div class="card-custom">
        <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img"
             onerror="this.src='https://via.placeholder.com/180x50?text=AS+GYM'">
        <p class="mt-2 fw-bold text-black">Forgot Password</p>
        <form method="POST" action="changepass.php">
            <div class="mb-3 text-start">
                <label class="form-label small fw-bold text-black mb-1">Enter Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" name="send_otp" class="btn btn-pink">Submit</button>
        </form>
    </div>

    <!-- STEP 2: Enter OTP -->
    <?php elseif ($current_step == 2): ?>
    <div class="card-custom">
        <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img">
        <p class="mt-2 fw-bold text-black">Account Verification</p>
        <p class="small text-secondary">
            Enter the code sent to <strong><?= htmlspecialchars($_SESSION['reset_email'] ?? '') ?></strong>
        </p>
        <form method="POST" action="changepass.php">
            <div class="d-flex justify-content-center mb-4">
                <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
            </div>
            <button type="submit" name="verify_otp" class="btn btn-pink mb-2">Verify Code</button>
        </form>
        <a href="changepass.php?resend=1" class="d-block small text-dark text-decoration-none fw-bold">Resend Code</a>
    </div>

    <!-- STEP 3: Reset Password -->
    <?php elseif ($current_step == 3): ?>
    <div class="card-custom">
        <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img">
        <p class="mt-2 fw-bold text-black">Reset Password</p>
        <form method="POST" action="changepass.php" name="reset_form">
            <div class="mb-3 text-start">
                <label class="form-label small fw-bold text-black mb-1">New Password</label>
                <div class="input-group">
                    <input type="password" name="new_password" id="newPass" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('newPass', this)">👁️</button>
                </div>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label small fw-bold text-black mb-1">Confirm New Password</label>
                <div class="input-group">
                    <input type="password" name="con_new_pass" id="conPass" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('conPass', this)">👁️</button>
                </div>
            </div>
            <button type="submit" name="update_password" class="btn btn-pink mt-2">Reset Password</button>
        </form>
    </div>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // OTP auto-focus
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, ''); // digits only
            if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });
        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && e.target.value === "" && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });

    // Password match check
    const resetForm = document.querySelector('form[name="reset_form"]');
    if (resetForm) {
        resetForm.addEventListener('submit', function (e) {
            const pass    = document.getElementById('newPass').value;
            const confirm = document.getElementById('conPass').value;
            if (pass !== confirm) {
                e.preventDefault();
                alert("Passwords do not match!");
            }
        });
    }
});

function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
        input.type = "text";
        btn.textContent = "🙈";
    } else {
        input.type = "password";
        btn.textContent = "👁️";
    }
}
</script>
</body>
</html>