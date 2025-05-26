<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database functions
require_once 'db_functions.php';

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to check if user is admin
function isAdmin() {
    // Check if user is logged in and has an AccessLevelID of 4 (Dean) or higher
    return isLoggedIn() && isset($_SESSION['AccessLevelID']) && $_SESSION['AccessLevelID'] >= 4;
}

// Function to require login
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = "You must be logged in to access this page.";
        header("Location: login.php");
        exit;
    }
}

// Function to require admin
function requireAdmin() {
    if (!isAdmin()) {
        $_SESSION['error'] = "You must be an administrator to access this page.";
        header("Location: ../public/index.php"); // Or wherever unauthorized users should be redirected
        exit;
    }
}

// Function to get current user
function getCurrentUser($conn) {
    if (isLoggedIn()) {
        return getUserById($conn, $_SESSION['user_id']);
    }
    return null;
}

// Function to set user session
function setUserSession($user) {
    $_SESSION['user_id'] = $user['id']; // Use new column name
    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name']; // Assuming these are fetched
    $_SESSION['user_email'] = $user['email']; // Use new column name
    $_SESSION['user_role'] = $user['role']; // Use new column name (still exists)
    $_SESSION['AccessLevelID'] = $user['AccessLevelID']; // Use new column name
}

// Function to clear user session
function clearUserSession() {
    session_unset();
    session_destroy();
}
?>