<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'dams_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application configuration
define('APP_NAME', 'DAMS');
define('APP_URL', 'http://localhost/dams');
define('APP_DEBUG', true);

// Session configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_NAME', 'DAMS_SESSION');

// Security configuration
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_HASH_COST', 12);

// File upload configuration
define('UPLOAD_MAX_SIZE', 10485760); // 10MB
define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);

// Error reporting
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Time zone
date_default_timezone_set('Asia/Manila'); 