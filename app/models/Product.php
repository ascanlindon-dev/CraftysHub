<<<<<<< HEAD
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Product extends Model {
        // Get all reviews for a product
        public function get_reviews($product_id) {
            return $this->db->table('product_reviews')
                ->where('product_id', $product_id)
                ->order_by('created_at', 'DESC')
                ->get_all(PDO::FETCH_OBJ);
        }

        // Add a review for a product
        public function add_review($product_id, $user_id, $rating, $review) {
            $data = [
                'product_id' => $product_id,
                'user_id' => $user_id,
                'rating' => $rating,
                'review' => $review,
                'created_at' => date('Y-m-d H:i:s')
            ];
            return $this->db->table('product_reviews')->insert($data);
        }
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    public function __construct() {
        parent::__construct();

    }

    public function get_all_products() {
        return $this->db->table($this->table)->get_all(PDO::FETCH_OBJ);
    }

    public function get_product($product_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $product_id)
                        ->get(PDO::FETCH_OBJ);
    }

    public function create_product($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_product($product_id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $product_id)
                        ->update($data);
    }

    public function delete_product($product_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $product_id)
                        ->delete();
    }

    // Dashboard statistics
    public function count_total_products() {
        $result = $this->db->table($this->table)
                          ->select('COUNT(*) as total')
                          ->get(PDO::FETCH_OBJ);
        return $result ? $result->total : 0;
    }

    // ===== INVENTORY MANAGEMENT METHODS =====

    /**
     * Get comprehensive inventory statistics
     */
    public function get_inventory_stats() {
        try {
            // Total products count
            $total_products_result = $this->db->table($this->table)
                                            ->select('COUNT(*) as total')
                                            ->get(PDO::FETCH_OBJ);
            $total_products = $total_products_result ? $total_products_result->total : 0;

            // Total stock units
            $total_stock_result = $this->db->table($this->table)
                                          ->select('SUM(stock) as total_stock')
                                          ->get(PDO::FETCH_OBJ);
            $total_stock = $total_stock_result ? ($total_stock_result->total_stock ?? 0) : 0;

            // Low stock count (stock <= 5)
            $low_stock_result = $this->db->table($this->table)
                                        ->select('COUNT(*) as low_stock_count')
                                        ->where('stock', '<=', 5)
                                        ->where('stock', '>', 0)
                                        ->get(PDO::FETCH_OBJ);
            $low_stock_count = $low_stock_result ? $low_stock_result->low_stock_count : 0;

            // Out of stock count (stock = 0)
            $out_of_stock_result = $this->db->table($this->table)
                                           ->select('COUNT(*) as out_of_stock_count')
                                           ->where('stock', '=', 0)
                                           ->get(PDO::FETCH_OBJ);
            $out_of_stock_count = $out_of_stock_result ? $out_of_stock_result->out_of_stock_count : 0;

            // Total inventory value
            $inventory_value_result = $this->db->table($this->table)
                                              ->select('SUM(stock * price) as total_value')
                                              ->get(PDO::FETCH_OBJ);
            $total_inventory_value = $inventory_value_result ? ($inventory_value_result->total_value ?? 0) : 0;

            return [
                'total_products' => (int)$total_products,
                'total_stock' => (int)$total_stock,
                'low_stock_count' => (int)$low_stock_count,
                'out_of_stock_count' => (int)$out_of_stock_count,
                'total_inventory_value' => (float)$total_inventory_value
            ];

        } catch (Exception $e) {
            error_log("Error getting inventory stats: " . $e->getMessage());
            return [
                'total_products' => 0,
                'total_stock' => 0,
                'low_stock_count' => 0,
                'out_of_stock_count' => 0,
                'total_inventory_value' => 0
            ];
        }
    }

    /**
     * Get products with low stock levels
     */
    public function get_low_stock_products($threshold = 5) {
        try {
            return $this->db->table($this->table)
                           ->where('stock', '<=', $threshold)
                           ->where('stock', '>', 0)
                           ->order_by('stock', 'ASC')
                           ->get_all(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting low stock products: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get products that are out of stock
     */
    public function get_out_of_stock_products() {
        try {
            return $this->db->table($this->table)
                           ->where('stock', '=', 0)
                           ->order_by('product_name', 'ASC')
                           ->get_all(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting out of stock products: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Update stock quantity for a product
     */
    public function update_stock($product_id, $new_stock) {
        try {
            if ($new_stock < 0) {
                throw new Exception('Stock quantity cannot be negative');
            }

            $result = $this->db->table($this->table)
                              ->where($this->primaryKey, $product_id)
                              ->update(['stock' => $new_stock]);
            
            if ($result) {
                error_log("Stock updated for product ID {$product_id}: new stock = {$new_stock}");
            }
            
            return $result;

        } catch (Exception $e) {
            error_log("Error updating stock for product {$product_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Deduct stock when a product is purchased
     */
    public function deduct_stock($product_id, $quantity) {
        try {
            // Get current product data
            $product = $this->get_product($product_id);
            
            if (!$product) {
                throw new Exception("Product with ID {$product_id} not found");
            }
            
            // Check if sufficient stock is available
            if ($product->stock < $quantity) {
                throw new Exception("Insufficient stock. Available: {$product->stock}, Requested: {$quantity}");
            }
            
            // Calculate new stock
            $new_stock = $product->stock - $quantity;
            
            // Update stock
            $result = $this->update_stock($product_id, $new_stock);
            
            if ($result) {
                error_log("Stock deducted for product ID {$product_id}: {$quantity} units. New stock: {$new_stock}");
            }
            
            return $result;

        } catch (Exception $e) {
            error_log("Error deducting stock for product {$product_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add stock when restocking or returning items
     */
    public function add_stock($product_id, $quantity) {
        try {
            // Get current product data
            $product = $this->get_product($product_id);
            
            if (!$product) {
                throw new Exception("Product with ID {$product_id} not found");
            }
            
            // Calculate new stock
            $new_stock = $product->stock + $quantity;
            
            // Update stock
            $result = $this->update_stock($product_id, $new_stock);
            
            if ($result) {
                error_log("Stock added for product ID {$product_id}: {$quantity} units. New stock: {$new_stock}");
            }
            
            return $result;

        } catch (Exception $e) {
            error_log("Error adding stock for product {$product_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Check if product has sufficient stock
     */
    public function has_sufficient_stock($product_id, $required_quantity) {
        try {
            $product = $this->get_product($product_id);
            
            if (!$product) {
                return false;
            }
            
            return $product->stock >= $required_quantity;

        } catch (Exception $e) {
            error_log("Error checking stock for product {$product_id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get products with stock above a threshold
     */
    public function get_products_in_stock($min_stock = 1) {
        try {
            return $this->db->table($this->table)
                           ->where('stock', '>=', $min_stock)
                           ->order_by('product_name', 'ASC')
                           ->get_all(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting products in stock: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get inventory movement history (this would need a separate table in production)
     * For now, this is a placeholder that could log to files or database
     */
    public function log_inventory_movement($product_id, $movement_type, $quantity, $reference = '') {
        try {
            $log_entry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'product_id' => $product_id,
                'movement_type' => $movement_type, // 'sale', 'restock', 'adjustment', 'return'
                'quantity' => $quantity,
                'reference' => $reference
            ];
            
            error_log("Inventory Movement: " . json_encode($log_entry));
            
            // In a production system, you would insert this into an inventory_movements table
            // return $this->db->table('inventory_movements')->insert($log_entry);
            
            return true;

        } catch (Exception $e) {
            error_log("Error logging inventory movement: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get top selling products by stock movement (placeholder)
     */
    public function get_top_selling_products($limit = 10) {
        try {
            // This is a simplified version. In production, you'd join with order_items
            // to get actual sales data
            return $this->db->table($this->table)
                           ->where('stock', '>', 0)
                           ->order_by('stock', 'DESC') // Higher stock might indicate popular items
                           ->limit($limit)
                           ->get_all(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting top selling products: " . $e->getMessage());
            return [];
        }
    }
}
=======
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Product extends Model {
        // Get all reviews for a product
        public function get_reviews($product_id) {
            return $this->db->table('product_reviews')
                ->where('product_id', $product_id)
                ->order_by('created_at', 'DESC')
                ->get_all(PDO::FETCH_OBJ);
        }

        // Add a review for a product
        public function add_review($product_id, $user_id, $rating, $review) {
            $data = [
                'product_id' => $product_id,
                'user_id' => $user_id,
                'rating' => $rating,
                'review' => $review,
                'created_at' => date('Y-m-d H:i:s')
            ];
            return $this->db->table('product_reviews')->insert($data);
        }
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    public function __construct() {
        parent::__construct();

    }

    public function get_all_products() {
        return $this->db->table($this->table)->get_all(PDO::FETCH_OBJ);
    }

    public function get_product($product_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $product_id)
                        ->get(PDO::FETCH_OBJ);
    }

    public function create_product($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_product($product_id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $product_id)
                        ->update($data);
    }

    public function delete_product($product_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $product_id)
                        ->delete();
    }

    // Dashboard statistics
    public function count_total_products() {
        $result = $this->db->table($this->table)
                          ->select('COUNT(*) as total')
                          ->get(PDO::FETCH_OBJ);
        return $result ? $result->total : 0;
    }

    // ===== INVENTORY MANAGEMENT METHODS =====

    /**
     * Get comprehensive inventory statistics
     */
    public function get_inventory_stats() {
        try {
            // Total products count
            $total_products_result = $this->db->table($this->table)
                                            ->select('COUNT(*) as total')
                                            ->get(PDO::FETCH_OBJ);
            $total_products = $total_products_result ? $total_products_result->total : 0;

            // Total stock units
            $total_stock_result = $this->db->table($this->table)
                                          ->select('SUM(stock) as total_stock')
                                          ->get(PDO::FETCH_OBJ);
            $total_stock = $total_stock_result ? ($total_stock_result->total_stock ?? 0) : 0;

            // Low stock count (stock <= 5)
            $low_stock_result = $this->db->table($this->table)
                                        ->select('COUNT(*) as low_stock_count')
                                        ->where('stock', '<=', 5)
                                        ->where('stock', '>', 0)
                                        ->get(PDO::FETCH_OBJ);
            $low_stock_count = $low_stock_result ? $low_stock_result->low_stock_count : 0;

            // Out of stock count (stock = 0)
            $out_of_stock_result = $this->db->table($this->table)
                                           ->select('COUNT(*) as out_of_stock_count')
                                           ->where('stock', '=', 0)
                                           ->get(PDO::FETCH_OBJ);
            $out_of_stock_count = $out_of_stock_result ? $out_of_stock_result->out_of_stock_count : 0;

            // Total inventory value
            $inventory_value_result = $this->db->table($this->table)
                                              ->select('SUM(stock * price) as total_value')
                                              ->get(PDO::FETCH_OBJ);
            $total_inventory_value = $inventory_value_result ? ($inventory_value_result->total_value ?? 0) : 0;

            return [
                'total_products' => (int)$total_products,
                'total_stock' => (int)$total_stock,
                'low_stock_count' => (int)$low_stock_count,
                'out_of_stock_count' => (int)$out_of_stock_count,
                'total_inventory_value' => (float)$total_inventory_value
            ];

        } catch (Exception $e) {
            error_log("Error getting inventory stats: " . $e->getMessage());
            return [
                'total_products' => 0,
                'total_stock' => 0,
                'low_stock_count' => 0,
                'out_of_stock_count' => 0,
                'total_inventory_value' => 0
            ];
        }
    }

    /**
     * Get products with low stock levels
     */
    public function get_low_stock_products($threshold = 5) {
        try {
            return $this->db->table($this->table)
                           ->where('stock', '<=', $threshold)
                           ->where('stock', '>', 0)
                           ->order_by('stock', 'ASC')
                           ->get_all(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting low stock products: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get products that are out of stock
     */
    public function get_out_of_stock_products() {
        try {
            return $this->db->table($this->table)
                           ->where('stock', '=', 0)
                           ->order_by('product_name', 'ASC')
                           ->get_all(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting out of stock products: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Update stock quantity for a product
     */
    public function update_stock($product_id, $new_stock) {
        try {
            if ($new_stock < 0) {
                throw new Exception('Stock quantity cannot be negative');
            }

            $result = $this->db->table($this->table)
                              ->where($this->primaryKey, $product_id)
                              ->update(['stock' => $new_stock]);
            
            if ($result) {
                error_log("Stock updated for product ID {$product_id}: new stock = {$new_stock}");
            }
            
            return $result;

        } catch (Exception $e) {
            error_log("Error updating stock for product {$product_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Deduct stock when a product is purchased
     */
    public function deduct_stock($product_id, $quantity) {
        try {
            // Get current product data
            $product = $this->get_product($product_id);
            
            if (!$product) {
                throw new Exception("Product with ID {$product_id} not found");
            }
            
            // Check if sufficient stock is available
            if ($product->stock < $quantity) {
                throw new Exception("Insufficient stock. Available: {$product->stock}, Requested: {$quantity}");
            }
            
            // Calculate new stock
            $new_stock = $product->stock - $quantity;
            
            // Update stock
            $result = $this->update_stock($product_id, $new_stock);
            
            if ($result) {
                error_log("Stock deducted for product ID {$product_id}: {$quantity} units. New stock: {$new_stock}");
            }
            
            return $result;

        } catch (Exception $e) {
            error_log("Error deducting stock for product {$product_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add stock when restocking or returning items
     */
    public function add_stock($product_id, $quantity) {
        try {
            // Get current product data
            $product = $this->get_product($product_id);
            
            if (!$product) {
                throw new Exception("Product with ID {$product_id} not found");
            }
            
            // Calculate new stock
            $new_stock = $product->stock + $quantity;
            
            // Update stock
            $result = $this->update_stock($product_id, $new_stock);
            
            if ($result) {
                error_log("Stock added for product ID {$product_id}: {$quantity} units. New stock: {$new_stock}");
            }
            
            return $result;

        } catch (Exception $e) {
            error_log("Error adding stock for product {$product_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Check if product has sufficient stock
     */
    public function has_sufficient_stock($product_id, $required_quantity) {
        try {
            $product = $this->get_product($product_id);
            
            if (!$product) {
                return false;
            }
            
            return $product->stock >= $required_quantity;

        } catch (Exception $e) {
            error_log("Error checking stock for product {$product_id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get products with stock above a threshold
     */
    public function get_products_in_stock($min_stock = 1) {
        try {
            return $this->db->table($this->table)
                           ->where('stock', '>=', $min_stock)
                           ->order_by('product_name', 'ASC')
                           ->get_all(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting products in stock: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get inventory movement history (this would need a separate table in production)
     * For now, this is a placeholder that could log to files or database
     */
    public function log_inventory_movement($product_id, $movement_type, $quantity, $reference = '') {
        try {
            $log_entry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'product_id' => $product_id,
                'movement_type' => $movement_type, // 'sale', 'restock', 'adjustment', 'return'
                'quantity' => $quantity,
                'reference' => $reference
            ];
            
            error_log("Inventory Movement: " . json_encode($log_entry));
            
            // In a production system, you would insert this into an inventory_movements table
            // return $this->db->table('inventory_movements')->insert($log_entry);
            
            return true;

        } catch (Exception $e) {
            error_log("Error logging inventory movement: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get top selling products by stock movement (placeholder)
     */
    public function get_top_selling_products($limit = 10) {
        try {
            // This is a simplified version. In production, you'd join with order_items
            // to get actual sales data
            return $this->db->table($this->table)
                           ->where('stock', '>', 0)
                           ->order_by('stock', 'DESC') // Higher stock might indicate popular items
                           ->limit($limit)
                           ->get_all(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting top selling products: " . $e->getMessage());
            return [];
        }
    }
}
>>>>>>> da170f7 (sure to?)
