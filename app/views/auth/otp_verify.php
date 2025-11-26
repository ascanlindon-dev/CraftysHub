<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OTP Verification - CraftsHub Admin</title>
<style>
body { font-family: "Poppins", sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
.otp-container { background: #fff; padding: 40px; border-radius: 15px; max-width: 400px; width: 100%; margin: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
.logo { text-align: center; margin-bottom: 30px; }
.logo h1 { color: #667eea; margin: 0; font-size: 2.5em; }
label { display: block; margin-top: 15px; color: #333; font-weight: 500; }
input { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 16px; }
input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
.btn { width: 100%; margin-top: 20px; padding: 12px; border: none; border-radius: 8px; background: #667eea; color: white; cursor: pointer; font-size: 16px; font-weight: 500; transition: all 0.3s; }
.btn:hover { background: #5a67d8; transform: translateY(-1px); }
.alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>
</head>
<body>
<div class="otp-container">
    <div class="logo">
        <h1>🔒 CraftsyHub</h1>
        <p>OTP Verification</p>
    </div>
    <?php if(isset($_SESSION['error_message'])): ?>
        <div class="alert alert-error">
            ❌ <?= $_SESSION['error_message']; ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    <form method="POST" action="/signup">
        <label>Enter the OTP sent to your email</label>
        <input type="text" name="otp" maxlength="6" required>
        <button type="submit" class="btn">Verify OTP</button>
    </form>
</div>
</body>
</html>
