<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - CraftsHub</title>
<style>
/* Price breakdown below quantity in order summary */
.item-breakdown {
    font-size: 0.92em;
    color: #8d735c;
    background: #f8f6f4;
    border-radius: 6px;
    padding: 4px 10px;
    margin-top: 4px;
    display: inline-block;
    font-weight: 500;
    letter-spacing: 0.2px;
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
    color: #2D2D2D;
    font-weight: 600;
    margin-bottom: 10px;
}
.page-subtitle {
    color: #777;
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
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #86efac;
}
.alert-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fca5a5;
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
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}

.form-section {
    margin-bottom: 30px;
}
.form-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 1.2em;
    font-weight: 600;
    color: #2D2D2D;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f5f0eb;
}

.form-group {
    margin-bottom: 20px;
}
.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #2D2D2D;
    text-transform: uppercase;
    font-size: 0.9em;
    letter-spacing: 0.5px;
}
.form-input, .form-textarea, .form-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #E8D4C8;
    border-radius: 8px;
    font-size: 16px;
    background: #faf9f7;
    transition: all 0.3s;
}
.form-input:focus, .form-textarea:focus, .form-select:focus {
    outline: none;
    border-color: #D9967D;
    background: white;
    box-shadow: 0 0 0 3px rgba(217, 150, 125, 0.1);
}
.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.payment-options {
    display: grid;
    gap: 12px;
}
.payment-option {
    display: flex;
    align-items: center;
    padding: 16px;
    border: 2px solid #E8D4C8;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    background: white;
}
.payment-option:hover {
    border-color: #D9967D;
    background: #faf9f7;
}
.payment-option input[type="radio"] {
    margin-right: 12px;
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #D9967D;
}
.payment-option.selected {
    border-color: #D9967D;
    background: #faf9f7;
    box-shadow: 0 2px 8px rgba(217, 150, 125, 0.1);
}
.payment-option div strong {
    color: #2D2D2D;
}
.payment-option div small {
    color: #777;
}

/* Order Summary */
.order-summary {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    height: fit-content;
    position: sticky;
    top: 20px;
}
.summary-title {
    font-size: 1.3em;
    font-weight: 600;
    color: #2D2D2D;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f5f0eb;
}

.order-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f0ede8;
}
.order-item:last-child {
    border-bottom: none;
}
.item-image {
    width: 60px;
    height: 60px;
    background: linear-gradient(45deg, #E8A89B, #D9967D);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 12px;
    overflow: hidden;
    flex-shrink: 0;
    font-size: 1.5em;
}
.item-details {
    flex: 1;
}
.item-name {
    font-weight: 600;
    color: #2D2D2D;
    margin-bottom: 4px;
    font-size: 0.95em;
}
.item-quantity {
    color: #777;
    font-size: 0.85em;
}
.item-price {
    font-weight: 600;
    color: #D9967D;
    font-size: 1em;
}

.summary-totals {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 2px solid #f5f0eb;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #2D2D2D;
    font-size: 0.95em;
}
.summary-row.total {
    font-size: 1.2em;
    font-weight: 700;
    color: #2D2D2D;
    padding-top: 10px;
    border-top: 1px solid #f0ede8;
    margin-top: 10px;
}

/* Buttons */
.btn-group {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}
.btn {
    padding: 14px 28px;
    border: none;
    border-radius: 8px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.btn-primary {
    background: linear-gradient(135deg, #D9967D 0%, #C88A6F 100%);
    color: white;
    flex: 1;
    box-shadow: 0 4px 12px rgba(200, 138, 111, 0.2);
}
.btn-primary:hover {
    background: linear-gradient(135deg, #CE8A74 0%, #BD7E63 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(200, 138, 111, 0.3);
}
.btn-secondary {
    background: white;
    color: #D9967D;
    border: 2px solid #E8D4C8;
}
.btn-secondary:hover {
    background: #faf9f7;
    border-color: #D9967D;
    color: #C88A6F;
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
        <div class="logo">CraftsHub - Checkout</div>
        <div class="user-info">
            <span>Welcome, <?= htmlspecialchars($buyer_name) ?>!</span>
            <a href="/buyer/logout" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">Checkout</h1>
            <p class="page-subtitle">Review your order and complete your purchase</p>
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
                        <h3 class="section-title">Payment Method</h3>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash_on_delivery" checked>
                                <div>
                                    <strong>Cash on Delivery</strong><br>
                                    <small>Pay when your order arrives</small>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="GCASH">
                                <div>
                                    <strong>GCash</strong><br>
                                    <small>Pay securely using GCash (via PayMongo)</small>
                                </div>
                            </label>
                        </div>
                    </div>


                    <!-- Buttons -->
                    <div class="btn-group">
                        <a href="/buyer/cart" class="btn btn-secondary">Back to Cart</a>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="summary-title">Order Summary</h3>
                
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
                                <?php if($item->quantity > 1): ?>
                                    <div class="item-price" style="margin-top:2px;">
                                        ₱<?= number_format($item->price, 2) ?> x <?= $item->quantity ?> = ₱<?= number_format($item->price * $item->quantity, 2) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="item-price" style="margin-top:2px;">
                                        ₱<?= number_format($item->price, 2) ?>
                                    </div>
                                <?php endif; ?>
                        </div>
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