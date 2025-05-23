<?php
// File: public/view.php
// Include session management
require_once 'include/session.php';

// Require login
requireLogin();

// Check if document ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "No document specified.";
    header("Location: my-documents.php");
    exit;
}

$documentId = (int)$_GET['id'];

// Get document information
$document = getDocumentById($conn, $documentId);

// Check if document exists
if (!$document) {
    $_SESSION['error'] = "Document not found.";
    header("Location: my-documents.php");
    exit;
}

// Check if user has access to the document
if (!hasDocumentAccess($conn, $_SESSION['user_id'], $documentId)) {
    $_SESSION['error'] = "You do not have permission to view this document.";
    header("Location: my-documents.php");
    exit;
}

// Log the view action
$viewAccessTypeId = 1; // Assuming 1 is the ID for 'View' in accesstype table
logFileAccess($conn, $_SESSION['user_id'], $documentId, $viewAccessTypeId);

include 'include/header.php';
include 'include/sidebar.php';
?>

<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">
    <!-- Page Title -->
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold"><?php echo htmlspecialchars($document['Title']); ?></h3>
            <h6 class="font-weight-normal mb-0">
              Uploaded by: <?php echo htmlspecialchars($document['FirstName'] . ' ' . $document['LastName']); ?> | 
              Date: <?php echo date('Y-m-d H:i', strtotime($document['UploadDate'])); ?>
            </h6>
          </div>
          <div class="col-12 col-xl-4">
            <div class="justify-content-end d-flex">
              <a href="download.php?id=<?php echo $documentId; ?>" class="btn btn-primary mr-2">
                <i class="ti-download mr-1"></i> Download
              </a>
              <?php if ($_SESSION['user_id'] == $document['UserID'] || $_SESSION['user_role'] == 'admin'): ?>
              <a href="delete.php?id=<?php echo $documentId; ?>" class="btn btn-danger delete-doc">
                <i class="ti-trash mr-1"></i> Delete
              </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Document Details -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <p class="font-weight-bold">File Type:</p>
                <p><span class="badge badge-info"><?php echo strtoupper($document['FileType']); ?></span></p>
              </div>
              <div class="col-md-3">
                <p class="font-weight-bold">Category:</p>
                <p><?php echo $document['CategoryName'] ? htmlspecialchars($document['CategoryName']) : 'Uncategorized'; ?></p>
              </div>
              <div class="col-md-3">
                <p class="font-weight-bold">Access Level:</p>
                <p><?php echo htmlspecialchars($document['LevelName']); ?></p>
              </div>
              <div class="col-md-3">
                <p class="font-weight-bold">File Size:</p>
                <p><?php echo formatFileSize(filesize($document['FileLocation'])); ?></p>
              </div>
            </div>
            
            <?php if (!empty($document['FileTypeDescription'])): ?>
            <div class="row mt-3">
              <div class="col-md-12">
                <p class="font-weight-bold">Description:</p>
                <p><?php echo nl2br(htmlspecialchars($document['FileTypeDescription'])); ?></p>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Document Viewer -->
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Document Preview</h4>
            
            <div class="document-viewer">
              <?php
              $fileType = strtolower($document['FileType']);
              $filePath = $document['FileLocation'];
              
              if ($fileType == 'pdf') {
                // PDF viewer
                echo '<div class="embed-responsive embed-responsive-16by9">';
                echo '<iframe class="embed-responsive-item" src="' . $filePath . '" allowfullscreen></iframe>';
                echo '</div>';
              } else if ($fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'png') {
                // Image viewer
                echo '<div class="text-center">';
                echo '<img src="' . $filePath . '" class="img-fluid" alt="' . htmlspecialchars($document['Title']) . '">';
                echo '</div>';
              } else {
                echo '<div class="alert alert-warning">Preview not available for this file type. Please download the file to view it.</div>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to move this document to trash?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a href="#" id="confirm-delete" class="btn btn-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>

<script>
  // Script for delete confirmation
  $(document).ready(function() {
    $('.delete-doc').on('click', function(e) {
      e.preventDefault();
      var deleteUrl = $(this).attr('href');
      $('#confirm-delete').attr('href', deleteUrl);
      $('#deleteModal').modal('show');
    });
  });
</script>

<?php
include 'include/footer.php';
?>