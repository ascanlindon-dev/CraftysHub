<<<<<<< HEAD
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Revenue extends Model {
    protected $table = 'revenue';
    protected $transactionTable = 'revenue_transactions';
    protected $primaryKey = 'revenue_id';

    public function __construct() {
        parent::__construct();
    }

    // Get today's revenue
    public function get_today_revenue() {
        $today = date('Y-m-d');
        $result = $this->db->table($this->table)
                          ->where('date', $today)
                          ->select('daily_sales')
                          ->get(PDO::FETCH_OBJ);
        return $result ? $result->daily_sales : 0;
    }

    // Get total revenue from all time
    public function get_total_revenue() {
        $result = $this->db->table($this->table)
                          ->select('SUM(daily_sales) as total_revenue')
                          ->get(PDO::FETCH_OBJ);
        return $result && $result->total_revenue ? $result->total_revenue : 0;
    }

    // Get monthly revenue
    public function get_monthly_revenue($year = null, $month = null) {
        try {
            $year = $year ?: date('Y');
            $month = $month ?: date('m');
            
            // Use date range instead of SQL functions
            $startDate = "$year-$month-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $result = $this->db->table($this->table)
                              ->where('date', '>=', $startDate)
                              ->where('date', '<=', $endDate)
                              ->select('SUM(daily_sales) as monthly_revenue')
                              ->get(PDO::FETCH_OBJ);
            return $result && $result->monthly_revenue ? $result->monthly_revenue : 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    // Get revenue for last 7 days
    public function get_weekly_revenue() {
        try {
            $result = $this->db->table($this->table)
                              ->where('date', '>=', date('Y-m-d', strtotime('-7 days')))
                              ->select('SUM(daily_sales) as weekly_revenue')
                              ->get(PDO::FETCH_OBJ);
            return $result && $result->weekly_revenue ? $result->weekly_revenue : 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    // Get revenue statistics for dashboard
    public function get_revenue_stats() {
        return [
            'today' => $this->get_today_revenue(),
            'weekly' => $this->get_weekly_revenue(),
            'monthly' => $this->get_monthly_revenue(),
            'total' => $this->get_total_revenue()
        ];
    }

    // Get daily revenue data for charts
    public function get_daily_revenue_chart($days = 30) {
        try {
            $startDate = date('Y-m-d', strtotime("-$days days"));
            $results = $this->db->table($this->table)
                               ->where('date', '>=', $startDate)
                               ->select('date, daily_sales, total_orders')
                               ->order_by('date', 'ASC')
                               ->get_all(PDO::FETCH_OBJ);
            return $results ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    // Create or update daily revenue record
    public function upsert_daily_revenue($date, $data) {
        // Check if record exists
        $existing = $this->db->table($this->table)
                            ->where('date', $date)
                            ->get(PDO::FETCH_OBJ);
        
        if ($existing) {
            // Update existing record
            return $this->db->table($this->table)
                           ->where('date', $date)
                           ->update($data);
        } else {
            // Insert new record
            $data['date'] = $date;
            return $this->db->table($this->table)->insert($data);
        }
    }

    // Add revenue transaction
    public function add_transaction($transactionData) {
        return $this->db->table($this->transactionTable)->insert($transactionData);
    }

    // Get top performing days
    public function get_top_revenue_days($limit = 10) {
        return $this->db->table($this->table)
                       ->select('date, daily_sales, total_orders, average_order_value')
                       ->order_by('daily_sales', 'DESC')
                       ->limit($limit)
                       ->get_all(PDO::FETCH_OBJ);
    }

    // Calculate revenue from orders table (fallback method)
    public function calculate_revenue_from_orders() {
        try {
            $today = date('Y-m-d');
            
            // Today's revenue from orders - using date range instead of DATE() function
            $today_result = $this->db->table('orders')
                                   ->where('order_date', '>=', $today . ' 00:00:00')
                                   ->where('order_date', '<=', $today . ' 23:59:59')
                                   ->select('SUM(grand_total) as today_revenue, COUNT(*) as today_orders')
                                   ->get(PDO::FETCH_OBJ);
            
            // Total revenue from orders
            $total_result = $this->db->table('orders')
                                   ->select('SUM(grand_total) as total_revenue, COUNT(*) as total_orders')
                                   ->get(PDO::FETCH_OBJ);
            
            return [
                'today_revenue' => $today_result ? $today_result->today_revenue ?? 0 : 0,
                'today_orders' => $today_result ? $today_result->today_orders ?? 0 : 0,
                'total_revenue' => $total_result ? $total_result->total_revenue ?? 0 : 0,
                'total_orders' => $total_result ? $total_result->total_orders ?? 0 : 0
            ];
        } catch (Exception $e) {
            return [
                'today_revenue' => 0,
                'today_orders' => 0,
                'total_revenue' => 0,
                'total_orders' => 0
            ];
        }
    }

    // Sync revenue data from orders (maintenance function)
    public function sync_revenue_from_orders() {
        try {
            // Get daily revenue from orders table
            $daily_revenues = $this->db->table('orders')
                                     ->select('DATE(order_date) as order_date, 
                                             SUM(grand_total) as daily_sales,
                                             COUNT(*) as total_orders,
                                             AVG(grand_total) as average_order_value')
                                     ->group_by('DATE(order_date)')
                                     ->get_all(PDO::FETCH_OBJ);
            
            foreach ($daily_revenues as $daily) {
                $data = [
                    'daily_sales' => $daily->daily_sales,
                    'total_orders' => $daily->total_orders,
                    'average_order_value' => round($daily->average_order_value, 2),
                    'product_sales' => $daily->daily_sales, // Assuming all sales are product sales
                    'net_revenue' => $daily->daily_sales
                ];
                
                $this->upsert_daily_revenue($daily->order_date, $data);
            }
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Get recent revenue transactions
    public function get_recent_transactions($limit = 10) {
        try {
            $result = $this->db->table($this->transactionTable)
                              ->order_by('transaction_date', 'DESC')
                              ->limit($limit)
                              ->get_all(PDO::FETCH_OBJ);
            return $result ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    // Get revenue trends for charts (last N days)
    public function get_revenue_trends($days = 30) {
        try {
            $startDate = date('Y-m-d', strtotime("-$days days"));
            $result = $this->db->table($this->table)
                              ->where('date', '>=', $startDate)
                              ->select('date, daily_sales, total_orders')
                              ->order_by('date', 'ASC')
                              ->get_all(PDO::FETCH_OBJ);
            return $result ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    // Sync revenue data from orders table (alias for sync_revenue_from_orders)
    public function sync_from_orders() {
        return $this->sync_revenue_from_orders();
    }

    // Simple fallback methods that avoid complex SQL
    public function get_simple_revenue_stats() {
        try {
            // Get all revenue records to calculate manually
            $all_revenue = $this->db->table($this->table)
                                  ->select('date, daily_sales')
                                  ->order_by('date', 'DESC')
                                  ->get_all(PDO::FETCH_OBJ);
            
            if (empty($all_revenue)) {
                return [
                    'today' => 0,
                    'weekly' => 0,
                    'monthly' => 0,
                    'total' => 0
                ];
            }
            
            $today = date('Y-m-d');
            $week_ago = date('Y-m-d', strtotime('-7 days'));
            $month_start = date('Y-m-01');
            
            $today_revenue = 0;
            $weekly_revenue = 0;
            $monthly_revenue = 0;
            $total_revenue = 0;
            
            foreach ($all_revenue as $record) {
                $record_date = $record->date;
                $sales = floatval($record->daily_sales);
                
                $total_revenue += $sales;
                
                if ($record_date === $today) {
                    $today_revenue += $sales;
                }
                
                if ($record_date >= $week_ago) {
                    $weekly_revenue += $sales;
                }
                
                if ($record_date >= $month_start) {
                    $monthly_revenue += $sales;
                }
            }
            
            return [
                'today' => $today_revenue,
                'weekly' => $weekly_revenue,
                'monthly' => $monthly_revenue,
                'total' => $total_revenue
            ];
        } catch (Exception $e) {
            return [
                'today' => 0,
                'weekly' => 0,
                'monthly' => 0,
                'total' => 0
            ];
        }
    }
=======
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Revenue extends Model {
    protected $table = 'revenue';
    protected $transactionTable = 'revenue_transactions';
    protected $primaryKey = 'revenue_id';

    public function __construct() {
        parent::__construct();
    }

    // Get today's revenue
    public function get_today_revenue() {
        $today = date('Y-m-d');
        $result = $this->db->table($this->table)
                          ->where('date', $today)
                          ->select('daily_sales')
                          ->get(PDO::FETCH_OBJ);
        return $result ? $result->daily_sales : 0;
    }

    // Get total revenue from all time
    public function get_total_revenue() {
        $result = $this->db->table($this->table)
                          ->select('SUM(daily_sales) as total_revenue')
                          ->get(PDO::FETCH_OBJ);
        return $result && $result->total_revenue ? $result->total_revenue : 0;
    }

    // Get monthly revenue
    public function get_monthly_revenue($year = null, $month = null) {
        try {
            $year = $year ?: date('Y');
            $month = $month ?: date('m');
            
            // Use date range instead of SQL functions
            $startDate = "$year-$month-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $result = $this->db->table($this->table)
                              ->where('date', '>=', $startDate)
                              ->where('date', '<=', $endDate)
                              ->select('SUM(daily_sales) as monthly_revenue')
                              ->get(PDO::FETCH_OBJ);
            return $result && $result->monthly_revenue ? $result->monthly_revenue : 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    // Get revenue for last 7 days
    public function get_weekly_revenue() {
        try {
            $result = $this->db->table($this->table)
                              ->where('date', '>=', date('Y-m-d', strtotime('-7 days')))
                              ->select('SUM(daily_sales) as weekly_revenue')
                              ->get(PDO::FETCH_OBJ);
            return $result && $result->weekly_revenue ? $result->weekly_revenue : 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    // Get revenue statistics for dashboard
    public function get_revenue_stats() {
        return [
            'today' => $this->get_today_revenue(),
            'weekly' => $this->get_weekly_revenue(),
            'monthly' => $this->get_monthly_revenue(),
            'total' => $this->get_total_revenue()
        ];
    }

    // Get daily revenue data for charts
    public function get_daily_revenue_chart($days = 30) {
        try {
            $startDate = date('Y-m-d', strtotime("-$days days"));
            $results = $this->db->table($this->table)
                               ->where('date', '>=', $startDate)
                               ->select('date, daily_sales, total_orders')
                               ->order_by('date', 'ASC')
                               ->get_all(PDO::FETCH_OBJ);
            return $results ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    // Create or update daily revenue record
    public function upsert_daily_revenue($date, $data) {
        // Check if record exists
        $existing = $this->db->table($this->table)
                            ->where('date', $date)
                            ->get(PDO::FETCH_OBJ);
        
        if ($existing) {
            // Update existing record
            return $this->db->table($this->table)
                           ->where('date', $date)
                           ->update($data);
        } else {
            // Insert new record
            $data['date'] = $date;
            return $this->db->table($this->table)->insert($data);
        }
    }

    // Add revenue transaction
    public function add_transaction($transactionData) {
        return $this->db->table($this->transactionTable)->insert($transactionData);
    }

    // Get top performing days
    public function get_top_revenue_days($limit = 10) {
        return $this->db->table($this->table)
                       ->select('date, daily_sales, total_orders, average_order_value')
                       ->order_by('daily_sales', 'DESC')
                       ->limit($limit)
                       ->get_all(PDO::FETCH_OBJ);
    }

    // Calculate revenue from orders table (fallback method)
    public function calculate_revenue_from_orders() {
        try {
            $today = date('Y-m-d');
            
            // Today's revenue from orders - using date range instead of DATE() function
            $today_result = $this->db->table('orders')
                                   ->where('order_date', '>=', $today . ' 00:00:00')
                                   ->where('order_date', '<=', $today . ' 23:59:59')
                                   ->select('SUM(grand_total) as today_revenue, COUNT(*) as today_orders')
                                   ->get(PDO::FETCH_OBJ);
            
            // Total revenue from orders
            $total_result = $this->db->table('orders')
                                   ->select('SUM(grand_total) as total_revenue, COUNT(*) as total_orders')
                                   ->get(PDO::FETCH_OBJ);
            
            return [
                'today_revenue' => $today_result ? $today_result->today_revenue ?? 0 : 0,
                'today_orders' => $today_result ? $today_result->today_orders ?? 0 : 0,
                'total_revenue' => $total_result ? $total_result->total_revenue ?? 0 : 0,
                'total_orders' => $total_result ? $total_result->total_orders ?? 0 : 0
            ];
        } catch (Exception $e) {
            return [
                'today_revenue' => 0,
                'today_orders' => 0,
                'total_revenue' => 0,
                'total_orders' => 0
            ];
        }
    }

    // Sync revenue data from orders (maintenance function)
    public function sync_revenue_from_orders() {
        try {
            // Get daily revenue from orders table
            $daily_revenues = $this->db->table('orders')
                                     ->select('DATE(order_date) as order_date, 
                                             SUM(grand_total) as daily_sales,
                                             COUNT(*) as total_orders,
                                             AVG(grand_total) as average_order_value')
                                     ->group_by('DATE(order_date)')
                                     ->get_all(PDO::FETCH_OBJ);
            
            foreach ($daily_revenues as $daily) {
                $data = [
                    'daily_sales' => $daily->daily_sales,
                    'total_orders' => $daily->total_orders,
                    'average_order_value' => round($daily->average_order_value, 2),
                    'product_sales' => $daily->daily_sales, // Assuming all sales are product sales
                    'net_revenue' => $daily->daily_sales
                ];
                
                $this->upsert_daily_revenue($daily->order_date, $data);
            }
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Get recent revenue transactions
    public function get_recent_transactions($limit = 10) {
        try {
            $result = $this->db->table($this->transactionTable)
                              ->order_by('transaction_date', 'DESC')
                              ->limit($limit)
                              ->get_all(PDO::FETCH_OBJ);
            return $result ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    // Get revenue trends for charts (last N days)
    public function get_revenue_trends($days = 30) {
        try {
            $startDate = date('Y-m-d', strtotime("-$days days"));
            $result = $this->db->table($this->table)
                              ->where('date', '>=', $startDate)
                              ->select('date, daily_sales, total_orders')
                              ->order_by('date', 'ASC')
                              ->get_all(PDO::FETCH_OBJ);
            return $result ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    // Sync revenue data from orders table (alias for sync_revenue_from_orders)
    public function sync_from_orders() {
        return $this->sync_revenue_from_orders();
    }

    // Simple fallback methods that avoid complex SQL
    public function get_simple_revenue_stats() {
        try {
            // Get all revenue records to calculate manually
            $all_revenue = $this->db->table($this->table)
                                  ->select('date, daily_sales')
                                  ->order_by('date', 'DESC')
                                  ->get_all(PDO::FETCH_OBJ);
            
            if (empty($all_revenue)) {
                return [
                    'today' => 0,
                    'weekly' => 0,
                    'monthly' => 0,
                    'total' => 0
                ];
            }
            
            $today = date('Y-m-d');
            $week_ago = date('Y-m-d', strtotime('-7 days'));
            $month_start = date('Y-m-01');
            
            $today_revenue = 0;
            $weekly_revenue = 0;
            $monthly_revenue = 0;
            $total_revenue = 0;
            
            foreach ($all_revenue as $record) {
                $record_date = $record->date;
                $sales = floatval($record->daily_sales);
                
                $total_revenue += $sales;
                
                if ($record_date === $today) {
                    $today_revenue += $sales;
                }
                
                if ($record_date >= $week_ago) {
                    $weekly_revenue += $sales;
                }
                
                if ($record_date >= $month_start) {
                    $monthly_revenue += $sales;
                }
            }
            
            return [
                'today' => $today_revenue,
                'weekly' => $weekly_revenue,
                'monthly' => $monthly_revenue,
                'total' => $total_revenue
            ];
        } catch (Exception $e) {
            return [
                'today' => 0,
                'weekly' => 0,
                'monthly' => 0,
                'total' => 0
            ];
        }
    }
>>>>>>> da170f7 (sure to?)
}