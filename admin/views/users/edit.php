<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit User</h4>
                <form class="forms-sample" action="<?= APP_URL ?>/admin/users/update/<?= $user['id'] ?>" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" 
                               value="<?= htmlspecialchars($user['first_name']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" class="form-control" id="middleName" name="middleName" 
                               value="<?= htmlspecialchars($user['middle_name'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" 
                               value="<?= htmlspecialchars($user['last_name']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="extension">Name Extension</label>
                        <input type="text" class="form-control" id="extension" name="extension" 
                               value="<?= htmlspecialchars($user['extension'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Regular User</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="AccessLevelID">Access Level</label>
                        <select class="form-control" id="AccessLevelID" name="AccessLevelID" required>
                            <option value="">Select Access Level</option>
                            <?php foreach ($accessLevels as $level): ?>
                                <option value="<?= $level['AccessLevelID'] ?>" 
                                    <?= $user['AccessLevelID'] === $level['AccessLevelID'] ? 'selected' : '' ?>>
                                    <?= $level['LevelName'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    <a href="<?= APP_URL ?>/admin/users" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div> 