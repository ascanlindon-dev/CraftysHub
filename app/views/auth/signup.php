<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - CraftsHub Admin</title>
<style>
body { 
    font-family: "Poppins", sans-serif; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 0;
    margin: 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.signup-container { 
    background: #fff; 
    padding: 40px; 
    border-radius: 15px; 
    max-width: 400px; 
    width: 100%;
    margin: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
}
.logo { text-align: center; margin-bottom: 30px; }
.logo h1 { color: #667eea; margin: 0; font-size: 2.5em; }
.logo p { color: #666; margin: 5px 0 0 0; }
label { display: block; margin-top: 15px; color: #333; font-weight: 500; }
input { 
    width: 100%; 
    padding: 12px; 
    margin-top: 5px; 
    border: 1px solid #ddd; 
    border-radius: 8px; 
    box-sizing: border-box;
    font-size: 16px;
}
input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
.btn { 
    width: 100%;
    margin-top: 20px; 
    padding: 12px; 
    border: none; 
    border-radius: 8px; 
    background: #667eea; 
    color: white; 
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s;
}
.btn:hover { background: #5a67d8; transform: translateY(-1px); }
.login-link { text-align: center; margin-top: 20px; }
.login-link a { color: #667eea; text-decoration: none; }
.login-link a:hover { text-decoration: underline; }
.alert { 
    padding: 12px; 
    border-radius: 8px; 
    margin-bottom: 20px; 
    text-align: center;
}
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

/* Password Toggle Styles */
.password-container {
    position: relative;
    display: flex;
    align-items: center;
}
.password-container input {
    padding-right: 45px;
    margin: 0;
}
.password-toggle {
    position: absolute;
    right: 15px;
    cursor: pointer;
    user-select: none;
    font-size: 18px;
    opacity: 0.7;
    transition: opacity 0.3s;
}
.password-toggle:hover {
    opacity: 1;
}
</style>
</head>
<body>
<div class="signup-container">
    <div class="logo">
        <h1>🎨 CraftsHub</h1>
        <p>Create Admin Account</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if(isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            ✅ <?= $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['error_message'])): ?>
        <div class="alert alert-error">
            ❌ <?= $_SESSION['error_message']; ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <form method="POST" action="/signup">
        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="tel" name="phone_number" required>

        <label>Password</label>
        <div class="password-container">
            <input type="password" name="password" id="signup_password" required>
            <span class="password-toggle" onclick="togglePassword('signup_password', this)">👁️</span>
        </div>

        <label>Confirm Password</label>
        <div class="password-container">
            <input type="password" name="confirm_password" id="confirm_password" required>
            <span class="password-toggle" onclick="togglePassword('confirm_password', this)">👁️</span>
        </div>

                <!-- Google Login Button -->
                <div style="margin: 18px 0; text-align: center;">
                        <a href="/auth/google-login" class="btn btn-google" style="display:inline-block;padding:10px 10px;background:#4285F4;color:#fff;border-radius:5px;text-decoration:none;font-weight:500;">
                            <img src="https://developers.google.com/identity/images/g-logo.png" style="height:20px;vertical-align:middle;margin-right:8px;"> Sign up with Google
                        </a>
                </div>



        <button type="submit" class="btn">📝 Create Account</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="/login">Login here</a>
    </div>
</div>

<script>
function togglePassword(inputId, toggleElement) {
    const passwordInput = document.getElementById(inputId);
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Change icon based on state
    toggleElement.textContent = type === 'password' ? '👁️' : '🙈';
}
</script>

</body>
=======
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - CraftsHub Admin</title>
<style>
body { 
    font-family: "Poppins", sans-serif; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 0;
    margin: 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.signup-container { 
    background: #fff; 
    padding: 40px; 
    border-radius: 15px; 
    max-width: 400px; 
    width: 100%;
    margin: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
}
.logo { text-align: center; margin-bottom: 30px; }
.logo h1 { color: #667eea; margin: 0; font-size: 2.5em; }
.logo p { color: #666; margin: 5px 0 0 0; }
label { display: block; margin-top: 15px; color: #333; font-weight: 500; }
input { 
    width: 100%; 
    padding: 12px; 
    margin-top: 5px; 
    border: 1px solid #ddd; 
    border-radius: 8px; 
    box-sizing: border-box;
    font-size: 16px;
}
input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
.btn { 
    width: 100%;
    margin-top: 20px; 
    padding: 12px; 
    border: none; 
    border-radius: 8px; 
    background: #667eea; 
    color: white; 
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s;
}
.btn:hover { background: #5a67d8; transform: translateY(-1px); }
.login-link { text-align: center; margin-top: 20px; }
.login-link a { color: #667eea; text-decoration: none; }
.login-link a:hover { text-decoration: underline; }
.alert { 
    padding: 12px; 
    border-radius: 8px; 
    margin-bottom: 20px; 
    text-align: center;
}
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

/* Password Toggle Styles */
.password-container {
    position: relative;
    display: flex;
    align-items: center;
}
.password-container input {
    padding-right: 45px;
    margin: 0;
}
.password-toggle {
    position: absolute;
    right: 15px;
    cursor: pointer;
    user-select: none;
    font-size: 18px;
    opacity: 0.7;
    transition: opacity 0.3s;
}
.password-toggle:hover {
    opacity: 1;
}
</style>
</head>
<body>
<div class="signup-container">
    <div class="logo">
        <h1>🎨 CraftsHub</h1>
        <p>Create Admin Account</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if(isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            ✅ <?= $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['error_message'])): ?>
        <div class="alert alert-error">
            ❌ <?= $_SESSION['error_message']; ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <form method="POST" action="/signup">
        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="tel" name="phone_number" required>

        <label>Password</label>
        <div class="password-container">
            <input type="password" name="password" id="signup_password" required>
            <span class="password-toggle" onclick="togglePassword('signup_password', this)">👁️</span>
        </div>

        <label>Confirm Password</label>
        <div class="password-container">
            <input type="password" name="confirm_password" id="confirm_password" required>
            <span class="password-toggle" onclick="togglePassword('confirm_password', this)">👁️</span>
        </div>

                <!-- Google Login Button -->
                <div style="margin: 18px 0; text-align: center;">
                        <a href="/auth/google-login" class="btn btn-google" style="display:inline-block;padding:10px 10px;background:#4285F4;color:#fff;border-radius:5px;text-decoration:none;font-weight:500;">
                            <img src="https://developers.google.com/identity/images/g-logo.png" style="height:20px;vertical-align:middle;margin-right:8px;"> Sign up with Google
                        </a>
                </div>



        <button type="submit" class="btn">📝 Create Account</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="/login">Login here</a>
    </div>
</div>

<script>
function togglePassword(inputId, toggleElement) {
    const passwordInput = document.getElementById(inputId);
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Change icon based on state
    toggleElement.textContent = type === 'password' ? '👁️' : '🙈';
}
</script>

</body>
>>>>>>> da170f7 (sure to?)
</html>