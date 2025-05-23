<?php
// File: public/trash.php
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
            <h3 class="font-weight-bold">Trash</h3>
            <h6 class="font-weight-normal mb-0">View and restore deleted documents</h6>
          </div>
          <div class="col-12 col-xl-4">
            <div class="justify-content-end d-flex">
              <button class="btn btn-danger empty-trash">
                <i class="ti-trash mr-1"></i> Empty Trash
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Trash Table -->
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="trash-table">
                <thead>
                  <tr>
                    <th>Document Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Deleted Date</th>
                    <th>Actions</th>
                  </tr>  
                </thead>
                <tbody>
                  <?php
                  // Sample data - Would be replaced with actual data from database
                  $trash_documents = [
                    ['Old Report', 'PDF', '2.3 MB', '2023-06-01'],
                    ['Logo Draft', 'PNG', '0.8 MB', '2023-05-25'],
                    ['Client Meeting', 'PDF', '1.5 MB', '2023-05-20']
                  ];
                  
                  if (count($trash_documents) > 0) {
                    foreach ($trash_documents as $doc) {
                      echo '<tr>';
                      echo '<td>' . $doc[0] . '</td>';
                      echo '<td><span class="badge badge-info">' . $doc[1] . '</span></td>';
                      echo '<td>' . $doc[2] . '</td>';
                      echo '<td>' . $doc[3] . '</td>';
                      echo '<td>
                              <a href="restore.php?doc=' . urlencode($doc[0]) . '" class="btn btn-success btn-icon-text btn-sm">
                                <i class="ti-reload"></i> Restore
                              </a>
                              <a href="permanent-delete.php?doc=' . urlencode($doc[0]) . '" class="btn btn-danger btn-icon-text btn-sm permanent-delete">
                                <i class="ti-trash"></i> Delete Permanently
                              </a>
                            </td>';
                      echo '</tr>';
                    }
                  } else {
                    echo '<tr><td colspan="5" class="text-center">Your trash is empty</td></tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <?php if (count($trash_documents) > 0): ?>
            <!-- Trash Info -->
            <div class="mt-4 alert alert-info">
              <i class="ti-info-alt mr-2"></i>
              Documents in trash will be automatically deleted after 30 days.
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Permanent Delete Confirmation Modal -->
  <div class="modal fade" id="permanentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="permanentDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="permanentDeleteModalLabel">Confirm Permanent Deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to permanently delete this document? This action cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a href="#" id="confirm-permanent-delete" class="btn btn-danger">Delete Permanently</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Empty Trash Confirmation Modal -->
  <div class="modal fade" id="emptyTrashModal" tabindex="-1" role="dialog" aria-labelledby="emptyTrashModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="emptyTrashModalLabel">Empty Trash</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to empty the trash? All documents in trash will be permanently deleted. This action cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a href="empty-trash.php" class="btn btn-danger">Empty Trash</a>
        </div>
      </div>
    </div>
  </div>

<script>
  // Script for delete confirmation
  $(document).ready(function() {
    $('.permanent-delete').on('click', function(e) {
      e.preventDefault();
      var deleteUrl = $(this).attr('href');
      $('#confirm-permanent-delete').attr('href', deleteUrl);
      $('#permanentDeleteModal').modal('show');
    });
    
    $('.empty-trash').on('click', function(e) {
      e.preventDefault();
      $('#emptyTrashModal').modal('show');
    });
  });
</script>

<?php
include 'include/footer.php';
?>