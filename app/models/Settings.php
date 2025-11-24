<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Settings extends Model {
    protected $table = 'site_settings';
    protected $primaryKey = 'setting_id';

    public function __construct() {
        parent::__construct();
    }

    public function get_setting($key) {
        $result = $this->db->table($this->table)
                          ->where('setting_key', $key)
                          ->get(PDO::FETCH_OBJ);
        return $result ? $result->setting_value : null;
    }

    public function set_setting($key, $value) {
        $existing = $this->db->table($this->table)
                            ->where('setting_key', $key)
                            ->get(PDO::FETCH_OBJ);
        
        if ($existing) {
            return $this->db->table($this->table)
                           ->where('setting_key', $key)
                           ->update([
                               'setting_value' => $value,
                               'updated_at' => date('Y-m-d H:i:s')
                           ]);
        } else {
            return $this->db->table($this->table)
                           ->insert([
                               'setting_key' => $key,
                               'setting_value' => $value,
                               'created_at' => date('Y-m-d H:i:s'),
                               'updated_at' => date('Y-m-d H:i:s')
                           ]);
        }
    }

    public function get_all_settings() {
        $settings = $this->db->table($this->table)->get_all(PDO::FETCH_OBJ);
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting->setting_key] = $setting->setting_value;
        }
        return $result;
    }

    public function get_email_settings() {
        $email_keys = ['smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_encryption', 'from_email', 'from_name'];
        $settings = [];
        foreach ($email_keys as $key) {
            $settings[$key] = $this->get_setting($key);
        }
        return $settings;
    }
}
?>