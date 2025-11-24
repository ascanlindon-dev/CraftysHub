
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Cart - CraftsHub</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { 
    font-family: "Poppins", sans-serif; 
    background: #f8f9fa;
    overflow-x: hidden;
}

/* Header */
.header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
    color: #495057;
    border-bottom: 1px solid #dee2e6;
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
    color: #667eea;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4em;
    box-shadow: 0 2px 6px rgba(0,0,0,0.07);
    border: 2px solid #eee;
    transition: box-shadow 0.2s;
}

.sidebar-item:hover .sidebar-icon,
.sidebar-item.active .sidebar-icon {
    box-shadow: 0 4px 12px rgba(102,126,234,0.13);
    color: #fff;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
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
}

.page-header {
    margin-bottom: 30px;
}
.page-title {
    font-size: 2.5em;
    color: #333;
    font-weight: 600;
}

/* Alert Messages */
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Cart Items */
.cart-container {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.cart-items {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.cart-item {
    display: flex;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #eee;
}
.cart-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 80px;
    height: 80px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5em;
    margin-right: 20px;
    overflow: hidden;
}

.item-details {
    flex: 1;
}
.item-name {
    font-size: 1.2em;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}
.item-price {
    color: #667eea;
    font-weight: 500;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 20px;
}
.quantity-btn {
    width: 35px;
    height: 35px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}
.quantity-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}
.quantity-input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    padding: 8px;
    border-radius: 5px;
}

.item-total {
    font-size: 1.1em;
    font-weight: 600;
    color: #333;
    margin-right: 15px;
}

.remove-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s;
}
.remove-btn:hover {
    background: #c82333;
}

/* Cart Summary */
.cart-summary {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    height: fit-content;
}
.summary-title {
    font-size: 1.5em;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}
.summary-row:last-child {
    border-bottom: none;
    font-size: 1.2em;
    font-weight: 600;
    color: #333;
}
.checkout-btn {
    width: 100%;
    padding: 15px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1.1em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 20px;
}
.checkout-btn:hover {
    background: #5a67d8;
    transform: translateY(-2px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}
.empty-state .icon {
    font-size: 4em;
    margin-bottom: 20px;
    opacity: 0.5;
}
.empty-state .btn {
    margin-top: 20px;
    padding: 12px 24px;
    background: #667eea;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    display: inline-block;
    transition: all 0.3s;
}
.empty-state .btn:hover {
    background: #5a67d8;
    color: white;
}
/* Account Dropdown */
    .account-dropdown {
        position: relative;
        display: inline-block;
    }
    .account-logo {
        background: #fff !important;
        color: #333 !important;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2em;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        border: 2px solid #eee;
        transition: box-shadow 0.2s;
    }
    .account-logo:hover {
        box-shadow: 0 4px 12px rgba(102,126,234,0.15);
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
        color: #333;
        text-decoration: none;
        transition: background 0.2s;
    }
    .dropdown-item:hover {
        background: #f8f9fa;
        color: #667eea;
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
    }
    .cart-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .cart-item {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    .quantity-controls {
        margin: 0;
    }
}
</style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            <div class="logo">🛍️ CraftsHub - My Cart</div>
        </div>
        <div class="user-info">
                <span>Welcome, <?= htmlspecialchars($buyer_name) ?>!</span>
                <div class="account-dropdown">
                    <span class="account-logo" onclick="toggleAccountMenu()">👤</span>
                    <div class="dropdown-menu" id="accountMenu">
                        <a href="/buyer/account-settings" class="dropdown-item">⚙️ Account Settings</a>
                        <a href="/buyer/customer-service" class="dropdown-item">💬 Customer Service</a>
                        <a href="/buyer/logout" class="dropdown-item">🚪 Logout</a>
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
    <div class="sidebar">
        <h3 class="sidebar-title">🚀 Quick Actions</h3>
        <a href="/buyer/dashboard" class="sidebar-item"><span class="sidebar-icon">🏠</span> Dashboard</a>
        <a href="/buyer/cart" class="sidebar-item active"><span class="sidebar-icon">🛒</span> View Cart</a>
        <a href="/buyer/orders" class="sidebar-item"><span class="sidebar-icon">📦</span> View My Orders</a>

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">🛒 My Cart</h1>
        </div>

        <!-- Success/Error Messages -->
        <?php if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                ✅ <?= $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-error">
                ❌ <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
        <?php if(!empty($cart_items)): ?>
            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items">
                    <?php foreach($cart_items as $item): ?>
                        <div class="cart-item">
                            <div class="item-image">
                <?php if(!empty($item->image_url)): ?>
                    <img src="<?= htmlspecialchars($item->image_url) ?>" alt="<?= htmlspecialchars($item->product_name) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                <?php else: ?>
                    🎨
                <?php endif; ?>
            </div>
                            <div class="item-details">
                                <div class="item-name"><?= htmlspecialchars($item->product_name) ?></div>
                                <div class="item-price">$<?= number_format($item->price, 2) ?> each</div>
                            </div>
                            <div class="quantity-controls">
                                <form method="POST" action="/buyer/update-cart" style="display: inline;">
                                    <input type="hidden" name="cart_id" value="<?= $item->cart_id ?>">
                                    <input type="hidden" name="quantity" value="<?= max(1, $item->quantity - 1) ?>">
                                    <button type="submit" class="quantity-btn">-</button>
                                </form>
                                <input type="text" class="quantity-input" value="<?= $item->quantity ?>" readonly>
                                <form method="POST" action="/buyer/update-cart" style="display: inline;">
                                    <input type="hidden" name="cart_id" value="<?= $item->cart_id ?>">
                                    <input type="hidden" name="quantity" value="<?= $item->quantity + 1 ?>">
                                    <button type="submit" class="quantity-btn">+</button>
                                </form>
                            </div>
                            <div class="item-total">₱<?= number_format($item->price * $item->quantity, 2) ?></div>
                            <form method="POST" action="/buyer/remove-from-cart" style="display: inline;">
                                <input type="hidden" name="cart_id" value="<?= $item->cart_id ?>">
                                <button type="submit" class="remove-btn" onclick="return confirm('Remove this item from cart?')">🗑️</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h3 class="summary-title">Order Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>₱<?= number_format($cart_total, 2) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row">
                        <span>Total:</span>
                        <span>₱<?= number_format($cart_total, 2) ?></span>
                    </div>
                    <a href="/buyer/checkout" class="checkout-btn" style="text-decoration: none; display: block; text-align: center;">
                        💳 Proceed to Checkout
                    </a>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="/buyer/dashboard" style="color: #667eea; text-decoration: none;">
                            🛍️ Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="icon">🛒</div>
                <h3>Your cart is empty</h3>
                <p>Add some products to your cart to get started!</p>
                <a href="/buyer/dashboard" class="btn">🛍️ Start Shopping</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
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
    </script>
</body>

</html>