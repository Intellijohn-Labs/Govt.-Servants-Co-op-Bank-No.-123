<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">System & Security Audit Log</h3>
    <p class="text-muted small mb-0">Record of administrative logins, role assignments, and session security tracking.</p>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">User Name</th>
            <th class="py-3">Username</th>
            <th class="py-3">Assigned Role</th>
            <th class="py-3">Email Address</th>
            <th class="py-3">Last Access Timestamp</th>
            <th class="py-3">Access IP</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($users)): ?>
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">No audit entries found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($users as $u): ?>
              <tr>
                <td class="ps-3 fw-bold text-dark"><?= e($u['name']) ?></td>
                <td class="font-monospace small text-primary"><?= e($u['username']) ?></td>
                <td><span class="badge bg-primary-subtle text-primary"><?= e($u['role_name']) ?></span></td>
                <td class="small text-muted"><?= e($u['email']) ?></td>
                <td class="small text-muted font-monospace"><?= e($u['last_login_at'] ?? 'Never logged in') ?></td>
                <td class="small text-muted font-monospace"><?= e($u['last_login_ip'] ?? '127.0.0.1') ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
