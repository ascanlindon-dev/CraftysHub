<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ==== GLOBAL ==== */
* { margin: 0; padding: 0; box-sizing: border-box; font-family: "Poppins", sans-serif; }
body { display: flex; min-height: 100vh; background: #f9f9f9; color: #333; }

/* ==== SIDEBAR ==== */
.sidebar {
  width: 240px; background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
  color: #fff; display: flex; flex-direction: column; justify-content: space-between; padding: 20px 0; box-shadow: 2px 0 15px rgba(0, 0, 0, 0.08);
  transition: width 0.3s ease;
}
.sidebar:hover { width: 260px; }
.sidebar h2 { text-align: center; margin-bottom: 30px; font-weight: 600; font-size: 1.5rem; }
.sidebar ul { list-style: none; }
.sidebar ul li { padding: 15px 20px; cursor: pointer; border-left: 3px solid transparent; transition: 0.3s; }
.sidebar ul li:hover, .sidebar ul li.active { background: rgba(255, 255, 255, 0.15); border-left-color: #fff; transform: translateX(5px); }
.sidebar ul li a { color: #fff; text-decoration: none; display: flex; align-items: center; gap: 10px; }
.logout-section { padding: 20px; border-top: 1px solid rgba(255, 255, 255, 0.2); }
.logout-btn { background: rgba(255, 255, 255, 0.1); color: #fff; padding: 10px 20px; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 5px; text-align: center; text-decoration: none; transition: 0.3s; }
.logout-btn:hover { background: rgba(255, 255, 255, 0.2); }

/* ==== MAIN CONTENT ==== */
.main-content { flex: 1; padding: 20px; overflow-y: auto; }
.header { background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%); color: #fff; padding: 20px 30px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 5px 15px rgba(217, 150, 125, 0.35); }
.header h1 { margin: 0; font-size: 2rem; font-weight: 600; display: flex; align-items: center; gap: 10px; }
.header p { margin: 5px 0 0 0; opacity: 0.9; }

/* ==== TABLE STYLE ==== */
.table-container { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ecf0f1; }
th { background: #D9967D; color: #fff; font-weight: 600; position: sticky; top: 0; z-index: 10; }
tr:nth-child(even) { background: #f8f9fa; }
tr:hover { background: #f1f1f1; }
.actions button, .actions a {
  padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; color: #fff; margin-right: 5px; text-decoration: none; display: inline-block;
}
.delete-btn { background: #e74c3c; }
.delete-btn:hover { background: #c0392b; transform: translateY(-1px); }
.btn-add { background: linear-gradient(135deg, #C88A6F, #D9967D); color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 15px; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.2s ease; }
.btn-add:hover { transform: scale(1.05); }

/* ==== SUCCESS/ERROR MESSAGES ==== */
.message { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; }
.success-message { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
.error-message { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }

/* ==== RESPONSIVE ==== */
@media (max-width: 768px) {
  .sidebar { width: 70px; }
  .sidebar h2, .sidebar ul li span { display: none; }
  .sidebar ul li { text-align: center; }
  th, td { padding: 10px; font-size: 0.9rem; }
  .actions button, .actions a { padding: 4px 6px; font-size: 0.8rem; }
  .main-content { padding: 15px; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div>
    <h2>Admin Panel</h2>
    <ul>
      <li><a href="/admin/dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
      <li><a href="/admin/products"><i class="fas fa-box"></i> Products</a></li>
      <li><a href="/admin/inventory"><i class="fas fa-list"></i> Inventory</a></li>
      <li><a href="/admin/orders"><i class="fas fa-shopping-cart"></i> Orders</a></li>
      <li class="active"><a href="/admin/users"><i class="fas fa-users"></i> Users</a></li>
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
  <div class="header">
    <h1><i class="fas fa-users"></i> Users List</h1>
    <p>Manage all registered users efficiently</p>
  </div>

  <!-- Success/Error Messages -->
  <?php if(isset($_SESSION['success_message'])): ?>
    <div class="message success-message"><i class="fas fa-check-circle"></i> <?= $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <?php if(isset($_SESSION['error_message'])): ?>
    <div class="message error-message"><i class="fas fa-times-circle"></i> <?= $_SESSION['error_message']; ?></div>
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
                <button type="submit" class="delete-btn"><i class="fas fa-trash"></i> Delete</button>
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

  <button onclick="window.location.href='/admin/add_user'" class="btn-add"><i class="fas fa-plus"></i> Add User</button>
</div>

</body>
</html>
