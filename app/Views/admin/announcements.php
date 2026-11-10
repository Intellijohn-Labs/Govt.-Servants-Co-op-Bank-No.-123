<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Announcements & Emergency Alerts</h3>
    <p class="text-muted small mb-0">Control the top scrolling marquee ticker and urgent AGM/emergency popup modals.</p>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Type</th>
            <th class="py-3">Title (English)</th>
            <th class="py-3">Message (Malayalam)</th>
            <th class="py-3">Priority</th>
            <th class="py-3">Active Window</th>
            <th class="py-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($announcements)): ?>
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">No announcements found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($announcements as $a): ?>
              <tr>
                <td class="ps-3">
                  <span class="badge bg-<?= $a['type'] === 'ticker' ? 'warning text-dark' : 'danger' ?> text-uppercase">
                    <?= e($a['type']) ?>
                  </span>
                </td>
                <td class="fw-bold text-dark">
                  <?= e($a['title_en']) ?>
                  <div class="small text-muted text-truncate" style="max-width: 250px;"><?= e($a['message_en']) ?></div>
                </td>
                <td class="fw-medium text-dark small" style="max-width: 250px;">
                  <?= e($a['title_ml']) ?>
                  <div class="small text-muted text-truncate"><?= e($a['message_ml']) ?></div>
                </td>
                <td>
                  <span class="badge bg-<?= $a['priority'] === 'urgent' ? 'danger-subtle text-danger' : 'light text-muted border' ?>">
                    <?= e($a['priority']) ?>
                  </span>
                </td>
                <td class="small text-muted">
                  <?= date('d M Y', strtotime($a['start_date'])) ?> to <?= date('d M Y', strtotime($a['end_date'])) ?>
                </td>
                <td>
                  <span class="badge bg-<?= $a['is_active'] ? 'success' : 'secondary' ?>">
                    <?= $a['is_active'] ? 'Active' : 'Inactive' ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
