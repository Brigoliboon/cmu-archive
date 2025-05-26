<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">User Details</h4>
                    <div>
                        <a href="<?= APP_URL ?>/admin/users/edit/<?= $user['id'] ?>" class="btn btn-warning mr-2">
                            <i class="ti-pencil"></i> Edit
                        </a>
                        <a href="<?= APP_URL ?>/admin/users" class="btn btn-light">
                            <i class="ti-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th style="width: 200px;">Username</th>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                            </tr>
                            <tr>
                                <th>Full Name</th>
                                <td>
                                    <?= htmlspecialchars($user['first_name'] . ' ' . 
                                        ($user['middle_name'] ? $user['middle_name'] . ' ' : '') . 
                                        $user['last_name'] . 
                                        ($user['extension'] ? ' ' . $user['extension'] : '')) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                            </tr>
                            <tr>
                                <th>Access Level</th>
                                <td><?= htmlspecialchars($user['access_level']) ?></td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td><?= date('F d, Y H:i:s', strtotime($user['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td><?= date('F d, Y H:i:s', strtotime($user['updated_at'])) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 