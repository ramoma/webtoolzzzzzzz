<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A's Gym - Password Recovery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Container for the image and the gradient overlay */
        .bg-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        /* The Base Image */
        .bg-image-tag {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* The Gradient Overlay (matches your original screenshot exactly) */
        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Left-to-Right gradient using colors from your image */
            background: linear-gradient(to right, rgba(211, 84, 0, 0.9), rgba(192, 57, 43, 0.8), rgba(142, 68, 173, 0.9));
        }

        /* Authentication UI Styling */
        .auth-content {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1; /* Sits above the gradient */
        }

        .card-custom {
            background-color: #e0e0e0; /* Gray box from your image */
            border-radius: 0;
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .logo-img {
            width: 180px;
            margin-bottom: 15px;
        }

        /* The Pink Button and Link colors */
        .btn-pink {
            background-color: #ff4db8;
            color: white;
            border-radius: 0;
            width: 100%;
            font-weight: bold;
            border: none;
            padding: 10px;
        }

        .btn-pink:hover { background-color: #e03ca3; color: white; }
        
        .otp-input {
            width: 42px;
            height: 52px;
            text-align: center;
            margin: 0 3px;
            border: 1px solid #999;
            font-size: 1.25rem;
        }

        .hidden { display: none; }
        .form-control { border-radius: 0; border: 1px solid #aaa; }
    </style>
</head>
<body>

        <form method="POST" action="changepass.php">

    <div class="bg-wrapper">
        <img src="../images/hero_banner_2.jpg" class="bg-image-tag" alt="Gym Background Image">
        <div class="gradient-overlay"></div>
    </div>

    <div class="container auth-content">
        
        <div id="step1" class="card-custom">
            <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img" onerror="this.src='https://via.placeholder.com/180x50?text=AS+GYM'">
            <p class="mt-2 fw-bold text-black">Forgot Password</p>
            <div class="mb-3 text-start">
                <label class="form-label small fw-bold text-black mb-1">Enter Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button onclick="showStep(2)" class="btn btn-pink">Submit</button>
        </div>

        <div id="step2" class="card-custom hidden">
            <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img">
            <p class="mt-2 fw-bold text-black">Account Verification</p>
            <p class="small text-secondary">Enter Code Here</p>
            <div class="d-flex justify-content-center mb-4">
                <input type="text" maxlength="1" class="otp-input" required>
                <input type="text" maxlength="1" class="otp-input" required>
                <input type="text" maxlength="1" class="otp-input" required>
                <input type="text" maxlength="1" class="otp-input" required>
                <input type="text" maxlength="1" class="otp-input" required>
                <input type="text" maxlength="1" class="otp-input" required>
            </div>
            <button onclick="showStep(3)" class="btn btn-pink mb-2">Verify Code</button>
            <a href="#" class="d-block small text-dark text-decoration-none fw-bold">Resend Code</a>
        </div>

        <div id="step3" class="card-custom hidden">
            <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img">
            <p class="mt-2 fw-bold text-black">Reset Password</p>
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
    <br>
        <button onclick="return checkpassword();" class="btn btn-pink">Reset Password</button>
    </div>

    <script>
        function showStep(step) {
            document.querySelectorAll('.card-custom').forEach(card => card.classList.add('hidden'));
            document.getElementById('step' + step).classList.remove('hidden');
        }

        function checkpassword() {
            const newPass = document.querySelector('input[name="new_password"]').value;
            const conNewPass = document.querySelector('input[name="con_new_pass"]').value;
            if (newPass != conNewPass) {
                alert("Passwords do not match!");
                return false; // Prevent form submission
            } else{
                alert("Password Updated!");
                window.location.href = "login_page.html"; // redirect after success
                return true; // Allow form submission
            }
        }

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

    document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
    input.addEventListener('input', function () {
        if (this.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && this.value === '' && index > 0) {
            inputs[index - 1].focus();
        }
    });
});
    
    </script>
</body>
</html>