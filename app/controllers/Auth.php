<<<<<<< HEAD
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller {

    public function __construct() {
        parent::__construct();
        
        // Start session for authentication
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Load User model
        $this->call->model('User');
    }

    /** 🔐 Login */
    public function login() {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            redirect('/admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (!empty($email) && !empty($password)) {
                // Check for admin credentials first
                if ($email === 'ascanlindon@gmail.com' && $password === 'ascanashe') {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_email'] = $email;
                    $_SESSION['admin_name'] = 'Admin User';
                    $_SESSION['success_message'] = 'Welcome back, Admin!';
                    redirect('/admin/dashboard');
                } else {
                    // Check database users (buyers)
                    $user = $this->User->get_user_by_email($email);
                    if ($user && $user->password === $password) {
                        // User found in database - log them in as buyer
                        $_SESSION['buyer_logged_in'] = true;
                        $_SESSION['buyer_id'] = $user->buyer_id;
                        $_SESSION['buyer_email'] = $user->email;
                        $_SESSION['buyer_name'] = $user->full_name;
                        $_SESSION['success_message'] = 'Welcome back, ' . $user->full_name . '!';
                        redirect('/buyer/dashboard');
                    } else {
                        $_SESSION['error_message'] = 'Invalid email or password.';
                    }
                }
            } else {
                $_SESSION['error_message'] = 'Please fill in all fields.';
            }
        }
        
        $this->call->view('auth/login');
    }

    /** 📝 Signup */
    public function signup() {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            redirect('/admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';


            if (!empty($full_name) && !empty($email) && !empty($phone_number) && !empty($password) && !empty($confirm_password)) {
                if ($password === $confirm_password) {
                    // Check if user already exists
                    $existing_user = $this->User->get_user_by_email($email);

                    if (!$existing_user && $email !== 'ascanlindon@gmail.com') {
                        // Create new user in database
                        $user_data = [
                            'full_name' => $full_name,
                            'email' => $email,
                            'phone_number' => $phone_number,
                            'password' => $password, // In production, use password_hash($password, PASSWORD_DEFAULT)
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        if ($this->User->create_user($user_data)) {
                            $_SESSION['success_message'] = 'Account created successfully! You can now login.';
                            redirect('/login');
                        } else {
                            $_SESSION['error_message'] = 'Failed to create account. Please try again.';
                        }
                    } else {
                        $_SESSION['error_message'] = 'Email already exists.';
                    }
                } else {
                    $_SESSION['error_message'] = 'Passwords do not match.';
                }
            } else {
                $_SESSION['error_message'] = 'Please fill in all fields.';
            }
        }
        
        $this->call->view('auth/signup');
    }

    /** 🚪 Logout */
    public function logout() {
        // Destroy session
        session_destroy();
        
        // Start new session for flash message
        session_start();
        $_SESSION['success_message'] = 'You have been logged out successfully.';
        
        redirect('/login');
    }

    /** Google Login */
    public function googleLogin() {
        require_once 'C:/wamp64/www/craftyshub/vendor/autoload.php';
        $client = new \Google_Client();
        $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri('http://localhost:4000/auth/google-callback');
        $client->addScope('email');
        $client->addScope('profile');
        $auth_url = $client->createAuthUrl();
        header('Location: ' . $auth_url);
        exit;
    }

    /** Google Callback */
    public function googleCallback() {
        require_once 'C:/wamp64/www/craftyshub/vendor/autoload.php';
        $client = new \Google_Client();
        $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri('http://localhost:4000/auth/google-callback');
        $client->addScope('email');
        $client->addScope('profile');
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['access_token'])) {
                $client->setAccessToken($token['access_token']);
                $oauth = new \Google_Service_Oauth2($client);
                $google_user = $oauth->userinfo->get();
                // Check if user exists
                $user = $this->User->get_user_by_email($google_user->email);
                if (!$user) {
                    // Create user
                    $new_user = [
                        'full_name' => $google_user->name,
                        'email' => $google_user->email,
                        'password' => '', // No password for Google login
                        'phone_number' => '',
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $this->User->create_user($new_user);
                    $user = $this->User->get_user_by_email($google_user->email);
                }
                // Log in user
                $_SESSION['buyer_logged_in'] = true;
                $_SESSION['buyer_id'] = $user->buyer_id;
                $_SESSION['buyer_email'] = $user->email;
                $_SESSION['buyer_name'] = $user->full_name;
                $_SESSION['success_message'] = 'Welcome back, ' . $user->full_name . '!';
                redirect('/buyer/dashboard');
            } else {
                // Token error
                $_SESSION['error_message'] = 'Google authentication failed.';
                redirect('/login');
            }
        } else {
            echo 'Google login failed.';
        }
    }
