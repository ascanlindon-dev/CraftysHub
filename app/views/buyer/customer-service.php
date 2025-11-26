<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Service - CraftsHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", sans-serif;
            background: #faf9f7;
        }
        .feedback-container {
            max-width: 600px;
            margin: 60px auto;
            background: white;
            padding: 50px 40px 40px 40px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        h2 { 
            text-align: center; 
            color: #2D2D2D; 
            margin-bottom: 28px; 
            font-size: 2em; 
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .form-group { margin-bottom: 22px; }
        .form-group:last-of-type { margin-bottom: 32px; }
        input[type="file"] {
            padding: 10px 0 10px 0;
            background: #faf9f7;
            border-radius: 8px;
            border: 2px solid #E8D4C8;
            width: 100%;
            font-size: 1em;
            transition: border 0.3s, background 0.3s;
        }
        input[type="file"]:focus {
            border-color: #D9967D;
            background: white;
        }
        label { 
            display: block; 
            margin-bottom: 8px; 
            color: #2D2D2D; 
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 0.5px;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid #E8D4C8;
            border-radius: 8px;
            font-size: 1em;
            background: #faf9f7;
            transition: border 0.3s, box-shadow 0.3s, background 0.3s;
            margin-bottom: 0;
        }
        input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            outline: none;
            border-color: #D9967D;
            background: white;
            box-shadow: 0 0 0 3px rgba(217, 150, 125, 0.1);
        }
        textarea { 
            min-height: 160px; 
            resize: vertical;
            font-family: inherit;
        }
        .send-btn {
            width: 100%;
            padding: 14px;
            margin-top: 18px;
            background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(200, 138, 111, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .send-btn:hover {
            background: linear-gradient(135deg, #CE8A74 0%, #BD7E63 100%);
            box-shadow: 0 6px 16px rgba(200, 138, 111, 0.3);
            transform: translateY(-2px);
        }
        .msg { 
            text-align: center; 
            margin-bottom: 18px; 
            color: #166534; 
            font-weight: 600; 
            font-size: 1em;
            background: #f0fdf4;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #86efac;
        }
        .back-btn { 
            display: inline-block; 
            margin-bottom: 20px; 
            color: #D9967D; 
            background: white; 
            padding: 10px 20px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: 600;
            border: 2px solid #E8D4C8;
            transition: all 0.3s; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            font-size: 0.95em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .back-btn:hover { 
            background: #faf9f7; 
            color: #C88A6F;
            border-color: #D9967D;
            box-shadow: 0 4px 12px rgba(217, 150, 125, 0.15);
        }
    </style>
</head>
<body>
    <div class="feedback-container">
        <a href="/buyer/dashboard" class="back-btn"><i class="fas fa-arrow-left" style="margin-right:8px;"></i> Back to Dashboard</a>
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
            <button type="submit" class="send-btn">Send Feedback</button>
        </form>
    </div>
</body>
</html>
