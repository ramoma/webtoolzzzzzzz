document.addEventListener("DOMContentLoaded", function(e){
    e.preventDefault();
    document.getElementById('step2').style.display = 'none';
    document.getElementById('step3').style.display = 'none';
});

function showStep(step){
    document.getElementById('step' + step).style.display = 'block';
    document.getElementById('step' + (step - 1)).style.display = 'none';
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

    const res  = await fetch('../Api/change_pass.php', { method: 'POST', body: formData });
    const data = await res.json();

    if (data.success) {
        showStep(data.step); // move to step 2
        // document.getElementById("step2").style.display = 'block';
        // document.getElementById("step1").style.display = 'none';
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

    const res  = await fetch('../Api/change_pass.php', { method: 'POST', body: formData });
    const data = await res.json();

    if (data.success) {
        showStep(data.step); // move to step 3
    } else {
        showError('step2Error', data.message);
    }
}

// ── Resend OTP ──
async function resendOTP() {
    const res  = await fetch('../Api/change_pass.php?resend=1');
    const data = await res.json();
    if (data.success) {
        document.getElementById("step1").style.display = 'block';
        document.getElementById("step2").style.display = 'none';
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

    const res  = await fetch('../Api/change_pass.php', { method: 'POST', body: formData });
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