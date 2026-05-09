<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Rizvi Group</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #F8FAFC;
            --card: #E2E8F0;
            --accent: #2563EB;
            --accent-glow: #60A5FA;
            --text: #0F172A;
            --muted: #8a8f9d;
            --border: rgba(255,255,255,0.05);
            --radius: 20px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: 
                radial-gradient(circle at 20% 20%, rgba(201,168,76,0.05) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(201,168,76,0.05) 0%, transparent 40%);
        }

        .login-container {
            position: relative;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        .login-card {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 50px 40px;
            border-radius: var(--radius);
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
            text-align: center;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            background: linear-gradient(135deg, var(--border), var(--accent-glow), var(--border));
            z-index: -1;
            border-radius: calc(var(--radius) + 2px);
            opacity: 0.5;
        }

        .logo-icon {
            font-size: 48px;
            margin-bottom: 24px;
            display: inline-flex;
            width: 80px;
            height: 80px;
            background: rgba(201,168,76,0.1);
            border-radius: 20px;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            text-shadow: 0 0 20px var(--accent-glow);
        }

        h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 32px;
            margin-bottom: 12px;
            background: linear-gradient(to right, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 16px;
            transition: color 0.3s;
        }

        .input-wrap input {
            width: 100%;
            background: rgba(0,0,0,0.2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px 16px 50px;
            color: #fff;
            font-size: 15px;
            outline: none;
            transition: all 0.3s;
        }

        .input-wrap input:focus {
            border-color: var(--accent);
            background: rgba(0,0,0,0.3);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .input-wrap input:focus + i {
            color: var(--accent);
        }

        .btn-login {
            width: 100%;
            background: var(--accent);
            color: #000;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            background: #60A5FA;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(201,168,76,0.2);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-msg {
            background: rgba(232,82,82,0.1);
            color: #ff6b6b;
            padding: 14px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 24px;
            display: none;
            border: 1px solid rgba(232,82,82,0.2);
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .login-footer {
            margin-top: 30px;
            font-size: 13px;
            color: var(--muted);
        }

        .login-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-card" id="loginView">
        <div class="logo-icon">🎓</div>
        <h1>Admin Access</h1>
        <p>Enter your credentials to manage the Rizvi Group portal.</p>

        <div id="error" class="error-msg">Invalid username or password</div>

        <form id="loginForm">
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrap">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" placeholder="e.g. admin" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <div style="text-align: right; margin-top: 8px;">
                    <a href="javascript:void(0)" onclick="toggleView('forgot')" style="font-size: 12px; color: var(--accent); text-decoration: none;">Forgot Password?</a>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <span>Secure Login</span>
                <i class="fa fa-arrow-right"></i>
            </button>
        </form>

        <div class="login-footer">
            &copy; 2025 Rizvi Group &bull; <a href="index.php">Back to Site</a>
        </div>
    </div>

    <!-- Forgot Password View -->
    <div class="login-card" id="forgotView" style="display: none;">
        <div class="logo-icon">🔑</div>
        <h1>Reset Password</h1>
        <p>Enter your username or email address and we'll send you instructions to reset your password.</p>

        <div id="forgotMsg" class="error-msg" style="background: rgba(37,99,235,0.1); color: var(--accent); border-color: rgba(37,99,235,0.2);">Request sent successfully</div>

        <form id="forgotForm">
            <div class="form-group">
                <label>Username or Email</label>
                <div class="input-wrap">
                    <i class="fa fa-envelope"></i>
                    <input type="text" name="identity" placeholder="Enter your registered identity" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <span>Send Reset Link</span>
                <i class="fa fa-paper-plane"></i>
            </button>
        </form>

        <div class="login-footer">
            <a href="javascript:void(0)" onclick="toggleView('login')" style="color: var(--accent); text-decoration: none; font-weight: 600;">
                <i class="fa fa-arrow-left" style="margin-right: 5px;"></i> Back to Login
            </a>
        </div>
    </div>
</div>

<script>
function toggleView(view) {
    const login = document.getElementById('loginView');
    const forgot = document.getElementById('forgotView');
    const err = document.getElementById('error');
    const msg = document.getElementById('forgotMsg');
    
    err.style.display = 'none';
    msg.style.display = 'none';

    if (view === 'forgot') {
        login.style.display = 'none';
        forgot.style.display = 'block';
    } else {
        login.style.display = 'block';
        forgot.style.display = 'none';
    }
}

document.getElementById('forgotForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = this.querySelector('button');
    const msg = document.getElementById('forgotMsg');
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    
    setTimeout(() => {
        msg.textContent = 'A reset request has been sent to the super admin. You will be notified shortly.';
        msg.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = '<span>Send Reset Link</span><i class="fa fa-paper-plane"></i>';
    }, 1500);
});

document.getElementById('loginForm').addEventListener('submit', async function(e) {
    const err = document.getElementById('error');
    err.style.background = ''; // Reset style if it was changed by forgotPassword
    err.style.color = '';
    err.style.borderColor = '';
    
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('action', 'login');

    try {
        const response = await fetch('backend.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if (data.success) {
            window.location.href = 'admin.php';
        } else {
            const err = document.getElementById('error');
            err.textContent = data.message || 'Login failed';
            err.style.display = 'block';
        }
    } catch (error) {
        console.error(error);
    }
});
</script>

</body>
</html>
