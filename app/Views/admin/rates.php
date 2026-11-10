<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Unified Rate Engine</h3>
    <p class="text-muted small mb-0">Centralized control of all deposit tenures and lending interest rate schedules with automatic live synchronization.</p>
  </div>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRateModal">
    <i class="fa-solid fa-plus me-1"></i> Add New Rate Slab
  </button>
</div>

<!-- Deposit Rates Section -->
<div class="card border-0 shadow-sm mb-5">
  <div class="card-header bg-light py-3 border-bottom d-flex justify-content-between align-items-center">
    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-piggy-bank text-primary me-2"></i> Term Deposit Interest Rate Slabs</h5>
    <span class="badge bg-primary rounded-pill"><?= count($depositRates) ?> Slabs</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Tenure (English)</th>
            <th class="py-3">Tenure (Malayalam)</th>
            <th class="py-3">General Public Rate</th>
            <th class="py-3">Senior Citizen Bonus Rate</th>
            <th class="py-3">Effective From</th>
            <th class="py-3 text-end pe-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($depositRates as $dr): ?>
            <tr>
              <td class="ps-3 fw-bold text-dark"><?= e($dr['tenure_label_en']) ?></td>
              <td class="fw-medium text-dark small"><?= e($dr['tenure_label_ml']) ?></td>
              <td><span class="badge bg-primary-subtle text-primary fs-6 px-3 py-1"><?= number_format((float)$dr['general_rate'], 2) ?> %</span></td>
              <td>
                <?php if ($dr['senior_rate']): ?>
                  <span class="badge bg-success-subtle text-success fs-6 px-3 py-1"><?= number_format((float)$dr['senior_rate'], 2) ?> %</span>
                <?php else: ?>
                  <span class="text-muted small">Same as general</span>
                <?php endif; ?>
              </td>
              <td class="small text-muted"><?= date('d M Y', strtotime($dr['effective_from'])) ?></td>
              <td class="text-end pe-3">
                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editRateModal<?= $dr['id'] ?>">
                  <i class="fa-solid fa-pen-to-square"></i> Edit
                </button>
                <form action="/admin/rates/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this rate slab?')">
                  <?= csrf_field() ?>
                  <input type="hidden" name="id" value="<?= $dr['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
              </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editRateModal<?= $dr['id'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="/admin/rates/save" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $dr['id'] ?>">
                    <input type="hidden" name="category_type" value="deposit">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold">Edit Deposit Rate Slab</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label small fw-bold">Tenure (English)</label>
                        <input type="text" name="tenure_label_en" class="form-control" value="<?= e($dr['tenure_label_en']) ?>" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label small fw-bold">Tenure (Malayalam)</label>
                        <input type="text" name="tenure_label_ml" class="form-control" value="<?= e($dr['tenure_label_ml']) ?>" required>
                      </div>
                      <div class="row g-2 mb-3">
                        <div class="col-6">
                          <label class="form-label small fw-bold">General Rate (% p.a.)</label>
                          <input type="number" step="0.05" name="general_rate" class="form-control" value="<?= e($dr['general_rate']) ?>" required>
                        </div>
                        <div class="col-6">
                          <label class="form-label small fw-bold">Senior Citizen Rate (% p.a.)</label>
                          <input type="number" step="0.05" name="senior_rate" class="form-control" value="<?= e($dr['senior_rate'] ?? '') ?>">
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label small fw-bold">Effective Date</label>
                        <input type="date" name="effective_from" class="form-control" value="<?= e($dr['effective_from']) ?>" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Loan Rates Section -->
<div class="card border-0 shadow-sm">
  <div class="card-header bg-light py-3 border-bottom d-flex justify-content-between align-items-center">
    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-hand-holding-dollar text-primary me-2"></i> Lending & Loan Interest Rates</h5>
    <span class="badge bg-secondary rounded-pill"><?= count($loanRates) ?> Schemes</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Loan Scheme (English)</th>
            <th class="py-3">Scheme (Malayalam)</th>
            <th class="py-3">Interest Rate (% p.a.)</th>
            <th class="py-3">Effective Date</th>
            <th class="py-3 text-end pe-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($loanRates as $lr): ?>
            <tr>
              <td class="ps-3 fw-bold text-dark"><?= e($lr['tenure_label_en']) ?></td>
              <td class="fw-medium text-dark small"><?= e($lr['tenure_label_ml']) ?></td>
              <td><span class="badge bg-warning-subtle text-dark fs-6 px-3 py-1"><?= number_format((float)$lr['general_rate'], 2) ?> %</span></td>
              <td class="small text-muted"><?= date('d M Y', strtotime($lr['effective_from'])) ?></td>
              <td class="text-end pe-3">
                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editLoanModal<?= $lr['id'] ?>">
                  <i class="fa-solid fa-pen-to-square"></i> Edit
                </button>
                <form action="/admin/rates/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this rate slab?')">
                  <?= csrf_field() ?>
                  <input type="hidden" name="id" value="<?= $lr['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
              </td>
            </tr>

            <!-- Edit Loan Modal -->
            <div class="modal fade" id="editLoanModal<?= $lr['id'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="/admin/rates/save" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $lr['id'] ?>">
                    <input type="hidden" name="category_type" value="loan">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold">Edit Loan Rate</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label small fw-bold">Scheme Name (English)</label>
                        <input type="text" name="tenure_label_en" class="form-control" value="<?= e($lr['tenure_label_en']) ?>" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label small fw-bold">Scheme Name (Malayalam)</label>
                        <input type="text" name="tenure_label_ml" class="form-control" value="<?= e($lr['tenure_label_ml']) ?>" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label small fw-bold">Interest Rate (% p.a.)</label>
                        <input type="number" step="0.05" name="general_rate" class="form-control" value="<?= e($lr['general_rate']) ?>" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label small fw-bold">Effective Date</label>
                        <input type="date" name="effective_from" class="form-control" value="<?= e($lr['effective_from']) ?>" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal: New Rate Slab -->
<div class="modal fade" id="newRateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/admin/rates/save" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="0">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Add Rate Slab</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-bold">Category</label>
            <select name="category_type" class="form-select">
              <option value="deposit">Term Deposit</option>
              <option value="loan">Lending / Loan</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Label / Tenure (English)</label>
            <input type="text" name="tenure_label_en" class="form-control" placeholder="e.g. 1 Year to 2 Years" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Label / Tenure (Malayalam)</label>
            <input type="text" name="tenure_label_ml" class="form-control" placeholder="1 വർഷം മുതൽ 2 വർഷം വരെ" required>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-bold">General Rate (%)</label>
              <input type="number" step="0.05" name="general_rate" class="form-control" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-bold">Senior Citizen Rate (%)</label>
              <input type="number" step="0.05" name="senior_rate" class="form-control" placeholder="Optional">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Effective From</label>
            <input type="date" name="effective_from" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Add Slab</button>
        </div>
      </form>
    </div>
  </div>
</div>