=======
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller {

    public function __construct() {
        parent::__construct();
        
        // Start session for authentication
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Load User model
        $this->call->model('User');
    }

    /** 🔐 Login */
    public function login() {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            redirect('/admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (!empty($email) && !empty($password)) {
                // Check for admin credentials first
                if ($email === 'ascanlindon@gmail.com' && $password === 'ascanashe') {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_email'] = $email;
                    $_SESSION['admin_name'] = 'Admin User';
                    $_SESSION['success_message'] = 'Welcome back, Admin!';
                    redirect('/admin/dashboard');
                } else {
                    // Check database users (buyers)
                    $user = $this->User->get_user_by_email($email);
                    if ($user && $user->password === $password) {
                        // User found in database - log them in as buyer
                        $_SESSION['buyer_logged_in'] = true;
                        $_SESSION['buyer_id'] = $user->buyer_id;
                        $_SESSION['buyer_email'] = $user->email;
                        $_SESSION['buyer_name'] = $user->full_name;
                        $_SESSION['success_message'] = 'Welcome back, ' . $user->full_name . '!';
                        redirect('/buyer/dashboard');
                    } else {
                        $_SESSION['error_message'] = 'Invalid email or password.';
                    }
                }
            } else {
                $_SESSION['error_message'] = 'Please fill in all fields.';
            }
        }
        
        $this->call->view('auth/login');
    }

    /** 📝 Signup */
    public function signup() {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            redirect('/admin/dashboard');
        }

        // Step 1: Registration details submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['otp'])) {
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (!empty($full_name) && !empty($email) && !empty($phone_number) && !empty($password) && !empty($confirm_password)) {
                if ($password === $confirm_password) {
                    // Check if user already exists
                    $existing_user = $this->User->get_user_by_email($email);
                    if (!$existing_user && $email !== 'ascanlindon@gmail.com') {
                        // Generate OTP
                        $otp = rand(100000, 999999);
                        $_SESSION['pending_registration'] = [
                            'full_name' => $full_name,
                            'email' => $email,
                            'phone_number' => $phone_number,
                            'password' => $password,
                            'created_at' => date('Y-m-d H:i:s'),
                            'otp' => $otp
                        ];
                        // Send OTP email
                        require_once __DIR__ . '/../helpers/email_helper.php';
                        require_once __DIR__ . '/../libraries/PHPMailer.php';
                        $config = get_email_config();
                        $mail = new PHPMailer\PHPMailer\PHPMailer();
                        $mail->isSMTP();
                        // $mail->SMTPDebug = 0; // Disable debug output for production
                        $mail->Host = $config['smtp_host'];
                        $mail->SMTPAuth = true;
                        $mail->Username = $config['smtp_user'];
                        $mail->Password = $config['smtp_pass'];
                        $mail->SMTPSecure = $config['smtp_crypto'];
                        $mail->Port = $config['smtp_port'];
                        $mail->setFrom($config['from_email'], $config['from_name']);
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Your CraftsHub OTP Code';
                        $mail->Body = '<p>Your OTP code is: <b>' . $otp . '</b></p>';
                        if ($mail->send()) {
                            $_SESSION['success_message'] = 'OTP sent to your email. Please enter it below.';
                        } else {
                            $_SESSION['error_message'] = 'Failed to send OTP. Debug: ' . $mail->ErrorInfo;
                        }
                        $this->call->view('auth/otp_verify');
                        return;
                    } else {
                        $_SESSION['error_message'] = 'Email already exists.';
                    }
                } else {
                    $_SESSION['error_message'] = 'Passwords do not match.';
                }
            } else {
                $_SESSION['error_message'] = 'Please fill in all fields.';
            }
        }

        // Step 2: OTP submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
            $entered_otp = $_POST['otp'] ?? '';
            if (isset($_SESSION['pending_registration'])) {
                $pending = $_SESSION['pending_registration'];
                if ($entered_otp == $pending['otp']) {
                    // Create user
                    $user_data = [
                        'full_name' => $pending['full_name'],
                        'email' => $pending['email'],
                        'phone_number' => $pending['phone_number'],
                        'password' => $pending['password'],
                        'created_at' => $pending['created_at']
                    ];
                    if ($this->User->create_user($user_data)) {
                        unset($_SESSION['pending_registration']);
                        $_SESSION['success_message'] = 'Account created successfully! You can now login.';
                        redirect('/login');
                    } else {
                        $_SESSION['error_message'] = 'Failed to create account. Please try again.';
                        $this->call->view('auth/otp_verify');
                        return;
                    }
                } else {
                    $_SESSION['error_message'] = 'Invalid OTP. Please try again.';
                    $this->call->view('auth/otp_verify');
                    return;
                }
            } else {
                $_SESSION['error_message'] = 'No registration in progress.';
                redirect('/signup');
            }
        }

        $this->call->view('auth/signup');
    }

    /** 🚪 Logout */
    public function logout() {
        // Destroy session
        session_destroy();
        
        // Start new session for flash message
        session_start();
        $_SESSION['success_message'] = 'You have been logged out successfully.';
        
        redirect('/login');
    }

    /** Google Login */
    public function googleLogin() {
        require_once 'C:/wamp64/www/craftyshub/vendor/autoload.php';
        $client = new \Google_Client();
        $client->setClientId('845656917784-jkqb35hivmfn995237ca3ihsuei6v3sg.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost:4000/auth/google-callback');
        $client->addScope('email');
        $client->addScope('profile');
        $auth_url = $client->createAuthUrl();
        header('Location: ' . $auth_url);
        exit;
    }

    /** Google Callback */
    public function googleCallback() {
        require_once 'C:/wamp64/www/craftyshub/vendor/autoload.php';
        $client = new \Google_Client();
        $client->setClientId('845656917784-jkqb35hivmfn995237ca3ihsuei6v3sg.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost:4000/auth/google-callback');
        $client->addScope('email');
        $client->addScope('profile');
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['access_token'])) {
                $client->setAccessToken($token['access_token']);
                $oauth = new \Google_Service_Oauth2($client);
                $google_user = $oauth->userinfo->get();
                // Check if user exists
                $user = $this->User->get_user_by_email($google_user->email);
                if (!$user) {
                    // Create user
                    $new_user = [
                        'full_name' => $google_user->name,
                        'email' => $google_user->email,
                        'password' => '', // No password for Google login
                        'phone_number' => '',
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $this->User->create_user($new_user);
                    $user = $this->User->get_user_by_email($google_user->email);
                }
                // Log in user
                $_SESSION['buyer_logged_in'] = true;
                $_SESSION['buyer_id'] = $user->buyer_id;
                $_SESSION['buyer_email'] = $user->email;
                $_SESSION['buyer_name'] = $user->full_name;
                $_SESSION['success_message'] = 'Welcome back, ' . $user->full_name . '!';
                redirect('/buyer/dashboard');
            } else {
                // Token error
                $_SESSION['error_message'] = 'Google authentication failed.';
                redirect('/login');
            }
        } else {
            echo 'Google login failed.';
        }
    }
>>>>>>> da170f7 (sure to?)
}