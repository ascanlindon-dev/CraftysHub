<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Settings</title>
  <style>
    /* ==== GLOBAL STYLES ==== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #f5f6fa;
      display: flex;
      height: 100vh;
      color: #333;
    }

    /* ==== SIDEBAR ==== */
    .sidebar {
      width: 240px;
      background: #1e1f26;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 20px 0;
      transition: all 0.3s ease;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      padding: 15px 20px;
      cursor: pointer;
      transition: 0.3s;
    }

    .sidebar ul li:hover,
    .sidebar ul li.active {
      background: #3498db;
    }

    .sidebar ul li i {
      margin-right: 10px;
    }

    .logout {
      text-align: center;
      padding: 15px 0;
      background: #e74c3c;
      cursor: pointer;
      font-weight: 500;
    }

    /* ==== MAIN CONTENT ==== */
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .topbar {
      background: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .topbar input {
      padding: 8px 12px;
      width: 250px;
      border: 1px solid #ccc;
      border-radius: 5px;
      outline: none;
    }

    .user {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      object-fit: cover;
    }

    .dashboard-content {
      padding: 30px;
      flex: 1;
      overflow-y: auto;
    }

    /* ==== SETTINGS SPECIFIC STYLES ==== */
    .settings-container {
      max-width: 900px;
    }

    .settings-section {
      background: #fff;
      border-radius: 10px;
      padding: 25px;
      margin-bottom: 20px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .settings-section h3 {
      font-size: 20px;
      margin-bottom: 20px;
      color: #2c3e50;
      border-bottom: 2px solid #3498db;
      padding-bottom: 10px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 14px;
      outline: none;
      transition: border 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: #3498db;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    .form-group-inline {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-group-inline input[type="checkbox"] {
      width: auto;
      margin: 0;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-primary {
      background: #3498db;
      color: #fff;
    }

    .btn-primary:hover {
      background: #2980b9;
    }

    .btn-danger {
      background: #e74c3c;
      color: #fff;
    }

    .btn-danger:hover {
      background: #c0392b;
    }

    .btn-success {
      background: #2ecc71;
      color: #fff;
    }

    .btn-success:hover {
      background: #27ae60;
    }

    .info-text {
      font-size: 12px;
      color: #7f8c8d;
      margin-top: 5px;
    }

    /* ==== PASSWORD TOGGLE STYLES ====
    .password-container {
      position: relative;
      display: flex;
      align-items: center;
    }
    .password-container input {
      padding-right: 45px;
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

    /* ==== RESPONSIVE ==== */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      .sidebar h2,
      .sidebar ul li span {
        display: none;
      }
      .sidebar ul li {
        text-align: center;
      }
    }
  </style>
</head>
<body>
  
  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <h2>Admin Panel</h2>
      <ul>
        <li>
          <a href="/admin/dashboard" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>📊</i><span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="/admin/products" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>📦</i><span>Products</span>
          </a>
        </li>
        <li>
          <a href="/admin/inventory" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>📋</i><span>Inventory</span>
          </a>
        </li>
        <li>
          <a href="/admin/users" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>👥</i><span>Users</span>
          </a>
        </li>
        <li>
          <a href="/admin/orders" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>🛒</i><span>Orders</span>
          </a>
        </li>
        <li>
          <a href="/admin/revenue" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>💰</i><span>Revenue</span>
          </a>
        </li>
        <li class="active">
          <a href="/admin/settings" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>⚙️</i><span>Settings</span>
          </a>
        </li>
      </ul>
    </div>
    <a href="/admin/logout" class="logout" style="color: inherit; text-decoration: none;">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="topbar">
      <h1>Settings</h1>
      <div class="user">
        <input type="text" placeholder="Search..." />
        <img src="https://imgs.search.brave.com/0ofFPm4oF8RbyafCjS3MO-EhyZWGHq2u_W3w7Ak6Jrc/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/ZnJlZS1wc2QvM2Qt/aWxsdXN0cmF0aW9u/LWh1bWFuLWF2YXRh/ci1wcm9maWxlXzIz/LTIxNTA2NzExMzQu/anBnP3NlbXQ9YWlz/X2h5YnJpZCZ3PTc0/MCZxPTgw" alt="User Avatar" />
      </div>
    </div>

    <div class="dashboard-content">
      <div class="settings-container">
        <h2>⚙️ System Settings</h2>
        <br>

        <!-- General Settings -->
        <div class="settings-section">
          <h3>General Settings</h3>
          <form method="POST" action="/admin/settings/update-general">
            <div class="form-group">
              <label for="site_name">Site Name</label>
              <input type="text" id="site_name" name="site_name" value="CraftysHub" placeholder="Enter site name">
            </div>
            <div class="form-group">
              <label for="site_email">Site Email</label>
              <input type="email" id="site_email" name="site_email" value="admin@craftyshub.com" placeholder="Enter site email">
            </div>
            <div class="form-group">
              <label for="site_description">Site Description</label>
              <textarea id="site_description" name="site_description" placeholder="Enter site description">Your premier destination for handcrafted items</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save General Settings</button>
          </form>
        </div>

        <!-- Email Settings -->
        <div class="settings-section">
          <h3>Email Configuration</h3>
          <form method="POST" action="/admin/settings/update-email">
            <div class="form-group">
              <label for="smtp_host">SMTP Host</label>
              <input type="text" id="smtp_host" name="smtp_host" placeholder="smtp.gmail.com">
            </div>
            <div class="form-group">
              <label for="smtp_port">SMTP Port</label>
              <input type="number" id="smtp_port" name="smtp_port" placeholder="587">
            </div>
            <div class="form-group">
              <label for="smtp_user">SMTP Username</label>
              <input type="text" id="smtp_user" name="smtp_user" placeholder="your-email@gmail.com">
            </div>
            <div class="form-group">
              <label for="smtp_pass">SMTP Password</label>
              <div class="password-container">
                <input type="password" id="smtp_pass" name="smtp_pass" placeholder="••••••••">
                <span class="password-toggle" onclick="togglePassword('smtp_pass', this)">👁️</span>
              </div>
              <p class="info-text">Your password is encrypted and stored securely</p>
            </div>
            <button type="submit" class="btn btn-primary">Save Email Settings</button>
          </form>
        </div>

        <!-- Security Settings -->
        <div class="settings-section">
          <h3>Security Settings</h3>
          <form method="POST" action="/admin/settings/update-security">
            <div class="form-group">
              <label for="session_timeout">Session Timeout (minutes)</label>
              <input type="number" id="session_timeout" name="session_timeout" value="30" min="5" max="1440">
              <p class="info-text">Users will be logged out after this period of inactivity</p>
            </div>
            <div class="form-group form-group-inline">
              <input type="checkbox" id="two_factor" name="two_factor">
              <label for="two_factor" style="margin: 0;">Enable Two-Factor Authentication</label>
            </div>
            <div class="form-group form-group-inline">
              <input type="checkbox" id="force_ssl" name="force_ssl" checked>
              <label for="force_ssl" style="margin: 0;">Force SSL/HTTPS</label>
            </div>
            <button type="submit" class="btn btn-primary">Save Security Settings</button>
          </form>
        </div>

        <!-- Maintenance Mode -->
        <div class="settings-section">
          <h3>Maintenance Mode</h3>
          <form method="POST" action="/admin/settings/maintenance">
            <div class="form-group form-group-inline">
              <input type="checkbox" id="maintenance_mode" name="maintenance_mode">
              <label for="maintenance_mode" style="margin: 0;">Enable Maintenance Mode</label>
            </div>
            <div class="form-group">
              <label for="maintenance_message">Maintenance Message</label>
              <textarea id="maintenance_message" name="maintenance_message" placeholder="Enter message to display to visitors">We're currently performing scheduled maintenance. We'll be back shortly!</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update Maintenance Settings</button>
          </form>
        </div>

        <!-- Danger Zone -->
        <div class="settings-section" style="border-left: 4px solid #e74c3c;">
          <h3 style="color: #e74c3c; border-bottom-color: #e74c3c;">⚠️ Danger Zone</h3>
          <div class="form-group">
            <label>Clear Cache</label>
            <p class="info-text">Remove all cached data to improve performance or fix issues</p>
            <button type="button" class="btn btn-danger" onclick="confirm('Are you sure you want to clear all cache?') && this.form.submit()">Clear All Cache</button>
          </div>
          <div class="form-group">
            <label>Reset Settings</label>
            <p class="info-text">Reset all settings to default values (cannot be undone)</p>
            <button type="button" class="btn btn-danger" onclick="confirm('This will reset all settings to defaults. Are you sure?')">Reset to Defaults</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script>
    // Add form submission handling
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Settings saved successfully!');
        // In production, you would submit via AJAX or allow form submission
      });
    });
  });

  // Password toggle function
  function togglePassword(inputId, toggleElement) {
    const passwordInput = document.getElementById(inputId);
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Change icon based on state
    toggleElement.textContent = type === 'password' ? '👁️' : '🙈';
  }
  </script>
</body>
</html>

