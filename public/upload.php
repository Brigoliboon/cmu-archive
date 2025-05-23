<?php
// File: public/upload.php
// Include session management
require_once 'include/session.php';

// Require login
requireLogin();

// Get categories for the form
$categories = getAllCategories($conn);

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
            <h3 class="font-weight-bold">Upload Documents</h3>
            <h6 class="font-weight-normal mb-0">Upload new documents to your archive</h6>
          </div>
        </div>
      </div>
    </div>
    
    <?php
    // Display error message if any
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }
    
    // Display success message if any
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }
    ?>
    
    <!-- Upload Form -->
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Upload New Document</h4>
            <p class="card-description">
              Supported file types: PDF, JPG, PNG | Max file size: 10MB
            </p>
            
            <form class="forms-sample" action="process-upload.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="documentTitle">Document Title</label>
                <input type="text" class="form-control" id="documentTitle" name="documentTitle" placeholder="Enter document title" required>
              </div>
              
              <div class="form-group">
                <label for="documentDescription">Description (Optional)</label>
                <textarea class="form-control" id="documentDescription" name="documentDescription" rows="4" placeholder="Enter a brief description of the document"></textarea>
              </div>
              
              <div class="form-group">
                <label for="category">Category (Optional)</label>
                <select class="form-control" id="category" name="categoryId">
                  <option value="">-- Select Category --</option>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['CategoryID']; ?>"><?php echo htmlspecialchars($category['CategoryName']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="form-group">
                <label>Document File</label>
                <input type="file" name="documentFile" class="file-upload-default" required>
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Document">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Select File</button>
                  </span>
                </div>
                <small class="form-text text-muted">Allowed file types: PDF, JPG, PNG | Maximum size: 10 MB</small>
              </div>
              
              <div class="form-group">
                <label for="documentTags">Tags (Optional)</label>
                <input type="text" class="form-control" id="documentTags" name="documentTags" placeholder="Enter tags separated by commas">
                <small class="form-text text-muted">Example: report, 2023, financial</small>
              </div>
              
              <button type="submit" class="btn btn-primary mr-2">Upload Document</button>
              <a href="index.php" class="btn btn-light">Cancel</a>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Upload Tips -->
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Upload Tips</h4>
            <ul class="list-arrow">
              <li>Use descriptive file names for better organization</li>
              <li>Add relevant tags to improve searchability</li>
              <li>Make sure your PDF files are searchable for better text extraction</li>
              <li>Compress large image files before uploading for faster viewing</li>
              <li>For scanned documents, ensure good quality for better readability</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
  // File upload script
  $(document).ready(function() {
    $('.file-upload-browse').on('click', function() {
      var file = $(this).parent().parent().parent().find('.file-upload-default');
      file.trigger('click');
    });
    
    $('.file-upload-default').on('change', function() {
      var fileName = $(this).val().split('\\').pop();
      $(this).parent().find('.form-control').val(fileName);
    });
  });
</script>

<?php
include 'include/footer.php';
?>