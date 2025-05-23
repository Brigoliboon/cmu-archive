<?php
// Include session management
require_once 'include/session.php';

// Require login
requireLogin();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST['documentTitle'] ?? '';
    $description = $_POST['documentDescription'] ?? '';
    $tags = $_POST['documentTags'] ?? '';
    
    // Validate form data
    if (empty($title)) {
        $_SESSION['error'] = "Please enter a document title.";
        header("Location: upload.php");
        exit;
    }
    
    // Check if file was uploaded
    if (!isset($_FILES['documentFile']) || $_FILES['documentFile']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Please select a file to upload.";
        header("Location: upload.php");
        exit;
    }
    
    // Get file information
    $file = $_FILES['documentFile'];
    $fileName = $file['name'];
    $fileTmpPath = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    
    // Get file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Check file extension
    $allowedExts = ['pdf', 'jpg', 'jpeg', 'png'];
    if (!in_array($fileExt, $allowedExts)) {
        $_SESSION['error'] = "Only PDF, JPG, and PNG files are allowed.";
        header("Location: upload.php");
        exit;
    }
    
    // Check file size (10MB max)
    $maxSize = 10 * 1024 * 1024; // 10MB in bytes
    if ($fileSize > $maxSize) {
        $_SESSION['error'] = "File size exceeds the maximum limit of 10MB.";
        header("Location: upload.php");
        exit;
    }
    
    // Create upload directory if it doesn't exist
    $uploadDir = '../uploads/' . $_SESSION['user_id'] . '/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generate unique filename
    $newFileName = uniqid() . '.' . $fileExt;
    $uploadPath = $uploadDir . $newFileName;
    
    // Move uploaded file
    if (move_uploaded_file($fileTmpPath, $uploadPath)) {
        // Standardize file extension for database
        if ($fileExt == 'jpeg') {
            $fileExt = 'jpg';
        }
        
        // Prepare document data
        $documentData = [
            'title' => $title,
            'fileType' => $fileExt,
            'description' => $description,
            'userId' => $_SESSION['user_id'],
            'accessLevel' => $_SESSION['user_access_level'] // Use user's access level by default
        ];
        
        // Add document to database
        $documentId = addDocument($conn, $documentData, $uploadPath);
        
        if ($documentId) {
            // Log the upload action
            $uploadAccessTypeId = 3; // Assuming 3 is the ID for 'Upload' in accesstype table
            logFileAccess($conn, $_SESSION['user_id'], $documentId, $uploadAccessTypeId);
            
            $_SESSION['success'] = "Document uploaded successfully.";
            header("Location: my-documents.php");
            exit;
        } else {
            // Delete the uploaded file if database insertion failed
            unlink($uploadPath);
            
            $_SESSION['error'] = "Failed to add document to database.";
            header("Location: upload.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Failed to upload file.";
        header("Location: upload.php");
        exit;
    }
} else {
    // If not a POST request, redirect to upload page
    header("Location: upload.php");
    exit;
}
?>