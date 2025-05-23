<?php
// File: admin/manage-documents.php
session_start();

// // Check if user is logged in and is admin
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//     header("Location: ../public/login.php");
//     exit;
// }

include 'include/header.php';
include 'include/admin-sidebar.php';
?>

<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">
    <!-- Page Title -->
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold">Document Management</h3>
            <h6 class="font-weight-normal mb-0">Manage all documents in the system</h6>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Filters -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body py-3">
            <div class="row">
              <div class="col-md-2">
                <select class="form-control" id="file-type-filter">
                  <option value="">All Types</option>
                  <option value="PDF">PDF</option>
                  <option value="PNG">PNG</option>
                  <option value="JPG">JPG</option>
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control" id="access-level-filter">
                  <option value="">All Access Levels</option>
                  <option value="1">Level 1</option>
                  <option value="2">Level 2</option>
                  <option value="3">Level 3</option>
                  <option value="4">Level 4</option>
                  <option value="5">Level 5</option>
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control" id="status-filter">
                  <option value="">All Status</option>
                  <option value="active">Active</option>
                  <option value="flagged">Flagged</option>
                  <option value="deleted">Deleted</option>
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control" id="date-filter">
                  <option value="">Any Date</option>
                  <option value="today">Today</option>
                  <option value="week">This Week</option>
                  <option value="month">This Month</option>
                  <option value="year">This Year</option>
                </select>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search documents...">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">Search</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Documents Table -->
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="documents-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Document Name</th>
                    <th>Type</th>
                    <th>Owner</th>
                    <th>Access Level</th>
                    <th>Uploaded Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>  
                </thead>
                <tbody>
                  <?php
                  // Sample data - Would be replaced with actual data from database
                  $documents = [
                    [1, 'Project Proposal', 'PDF', 'John Doe', 'Level 3', '2023-06-01', 'Active'],
                    [2, 'Financial Analysis', 'PDF', 'Maria Garcia', 'Level 2', '2023-05-28', 'Active'],
                    [3, 'Meeting Notes', 'PDF', 'Ahmed Khan', 'Level 5', '2023-05-20', 'Active'],
                    [4, 'Product Image', 'JPG', 'Lisa Wong', 'Level 1', '2023-05-15', 'Flagged'],
                    [5, 'Logo Design', 'PNG', 'Robert Smith', 'Level 3', '2023-05-10', 'Deleted'],
                    [6, 'Marketing Plan', 'PDF', 'Emma Johnson', 'Level 2', '2023-05-05', 'Active'],
                    [7, 'Client Portrait', 'JPG', 'Michael Brown', 'Level 5', '2023-04-30', 'Active'],
                    [8, 'Technical Diagram', 'PNG', 'Sophia Martinez', 'Level 4', '2023-04-25', 'Active'],
                    [9, 'Contract Document', 'PDF', 'John Doe', 'Level 3', '2023-04-20', 'Flagged'],
                    [10, 'Event Flyer', 'PNG', 'Maria Garcia', 'Level 2', '2023-04-15', 'Active']
                  ];
                  
                  foreach ($documents as $doc) {
                    $statusClass = '';
                    switch ($doc[6]) {
                      case 'Active':
                        $statusClass = 'badge-success';
                        break;
                      case 'Flagged':
                        $statusClass = 'badge-warning';
                        break;
                      case 'Deleted':
                        $statusClass = 'badge-danger';
                        break;
                    }
                    
                    echo '<tr>';
                    echo '<td>' . $doc[0] . '</td>';
                    echo '<td>' . $doc[1] . '</td>';
                    echo '<td><span class="badge badge-info">' . $doc[2] . '</span></td>';
                    echo '<td>' . $doc[3] . '</td>';
                    echo '<td>' . $doc[4] . '</td>';
                    echo '<td>' . $doc[5] . '</td>';
                    echo '<td><span class="badge ' . $statusClass . '">' . $doc[6] . '</span></td>';
                    echo '<td>
                            <a href="view-document.php?id=' . $doc[0] . '" class="btn btn-info btn-sm" title="View Document">
                              <i class="ti-eye"></i>
                            </a>
                            <a href="../public/download.php?id=' . $doc[0] . '" class="btn btn-primary btn-sm" title="Download">
                              <i class="ti-download"></i>
                            </a>';
                            
                    if ($doc[6] == 'Active') {
                      echo '<button type="button" class="btn btn-warning btn-sm flag-document" data-id="' . $doc[0] . '" title="Flag Document">
                              <i class="ti-flag-alt"></i>
                            </button>';
                    } else if ($doc[6] == 'Flagged') {
                      echo '<button type="button" class="btn btn-success btn-sm unflag-document" data-id="' . $doc[0] . '" title="Unflag Document">
                              <i class="ti-check"></i>
                            </button>';
                    }
                    
                    if ($doc[6] != 'Deleted') {
                      echo '<button type="button" class="btn btn-danger btn-sm delete-document" data-id="' . $doc[0] . '" title="Delete Document">
                              <i class="ti-trash"></i>
                            </button>';
                    } else {
                      echo '<button type="button" class="btn btn-success btn-sm restore-document" data-id="' . $doc[0] . '" title="Restore Document">
                              <i class="ti-reload"></i>
                            </button>';
                    }
                            
                    echo '</td>';
                    echo '</tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4">
              <nav>
                <ul class="pagination justify-content-center">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Flag Document Modal -->
  <div class="modal fade" id="flagDocumentModal" tabindex="-1" role="dialog" aria-labelledby="flagDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="flagDocumentModalLabel">Flag Document</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="flagDocumentForm" action="process-flag-document.php" method="post">
            <input type="hidden" id="documentId" name="documentId" value="">
            <div class="form-group">
              <label for="flagReason">Reason for Flagging</label>
              <select class="form-control" id="flagReason" name="flagReason" required>
                <option value="">-- Select Reason --</option>
                <option value="inappropriate">Inappropriate Content</option>
                <option value="copyright">Copyright Violation</option>
                <option value="confidential">Confidential Information</option>
                <option value="irrelevant">Irrelevant Content</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label for="flagComments">Additional Comments</label>
              <textarea class="form-control" id="flagComments" name="flagComments" rows="3"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-warning">Flag Document</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Document Modal -->
  <div class="modal fade" id="deleteDocumentModal" tabindex="-1" role="dialog" aria-labelledby="deleteDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteDocumentModalLabel">Delete Document</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this document?</p>
          <form id="deleteDocumentForm" action="process-delete-document.php" method="post">
            <input type="hidden" id="deleteDocumentId" name="documentId" value="">
            <div class="form-group">
              <label for="deleteReason">Reason for Deletion</label>
              <textarea class="form-control" id="deleteReason" name="deleteReason" rows="3" required></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete Document</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
  $(document).ready(function() {
    // Flag document
    $('.flag-document').on('click', function() {
      var documentId = $(this).data('id');
      $('#documentId').val(documentId);
      $('#flagDocumentModal').modal('show');
    });
    
    // Delete document
    $('.delete-document').on('click', function() {
      var documentId = $(this).data('id');
      $('#deleteDocumentId').val(documentId);
      $('#deleteDocumentModal').modal('show');
    });
    
    // Unflag document
    $('.unflag-document').on('click', function() {
      if (confirm('Are you sure you want to remove the flag from this document?')) {
        var documentId = $(this).data('id');
        // In a real application, you would make an AJAX call to update the status
        console.log('Unflagging document ' + documentId);
        // Reload page or update UI
      }
    });
    
    // Restore document
    $('.restore-document').on('click', function() {
      if (confirm('Are you sure you want to restore this document?')) {
        var documentId = $(this).data('id');
        // In a real application, you would make an AJAX call to update the status
        console.log('Restoring document ' + documentId);
        // Reload page or update UI
      }
    });

    // Initialize DataTable
    $('#documents-table').DataTable({
      "pageLength": 10,
      "lengthMenu": [10, 25, 50, 100],
      "order": [[ 0, "desc" ]],
      "language": {
        "search": "Search:",
        "lengthMenu": "Show _MENU_ entries per page",
        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
        "infoEmpty": "Showing 0 to 0 of 0 entries",
        "infoFiltered": "(filtered from _MAX_ total entries)"
      }
    });
  });
</script>

<?php
include 'include/footer.php';
?>