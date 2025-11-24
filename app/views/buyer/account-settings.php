
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Settings</title>
    <style>
        body { font-family: "Poppins", sans-serif; background: #f8f9fa; }
        .settings-container {
            max-width: 420px;
            margin: 50px auto;
            background: #fff;
            padding: 35px 30px 30px 30px;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(102,126,234,0.10);
            position: relative;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 10px;
            color: #667eea;
            background: #f8f9fa;
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            box-shadow: 0 2px 8px rgba(102,126,234,0.07);
        }
        .back-btn:hover {
            background: #e9ecef;
            color: #5a67d8;
        }
        h2 {
            text-align: center;
            color: #667eea;
            margin-bottom: 28px;
            font-size: 2em;
            letter-spacing: 1px;
        }
        .settings-form {
            margin-top: 10px;
        }
        .form-group {
            margin-bottom: 22px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
            width: 100%;
            padding: 13px 14px;
            border: 1.5px solid #e9ecef;
            border-radius: 9px;
            font-size: 1em;
            background: #f8f9fa;
            transition: border 0.2s;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="tel"]:focus {
            border-color: #667eea;
            background: #fff;
        }
        .save-btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(102,126,234,0.09);
        }
        .save-btn:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #764ba2 100%);
            box-shadow: 0 4px 16px rgba(102,126,234,0.13);
        }
        .msg {
            text-align: center;
            margin-bottom: 18px;
            color: #28a745;
            font-weight: 500;
            font-size: 1.08em;
        }
         body.darkmode { background: #181a1b; color: #e0e0e0; }
            .settings-container.darkmode { background: #23272a; box-shadow: 0 8px 32px rgba(40,40,40,0.25); }
            .back-btn.darkmode { background: #23272a; color: #e0e0e0; }
            .back-btn.darkmode:hover { background: #181a1b; color: #a3a3a3; }
            h2.darkmode { color: #e0e0e0; }
            label.darkmode { color: #e0e0e0; }
            input.darkmode, input.darkmode:focus { background: #23272a; color: #e0e0e0; border-color: #444; }
            .save-btn.darkmode { background: linear-gradient(135deg, #23272a 0%, #444 100%); color: #e0e0e0; }
            .save-btn.darkmode:hover { background: linear-gradient(135deg, #181a1b 0%, #444 100%); }
            .msg.darkmode { color: #28a745; }
    </style>
</head>
<body>
    <div class="settings-container">
                <div style="text-align:right; margin-bottom:10px;">
                    <label style="font-weight:500; color:#333; margin-right:8px;">🌙 Dark Mode</label>
                    <input type="checkbox" id="darkmode-toggle" style="transform:scale(1.3); vertical-align:middle;">
                </div>
           
        <a href="/buyer/dashboard" class="back-btn">← Back to Dashboard</a>
        <h2>Account Settings</h2>
        <?php if(isset($msg)) echo '<div class="msg">'.htmlspecialchars($msg).'</div>'; ?>
        <form method="post" action="" class="settings-form">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($buyer->full_name) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($buyer->email) ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password">
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?= htmlspecialchars($buyer->phone_number) ?>">
            </div>
            <button type="submit" class="save-btn">💾 Save Changes</button>
        </form>
    </div>
</body>
    <script>
    // Dark mode toggle logic
    const darkToggle = document.getElementById('darkmode-toggle');
    const body = document.body;
    const container = document.querySelector('.settings-container');
    const backBtn = document.querySelector('.back-btn');
    const h2 = document.querySelector('h2');
    const labels = document.querySelectorAll('label');
    const inputs = document.querySelectorAll('input');
    const saveBtn = document.querySelector('.save-btn');
    const msg = document.querySelector('.msg');

    // Load dark mode preference
    if(localStorage.getItem('darkmode') === 'true') {
        enableDarkMode();
        darkToggle.checked = true;
    }

    darkToggle.addEventListener('change', function() {
        if(this.checked) {
            enableDarkMode();
            localStorage.setItem('darkmode', 'true');
        } else {
            disableDarkMode();
            localStorage.setItem('darkmode', 'false');
        }
    });

    function enableDarkMode() {
        body.classList.add('darkmode');
        container.classList.add('darkmode');
        backBtn.classList.add('darkmode');
        h2.classList.add('darkmode');
        labels.forEach(l => l.classList.add('darkmode'));
        inputs.forEach(i => i.classList.add('darkmode'));
        saveBtn.classList.add('darkmode');
        if(msg) msg.classList.add('darkmode');
    }
    function disableDarkMode() {
        body.classList.remove('darkmode');
        container.classList.remove('darkmode');
        backBtn.classList.remove('darkmode');
        h2.classList.remove('darkmode');
        labels.forEach(l => l.classList.remove('darkmode'));
        inputs.forEach(i => i.classList.remove('darkmode'));
        saveBtn.classList.remove('darkmode');
        if(msg) msg.classList.remove('darkmode');
    }
    </script>
</html>

