<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Cart extends Model {
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_cart_items() {
        return $this->db->table($this->table)->get_all(PDO::FETCH_OBJ);
    }

    public function get_cart_item($cart_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $cart_id)
                        ->get(PDO::FETCH_OBJ);
    }

    public function add_to_cart($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_cart_item($cart_id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $cart_id)
                        ->update($data);
    }

    public function remove_from_cart($cart_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $cart_id)
                        ->delete();
    }

    public function get_cart_by_buyer($buyer_id) {
        return $this->db->table($this->table)
                        ->join('products', 'cart.product_id = products.product_id')
                        ->where('cart.buyer_id', $buyer_id)
                        ->get_all(PDO::FETCH_OBJ);
    }

    public function check_existing_cart_item($buyer_id, $product_id) {
        return $this->db->table($this->table)
                        ->where('buyer_id', $buyer_id)
                        ->where('product_id', $product_id)
                        ->get(PDO::FETCH_OBJ);
    }

    public function clear_cart($buyer_id) {
        return $this->db->table($this->table)
                        ->where('buyer_id', $buyer_id)
                        ->delete();
    }
}