<?php
require_once 'BaseController.php';
require_once '../models/User.php';
require_once '../../public/include/db_functions.php';

class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User($this->db);
    }

    public function index() {
        Auth::requireAdmin();
        
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        
        $users = $this->userModel->getAll($page, $limit);
        $totalUsers = $this->userModel->count();
        $totalPages = ceil($totalUsers / $limit);
        
        $this->render('users/index', [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'flash' => $this->getFlashMessage()
        ]);
    }

    public function create() {
        Auth::requireAdmin();
        
        global $conn;
        $accessLevels = getAllAccessLevels($conn);

        $this->render('users/create', [
            'flash' => $this->getFlashMessage(),
            'accessLevels' => $accessLevels
        ]);
    }

    public function store() {
        Auth::requireAdmin();
        $this->requirePost();

        $errors = $this->validateRequest(['username', 'password', 'firstName', 'lastName', 'email', 'role', 'accessLevel']);
        
        if (!empty($errors)) {
            $this->setFlashMessage('error', implode('<br>', $errors));
            $this->redirect(APP_URL . '/admin/users/create');
        }

        try {
            // Check if email already exists
            if ($this->userModel->findByEmail($_POST['email'])) {
                $this->setFlashMessage('error', 'Email address is already registered.');
                $this->redirect(APP_URL . '/admin/users/create');
            }

            $userId = $this->userModel->create($_POST);
            
            if ($userId) {
                $this->setFlashMessage('success', 'User created successfully.');
                $this->redirect(APP_URL . '/admin/users');
            } else {
                throw new Exception('Failed to create user.');
            }
        } catch (Exception $e) {
            $this->setFlashMessage('error', 'An error occurred while creating the user.');
            $this->redirect(APP_URL . '/admin/users/create');
        }
    }

    public function edit($id) {
        Auth::requireAdmin();
        
        global $conn;
        $accessLevels = getAllAccessLevels($conn);

        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->setFlashMessage('error', 'User not found.');
            $this->redirect(APP_URL . '/admin/users');
        }

        $this->render('users/edit', [
            'user' => $user,
            'flash' => $this->getFlashMessage(),
            'accessLevels' => $accessLevels
        ]);
    }

    public function update($id) {
        Auth::requireAdmin();
        $this->requirePost();

        $errors = $this->validateRequest(['username', 'firstName', 'lastName', 'email', 'role', 'accessLevel']);
        
        if (!empty($errors)) {
            $this->setFlashMessage('error', implode('<br>', $errors));
            $this->redirect(APP_URL . '/admin/users/edit/' . $id);
        }

        try {
            $success = $this->userModel->update($id, $_POST);
            
            if ($success) {
                $this->setFlashMessage('success', 'User updated successfully.');
                $this->redirect(APP_URL . '/admin/users');
            } else {
                throw new Exception('Failed to update user.');
            }
        } catch (Exception $e) {
            $this->setFlashMessage('error', 'An error occurred while updating the user.');
            $this->redirect(APP_URL . '/admin/users/edit/' . $id);
        }
    }

    public function delete($id) {
        Auth::requireAdmin();
        $this->requirePost();

        try {
            $success = $this->userModel->delete($id);
            
            if ($success) {
                $this->setFlashMessage('success', 'User deleted successfully.');
            } else {
                throw new Exception('Failed to delete user.');
            }
        } catch (Exception $e) {
            $this->setFlashMessage('error', 'An error occurred while deleting the user.');
        }

        $this->redirect(APP_URL . '/admin/users');
    }

    public function view($id) {
        Auth::requireAdmin();
        
        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->setFlashMessage('error', 'User not found.');
            $this->redirect(APP_URL . '/admin/users');
        }

        $this->render('users/view', [
            'user' => $user,
            'flash' => $this->getFlashMessage()
        ]);
    }
} 