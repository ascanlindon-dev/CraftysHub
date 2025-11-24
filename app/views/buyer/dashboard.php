<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buyer Dashboard - CraftsHub</title>
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
.logout-btn {
    background: rgba(255,255,255,0.2);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}
.logout-btn:hover { background: rgba(255,255,255,0.3); }

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
    font-size: 1.2em;
    font-weight: 600;
    color: #333;
    margin: 0 25px 20px 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
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
.sidebar-item:hover, .sidebar-item.active {
    background: #f8f9fa;
    border-left-color: #667eea;
    color: #667eea;
}

/* Main Content */
.main-content {
    margin-left: 250px;
    padding: 30px;
    min-height: calc(100vh - 80px);
}

.welcome-section {
    background: white;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    text-align: center;
}
.welcome-title {
    font-size: 2.5em;
    color: #333;
    margin-bottom: 10px;
}
.welcome-subtitle {
    color: #666;
    font-size: 1.2em;
}

/* Search Section */
.search-section {
    background: white;
    padding: 20px 30px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

.search-container {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
}

.search-input {
    width: 100%;
    padding: 15px 20px;
    font-size: 16px;
    border: 2px solid #e9ecef;
    border-radius: 50px;
    outline: none;
    transition: all 0.3s;
    background: #f8f9fa;
}

.search-input:focus {
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.clear-btn {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: #6c757d;
    padding: 5px;
    border-radius: 50%;
    transition: all 0.3s;
}

.clear-btn:hover {
    background: #f8f9fa;
    color: #495057;
}

/* Products Section */
.products-section {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.product-card {
    background: #f8f9fa;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: all 0.3s;
    cursor: pointer;
}
.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.product-image {
    width: 100%;
    height: 180px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5em;
    color: white;
    overflow: hidden;
}

.product-details {
    padding: 20px;
}
.product-name {
    font-size: 1.2em;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}
.product-price {
    font-size: 1.3em;
    font-weight: bold;
    color: #667eea;
    margin-bottom: 10px;
}
.product-stock {
    font-size: 0.9em;
    color: #28a745;
    margin-bottom: 15px;
}
.product-stock.low { color: #ffc107; }
.product-stock.out { color: #dc3545; }

.add-to-cart-btn {
    width: 100%;
    padding: 10px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}
.add-to-cart-btn:hover {
    background: #5a67d8;
}
.add-to-cart-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.buy-now-btn {
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}
.buy-now-btn:hover {
    background: linear-gradient(135deg, #218838, #1ea080);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
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
    .menu-toggle { display: inline-block !important; }
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
    }
    .sidebar.active {
        transform: translateX(0);
    }
    .main-content {
        margin-left: 0;
        padding: 20px;
    }
    .welcome-title { font-size: 2em; }
    .products-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <button class="menu-toggle" onclick="toggleSidebar()" style="display: none; background: none; border: none; color: white; font-size: 1.5em; margin-right: 10px; cursor: pointer;">☰</button>
            🛍️ CraftsHub - Buyer Portal
        </div>
            <!-- Single Buy Now Popup Overlay (outside product grid, only once) -->
            <div id="buyNowOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); z-index:9999; justify-content:center; align-items:center;">
                <div id="buyNowPopup" style="background:#fff; padding:32px; border-radius:10px; max-width:350px; margin:auto; position:relative; box-shadow:0 4px 24px rgba(0,0,0,0.18); display:flex; flex-direction:column; align-items:center;">
                    <span onclick="closeBuyNowOverlay()" style="position:absolute; top:10px; right:16px; cursor:pointer; font-size:24px;">&times;</span>
                    <h3 style="margin-bottom:18px;">Buy <span id="buyNowProductName"></span></h3>
                    <form id="buyNowForm" onsubmit="submitBuyNowOverlayForm(event)">
                        <input type="hidden" id="buyNowProductId" name="product_id">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:18px;">
                            <label for="buyNowQuantity" style="font-weight:500;">Quantity:</label>
                            <button type="button" onclick="changeBuyNowQuantity(-1)" style="background:#eee; border:none; border-radius:4px; width:32px; height:32px; font-size:18px;">-</button>
                            <input type="number" id="buyNowQuantity" name="quantity" min="1" value="1" style="width:60px; text-align:center; font-size:16px;">
                            <button type="button" onclick="changeBuyNowQuantity(1)" style="background:#eee; border:none; border-radius:4px; width:32px; height:32px; font-size:18px;">+</button>
                        </div>
                        <button type="submit" style="background:#667eea; color:#fff; padding:8px 20px; border:none; border-radius:5px;">Checkout</button>
                        <button type="button" onclick="closeBuyNowOverlay()" style="margin-left:10px; background:#eee; color:#333; border:none; padding:8px 20px; border-radius:5px;">Cancel</button>
                    </form>
                </div>
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
            // Buy Now single overlay popup
            function showBuyNowOverlay(productId, productName, price) {
                var overlay = document.getElementById('buyNowOverlay');
                var popup = document.getElementById('buyNowPopup');
                document.getElementById('buyNowProductName').textContent = productName;
                document.getElementById('buyNowProductId').value = productId;
                document.getElementById('buyNowQuantity').value = 1;
                overlay.style.display = 'flex';
                overlay.style.zIndex = '9999';
                popup.style.zIndex = '10000';
            }

            function closeBuyNowOverlay() {
                var overlay = document.getElementById('buyNowOverlay');
                overlay.style.display = 'none';
            }

            function changeBuyNowQuantity(delta) {
                var qtyInput = document.getElementById('buyNowQuantity');
                var current = parseInt(qtyInput.value, 10) || 1;
                var newVal = current + delta;
                if (newVal < 1) newVal = 1;
                qtyInput.value = newVal;
            }

            function submitBuyNowOverlayForm(event) {
                event.preventDefault();
                var productId = document.getElementById('buyNowProductId').value;
                var quantity = document.getElementById('buyNowQuantity').value;
                if (!quantity || quantity < 1) {
                    alert('Please enter a valid quantity.');
                    return;
                }
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '/buyer/buy-now';
                var productIdInput = document.createElement('input');
                productIdInput.type = 'hidden';
                productIdInput.name = 'product_id';
                productIdInput.value = productId;
                var quantityInput = document.createElement('input');
                quantityInput.type = 'hidden';
                quantityInput.name = 'quantity';
                quantityInput.value = quantity;
                form.appendChild(productIdInput);
                form.appendChild(quantityInput);
                document.body.appendChild(form);
                form.submit();
            }
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
        <a href="/buyer/dashboard" class="sidebar-item active"><span class="sidebar-icon">🏠</span> Dashboard</a>
        <a href="/buyer/cart" class="sidebar-item"><span class="sidebar-icon">🛒</span> View Cart</a>
        <a href="/buyer/orders" class="sidebar-item"><span class="sidebar-icon">📦</span> View My Orders</a>

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title">👋 Welcome to your Dashboard!</h1>
            <p class="welcome-subtitle">Manage your orders, browse products, and track your purchases</p>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="🔍 Search products by name..." class="search-input">
                <button onclick="clearSearch()" class="clear-btn" id="clearBtn" style="display: none;">✖️</button>
            </div>
        </div>
        
        <!-- Products Section -->
        <div class="products-section">
            <h2 class="section-title" id="productsTitle">
                🛍️ Available Products
            </h2>
            
            <?php if(!empty($products)): ?>
                <div class="products-grid">
                    <?php foreach($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if(!empty($product->image_url)): ?>
                                    <img src="<?= htmlspecialchars($product->image_url) ?>" alt="<?= htmlspecialchars($product->product_name) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    🎨
                                <?php endif; ?>
                            </div>
                            <div class="product-details">
                                <div class="product-name"><?= htmlspecialchars($product->product_name) ?></div>
                                <?php if(!empty($product->description)): ?>
                                    <div class="product-description" style="font-size: 0.9em; color: #6c757d; margin: 8px 0; line-height: 1.4;"><?= htmlspecialchars(substr($product->description, 0, 100)) ?><?= strlen($product->description) > 100 ? '...' : '' ?></div>
                                <?php endif; ?>
                                <div class="product-price">₱<?= number_format($product->price, 2) ?></div>
                                <?php $stock = $product->stock ?? 0; ?>
                                <div class="product-stock <?= $stock <= 5 ? ($stock == 0 ? 'out' : 'low') : '' ?>">
                                    <?php if($stock > 0): ?>
                                        📦 <?= $stock ?> in stock
                                    <?php else: ?>
                                        ❌ Out of stock
                                    <?php endif; ?>
                                </div>
                                <div class="product-actions" style="display: flex; gap: 8px; flex-direction: column;">
                                                                        <a href="/buyer/product/<?= $product->product_id ?>" class="view-product-link" style="color: #007bff; text-decoration: underline; font-weight: 500;">👁️ View Product</a>
                                    <button class="add-to-cart-btn" <?= $product->stock == 0 ? 'disabled' : '' ?> 
                                            onclick="addToCart(<?= $product->product_id ?>, '<?= htmlspecialchars($product->product_name) ?>')">
                                        <?= $product->stock == 0 ? '❌ Out of Stock' : '🛒 Add to Cart' ?>
                                    </button>
                                    <?php if($product->stock > 0): ?>
                                        <button class="buy-now-btn" onclick="showBuyNowOverlay(<?= $product->product_id ?>, '<?= htmlspecialchars($product->product_name) ?>', <?= $product->price ?>)">
                                            ⚡ Buy Now
                                        </button>
                                        <!-- Single Buy Now Popup Overlay -->
                                        <div id="buyNowOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); z-index:9999; justify-content:center; align-items:center;">
                                            <div id="buyNowPopup" style="background:#fff; padding:32px; border-radius:10px; max-width:350px; margin:auto; position:relative; box-shadow:0 4px 24px rgba(0,0,0,0.18); display:flex; flex-direction:column; align-items:center;">
                                                <span onclick="closeBuyNowOverlay()" style="position:absolute; top:10px; right:16px; cursor:pointer; font-size:24px;">&times;</span>
                                                <h3 style="margin-bottom:18px;">Buy <span id="buyNowProductName"></span></h3>
                                                <form id="buyNowForm" onsubmit="submitBuyNowOverlayForm(event)">
                                                    <input type="hidden" id="buyNowProductId" name="product_id">
                                                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:18px;">
                                                        <label for="buyNowQuantity" style="font-weight:500;">Quantity:</label>
                                                        <button type="button" onclick="changeBuyNowQuantity(-1)" style="background:#eee; border:none; border-radius:4px; width:32px; height:32px; font-size:18px;">-</button>
                                                        <input type="number" id="buyNowQuantity" name="quantity" min="1" value="1" style="width:60px; text-align:center; font-size:16px;">
                                                        <button type="button" onclick="changeBuyNowQuantity(1)" style="background:#eee; border:none; border-radius:4px; width:32px; height:32px; font-size:18px;">+</button>
                                                    </div>
                                                    <button type="submit" style="background:#667eea; color:#fff; padding:8px 20px; border:none; border-radius:5px;">Checkout</button>
                                                    <button type="button" onclick="closeBuyNowOverlay()" style="margin-left:10px; background:#eee; color:#333; border:none; padding:8px 20px; border-radius:5px;">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: #666; padding: 40px;">No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Single Buy Now Popup Overlay (moved outside product loop) -->
    <div id="buyNowOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); z-index:9999; justify-content:center; align-items:center;">
        <div id="buyNowPopup" style="background:#fff; padding:32px; border-radius:10px; max-width:350px; margin:auto; position:relative; box-shadow:0 4px 24px rgba(0,0,0,0.18); display:flex; flex-direction:column; align-items:center;">
            <span onclick="closeBuyNowOverlay()" style="position:absolute; top:10px; right:16px; cursor:pointer; font-size:24px;">&times;</span>
            <h3 style="margin-bottom:18px;">Buy <span id="buyNowProductName"></span></h3>
            <form id="buyNowForm" onsubmit="submitBuyNowOverlayForm(event)">
                <input type="hidden" id="buyNowProductId" name="product_id">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:18px;">
                    <label for="buyNowQuantity" style="font-weight:500;">Quantity:</label>
                    <button type="button" onclick="changeBuyNowQuantity(-1)" style="background:#eee; border:none; border-radius:4px; width:32px; height:32px; font-size:18px;">-</button>
                    <input type="number" id="buyNowQuantity" name="quantity" min="1" value="1" style="width:60px; text-align:center; font-size:16px;">
                    <button type="button" onclick="changeBuyNowQuantity(1)" style="background:#eee; border:none; border-radius:4px; width:32px; height:32px; font-size:18px;">+</button>
                </div>
                <button type="submit" style="background:#667eea; color:#fff; padding:8px 20px; border:none; border-radius:5px;">Checkout</button>
                <button type="button" onclick="closeBuyNowOverlay()" style="margin-left:10px; background:#eee; color:#333; border:none; padding:8px 20px; border-radius:5px;">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        // Add to cart functionality
        function addToCart(productId, productName) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/buyer/add-to-cart';
            
            const productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'product_id';
            productIdInput.value = productId;
            
            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = 1;
            
            form.appendChild(productIdInput);
            form.appendChild(quantityInput);
            document.body.appendChild(form);
            form.submit();
        }

        // Buy Now single overlay popup
        function showBuyNowOverlay(productId, productName, price) {
            document.getElementById('buyNowProductName').textContent = productName;
            document.getElementById('buyNowProductId').value = productId;
            document.getElementById('buyNowQuantity').value = 1;
            document.getElementById('buyNowOverlay').style.display = 'flex';
        }

        function closeBuyNowOverlay() {
            document.getElementById('buyNowOverlay').style.display = 'none';
        }

        function changeBuyNowQuantity(delta) {
            var qtyInput = document.getElementById('buyNowQuantity');
            var current = parseInt(qtyInput.value, 10) || 1;
            var newVal = current + delta;
            if (newVal < 1) newVal = 1;
            qtyInput.value = newVal;
        }

        function submitBuyNowOverlayForm(event) {
            event.preventDefault();
            var productId = document.getElementById('buyNowProductId').value;
            var quantity = document.getElementById('buyNowQuantity').value;
            if (!quantity || quantity < 1) {
                alert('Please enter a valid quantity.');
                return;
            }
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/buyer/buy-now';
            var productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'product_id';
            productIdInput.value = productId;
            var quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = quantity;
            form.appendChild(productIdInput);
            form.appendChild(quantityInput);
            document.body.appendChild(form);
            form.submit();
        }

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

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearBtn');
        const productsTitle = document.getElementById('productsTitle');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const productCards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            productCards.forEach(card => {
                const productName = card.querySelector('.product-name').textContent.toLowerCase();
                const productDesc = card.querySelector('.product-description') ? 
                    card.querySelector('.product-description').textContent.toLowerCase() : '';
                
                if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update title and show/hide clear button
            if (searchTerm) {
                productsTitle.textContent = `🔍 Search Results (${visibleCount} found)`;
                clearBtn.style.display = 'block';
            } else {
                productsTitle.textContent = '🛍️ Available Products';
                clearBtn.style.display = 'none';
            }

            // Show "no results" message if no products found
            showNoResultsMessage(visibleCount === 0 && searchTerm);
        });

        function clearSearch() {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
            searchInput.focus();
        }

        function showNoResultsMessage(show) {
            let noResultsDiv = document.getElementById('noResultsMessage');
            if (show && !noResultsDiv) {
                noResultsDiv = document.createElement('div');
                noResultsDiv.id = 'noResultsMessage';
                noResultsDiv.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #6c757d;">
                        <div style="font-size: 3em; margin-bottom: 20px;">🔍</div>
                        <h3>No products found</h3>
                        <p>Try searching with different keywords</p>
                    </div>
                `;
                document.querySelector('.products-grid').appendChild(noResultsDiv);
            } else if (!show && noResultsDiv) {
                noResultsDiv.remove();
            }
        }
    </script>
        <!-- Footer Section -->
        <footer style="background-color: #fafaf9; border-top: 1px solid #e7e5e4; margin-top: 60px; padding: 60px 20px 20px; font-family: Inter, sans-serif;">
            <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 40px;">
                <!-- About -->
                <div style="color: #444; font-size: 14px; line-height: 1.6;">
                    <div style="display: flex; align-items: center; margin-bottom: 16px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(to bottom right, #f59e0b, #ea580c); display: flex; align-items: center; justify-content: center; margin-right: 8px; font-size: 16px;">
                            <span style="color: #fff;">🎨</span>
                        </div>
                        <span style="font-weight: 600; color: #1c1917;">CraftsyHub</span>
                    </div>
                    <p>Connecting artisans with craft lovers. Discover unique, handmade treasures from talented makers.</p>
                </div>
                <!-- Quick Links -->
                <div style="color: #444; font-size: 14px; line-height: 1.6;">
                    <h3 style="margin-bottom: 16px; font-weight: 600; color: #1c1917; font-size: 16px;">Quick Links</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 8px;"><a href="/buyer/dashboard" style="background: none; border: none; color: #57534e; font-size: 14px; cursor: pointer; padding: 0; text-decoration: none; transition: color 0.2s;">Home</a></li>
                        <li style="margin-bottom: 8px;"><a href="/buyer/marketplace-preview" style="background: none; border: none; color: #57534e; font-size: 14px; cursor: pointer; padding: 0; text-decoration: none; transition: color 0.2s;">Marketplace</a></li>
                        <li style="margin-bottom: 8px;"><a href="/buyer/about" style="background: none; border: none; color: #57534e; font-size: 14px; cursor: pointer; padding: 0; text-decoration: none; transition: color 0.2s;">About Us</a></li>
                        <li style="margin-bottom: 8px;"><a href="/buyer/contact" style="background: none; border: none; color: #57534e; font-size: 14px; cursor: pointer; padding: 0; text-decoration: none; transition: color 0.2s;">Contact</a></li>
                    </ul>
                </div>
                <!-- Contact Info -->
                <div style="color: #444; font-size: 14px; line-height: 1.6;">
                    <h3 style="margin-bottom: 16px; font-weight: 600; color: #1c1917; font-size: 16px;">Contact Us</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="display: flex; align-items: center; gap: 8px; color: #57534e; font-size: 14px; margin-bottom: 8px;"><span style="font-size:16px;">📧</span> <span>hello@craftsyhub.com</span></li>
                        <li style="display: flex; align-items: center; gap: 8px; color: #57534e; font-size: 14px; margin-bottom: 8px;"><span style="font-size:16px;">📞</span> <span>+63 123 456 7890</span></li>
                        <li style="display: flex; align-items: center; gap: 8px; color: #57534e; font-size: 14px; margin-bottom: 8px;"><span style="font-size:16px;">📍</span> <span>Manila, Philippines</span></li>
                    </ul>
                </div>
                <!-- Social -->
                <div style="color: #444; font-size: 14px; line-height: 1.6;">
                    <h3 style="margin-bottom: 16px; font-weight: 600; color: #1c1917; font-size: 16px;">Follow Us</h3>
                    <div style="display: flex; gap: 12px;">
                        <a href="#" style="width: 36px; height: 36px; border-radius: 10px; border: 1px solid #e7e5e4; background-color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size:16px;">👍</a>
                        <a href="#" style="width: 36px; height: 36px; border-radius: 10px; border: 1px solid #e7e5e4; background-color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size:16px;">📸</a>
                        <a href="#" style="width: 36px; height: 36px; border-radius: 10px; border: 1px solid #e7e5e4; background-color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size:16px;">🐦</a>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid #e7e5e4; margin-top: 40px; padding-top: 24px; text-align: center; color: #57534e; font-size: 13px;">
                <p>&copy; <?php echo date('Y'); ?> CraftsyHub. All rights reserved.</p>
            </div>
        </footer>
</body>
</html>