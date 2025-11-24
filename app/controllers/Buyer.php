<<<<<<< HEAD
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// PHPMailer namespace imports and autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../libraries/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../libraries/PHPMailer/SMTP.php';
require_once __DIR__ . '/../libraries/PHPMailer/Exception.php';

class Buyer extends Controller {
        /** 👁️ View Single Product */
        public function product($product_id = null) {
            $data['title'] = 'Product Details';
            $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
            $data['product'] = null;
            $data['reviews'] = [];
            $data['review_msg'] = null;
            if ($product_id) {
                $data['product'] = $this->Product->get_product($product_id);
                $reviews = $this->Product->get_reviews($product_id);
                // Attach reviewer name to each review
                $data['reviews'] = [];
                foreach ($reviews as $r) {
                    $user = $this->User->get_user($r->user_id);
                    $r->reviewer_name = $user ? ($user->full_name ?? 'User') : 'User';
                    $data['reviews'][] = $r;
                }
            }

            // Handle review submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_submit'])) {
                $rating = intval($_POST['rating'] ?? 0);
                $review = trim($_POST['review'] ?? '');
                $user_id = $_SESSION['buyer_id'] ?? null;
                if ($product_id && $user_id && $rating > 0 && $rating <= 5 && $review !== '') {
                    $this->Product->add_review($product_id, $user_id, $rating, $review);
                    $data['review_msg'] = 'Review submitted!';
                    // Refresh reviews
                    $data['reviews'] = $this->Product->get_reviews($product_id);
                } else {
                    $data['review_msg'] = 'Please provide a rating (1-5) and a review.';
                }
            }
            $this->call->view('buyer/product_view', $data);
        }
    /**
     * Customer Service page for buyers
     */
    public function customerService() {
        $msg = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';
            $buyer_name = $_SESSION['buyer_name'] ?? 'Buyer';
            $buyer_email = $_SESSION['buyer_email'] ?? '';

            // Get admin email from config
            $admin_email = $this->config->get('admin_email') ?? 'ascanlindon@gmail.com';

            // Prepare email body
            $email_subject = "[Customer Service] $subject";
            $email_body = "From: $buyer_name <$buyer_email><br><br>" . nl2br($message);

            // Handle file upload
            $attachment_path = null;
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                $attachment_path = $_FILES['attachment']['tmp_name'];
            }

            // Use notif_helper to send email
            require_once __DIR__ . '/../helpers/notif_helper.php';
            $result = notif_helper($admin_email, $email_subject, $email_body, $attachment_path);
            if ($result === true) {
                $msg = 'Your feedback has been sent successfully!';
            } else {
                $msg = $result;
            }
        }
        $data['msg'] = $msg;
        $this->call->view('buyer/customer-service', $data);
    }
    /**
     * Account Settings page for buyers
     */
    public function accountSettings() {
        $buyer_id = $_SESSION['buyer_id'];
        $msg = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';
            $password = $_POST['password'] ?? '';

            $update_data = [
                'full_name' => $full_name,
                'email' => $email,
                'phone_number' => $phone_number
            ];
            if (!empty($password)) {
                $update_data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->User->update_user($buyer_id, $update_data);
            $_SESSION['buyer_name'] = $full_name;
            $msg = 'Account updated successfully!';
        }
        $buyer = $this->User->get_user($buyer_id);
        $data['buyer'] = $buyer;
        $data['title'] = 'Account Settings';
        if ($msg) $data['msg'] = $msg;
        $this->call->view('buyer/account-settings', $data);
    }

    public function __construct() {
        parent::__construct();
        
        // Start session for authentication
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if buyer is logged in
        if (!isset($_SESSION['buyer_logged_in']) || $_SESSION['buyer_logged_in'] !== true) {
            $_SESSION['error_message'] = 'Please login to access your dashboard.';
            redirect('/login');
        }
        
        // Load models
        $this->call->model('User');
        $this->call->model('Product');
        $this->call->model('Cart');
        
        // Load PayMongo library
        $this->call->library('PayMongo');
    }

    /** 🏠 Buyer Dashboard */
    public function dashboard() {
        $data['title'] = 'Buyer Dashboard';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        
        // Get cart items count
        $buyer_id = $_SESSION['buyer_id'];
        $cart_items = $this->Cart->get_cart_by_buyer($buyer_id);
        $data['cart_count'] = count($cart_items);
        
        // Automatically load products for the dashboard
        $data['products'] = $this->Product->get_all_products();
        
        $this->call->view('buyer/dashboard', $data);
    }

    /** �️ View Products */
    public function products() {
        $data['title'] = 'Browse Products';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        
        // Get all products from database
        $data['products'] = $this->Product->get_all_products();
        
        $this->call->view('buyer/products', $data);
    }

    /** 📦 View Orders */
    public function orders() {
        $data['title'] = 'My Orders';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        
        // Load Order and OrderItem models
        $this->call->model('Order');
        $this->call->model('OrderItem');
        
        // Get orders for current buyer
        $buyer_id = $_SESSION['buyer_id'];
        $orders = $this->Order->get_orders_by_buyer($buyer_id);
        
        // Get order items for each order
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $order->items = $this->OrderItem->get_order_items_by_order($order->id);
            }
        }
        
        $data['orders'] = $orders;
        
        $this->call->view('buyer/orders', $data);
    }

    /** � View Cart */
    public function cart() {
        $data['title'] = 'My Cart';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        
        // Get cart items for current buyer
        $buyer_id = $_SESSION['buyer_id'];
        $data['cart_items'] = $this->Cart->get_cart_by_buyer($buyer_id);
        
        // Calculate cart totals
        $total = 0;
        if (!empty($data['cart_items'])) {
            foreach ($data['cart_items'] as $item) {
                $total += ($item->price * $item->quantity);
            }
        }
        $data['cart_total'] = $total;
        
        $this->call->view('buyer/cart', $data);
    }

    /** 🛒 Add to Cart */
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            $buyer_id = $_SESSION['buyer_id'];
            
            if ($product_id > 0) {
                // Check if item already exists in cart
                $existing_item = $this->Cart->check_existing_cart_item($buyer_id, $product_id);
                
                if ($existing_item) {
                    // Update quantity
                    $new_quantity = $existing_item->quantity + $quantity;
                    $this->Cart->update_cart_item($existing_item->cart_id, ['quantity' => $new_quantity]);
                    $_SESSION['success_message'] = 'Cart updated successfully!';
                } else {
                    // Add new item
                    $cart_data = [
                        'buyer_id' => $buyer_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity
                    ];
                    $this->Cart->add_to_cart($cart_data);
                    $_SESSION['success_message'] = 'Product added to cart!';
                }
            } else {
                $_SESSION['error_message'] = 'Invalid product.';
            }
        }
        
        redirect('/buyer/cart');
    }

    /** 🗑️ Remove from Cart */
    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_id = $_POST['cart_id'] ?? 0;
            
            if ($cart_id > 0) {
                $this->Cart->remove_from_cart($cart_id);
                $_SESSION['success_message'] = 'Item removed from cart!';
            } else {
                $_SESSION['error_message'] = 'Invalid cart item.';
            }
        }
        
        redirect('/buyer/cart');
    }

    /** 🔄 Update Cart */
    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_id = $_POST['cart_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            
            if ($cart_id > 0 && $quantity > 0) {
                $this->Cart->update_cart_item($cart_id, ['quantity' => $quantity]);
                $_SESSION['success_message'] = 'Cart updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Invalid cart update.';
            }
        }
        
        redirect('/buyer/cart');
    }

    /** 💳 Checkout Process */
    public function checkout() {
        // Load Order and OrderItem models
        $this->call->model('Order');
        $this->call->model('OrderItem');
        
        $buyer_id = $_SESSION['buyer_id'];
        
        // Get cart items for current buyer
        $cart_items = $this->Cart->get_cart_by_buyer($buyer_id);
        
        if (empty($cart_items)) {
            $_SESSION['error_message'] = 'Your cart is empty. Add some products before checkout.';
            redirect('/buyer/cart');
            return;
        }
        
        // Calculate total
        $total_amount = 0;
        foreach ($cart_items as $item) {
            $total_amount += ($item->price * $item->quantity);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process checkout
            $shipping_address = $_POST['shipping_address'] ?? '';
            $payment_method = $_POST['payment_method'] ?? 'cash_on_delivery';
            if (empty($shipping_address)) {
                $_SESSION['error_message'] = 'Please provide a shipping address.';
            } else {
                // Handle GCash payment
                if ($payment_method === 'GCASH') {
                    // Store checkout data in session
                    $_SESSION['pending_order'] = [
                        'buyer_id' => $buyer_id,
                        'shipping_address' => $shipping_address,
                        'payment_method' => $payment_method,
                        'total_amount' => $total_amount,
                        'cart_items' => $cart_items
                    ];
                    // Redirect to GCash payment
                    redirect('/buyer/payment/gcash');
                    return;
                }

                // Create order data for COD
                $order_data = [
                    'buyer_id' => $buyer_id,
                    'order_number' => 'ORD-' . time() . '-' . $buyer_id,
                    'status' => 'pending',
                    'grand_total' => $total_amount,
                    'shipping_address' => $shipping_address,
                    'payment_method' => $payment_method,
                    'payment_status' => 'pending',
                    'order_date' => date('Y-m-d H:i:s')
                ];

                // Create order and order items
                $order_id = $this->processCheckout($order_data, $cart_items);

                if ($order_id) {
                    // Clear cart after successful checkout
                    $this->Cart->clear_cart($buyer_id);

                    // Send Gmail notification to buyer
                    require_once __DIR__ . '/../../vendor/autoload.php';
                    $buyer_email = $_SESSION['buyer_email'] ?? '';
                    if (!empty($buyer_email)) {
                        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'ascanlindon@gmail.com';
                            $mail->Password = 'mlmg podg gfnj sszf';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->setFrom('ascanlindon@gmail.com', 'CraftsHub');
                            $mail->addAddress($buyer_email);
                            $mail->Subject = 'Order Confirmation - CraftsHub';

                            // Build order items table
                            $items_html = "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;'>";
                            $items_html .= "<tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr>";
                            foreach ($cart_items as $item) {
                                $items_html .= "<tr>"
                                    . "<td>" . htmlspecialchars($item->product_name) . "</td>"
                                    . "<td>" . $item->quantity . "</td>"
                                    . "<td>₱" . number_format($item->price, 2) . "</td>"
                                    . "<td>₱" . number_format($item->price * $item->quantity, 2) . "</td>"
                                    . "</tr>";
                            }
                            $items_html .= "</table>";

                            $mail->isHTML(true);
                            $mail->Body =
                                "<h2>Thank you for your order!</h2>"
                                . "<p>Your order ID is <strong>#{$order_id}</strong>.</p>"
                                . "<h3>Order Details:</h3>"
                                . $items_html
                                . "<p><strong>Total: ₱" . number_format($total_amount, 2) . "</strong></p>"
                                . "<p>We will process your order and notify you once it ships.</p>";
                            $mail->send();
                        } catch (Exception $e) {
                            error_log('Mail error: ' . $mail->ErrorInfo);
                        }
                    }

                    $_SESSION['success_message'] = 'Order placed successfully! Order ID: #' . $order_id;
                    redirect('/buyer/orders');
                } else {
                    $_SESSION['error_message'] = 'Failed to process your order. Please try again.';
                }
            }
        }
        
        // Prepare data for checkout view
        $data['title'] = 'Checkout';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        $data['cart_items'] = $cart_items;
        $data['cart_total'] = $total_amount;
        
        $this->call->view('buyer/checkout', $data);
    }
    
    /** 🔄 Process Checkout Helper */
    private function processCheckout($order_data, $cart_items) {
        try {
            // Debug: Log order data
            error_log("Processing checkout with order data: " . json_encode($order_data));
            
            // STEP 1: Validate stock availability for all items before proceeding
            foreach ($cart_items as $item) {
                if (!$this->Product->has_sufficient_stock($item->product_id, $item->quantity)) {
                    $product = $this->Product->get_product($item->product_id);
                    $available_stock = $product ? $product->stock : 0;
                    $_SESSION['error_message'] = "Insufficient stock for '{$item->product_name}'. Available: {$available_stock}, Requested: {$item->quantity}";
                    return false;
                }
            }
            
            // STEP 2: Create the main order
            $order_id = $this->Order->create_order($order_data);
            
            if ($order_id) {
                error_log("Order created successfully with ID: " . $order_id);
                
                // STEP 3: Process each cart item and deduct inventory
                $item_count = 0;
                $inventory_deducted = []; // Track what we've deducted for rollback if needed
                
                foreach ($cart_items as $item) {
                    try {
                        // Deduct stock first
                        if ($this->Product->deduct_stock($item->product_id, $item->quantity)) {
                            // Log inventory movement
                            $this->Product->log_inventory_movement(
                                $item->product_id,
                                'sale',
                                $item->quantity,
                                "Order ID: {$order_id}"
                            );
                            
                            // Track successful deduction
                            $inventory_deducted[] = [
                                'product_id' => $item->product_id,
                                'quantity' => $item->quantity
                            ];
                            
                            // Create order item
                            $order_item_data = [
                                'order_id' => $order_id,
                                'product_id' => $item->product_id,
                                'product_name' => $item->product_name,
                                'product_description' => $item->description ?? '',
                                'unit_price' => $item->price,
                                'quantity' => $item->quantity,
                                'total_price' => $item->price * $item->quantity,
                                'product_image' => $item->image_url ?? ''
                            ];
                            
                            error_log("Creating order item: " . json_encode($order_item_data));
                            
                            if ($this->OrderItem->create_order_item($order_item_data)) {
                                $item_count++;
                                error_log("Order item created successfully for product ID: " . $item->product_id);
                            } else {
                                error_log("Failed to create order item for product ID: " . $item->product_id);
                                
                                // Rollback inventory deduction for this item
                                $this->Product->add_stock($item->product_id, $item->quantity);
                                
                                $_SESSION['error_message'] = 'Failed to create order item for product: ' . $item->product_name;
                                
                                // Rollback all previously deducted inventory
                                $this->rollbackInventoryDeductions($inventory_deducted, $order_id);
                                return false;
                            }
                        } else {
                            error_log("Failed to deduct stock for product ID: " . $item->product_id);
                            $_SESSION['error_message'] = 'Failed to update inventory for product: ' . $item->product_name;
                            
                            // Rollback all previously deducted inventory
                            $this->rollbackInventoryDeductions($inventory_deducted, $order_id);
                            return false;
                        }
                        
                    } catch (Exception $e) {
                        error_log("Error processing item {$item->product_id}: " . $e->getMessage());
                        $_SESSION['error_message'] = 'Error processing ' . $item->product_name . ': ' . $e->getMessage();
                        
                        // Rollback all previously deducted inventory
                        $this->rollbackInventoryDeductions($inventory_deducted, $order_id);
                        return false;
                    }
                }
                
                error_log("Created $item_count order items successfully with inventory deduction");
                error_log("Inventory deducted for order {$order_id}: " . json_encode($inventory_deducted));
                
                return $order_id;
            } else {
                error_log("Failed to create order");
                $_SESSION['error_message'] = 'Failed to create order in database.';
                return false;
            }
            
        } catch (Exception $e) {
            error_log("Checkout error: " . $e->getMessage());
            $_SESSION['error_message'] = 'Checkout error: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Rollback inventory deductions if checkout fails
     */
    private function rollbackInventoryDeductions($inventory_deducted, $order_id) {
        try {
            error_log("Rolling back inventory deductions for order {$order_id}");
            
            foreach ($inventory_deducted as $deduction) {
                $this->Product->add_stock($deduction['product_id'], $deduction['quantity']);
                
                // Log the rollback
                $this->Product->log_inventory_movement(
                    $deduction['product_id'],
                    'adjustment',
                    $deduction['quantity'],
                    "Rollback for failed order ID: {$order_id}"
                );
                
                error_log("Rolled back {$deduction['quantity']} units for product ID {$deduction['product_id']}");
            }
            
        } catch (Exception $e) {
            error_log("Error during inventory rollback: " . $e->getMessage());
        }
    }

    /** 📋 Get Order Items (AJAX) */
    public function getOrderItems() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? 0;
            $buyer_id = $_SESSION['buyer_id'];
            
            if ($order_id > 0) {
                // Load OrderItem model
                $this->call->model('OrderItem');
                $this->call->model('Order');
                
                // Verify order belongs to current buyer
                $order = $this->Order->get_order($order_id);
                if (!$order || $order->buyer_id != $buyer_id) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Order not found or access denied'
                    ]);
                    return;
                }
                
                // Get order items
                $items = $this->OrderItem->get_order_items_by_order($order_id);
                
                if ($items) {
                    echo json_encode([
                        'success' => true,
                        'items' => $items
                    ]);
                } else {
                    echo json_encode([
                        'success' => true,
                        'items' => []
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid order ID'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
    }

    /** ❌ Cancel Order */
    public function cancelOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? 0;
            $buyer_id = $_SESSION['buyer_id'];
            
            if ($order_id > 0) {
                // Load Order model
                $this->call->model('Order');
                
                // Verify order belongs to current buyer and is cancellable
                $order = $this->Order->get_order($order_id);
                
                if (!$order || $order->buyer_id != $buyer_id) {
                    $_SESSION['error_message'] = 'Order not found or access denied.';
                } elseif (strtolower($order->status) !== 'pending') {
                    $_SESSION['error_message'] = 'Only pending orders can be cancelled.';
                } else {
                    // Update order status to cancelled
                    $update_data = [
                        'status' => 'cancelled'
                    ];
                    
                    if ($this->Order->update_order($order_id, $update_data)) {
                        // Optional: Restore product stock
                        $this->restoreProductStock($order_id);
                        
                        $_SESSION['success_message'] = 'Order #' . ($order->order_number ?? $order_id) . ' has been cancelled successfully.';
                    } else {
                        $_SESSION['error_message'] = 'Failed to cancel the order. Please try again.';
                    }
                }
            } else {
                $_SESSION['error_message'] = 'Invalid order ID.';
            }
        } else {
            $_SESSION['error_message'] = 'Invalid request method.';
        }
        
        redirect('/buyer/orders');
    }

    /** 🔄 Restore Product Stock Helper */
    private function restoreProductStock($order_id) {
        try {
            // Load models
            $this->call->model('OrderItem');
            
            // Get order items
            $order_items = $this->OrderItem->get_order_items_by_order($order_id);
            
            if (!empty($order_items)) {
                foreach ($order_items as $item) {
                    // Get current product stock
                    $product = $this->Product->get_product($item->product_id);
                    
                    if ($product) {
                        // Restore stock
                        $new_stock = $product->stock + $item->quantity;
                        $this->Product->update_product($item->product_id, ['stock' => $new_stock]);
                        
                        error_log("Restored {$item->quantity} units to product ID {$item->product_id}. New stock: {$new_stock}");
                    }
                }
            }
        } catch (Exception $e) {
            error_log("Error restoring product stock for order {$order_id}: " . $e->getMessage());
        }
    }

    /** ⚡ Buy Now - Add to cart and redirect to checkout */
    public function buyNow() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            $buyer_id = $_SESSION['buyer_id'];
            
            if ($product_id > 0 && $quantity > 0) {
                try {
                    // Validate product exists and has sufficient stock
                    $product = $this->Product->get_product($product_id);
                    
                    if (!$product) {
                        $_SESSION['error_message'] = 'Product not found.';
                        redirect('/buyer/dashboard');
                        return;
                    }
                    
                    if ($product->stock < $quantity) {
                        $_SESSION['error_message'] = "Insufficient stock. Only {$product->stock} units available.";
                        redirect('/buyer/dashboard');
                        return;
                    }
                    
                    if ($product->stock == 0) {
                        $_SESSION['error_message'] = 'This product is currently out of stock.';
                        redirect('/buyer/dashboard');
                        return;
                    }
                    
                    // Clear existing cart for "buy now" (instant purchase)
                    $this->Cart->clear_cart($buyer_id);
                    
                    // Add product to cart
                    $cart_data = [
                        'buyer_id' => $buyer_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity
                    ];
                    
                    if ($this->Cart->add_to_cart($cart_data)) {
                        // Set a session flag to indicate this is a "buy now" transaction
                        $_SESSION['buy_now_mode'] = true;
                        $_SESSION['success_message'] = 'Product added! Complete your purchase below.';
                        
                        // Redirect directly to checkout
                        redirect('/buyer/checkout');
                    } else {
                        $_SESSION['error_message'] = 'Failed to process your request. Please try again.';
                        redirect('/buyer/dashboard');
                    }
                    
                } catch (Exception $e) {
                    error_log("Buy Now error: " . $e->getMessage());
                    $_SESSION['error_message'] = 'An error occurred. Please try again.';
                    redirect('/buyer/dashboard');
                }
            } else {
                $_SESSION['error_message'] = 'Invalid product or quantity.';
                redirect('/buyer/dashboard');
            }
        } else {
            $_SESSION['error_message'] = 'Invalid request method.';
            redirect('/buyer/dashboard');
        }
    }

    /** 💳 Process GCash Payment */
    public function processGCashPayment() {
        // Check if pending order exists
        if (!isset($_SESSION['pending_order'])) {
            $_SESSION['error_message'] = 'No pending order found. Please try again.';
            redirect('/buyer/checkout');
            return;
        }
        
        $pending_order = $_SESSION['pending_order'];
        $amount = $pending_order['total_amount'];
        
        // Convert amount to centavos (PayMongo requires amount in centavos)
        $amount_in_centavos = $amount * 100;
        
        // Create GCash source
        $result = $this->PayMongo->createGCashSource($amount_in_centavos);
        
        if ($result['success']) {
            // Store source ID in session
            $_SESSION['payment_source_id'] = $result['source_id'];
            
            // Redirect to GCash payment page
            header('Location: ' . $result['redirect_url']);
            exit;
        } else {
            $_SESSION['error_message'] = 'Failed to initiate GCash payment: ' . $result['message'];
            redirect('/buyer/checkout');
        }
    }

    /** ✅ GCash Payment Success Callback */
    public function gcashSuccess() {
        // Verify source ID exists
        if (!isset($_SESSION['payment_source_id']) || !isset($_SESSION['pending_order'])) {
            $_SESSION['error_message'] = 'Invalid payment session. Please try again.';
            redirect('/buyer/checkout');
            return;
        }
        
        $source_id = $_SESSION['payment_source_id'];
        $pending_order = $_SESSION['pending_order'];
        
        // Retrieve source to verify payment status
        $result = $this->PayMongo->retrieveSource($source_id);
        
        if ($result['success']) {
            $status = $result['status'];
            
            // Handle different payment statuses
            if ($status === 'chargeable') {
                // Payment authorized, create charge
                $payment_result = $this->PayMongo->createPayment($source_id, $pending_order['total_amount'] * 100);
                
                if ($payment_result['success']) {
                    // Load Order and OrderItem models
                    $this->call->model('Order');
                    $this->call->model('OrderItem');
                    
                    // Create order data
                    $order_data = [
                        'buyer_id' => $pending_order['buyer_id'],
                        'order_number' => 'ORD-' . time() . '-' . $pending_order['buyer_id'],
                        'status' => 'pending',
                        'grand_total' => $pending_order['total_amount'],
                        'shipping_address' => $pending_order['shipping_address'],
                        'payment_method' => 'GCASH',
                        'payment_status' => 'paid',
                        'payment_reference' => $payment_result['payment_id'],
                        'order_date' => date('Y-m-d H:i:s')
                    ];
                    
                    // Create order and order items
                    $order_id = $this->processCheckout($order_data, $pending_order['cart_items']);
                    
                    if ($order_id) {
                        // Clear cart and session
                        $this->Cart->clear_cart($pending_order['buyer_id']);
                        unset($_SESSION['pending_order']);
                        unset($_SESSION['payment_source_id']);

                        // Record revenue for today
                        $this->call->model('Revenue');
                        $today = date('Y-m-d');
                        $amount = $pending_order['total_amount'];
                        $existing = $this->Revenue->db->table('revenue')->where('date', $today)->get(PDO::FETCH_OBJ);
                        if ($existing) {
                            // Update today's revenue
                            $new_sales = $existing->daily_sales + $amount;
                            $this->Revenue->db->table('revenue')->where('date', $today)->update(['daily_sales' => $new_sales]);
                        } else {
                            // Insert new revenue record for today
                            $this->Revenue->db->table('revenue')->insert([
                                'date' => $today,
                                'daily_sales' => $amount
                            ]);
                        }

                        $_SESSION['success_message'] = '✅ Payment successful! Order ID: #' . $order_id;
                        redirect('/buyer/orders');
                    } else {
                        // Log the error for debugging
                        error_log("GCash Order Creation Failed - Pending Order Data: " . json_encode($pending_order));
                        error_log("GCash Order Creation Failed - Cart Items Count: " . count($pending_order['cart_items']));
                        
                        $_SESSION['error_message'] = 'Payment successful but order creation failed. Order will be processed manually. Payment ID: ' . $payment_result['payment_id'];
                        redirect('/buyer/dashboard');
                    }
                } else {
                    $_SESSION['error_message'] = 'Payment processing failed: ' . $payment_result['message'];
                    redirect('/buyer/checkout');
                }
            } elseif ($status === 'pending') {
                // Payment still processing - show waiting page or retry
                $_SESSION['info_message'] = '⏳ Payment is being processed. Please wait...';
                
                // Retry after a short delay (reload the page)
                echo '<!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="refresh" content="3;url=/buyer/payment/gcash-success">
                    <title>Processing Payment...</title>
                    <style>
                        body { font-family: Arial; text-align: center; padding: 50px; background: #f5f5f5; }
                        .spinner { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; 
                                   border-radius: 50%; width: 50px; height: 50px; 
                                   animation: spin 1s linear infinite; margin: 20px auto; }
                        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
                    </style>
                </head>
                <body>
                    <h2>⏳ Processing Your Payment...</h2>
                    <div class="spinner"></div>
                    <p>Please wait while we verify your GCash payment.</p>
                    <p><small>This page will automatically refresh in 3 seconds...</small></p>
                </body>
                </html>';
                exit;
            } elseif ($status === 'paid') {
                // Already paid - redirect to create order
                $_SESSION['success_message'] = '✅ Payment already completed!';
                redirect('/buyer/orders');
            } else {
                // Failed, cancelled, or expired
                $_SESSION['error_message'] = '❌ Payment ' . $status . '. Please try again.';
                redirect('/buyer/checkout');
            }
        } else {
            $_SESSION['error_message'] = 'Payment verification failed. Please try again.';
            redirect('/buyer/checkout');
        }
    }

    /** ❌ GCash Payment Failed Callback */
    public function gcashFailed() {
        // Clear payment session
        unset($_SESSION['payment_source_id']);
        
        $_SESSION['error_message'] = '❌ Payment cancelled or failed. Please try again.';
        redirect('/buyer/checkout');
    }

    /** 🚪 Logout */
    public function logout() {
        // Clear buyer session
        unset($_SESSION['buyer_logged_in']);
        unset($_SESSION['buyer_id']);
        unset($_SESSION['buyer_name']);
        unset($_SESSION['buyer_email']);
        
        $_SESSION['success_message'] = 'You have been logged out successfully.';
        redirect('/login');
    }
=======
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// PHPMailer namespace imports and autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../libraries/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../libraries/PHPMailer/SMTP.php';
require_once __DIR__ . '/../libraries/PHPMailer/Exception.php';

class Buyer extends Controller {
        /** 👁️ View Single Product */
        public function product($product_id = null) {
            $data['title'] = 'Product Details';
            $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
            $data['product'] = null;
            $data['reviews'] = [];
            $data['review_msg'] = null;
            if ($product_id) {
                $data['product'] = $this->Product->get_product($product_id);
                $reviews = $this->Product->get_reviews($product_id);
                // Attach reviewer name to each review
                $data['reviews'] = [];
                foreach ($reviews as $r) {
                    $user = $this->User->get_user($r->user_id);
                    $r->reviewer_name = $user ? ($user->full_name ?? 'User') : 'User';
                    $data['reviews'][] = $r;
                }
            }

            // Handle review submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_submit'])) {
                $rating = intval($_POST['rating'] ?? 0);
                $review = trim($_POST['review'] ?? '');
                $user_id = $_SESSION['buyer_id'] ?? null;
                if ($product_id && $user_id && $rating > 0 && $rating <= 5 && $review !== '') {
                    $this->Product->add_review($product_id, $user_id, $rating, $review);
                    $data['review_msg'] = 'Review submitted!';
                    // Refresh reviews
                    $data['reviews'] = $this->Product->get_reviews($product_id);
                } else {
                    $data['review_msg'] = 'Please provide a rating (1-5) and a review.';
                }
            }
            $this->call->view('buyer/product_view', $data);
        }
    /**
     * Customer Service page for buyers
     */
    public function customerService() {
        $msg = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';
            $buyer_name = $_SESSION['buyer_name'] ?? 'Buyer';
            $buyer_email = $_SESSION['buyer_email'] ?? '';

            // Get admin email from config
            $admin_email = $this->config->get('admin_email') ?? 'ascanlindon@gmail.com';

            // Prepare email body
            $email_subject = "[Customer Service] $subject";
            $email_body = "From: $buyer_name <$buyer_email><br><br>" . nl2br($message);

            // Handle file upload
            $attachment_path = null;
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                $attachment_path = $_FILES['attachment']['tmp_name'];
            }

            // Use notif_helper to send email
            require_once __DIR__ . '/../helpers/notif_helper.php';
            $result = notif_helper($admin_email, $email_subject, $email_body, $attachment_path);
            if ($result === true) {
                $msg = 'Your feedback has been sent successfully!';
            } else {
                $msg = $result;
            }
        }
        $data['msg'] = $msg;
        $this->call->view('buyer/customer-service', $data);
    }
    /**
     * Account Settings page for buyers
     */
    public function accountSettings() {
        $buyer_id = $_SESSION['buyer_id'];
        $msg = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';
            $password = $_POST['password'] ?? '';

            $update_data = [
                'full_name' => $full_name,
                'email' => $email,
                'phone_number' => $phone_number
            ];
            if (!empty($password)) {
                $update_data['password'] = $password; // Store as plain text (insecure)
            }

            $this->User->update_user($buyer_id, $update_data);
            $_SESSION['buyer_name'] = $full_name;
            $msg = 'Account updated successfully!';
        }
        $buyer = $this->User->get_user($buyer_id);
        $data['buyer'] = $buyer;
        $data['title'] = 'Account Settings';
        if ($msg) $data['msg'] = $msg;
        $this->call->view('buyer/account-settings', $data);
    }

    public function __construct() {
        parent::__construct();
        
        // Start session for authentication
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if buyer is logged in
        if (!isset($_SESSION['buyer_logged_in']) || $_SESSION['buyer_logged_in'] !== true) {
            $_SESSION['error_message'] = 'Please login to access your dashboard.';
            redirect('/login');
        }
        
        // Load models
        $this->call->model('User');
        $this->call->model('Product');
        $this->call->model('Cart');
        
        // Load PayMongo library
        $this->call->library('PayMongo');
    }

    /** 🏠 Buyer Dashboard */
    public function dashboard() {
        $data['title'] = 'Buyer Dashboard';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        
        // Get cart items count
        $buyer_id = $_SESSION['buyer_id'];
        $cart_items = $this->Cart->get_cart_by_buyer($buyer_id);
        $data['cart_count'] = count($cart_items);
        
        // Automatically load products for the dashboard
        $data['products'] = $this->Product->get_all_products();
        
        $this->call->view('buyer/dashboard', $data);
    }

    /** �️ View Products */
    public function products() {
        $data['title'] = 'Browse Products';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        
        // Get all products from database
        $data['products'] = $this->Product->get_all_products();
        
        $this->call->view('buyer/products', $data);
    }

    /** 📦 View Orders */
    public function orders() {
        $data['title'] = 'My Orders';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        
        // Load Order and OrderItem models
        $this->call->model('Order');
        $this->call->model('OrderItem');
        
        // Get orders for current buyer
        $buyer_id = $_SESSION['buyer_id'];
        $orders = $this->Order->get_orders_by_buyer($buyer_id);
        
        // Get order items for each order
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $order->items = $this->OrderItem->get_order_items_by_order($order->id);
            }
        }
        
        $data['orders'] = $orders;
        
        $this->call->view('buyer/orders', $data);
    }

    /** � View Cart */
    public function cart() {
        $data['title'] = 'My Cart';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        
        // Get cart items for current buyer
        $buyer_id = $_SESSION['buyer_id'];
        $data['cart_items'] = $this->Cart->get_cart_by_buyer($buyer_id);
        
        // Calculate cart totals
        $total = 0;
        if (!empty($data['cart_items'])) {
            foreach ($data['cart_items'] as $item) {
                $total += ($item->price * $item->quantity);
            }
        }
        $data['cart_total'] = $total;
        
        $this->call->view('buyer/cart', $data);
    }

    /** 🛒 Add to Cart */
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            $buyer_id = $_SESSION['buyer_id'];
            
            if ($product_id > 0) {
                // Check if item already exists in cart
                $existing_item = $this->Cart->check_existing_cart_item($buyer_id, $product_id);
                
                if ($existing_item) {
                    // Update quantity
                    $new_quantity = $existing_item->quantity + $quantity;
                        // Check stock before updating
                        $product = $this->Product->get_product($product_id);
                        if (!$product) {
                            $_SESSION['error_message'] = 'Product not found.';
                            redirect('/buyer/cart');
                            return;
                        }
                        if ($new_quantity > $product->stock) {
                            $_SESSION['error_message'] = "Cannot add more than available stock. Available: {$product->stock}, Requested: {$new_quantity}";
                            redirect('/buyer/cart');
                            return;
                        }
                    $this->Cart->update_cart_item($existing_item->cart_id, ['quantity' => $new_quantity]);
                    $_SESSION['success_message'] = 'Cart updated successfully!';
                } else {
                    // Add new item
                        $product = $this->Product->get_product($product_id);
                        if (!$product) {
                            $_SESSION['error_message'] = 'Product not found.';
                            redirect('/buyer/cart');
                            return;
                        }
                        if ($quantity > $product->stock) {
                            $_SESSION['error_message'] = "Cannot add more than available stock. Available: {$product->stock}, Requested: {$quantity}";
                            redirect('/buyer/cart');
                            return;
                        }
                    $cart_data = [
                        'buyer_id' => $buyer_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity
                    ];
                    $this->Cart->add_to_cart($cart_data);
                    $_SESSION['success_message'] = 'Product added to cart!';
                }
            } else {
                $_SESSION['error_message'] = 'Invalid product.';
            }
        }
        
        redirect('/buyer/cart');
    }

    /** 🗑️ Remove from Cart */
    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_id = $_POST['cart_id'] ?? 0;
            
            if ($cart_id > 0) {
                $this->Cart->remove_from_cart($cart_id);
                $_SESSION['success_message'] = 'Item removed from cart!';
            } else {
                $_SESSION['error_message'] = 'Invalid cart item.';
            }
        }
        
        redirect('/buyer/cart');
    }

    /** 🔄 Update Cart */
    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_id = $_POST['cart_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            
            if ($cart_id > 0 && $quantity > 0) {
                $this->Cart->update_cart_item($cart_id, ['quantity' => $quantity]);
                $_SESSION['success_message'] = 'Cart updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Invalid cart update.';
            }
        }
        
        redirect('/buyer/cart');
    }

    /** 💳 Checkout Process */
    public function checkout() {
        // Load Order and OrderItem models
        $this->call->model('Order');
        $this->call->model('OrderItem');
        
        $buyer_id = $_SESSION['buyer_id'];
        
        // Get cart items for current buyer
        $cart_items = $this->Cart->get_cart_by_buyer($buyer_id);
        
        if (empty($cart_items)) {
            $_SESSION['error_message'] = 'Your cart is empty. Add some products before checkout.';
            redirect('/buyer/cart');
            return;
        }
        
        // Calculate total
        $total_amount = 0;
        foreach ($cart_items as $item) {
            $total_amount += ($item->price * $item->quantity);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process checkout
            $shipping_address = $_POST['shipping_address'] ?? '';
            $payment_method = $_POST['payment_method'] ?? 'cash_on_delivery';
            if (empty($shipping_address)) {
                $_SESSION['error_message'] = 'Please provide a shipping address.';
            } else {
                // Handle GCash payment
                if ($payment_method === 'GCASH') {
                    // Store checkout data in session
                    $_SESSION['pending_order'] = [
                        'buyer_id' => $buyer_id,
                        'shipping_address' => $shipping_address,
                        'payment_method' => $payment_method,
                        'total_amount' => $total_amount,
                        'cart_items' => $cart_items
                    ];
                    // Redirect to GCash payment
                    redirect('/buyer/payment/gcash');
                    return;
                }

                // Create order data for COD
                $order_data = [
                    'buyer_id' => $buyer_id,
                    'order_number' => 'ORD-' . time() . '-' . $buyer_id,
                    'status' => 'pending',
                    'grand_total' => $total_amount,
                    'shipping_address' => $shipping_address,
                    'payment_method' => $payment_method,
                    'payment_status' => 'pending',
                    'order_date' => date('Y-m-d H:i:s')
                ];

                // Create order and order items
                $order_id = $this->processCheckout($order_data, $cart_items);

                if ($order_id) {
                    // Clear cart after successful checkout
                    $this->Cart->clear_cart($buyer_id);

                    // Send Gmail notification to buyer
                    require_once __DIR__ . '/../../vendor/autoload.php';
                    $buyer_email = $_SESSION['buyer_email'] ?? '';
                    if (!empty($buyer_email)) {
                        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'ascanlindon@gmail.com';
                            $mail->Password = 'mlmg podg gfnj sszf';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->setFrom('ascanlindon@gmail.com', 'CraftsHub');
                            $mail->addAddress($buyer_email);
                            $mail->Subject = 'Order Confirmation - CraftsHub';

                            // Build order items table
                            $items_html = "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;'>";
                            $items_html .= "<tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr>";
                            foreach ($cart_items as $item) {
                                $items_html .= "<tr>"
                                    . "<td>" . htmlspecialchars($item->product_name) . "</td>"
                                    . "<td>" . $item->quantity . "</td>"
                                    . "<td>₱" . number_format($item->price, 2) . "</td>"
                                    . "<td>₱" . number_format($item->price * $item->quantity, 2) . "</td>"
                                    . "</tr>";
                            }
                            $items_html .= "</table>";

                            $mail->isHTML(true);
                            $mail->Body =
                                "<h2>Thank you for your order!</h2>"
                                . "<p>Your order ID is <strong>#{$order_id}</strong>.</p>"
                                . "<h3>Order Details:</h3>"
                                . $items_html
                                . "<p><strong>Total: ₱" . number_format($total_amount, 2) . "</strong></p>"
                                . "<p>We will process your order and notify you once it ships.</p>";
                            $mail->send();
                        } catch (Exception $e) {
                            error_log('Mail error: ' . $mail->ErrorInfo);
                        }
                    }

                    $_SESSION['success_message'] = 'Order placed successfully! Order ID: #' . $order_id;
                    redirect('/buyer/orders');
                } else {
                    $_SESSION['error_message'] = 'Failed to process your order. Please try again.';
                }
            }
        }
        
        // Prepare data for checkout view
        $data['title'] = 'Checkout';
        $data['buyer_name'] = $_SESSION['buyer_name'] ?? 'Buyer';
        $data['cart_items'] = $cart_items;
        $data['cart_total'] = $total_amount;
        
        $this->call->view('buyer/checkout', $data);
    }
    
    /** 🔄 Process Checkout Helper */
    private function processCheckout($order_data, $cart_items) {
        try {
            // Debug: Log order data
            error_log("Processing checkout with order data: " . json_encode($order_data));
            
            // STEP 1: Validate stock availability for all items before proceeding
            foreach ($cart_items as $item) {
                if (!$this->Product->has_sufficient_stock($item->product_id, $item->quantity)) {
                    $product = $this->Product->get_product($item->product_id);
                    $available_stock = $product ? $product->stock : 0;
                    $_SESSION['error_message'] = "Insufficient stock for '{$item->product_name}'. Available: {$available_stock}, Requested: {$item->quantity}";
                    return false;
                }
            }
            
            // STEP 2: Create the main order
            $order_id = $this->Order->create_order($order_data);
            
            if ($order_id) {
                error_log("Order created successfully with ID: " . $order_id);
                
                // STEP 3: Process each cart item and deduct inventory
                $item_count = 0;
                $inventory_deducted = []; // Track what we've deducted for rollback if needed
                
                foreach ($cart_items as $item) {
                    try {
                        // Deduct stock first
                        if ($this->Product->deduct_stock($item->product_id, $item->quantity)) {
                            // Log inventory movement
                            $this->Product->log_inventory_movement(
                                $item->product_id,
                                'sale',
                                $item->quantity,
                                "Order ID: {$order_id}"
                            );
                            
                            // Track successful deduction
                            $inventory_deducted[] = [
                                'product_id' => $item->product_id,
                                'quantity' => $item->quantity
                            ];
                            
                            // Create order item
                            $order_item_data = [
                                'order_id' => $order_id,
                                'product_id' => $item->product_id,
                                'product_name' => $item->product_name,
                                'product_description' => $item->description ?? '',
                                'unit_price' => $item->price,
                                'quantity' => $item->quantity,
                                'total_price' => $item->price * $item->quantity,
                                'product_image' => $item->image_url ?? ''
                            ];
                            
                            error_log("Creating order item: " . json_encode($order_item_data));
                            
                            if ($this->OrderItem->create_order_item($order_item_data)) {
                                $item_count++;
                                error_log("Order item created successfully for product ID: " . $item->product_id);
                            } else {
                                error_log("Failed to create order item for product ID: " . $item->product_id);
                                
                                // Rollback inventory deduction for this item
                                $this->Product->add_stock($item->product_id, $item->quantity);
                                
                                $_SESSION['error_message'] = 'Failed to create order item for product: ' . $item->product_name;
                                
                                // Rollback all previously deducted inventory
                                $this->rollbackInventoryDeductions($inventory_deducted, $order_id);
                                return false;
                            }
                        } else {
                            error_log("Failed to deduct stock for product ID: " . $item->product_id);
                            $_SESSION['error_message'] = 'Failed to update inventory for product: ' . $item->product_name;
                            
                            // Rollback all previously deducted inventory
                            $this->rollbackInventoryDeductions($inventory_deducted, $order_id);
                            return false;
                        }
                        
                    } catch (Exception $e) {
                        error_log("Error processing item {$item->product_id}: " . $e->getMessage());
                        $_SESSION['error_message'] = 'Error processing ' . $item->product_name . ': ' . $e->getMessage();
                        
                        // Rollback all previously deducted inventory
                        $this->rollbackInventoryDeductions($inventory_deducted, $order_id);
                        return false;
                    }
                }
                
                error_log("Created $item_count order items successfully with inventory deduction");
                error_log("Inventory deducted for order {$order_id}: " . json_encode($inventory_deducted));
                
                return $order_id;
            } else {
                error_log("Failed to create order");
                $_SESSION['error_message'] = 'Failed to create order in database.';
                return false;
            }
            
        } catch (Exception $e) {
            error_log("Checkout error: " . $e->getMessage());
            $_SESSION['error_message'] = 'Checkout error: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Rollback inventory deductions if checkout fails
     */
    private function rollbackInventoryDeductions($inventory_deducted, $order_id) {
        try {
            error_log("Rolling back inventory deductions for order {$order_id}");
            
            foreach ($inventory_deducted as $deduction) {
                $this->Product->add_stock($deduction['product_id'], $deduction['quantity']);
                
                // Log the rollback
                $this->Product->log_inventory_movement(
                    $deduction['product_id'],
                    'adjustment',
                    $deduction['quantity'],
                    "Rollback for failed order ID: {$order_id}"
                );
                
                error_log("Rolled back {$deduction['quantity']} units for product ID {$deduction['product_id']}");
            }
            
        } catch (Exception $e) {
            error_log("Error during inventory rollback: " . $e->getMessage());
        }
    }

    /** 📋 Get Order Items (AJAX) */
    public function getOrderItems() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? 0;
            $buyer_id = $_SESSION['buyer_id'];
            
            if ($order_id > 0) {
                // Load OrderItem model
                $this->call->model('OrderItem');
                $this->call->model('Order');
                
                // Verify order belongs to current buyer
                $order = $this->Order->get_order($order_id);
                if (!$order || $order->buyer_id != $buyer_id) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Order not found or access denied'
                    ]);
                    return;
                }
                
                // Get order items
                $items = $this->OrderItem->get_order_items_by_order($order_id);
                
                if ($items) {
                    echo json_encode([
                        'success' => true,
                        'items' => $items
                    ]);
                } else {
                    echo json_encode([
                        'success' => true,
                        'items' => []
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid order ID'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
    }

    /** ❌ Cancel Order */
    public function cancelOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? 0;
            $buyer_id = $_SESSION['buyer_id'];
            
            if ($order_id > 0) {
                // Load Order model
                $this->call->model('Order');
                
                // Verify order belongs to current buyer and is cancellable
                $order = $this->Order->get_order($order_id);
                
                if (!$order || $order->buyer_id != $buyer_id) {
                    $_SESSION['error_message'] = 'Order not found or access denied.';
                } elseif (strtolower($order->status) !== 'pending') {
                    $_SESSION['error_message'] = 'Only pending orders can be cancelled.';
                } else {
                    // Update order status to cancelled
                    $update_data = [
                        'status' => 'cancelled'
                    ];
                    
                    if ($this->Order->update_order($order_id, $update_data)) {
                        // Optional: Restore product stock
                        $this->restoreProductStock($order_id);
                        
                        $_SESSION['success_message'] = 'Order #' . ($order->order_number ?? $order_id) . ' has been cancelled successfully.';
                    } else {
                        $_SESSION['error_message'] = 'Failed to cancel the order. Please try again.';
                    }
                }
            } else {
                $_SESSION['error_message'] = 'Invalid order ID.';
            }
        } else {
            $_SESSION['error_message'] = 'Invalid request method.';
        }
        
        redirect('/buyer/orders');
    }

    /** 🔄 Restore Product Stock Helper */
    private function restoreProductStock($order_id) {
        try {
            // Load models
            $this->call->model('OrderItem');
            
            // Get order items
            $order_items = $this->OrderItem->get_order_items_by_order($order_id);
            
            if (!empty($order_items)) {
                foreach ($order_items as $item) {
                    // Get current product stock
                    $product = $this->Product->get_product($item->product_id);
                    
                    if ($product) {
                        // Restore stock
                        $new_stock = $product->stock + $item->quantity;
                        $this->Product->update_product($item->product_id, ['stock' => $new_stock]);
                        
                        error_log("Restored {$item->quantity} units to product ID {$item->product_id}. New stock: {$new_stock}");
                    }
                }
            }
        } catch (Exception $e) {
            error_log("Error restoring product stock for order {$order_id}: " . $e->getMessage());
        }
    }

    /** ⚡ Buy Now - Add to cart and redirect to checkout */
    public function buyNow() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            $buyer_id = $_SESSION['buyer_id'];
            
            if ($product_id > 0 && $quantity > 0) {
                try {
                    // Validate product exists and has sufficient stock
                    $product = $this->Product->get_product($product_id);
                    
                    if (!$product) {
                        $_SESSION['error_message'] = 'Product not found.';
                        redirect('/buyer/dashboard');
                        return;
                    }
                    
                    if ($product->stock < $quantity) {
                        $_SESSION['error_message'] = "Insufficient stock. Only {$product->stock} units available.";
                        redirect('/buyer/dashboard');
                        return;
                    }
                    
                    if ($product->stock == 0) {
                        $_SESSION['error_message'] = 'This product is currently out of stock.';
                        redirect('/buyer/dashboard');
                        return;
                    }
                    
                    // Clear existing cart for "buy now" (instant purchase)
                    $this->Cart->clear_cart($buyer_id);
                    
                    // Add product to cart
                    $cart_data = [
                        'buyer_id' => $buyer_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity
                    ];
                    
                    if ($this->Cart->add_to_cart($cart_data)) {
                        // Set a session flag to indicate this is a "buy now" transaction
                        $_SESSION['buy_now_mode'] = true;
                        $_SESSION['success_message'] = 'Product added! Complete your purchase below.';
                        
                        // Redirect directly to checkout
                        redirect('/buyer/checkout');
                    } else {
                        $_SESSION['error_message'] = 'Failed to process your request. Please try again.';
                        redirect('/buyer/dashboard');
                    }
                    
                } catch (Exception $e) {
                    error_log("Buy Now error: " . $e->getMessage());
                    $_SESSION['error_message'] = 'An error occurred. Please try again.';
                    redirect('/buyer/dashboard');
                }
            } else {
                $_SESSION['error_message'] = 'Invalid product or quantity.';
                redirect('/buyer/dashboard');
            }
        } else {
            $_SESSION['error_message'] = 'Invalid request method.';
            redirect('/buyer/dashboard');
        }
    }

    /** 💳 Process GCash Payment */
    public function processGCashPayment() {
        // Check if pending order exists
        if (!isset($_SESSION['pending_order'])) {
            $_SESSION['error_message'] = 'No pending order found. Please try again.';
            redirect('/buyer/checkout');
            return;
        }
        
        $pending_order = $_SESSION['pending_order'];
        $amount = $pending_order['total_amount'];
        
        // Convert amount to centavos (PayMongo requires amount in centavos)
        $amount_in_centavos = $amount * 100;
        
        // Create GCash source
        $result = $this->PayMongo->createGCashSource($amount_in_centavos);
        
        if ($result['success']) {
            // Store source ID in session
            $_SESSION['payment_source_id'] = $result['source_id'];
            
            // Redirect to GCash payment page
            header('Location: ' . $result['redirect_url']);
            exit;
        } else {
            $_SESSION['error_message'] = 'Failed to initiate GCash payment: ' . $result['message'];
            redirect('/buyer/checkout');
        }
    }

    /** ✅ GCash Payment Success Callback */
    public function gcashSuccess() {
        // Verify source ID exists
        if (!isset($_SESSION['payment_source_id']) || !isset($_SESSION['pending_order'])) {
            $_SESSION['error_message'] = 'Invalid payment session. Please try again.';
            redirect('/buyer/checkout');
            return;
        }
        
        $source_id = $_SESSION['payment_source_id'];
        $pending_order = $_SESSION['pending_order'];
        
        // Retrieve source to verify payment status
        $result = $this->PayMongo->retrieveSource($source_id);
        
        if ($result['success']) {
            $status = $result['status'];
            
            // Handle different payment statuses
            if ($status === 'chargeable') {
                // Payment authorized, create charge
                $payment_result = $this->PayMongo->createPayment($source_id, $pending_order['total_amount'] * 100);
                
                if ($payment_result['success']) {
                    // Load Order and OrderItem models
                    $this->call->model('Order');
                    $this->call->model('OrderItem');
                    
                    // Create order data
                    $order_data = [
                        'buyer_id' => $pending_order['buyer_id'],
                        'order_number' => 'ORD-' . time() . '-' . $pending_order['buyer_id'],
                        'status' => 'pending',
                        'grand_total' => $pending_order['total_amount'],
                        'shipping_address' => $pending_order['shipping_address'],
                        'payment_method' => 'GCASH',
                        'payment_status' => 'paid',
                        'payment_reference' => $payment_result['payment_id'],
                        'order_date' => date('Y-m-d H:i:s')
                    ];
                    
                    // Create order and order items
                    $order_id = $this->processCheckout($order_data, $pending_order['cart_items']);
                    
                    if ($order_id) {
                        // Clear cart and session
                        $this->Cart->clear_cart($pending_order['buyer_id']);
                        unset($_SESSION['pending_order']);
                        unset($_SESSION['payment_source_id']);

                        // Record revenue for today
                        $this->call->model('Revenue');
                        $today = date('Y-m-d');
                        $amount = $pending_order['total_amount'];
                        $existing = $this->Revenue->db->table('revenue')->where('date', $today)->get(PDO::FETCH_OBJ);
                        if ($existing) {
                            // Update today's revenue
                            $new_sales = $existing->daily_sales + $amount;
                            $this->Revenue->db->table('revenue')->where('date', $today)->update(['daily_sales' => $new_sales]);
                        } else {
                            // Insert new revenue record for today
                            $this->Revenue->db->table('revenue')->insert([
                                'date' => $today,
                                'daily_sales' => $amount
                            ]);
                        }

                        $_SESSION['success_message'] = '✅ Payment successful! Order ID: #' . $order_id;
                        redirect('/buyer/orders');
                    } else {
                        // Log the error for debugging
                        error_log("GCash Order Creation Failed - Pending Order Data: " . json_encode($pending_order));
                        error_log("GCash Order Creation Failed - Cart Items Count: " . count($pending_order['cart_items']));
                        
                        $_SESSION['error_message'] = 'Payment successful but order creation failed. Order will be processed manually. Payment ID: ' . $payment_result['payment_id'];
                        redirect('/buyer/dashboard');
                    }
                } else {
                    $_SESSION['error_message'] = 'Payment processing failed: ' . $payment_result['message'];
                    redirect('/buyer/checkout');
                }
            } elseif ($status === 'pending') {
                // Payment still processing - show waiting page or retry
                $_SESSION['info_message'] = '⏳ Payment is being processed. Please wait...';
                
                // Retry after a short delay (reload the page)
                echo '<!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="refresh" content="3;url=/buyer/payment/gcash-success">
                    <title>Processing Payment...</title>
                    <style>
                        body { font-family: Arial; text-align: center; padding: 50px; background: #f5f5f5; }
                        .spinner { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; 
                                   border-radius: 50%; width: 50px; height: 50px; 
                                   animation: spin 1s linear infinite; margin: 20px auto; }
                        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
                    </style>
                </head>
                <body>
                    <h2>⏳ Processing Your Payment...</h2>
                    <div class="spinner"></div>
                    <p>Please wait while we verify your GCash payment.</p>
                    <p><small>This page will automatically refresh in 3 seconds...</small></p>
                </body>
                </html>';
                exit;
            } elseif ($status === 'paid') {
                // Already paid - redirect to create order
                $_SESSION['success_message'] = '✅ Payment already completed!';
                redirect('/buyer/orders');
            } else {
                // Failed, cancelled, or expired
                $_SESSION['error_message'] = '❌ Payment ' . $status . '. Please try again.';
                redirect('/buyer/checkout');
            }
        } else {
            $_SESSION['error_message'] = 'Payment verification failed. Please try again.';
            redirect('/buyer/checkout');
        }
    }

    /** ❌ GCash Payment Failed Callback */
    public function gcashFailed() {
        // Clear payment session
        unset($_SESSION['payment_source_id']);
        
        $_SESSION['error_message'] = '❌ Payment cancelled or failed. Please try again.';
        redirect('/buyer/checkout');
    }

    /** 🚪 Logout */
    public function logout() {
        // Clear buyer session
        unset($_SESSION['buyer_logged_in']);
        unset($_SESSION['buyer_id']);
        unset($_SESSION['buyer_name']);
        unset($_SESSION['buyer_email']);
        
        $_SESSION['success_message'] = 'You have been logged out successfully.';
        redirect('/login');
    }
>>>>>>> da170f7 (sure to?)
}