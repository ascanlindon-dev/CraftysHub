<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    body { display: flex; min-height: 100vh; background: #faf9f7; color: #2D2D2D; }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 20px 0;
      box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    }
    .sidebar h2 { text-align: center; margin-bottom: 30px; font-weight: 600; font-size: 1.5rem; }
    .sidebar ul { list-style: none; }
    .sidebar ul li { padding: 15px 20px; cursor: pointer; border-left: 3px solid transparent; transition: 0.3s; }
    .sidebar ul li:hover, .sidebar ul li.active { background: rgba(255,255,255,0.15); border-left-color: #fff; transform: translateX(5px); }
    .sidebar ul li a { color: #fff; text-decoration: none; display: flex; align-items: center; gap: 10px; }
    .logout-section { padding: 20px; border-top: 1px solid rgba(255,255,255,0.2); }
    .logout-btn { background: rgba(255,255,255,0.1); color: #fff; padding: 10px 20px; border: 1px solid rgba(255,255,255,0.2); border-radius: 5px; text-align: center; text-decoration: none; transition: 0.3s; }
    .logout-btn:hover { background: rgba(255,255,255,0.2); }

    /* Main Content */
    .main-content { flex: 1; padding: 20px; overflow-y: auto; }
    .header { background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%); color: #fff; padding: 20px 30px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 5px 15px rgba(217,150,125,0.4); }
    .header h1 { margin: 0; font-size: 2rem; font-weight: 600; }
    .header p { margin: 5px 0 0 0; opacity: 0.9; }

    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 20px;
    }
    .stat-card {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card.success { border-left: 4px solid #D9967D; }
    .stat-card.info { border-left: 4px solid #C88A6F; }
    .stat-card.warning { border-left: 4px solid #f39c12; }
    .stat-card.danger { border-left: 4px solid #e74c3c; }
    .stat-number { font-size: 2.5rem; font-weight: bold; margin-bottom: 10px; }
    .stat-label { color: #777; font-size: 1rem; font-weight: 500; }

    /* Responsive */
    @media (max-width: 768px) {
      .stats-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <h2>Admin Panel</h2>
      <ul>
        <li class="active"><a href="/admin/dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li><a href="/admin/products"><i class="fas fa-box"></i> Products</a></li>
        <li><a href="/admin/inventory"><i class="fas fa-list"></i> Inventory</a></li>
        <li><a href="/admin/orders"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="/admin/users"><i class="fas fa-users"></i> Users</a></li>
        <li><a href="/admin/revenue"><i class="fas fa-chart-bar"></i> Revenue</a></li>
      </ul>
    </div>
    <div class="logout-section">
      <a href="/admin/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <h1>Dashboard</h1>
      <p>Welcome back, Admin! Here's a quick overview of your system</p>
    </div>

    <!-- Top Row of Cards -->
    <div class="stats-grid">
      <div class="stat-card success">
        <div class="stat-number"><?= isset($total_users) ? number_format($total_users) : '0' ?></div>
        <div class="stat-label">Total Users</div>
      </div>
      <div class="stat-card info">
        <div class="stat-number"><?= isset($total_products) ? number_format($total_products) : '0' ?></div>
        <div class="stat-label">Total Products</div>
      </div>
      <div class="stat-card warning">
        <div class="stat-number"><?= isset($orders_today) ? number_format($orders_today) : '0' ?></div>
        <div class="stat-label">Orders Today</div>
      </div>
    </div>

    <!-- Bottom Row of Cards -->
    <div class="stats-grid">
      <div class="stat-card success">
        <div class="stat-number">₱<?= isset($today_revenue) ? $today_revenue : '0.00' ?></div>
        <div class="stat-label">Today's Revenue</div>
      </div>
      <div class="stat-card info">
        <div class="stat-number">₱<?= isset($monthly_revenue) ? $monthly_revenue : '0.00' ?></div>
        <div class="stat-label">Monthly Revenue</div>
      </div>
      <div class="stat-card danger">
        <div class="stat-number">₱<?= isset($revenue) ? $revenue : '0.00' ?></div>
        <div class="stat-label">Total Revenue</div>
      </div>
    </div>

  </div>

</body>
</html>
