
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Service - CraftsHub</title>
    <style>
        body { font-family: "Poppins", sans-serif; background: #f8f9fa; }
        .feedback-container {
            max-width: 600px;
            margin: 60px auto;
            background: #fff;
            padding: 50px 40px 40px 40px;
            border-radius: 22px;
            box-shadow: 0 12px 40px rgba(102,126,234,0.12);
        }
        h2 { text-align: center; color: #667eea; margin-bottom: 28px; font-size: 2em; letter-spacing: 1px; }
        .form-group { margin-bottom: 22px; }
            .form-group:last-of-type { margin-bottom: 32px; }
            input[type="file"] {
                padding: 10px 0 10px 0;
                background: #f8f9fa;
                border-radius: 9px;
                border: 1.5px solid #e9ecef;
                width: 100%;
                font-size: 1em;
            }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        input[type="text"], input[type="email"], textarea {
            width: 96%;
            padding: 20px 10px;
            border: 2px solid #e9ecef;
            border-radius: 14px;
            font-size: 1.18em;
            background: #f8f9fa;
            transition: border 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(102,126,234,0.09);
            margin-bottom: 2px;
            margin-left: 2%;
        }
        input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 2px 8px rgba(102,126,234,0.13);
        }
        textarea { min-height: 160px; resize: vertical; }
            .send-btn {
                width: 100%;
                padding: 13px;
                margin-top: 18px;
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
            .send-btn:hover {
                background: linear-gradient(135deg, #5a67d8 0%, #764ba2 100%);
                box-shadow: 0 4px 16px rgba(102,126,234,0.13);
            }
        .msg { text-align: center; margin-bottom: 18px; color: #28a745; font-weight: 500; font-size: 1.08em; }
        .back-btn { display: inline-block; margin-bottom: 10px; color: #667eea; background: #f8f9fa; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: background 0.2s, color 0.2s; box-shadow: 0 2px 8px rgba(102,126,234,0.07); }
        .back-btn:hover { background: #e9ecef; color: #5a67d8; }
    </style>
</head>
<body>
    <div class="feedback-container">
        <a href="/buyer/dashboard" class="back-btn">← Back to Dashboard</a>
        <h2>Customer Service</h2>
        <?php if(isset($msg)) echo '<div class="msg">'.htmlspecialchars($msg).'</div>'; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <div class="form-group">
                <label for="attachment">Attach a file (optional)</label>
                <input type="file" id="attachment" name="attachment" accept="image/*,application/pdf">
            </div>
            <button type="submit" class="send-btn">📧 Send Feedback</button>
        </form>
    </div>
</body>
</html>

