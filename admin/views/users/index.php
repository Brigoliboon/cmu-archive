<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Users</h4>
                    <a href="<?= APP_URL ?>/admin/users/create" class="btn btn-primary">
                        <i class="ti-plus"></i> Add New User
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Access Level</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td>
                                    <?= htmlspecialchars($user['first_name'] . ' ' . 
                                        ($user['middle_name'] ? $user['middle_name'] . ' ' : '') . 
                                        $user['last_name']) ?>
                                </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars($user['access_level']) ?></td>
                                <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= APP_URL ?>/admin/users/view/<?= $user['id'] ?>" 
                                           class="btn btn-info btn-sm" title="View">
                                            <i class="ti-eye"></i>
                                        </a>
                                        <a href="<?= APP_URL ?>/admin/users/edit/<?= $user['id'] ?>" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="ti-pencil"></i>
                                        </a>
                                        <form action="<?= APP_URL ?>/admin/users/delete/<?= $user['id'] ?>" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPages > 1): ?>
                <div class="d-flex justify-content-center mt-4">
                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.table').DataTable({
        "paging": false,
        "ordering": true,
        "info": false,
        "searching": true
    });
});
</script> 