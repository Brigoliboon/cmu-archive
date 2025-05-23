<?php
// File: public/profile.php
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
            <h3 class="font-weight-bold">My Profile</h3>
            <h6 class="font-weight-normal mb-0">View and update your profile information</h6>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Profile Information -->
    <div class="row">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="../images/faces/face3.jpg" alt="Profile" class="rounded-circle" width="150">
              <div class="mt-3">
                <h4>John Doe</h4>
                <button class="btn btn-primary mt-2" id="changeAvatarBtn">Change Avatar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Profile Information</h4>
            <form class="forms-sample" action="update-profile.php" method="post">
              <div class="form-group row">
                <label for="firstName" class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="firstName" name="firstName" value="John" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="lastName" class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="lastName" name="lastName" value="Doe" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" value="john.doe@example.com" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-9">
                  <input type="tel" class="form-control" id="phone" name="phone" value="(123) 456-7890">
                </div>
              </div>
              <div class="form-group row">
                <label for="department" class="col-sm-3 col-form-label">Department</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="department" name="department" value="Marketing">
                </div>
              </div>
              <button type="submit" class="btn btn-primary mr-2">Update Profile</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Change Password -->
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Change Password</h4>
            <form class="forms-sample" action="change-password.php" method="post">
              <div class="form-group row">
                <label for="currentPassword" class="col-sm-3 col-form-label">Current Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="newPassword" class="col-sm-3 col-form-label">New Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm New Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mr-2">Change Password</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Avatar Upload Modal -->
  <div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="avatarModalLabel">Change Profile Picture</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="avatarForm" action="update-avatar.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Select New Image</label>
              <input type="file" name="avatarFile" class="file-upload-default" accept="image/jpeg, image/png" required>
              <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                <span class="input-group-append">
                  <button class="file-upload-browse btn btn-primary" type="button">Browse</button>
                </span>
              </div>
              <small class="form-text text-muted">Allowed file types: JPG, PNG | Maximum size: 2 MB</small>
            </div>
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-primary">Upload New Avatar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
  $(document).ready(function() {
    // Avatar change button
    $('#changeAvatarBtn').on('click', function() {
      $('#avatarModal').modal('show');
    });
    
    // File upload script
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
    <!-- Profile Information -->
    <div class="row">
      <div class="col-md-4