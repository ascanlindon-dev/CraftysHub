<<<<<<< HEAD
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class PayMongo {
    
    private $secret_key;
    private $public_key;
    private $api_base_url;
    private $environment;
    private $success_url;
    private $failed_url;
    
    public function __construct() {
        // Load PayMongo config manually
        $config_file = APP_DIR . 'config/paymongo.php';
        
        if (!file_exists($config_file)) {
            throw new Exception('PayMongo configuration file not found');
        }
        
        include $config_file;
        
        if (!isset($config['paymongo'])) {
            throw new Exception('PayMongo configuration not found');
        }
        
        $paymongo_config = $config['paymongo'];
        
        $this->secret_key = $paymongo_config['secret_key'];
        $this->public_key = $paymongo_config['public_key'];
        $this->api_base_url = $paymongo_config['api_base_url'];
        $this->environment = $paymongo_config['environment'] ?? 'sandbox';
        $this->success_url = $paymongo_config['success_url'];
        $this->failed_url = $paymongo_config['failed_url'];
    }
    
    /**
     * Check if in sandbox mode
     */
    public function isSandbox() {
        return $this->environment === 'sandbox';
    }
    
    /**
     * Create GCash Payment Source
     * @param float $amount - Amount in centavos (already converted)
     * @param string $redirect_success
     * @param string $redirect_failed
     * @return array
     */
    public function createGCashSource($amount, $redirect_success = null, $redirect_failed = null) {
        $url = $this->api_base_url . '/sources';
        
        // Amount should already be in centavos
        $amount_in_centavos = (int)$amount;
        
        $data = [
            'data' => [
                'attributes' => [
                    'amount' => $amount_in_centavos,
                    'redirect' => [
                        'success' => $redirect_success ?: $this->success_url,
                        'failed' => $redirect_failed ?: $this->failed_url
                    ],
                    'type' => 'gcash',
                    'currency' => 'PHP',
                    'description' => 'CraftsHub Order Payment'
                ]
            ]
        ];
        
        $response = $this->makeRequest($url, 'POST', $data);
        
        if ($response['success'] && isset($response['data']['data'])) {
            $source_data = $response['data']['data'];
            return [
                'success' => true,
                'source_id' => $source_data['id'],
                'redirect_url' => $source_data['attributes']['redirect']['checkout_url'],
                'status' => $source_data['attributes']['status']
            ];
        } else {
            return [
                'success' => false,
                'message' => isset($response['data']['errors'][0]['detail']) 
                    ? $response['data']['errors'][0]['detail'] 
                    : 'Failed to create payment source'
            ];
        }
    }
    
    /**
     * Retrieve Source (for checking payment status)
     * @param string $source_id
     * @return array
     */
    public function retrieveSource($source_id) {
        $url = $this->api_base_url . "/sources/{$source_id}";
        $response = $this->makeRequest($url, 'GET');
        
        if ($response['success'] && isset($response['data']['data'])) {
            $source_data = $response['data']['data'];
            return [
                'success' => true,
                'status' => $source_data['attributes']['status'],
                'amount' => $source_data['attributes']['amount'] / 100,
                'source_id' => $source_data['id']
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to retrieve source'
            ];
        }
    }
    
    /**
     * Create Payment (charge the source)
     * @param string $source_id
     * @param float $amount - Amount in centavos
     * @param string $description
     * @return array
     */
    public function createPayment($source_id, $amount, $description = 'Order Payment') {
        $url = $this->api_base_url . '/payments';
        
        $amount_in_centavos = (int)$amount;
        
        $data = [
            'data' => [
                'attributes' => [
                    'amount' => $amount_in_centavos,
                    'source' => [
                        'id' => $source_id,
                        'type' => 'source'
                    ],
                    'currency' => 'PHP',
                    'description' => $description
                ]
            ]
        ];
        
        $response = $this->makeRequest($url, 'POST', $data);
        
        if ($response['success'] && isset($response['data']['data'])) {
            $payment_data = $response['data']['data'];
            return [
                'success' => true,
                'payment_id' => $payment_data['id'],
                'status' => $payment_data['attributes']['status'],
                'amount' => $payment_data['attributes']['amount'] / 100
            ];
        } else {
            return [
                'success' => false,
                'message' => isset($response['data']['errors'][0]['detail']) 
                    ? $response['data']['errors'][0]['detail'] 
                    : 'Failed to create payment'
            ];
        }
    }
    
    /**
     * Make HTTP Request to PayMongo API
     * @param string $url
     * @param string $method
     * @param array $data
     * @return array
     */
    private function makeRequest($url, $method = 'GET', $data = null) {
        $ch = curl_init();
        
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->secret_key . ':')
        ];
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local development
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        // Log for debugging in sandbox
        if ($this->isSandbox()) {
            error_log("PayMongo API Request: " . $method . " " . $url);
            if ($data) {
                error_log("PayMongo Request Data: " . json_encode($data));
            }
            error_log("PayMongo Response Code: " . $http_code);
            error_log("PayMongo Response: " . $response);
            if ($curl_error) {
                error_log("PayMongo cURL Error: " . $curl_error);
            }
        }
        
        $result = json_decode($response, true);
        
        return [
            'success' => $http_code >= 200 && $http_code < 300,
            'http_code' => $http_code,
            'data' => $result,
            'error' => $curl_error
        ];
    }
}
=======
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class PayMongo {
    
    private $secret_key;
    private $public_key;
    private $api_base_url;
    private $environment;
    private $success_url;
    private $failed_url;
    
    public function __construct() {
        // Load PayMongo config manually
        $config_file = APP_DIR . 'config/paymongo.php';
        
        if (!file_exists($config_file)) {
            throw new Exception('PayMongo configuration file not found');
        }
        
        include $config_file;
        
        if (!isset($config['paymongo'])) {
            throw new Exception('PayMongo configuration not found');
        }
        
        $paymongo_config = $config['paymongo'];
        
        $this->secret_key = $paymongo_config['secret_key'];
        $this->public_key = $paymongo_config['public_key'];
        $this->api_base_url = $paymongo_config['api_base_url'];
        $this->environment = $paymongo_config['environment'] ?? 'sandbox';
        $this->success_url = $paymongo_config['success_url'];
        $this->failed_url = $paymongo_config['failed_url'];
    }
    
    /**
     * Check if in sandbox mode
     */
    public function isSandbox() {
        return $this->environment === 'sandbox';
    }
    
    /**
     * Create GCash Payment Source
     * @param float $amount - Amount in centavos (already converted)
     * @param string $redirect_success
     * @param string $redirect_failed
     * @return array
     */
    public function createGCashSource($amount, $redirect_success = null, $redirect_failed = null) {
        $url = $this->api_base_url . '/sources';
        
        // Amount should already be in centavos
        $amount_in_centavos = (int)$amount;
        
        $data = [
            'data' => [
                'attributes' => [
                    'amount' => $amount_in_centavos,
                    'redirect' => [
                        'success' => $redirect_success ?: $this->success_url,
                        'failed' => $redirect_failed ?: $this->failed_url
                    ],
                    'type' => 'gcash',
                    'currency' => 'PHP',
                    'description' => 'CraftsHub Order Payment'
                ]
            ]
        ];
        
        $response = $this->makeRequest($url, 'POST', $data);
        
        if ($response['success'] && isset($response['data']['data'])) {
            $source_data = $response['data']['data'];
            return [
                'success' => true,
                'source_id' => $source_data['id'],
                'redirect_url' => $source_data['attributes']['redirect']['checkout_url'],
                'status' => $source_data['attributes']['status']
            ];
        } else {
            return [
                'success' => false,
                'message' => isset($response['data']['errors'][0]['detail']) 
                    ? $response['data']['errors'][0]['detail'] 
                    : 'Failed to create payment source'
            ];
        }
    }
    
    /**
     * Retrieve Source (for checking payment status)
     * @param string $source_id
     * @return array
     */
    public function retrieveSource($source_id) {
        $url = $this->api_base_url . "/sources/{$source_id}";
        $response = $this->makeRequest($url, 'GET');
        
        if ($response['success'] && isset($response['data']['data'])) {
            $source_data = $response['data']['data'];
            return [
                'success' => true,
                'status' => $source_data['attributes']['status'],
                'amount' => $source_data['attributes']['amount'] / 100,
                'source_id' => $source_data['id']
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to retrieve source'
            ];
        }
    }
    
    /**
     * Create Payment (charge the source)
     * @param string $source_id
     * @param float $amount - Amount in centavos
     * @param string $description
     * @return array
     */
    public function createPayment($source_id, $amount, $description = 'Order Payment') {
        $url = $this->api_base_url . '/payments';
        
        $amount_in_centavos = (int)$amount;
        
        $data = [
            'data' => [
                'attributes' => [
                    'amount' => $amount_in_centavos,
                    'source' => [
                        'id' => $source_id,
                        'type' => 'source'
                    ],
                    'currency' => 'PHP',
                    'description' => $description
                ]
            ]
        ];
        
        $response = $this->makeRequest($url, 'POST', $data);
        
        if ($response['success'] && isset($response['data']['data'])) {
            $payment_data = $response['data']['data'];
            return [
                'success' => true,
                'payment_id' => $payment_data['id'],
                'status' => $payment_data['attributes']['status'],
                'amount' => $payment_data['attributes']['amount'] / 100
            ];
        } else {
            return [
                'success' => false,
                'message' => isset($response['data']['errors'][0]['detail']) 
                    ? $response['data']['errors'][0]['detail'] 
                    : 'Failed to create payment'
            ];
        }
    }
    
    /**
     * Make HTTP Request to PayMongo API
     * @param string $url
     * @param string $method
     * @param array $data
     * @return array
     */
    private function makeRequest($url, $method = 'GET', $data = null) {
        $ch = curl_init();
        
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->secret_key . ':')
        ];
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local development
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        // Log for debugging in sandbox
        if ($this->isSandbox()) {
            error_log("PayMongo API Request: " . $method . " " . $url);
            if ($data) {
                error_log("PayMongo Request Data: " . json_encode($data));
            }
            error_log("PayMongo Response Code: " . $http_code);
            error_log("PayMongo Response: " . $response);
            if ($curl_error) {
                error_log("PayMongo cURL Error: " . $curl_error);
            }
        }
        
        $result = json_decode($response, true);
        
        return [
            'success' => $http_code >= 200 && $http_code < 300,
            'http_code' => $http_code,
            'data' => $result,
            'error' => $curl_error
        ];
    }
}
>>>>>>> da170f7 (sure to?)
