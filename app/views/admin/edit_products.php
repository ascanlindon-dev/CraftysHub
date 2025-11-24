<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Product</title>
<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: #f5f6fa;
      display: flex;
      min-height: 100vh;
    }

    /* ==== SIDEBAR ==== */
    .sidebar {
      width: 260px;
      background: #1e1f26;
      color: white;
      position: fixed;
      height: 100vh;
      transition: all 0.3s;
      z-index: 100;
    }

    .sidebar h2 {
      text-align: center;
      padding: 20px 0;
      font-size: 22px;
      font-weight: 600;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      margin-bottom: 30px;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      margin: 10px 0;
      transition: all 0.3s;
    }

    .sidebar ul li:hover {
      background: #2a2b35;
      transform: translateX(5px);
    }

    .sidebar ul li.active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-left: 4px solid #fff;
    }

    .sidebar ul li a {
      display: flex;
      align-items: center;
      padding: 15px 20px;
      color: white;
      text-decoration: none;
      transition: all 0.3s;
    }

    .sidebar ul li i {
      margin-right: 15px;
      font-size: 18px;
    }

    .sidebar ul li span {
      font-weight: 500;
      font-size: 14px;
    }

    /* ==== MAIN CONTENT ==== */
    .main-content {
      margin-left: 260px;
      flex: 1;
      background: #f5f6fa;
    }

    .dashboard-content {
      padding: 30px;
    }

    .container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      max-width: 700px;
      margin: 0 auto;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    h2 {
      font-size: 28px;
      color: #2c3e50;
      margin-bottom: 30px;
      font-weight: 600;
    }

    label {
      display: block;
      margin-top: 20px;
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
    }

    input, textarea {
      width: 100%;
      padding: 12px 15px;
      margin-top: 5px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      transition: border 0.3s;
    }

    input:focus, textarea:focus {
      border-color: #667eea;
      outline: none;
    }

    input:required, textarea:required {
      border-left: 3px solid #e74c3c;
    }

    textarea {
      min-height: 100px;
      resize: vertical;
    }

    button {
      margin-top: 25px;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      margin-right: 10px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-cancel {
      background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
      color: white;
    }

    .btn-cancel:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(149, 165, 166, 0.4);
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
      .main-content {
        margin-left: 70px;
      }
      .dashboard-content {
        padding: 15px;
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
            <i>🏠</i><span>Dashboard</span>
          </a>
        </li>
        <li class="active">
          <a href="/admin/products" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>🛍️</i><span>Products</span>
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
            <i>📦</i><span>Orders</span>
          </a>
        </li>
        <li>
          <a href="/admin/revenue" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>💰</i><span>Revenue</span>
          </a>
        </li>
        <li>
          <a href="/admin/settings" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>⚙️</i><span>Settings</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="dashboard-content">
      <div class="container">
        <h2>✏️ Edit Product</h2>
    <form method="POST" action="/admin/update_product">
        <input type="hidden" name="product_id" value="<?= $product->product_id ?>">

        <label>Product Name</label>
        <input type="text" name="product_name" value="<?= htmlspecialchars($product->product_name ?? '') ?>" required>

        <label>Description</label>
        <textarea name="description" required><?= htmlspecialchars($product->description ?? '') ?></textarea>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?= $product->price ?? 0 ?>" required>

        <label>Stock</label>
        <input type="number" name="stock" value="<?= $product->stock ?? 0 ?>" required>

        <label>Image URL</label>
        <input type="text" name="image_url" value="<?= htmlspecialchars($product->image_url ?? '') ?>">

        <button type="submit" class="btn-primary">💾 Save Changes</button>
        <button type="button" onclick="window.location.href='/admin/products'" class="btn-cancel">⬅️ Cancel</button>
    </form>
      </div>
    </div>
  </div>
</body>
</html>
=======
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Product</title>
<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: #f5f6fa;
      display: flex;
      min-height: 100vh;
    }

    /* ==== SIDEBAR ==== */
    .sidebar {
      width: 260px;
      background: #1e1f26;
      color: white;
      position: fixed;
      height: 100vh;
      transition: all 0.3s;
      z-index: 100;
    }

    .sidebar h2 {
      text-align: center;
      padding: 20px 0;
      font-size: 22px;
      font-weight: 600;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      margin-bottom: 30px;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      margin: 10px 0;
      transition: all 0.3s;
    }

    .sidebar ul li:hover {
      background: #2a2b35;
      transform: translateX(5px);
    }

    .sidebar ul li.active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-left: 4px solid #fff;
    }

    .sidebar ul li a {
      display: flex;
      align-items: center;
      padding: 15px 20px;
      color: white;
      text-decoration: none;
      transition: all 0.3s;
    }

    .sidebar ul li i {
      margin-right: 15px;
      font-size: 18px;
    }

    .sidebar ul li span {
      font-weight: 500;
      font-size: 14px;
    }

    /* ==== MAIN CONTENT ==== */
    .main-content {
      margin-left: 260px;
      flex: 1;
      background: #f5f6fa;
    }

    .dashboard-content {
      padding: 30px;
    }

    .container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      max-width: 700px;
      margin: 0 auto;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    h2 {
      font-size: 28px;
      color: #2c3e50;
      margin-bottom: 30px;
      font-weight: 600;
    }

    label {
      display: block;
      margin-top: 20px;
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
    }

    input, textarea {
      width: 100%;
      padding: 12px 15px;
      margin-top: 5px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      transition: border 0.3s;
    }

    input:focus, textarea:focus {
      border-color: #667eea;
      outline: none;
    }

    input:required, textarea:required {
      border-left: 3px solid #e74c3c;
    }

    textarea {
      min-height: 100px;
      resize: vertical;
    }

    button {
      margin-top: 25px;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      margin-right: 10px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-cancel {
      background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
      color: white;
    }

    .btn-cancel:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(149, 165, 166, 0.4);
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
      .main-content {
        margin-left: 70px;
      }
      .dashboard-content {
        padding: 15px;
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
            <i>🏠</i><span>Dashboard</span>
          </a>
        </li>
        <li class="active">
          <a href="/admin/products" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>🛍️</i><span>Products</span>
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
            <i>📦</i><span>Orders</span>
          </a>
        </li>
        <li>
          <a href="/admin/revenue" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>💰</i><span>Revenue</span>
          </a>
        </li>
        <li>
          <a href="/admin/settings" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <i>⚙️</i><span>Settings</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="dashboard-content">
      <div class="container">
        <h2>✏️ Edit Product</h2>
    <form method="POST" action="/admin/update_product">
        <input type="hidden" name="product_id" value="<?= $product->product_id ?>">

        <label>Product Name</label>
        <input type="text" name="product_name" value="<?= htmlspecialchars($product->product_name ?? '') ?>" required>

        <label>Description</label>
        <textarea name="description" required><?= htmlspecialchars($product->description ?? '') ?></textarea>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?= $product->price ?? 0 ?>" required>

        <label>Stock</label>
        <input type="number" name="stock" value="<?= $product->stock ?? 0 ?>" required>

        <label>Image URL</label>
        <input type="text" name="image_url" value="<?= htmlspecialchars($product->image_url ?? '') ?>">

        <button type="submit" class="btn-primary">💾 Save Changes</button>
        <button type="button" onclick="window.location.href='/admin/products'" class="btn-cancel">⬅️ Cancel</button>
    </form>
      </div>
    </div>
  </div>
</body>
</html>
>>>>>>> da170f7 (sure to?)
