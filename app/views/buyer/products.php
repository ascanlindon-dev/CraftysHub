<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Browse Products - CraftsHub</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { 
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
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
    color: #2D2D2D;
    margin: 0 25px 20px 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0ede8;
}
.sidebar-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 25px;
    color: #2D2D2D;
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
    box-shadow: 0 4px 12px rgba(217,150,125,0.13);
    color: #fff;
    background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
    border-color: #D9967D;
}

/* Main Content */
.main-content {
    margin-left: 250px;
    padding: 30px;
    min-height: calc(100vh - 80px);
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
    border: 2px solid #E8D4C8;
    border-radius: 50px;
    outline: none;
    transition: all 0.3s;
    background: #faf9f7;
}

.search-input:focus {
    border-color: #D9967D;
    background: white;
    box-shadow: 0 0 0 3px rgba(217, 150, 125, 0.1);
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
    background: linear-gradient(45deg, #D9967D, #C88A6F);
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
    color: #2D2D2D;
    margin-bottom: 8px;
}
.product-price {
    font-size: 1.3em;
    font-weight: bold;
    color: #D9967D;
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
    background: #D9967D;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}
.add-to-cart-btn:hover {
    background: #C88A6F;
}
.add-to-cart-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.buy-now-btn {
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, #D9967D, #C88A6F);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(217, 150, 125, 0.3);
}
.buy-now-btn:hover {
    background: linear-gradient(135deg, #C88A6F, #B87960);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(217, 150, 125, 0.4);
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
    .products-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <button class="menu-toggle" onclick="toggleSidebar()" style="display: none; background: none; border: none; color: white; font-size: 1.5em; margin-right: 10px; cursor: pointer;">☰</button>
            CraftsHub - Browse Products
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div class="sidebar">
        <h3 class="sidebar-title"><i class="fas fa-bolt" style="color:#D9967D; margin-right:8px;"></i> Quick Actions</h3>
        <a href="/buyer/dashboard" class="sidebar-item"><span class="sidebar-icon"><i class="fas fa-home"></i></span> Dashboard</a>
        <a href="/buyer/cart" class="sidebar-item"><span class="sidebar-icon"><i class="fas fa-shopping-cart"></i></span> View Cart</a>
        <a href="/buyer/orders" class="sidebar-item"><span class="sidebar-icon"><i class="fas fa-box"></i></span> View My Orders</a>

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Search Section -->
        <div class="search-section">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search products by name..." class="search-input">
                <button onclick="clearSearch()" class="clear-btn" id="clearBtn" style="display: none;"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <!-- Products Section -->
        <div class="products-section">
            <h2 class="section-title" id="productsTitle">
                Available Products
            </h2>
            
            <?php if(!empty($products)): ?>
                <div class="products-grid">
                    <?php foreach($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if(!empty($product->image_url)): ?>
                                    <img src="<?= htmlspecialchars($product->image_url) ?>" alt="<?= htmlspecialchars($product->product_name) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="display:flex; align-items:center; justify-content:center; width:100%; height:100%; color:#D9967D;"><i class="fas fa-image fa-2x"></i></div>
                                <?php endif; ?>
                            </div>
                            <div class="product-details">
                                <div class="product-name"><?= htmlspecialchars($product->product_name) ?></div>
                                <?php if(!empty($product->description)): ?>
                                    <div class="product-description" style="font-size: 0.9em; color: #777; margin: 8px 0; line-height: 1.4;"><?= htmlspecialchars(substr($product->description, 0, 100)) ?><?= strlen($product->description) > 100 ? '...' : '' ?></div>
                                <?php endif; ?>
                                <div class="product-price">₱<?= number_format($product->price, 2) ?></div>
                                <div class="product-stock <?= $product->stock <= 5 ? ($product->stock == 0 ? 'out' : 'low') : '' ?>">
                                    <?php if($product->stock > 0): ?>
                                        <?= $product->stock ?> in stock
                                    <?php else: ?>
                                        Out of stock
                                    <?php endif; ?>
                                </div>
                                <div class="product-actions" style="display: flex; gap: 8px; flex-direction: column;">
                                    <a href="/buyer/product/<?= $product->product_id ?>" class="view-product-link" style="color: #D9967D; text-decoration: underline; font-weight: 500;">View Product</a>
                                    <button class="add-to-cart-btn" <?= $product->stock == 0 ? 'disabled' : '' ?> 
                                            onclick="addToCart(<?= $product->product_id ?>, '<?= htmlspecialchars($product->product_name) ?>')">
                                        <?= $product->stock == 0 ? 'Out of Stock' : 'Add to Cart' ?>
                                    </button>
                                    <?php if($product->stock > 0): ?>
                                        <button class="buy-now-btn" onclick="buyNow(<?= $product->product_id ?>, '<?= htmlspecialchars($product->product_name) ?>', <?= $product->price ?>)">
                                            Buy Now
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: #777; padding: 40px;">No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function addToCart(productId, productName) {
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

        function buyNow(productId, productName, price) {
            const quantity = prompt(`How many "${productName}" would you like to buy?`, '1');
            if (quantity !== null && quantity > 0) {
                const confirmation = confirm(
                    `Buy ${quantity} x "${productName}" for ₱${(price * quantity).toFixed(2)}?\n\nThis will redirect you to checkout.`
                );
                if (confirmation) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/buyer/buy-now';
                    const productIdInput = document.createElement('input');
                    productIdInput.type = 'hidden';
                    productIdInput.name = 'product_id';
                    productIdInput.value = productId;
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'hidden';
                    quantityInput.name = 'quantity';
                    quantityInput.value = quantity;
                    form.appendChild(productIdInput);
                    form.appendChild(quantityInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }

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
                
                if (productName.includes(searchTerm)) {
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
</body>
</html>
