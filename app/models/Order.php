<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Order extends Model {
    protected $table = 'orders';
    protected $primaryKey = 'id'; // Changed from 'order_id' to match actual table

    public function __construct() {
        parent::__construct();
    }
        // Fetch a single order by its ID (for admin view)
        public function get_order_by_id($id) {
            return $this->db->table($this->table)
                            ->where($this->primaryKey, $id)
                            ->get(PDO::FETCH_OBJ);
        }

    public function get_all_orders() {
        return $this->db->table($this->table)->get_all(PDO::FETCH_OBJ);
    }

    public function get_order($order_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $order_id)
                        ->get(PDO::FETCH_OBJ);
    }

    public function create_order($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_order($order_id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $order_id)
                        ->update($data);
    }

    public function delete_order($order_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $order_id)
                        ->delete();
    }

    public function get_orders_by_user($user_id) {
        return $this->db->table($this->table)
                        ->where('user_id', $user_id)
                        ->get_all(PDO::FETCH_OBJ);
    }

    public function get_orders_by_buyer($buyer_id) {
        return $this->db->table($this->table)
                        ->where('buyer_id', $buyer_id)
                        ->order_by('order_date', 'DESC')
                        ->get_all(PDO::FETCH_OBJ);
    }

    // Dashboard statistics
    public function count_orders_today() {
        $today = date('Y-m-d');
        $result = $this->db->table($this->table)
                          ->where('DATE(order_date)', $today)
                          ->select('COUNT(*) as total')
                          ->get(PDO::FETCH_OBJ);
        return $result ? $result->total : 0;
    }

    public function calculate_total_revenue() {
        $result = $this->db->table($this->table)
                          ->select('SUM(total_amount) as revenue')
                          ->get(PDO::FETCH_OBJ);
        return $result && $result->revenue ? $result->revenue : 0;
    }

    public function calculate_today_revenue() {
        $today = date('Y-m-d');
        $result = $this->db->table($this->table)
                          ->where('DATE(order_date)', $today)
                          ->select('SUM(total_amount) as revenue')
                          ->get(PDO::FETCH_OBJ);
        return $result && $result->revenue ? $result->revenue : 0;
    }

    public function create_order_with_items($order_data, $cart_items) {
        try {
            // Create the order
            $order_id = $this->create_order($order_data);
            
            if ($order_id) {
                // Note: OrderItem model should be loaded in the controller
                // This is a helper method for transaction-based order creation
                return $order_id;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Order creation error: " . $e->getMessage());
            return false;
        }
    }
}