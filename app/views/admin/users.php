<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users Dashboard</title>
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
.delete-btn { background:#e74c3c; }
.delete-btn:hover { background:#c0392b; transform:translateY(-1px); }
.btn-add { background:#3498db; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; margin-top:15px; }

/* ==== SUCCESS/ERROR MESSAGES ==== */
.message { padding:15px 20px; border-radius:8px; margin-bottom:20px; font-weight:500; }
.success-message { background:linear-gradient(135deg,#d4edda 0%,#c3e6cb 100%); border:1px solid #c3e6cb; color:#155724; }
.error-message { background:linear-gradient(135deg,#f8d7da 0%,#f5c6cb 100%); border:1px solid #f5c6cb; color:#721c24; }

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
      <li><a href="/admin/orders">🛒 Orders</a></li>
      <li class="active"><a href="/admin/users">👥 Users</a></li>
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
    <h1>👥 Users List</h1>
    <p>Manage all registered users efficiently</p>
  </div>

  <!-- Success/Error Messages -->
  <?php if(isset($_SESSION['success_message'])): ?>
      <div class="message success-message">
          ✅ <?= $_SESSION['success_message']; ?>
      </div>
      <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <?php if(isset($_SESSION['error_message'])): ?>
      <div class="message error-message">
          ❌ <?= $_SESSION['error_message']; ?>
      </div>
      <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Password</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($users)): ?>
          <?php foreach($users as $u): ?>
          <tr>
            <td><?= $u->buyer_id ?? '' ?></td>
            <td><?= htmlspecialchars($u->full_name ?? '') ?></td>
            <td><?= htmlspecialchars($u->email ?? '') ?></td>
            <td><?= htmlspecialchars($u->phone_number ?? '') ?></td>
            <td><?= htmlspecialchars($u->password ?? '') ?></td>
            <td><?= $u->created_at ?? '' ?></td>
            <td class="actions">
              <form action="/admin/users/delete" method="POST" style="display:inline-block;" 
                    onsubmit="return confirm('Are you sure you want to delete user: <?= htmlspecialchars($u->full_name) ?>?')">
                <input type="hidden" name="buyer_id" value="<?= $u->buyer_id ?>">
                <button type="submit" class="delete-btn">🗑️ Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" style="text-align:center;">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <button onclick="window.location.href='/admin/add_user'" class="btn-add">➕ Add User</button>
</div>

</body>
</html>
=======
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users Dashboard</title>
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
.delete-btn { background:#e74c3c; }
.delete-btn:hover { background:#c0392b; transform:translateY(-1px); }
.btn-add { background:#3498db; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; margin-top:15px; }

/* ==== SUCCESS/ERROR MESSAGES ==== */
.message { padding:15px 20px; border-radius:8px; margin-bottom:20px; font-weight:500; }
.success-message { background:linear-gradient(135deg,#d4edda 0%,#c3e6cb 100%); border:1px solid #c3e6cb; color:#155724; }
.error-message { background:linear-gradient(135deg,#f8d7da 0%,#f5c6cb 100%); border:1px solid #f5c6cb; color:#721c24; }

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
      <li><a href="/admin/orders">🛒 Orders</a></li>
      <li class="active"><a href="/admin/users">👥 Users</a></li>
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
    <h1>👥 Users List</h1>
    <p>Manage all registered users efficiently</p>
  </div>

  <!-- Success/Error Messages -->
  <?php if(isset($_SESSION['success_message'])): ?>
      <div class="message success-message">
          ✅ <?= $_SESSION['success_message']; ?>
      </div>
      <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <?php if(isset($_SESSION['error_message'])): ?>
      <div class="message error-message">
          ❌ <?= $_SESSION['error_message']; ?>
      </div>
      <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Password</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($users)): ?>
          <?php foreach($users as $u): ?>
          <tr>
            <td><?= $u->buyer_id ?? '' ?></td>
            <td><?= htmlspecialchars($u->full_name ?? '') ?></td>
            <td><?= htmlspecialchars($u->email ?? '') ?></td>
            <td><?= htmlspecialchars($u->phone_number ?? '') ?></td>
            <td><?= htmlspecialchars($u->password ?? '') ?></td>
            <td><?= $u->created_at ?? '' ?></td>
            <td class="actions">
              <form action="/admin/users/delete" method="POST" style="display:inline-block;" 
                    onsubmit="return confirm('Are you sure you want to delete user: <?= htmlspecialchars($u->full_name) ?>?')">
                <input type="hidden" name="buyer_id" value="<?= $u->buyer_id ?>">
                <button type="submit" class="delete-btn">🗑️ Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" style="text-align:center;">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <button onclick="window.location.href='/admin/add_user'" class="btn-add">➕ Add User</button>
</div>

</body>
</html>
>>>>>>> da170f7 (sure to?)
