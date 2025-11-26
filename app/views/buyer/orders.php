<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Orders - CraftsHub</title>
<style>
/* Hamburger icon for sidebar toggle */
.sidebar-toggle-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    margin-right: 12px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 40px;
    width: 40px;
}
.sidebar-toggle-btn .bar {
    width: 26px;
    height: 3px;
    background: #fff;
    margin: 3px 0;
    border-radius: 2px;
    transition: 0.3s;
}
.sidebar-hidden {
    display: none !important;
}
* { margin: 0; padding: 0; box-sizing: border-box; }
body { 
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", sans-serif;
    background: #faf9f7;
    overflow-x: hidden;
}

/* Header */
.header {
    background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
}
.logo { font-size: 1.8em; font-weight: bold; }
.user-info { display: flex; align-items: center; gap: 15px; }
.logout-btn, .back-btn {
    background: rgba(255,255,255,0.2);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    margin-left: 10px;
}
.logout-btn:hover, .back-btn:hover { 
    background: rgba(255,255,255,0.3); 
    color: white;
}

/* Sidebar */
.sidebar {
    position: fixed;
    left: 0;
    top: 80px;
    width: 250px;
    height: calc(100vh - 80px);
    background: white;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    padding: 20px 0;
    z-index: 100;
}

.sidebar-title {
    padding: 0 20px 15px;
    font-size: 1.1em;
    font-weight: 600;
    color: #2D2D2D;
    border-bottom: 1px solid #f0ede8;
    margin-bottom: 15px;
}

.sidebar-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 25px;
    color: #333;
    text-decoration: none;
    transition: all 0.3s;
    border-left: 3px solid transparent;
    font-size: 1.08em;
}

.sidebar-icon {
    background: #fff;
    color: #D9967D;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4em;
    box-shadow: 0 2px 6px rgba(0,0,0,0.07);
    border: 2px solid #E8D4C8;
    transition: box-shadow 0.2s;
}

.sidebar-item:hover .sidebar-icon,
.sidebar-item.active .sidebar-icon {
    box-shadow: 0 4px 12px rgba(217, 150, 125, 0.2);
    color: #fff;
    background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
    border-color: #D9967D;
}

/* Mobile menu toggle */
.menu-toggle {
    display: none;
    background: rgba(255,255,255,0.2);
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
}

/* Main Content */
.main-content {
    margin-left: 250px;
    padding: 30px;
    min-height: calc(100vh - 80px);
    margin-top: 80px; /* Height of header */
}

.page-header {
    margin-bottom: 30px;
}
.page-title {
    font-size: 2.5em;
    color: #2D2D2D;
    font-weight: 600;
}

/* Orders */
.order-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
    border-bottom: 2px solid #f0ede8;
    overflow-x: auto;
}

.order-tab {
    padding: 12px 20px;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    color: #777;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
}

.order-tab:hover {
    color: #D9967D;
    background: rgba(217, 150, 125, 0.05);
}

.order-tab.active {
    color: #D9967D;
    border-bottom-color: #D9967D;
    font-weight: 600;
}

.order-tab .count {
    background: #E8D4C8;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.85em;
    margin-left: 5px;
    color: #2D2D2D;
}

.order-tab.active .count {
    background: #D9967D;
    color: white;
}

.order-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s;
}
.order-card:hover {
    transform: translateY(-2px);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0ede8;
}
.order-id {
    font-size: 1.3em;
    font-weight: 600;
    color: #2D2D2D;
}
.order-date {
    color: #777;
    font-size: 0.95em;
}

.order-status {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9em;
    font-weight: 500;
    text-transform: uppercase;
}
.status-pending {
    background: #fef3c7;
    color: #92400e;
}
.status-processing {
    background: #dbeafe;
    color: #1e40af;
}
.status-shipped {
    background: #dcfce7;
    color: #166534;
}
.status-delivered {
    background: #cffafe;
    color: #164e63;
}
.status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

.order-items {
    margin-bottom: 20px;
}
.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f5f0eb;
}
.item-info {
    flex: 1;
}
.item-name {
    font-weight: 500;
    color: #2D2D2D;
}
.item-details {
    color: #777;
    font-size: 0.9em;
}
.item-price {
    font-weight: 600;
    color: #D9967D;
}

