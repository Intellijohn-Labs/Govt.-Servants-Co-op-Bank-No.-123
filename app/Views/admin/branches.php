<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Branches & Office Network</h3>
    <p class="text-muted small mb-0">Manage brick-and-mortar banking branches, working hours, manager contacts, and safe locker amenities.</p>
  </div>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newBranchModal">
    <i class="fa-solid fa-plus me-1"></i> Add New Branch
  </button>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Code & Name</th>
            <th class="py-3">Malayalam Title</th>
            <th class="py-3">Address & Phone</th>
            <th class="py-3">Manager</th>
            <th class="py-3">Key Amenities</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end pe-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($branches)): ?>
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">No branches found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($branches as $b): ?>
              <tr>
                <td class="ps-3">
                  <div class="fw-bold text-dark">
                    <?= e($b['name_en']) ?>
                    <?php if (!empty($b['is_head_office'])): ?>
                      <span class="badge bg-primary text-white ms-1 small">Head Office</span>
                    <?php endif; ?>
                  </div>
                  <span class="badge bg-light text-muted border font-monospace"><?= e($b['code']) ?></span>
                </td>
                <td class="fw-medium text-dark small">
                  <?= e($b['name_ml']) ?>
                </td>
                <td class="small">
                  <div class="text-truncate" style="max-width: 250px;"><?= e($b['address_en']) ?></div>
                  <div><i class="fa-solid fa-phone text-muted me-1"></i> <?= e($b['phone']) ?></div>
                </td>
                <td class="small">
                  <div class="fw-semibold"><?= e($b['manager_name'] ?: 'Not assigned') ?></div>
                  <div class="text-muted"><?= e($b['manager_phone'] ?? '') ?></div>
                </td>
                <td>
                  <div class="d-flex flex-wrap gap-1">
                    <?php if ($b['has_365_days']): ?><span class="badge bg-warning text-dark small">365 Days</span><?php endif; ?>
                    <?php if ($b['has_locker']): ?><span class="badge bg-info-subtle text-info-emphasis small">Locker</span><?php endif; ?>
                    <?php if ($b['has_gold_loan']): ?><span class="badge bg-light text-dark border small">Gold Loan</span><?php endif; ?>
                    <?php if ($b['has_atm']): ?><span class="badge bg-success-subtle text-success small">ATM</span><?php endif; ?>
                  </div>
                </td>
                <td>
                  <span class="badge bg-<?= $b['status'] === 'active' ? 'success' : 'secondary' ?> text-uppercase">
                    <?= e($b['status']) ?>
                  </span>
                </td>
                <td class="text-end pe-3">
                  <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editBranchModal<?= $b['id'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                  </button>
                </td>
              </tr>

              <!-- Edit Branch Modal -->
              <div class="modal fade" id="editBranchModal<?= $b['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <form action="/admin/branches/save" method="POST">
                      <?= csrf_field() ?>
                      <input type="hidden" name="id" value="<?= $b['id'] ?>">
                      <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Branch: <?= e($b['name_en']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-md-4">
                            <label class="form-label small fw-bold">Branch Code</label>
                            <input type="text" name="code" class="form-control" value="<?= e($b['code']) ?>" required>
                          </div>
                          <div class="col-md-4">
                            <label class="form-label small fw-bold">Name (English)</label>
                            <input type="text" name="name_en" class="form-control" value="<?= e($b['name_en']) ?>" required>
                          </div>
                          <div class="col-md-4">
                            <label class="form-label small fw-bold">Name (Malayalam)</label>
                            <input type="text" name="name_ml" class="form-control" value="<?= e($b['name_ml']) ?>" required>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Address (English)</label>
                            <textarea name="address_en" class="form-control" rows="2" required><?= e($b['address_en']) ?></textarea>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Address (Malayalam)</label>
                            <textarea name="address_ml" class="form-control" rows="2" required><?= e($b['address_ml']) ?></textarea>
                          </div>
                          <div class="col-md-4">
                            <label class="form-label small fw-bold">Primary Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= e($b['phone']) ?>" required>
                          </div>
                          <div class="col-md-4">
                            <label class="form-label small fw-bold">Branch Email</label>
                            <input type="email" name="email" class="form-control" value="<?= e($b['email'] ?? '') ?>">
                          </div>
                          <div class="col-md-4">
                            <label class="form-label small fw-bold">Branch Status</label>
                            <select name="status" class="form-select">
                              <option value="active" <?= $b['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                              <option value="inactive" <?= $b['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Manager Name</label>
                            <input type="text" name="manager_name" class="form-control" value="<?= e($b['manager_name'] ?? '') ?>">
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Manager Mobile Phone</label>
                            <input type="text" name="manager_phone" class="form-control" value="<?= e($b['manager_phone'] ?? '') ?>">
                          </div>
                          <div class="col-12">
                            <label class="form-label small fw-bold">Amenities & Features</label>
                            <div class="d-flex gap-4 flex-wrap">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="has_locker" value="1" id="loc<?= $b['id'] ?>" <?= $b['has_locker'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="loc<?= $b['id'] ?>">Safe Deposit Lockers</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="has_365_days" value="1" id="days<?= $b['id'] ?>" <?= $b['has_365_days'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="days<?= $b['id'] ?>">365-Day Evening Banking</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="has_gold_loan" value="1" id="gl<?= $b['id'] ?>" <?= $b['has_gold_loan'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="gl<?= $b['id'] ?>">Gold Loan Counter</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="has_atm" value="1" id="atm<?= $b['id'] ?>" <?= $b['has_atm'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="atm<?= $b['id'] ?>">On-site ATM / Kiosk</label>
                              </div>
                            </div>
                          </div>
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
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- New Branch Modal -->
<div class="modal fade" id="newBranchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="/admin/branches/save" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="0">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Create New Branch</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label small fw-bold">Branch Code</label>
              <input type="text" name="code" class="form-control" placeholder="e.g. BR-05" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Name (English)</label>
              <input type="text" name="name_en" class="form-control" placeholder="e.g. Town Branch" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Name (Malayalam)</label>
              <input type="text" name="name_ml" class="form-control" placeholder="ടൗൺ ശാഖ" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Address (English)</label>
              <textarea name="address_en" class="form-control" rows="2" required></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Address (Malayalam)</label>
              <textarea name="address_ml" class="form-control" rows="2" required></textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Primary Phone</label>
              <input type="text" name="phone" class="form-control" placeholder="+91 497 278 5000" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Branch Email</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Status</label>
              <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Create Branch</button>
        </div>
      </form>
    </div>
  </div>
</div>
