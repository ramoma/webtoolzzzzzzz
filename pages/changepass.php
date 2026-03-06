<?php
// Load the backend logic first
require_once 'connection.php';
header("Content-Type: application/json");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A's Gym - Password Recovery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Barlow:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink:        #ff4db8;
            --pink-dark:   #e03ca3;
            --orange:      #d35400;
            --red:         #c0392b;
            --purple:      #8e44ad;
        }

        /* ── Background ── */
        body {
            min-height: 100vh;
            font-family: 'Barlow', sans-serif;
            overflow: hidden;
        }

        .bg-wrapper {
            position: fixed;
            inset: 0;
            z-index: -1;
        }
        .bg-image-tag {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center;
        }
        .gradient-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(211,84,0,0.92) 0%,
                rgba(192,57,43,0.85) 45%,
                rgba(142,68,173,0.92) 100%
            );
        }

        /* ── Card ── */
        .auth-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: rgba(255,255,255,0.97);
            border-radius: 4px;
            width: 100%;
            max-width: 420px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.45);
            border-top: 4px solid var(--pink);
        }

        /* ── Logo / headings ── */
        .logo-img {
            width: 160px;
            margin-bottom: 0.5rem;
        }

        .step-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #1a1a1a;
            margin-bottom: 0.25rem;
        }

        .step-sub {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        /* ── Divider ── */
        .title-divider {
            width: 40px;
            height: 3px;
            background: var(--pink);
            margin: 0.4rem auto 1.25rem;
            border-radius: 2px;
        }

        /* ── Form labels ── */
        .form-label {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #444;
            margin-bottom: 0.35rem;
        }

        /* ── Inputs ── */
        .form-control {
            border: 1.5px solid #ddd;
            border-radius: 3px;
            padding: 0.6rem 0.85rem;
            font-size: 0.95rem;
            transition: border-color 0.2s;
            background: #fafafa;
        }
        .form-control:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(255,77,184,0.12);
            background: #fff;
        }

        /* ── Input group toggle button ── */
        .input-group .btn-outline-secondary {
            border: 1.5px solid #ddd;
            border-left: none;
            border-radius: 0 3px 3px 0;
            color: #888;
            background: #fafafa;
            padding: 0 0.75rem;
            font-size: 1rem;
            transition: background 0.15s;
        }
        .input-group .btn-outline-secondary:hover {
            background: #f0f0f0;
            color: #555;
        }
        .input-group .form-control {
            border-radius: 3px 0 0 3px;
        }

        /* ── OTP inputs ── */
        .otp-group {
            gap: 8px;
        }
        .otp-input {
            width: 46px;
            height: 54px;
            text-align: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            border: 1.5px solid #ddd;
            border-radius: 3px;
            background: #fafafa;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #1a1a1a;
        }
        .otp-input:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(255,77,184,0.12);
            background: #fff;
            outline: none;
        }

        /* ── Primary button ── */
        .btn-pink {
            background: var(--pink);
            color: #fff;
            border: none;
            border-radius: 3px;
            width: 100%;
            padding: 0.7rem;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(255,77,184,0.35);
        }
        .btn-pink:hover {
            background: var(--pink-dark);
            color: #fff;
            box-shadow: 0 6px 18px rgba(255,77,184,0.45);
            transform: translateY(-1px);
        }
        .btn-pink:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(255,77,184,0.3);
        }

        /* ── Resend link ── */
        .resend-link {
            font-size: 0.82rem;
            font-weight: 600;
            color: #555;
            text-decoration: none;
            letter-spacing: 0.03em;
            transition: color 0.15s;
        }
        .resend-link:hover { color: var(--pink); }

        /* ── Step indicator dots ── */
        .step-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 1.5rem;
        }
        .step-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #ddd;
            transition: background 0.3s, transform 0.3s;
        }
        .step-dot.active {
            background: var(--pink);
            transform: scale(1.3);
        }
        .step-dot.done {
            background: var(--pink-dark);
        }

        /* ── Alert override ── */
        .alert-info {
            background: #fff0f8;
            border-color: var(--pink);
            color: #a0006e;
            border-radius: 3px;
            font-size: 0.88rem;
        }
    </style>