.order-summary {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #f0ede8;
}
.order-total {
    font-size: 1.2em;
    font-weight: 600;
    color: #2D2D2D;
}
.order-actions {
    display: flex;
    gap: 10px;
}
.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-size: 0.9em;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}
.btn-primary {
    background: #D9967D;
    color: white;
}
.btn-primary:hover {
    background: #C88A6F;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(200, 138, 111, 0.2);
}
.btn-outline {
    background: transparent;
    color: #D9967D;
    border: 1px solid #D9967D;
}
.btn-outline:hover {
    background: #D9967D;
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #777;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}
.empty-state .icon {
    font-size: 4em;
    margin-bottom: 20px;
    opacity: 0.5;
}
.empty-state .btn {
    margin-top: 20px;
    padding: 12px 24px;
    background: #D9967D;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    display: inline-block;
    transition: all 0.3s;
}
.empty-state .btn:hover {
    background: #C88A6F;
    color: white;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    animation: fadeIn 0.3s;
}

.modal-content {
    background-color: white;
    margin: 2% auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.modal-header {
    background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
    color: white;
    padding: 20px 30px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.5em;
    font-weight: 600;
}

.close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.3s;
}

.close:hover {
    background: rgba(255,255,255,0.3);
}

.modal-body {
    padding: 30px;
}

.order-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

.info-card {
    background: #faf9f7;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #D9967D;
}

.info-label {
    font-weight: 600;
    color: #777;
    font-size: 0.9em;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.info-value {
    font-size: 1.1em;
    color: #2D2D2D;
    font-weight: 500;
}

.products-section {
    margin-top: 30px;
}

.section-title {
    font-size: 1.3em;
    font-weight: 600;
    color: #2D2D2D;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0ede8;
}

.product-item {
    display: flex;
    align-items: center;
    padding: 15px;
    background: white;
    border: 1px solid #f0ede8;
    border-radius: 10px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.product-image {
    width: 80px;
    height: 80px;
    background: linear-gradient(45deg, #D9967D, #C88A6F);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5em;
    margin-right: 20px;
    flex-shrink: 0;
}

.product-details {
    flex: 1;
}

.product-name {
    font-size: 1.1em;
    font-weight: 600;
    color: #2D2D2D;
    margin-bottom: 5px;
}

.product-description {
    color: #777;
    font-size: 0.9em;
    margin-bottom: 8px;
    line-height: 1.4;
}

.product-meta {
    display: flex;
    gap: 20px;
    font-size: 0.9em;
}

.product-quantity {
    color: #777;
}

.product-price {
    color: #D9967D;
    font-weight: 600;
}

.product-total {
    font-size: 1.1em;
    font-weight: 600;
    color: #28a745;
    text-align: right;
    min-width: 100px;
}

/* Account Dropdown */
    .account-dropdown {
        position: relative;
        display: inline-block;
    }
    .account-logo {
        background: #fff !important;
        color: #2D2D2D !important;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2em;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        border: 2px solid #E8D4C8;
        transition: box-shadow 0.2s;
    }
    .account-logo:hover {
        box-shadow: 0 4px 12px rgba(217,150,125,0.15);
    }
    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 50px;
        background: white;
        min-width: 180px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        border-radius: 10px;
        z-index: 200;
        overflow: hidden;
    }
    .dropdown-item {
        display: block;
        padding: 15px 20px;
        color: #2D2D2D;
        text-decoration: none;
        transition: background 0.2s;
    }
    .dropdown-item:hover {
        background: #faf9f7;
        color: #D9967D;
    }


@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Responsive */
@media (max-width: 768px) {
    .menu-toggle { display: block; }
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    .sidebar.active {
        transform: translateX(0);
    }
    .main-content { 
        margin-left: 0;
        padding: 20px; 
        margin-top: 80px; /* Height of header */
    }
    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    .order-summary {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    /* Modal responsive */
    .modal-content {
        width: 95%;
        margin: 5% auto;
    }
    
    .modal-header {
        padding: 15px 20px;
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .order-info-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .product-item {
        flex-direction: column;
        text-align: center;
    }
    
    .product-image {
        margin-right: 0;
        margin-bottom: 15px;
    }
    
    .product-meta {
        justify-content: center;
        gap: 15px;
    }
}
</style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <!-- Sidebar Toggle Button (Hamburger) at far left -->
            <button class="sidebar-toggle-btn" id="sidebarToggleBtn" onclick="toggleSidebarVisibility()" title="Toggle Quick Actions">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            <div class="logo">CraftsHub - My Orders</div>
        </div>
        <div class="user-info">
                <span>Welcome, <?= htmlspecialchars($buyer_name) ?>!</span>
                <div class="account-dropdown">
                    <span class="account-logo" onclick="toggleAccountMenu()">A</span>
                    <div class="dropdown-menu" id="accountMenu">
                        <a href="/buyer/account-settings" class="dropdown-item">Account Settings</a>
                        <a href="/buyer/customer-service" class="dropdown-item">Customer Service</a>
                        <a href="/buyer/logout" class="dropdown-item">Logout</a>
                    </div>
                </div>
        </div>
        <script>
    function toggleAccountMenu() {
        var menu = document.getElementById('accountMenu');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
    // Hide dropdown when clicking outside
    document.addEventListener('click', function(event) {
        var menu = document.getElementById('accountMenu');
        var logo = document.querySelector('.account-logo');
        if (!menu || !logo) return;
        if (!menu.contains(event.target) && !logo.contains(event.target)) {
            menu.style.display = 'none';
        }
    });
    </script>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
                
        <h3 class="sidebar-title"><i class="fas fa-bolt" style="color:#D9967D; margin-right:8px;"></i> Quick Actions</h3>
        <a href="/buyer/dashboard" class="sidebar-item"><span class="sidebar-icon"><i class="fas fa-home"></i></span> Dashboard</a>
        <a href="/buyer/cart" class="sidebar-item"><span class="sidebar-icon"><i class="fas fa-shopping-cart"></i></span> View Cart</a>
        <a href="/buyer/orders" class="sidebar-item active"><span class="sidebar-icon"><i class="fas fa-box"></i></span> View My Orders</a>
        <!--a href="#" class="sidebar-item">� Update Profile</a-->

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title"><i class="fas fa-box" style="color:#D9967D; margin-right:8px;"></i> My Orders</h1>
        </div>

        <!-- Order Category Tabs -->
        <div class="order-tabs">
            <button class="order-tab active" onclick="filterOrders('all')" id="tab-all">
                All Orders <span class="count" id="count-all"><?= count($orders ?? []) ?></span>
            </button>
            <button class="order-tab" onclick="filterOrders('pending')" id="tab-pending">
                ⏳ Pending <span class="count" id="count-pending">0</span>
            </button>
            <button class="order-tab" onclick="filterOrders('processing')" id="tab-processing">
                <i class="fas fa-sync-alt" style="margin-right:8px;color:#C88A6F;"></i> Processing <span class="count" id="count-processing">0</span>
            </button>
            <button class="order-tab" onclick="filterOrders('shipped')" id="tab-shipped">
                Shipped <span class="count" id="count-shipped">0</span>
            </button>
            <button class="order-tab" onclick="filterOrders('delivered')" id="tab-delivered">
                Delivered <span class="count" id="count-delivered">0</span>
            </button>
            <button class="order-tab" onclick="filterOrders('cancelled')" id="tab-cancelled">
                Cancelled <span class="count" id="count-cancelled">0</span>
            </button>
        </div>
        
        <?php if(!empty($orders)): ?>
            <?php foreach($orders as $order): ?>
                <?php
                $buyer_status = strtolower($order->status ?? 'pending');
                if ($buyer_status === 'completed') {
                    $buyer_status = 'delivered';
                }
                ?>
                <div class="order-card" data-status="<?= $buyer_status ?>">
                    <div class="order-header">
                        <div>
                            <div class="order-id">Order #<?= $order->order_number ?? $order->id ?></div>
                            <div class="order-date">Placed on <?= date('F j, Y', strtotime($order->order_date ?? 'now')) ?></div>
                        </div>
                        <div class="order-status status-<?= strtolower($order->status ?? 'pending') ?>">
                            <?= ucfirst($order->status ?? 'Pending') ?>
                        </div>
                    </div>
                    
                    <div class="order-items">
                        <?php if (!empty($order->items)): ?>
                            <?php foreach ($order->items as $item): ?>
                                <div class="order-item">
                                    <div class="item-info">
                                        <div class="item-name"><?= htmlspecialchars($item->product_name ?? 'Product') ?></div>
                                        <div class="item-details">Quantity: <?= $item->quantity ?? 1 ?> × ₱<?= number_format($item->unit_price ?? 0, 2) ?></div>
                                    </div>
                                    <div class="item-price">₱<?= number_format($item->total_price ?? 0, 2) ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="order-item">
                                <div class="item-info">
                                    <div class="item-name">No items found</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="order-summary">
                        <div class="order-total">Total: ₱<?= number_format($order->grand_total ?? 0, 2) ?></div>
                        <div class="order-actions">
                            <button class="btn btn-outline" onclick="viewOrderDetails(<?= $order->id ?>, '<?= htmlspecialchars($order->order_number ?? $order->id) ?>', '<?= htmlspecialchars($order->status ?? 'pending') ?>', '<?= $order->order_date ?? 'now' ?>', <?= $order->grand_total ?? 0 ?>, '<?= htmlspecialchars($order->shipping_address ?? '') ?>', '<?= htmlspecialchars($order->payment_method ?? '') ?>', '<?= htmlspecialchars($order->payment_status ?? '') ?>')">View Details</button>
                            <?php if(strtolower($order->status ?? 'pending') === 'delivered'): ?>
                                <a href="#" class="btn btn-primary">Review</a>
                            <?php elseif(strtolower($order->status ?? 'pending') === 'pending'): ?>
                                <button class="btn btn-outline" onclick="cancelOrder(<?= $order->id ?>, '<?= htmlspecialchars($order->order_number ?? $order->id) ?>')">Cancel</button>
                            <?php endif; ?>
                        </div>
                            <!-- Cancel Order Popup Overlay (rendered ONCE per page) -->
                            <div id="cancelOrderOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:transparent; z-index:9999;">
                                <div id="cancelOrderPopup" style="position:absolute; left:50%; top:15%; transform:translate(-50%,0); background:#fff; padding:32px; border-radius:10px; max-width:350px; width:90vw; box-shadow:0 4px 24px rgba(0,0,0,0.18); display:flex; flex-direction:column; align-items:center;">
                                    <span onclick="closeCancelOrderOverlay()" style="position:absolute; top:10px; right:16px; cursor:pointer; font-size:24px;">&times;</span>
                                    <h3 style="margin-bottom:18px;">Cancel Order</h3>
                                    <form id="cancelOrderForm" onsubmit="submitCancelOrderForm(event)">
                                        <input type="hidden" id="cancelOrderId" name="order_id">
                                        <div style="margin-bottom:18px; width:100%;">
                                            <label for="cancelReason" style="font-weight:500;">Reason:</label>
                                            <select id="cancelReason" name="reason" style="width:100%; margin-top:8px; padding:6px; border-radius:4px;">
                                                <option value="Changed mind">Changed my mind</option>
                                                <option value="Found better price">Found a better price</option>
                                                <option value="Ordered by mistake">Ordered by mistake</option>
                                                <option value="Other">Other (please specify below)</option>
                                            </select>
                                            <textarea id="cancelOtherReason" name="other_reason" placeholder="Other reason..." style="width:100%; margin-top:8px; padding:6px; border-radius:4px; display:none;"></textarea>
                                        </div>
                                        <button type="submit" style="background:#dc3545; color:#fff; padding:8px 20px; border:none; border-radius:5px;">Confirm Cancel</button>
                                        <button type="button" onclick="closeCancelOrderOverlay()" style="margin-left:10px; background:#eee; color:#333; border:none; padding:8px 20px; border-radius:5px;">Cancel</button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="icon"><i class="fas fa-box" style="color:#D9967D;"></i></div>
                <h3>No orders yet</h3>
                <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
                <a href="/buyer/dashboard" class="btn"><i class="fas fa-store" style="margin-right:8px;color:#D9967D;"></i> Start Shopping</a>
            </div>
                                                <tr>
                                                    <td colspan="7" style="text-align:center; padding: 40px; color: #7f8c8d;">
                                                        <strong>No orders found</strong><br>
                                                        <small>Add your first order to start</small>
                                                    </td>
                                                </tr>
        <?php endif; ?>
    </div>

    <!-- Order Details Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Order Details</h2>
                <button class="close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="order-info-grid">
                    <div class="info-card">
                        <div class="info-label">Order Number</div>
                        <div class="info-value" id="modalOrderNumber">-</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Order Status</div>
                        <div class="info-value" id="modalOrderStatus">-</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Order Date</div>
                        <div class="info-value" id="modalOrderDate">-</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Total Amount</div>
                        <div class="info-value" id="modalOrderTotal">-</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Shipping Address</div>
                        <div class="info-value" id="modalShippingAddress">-</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Payment Method</div>
                        <div class="info-value" id="modalPaymentMethod">-</div>
                    </div>
                </div>

                <div class="products-section">
                    <h3 class="section-title"><i class="fas fa-box" style="color:#D9967D; margin-right:8px;"></i> Order Items</h3>
                    <div id="modalOrderItems">
                        <div style="text-align: center; padding: 20px; color: #6c757d;">
                            Loading order items...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Sidebar hide/unhide toggle
                function toggleSidebarVisibility() {
                    const sidebar = document.getElementById('sidebar');
                    sidebar.classList.toggle('sidebar-hidden');
                }

                // Optional: Hide sidebar by default on mobile
                document.addEventListener('DOMContentLoaded', function() {
                    if (window.innerWidth <= 768) {
                        document.getElementById('sidebar').classList.add('sidebar-hidden');
                    }
                });
                
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const menuToggle = document.querySelector('.menu-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuToggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Modal functionality
        function viewOrderDetails(orderId, orderNumber, status, orderDate, grandTotal, shippingAddress, paymentMethod, paymentStatus) {
            // Set basic order info
            document.getElementById('modalTitle').textContent = `Order Details - #${orderNumber}`;
            document.getElementById('modalOrderNumber').textContent = orderNumber;
            document.getElementById('modalOrderStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
            document.getElementById('modalOrderDate').textContent = new Date(orderDate).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalOrderTotal').textContent = `₱${parseFloat(grandTotal).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
            document.getElementById('modalShippingAddress').textContent = shippingAddress || 'Not provided';
            document.getElementById('modalPaymentMethod').textContent = paymentMethod || 'Not specified';

            // Load order items via AJAX
            loadOrderItems(orderId);

            // Show modal
            document.getElementById('orderModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function loadOrderItems(orderId) {
            const itemsContainer = document.getElementById('modalOrderItems');
            itemsContainer.innerHTML = '<div style="text-align: center; padding: 20px; color: #6c757d;">Loading order items...</div>';

            // Create a form to fetch order items
            const form = new FormData();
            form.append('order_id', orderId);

            fetch('/buyer/get-order-items', {
                method: 'POST',
                body: form
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.items && data.items.length > 0) {
                    let itemsHtml = '';
                    let subtotal = 0;

                    data.items.forEach(item => {
                        const itemTotal = parseFloat(item.total_price || (item.unit_price * item.quantity));
                        subtotal += itemTotal;

                        itemsHtml += `
                            <div class="product-item">
                                <div class="product-image">
                                    ${item.product_image ? `<img src="${item.product_image}" alt="${item.product_name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">` : '<i class="fas fa-image" style="font-size:36px;color:#D9967D;"></i>'}
                                </div>
                                <div class="product-details">
                                    <div class="product-name">${item.product_name || 'Unknown Product'}</div>
                                    <div class="product-description">${item.product_description || 'No description available'}</div>
                                    <div class="product-meta">
                                        <div class="product-quantity">Quantity: ${item.quantity}</div>
                                        <div class="product-price">Unit Price: ₱${parseFloat(item.unit_price).toFixed(2)}</div>
                                    </div>
                                </div>
                                <div class="product-total">₱${itemTotal.toFixed(2)}</div>
                            </div>
                        `;
                    });

                    // Add subtotal
                    itemsHtml += `
                        <div style="border-top: 2px solid #e9ecef; padding-top: 15px; margin-top: 15px; text-align: right;">
                            <div style="font-size: 1.2em; font-weight: 600; color: #333;">
                                Subtotal: ₱${subtotal.toFixed(2)}
                            </div>
                        </div>
                    `;

                    itemsContainer.innerHTML = itemsHtml;
                } else {
                    itemsContainer.innerHTML = `
                        <div style="text-align: center; padding: 40px; color: #6c757d;">
                            <div style="font-size: 2em; margin-bottom: 15px;"><i class="fas fa-box" style="color:#D9967D;"></i></div>
                            <div>No items found for this order</div>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading order items:', error);
                itemsContainer.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #dc3545;">
                        <div style="font-size: 2em; margin-bottom: 15px;"><i class="fas fa-exclamation-triangle" style="color:#f39c12;"></i></div>
                        <div>Failed to load order items</div>
                        <div style="font-size: 0.9em; margin-top: 10px;">Please try again later</div>
                    </div>
                `;
            });
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Close modal with escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Cancel order popup logic
        function cancelOrder(orderId, orderNumber) {
            // Set order id in hidden input
            document.getElementById('cancelOrderId').value = orderId;
            // Reset reason fields
            document.getElementById('cancelReason').value = 'Changed mind';
            document.getElementById('cancelOtherReason').style.display = 'none';
            document.getElementById('cancelOtherReason').value = '';
            // Show overlay
            document.getElementById('cancelOrderOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeCancelOrderOverlay() {
            document.getElementById('cancelOrderOverlay').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Show/hide other reason textarea
        document.addEventListener('DOMContentLoaded', function() {
            var reasonSelect = document.getElementById('cancelReason');
            var otherReason = document.getElementById('cancelOtherReason');
            reasonSelect.addEventListener('change', function() {
                if (this.value === 'Other') {
                    otherReason.style.display = 'block';
                } else {
                    otherReason.style.display = 'none';
                    otherReason.value = '';
                }
            });
        });

        // Handle cancel order form submit
        function submitCancelOrderForm(event) {
            event.preventDefault();
            var orderId = document.getElementById('cancelOrderId').value;
            var reason = document.getElementById('cancelReason').value;
            var otherReason = document.getElementById('cancelOtherReason').value;

            // Optionally validate
            if (reason === 'Other' && otherReason.trim() === '') {
                alert('Please specify your reason for cancellation.');
                return;
            }

            // Submit via POST
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/buyer/cancel-order';

            var orderIdInput = document.createElement('input');
            orderIdInput.type = 'hidden';
            orderIdInput.name = 'order_id';
            orderIdInput.value = orderId;
            form.appendChild(orderIdInput);

            var reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'reason';
            reasonInput.value = reason;
            form.appendChild(reasonInput);

            if (reason === 'Other') {
                var otherReasonInput = document.createElement('input');
                otherReasonInput.type = 'hidden';
                otherReasonInput.name = 'other_reason';
                otherReasonInput.value = otherReason;
                form.appendChild(otherReasonInput);
            }

            document.body.appendChild(form);
            form.submit();
        }

        // Filter orders by status
        let currentFilter = 'all';

        function filterOrders(status) {
            currentFilter = status;
            
            // Update active tab
            document.querySelectorAll('.order-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById('tab-' + status).classList.add('active');
            
            // Filter order cards
            const orderCards = document.querySelectorAll('.order-card');
            let visibleCount = 0;
            
            orderCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (status === 'all' || cardStatus === status) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show/hide empty message
            updateEmptyMessage(visibleCount);
        }

        function updateEmptyMessage(visibleCount) {
            let emptyMsg = document.getElementById('empty-orders-message');
            
            if (visibleCount === 0) {
                if (!emptyMsg) {
                    emptyMsg = document.createElement('div');
                    emptyMsg.id = 'empty-orders-message';
                    emptyMsg.style.cssText = 'text-align: center; padding: 60px 20px; background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08);';
                    emptyMsg.innerHTML = `
                        <div style="font-size: 4em; margin-bottom: 20px;"><i class="fas fa-box" style="color:#D9967D;"></i></div>
                        <h3 style="color: #666; margin-bottom: 10px;">No orders found</h3>
                        <p style="color: #999;">No ${currentFilter === 'all' ? '' : currentFilter} orders at the moment.</p>
                    `;
                    document.querySelector('.main-content').appendChild(emptyMsg);
                }
                emptyMsg.style.display = 'block';
            } else {
                if (emptyMsg) {
                    emptyMsg.style.display = 'none';
                }
            }
        }

        // Count orders by status
        function countOrdersByStatus() {
            const orderCards = document.querySelectorAll('.order-card');
            const counts = {
                all: orderCards.length,
                pending: 0,
                processing: 0,
                shipped: 0,
                delivered: 0,
                cancelled: 0
            };
            
            orderCards.forEach(card => {
                const status = card.getAttribute('data-status');
                if (counts.hasOwnProperty(status)) {
                    counts[status]++;
                }
            });
            
            // Update count badges
            Object.keys(counts).forEach(status => {
                const countElement = document.getElementById('count-' + status);
                if (countElement) {
                    countElement.textContent = counts[status];
                }
            });
        }

        // Initialize counts on page load
        document.addEventListener('DOMContentLoaded', function() {
            countOrdersByStatus();
        });
    </script>
</body>
</html>