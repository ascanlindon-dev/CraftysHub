<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", sans-serif;
            background: #faf9f7;
            padding: 20px;
            min-height: 100vh;
        }

        .settings-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            margin-bottom: 30px;
            color: #C88A6F;
            background: #fff9f7;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: 1px solid #E8D4C8;
        }

        .back-btn:hover {
            background: #f0ede8;
            color: #B8784D;
            border-color: #D9967D;
        }

        .back-btn span {
            margin-right: 6px;
            font-size: 16px;
        }

        .settings-header {
            margin-bottom: 40px;
            border-bottom: 2px solid #f5f0eb;
            padding-bottom: 24px;
        }

        .settings-header h2 {
            color: #2D2D2D;
            font-size: 1.8em;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .settings-header p {
            color: #777;
            font-size: 0.95em;
        }

        .settings-form {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2D2D2D;
            font-weight: 600;
            font-size: 0.92em;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #E8D4C8;
            border-radius: 6px;
            font-size: 15px;
            font-family: inherit;
            background: #faf9f7;
            transition: all 0.3s ease;
        }

        input[type="text"]:hover,
        input[type="email"]:hover,
        input[type="password"]:hover,
        input[type="tel"]:hover {
            border-color: #D9967D;
            background: #fff;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus {
            outline: none;
            border-color: #C88A6F;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(200, 138, 111, 0.1);
        }

        input::placeholder {
            color: #aaa;
        }

        .save-btn {
            width: 100%;
            margin-top: 8px;
            padding: 14px 16px;
            background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(200, 138, 111, 0.2);
        }

        .save-btn:hover {
            background: linear-gradient(135deg, #CE8A74 0%, #BD7E63 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(200, 138, 111, 0.3);
        }

        .save-btn:active {
            transform: translateY(0);
        }

        .msg {
            padding: 14px 16px;
            margin-bottom: 24px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            border-left: 4px solid #22c55e;
            background: #f0fdf4;
            color: #166534;
        }

        .msg.error {
            border-left-color: #ef4444;
            background: #fef2f2;
            color: #991b1b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .settings-container {
                padding: 30px 24px;
            }

            .settings-header h2 {
                font-size: 1.5em;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="tel"],
            .save-btn {
                padding: 12px 14px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .settings-container {
                padding: 24px 16px;
            }

            .settings-header {
                margin-bottom: 30px;
                padding-bottom: 20px;
            }

            .settings-header h2 {
                font-size: 1.3em;
            }

            .form-group {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="settings-container">
        <a href="/buyer/dashboard" class="back-btn"><i class="fas fa-arrow-left" style="margin-right:8px;"></i> Back to Dashboard</a>

        <div class="settings-header">
            <h2>Account Settings</h2>
            <p>Update your profile information and password</p>
        </div>

        <?php if(isset($msg)) echo '<div class="msg">'.htmlspecialchars($msg).'</div>'; ?>

        <form method="post" action="" class="settings-form">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($buyer->full_name) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($buyer->email) ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?= htmlspecialchars($buyer->phone_number) ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>

            <button type="submit" class="save-btn">Save Changes</button>
        </form>
    </div>
</body>
</html>
