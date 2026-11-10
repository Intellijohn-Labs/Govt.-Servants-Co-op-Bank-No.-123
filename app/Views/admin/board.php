<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Board of Directors & Executives</h3>
    <p class="text-muted small mb-0">Manage the democratically elected governance team, designations, and contact profiles.</p>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Order</th>
            <th class="py-3">Name (English)</th>
            <th class="py-3">Name (Malayalam)</th>
            <th class="py-3">Designation</th>
            <th class="py-3">Role Type</th>
            <th class="py-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($members)): ?>
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">No board members recorded.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($members as $m): ?>
              <tr>
                <td class="ps-3 font-monospace small"><?= (int)$m['sort_order'] ?></td>
                <td class="fw-bold text-dark"><?= e($m['name_en']) ?></td>
                <td class="fw-medium text-dark small"><?= e($m['name_ml']) ?></td>
                <td>
                  <div class="fw-semibold text-dark"><?= e($m['designation_en']) ?></div>
                  <div class="text-muted small"><?= e($m['designation_ml']) ?></div>
                </td>
                <td>
                  <span class="badge bg-primary-subtle text-primary text-uppercase"><?= e($m['role_type']) ?></span>
                </td>
                <td>
                  <span class="badge bg-<?= $m['status'] === 'active' ? 'success' : 'secondary' ?> text-uppercase"><?= e($m['status']) ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
