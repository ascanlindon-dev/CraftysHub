<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');


defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// Load .env variables using Dotenv
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

/**
 * PayMongo API Configuration
 * Get your API keys from: https://dashboard.paymongo.com/developers
 */

// PayMongo API Configuration
$config['paymongo'] = [
    // SANDBOX MODE - Use test keys for development
    'environment' => 'sandbox', // 'sandbox' or 'live'
    // PayMongo API Keys
    'secret_key' => $_ENV['PAYMONGO_SECRET_KEY'] ?? '',
    'public_key' => $_ENV['PAYMONGO_PUBLIC_KEY'] ?? '',
    // API Base URL
    'api_base_url' => 'https://api.paymongo.com/v1',
    // Payment Methods
    'enabled_methods' => [
        'gcash',
        'paymaya',
        'grab_pay',
    ],
    // Currency
    'currency' => 'PHP',
    // Callback URLs
    'success_url' => 'https://craftyshub.onrender.com/buyer/payment/gcash-success',
    'failed_url' => 'https://craftyshub.onrender.com/buyer/payment/gcash-failed',
];

return $config;
