<?php
session_start();
$current_step = $_SESSION['step'] ?? 1;
?>
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
        /* what */
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
        .error-msg { color: red; font-size: 0.85rem; margin-top: 8px; display: none; }
        .success-msg { color: green; font-size: 0.85rem; margin-top: 8px; display: none; }
    </style>
</head>
<body>

<div class="bg-wrapper">
    <img src="../images/hero_banner_2.jpg" class="bg-image-tag" alt="Gym Background">
    <div class="gradient-overlay"></div>
</div>

<div class="container auth-content">

    <!-- STEP 1: Email -->
    <div id="step1" class="card-custom" <?= $current_step != 1 ? 'style="display:none"' : '' ?>>
        <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img"
             onerror="this.src='https://via.placeholder.com/180x50?text=AS+GYM'">
        <p class="mt-2 fw-bold text-black">Forgot Password</p>
        <div class="mb-3 text-start">
            <label class="form-label small fw-bold text-black mb-1">Enter Email</label>
            <input type="email" id="emailInput" class="form-control" required>
        </div>
        <p class="error-msg" id="step1Error"></p>
        <button onclick="submitEmail()" class="btn btn-pink">Submit</button>
    </div>

    <!-- STEP 2: OTP -->
    <div id="step2" class="card-custom" <?= $current_step != 2 ? 'style="display:none"' : '' ?>>
        <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img">
        <p class="mt-2 fw-bold text-black">Account Verification</p>
        <p class="small text-secondary">Enter the code sent to your email</p>
        <div class="d-flex justify-content-center mb-4">
            <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
            <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
            <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
            <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
            <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
            <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
        </div>
        <p class="error-msg" id="step2Error"></p>
        <button onclick="submitOTP()" class="btn btn-pink mb-2">Verify Code</button>
        <a href="#" onclick="resendOTP()" class="d-block small text-dark text-decoration-none fw-bold">Resend Code</a>
    </div>

    <!-- STEP 3: Reset Password -->
    <div id="step3" class="card-custom" <?= $current_step != 3 ? 'style="display:none"' : '' ?>>
        <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img">
        <p class="mt-2 fw-bold text-black">Reset Password</p>
        <div class="mb-3 text-start">
            <label class="form-label small fw-bold text-black mb-1">New Password</label>
            <div class="input-group">
                <input type="password" id="newPass" class="form-control">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('newPass', this)">👁️</button>
            </div>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label small fw-bold text-black mb-1">Confirm New Password</label>
            <div class="input-group">
                <input type="password" id="conPass" class="form-control">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('conPass', this)">👁️</button>
            </div>
        </div>
        <p class="error-msg" id="step3Error"></p>
        <p class="success-msg" id="step3Success"></p>
        <button onclick="submitReset()" class="btn btn-pink mt-2">Reset Password</button>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

    // ── Helper: show/hide steps ──
    function showStep(step) {
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step3').style.display = 'none';
        document.getElementById('step' + step).style.display = 'block';
    }

    // ── Helper: show error message ──
    function showError(id, msg) {
        const el = document.getElementById(id);
        el.textContent = msg;
        el.style.display = 'block';
    }

    function hideError(id) {
        document.getElementById(id).style.display = 'none';
    }

    // ── STEP 1: Submit Email ──
    async function submitEmail() {
        hideError('step1Error');
        const email = document.getElementById('emailInput').value;

        if (!email) {
            showError('step1Error', 'Please enter your email.');
            return;
        }

        // FormData sends data the same way a normal form POST would
        const formData = new FormData();
        formData.append('send_otp', '1');
        formData.append('email', email);

        const res  = await fetch('change_pass.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
            showStep(data.step); // move to step 2
        } else {
            showError('step1Error', data.message);
        }
    }

    // ── STEP 2: Submit OTP ──
    async function submitOTP() {
        hideError('step2Error');
        const boxes = document.querySelectorAll('.otp-input');
        const otp   = Array.from(boxes).map(b => b.value).join('');

        if (otp.length < 6) {
            showError('step2Error', 'Please enter the full 6-digit code.');
            return;
        }

        const formData = new FormData();
        formData.append('verify_otp', '1');
        // Send each digit as otp_code[] array — matches $_POST['otp_code'] in PHP
        boxes.forEach(b => formData.append('otp_code[]', b.value));

        const res  = await fetch('change_pass.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
            showStep(data.step); // move to step 3
        } else {
            showError('step2Error', data.message);
        }
    }

    // ── Resend OTP ──
    async function resendOTP() {
        const res  = await fetch('change_pass.php?resend=1');
        const data = await res.json();
        if (data.success) {
            showStep(1);
        }
    }

    // ── STEP 3: Reset Password ──
    async function submitReset() {
        hideError('step3Error');
        const newPass = document.getElementById('newPass').value;
        const conPass = document.getElementById('conPass').value;

        if (!newPass || !conPass) {
            showError('step3Error', 'Please fill in both fields.');
            return;
        }
        if (newPass !== conPass) {
            showError('step3Error', 'Passwords do not match.');
            return;
        }

        const formData = new FormData();
        formData.append('update_password', '1');
        formData.append('new_password', newPass);
        formData.append('con_new_pass', conPass);

        const res  = await fetch('change_pass.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
            const el = document.getElementById('step3Success');
            el.textContent = data.message;
            el.style.display = 'block';
            setTimeout(() => window.location.href = data.redirect, 1500); // redirect after 1.5s
        } else {
            showError('step3Error', data.message);
        }
    }

    // ── OTP auto-focus ──
    document.addEventListener("DOMContentLoaded", function () {
        const otpInputs = document.querySelectorAll('.otp-input');
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, '');
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
    });

    // ── Password toggle ──
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