<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">
    <h2>Create New User</h2>

    <?php if (isset($flash['error'])): ?>
        <div class="alert alert-danger"><?php echo $flash['error']; ?></div>
    <?php endif; ?>

    <form action="<?php echo APP_URL; ?>/admin/users/store" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
        </div>
        <div class="mb-3">
            <label for="middleName" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middleName" name="middleName">
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
        </div>
        <div class="mb-3">
            <label for="extension" class="form-label">Extension</label>
            <input type="text" class="form-control" id="extension" name="extension">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="AccessLevelID" class="form-label">Access Level</label>
            <select class="form-select" id="AccessLevelID" name="AccessLevelID" required>
                <?php foreach ($accessLevels as $level): ?>
                    <option value="<?php echo $level['AccessLevelID']; ?>">
                        <?php echo $level['LevelName']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Create User</button>
        <a href="<?php echo APP_URL; ?>/admin/users" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 