<?php
class Auth {
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
    }

    public static function login($user) {
        self::init();
        $_SESSION['user'] = $user;
        $_SESSION['last_activity'] = time();
    }

    public static function logout() {
        self::init();
        session_destroy();
    }

    public static function isLoggedIn() {
        self::init();
        return isset($_SESSION['user']);
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . APP_URL . '/public/login.php');
            exit;
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        if (!isset($_SESSION['user']['AccessLevelID']) || $_SESSION['user']['AccessLevelID'] < 4) {
            header('Location: ' . APP_URL . '/public/unauthorized.php');
            exit;
        }
    }

    public static function checkSessionTimeout() {
        self::init();
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
            self::logout();
            header('Location: ' . APP_URL . '/public/login.php?timeout=1');
            exit;
        }
        $_SESSION['last_activity'] = time();
    }

    public static function getCurrentUser() {
        self::init();
        return $_SESSION['user'] ?? null;
    }

    public static function hasPermission($permission) {
        self::init();
        if (!self::isLoggedIn()) {
            return false;
        }
        return isset($_SESSION['user']['permissions']) && 
               in_array($permission, $_SESSION['user']['permissions']);
    }

    public static function requirePermission($permission) {
        if (!self::hasPermission($permission)) {
            header('Location: ' . APP_URL . '/public/unauthorized.php');
            exit;
        }
    }
} 