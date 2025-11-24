<<<<<<< HEAD
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Model {
    protected $table = 'buyers';
    protected $primaryKey = 'buyer_id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_users() {
        return $this->db->table($this->table)->get_all(PDO::FETCH_OBJ);
    }

    public function get_user($user_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $user_id)
                        ->get(PDO::FETCH_OBJ);
    }

    public function create_user($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_user($user_id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $user_id)
                        ->update($data);
    }

    public function delete_user($buyer_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $buyer_id)
                        ->delete();
    }

    public function get_user_by_email($email) {
        return $this->db->table($this->table)
                        ->where('email', $email)
                        ->get(PDO::FETCH_OBJ);
    }

    // Dashboard statistics
    public function count_total_users() {
        $result = $this->db->table($this->table)
                          ->select('COUNT(*) as total')
                          ->get(PDO::FETCH_OBJ);
        return $result ? $result->total : 0;
    }
=======
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Model {
    protected $table = 'buyers';
    protected $primaryKey = 'buyer_id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_users() {
        return $this->db->table($this->table)->get_all(PDO::FETCH_OBJ);
    }

    public function get_user($user_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $user_id)
                        ->get(PDO::FETCH_OBJ);
    }

    public function create_user($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_user($user_id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $user_id)
                        ->update($data);
    }

    public function delete_user($buyer_id) {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $buyer_id)
                        ->delete();
    }

    public function get_user_by_email($email) {
        return $this->db->table($this->table)
                        ->where('email', $email)
                        ->get(PDO::FETCH_OBJ);
    }

    // Dashboard statistics
    public function count_total_users() {
        $result = $this->db->table($this->table)
                          ->select('COUNT(*) as total')
                          ->get(PDO::FETCH_OBJ);
        return $result ? $result->total : 0;
    }
>>>>>>> da170f7 (sure to?)
}