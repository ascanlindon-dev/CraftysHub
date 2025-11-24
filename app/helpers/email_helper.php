<?php
/**
 * Email Configuration Helper
 * Helper functions to get email settings for use throughout the application
 */
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

if (!function_exists('get_email_config')) {
    /**
     * Get email configuration array for use with email libraries
     * @return array Email configuration array
     */
    function get_email_config() {
        // Database configuration
        $host = 'localhost';
        $dbname = 'craftyshub';
        $username = 'root';
        $password = '';
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Get email settings from database
            $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN (?, ?, ?, ?, ?, ?, ?)");
            $email_keys = ['smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_encryption', 'from_email', 'from_name'];
            $stmt->execute($email_keys);
            
            $settings = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $value = $row['setting_value'];
                
                // Decrypt password
                if ($row['setting_key'] === 'smtp_pass' && !empty($value)) {
                    $value = base64_decode($value);
                }
                
                $settings[$row['setting_key']] = $value;
            }
            
            // Return configuration array with defaults
            return [
                'protocol' => 'smtp',
                'smtp_host' => $settings['smtp_host'] ?? 'smtp.gmail.com',
                'smtp_port' => $settings['smtp_port'] ?? '587',
                'smtp_user' => $settings['smtp_user'] ?? '',
                'smtp_pass' => $settings['smtp_pass'] ?? '',
                'smtp_crypto' => $settings['smtp_encryption'] ?? 'tls',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'from_email' => $settings['from_email'] ?? 'noreply@craftyshub.com',
                'from_name' => $settings['from_name'] ?? 'CraftsHub'
            ];
            
        } catch (Exception $e) {
            error_log("Email config error: " . $e->getMessage());
            
            // Return default configuration on error
            return [
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => '587',
                'smtp_user' => '',
                'smtp_pass' => '',
                'smtp_crypto' => 'tls',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'from_email' => 'noreply@craftyshub.com',
                'from_name' => 'CraftsHub'
            ];
        }
    }
}

if (!function_exists('get_site_setting')) {
    /**
     * Get a single site setting value
     * @param string $key Setting key
     * @param mixed $default Default value if setting not found
     * @return mixed Setting value or default
     */
    function get_site_setting($key, $default = null) {
        // Database configuration
        $host = 'localhost';
        $dbname = 'craftyshub';
        $username = 'root';
        $password = '';
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
            $stmt->execute([$key]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? $result['setting_value'] : $default;
            
        } catch (Exception $e) {
            error_log("Site setting error: " . $e->getMessage());
            return $default;
        }
    }
}
