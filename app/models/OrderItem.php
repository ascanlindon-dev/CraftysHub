<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class OrderItem extends Model {
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_order_items() {
        return $this->db->table($this->table)->get_all(PDO::FETCH_OBJ);
    }

    public function get_order_item($order_item_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $order_item_id)
                        ->get(PDO::FETCH_OBJ);
    }

    public function create_order_item($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_order_item($order_item_id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $order_item_id)
                        ->update($data);
    }

    public function delete_order_item($order_item_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $order_item_id)
                        ->delete();
    }

    public function get_order_items_by_order($order_id) {
        return $this->db->table($this->table)
                        ->where('order_id', $order_id)
                        ->get_all(PDO::FETCH_OBJ);
    }

    public function create_order_items_from_cart($order_id, $cart_items) {
        $success = true;
        foreach ($cart_items as $item) {
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
            
            if (!$this->create_order_item($order_item_data)) {
                $success = false;
                break;
            }
        }
        return $success;
    }
}