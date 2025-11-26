<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventory Management - Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* ==== GLOBAL STYLES ==== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    body {
      background-color: #faf9f7;
      display: flex;
      height: 100vh;
      color: #2D2D2D;
    }

    /* ==== SIDEBAR ==== */
    .sidebar {
      width: 240px;
      background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 20px 0;
      transition: all 0.3s ease;
      box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
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
      background: rgba(255, 255, 255, 0.1);
      border-left-color: #fff;
      transform: translateX(5px);
    }

    .sidebar ul li.active {
      background: rgba(255, 255, 255, 0.15);
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
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .logout-btn {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      padding: 10px 20px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: block;
      text-align: center;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    /* ==== MAIN CONTENT ==== */
    .main-content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }

    .header {
      background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
      color: #fff;
      padding: 20px 30px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 5px 15px rgba(217, 150, 125, 0.4);
    }

    .header h1 {
      margin: 0;
      font-size: 2rem;
      font-weight: 600;
    }

    .header p {
      margin: 5px 0 0 0;
      opacity: 0.9;
    }

    /* ==== INVENTORY STATS ==== */
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
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-card.warning {
      border-left: 4px solid #D9967D;
    }

    .stat-card.success {
      border-left: 4px solid #C88A6F;
    }

    .stat-card.info {
      border-left: 4px solid #E8D4C8;
    }

    .stat-card.danger {
      border-left: 4px solid #e74c3c;
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: bold;
      color: #2D2D2D;
      margin-bottom: 10px;
    }

    .stat-label {
      color: #777;
      font-size: 1rem;
      font-weight: 500;
    }

    /* ==== INVENTORY TABLE ==== */
    .inventory-section {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-bottom: 20px;
    }

    .section-header {
      background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
      color: #fff;
      padding: 20px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .section-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin: 0;
    }

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

    .btn-primary {
      background: #D9967D;
      color: #fff;
    }

    .btn-primary:hover {
      background: #C88A6F;
      transform: translateY(-2px);
    }

    .btn-success {
      background: #2ecc71;
      color: #fff;
    }

    .btn-success:hover {
      background: #27ae60;
    }

    .btn-warning {
      background: #f39c12;
      color: #fff;
    }

    .btn-warning:hover {
      background: #e67e22;
    }

    .btn-sm {
      padding: 5px 10px;
      font-size: 0.8rem;
    }

    /* ==== TABLE STYLES ==== */
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
      background: #faf9f7;
      font-weight: 600;
      color: #2D2D2D;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    tr:hover {
      background: #faf9f7;
    }

    .stock-badge {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .stock-high {
      background: #d5f4e6;
      color: #2ecc71;
    }

    .stock-medium {
      background: #fff3cd;
      color: #f39c12;
    }

    .stock-low {
      background: #f8d7da;
      color: #e74c3c;
    }

    .stock-out {
      background: #f5c6cb;
      color: #721c24;
    }

    /* ==== QUICK UPDATE FORM ==== */
    .quick-update {
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .quick-update input {
      width: 60px;
      padding: 5px;
      border: 1px solid #E8D4C8;
      border-radius: 3px;
      text-align: center;
    }

    .quick-update button {
      padding: 5px 8px;
      background: #D9967D;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      font-size: 0.8rem;
    }

    .quick-update button:hover {
      background: #C88A6F;
    }

    /* ==== ALERTS ==== */
    .alert {
      padding: 15px 20px;
      border-radius: 5px;
      margin-bottom: 20px;
      border-left: 4px solid;
    }

    .alert-success {
      background: #E8D4C8;
      color: #D9967D;
      border-color: #D9967D;
    }

    .alert-error {
      background: #f8d7da;
      color: #e74c3c;
      border-color: #e74c3c;
    }

    .alert-warning {
      background: #fff3cd;
      color: #f39c12;
      border-color: #f39c12;
    }

    /* ==== RESPONSIVE ==== */
    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }
      
      .sidebar {
        width: 100%;
        height: auto;
      }
      
      .stats-grid {
        grid-template-columns: 1fr;
      }
      
      .section-header {
        flex-direction: column;
        gap: 15px;
      }
      
      table {
        font-size: 0.9rem;
      }
      
      th, td {
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <h2>CraftsHub Admin</h2>
      <ul>
        <li><a href="/admin/dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li><a href="/admin/products"><i class="fas fa-box"></i> Products</a></li>
        <li class="active"><a href="/admin/inventory"><i class="fas fa-list"></i> Inventory</a></li>
        <li><a href="/admin/orders"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="/admin/users"><i class="fas fa-users"></i> Users</a></li>
        <li><a href="/admin/revenue"><i class="fas fa-chart-bar"></i> Revenue</a></li>
        <li><a href="/admin/settings"><i class="fas fa-cog"></i> Settings</a></li>
      </ul>
    </div>
    <div class="logout-section">
      <a href="/admin/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header">
      <h1>Inventory Management</h1>
      <p>Monitor stock levels, track inventory, and manage product availability</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success_message']) ?>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
      <div class="alert alert-error">
        <i class="fas fa-times-circle"></i> <?= htmlspecialchars($_SESSION['error_message']) ?>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Inventory Statistics -->
    <div class="stats-grid">
      <div class="stat-card success">
        <div class="stat-number"><?= $total_products ?? 0 ?></div>
        <div class="stat-label">Total Products</div>
      </div>
      <div class="stat-card info">
        <div class="stat-number"><?= $total_stock ?? 0 ?></div>
        <div class="stat-label">Total Stock Units</div>
      </div>
      <div class="stat-card warning">
        <div class="stat-number"><?= $low_stock_count ?? 0 ?></div>
        <div class="stat-label">Low Stock Items</div>
      </div>
      <div class="stat-card danger">
        <div class="stat-number"><?= $out_of_stock_count ?? 0 ?></div>
        <div class="stat-label">Out of Stock</div>
      </div>
    </div>

    <!-- Low Stock Alerts -->
      <?php if (!empty($low_stock_products)): ?>
      <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> <strong>Low Stock Alert:</strong> You have <?= count($low_stock_products) ?> products with low stock levels that need attention.
      </div>
    <?php endif; ?>

    <!-- Inventory Table -->
    <div class="inventory-section">
          <div class="section-header">
        <h2 class="section-title">Product Inventory</h2>
        <div>
          <button onclick="refreshInventory()" class="btn btn-success"><i class="fas fa-sync-alt"></i> Refresh</button>
        </div>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Current Stock</th>
              <th>Stock Status</th>
              <th>Price</th>
              <th>Last Updated</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($products)): ?>
              <?php foreach ($products as $product): ?>
                <tr>
                  <td>#<?= htmlspecialchars($product->product_id) ?></td>
                  <td>
                    <strong><?= htmlspecialchars($product->product_name) ?></strong>
                    <?php if (!empty($product->description)): ?>
                      <br><small style="color: #7f8c8d;"><?= htmlspecialchars(substr($product->description, 0, 50)) ?><?= strlen($product->description) > 50 ? '...' : '' ?></small>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span style="font-size: 1.2rem; font-weight: bold;"><?= $product->stock ?></span>
                  </td>
                  <td>
                    <?php
                    $stock_class = 'stock-high';
                    $stock_text = 'In Stock';
                    
                    if ($product->stock == 0) {
                        $stock_class = 'stock-out';
                        $stock_text = 'Out of Stock';
                    } elseif ($product->stock <= 5) {
                        $stock_class = 'stock-low';
                        $stock_text = 'Low Stock';
                    } elseif ($product->stock <= 20) {
                        $stock_class = 'stock-medium';
                        $stock_text = 'Medium Stock';
                    }
                    ?>
                    <span class="stock-badge <?= $stock_class ?>"><?= $stock_text ?></span>
                  </td>
                  <td>₱<?= number_format($product->price, 2) ?></td>
                  <td><?= isset($product->updated_at) ? date('M j, Y', strtotime($product->updated_at)) : 'N/A' ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" style="text-align: center; padding: 40px; color: #7f8c8d;">
                  <strong>No products found</strong><br>
                  <small>Add your first product to start managing inventory</small>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Low Stock Products Section -->
    <?php if (!empty($low_stock_products)): ?>
      <div class="inventory-section">
        <div class="section-header">
          <h2 class="section-title"><i class="fas fa-exclamation-triangle"></i> Low Stock Products</h2>
          <span style="background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 15px; font-size: 0.9rem;">
            <?= count($low_stock_products) ?> items need attention
          </span>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Current Stock</th>
                <th>Recommended Reorder</th>
                <th>Quick Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($low_stock_products as $product): ?>
                <tr>
                  <td><strong><?= htmlspecialchars($product->product_name) ?></strong></td>
                  <td>
                    <span class="stock-badge stock-low"><?= $product->stock ?> units</span>
                  </td>
                  <td>
                    <span style="color: #2ecc71; font-weight: bold;">
                      <?= max(50, $product->stock * 3) ?> units
                    </span>
                  </td>
                  <td>
                    <form action="/admin/inventory/update-stock" method="POST" style="display: inline-flex; align-items: center; gap: 5px;">
                      <input type="hidden" name="product_id" value="<?= $product->product_id ?>">
                      <input type="number" name="new_stock" value="<?= max(50, $product->stock * 3) ?>" min="0" class="form-control" style="width: 80px;">
                      <button type="submit" class="btn btn-sm btn-success">Restock</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <script>
    function refreshInventory() {
      window.location.reload();
    }

    // Auto-refresh every 5 minutes
    setTimeout(function() {
      refreshInventory();
    }, 300000);

    // Form validation for stock updates
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        const stockInput = form.querySelector('input[name="new_stock"]');
        if (stockInput && (stockInput.value < 0 || stockInput.value === '')) {
          e.preventDefault();
          alert('Please enter a valid stock quantity (0 or greater)');
          stockInput.focus();
        }
      });
    });
  </script>
</body>
</html>