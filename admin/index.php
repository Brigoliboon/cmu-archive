<?php
// Load bootstrap file
require_once __DIR__ . '/core/bootstrap.php';
require_once __DIR__ . '/core/router.php';

// Initialize controllers
$userController = new UserController();

// Define routes
Router::get('/', function() use ($userController) {
    $userController->index();
});

Router::get('/users', function() use ($userController) {
    $userController->index();
});

Router::get('/users/create', function() use ($userController) {
    $userController->create();
});

Router::post('/users/store', function() use ($userController) {
    $userController->store();
});

Router::get('/users/edit/{id}', function($id) use ($userController) {
    $userController->edit($id);
});

Router::post('/users/update/{id}', function($id) use ($userController) {
    $userController->update($id);
});

Router::post('/users/delete/{id}', function($id) use ($userController) {
    $userController->delete($id);
});

Router::get('/users/view/{id}', function($id) use ($userController) {
    $userController->view($id);
});

// Dispatch the request
Router::dispatch(); 