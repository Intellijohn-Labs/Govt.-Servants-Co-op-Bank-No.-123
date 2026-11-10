<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="fw-bold mb-1">Administrative Control Center</h2>
    <p class="text-muted small mb-0">
      Managing: <span class="badge bg-primary text-white"><?= e(bank_name()) ?></span> (Client: <code><?= e(client_slug()) ?></code>)
    </p>
  </div>
  <div class="d-flex gap-2">
    <span class="badge bg-success-subtle text-success border border-success p-2">
      <i class="fa-solid fa-circle-check me-1"></i> Legal Mode: <?= strtoupper(setting('legal.entity_type')) ?>
    </span>
  </div>
</div>

<!-- Metrics Cards -->
<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="text-muted small fw-bold text-uppercase">Branches</span>
        <span class="p-2 bg-primary-subtle text-primary rounded-3"><i class="fa-solid fa-building"></i></span>
      </div>
      <div class="display-6 fw-bold text-dark"><?= (int)$branchCount ?></div>
      <div class="small text-muted mt-1"><i class="fa-solid fa-check text-success me-1"></i> Active physical centers</div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="text-muted small fw-bold text-uppercase">Products</span>
        <span class="p-2 bg-success-subtle text-success rounded-3"><i class="fa-solid fa-piggy-bank"></i></span>
      </div>
      <div class="display-6 fw-bold text-dark"><?= (int)$productCount ?></div>
      <div class="small text-muted mt-1"><i class="fa-solid fa-list-check me-1"></i> Published in catalogue</div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="text-muted small fw-bold text-uppercase">New Enquiries</span>
        <span class="p-2 bg-warning-subtle text-warning-emphasis rounded-3"><i class="fa-solid fa-bell"></i></span>
      </div>
      <div class="display-6 fw-bold text-warning-emphasis"><?= (int)$newEnquiries ?></div>
      <div class="small text-muted mt-1"><i class="fa-solid fa-clock me-1"></i> Awaiting staff action</div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="text-muted small fw-bold text-uppercase">Total Enquiries</span>
        <span class="p-2 bg-info-subtle text-info rounded-3"><i class="fa-solid fa-inbox"></i></span>
      </div>
      <div class="display-6 fw-bold text-dark"><?= (int)$enquiryCount ?></div>
      <div class="small text-muted mt-1"><i class="fa-solid fa-database me-1"></i> Lifetime tracked requests</div>
    </div>
  </div>
</div>

<!-- Recent Enquiries Table -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
  <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-envelope-open-text me-2 text-primary"></i> Recent Incoming Enquiries</h5>
    <span class="badge bg-light text-muted border">Latest 5</span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Tracking Code</th>
          <th>Applicant</th>
          <th>Branch</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($recentEnquiries)): ?>
          <?php foreach ($recentEnquiries as $enq): ?>
            <tr>
              <td><code class="fw-bold text-primary"><?= e($enq['tracking_code']) ?></code></td>
              <td>
                <div class="fw-bold text-dark"><?= e($enq['name']) ?></div>
                <div class="small text-muted"><?= e($enq['phone']) ?></div>
              </td>
              <td><?= e($enq['branch_name'] ?? 'Head Office') ?></td>
              <td>
                <span class="badge bg-light text-dark border"><?= e($enq['category']) ?></span>
                <span class="small text-muted ms-1"><?= e($enq['subject']) ?></span>
              </td>
              <td>
                <span class="badge bg-<?= $enq['status'] === 'new' ? 'warning text-dark' : 'success' ?> text-capitalize">
                  <?= e($enq['status']) ?>
                </span>
              </td>
              <td class="small text-muted"><?= format_date($enq['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center py-4 text-muted">No customer enquiries received yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
