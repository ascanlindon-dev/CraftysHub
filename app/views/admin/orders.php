
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orders Dashboard</title>
<style>
/* ==== GLOBAL ==== */
* { margin:0; padding:0; box-sizing:border-box; font-family:"Poppins",sans-serif; }
body { display:flex; min-height:100vh; background:#f5f6fa; color:#333; }

/* ==== SIDEBAR ==== */
.sidebar {
  width:240px; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
  color:#fff; display:flex; flex-direction:column; justify-content:space-between; padding:20px 0;
}
.sidebar h2 { text-align:center; margin-bottom:30px; font-weight:600; font-size:1.5rem; }
.sidebar ul { list-style:none; }
.sidebar ul li { padding:15px 20px; cursor:pointer; border-left:3px solid transparent; transition:0.3s; }
.sidebar ul li:hover, .sidebar ul li.active { background:rgba(255,255,255,0.15); border-left-color:#fff; transform:translateX(5px); }
.sidebar ul li a { color:#fff; text-decoration:none; display:flex; align-items:center; gap:10px; }
.logout-section { padding:20px; border-top:1px solid rgba(255,255,255,0.2); }
.logout-btn { background:rgba(255,255,255,0.1); color:#fff; padding:10px 20px; border:1px solid rgba(255,255,255,0.2); border-radius:5px; text-align:center; text-decoration:none; transition:0.3s; }
.logout-btn:hover { background:rgba(255,255,255,0.2); }

/* ==== MAIN CONTENT ==== */
.main-content { flex:1; padding:20px; overflow-y:auto; }
.header { background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:#fff; padding:20px 30px; border-radius:10px; margin-bottom:30px; box-shadow:0 5px 15px rgba(102,126,234,0.4); }
.header h1 { margin:0; font-size:2rem; font-weight:600; }
.header p { margin:5px 0 0 0; opacity:0.9; }

/* ==== TABLE STYLE ==== */
.table-container { background:#fff; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); overflow-x:auto; }
table { width:100%; border-collapse:collapse; }
th, td { padding:15px; text-align:left; border-bottom:1px solid #ecf0f1; }
th { background:#3498db; color:#fff; font-weight:600; position:sticky; top:0; z-index:10; }
tr:hover { background:#f8f9fa; }
.actions button, .actions a {
  padding:5px 10px; border:none; border-radius:4px; cursor:pointer; color:#fff; margin-right:5px; text-decoration:none; display:inline-block;
}
.view-btn { background:#2980b9; }
.view-btn:hover { background:#1f5e8a; }
.btn-add { background:#3498db; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; margin-top:15px; }

/* ==== RESPONSIVE ==== */
@media (max-width:768px){
  .sidebar { width:70px; }
  .sidebar h2, .sidebar ul li span { display:none; }
  .sidebar ul li { text-align:center; }
  th, td { padding:10px; font-size:0.9rem; }
  .actions button, .actions a { padding:4px 6px; font-size:0.8rem; }
  .main-content { padding:15px; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div>
    <h2>Admin Panel</h2>
    <ul>
      <li><a href="/admin/dashboard">📊 Dashboard</a></li>
      <li><a href="/admin/products">📦 Products</a></li>
      <li><a href="/admin/inventory">📋 Inventory</a></li>
      <li class="active"><a href="/admin/orders">🛒 Orders</a></li>
      <li><a href="/admin/users">👥 Users</a></li>
      <li><a href="/admin/revenue">💰 Revenue</a></li>
      <li><a href="/admin/settings">⚙️ Settings</a></li>
    </ul>
  </div>
  <div class="logout-section">
    <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
  </div>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <h1>📦 Orders List</h1>
    <p>Manage all customer orders efficiently</p>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Order Number</th>
          <th>Buyer ID</th>
          <th>Status</th>
          <th>Grand Total</th>
          <th>Address</th>
          <th>Payment Method</th>
          <th>Payment Status</th>
          <th>Order Date</th>
          <th>Notes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($orders)): ?>
          <?php foreach($orders as $o): ?>
          <tr>
            <td><?= $o->order_id ?? '' ?></td>
            <td><?= htmlspecialchars($o->order_number ?? '') ?></td>
            <td><?= $o->buyer_id ?? '' ?></td>
            <td><?= htmlspecialchars($o->status ?? '') ?></td>
            <td>₱<?= number_format($o->grand_total ?? 0, 2) ?></td>
            <td><?= htmlspecialchars($o->shipping_address ?? '') ?></td>
            <td><?= htmlspecialchars($o->payment_method ?? '') ?></td>
            <td><?= htmlspecialchars($o->payment_status ?? '') ?></td>
            <td><?= $o->order_date ?? '' ?></td>
            <td><?= htmlspecialchars($o->order_notes ?? '') ?></td>
            <td class="actions">
              <a href="/admin/orders/view/<?= $o->id ?>" class="view-btn">👁️ View</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="18" style="text-align:center;">No orders found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <button onclick="window.location.href='/admin/add_order'" class="btn-add">➕ Add Order</button>
</div>

</body>
</html>

