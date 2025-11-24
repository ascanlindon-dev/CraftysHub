<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Revenue Migration Command
 * 
 * Creates revenue tables and initializes data from existing orders
 * 
 * Usage: php console/cli.php revenue:setup
 */

class Revenue_migration {

    private $db;

    public function __construct() {
        // Initialize database connection
        $config = [
            'host' => 'localhost',
            'database' => 'craftify',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4'
        ];

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
            $this->db = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Setup revenue tables and initialize data
     */
    public function setup() {
        echo "🚀 Starting Revenue Tables Setup...\n\n";
        
        try {
            $this->createRevenueTables();
            $this->initializeRevenueData();
            $this->showSummary();
            
            echo "\n✨ Revenue setup completed successfully!\n";
            echo "🎯 Access your revenue dashboard at: /admin/revenue\n\n";
            
        } catch (Exception $e) {
            echo "❌ Setup failed: " . $e->getMessage() . "\n";
            return false;
        }
        
        return true;
    }

    /**
     * Create revenue tables
     */
    private function createRevenueTables() {
        echo "📊 Creating revenue tables...\n";

        // Revenue table
        $revenueTable = "
        CREATE TABLE IF NOT EXISTS `revenue` (
          `revenue_id` int(11) NOT NULL AUTO_INCREMENT,
          `date` date NOT NULL,
          `daily_sales` decimal(12,2) NOT NULL DEFAULT 0.00,
          `total_orders` int(11) NOT NULL DEFAULT 0,
          `average_order_value` decimal(10,2) NOT NULL DEFAULT 0.00,
          `product_sales` decimal(12,2) NOT NULL DEFAULT 0.00,
          `net_revenue` decimal(12,2) NOT NULL DEFAULT 0.00,
          `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`revenue_id`),
          UNIQUE KEY `unique_date` (`date`),
          KEY `idx_date` (`date`),
          KEY `idx_daily_sales` (`daily_sales`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        // Revenue transactions table
        $transactionsTable = "
        CREATE TABLE IF NOT EXISTS `revenue_transactions` (
          `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
          `order_id` int(11) DEFAULT NULL,
          `transaction_type` enum('sale','refund','adjustment') NOT NULL DEFAULT 'sale',
          `amount` decimal(10,2) NOT NULL,
          `description` varchar(255) DEFAULT NULL,
          `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `created_by` varchar(100) DEFAULT 'system',
          `metadata` json DEFAULT NULL,
          PRIMARY KEY (`transaction_id`),
          KEY `idx_order_id` (`order_id`),
          KEY `idx_transaction_date` (`transaction_date`),
          KEY `idx_transaction_type` (`transaction_type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        $this->db->exec($revenueTable);
        echo "  ✅ Revenue table created\n";

        $this->db->exec($transactionsTable);
        echo "  ✅ Revenue transactions table created\n";
    }

    /**
     * Initialize revenue data from existing orders
     */
    private function initializeRevenueData() {
        echo "💾 Initializing revenue data from existing orders...\n";

        // Initialize daily revenue summary
        $revenueInit = "
        INSERT IGNORE INTO revenue (date, daily_sales, total_orders, average_order_value, product_sales, net_revenue)
        SELECT 
            DATE(order_date) as date,
            SUM(grand_total) as daily_sales,
            COUNT(*) as total_orders,
            AVG(grand_total) as average_order_value,
            SUM(grand_total) as product_sales,
            SUM(grand_total) as net_revenue
        FROM orders 
        WHERE order_date IS NOT NULL AND grand_total > 0
        GROUP BY DATE(order_date)
        ORDER BY DATE(order_date)
        ";

        $stmt = $this->db->prepare($revenueInit);
        $stmt->execute();
        $daysCreated = $stmt->rowCount();
        echo "  ✅ Created revenue records for {$daysCreated} days\n";

        // Initialize revenue transactions
        $transactionInit = "
        INSERT IGNORE INTO revenue_transactions (order_id, transaction_type, amount, description, transaction_date, created_by)
        SELECT 
            order_id,
            'sale' as transaction_type,
            grand_total as amount,
            CONCAT('Order #', order_number, ' - ', UPPER(status)) as description,
            order_date as transaction_date,
            'migration' as created_by
        FROM orders 
        WHERE order_date IS NOT NULL AND grand_total > 0
        ORDER BY order_date
        ";

        $stmt = $this->db->prepare($transactionInit);
        $stmt->execute();
        $transactionsCreated = $stmt->rowCount();
        echo "  ✅ Created {$transactionsCreated} revenue transactions\n";
    }

    /**
     * Show revenue summary
     */
    private function showSummary() {
        echo "\n📈 Revenue Summary:\n";

        $summary = $this->db->query("
            SELECT 
                COUNT(*) as total_days,
                COALESCE(SUM(daily_sales), 0) as total_revenue,
                COALESCE(AVG(daily_sales), 0) as avg_daily_revenue,
                COALESCE(MAX(daily_sales), 0) as best_day,
                COALESCE(SUM(total_orders), 0) as total_orders,
                DATE(MIN(date)) as earliest_date,
                DATE(MAX(date)) as latest_date
            FROM revenue
        ")->fetch();

        $transactionCount = $this->db->query("SELECT COUNT(*) as count FROM revenue_transactions")->fetch()['count'];

        echo "  📅 Date range: {$summary['earliest_date']} to {$summary['latest_date']}\n";
        echo "  📊 Days tracked: {$summary['total_days']}\n";
        echo "  💰 Total revenue: ₱" . number_format($summary['total_revenue'], 2) . "\n";
        echo "  📈 Average daily: ₱" . number_format($summary['avg_daily_revenue'], 2) . "\n";
        echo "  🎯 Best single day: ₱" . number_format($summary['best_day'], 2) . "\n";
        echo "  📦 Total orders: " . number_format($summary['total_orders']) . "\n";
        echo "  🧾 Transactions logged: " . number_format($transactionCount) . "\n";
    }

    /**
     * Drop revenue tables (for testing/reset)
     */
    public function reset() {
        echo "⚠️  Resetting revenue tables...\n";
        
        try {
            $this->db->exec("SET FOREIGN_KEY_CHECKS = 0");
            $this->db->exec("DROP TABLE IF EXISTS revenue_transactions");
            $this->db->exec("DROP TABLE IF EXISTS revenue");
            $this->db->exec("SET FOREIGN_KEY_CHECKS = 1");
            
            echo "✅ Revenue tables dropped successfully\n";
            echo "💡 Run 'php console/cli.php revenue:setup' to recreate them\n\n";
        } catch (Exception $e) {
            echo "❌ Reset failed: " . $e->getMessage() . "\n";
            return false;
        }
        
        return true;
    }

    /**
     * Check revenue tables status
     */
    public function status() {
        echo "🔍 Checking revenue tables status...\n\n";

        $tables = ['revenue', 'revenue_transactions'];
        
        foreach ($tables as $table) {
            try {
                $result = $this->db->query("SELECT COUNT(*) as count FROM {$table}")->fetch();
                echo "✅ Table '{$table}': {$result['count']} records\n";
                
                if ($table === 'revenue' && $result['count'] > 0) {
                    $latest = $this->db->query("SELECT MAX(date) as latest_date FROM revenue")->fetch();
                    echo "   📅 Latest date: {$latest['latest_date']}\n";
                }
            } catch (Exception $e) {
                echo "❌ Table '{$table}': Not found or error\n";
            }
        }
        
        echo "\n";
    }
}

// Command execution for direct calls
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    
        $this->db->exec($revenueTable);
        echo "  ✅ Revenue table created\n";

        $this->db->exec($transactionsTable);
        echo "  ✅ Revenue transactions table created\n";
    }

    /**
     * Initialize revenue data from existing orders
     */
     function initializeRevenueData() {
        echo "💾 Initializing revenue data from existing orders...\n";

        // Initialize daily revenue summary
        $revenueInit = "
        INSERT IGNORE INTO revenue (date, daily_sales, total_orders, average_order_value, product_sales, net_revenue)
        SELECT 
            DATE(order_date) as date,
            SUM(grand_total) as daily_sales,
            COUNT(*) as total_orders,
            AVG(grand_total) as average_order_value,
            SUM(grand_total) as product_sales,
            SUM(grand_total) as net_revenue
        FROM orders 
        WHERE order_date IS NOT NULL AND grand_total > 0
        GROUP BY DATE(order_date)
        ORDER BY DATE(order_date)
        ";

        $stmt = $this->db->prepare($revenueInit);
        $stmt->execute();
        $daysCreated = $stmt->rowCount();
        echo "  ✅ Created revenue records for {$daysCreated} days\n";

        // Initialize revenue transactions
        $transactionInit = "
        INSERT IGNORE INTO revenue_transactions (order_id, transaction_type, amount, description, transaction_date, created_by)
        SELECT 
            order_id,
            'sale' as transaction_type,
            grand_total as amount,
            CONCAT('Order #', order_number, ' - ', UPPER(status)) as description,
            order_date as transaction_date,
            'migration' as created_by
        FROM orders 
        WHERE order_date IS NOT NULL AND grand_total > 0
        ORDER BY order_date
        ";
    }



// Command execution for direct calls
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $command = $argv[1] ?? 'setup';
    $migration = new Revenue_migration();
    switch ($command) {
        case 'setup':
            $migration->setup();
            break;
        case 'reset':
            $migration->reset();
            break;
        case 'status':
            $migration->status();
            break;
        default:
            echo "Usage: php revenue_migration.php [setup|reset|status]\n";
            echo "  setup  - Create tables and initialize data\n";
            echo "  reset  - Drop all revenue tables\n";
            echo "  status - Check tables status\n\n";
    }
}