<?php
// Load configuration
require_once __DIR__ . '/../config/config.php';

// Load core functions
require_once __DIR__ . '/database/connection.php';
require_once __DIR__ . '/middleware/auth.php';

// Load models
require_once __DIR__ . '/../models/User.php';

// Load controllers
require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../controllers/UserController.php';

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Set error handling
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    
    switch ($errno) {
        case E_USER_ERROR:
            error_log("Error [$errno] $errstr on line $errline in file $errfile");
            if (APP_DEBUG) {
                die("Fatal Error: [$errno] $errstr on line $errline in file $errfile");
            } else {
                die("A fatal error occurred. Please try again later.");
            }
            break;
            
        case E_USER_WARNING:
            error_log("Warning [$errno] $errstr on line $errline in file $errfile");
            break;
            
        case E_USER_NOTICE:
            error_log("Notice [$errno] $errstr on line $errline in file $errfile");
            break;
            
        default:
            error_log("Unknown error type: [$errno] $errstr on line $errline in file $errfile");
            break;
    }
    
    return true;
});

// Set exception handling
set_exception_handler(function($exception) {
    error_log("Uncaught Exception: " . $exception->getMessage() . "\n" . $exception->getTraceAsString());
    if (APP_DEBUG) {
        die("Uncaught Exception: " . $exception->getMessage() . "\n" . $exception->getTraceAsString());
    } else {
        die("An unexpected error occurred. Please try again later.");
    }
});

// Initialize database connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Check session timeout
Auth::checkSessionTimeout(); 