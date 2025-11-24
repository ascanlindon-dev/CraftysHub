<<<<<<< HEAD
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Safe HTML Escape
 * 
 * Safely escapes HTML characters, handling null values properly
 * 
 * @param mixed $value
 * @param string $default
 * @return string
 */
if (!function_exists('safe_html_escape')) {
    function safe_html_escape($value, $default = '') {
        return htmlspecialchars($value ?? $default, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Safe Number Format
 * 
 * Safely formats numbers, handling null values properly
 * 
 * @param mixed $number
 * @param int $decimals
 * @param mixed $default
 * @return string
 */
if (!function_exists('safe_number_format')) {
    function safe_number_format($number, $decimals = 2, $default = 0) {
        return number_format($number ?? $default, $decimals);
    }
=======
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Safe HTML Escape
 * 
 * Safely escapes HTML characters, handling null values properly
 * 
 * @param mixed $value
 * @param string $default
 * @return string
 */
if (!function_exists('safe_html_escape')) {
    function safe_html_escape($value, $default = '') {
        return htmlspecialchars($value ?? $default, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Safe Number Format
 * 
 * Safely formats numbers, handling null values properly
 * 
 * @param mixed $number
 * @param int $decimals
 * @param mixed $default
 * @return string
 */
if (!function_exists('safe_number_format')) {
    function safe_number_format($number, $decimals = 2, $default = 0) {
        return number_format($number ?? $default, $decimals);
    }
>>>>>>> da170f7 (sure to?)
}