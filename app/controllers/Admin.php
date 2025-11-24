    
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Admin extends Controller {

    public function __construct() {
        parent::__construct();

        // Start session for authentication
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            $_SESSION['error_message'] = 'Please login to access the admin dashboard.';
            redirect('/login');
        }

        // Load models
        $this->call->model('User');
        $this->call->model('Product');
        $this->call->model('Order');
        $this->call->model('Revenue');
        $this->call->model('Settings');
    }

    // Default dashboard page
    public function dashboard() {
        $data['title'] = 'Admin Dashboard';
        
        // Fetch real data from database
        $data['total_users'] = $this->User->count_total_users();
        $data['total_products'] = $this->Product->count_total_products();
        $data['orders_today'] = $this->Order->count_orders_today();
        
        // Get inventory statistics
        try {
            $inventory_stats = $this->Product->get_inventory_stats();
            $data['total_stock'] = $inventory_stats['total_stock'];
            $data['low_stock_count'] = $inventory_stats['low_stock_count'];
            $data['out_of_stock_count'] = $inventory_stats['out_of_stock_count'];
            $data['total_inventory_value'] = $inventory_stats['total_inventory_value'];
        } catch (Exception $e) {
            $data['total_stock'] = 0;
            $data['low_stock_count'] = 0;
            $data['out_of_stock_count'] = 0;
            $data['total_inventory_value'] = 0;
        }
        
        // Get revenue data (use Revenue model with fallback to orders)
        $revenue_stats = $this->Revenue->get_revenue_stats();
        $order_revenue = $this->Revenue->calculate_revenue_from_orders();
        
        // Use revenue table data if available, otherwise fallback to orders calculation
        $total_revenue = $revenue_stats['total'] > 0 ? $revenue_stats['total'] : $order_revenue['total_revenue'];
        $data['revenue'] = number_format($total_revenue, 2);
        
        // Additional revenue insights
        $data['today_revenue'] = number_format($revenue_stats['today'] > 0 ? $revenue_stats['today'] : $order_revenue['today_revenue'], 2);
        $data['weekly_revenue'] = number_format($revenue_stats['weekly'], 2);
        $data['monthly_revenue'] = number_format($revenue_stats['monthly'], 2);
        
        // Load the view
        $this->call->view('admin/dashboard', $data);
    }

     public function products() {
        $data['products'] = $this->Product->get_all_products(); // ✅ call model
        $this->call->view('admin/products', $data);
    }

    


    /** 💾 Update product */
    public function updateProduct($id = null) {
        // For POST requests, get product ID from form data
        // For GET requests, get product ID from URL parameter
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
        } else {
            $product_id = $id ?: segment(3);
        }
        
        // Ensure we have a product ID
        if (empty($product_id)) {
            show_404();
            return;
        }        
        
        // Get product data for display
        $data['product'] = $this->Product->get_product($product_id);
        
        // Check if product exists
        if (empty($data['product'])) {
            show_404();
            return;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $product_name = $_POST['product_name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $image_url = $_POST['image_url'] ?? '';
            
            $update_data = [
                'product_name' => $product_name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'image_url' => $image_url
            ];
            
            if (!empty($update_data)) {
                try {
                    $result = $this->Product->update_product($product_id, $update_data);
                    if ($result) {
                        // Set success message and redirect
                        $_SESSION['success_message'] = 'Product updated successfully!';
                        redirect('/admin/products');
                    } else {
                        $_SESSION['error_message'] = 'Failed to update product.';
                    }
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Error updating product: ' . $e->getMessage();
                }
            }
        }
        // Show edit form
        $this->call->view('admin/edit_products', $data);
    }

    // Handle order status update from admin
    public function update_order_status() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;
            if ($order_id && $status) {
                try {
                    $result = $this->Order->update_order($order_id, ['status' => $status]);
                    if ($result) {
                        $_SESSION['success_message'] = 'Order status updated successfully!';
                    } else {
                        $_SESSION['error_message'] = 'Failed to update order status.';
                    }
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Error: ' . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = 'Invalid order or status.';
            }
            redirect('/admin/orders');
        } else {
            show_404();
        }
    }

    /** ➕ Add new product */
    public function addProduct() {
        // Start session for messages
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $product_name = $_POST['product_name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $image_url = $_POST['image_url'] ?? '';
            
            $product_data = [
                'product_name' => $product_name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'image_url' => $image_url
            ];
            
            if (!empty($product_name) && !empty($description)) {
                try {
                    $result = $this->Product->create_product($product_data);
                    if ($result) {
                        $_SESSION['success_message'] = 'Product added successfully!';
                        redirect('/admin/products');
                    } else {
                        $_SESSION['error_message'] = 'Failed to add product.';
                    }
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Error adding product: ' . $e->getMessage();
                }
            } else {
                $_SESSION['error_message'] = 'Product name and description are required.';
            }
        }
        
        // Show add form
        $this->call->view('admin/add_product');
    }

    /** 🗑️ Delete product */
    public function deleteProduct() {
        $id = $this->io->post('product_id');
        $this->Product->delete_product($id);
        redirect('/admin/products');
    }

    //user ui
    public function users() {
        $data['users'] = $this->User->get_all_users();
        $this->call->view('admin/users', $data);
    }

    /**
     * Delete user - Remove user from database
     */
    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buyer_id'])) {
            $buyer_id = $_POST['buyer_id'];
            
            try {
                // Check if user exists before deletion
                $user = $this->User->get_user($buyer_id);
                if ($user) {
                    // Delete the user
                    $result = $this->User->delete_user($buyer_id);
                    
                    if ($result) {
                        $_SESSION['success_message'] = 'User deleted successfully.';
                    } else {
                        $_SESSION['error_message'] = 'Failed to delete user.';
                    }
                } else {
                    $_SESSION['error_message'] = 'User not found.';
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error deleting user: ' . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = 'Invalid request.';
        }
        
        redirect('/admin/users');
    }



    // Example: go to orders page
    public function orders() {
        $data['orders'] = $this->Order->get_all_orders();
        $this->call->view('admin/orders', $data);
    }

    /**
     * Revenue Dashboard - Display revenue analytics and management
     */
    public function revenue() {
        $data['title'] = 'Revenue Management';
        
        try {
            // Try to get revenue statistics using simple method first
            $revenue_stats = $this->Revenue->get_simple_revenue_stats();
            $data['today_revenue'] = number_format($revenue_stats['today'], 2);
            $data['total_revenue'] = number_format($revenue_stats['total'], 2);
            $data['monthly_revenue'] = number_format($revenue_stats['monthly'], 2);
            $data['weekly_revenue'] = number_format($revenue_stats['weekly'], 2);

            // Get recent revenue transactions (with error handling)
            try {
                $data['recent_transactions'] = $this->Revenue->get_recent_transactions(10);
            } catch (Exception $e) {
                $data['recent_transactions'] = [];
            }

            // Get revenue trends for chart (with error handling)
            try {
                $revenue_trends = $this->Revenue->get_revenue_trends(30);
                $data['revenue_trends'] = $revenue_trends;
                // Prepare chart labels and data for Chart.js
                $chart_labels = [];
                $chart_data = [];
                foreach ($revenue_trends as $trend) {
                    $chart_labels[] = date('M d', strtotime($trend->date));
                    $chart_data[] = floatval($trend->daily_sales);
                }
                $data['chart_labels'] = $chart_labels;
                $data['chart_data'] = $chart_data;
            } catch (Exception $e) {
                $data['revenue_trends'] = [];
                $data['chart_labels'] = [];
                $data['chart_data'] = [];
            }

            // Top revenue days for table
            try {
                $data['top_days'] = $this->Revenue->get_top_revenue_days(10);
            } catch (Exception $e) {
                $data['top_days'] = [];
            }

        } catch (Exception $e) {
            // Ultimate fallback to basic stats if Revenue model fails entirely
            $data['today_revenue'] = '0.00';
            $data['total_revenue'] = '0.00';
            $data['monthly_revenue'] = '0.00';
            $data['weekly_revenue'] = '0.00';
            $data['recent_transactions'] = [];
            $data['revenue_trends'] = [];
            $data['chart_labels'] = [];
            $data['chart_data'] = [];
            $data['top_days'] = [];
            // Don't show error to user, just log it
            error_log('Revenue dashboard error: ' . $e->getMessage());
        }
        // Load the revenue view
        $this->call->view('admin/revenue', $data);
    }

    /**
     * Sync Revenue - Sync revenue data from orders table
     */
    public function sync_revenue() {
        try {
            $result = $this->Revenue->sync_from_orders();
            if ($result) {
                $_SESSION['success_message'] = 'Revenue data synced successfully from orders.';
            } else {
                $_SESSION['error_message'] = 'Failed to sync revenue data.';
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error syncing revenue: ' . $e->getMessage();
        }
        
        redirect('/admin/revenue');
    }

    // Example: go to reports page
    public function reports() {
        $this->call->view('admin/reports');
    }

    // Settings page
    public function settings() {
        $data['title'] = 'Admin Settings';
        
        try {
            $data['settings'] = $this->Settings->get_all_settings();
            $data['email_settings'] = $this->Settings->get_email_settings();
        } catch (Exception $e) {
            // If there's an error loading settings, provide defaults
            error_log("Settings loading error: " . $e->getMessage());
            $data['settings'] = [];
            $data['email_settings'] = [];
        }
        
        $this->call->view('admin/settings', $data);
    }

    // Update Email Settings
    public function update_email_settings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email_settings = [
                    'smtp_host' => trim($_POST['smtp_host'] ?? ''),
                    'smtp_port' => trim($_POST['smtp_port'] ?? '587'),
                    'smtp_user' => trim($_POST['smtp_user'] ?? ''),
                    'smtp_pass' => trim($_POST['smtp_pass'] ?? ''),
                    'smtp_encryption' => trim($_POST['smtp_encryption'] ?? 'tls'),
                    'from_email' => trim($_POST['from_email'] ?? ''),
                    'from_name' => trim($_POST['from_name'] ?? 'CraftsHub')
                ];

                $success_count = 0;
                foreach ($email_settings as $key => $value) {
                    // Skip empty password fields (keep existing password)
                    if ($key === 'smtp_pass' && empty($value)) {
                        continue;
                    }
                    
                    // Encrypt password before storing
                    if ($key === 'smtp_pass' && !empty($value)) {
                        $value = base64_encode($value); // Simple encoding, use proper encryption in production
                    }
                    
                    $result = $this->Settings->set_setting($key, $value);
                    if ($result) {
                        $success_count++;
                    }
                }

                if ($success_count > 0) {
                    $_SESSION['success_message'] = "Email settings updated successfully! ($success_count settings saved)";
                } else {
                    $_SESSION['error_message'] = 'No settings were updated.';
                }
                
            } catch (Exception $e) {
                error_log("Email settings update error: " . $e->getMessage());
                $_SESSION['error_message'] = 'Failed to update email settings: ' . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = 'Invalid request method.';
        }
        
        redirect('/admin/settings');
    }

    // Update General Settings
    public function update_general_settings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $general_settings = [
                    'site_name' => $_POST['site_name'] ?? 'CraftsHub',
                    'site_description' => $_POST['site_description'] ?? '',
                    'admin_email' => $_POST['admin_email'] ?? '',
                    'maintenance_mode' => isset($_POST['maintenance_mode']) ? '1' : '0'
                ];

                foreach ($general_settings as $key => $value) {
                    $this->Settings->set_setting($key, $value);
                }

                $_SESSION['success_message'] = 'General settings updated successfully!';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Failed to update general settings: ' . $e->getMessage();
            }
        }
        
        redirect('/admin/settings');
    }

    // Update Security Settings
    public function update_security_settings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $security_settings = [
                    'session_timeout' => $_POST['session_timeout'] ?? '30',
                    'two_factor_auth' => isset($_POST['two_factor']) ? '1' : '0',
                    'force_ssl' => isset($_POST['force_ssl']) ? '1' : '0'
                ];

                foreach ($security_settings as $key => $value) {
                    $this->Settings->set_setting($key, $value);
                }

                $_SESSION['success_message'] = 'Security settings updated successfully!';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Failed to update security settings: ' . $e->getMessage();
            }
        }
        
        redirect('/admin/settings');
    }

    // Test Email Configuration
    public function test_email() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $test_email = $_POST['test_email'] ?? '';
            
            if (empty($test_email)) {
                $_SESSION['error_message'] = 'Please provide a test email address.';
                redirect('/admin/settings');
                return;
            }

            try {
                // Get email settings
                $email_settings = $this->Settings->get_email_settings();
                
                // Load email library
                $this->call->library('Email');
                
                // Configure email
                $config = [
                    'smtp_host' => $email_settings['smtp_host'],
                    'smtp_port' => $email_settings['smtp_port'],
                    'smtp_user' => $email_settings['smtp_user'],
                    'smtp_pass' => base64_decode($email_settings['smtp_pass']), // Decrypt password
                    'smtp_encryption' => $email_settings['smtp_encryption'],
                    'from_email' => $email_settings['from_email'],
                    'from_name' => $email_settings['from_name']
                ];
                
                $this->email->initialize($config);
                
                // Send test email
                $this->email->from($email_settings['from_email'], $email_settings['from_name']);
                $this->email->to($test_email);
                $this->email->subject('CraftsHub - Email Configuration Test');
                $this->email->message('
                    <h2>Email Configuration Test</h2>
                    <p>Congratulations! Your email configuration is working properly.</p>
                    <p>This test email was sent from CraftsHub Admin Panel.</p>
                    <hr>
                    <p>SMTP Settings Used:</p>
                    <ul>
                        <li>Host: ' . $email_settings['smtp_host'] . '</li>
                        <li>Port: ' . $email_settings['smtp_port'] . '</li>
                        <li>Encryption: ' . $email_settings['smtp_encryption'] . '</li>
                        <li>From: ' . $email_settings['from_name'] . ' &lt;' . $email_settings['from_email'] . '&gt;</li>
                    </ul>
                ');
                
                if ($this->email->send()) {
                    $_SESSION['success_message'] = 'Test email sent successfully to ' . $test_email . '!';
                } else {
                    $_SESSION['error_message'] = 'Failed to send test email. Please check your email configuration.';
                }
                
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Email test failed: ' . $e->getMessage();
            }
        }
        
        redirect('/admin/settings');
    }

    /**
     * Inventory Management - Display inventory dashboard with stock levels
     */
    public function inventory() {
        $data['title'] = 'Inventory Management';
        
        try {
            // Get all products with stock information
            $data['products'] = $this->Product->get_all_products();
            
            // Get inventory statistics
            $inventory_stats = $this->Product->get_inventory_stats();
            $data['total_products'] = $inventory_stats['total_products'];
            $data['total_stock'] = $inventory_stats['total_stock'];
            $data['low_stock_count'] = $inventory_stats['low_stock_count'];
            $data['out_of_stock_count'] = $inventory_stats['out_of_stock_count'];
            
            // Get low stock products (stock <= 5)
            $data['low_stock_products'] = $this->Product->get_low_stock_products(5);
            
        } catch (Exception $e) {
            // Handle errors gracefully
            error_log("Inventory dashboard error: " . $e->getMessage());
            $data['products'] = [];
            $data['total_products'] = 0;
            $data['total_stock'] = 0;
            $data['low_stock_count'] = 0;
            $data['out_of_stock_count'] = 0;
            $data['low_stock_products'] = [];
            $_SESSION['error_message'] = 'Unable to load inventory data. Please try again.';
        }
        
        $this->call->view('admin/inventory', $data);
    }

    /**
     * Update Stock - Handle stock quantity updates
     */
    public function updateStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? 0;
            $new_stock = $_POST['new_stock'] ?? 0;
            
            // Validate input
            if ($product_id <= 0) {
                $_SESSION['error_message'] = 'Invalid product ID.';
                redirect('/admin/inventory');
                return;
            }
            
            if ($new_stock < 0) {
                $_SESSION['error_message'] = 'Stock quantity cannot be negative.';
                redirect('/admin/inventory');
                return;
            }
            
            try {
                // Get product to verify it exists
                $product = $this->Product->get_product($product_id);
                if (!$product) {
                    $_SESSION['error_message'] = 'Product not found.';
                    redirect('/admin/inventory');
                    return;
                }
                
                // Update stock
                $old_stock = $product->stock;
                $update_data = [
                    'stock' => $new_stock
                ];
                
                if ($this->Product->update_product($product_id, $update_data)) {
                    $stock_difference = $new_stock - $old_stock;
                    $action = $stock_difference > 0 ? 'increased' : ($stock_difference < 0 ? 'decreased' : 'unchanged');
                    
                    $_SESSION['success_message'] = "Stock for '{$product->product_name}' has been updated from {$old_stock} to {$new_stock} units.";
                    
                    // Log inventory change
                    error_log("Inventory Update: Product ID {$product_id} ({$product->product_name}) stock {$action} from {$old_stock} to {$new_stock}");
                    
                } else {
                    $_SESSION['error_message'] = 'Failed to update stock. Please try again.';
                }
                
            } catch (Exception $e) {
                error_log("Stock update error: " . $e->getMessage());
                $_SESSION['error_message'] = 'Error updating stock: ' . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = 'Invalid request method.';
        }
        
        redirect('/admin/inventory');
    }

    /**
     * Bulk Stock Update - Handle multiple stock updates at once
     */
    public function bulkUpdateStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stock_updates = $_POST['stock_updates'] ?? [];
            $success_count = 0;
            $error_count = 0;
            
            if (empty($stock_updates)) {
                $_SESSION['error_message'] = 'No stock updates provided.';
                redirect('/admin/inventory');
                return;
            }
            
            try {
                foreach ($stock_updates as $product_id => $new_stock) {
                    // Validate and update each product
                    if ($product_id > 0 && $new_stock >= 0) {
                        $product = $this->Product->get_product($product_id);
                        if ($product) {
                            $update_data = ['stock' => $new_stock];
                            if ($this->Product->update_product($product_id, $update_data)) {
                                $success_count++;
                                error_log("Bulk Update: Product ID {$product_id} stock updated to {$new_stock}");
                            } else {
                                $error_count++;
                            }
                        } else {
                            $error_count++;
                        }
                    } else {
                        $error_count++;
                    }
                }
                
                if ($success_count > 0) {
                    $_SESSION['success_message'] = "Successfully updated {$success_count} product(s).";
                    if ($error_count > 0) {
                        $_SESSION['success_message'] .= " {$error_count} update(s) failed.";
                    }
                } else {
                    $_SESSION['error_message'] = "All stock updates failed. Please check your input and try again.";
                }
                
            } catch (Exception $e) {
                error_log("Bulk stock update error: " . $e->getMessage());
                $_SESSION['error_message'] = 'Error during bulk update: ' . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = 'Invalid request method.';
        }
        
        redirect('/admin/inventory');
    }

    /**
     * Get Inventory Stats API - Return inventory statistics as JSON
     */
    public function getInventoryStats() {
        header('Content-Type: application/json');
        
        try {
            $stats = $this->Product->get_inventory_stats();
            $low_stock_products = $this->Product->get_low_stock_products(5);
            
            echo json_encode([
                'success' => true,
                'stats' => $stats,
                'low_stock_products' => $low_stock_products,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Export Inventory - Generate CSV export of inventory data
     */
    public function exportInventory() {
        try {
            $products = $this->Product->get_all_products();
            
            // Set CSV headers
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="inventory_' . date('Y-m-d') . '.csv"');
            
            // Open output stream
            $output = fopen('php://output', 'w');
            
            // Write CSV header
            fputcsv($output, [
                'Product ID',
                'Product Name',
                'Description',
                'Stock Quantity',
                'Stock Status',
                'Unit Price',
                'Total Value',
                'Created Date'
            ]);
            
            // Write product data
            foreach ($products as $product) {
                $stock_status = 'In Stock';
                if ($product->stock == 0) {
                    $stock_status = 'Out of Stock';
                } elseif ($product->stock <= 5) {
                    $stock_status = 'Low Stock';
                } elseif ($product->stock <= 20) {
                    $stock_status = 'Medium Stock';
                }
                
                $total_value = $product->stock * $product->price;
                
                fputcsv($output, [
                    $product->product_id,
                    $product->product_name,
                    $product->description ?? '',
                    $product->stock,
                    $stock_status,
                    number_format($product->price, 2),
                    number_format($total_value, 2),
                    isset($product->created_at) ? date('Y-m-d H:i:s', strtotime($product->created_at)) : 'N/A'
                ]);
            }
            
            fclose($output);
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Failed to export inventory data: ' . $e->getMessage();
            redirect('/admin/inventory');
        }
    }

    /**
     * View order details page
     */
    public function viewOrder($id) {
        $this->call->model('Order');
        $order = $this->Order->get_order_by_id($id);
        $data['order'] = $order;
        $this->call->view('admin/order_view', $data);
    }

    /**
     * Logout - Destroy admin session and redirect to login
     */
    public function logout() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Clear all session variables
        session_unset();
        
        // Destroy the session
        session_destroy();
        
        // Set success message for login page
        session_start();
        $_SESSION['success_message'] = 'You have been successfully logged out.';
        
        // Redirect to login page
        redirect('/login');
    }
}
