
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - CraftsHub</title>
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
.logout-btn:hover { 
    background: rgba(255,255,255,0.3); 
    color: white;
}

/* Main Content */
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px;
}

.page-header {
    margin-bottom: 30px;
    text-align: center;
}
.page-title {
    font-size: 2.5em;
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
}
.page-subtitle {
    color: #666;
    font-size: 1.1em;
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

/* Checkout Container */
.checkout-container {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 30px;
}

/* Checkout Form */
.checkout-form {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.form-section {
    margin-bottom: 30px;
}
.form-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 1.3em;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-group {
    margin-bottom: 20px;
}
.form-label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #333;
}
.form-input, .form-textarea, .form-select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s;
}
.form-input:focus, .form-textarea:focus, .form-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}
.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.payment-options {
    display: grid;
    gap: 10px;
}
.payment-option {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}
.payment-option:hover {
    border-color: #667eea;
    background: #f8f9ff;
}
.payment-option input[type="radio"] {
    margin-right: 10px;
}
.payment-option.selected {
    border-color: #667eea;
    background: #f8f9ff;
}

/* Order Summary */
.order-summary {
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
    display: flex;
    align-items: center;
    gap: 10px;
}

.order-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}
.order-item:last-child {
    border-bottom: none;
}
.item-image {
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 15px;
    overflow: hidden;
}
.item-details {
    flex: 1;
}
.item-name {
    font-weight: 500;
    color: #333;
    margin-bottom: 5px;
}
.item-quantity {
    color: #666;
    font-size: 0.9em;
}
.item-price {
    font-weight: 600;
    color: #333;
}

.summary-totals {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #eee;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}
.summary-row.total {
    font-size: 1.2em;
    font-weight: 600;
    color: #333;
    padding-top: 10px;
    border-top: 1px solid #eee;
}

/* Buttons */
.btn-group {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}
.btn {
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 1.1em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}
.btn-primary {
    background: #667eea;
    color: white;
    flex: 1;
}
.btn-primary:hover {
    background: #5a67d8;
    transform: translateY(-2px);
}
.btn-secondary {
    background: #f8f9fa;
    color: #333;
    border: 1px solid #ddd;
}
.btn-secondary:hover {
    background: #e9ecef;
    color: #333;
}

/* Responsive */
@media (max-width: 768px) {
    .checkout-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .btn-group {
        flex-direction: column;
    }
    .main-content {
        padding: 20px 15px;
    }
}
</style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">💳 CraftsHub - Checkout</div>
        <div class="user-info">
            <span>Welcome, <?= htmlspecialchars($buyer_name) ?>!</span>
            <a href="/buyer/logout" class="logout-btn">🚪 Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">💳 Checkout</h1>
            <p class="page-subtitle">Review your order and complete your purchase</p>
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

        <div class="checkout-container">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form method="POST" action="/buyer/checkout">
                    <!-- Shipping Information -->
                    <div class="form-section">
                        <h3 class="section-title">🚚 Shipping Information</h3>
                        <div class="form-group">
                            <label class="form-label" for="shipping_address">Shipping Address *</label>
                            <select class="form-select" id="shipping_address" name="shipping_address" required>
                                <option value="">Select your location...</option>
                                <option value="Baco">Baco</option>
                                <option value="Bansud">Bansud</option>
                                <option value="Bongabong">Bongabong</option>
                                <option value="Bulalacao">Bulalacao</option>
                                <option value="Calapan City">Calapan City</option>
                                <option value="Gloria">Gloria</option>
                                <option value="Mansalay">Mansalay</option>
                                <option value="Naujan">Naujan</option>
                                <option value="Pinamalayan">Pinamalayan</option>
                                <option value="Pola">Pola</option>
                                <option value="Puerto Galera">Puerto Galera</option>
                                <option value="Roxas">Roxas</option>
                                <option value="San Teodoro">San Teodoro</option>
                                <option value="Socorro">Socorro</option>
                                <option value="Victoria">Victoria</option>
                                <option value="Other">Other (please specify in notes)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="order_notes">Notes / Special Instructions</label>
                            <textarea class="form-textarea" id="order_notes" name="order_notes" placeholder="Enter any notes or special instructions for delivery..."></textarea>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-section">
                        <h3 class="section-title">💰 Payment Method</h3>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash_on_delivery" checked>
                                <div>
                                    <strong>💵 Cash on Delivery</strong><br>
                                    <small>Pay when your order arrives</small>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="GCASH">
                                <div>
                                    <strong>📱 GCash</strong><br>
                                    <small>Pay securely using GCash (via PayMongo)</small>
                                </div>
                            </label>
                        </div>
                    </div>


                    <!-- Buttons -->
                    <div class="btn-group">
                        <a href="/buyer/cart" class="btn btn-secondary">🔙 Back to Cart</a>
                        <button type="submit" class="btn btn-primary">🛒 Place Order</button>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="summary-title">📋 Order Summary</h3>
                
                <!-- Order Items -->
                <?php foreach($cart_items as $item): ?>
                    <div class="order-item">
                        <div class="item-image">
                            <?php if(!empty($item->image_url)): ?>
                                <img src="<?= htmlspecialchars($item->image_url) ?>" alt="<?= htmlspecialchars($item->product_name) ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                🎨
                            <?php endif; ?>
                        </div>
                        <div class="item-details">
                            <div class="item-name"><?= htmlspecialchars($item->product_name) ?></div>
                            <div class="item-quantity">Qty: <?= $item->quantity ?></div>
                        </div>
                        <div class="item-price">₱<?= number_format($item->price * $item->quantity, 2) ?></div>
                    </div>
                <?php endforeach; ?>

                <!-- Summary Totals -->
                <div class="summary-totals">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>$<?= number_format($cart_total, 2) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax:</span>
                        <span>₱0.00</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>₱<?= number_format($cart_total, 2) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle payment method selection
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove selected class from all options
                document.querySelectorAll('.payment-option').forEach(option => {
                    option.classList.remove('selected');
                });
                
                // Add selected class to current option
                this.closest('.payment-option').classList.add('selected');
            });
        });

        // Initialize selected payment method
        document.querySelector('input[name="payment_method"]:checked').closest('.payment-option').classList.add('selected');
    </script>
</body>
</html>