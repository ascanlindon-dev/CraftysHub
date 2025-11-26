<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - CraftsHub Admin</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body { 
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", sans-serif;
    background: #faf9f7;
    padding: 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-wrapper {
    display: flex;
    width: 100%;
    max-width: 1200px;
    height: auto;
    min-height: 600px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.login-left {
    flex: 1;
    background: linear-gradient(135deg, #E8A89B 0%, #D9967D 50%, #F5DCC3 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 40px;
    color: white;
    position: relative;
    overflow: hidden;
}

/* Background image with overlay */
.login-left::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-image: url('https://i.pinimg.com/736x/15/b7/c3/15b7c30c361d8c83409dd5900e645fe0.jpg');
    background-size: cover;
    background-position: center;
    opacity: 0.85;
    z-index: 0;
    filter: brightness(1.1) saturate(1.15);
}

/* Dark overlay for text readability */
.login-left::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: linear-gradient(135deg, rgba(210, 140, 110, 0.5) 0%, rgba(217, 150, 125, 0.5) 100%);
    z-index: 1;
}

.login-left h2 {
    font-size: 2.2em;
    font-weight: 700;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.15);
    color: #fff;
    position: relative;
    z-index: 2;
}

.login-left p {
    font-size: 1em;
    opacity: 0.98;
    text-align: center;
    line-height: 1.6;
    max-width: 320px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    color: #fff;
    position: relative;
    z-index: 2;
}

.login-right {
    flex: 1;
    padding: 60px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-header {
    margin-bottom: 32px;
}

.login-header h3 {
    font-size: 1.8em;
    color: #2D2D2D;
    font-weight: 700;
    margin-bottom: 8px;
}

.login-header p {
    color: #777;
    font-size: 0.95em;
}

.form-group {
    margin-bottom: 20px;
}

label { 
    display: block;
    color: #2D2D2D;
    font-weight: 600;
    font-size: 0.92em;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

input { 
    width: 100%; 
    padding: 14px 16px; 
    border: 2px solid #E8D4C8;
    border-radius: 6px;
    font-size: 15px;
    font-family: inherit;
    transition: all 0.3s ease;
    background: #faf9f7;
}

input:hover {
    border-color: #D9967D;
    background: #fff;
}

input:focus { 
    outline: none;
    border-color: #C88A6F;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(200, 138, 111, 0.1);
}

input::placeholder {
    color: #999;
}

.password-container {
    position: relative;
    display: flex;
    align-items: center;
}

.password-container input {
    padding-right: 48px;
}

.password-toggle {
    position: absolute;
    right: 16px;
    cursor: pointer;
    user-select: none;
    font-size: 14px;
    color: #999;
    font-weight: 600;
    transition: all 0.3s;
    letter-spacing: 1px;
}

.password-toggle:hover {
    color: #C88A6F;
}

.forgot-password {
    text-align: right;
    margin-top: 12px;
}

.forgot-password a {
    color: #C88A6F;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: color 0.3s;
}

.forgot-password a:hover {
    color: #B8784D;
}

.btn { 
    width: 100%;
    margin-top: 28px;
    padding: 14px 16px;
    border: none;
    border-radius: 6px;
    background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
    color: white;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(200, 138, 111, 0.2);
}

.btn:hover { 
    background: linear-gradient(135deg, #CE8A74 0%, #BD7E63 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(200, 138, 111, 0.3);
}

.btn:active {
    transform: translateY(0);
}

.divider {
    margin: 28px 0;
    display: flex;
    align-items: center;
    color: #ccc;
}

.divider::before,
.divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: #ddd;
}

.divider span {
    padding: 0 12px;
    font-size: 13px;
    color: #999;
    font-weight: 500;
}

.google-btn {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #E8D4C8;
    background: #fff;
    color: #2D2D2D;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.google-btn:hover {
    border-color: #D9967D;
    background: #fff9f7;
}

.signup-link {
    text-align: center;
    margin-top: 24px;
    font-size: 14px;
    color: #777;
}

.signup-link a {
    color: #C88A6F;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s;
}

.signup-link a:hover {
    color: #B8784D;
}

.alert { 
    padding: 14px 16px;
    border-radius: 6px;
    margin-bottom: 24px;
    text-align: left;
    font-size: 14px;
    font-weight: 500;
}

.alert-success { 
    background: #f0f9ff;
    color: #0c5620;
    border: 1px solid #86efac;
}

.alert-error { 
    background: #fef2f2;
    color: #7f1d1d;
    border: 1px solid #fca5a5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-wrapper {
        flex-direction: column;
        min-height: auto;
    }

    .login-left {
        padding: 40px 30px;
        min-height: 200px;
    }

    .login-left h2 {
        font-size: 1.8em;
    }

    .login-right {
        padding: 40px 30px;
    }

    .login-header h3 {
        font-size: 1.5em;
    }
}

@media (max-width: 480px) {
    .login-left {
        padding: 30px 20px;
    }

    .login-right {
        padding: 30px 20px;
    }

    .login-left h2 {
        font-size: 1.5em;
    }

    .login-header h3 {
        font-size: 1.3em;
    }

    input,
    .btn,
    .google-btn {
        padding: 12px 14px;
        font-size: 14px;
    }
}
</style>
</head>
<body>

<div class="login-wrapper">
    <!-- Left Side -->
    <div class="login-left">
        <h2>CraftsHub</h2>
        <p>Welcome back to your merchant dashboard. Manage your store, track orders, and grow your business with ease.</p>
    </div>

    <!-- Right Side -->
    <div class="login-right">
        <div class="login-header">
            <h3>Sign In</h3>
            <p>Access your CraftsHub merchant account</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form method="POST" action="/login">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="login_password" placeholder="Enter your password" required>
                    <span class="password-toggle" onclick="togglePassword('login_password', this)">Show</span>
                </div>
                <div class="forgot-password">
                    <a href="/forgot-password">Forgot password?</a>
                </div>
            </div>

            <button type="submit" class="btn">Sign In</button>
        </form>

        <div class="divider">
            <span>Or</span>
        </div>

        <a href="/auth/google-login" class="google-btn">Continue with Google</a>

        <div class="signup-link">
            Don't have an account? <a href="/signup">Create one now</a>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, toggleElement) {
    const passwordInput = document.getElementById(inputId);
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Change text based on state
    toggleElement.textContent = type === 'password' ? 'Show' : 'Hide';
}
</script>

</body>
</html>