<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Revenue Management - Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 20px 0;
      transition: all 0.3s ease;
      box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
      font-size: 1.5rem;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      padding: 15px 20px;
      cursor: pointer;
      transition: 0.3s;
      border-left: 3px solid transparent;
    }

    .sidebar ul li:hover {
      background: rgba(255,255,255,0.1);
      border-left-color: #fff;
      transform: translateX(5px);
    }

    .sidebar ul li.active {
      background: rgba(255,255,255,0.15);
      border-left-color: #fff;
    }

    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logout-section {
      padding: 20px;
      border-top: 1px solid rgba(255,255,255,0.2);
    }

    .logout-btn {
      background: rgba(255,255,255,0.1);
      color: #fff;
      padding: 10px 20px;
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: block;
      text-align: center;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background: rgba(255,255,255,0.2);
    }

    /* ==== MAIN CONTENT ==== */
    .main-content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }

    /* ==== HEADER ==== */
    .header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      padding: 20px 30px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 5px 15px rgba(102,126,234,0.4);
    }

    .header h1 {
      margin: 0;
      font-size: 2rem;
      font-weight: 600;
    }

    .header p {
      margin-top: 5px;
      opacity: 0.9;
    }

    /* ==== REVENUE STATS CARDS ==== */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s ease;
      border-left: 4px solid;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-card.success { border-color: #2ecc71; }
    .stat-card.info { border-color: #3498db; }
    .stat-card.warning { border-color: #f39c12; }
    .stat-card.danger { border-color: #e74c3c; }

    .stat-number {
      font-size: 2.5rem;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .stat-label {
      color: #7f8c8d;
      font-size: 1rem;
      font-weight: 500;
    }

    /* ==== ALERTS ==== */
    .alert {
      padding: 15px 20px;
      border-radius: 5px;
      margin-bottom: 20px;
      border-left: 4px solid;
    }

    .alert-success { background: #d5f4e6; color: #2ecc71; border-color: #2ecc71; }
    .alert-error { background: #f8d7da; color: #e74c3c; border-color: #e74c3c; }

    /* ==== TABLE ==== */
    .table-section {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      overflow: hidden;
      margin-bottom: 30px;
    }

    .section-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      padding: 15px 20px;
      font-weight: 600;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ecf0f1;
    }

    th {
      background: #f8f9fa;
      font-weight: 600;
      color: #2c3e50;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    tr:hover { background: #f8f9fa; }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      font-weight: 500;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
    }

    .btn-primary { background: #3498db; color: #fff; }
    .btn-primary:hover { background: #2980b9; transform: translateY(-2px); }

    .btn-success { background: #2ecc71; color: #fff; }
    .btn-success:hover { background: #27ae60; }

    /* ==== RESPONSIVE ==== */
    @media (max-width: 768px) {
      body { flex-direction: column; }
      .sidebar { width: 100%; height: auto; }
      .stats-grid { grid-template-columns: 1fr; }
      table { font-size: 0.9rem; }
      th, td { padding: 10px; }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <h2>CraftsHub Admin</h2>
      <ul>
        <li><a href="/admin/dashboard">📊 Dashboard</a></li>
        <li><a href="/admin/products">📦 Products</a></li>
        <li><a href="/admin/inventory">📋 Inventory</a></li>
        <li><a href="/admin/orders">🛒 Orders</a></li>
        <li><a href="/admin/users">👥 Users</a></li>
        
        <li class="active"><a href="/admin/revenue">💰 Revenue</a></li>
        <li><a href="/admin/settings">⚙️ Settings</a></li>
      </ul>
    </div>
    <div class="logout-section">
      <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
    </div>
  </div>

  <div class="main-content">
    <!-- Header -->
    <div class="header">
      <h1>💰 Revenue Management</h1>
      <p>Track daily, weekly, monthly, and total revenue</p>
    </div>

    <!-- Alerts -->
    <?php if(isset($_SESSION['success_message'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error_message'])): ?>
      <div class="alert alert-error"><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <!-- Revenue Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card success">
        <div class="stat-number">₱<?= isset($today_revenue) ? $today_revenue : '0.00' ?></div>
        <div class="stat-label">Today's Revenue</div>
      </div>
      <div class="stat-card info">
        <div class="stat-number">₱<?= isset($weekly_revenue) ? $weekly_revenue : '0.00' ?></div>
        <div class="stat-label">Weekly Revenue</div>
      </div>
      <div class="stat-card warning">
        <div class="stat-number">₱<?= isset($monthly_revenue) ? $monthly_revenue : '0.00' ?></div>
        <div class="stat-label">Monthly Revenue</div>
      </div>
      <div class="stat-card danger">
        <div class="stat-number">₱<?= isset($total_revenue) ? $total_revenue : '0.00' ?></div>
        <div class="stat-label">Total Revenue</div>
      </div>
    </div>

    <!-- Sync Section -->
    <div class="table-section">
      <div class="section-header">
        ⚡ Data Synchronization
      </div>
      <div style="padding: 20px;">
        <p>Sync revenue data from orders to keep your tracking up to date.</p>
        <a href="/admin/sync-revenue" class="btn btn-success">🔄 Sync Revenue Data</a>
        <a href="/admin/dashboard" class="btn btn-primary">← Back to Dashboard</a>
      </div>
    </div>

    <!-- Revenue Charts Section -->
    <div class="table-section">
      <div class="section-header">📈 Revenue Charts</div>
      <div style="padding: 30px; display: flex; flex-wrap: wrap; gap: 40px; justify-content: center;">
        <div style="flex:1; min-width:300px; max-width:500px;">
          <h3 style="text-align:center;">Daily Revenue (Bar)</h3>
          <canvas id="barChart" height="120"></canvas>
        </div>
        <div style="flex:1; min-width:300px; max-width:500px;">
          <h3 style="text-align:center;">Revenue Trend (Line)</h3>
          <canvas id="lineChart" height="120"></canvas>
        </div>
        <div style="flex:1; min-width:300px; max-width:400px;">
          <h3 style="text-align:center;">Revenue Breakdown (Pie)</h3>
          <canvas id="pieChart" height="120"></canvas>
        </div>
      </div>
    </div>

    <!-- Top Revenue Days Table -->
    <div class="table-section">
      <div class="section-header">🏆 Top Revenue Days</div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Revenue</th>
              <th>Orders</th>
              <th>Avg Order Value</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($top_days) && !empty($top_days)): ?>
              <?php foreach($top_days as $day): ?>
                <tr>
                  <td><?= date('M d, Y', strtotime($day->date)) ?></td>
                  <td>₱<?= number_format($day->daily_sales,2) ?></td>
                  <td><?= number_format($day->total_orders) ?></td>
                  <td>₱<?= number_format($day->average_order_value,2) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="text-align:center; color:#7f8c8d;">
                  No revenue data available. <a href="/admin/sync-revenue">Sync data</a> to see results.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<script>
// Chart.js Data from PHP
const chartLabels = <?= json_encode($chart_labels ?? []) ?>;
const chartData = <?= json_encode($chart_data ?? []) ?>;

// Bar Chart
new Chart(document.getElementById('barChart').getContext('2d'), {
  type: 'bar',
  data: {
    labels: chartLabels,
    datasets: [{
      label: 'Daily Revenue',
      data: chartData,
      backgroundColor: 'rgba(102,126,234,0.5)',
      borderColor: '#667eea',
      borderWidth: 2
    }]
  },
  options: {
    scales: { y: { beginAtZero: true, ticks: { callback: v => '₱' + v } } }
  }
});

// Line Chart
new Chart(document.getElementById('lineChart').getContext('2d'), {
  type: 'line',
  data: {
    labels: chartLabels,
    datasets: [{
      label: 'Revenue Trend',
      data: chartData,
      backgroundColor: 'rgba(102,126,234,0.2)',
      borderColor: '#764ba2',
      borderWidth: 3,
      pointBackgroundColor: '#667eea',
      pointRadius: 5,
      fill: true,
      tension: 0.3
    }]
  },
  options: {
    scales: { y: { beginAtZero: true, ticks: { callback: v => '₱' + v } } }
  }
});

// Pie Chart (breakdown: today, week, month, total)
const pieLabels = ['Today', 'Week', 'Month', 'Total'];
const pieData = [
  parseFloat(<?= json_encode($today_revenue ?? 0) ?>),
  parseFloat(<?= json_encode($weekly_revenue ?? 0) ?>),
  parseFloat(<?= json_encode($monthly_revenue ?? 0) ?>),
  parseFloat(<?= json_encode($total_revenue ?? 0) ?>)
];
new Chart(document.getElementById('pieChart').getContext('2d'), {
  type: 'pie',
  data: {
    labels: pieLabels,
    datasets: [{
      data: pieData,
      backgroundColor: [
        'rgba(46,204,113,0.7)',
        'rgba(52,152,219,0.7)',
        'rgba(241,196,15,0.7)',
        'rgba(231,76,60,0.7)'
      ],
      borderColor: '#fff',
      borderWidth: 2
    }]
  },
  options: {
    plugins: {
      legend: { position: 'bottom' }
    }
  }
});
</script>
</body>
</html>
=======
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Revenue Management - Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 20px 0;
      transition: all 0.3s ease;
      box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
      font-size: 1.5rem;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      padding: 15px 20px;
      cursor: pointer;
      transition: 0.3s;
      border-left: 3px solid transparent;
    }

    .sidebar ul li:hover {
      background: rgba(255,255,255,0.1);
      border-left-color: #fff;
      transform: translateX(5px);
    }

    .sidebar ul li.active {
      background: rgba(255,255,255,0.15);
      border-left-color: #fff;
    }

    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logout-section {
      padding: 20px;
      border-top: 1px solid rgba(255,255,255,0.2);
    }

    .logout-btn {
      background: rgba(255,255,255,0.1);
      color: #fff;
      padding: 10px 20px;
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: block;
      text-align: center;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background: rgba(255,255,255,0.2);
    }

    /* ==== MAIN CONTENT ==== */
    .main-content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }

    /* ==== HEADER ==== */
    .header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      padding: 20px 30px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 5px 15px rgba(102,126,234,0.4);
    }

    .header h1 {
      margin: 0;
      font-size: 2rem;
      font-weight: 600;
    }

    .header p {
      margin-top: 5px;
      opacity: 0.9;
    }

    /* ==== REVENUE STATS CARDS ==== */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s ease;
      border-left: 4px solid;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-card.success { border-color: #2ecc71; }
    .stat-card.info { border-color: #3498db; }
    .stat-card.warning { border-color: #f39c12; }
    .stat-card.danger { border-color: #e74c3c; }

    .stat-number {
      font-size: 2.5rem;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .stat-label {
      color: #7f8c8d;
      font-size: 1rem;
      font-weight: 500;
    }

    /* ==== ALERTS ==== */
    .alert {
      padding: 15px 20px;
      border-radius: 5px;
      margin-bottom: 20px;
      border-left: 4px solid;
    }

    .alert-success { background: #d5f4e6; color: #2ecc71; border-color: #2ecc71; }
    .alert-error { background: #f8d7da; color: #e74c3c; border-color: #e74c3c; }

    /* ==== TABLE ==== */
    .table-section {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      overflow: hidden;
      margin-bottom: 30px;
    }

    .section-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      padding: 15px 20px;
      font-weight: 600;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ecf0f1;
    }

    th {
      background: #f8f9fa;
      font-weight: 600;
      color: #2c3e50;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    tr:hover { background: #f8f9fa; }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      font-weight: 500;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
    }

    .btn-primary { background: #3498db; color: #fff; }
    .btn-primary:hover { background: #2980b9; transform: translateY(-2px); }

    .btn-success { background: #2ecc71; color: #fff; }
    .btn-success:hover { background: #27ae60; }

    /* ==== RESPONSIVE ==== */
    @media (max-width: 768px) {
      body { flex-direction: column; }
      .sidebar { width: 100%; height: auto; }
      .stats-grid { grid-template-columns: 1fr; }
      table { font-size: 0.9rem; }
      th, td { padding: 10px; }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <h2>CraftsHub Admin</h2>
      <ul>
        <li><a href="/admin/dashboard">📊 Dashboard</a></li>
        <li><a href="/admin/products">📦 Products</a></li>
        <li><a href="/admin/inventory">📋 Inventory</a></li>
        <li><a href="/admin/orders">🛒 Orders</a></li>
        <li><a href="/admin/users">👥 Users</a></li>
        
        <li class="active"><a href="/admin/revenue">💰 Revenue</a></li>
        <li><a href="/admin/settings">⚙️ Settings</a></li>
      </ul>
    </div>
    <div class="logout-section">
      <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
    </div>
  </div>

  <div class="main-content">
    <!-- Header -->
    <div class="header">
      <h1>💰 Revenue Management</h1>
      <p>Track daily, weekly, monthly, and total revenue</p>
    </div>

    <!-- Alerts -->
    <?php if(isset($_SESSION['success_message'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error_message'])): ?>
      <div class="alert alert-error"><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <!-- Revenue Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card success">
        <div class="stat-number">₱<?= isset($today_revenue) ? $today_revenue : '0.00' ?></div>
        <div class="stat-label">Today's Revenue</div>
      </div>
      <div class="stat-card info">
        <div class="stat-number">₱<?= isset($weekly_revenue) ? $weekly_revenue : '0.00' ?></div>
        <div class="stat-label">Weekly Revenue</div>
      </div>
      <div class="stat-card warning">
        <div class="stat-number">₱<?= isset($monthly_revenue) ? $monthly_revenue : '0.00' ?></div>
        <div class="stat-label">Monthly Revenue</div>
      </div>
      <div class="stat-card danger">
        <div class="stat-number">₱<?= isset($total_revenue) ? $total_revenue : '0.00' ?></div>
        <div class="stat-label">Total Revenue</div>
      </div>
    </div>

    <!-- Sync Section -->
    <div class="table-section">
      <div class="section-header">
        ⚡ Data Synchronization
      </div>
      <div style="padding: 20px;">
        <p>Sync revenue data from orders to keep your tracking up to date.</p>
        <a href="/admin/sync-revenue" class="btn btn-success">🔄 Sync Revenue Data</a>
        <a href="/admin/dashboard" class="btn btn-primary">← Back to Dashboard</a>
      </div>
    </div>

    <!-- Revenue Charts Section -->
    <div class="table-section">
      <div class="section-header">📈 Revenue Charts</div>
      <div style="padding: 30px; display: flex; flex-wrap: wrap; gap: 40px; justify-content: center;">
        <div style="flex:1; min-width:300px; max-width:500px;">
          <h3 style="text-align:center;">Daily Revenue (Bar)</h3>
          <canvas id="barChart" height="120"></canvas>
        </div>
        <div style="flex:1; min-width:300px; max-width:500px;">
          <h3 style="text-align:center;">Revenue Trend (Line)</h3>
          <canvas id="lineChart" height="120"></canvas>
        </div>
        <div style="flex:1; min-width:300px; max-width:400px;">
          <h3 style="text-align:center;">Revenue Breakdown (Pie)</h3>
          <canvas id="pieChart" height="120"></canvas>
        </div>
      </div>
    </div>

    <!-- Top Revenue Days Table -->
    <div class="table-section">
      <div class="section-header">🏆 Top Revenue Days</div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Revenue</th>
              <th>Orders</th>
              <th>Avg Order Value</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($top_days) && !empty($top_days)): ?>
              <?php foreach($top_days as $day): ?>
                <tr>
                  <td><?= date('M d, Y', strtotime($day->date)) ?></td>
                  <td>₱<?= number_format($day->daily_sales,2) ?></td>
                  <td><?= number_format($day->total_orders) ?></td>
                  <td>₱<?= number_format($day->average_order_value,2) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="text-align:center; color:#7f8c8d;">
                  No revenue data available. <a href="/admin/sync-revenue">Sync data</a> to see results.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<script>
// Chart.js Data from PHP
const chartLabels = <?= json_encode($chart_labels ?? []) ?>;
const chartData = <?= json_encode($chart_data ?? []) ?>;

// Bar Chart
new Chart(document.getElementById('barChart').getContext('2d'), {
  type: 'bar',
  data: {
    labels: chartLabels,
    datasets: [{
      label: 'Daily Revenue',
      data: chartData,
      backgroundColor: 'rgba(102,126,234,0.5)',
      borderColor: '#667eea',
      borderWidth: 2
    }]
  },
  options: {
    scales: { y: { beginAtZero: true, ticks: { callback: v => '₱' + v } } }
  }
});

// Line Chart
new Chart(document.getElementById('lineChart').getContext('2d'), {
  type: 'line',
  data: {
    labels: chartLabels,
    datasets: [{
      label: 'Revenue Trend',
      data: chartData,
      backgroundColor: 'rgba(102,126,234,0.2)',
      borderColor: '#764ba2',
      borderWidth: 3,
      pointBackgroundColor: '#667eea',
      pointRadius: 5,
      fill: true,
      tension: 0.3
    }]
  },
  options: {
    scales: { y: { beginAtZero: true, ticks: { callback: v => '₱' + v } } }
  }
});

// Pie Chart (breakdown: today, week, month, total)
const pieLabels = ['Today', 'Week', 'Month', 'Total'];
const pieData = [
  parseFloat(<?= json_encode($today_revenue ?? 0) ?>),
  parseFloat(<?= json_encode($weekly_revenue ?? 0) ?>),
  parseFloat(<?= json_encode($monthly_revenue ?? 0) ?>),
  parseFloat(<?= json_encode($total_revenue ?? 0) ?>)
];
new Chart(document.getElementById('pieChart').getContext('2d'), {
  type: 'pie',
  data: {
    labels: pieLabels,
    datasets: [{
      data: pieData,
      backgroundColor: [
        'rgba(46,204,113,0.7)',
        'rgba(52,152,219,0.7)',
        'rgba(241,196,15,0.7)',
        'rgba(231,76,60,0.7)'
      ],
      borderColor: '#fff',
      borderWidth: 2
    }]
  },
  options: {
    plugins: {
      legend: { position: 'bottom' }
    }
  }
});
</script>
</body>
</html>
>>>>>>> da170f7 (sure to?)