</head>
<body>

<!-- Background -->
<div class="bg-wrapper">
    <img src="../images/hero_banner_2.jpg" class="bg-image-tag" alt="Gym Background"
         onerror="this.style.display='none'">
    <div class="gradient-overlay"></div>
</div>

<!-- Flash Message -->
<?php if (!empty($_SESSION['error'])): ?>
    <div class="position-fixed top-0 w-100 d-flex justify-content-center pt-3" style="z-index:1050">
        <div class="alert alert-info alert-dismissible fade show shadow" role="alert" style="max-width:420px">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Main -->
<div class="container auth-wrap">
    <div class="auth-card">

        <!-- Logo -->
        <div class="text-center mb-3">
            <img src="../images/image-removebg-preview.png" alt="A'S GYM" class="logo-img"
                 onerror="this.src='https://via.placeholder.com/160x45?text=A%27S+GYM'">
        </div>

        <!-- Step indicator -->
        <div class="step-dots">
            <div class="step-dot <?= $current_step == 1 ? 'active' : 'done' ?>"></div>
            <div class="step-dot <?= $current_step == 2 ? 'active' : ($current_step > 2 ? 'done' : '') ?>"></div>
            <div class="step-dot <?= $current_step == 3 ? 'active' : '' ?>"></div>
        </div>

        <!-- ── STEP 1: Email ── -->
        <?php if ($current_step == 1): ?>
            <div class="text-center">
                <p class="step-title">Forgot Password</p>
                <div class="title-divider"></div>
                <p class="step-sub">Enter your registered email and we'll send you a verification code.</p>
            </div>
            <form method="POST" action="forgot_password.php">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="you@example.com" required>
                </div>
                <button type="submit" name="send_otp" class="btn btn-pink mt-1">
                    Send Code
                </button>
            </form>

        <!-- ── STEP 2: OTP ── -->
        <?php elseif ($current_step == 2): ?>
            <div class="text-center">
                <p class="step-title">Verify Code</p>
                <div class="title-divider"></div>
                <p class="step-sub">
                    6-digit code sent to<br>
                    <strong class="text-dark"><?= htmlspecialchars($_SESSION['reset_email'] ?? '') ?></strong>
                </p>
            </div>
            <form method="POST" action="forgot_password.php">
                <div class="d-flex justify-content-center otp-group mb-4">
                    <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                    <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                    <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                    <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                    <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                    <input type="text" name="otp_code[]" maxlength="1" class="otp-input" inputmode="numeric" required>
                </div>
                <button type="submit" name="verify_otp" class="btn btn-pink mb-3">Verify Code</button>
            </form>
            <div class="text-center">
                <a href="forgot_password.php?resend=1" class="resend-link">
                    Didn't get it? Resend code →
                </a>
            </div>

        <!-- ── STEP 3: Reset Password ── -->
        <?php elseif ($current_step == 3): ?>
            <div class="text-center">
                <p class="step-title">Reset Password</p>
                <div class="title-divider"></div>
                <p class="step-sub">Choose a strong new password for your account.</p>
            </div>
            <form method="POST" action="forgot_password.php" name="reset_form">
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_pass"
                               class="form-control" placeholder="••••••••" required>
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePassword('new_pass', this)">👁️</button>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" name="con_new_pass" id="confirm_pass"
                               class="form-control" placeholder="••••••••" required>
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePassword('confirm_pass', this)">👁️</button>
                    </div>
                </div>
                <button type="submit" name="update_password" class="btn btn-pink">Reset Password</button>
            </form>
        <?php endif; ?>

    </div><!-- /auth-card -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // OTP auto-focus
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            // Only allow digits
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

    // Client-side password match check
    const resetForm = document.querySelector('form[name="reset_form"]');
    if (resetForm) {
        resetForm.addEventListener('submit', function (e) {
            const pass    = document.getElementById('new_pass').value;
            const confirm = document.getElementById('confirm_pass').value;
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