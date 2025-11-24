<<<<<<< HEAD
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * PayMongo API Configuration
 * Get your API keys from: https://dashboard.paymongo.com/developers
 */

$config['paymongo'] = [
    // SANDBOX MODE - Use test keys for development
    'environment' => 'sandbox', // 'sandbox' or 'live'
    
    // PayMongo API Keys
    'secret_key' => getenv('PAYMONGO_SECRET_KEY'),
    'public_key' => getenv('PAYMONGO_PUBLIC_KEY'),
    
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
    'success_url' => 'http://localhost:4000/buyer/payment/gcash-success',
    'failed_url' => 'http://localhost:4000/buyer/payment/gcash-failed',
];

return $config;
=======
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * PayMongo API Configuration
 * Get your API keys from: https://dashboard.paymongo.com/developers
 */

$config['paymongo'] = [
    // SANDBOX MODE - Use test keys for development
    'environment' => 'sandbox', // 'sandbox' or 'live'
    
    // PayMongo API Keys
    'secret_key' => 'sk_test_hq4GcGABHRwCfhhqznAqo9hp',
    'public_key' => 'pk_test_cuGeVdFaGE6VUSp648Pnif2C',
    
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
    'success_url' => 'http://localhost:4000/buyer/payment/gcash-success',
    'failed_url' => 'http://localhost:4000/buyer/payment/gcash-failed',
];

return $config;
>>>>>>> da170f7 (sure to?)
//https://secure-authentication.paymongo.com/sources?id=src_3yMNDBNBUQFDbpmMxvt6QHoY