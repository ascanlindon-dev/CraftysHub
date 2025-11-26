<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Cart - CraftsHub</title>
<style>
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
}

.page-header {
    margin-bottom: 30px;
}
.page-title {
    font-size: 2.5em;
    color: #2D2D2D;
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
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #86efac;
}
.alert-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

/* Cart Items */
.cart-container {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.cart-items {
    background: white;
    border-radius: 12px;
    padding: 0;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* Select All Header */
.cart-header {
    display: flex;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #f0ede8;
    background: #faf9f7;
}

.select-all-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.select-all-wrapper input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #D9967D;
}

.select-all-label {
    font-weight: 600;
    color: #2D2D2D;
    cursor: pointer;
}

.cart-item {
    display: flex;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #f5f0eb;
    gap: 15px;
}
.cart-item:last-child {
    border-bottom: none;
}

.item-checkbox {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #D9967D;
}

.item-image {
    width: 100px;
    height: 100px;
    background: linear-gradient(45deg, #E8A89B, #D9967D);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2em;
    overflow: hidden;
    flex-shrink: 0;
}

.item-details {
    flex: 1;
}
.item-name {
    font-size: 1em;
    font-weight: 600;
    color: #2D2D2D;
    margin-bottom: 8px;
}
.item-price {
    color: #D9967D;
    font-weight: 600;
    font-size: 1.1em;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid #E8D4C8;
    border-radius: 6px;
    padding: 4px;
    background: #faf9f7;
}

.quantity-btn {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    color: #C88A6F;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2em;
    font-weight: 600;
    transition: all 0.2s;
    border-radius: 4px;
}

.quantity-btn:hover {
    background: #fff;
    color: #D9967D;
}

.quantity-display {
    width: 45px;
    text-align: center;
    font-weight: 600;
    color: #2D2D2D;
    padding: 0 4px;
}

.item-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
}

.item-total {
    font-size: 1.2em;
    font-weight: 600;
    color: #2D2D2D;
}

.remove-btn {
    background: transparent;
    color: #DC3545;
    border: none;
    padding: 6px 12px;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.9em;
    font-weight: 500;
}
.remove-btn:hover {
    color: #A91E2C;
    background: #fef2f2;
    border-radius: 4px;
}

/* Cart Summary */
.cart-summary {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    height: fit-content;
    position: sticky;
    top: 20px;
}

.summary-title {
    font-size: 1.2em;
    font-weight: 600;
    color: #2D2D2D;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f5f0eb;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    color: #666;
}

.summary-row.total {
    border-top: 1px solid #f5f0eb;
    padding-top: 15px;
    margin-top: 15px;
    font-size: 1.3em;
    font-weight: 700;
    color: #2D2D2D;
}

.checkout-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(200, 138, 111, 0.2);
}
.checkout-btn:hover {
    background: linear-gradient(135deg, #CE8A74 0%, #BD7E63 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(200, 138, 111, 0.3);
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
    background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    display: inline-block;
    transition: all 0.3s;
    font-weight: 600;
}
.empty-state .btn:hover {
    background: linear-gradient(135deg, #CE8A74 0%, #BD7E63 100%);
    color: white;
    transform: translateY(-2px);
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
    box-shadow: 0 4px 12px rgba(217, 150, 125, 0.2);
}
.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 50px;
    background: white;
    min-width: 180px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    border-radius: 8px;
    z-index: 200;
    overflow: hidden;
    border: 1px solid #E8D4C8;
}
.dropdown-item {
    display: block;
    padding: 15px 20px;
    color: #333;
    text-decoration: none;
    transition: background 0.2s;
}
.dropdown-item:hover {
    background: #faf9f7;
    color: #D9967D;
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
        flex-wrap: wrap;
        gap: 10px;
    }
    .item-actions {
        width: 100%;
        flex-direction: row;
        justify-content: space-between;
    }
    .cart-summary {
        position: static;
    }
}
</style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <button class="menu-toggle" onclick="toggleSidebar()" style="font-size: 1.2em; font-weight: 600;">☰</button>
            <div class="logo">CraftsHub - My Cart</div>
        </div>
        <div class="user-info">
                <span>Welcome, <?= htmlspecialchars($buyer_name) ?>!</span>
                <div class="account-dropdown">
                    <span class="account-logo" onclick="toggleAccountMenu()" style="font-size: 1.4em;">👤</span>
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
    <div class="sidebar">
        <h3 class="sidebar-title">Quick Actions</h3>
        <a href="/buyer/dashboard" class="sidebar-item"><span class="sidebar-icon">⌂</span> Dashboard</a>
        <a href="/buyer/cart" class="sidebar-item active"><span class="sidebar-icon">🛒</span> View Cart</a>
        <a href="/buyer/orders" class="sidebar-item"><span class="sidebar-icon">📦</span> View My Orders</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">Shopping Cart</h1>
        </div>

        <!-- Success/Error Messages -->
        <?php if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                ✓ <?= $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-error">
                ✗ <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
        <?php if(!empty($cart_items)): ?>
            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items">
                    <!-- Select All Header -->
                    <div class="cart-header">
                        <div class="select-all-wrapper">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)">
                            <label class="select-all-label" for="selectAllCheckbox">Select All</label>
                        </div>
                        <span style="color: #777; font-size: 0.9em;">
                            <span id="selectedCount">0</span> selected
                        </span>
                    </div>

                    <!-- Cart Items List -->
                    <form id="cartForm">
                        <?php foreach($cart_items as $item): ?>
                            <div class="cart-item" data-cart-id="<?= $item->cart_id ?>" data-price="<?= $item->price ?>">
                                <!-- Checkbox -->
                                <input type="checkbox" class="item-checkbox" value="<?= $item->cart_id ?>" onchange="updateTotals()">
                                
                                <!-- Image -->
                                <div class="item-image">
                                    <?php if(!empty($item->image_url)): ?>
                                        <img src="<?= htmlspecialchars($item->image_url) ?>" alt="<?= htmlspecialchars($item->product_name) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        🎨
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Details -->
                                <div class="item-details">
                                    <div class="item-name"><?= htmlspecialchars($item->product_name) ?></div>
                                    <div class="item-price">₱<?= number_format($item->price, 2) ?> each</div>
                                </div>
                                
                                <!-- Quantity Controls -->
                                <div class="quantity-controls">
                                    <button type="button" class="quantity-btn" onclick="decrementQuantity(this)">−</button>
                                    <div class="quantity-display" data-quantity="<?= $item->quantity ?>">
                                        <input type="hidden" name="quantity[<?= $item->cart_id ?>]" value="<?= $item->quantity ?>">
                                        <?= $item->quantity ?>
                                    </div>
                                    <button type="button" class="quantity-btn" onclick="incrementQuantity(this)">+</button>
                                </div>
                                
                                <!-- Item Total -->
                                <div class="item-actions">
                                    <div class="item-total" data-base-price="<?= $item->price ?>" data-quantity="<?= $item->quantity ?>">
                                        ₱<?= number_format($item->price * $item->quantity, 2) ?>
                                    </div>
                                    <button type="button" class="remove-btn" onclick="removeCartItem(<?= $item->cart_id ?>)">Remove</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>

                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h3 class="summary-title">Order Summary</h3>
                    <div class="summary-row">
                        <span>Items Selected:</span>
                        <span id="selectedItems">0</span>
                    </div>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="summarySubtotal">₱0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span id="summaryTotal">₱0.00</span>
                    </div>
                    <button class="checkout-btn" id="checkoutBtn" onclick="proceedToCheckout()" style="text-decoration: none; text-align: center;">
                        Proceed to Checkout
                    </button>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="/buyer/dashboard" style="color: #D9967D; text-decoration: none; font-weight: 500;">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="icon">🛒</div>
                <h3>Your cart is empty</h3>
                <p>Add some products to your cart to get started!</p>
                <a href="/buyer/dashboard" class="btn">Start Shopping</a>
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

        // Toggle all checkboxes when "Select All" is clicked
        function toggleSelectAll(checkbox) {
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            itemCheckboxes.forEach(cb => cb.checked = checkbox.checked);
            updateTotals();
        }

        // Update totals when selection changes
        function updateTotals() {
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            let selectedCount = 0;
            let selectedTotal = 0;

            itemCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedCount++;
                    const cartItem = checkbox.closest('.cart-item');
                    const quantityDisplay = cartItem.querySelector('.quantity-display');
                    const basePrice = parseFloat(cartItem.getAttribute('data-price'));
                    const quantity = parseInt(quantityDisplay.textContent);
                    selectedTotal += basePrice * quantity;
                }
            });

            // Update select all checkbox state
            selectAllCheckbox.checked = selectedCount === itemCheckboxes.length && itemCheckboxes.length > 0;

            // Update display
            document.getElementById('selectedCount').textContent = selectedCount;
            document.getElementById('selectedItems').textContent = selectedCount;
            document.getElementById('summarySubtotal').textContent = '₱' + selectedTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('summaryTotal').textContent = '₱' + selectedTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            
            // Disable checkout button if no items selected
            const checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.disabled = selectedCount === 0;
            checkoutBtn.style.opacity = selectedCount === 0 ? '0.5' : '1';
            checkoutBtn.style.cursor = selectedCount === 0 ? 'not-allowed' : 'pointer';
        }

        // Increment quantity
        function incrementQuantity(btn) {
            const cartItem = btn.closest('.cart-item');
            const quantityDisplay = cartItem.querySelector('.quantity-display');
            const quantityInput = cartItem.querySelector('input[name^="quantity"]');
            let quantity = parseInt(quantityDisplay.textContent);
            quantity++;
            quantityDisplay.textContent = quantity;
            quantityInput.value = quantity;
            updateItemTotal(cartItem);
            updateTotals();
        }

        // Decrement quantity
        function decrementQuantity(btn) {
            const cartItem = btn.closest('.cart-item');
            const quantityDisplay = cartItem.querySelector('.quantity-display');
            const quantityInput = cartItem.querySelector('input[name^="quantity"]');
            let quantity = parseInt(quantityDisplay.textContent);
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
                quantityInput.value = quantity;
                updateItemTotal(cartItem);
                updateTotals();
            }
        }

        // Update item total price
        function updateItemTotal(cartItem) {
            const basePrice = parseFloat(cartItem.getAttribute('data-price'));
            const quantityDisplay = cartItem.querySelector('.quantity-display');
            const itemTotalDiv = cartItem.querySelector('.item-total');
            const quantity = parseInt(quantityDisplay.textContent);
            const total = basePrice * quantity;
            itemTotalDiv.textContent = '₱' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        // Remove item from cart
        function removeCartItem(cartId) {
            if (confirm('Remove this item from your cart?')) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/buyer/remove-from-cart';
                form.innerHTML = '<input type="hidden" name="cart_id" value="' + cartId + '">';
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Proceed to checkout with selected items
        function proceedToCheckout() {
            const selectedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
            
            if (selectedCheckboxes.length === 0) {
                alert('Please select at least one item to proceed');
                return;
            }

            // Create hidden form with selected items
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/buyer/checkout';
            
            selectedCheckboxes.forEach(checkbox => {
                const cartItem = checkbox.closest('.cart-item');
                const cartId = checkbox.value;
                const quantityDisplay = cartItem.querySelector('.quantity-display');
                const quantity = quantityDisplay.textContent;
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'items[' + cartId + ']';
                input.value = quantity;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }

        // Initialize totals on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotals();
        });
    </script>
</body>
</html>