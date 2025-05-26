<?php
class BaseController {
    protected $db;
    protected $user;
    protected $viewData;

    public function __construct() {
        global $conn;
        $this->db = $conn;
        $this->user = Auth::getCurrentUser();
        $this->viewData = [
            'user' => $this->user,
            'appName' => APP_NAME,
            'appUrl' => APP_URL
        ];
    }

    protected function render($view, $data = []) {
        // Merge view data with additional data
        $viewData = array_merge($this->viewData, $data);
        extract($viewData);

        // Start output buffering
        ob_start();
        
        // Include header
        include "../admin/views/partials/header.php";
        
        // Include the view
        include "../admin/views/{$view}.php";
        
        // Include footer
        include "../admin/views/partials/footer.php";
        
        // Get the contents and clean the buffer
        $content = ob_get_clean();
        
        // Output the content
        echo $content;
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function validateRequest($requiredFields) {
        $errors = [];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                $errors[] = ucfirst($field) . " is required";
            }
        }
        return $errors;
    }

    protected function setFlashMessage($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    protected function getFlashMessage() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    protected function requirePost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(APP_URL . '/public/unauthorized.php');
        }
    }

    protected function requireAjax() {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            $this->redirect(APP_URL . '/public/unauthorized.php');
        }
    }
} 