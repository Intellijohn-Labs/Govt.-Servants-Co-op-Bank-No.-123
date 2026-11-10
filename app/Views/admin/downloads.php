<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Downloads & Forms Management</h3>
    <p class="text-muted small mb-0">Manage downloadable customer PDF forms, loan applications, KYC mandates, and annual reports.</p>
  </div>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newDownloadModal">
    <i class="fa-solid fa-plus me-1"></i> Add Download Item
  </button>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Category</th>
            <th class="py-3">Title (English)</th>
            <th class="py-3">Title (Malayalam)</th>
            <th class="py-3">File Path / Size</th>
            <th class="py-3">Downloads</th>
            <th class="py-3 text-end pe-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($downloads)): ?>
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">No downloads found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($downloads as $d): ?>
              <tr>
                <td class="ps-3">
                  <span class="badge bg-secondary-subtle text-secondary"><?= e($d['category']) ?></span>
                </td>
                <td class="fw-bold text-dark">
                  <?= e($d['title_en']) ?>
                </td>
                <td class="fw-medium text-dark small">
                  <?= e($d['title_ml']) ?>
                </td>
                <td class="small font-monospace text-muted">
                  <?= e($d['file_path']) ?> (<?= (int)$d['file_size_kb'] ?> KB)
                </td>
                <td class="small">
                  <?= (int)($d['download_count'] ?? 0) ?>
                </td>
                <td class="text-end pe-3">
                  <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDlModal<?= $d['id'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                  </button>
                </td>
              </tr>

              <!-- Edit Modal -->
              <div class="modal fade" id="editDlModal<?= $d['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="/admin/downloads/save" method="POST">
                      <?= csrf_field() ?>
                      <input type="hidden" name="id" value="<?= $d['id'] ?>">
                      <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Download Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label small fw-bold">Category</label>
                          <input type="text" name="category" class="form-control" value="<?= e($d['category']) ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label small fw-bold">Title (English)</label>
                          <input type="text" name="title_en" class="form-control" value="<?= e($d['title_en']) ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label small fw-bold">Title (Malayalam)</label>
                          <input type="text" name="title_ml" class="form-control" value="<?= e($d['title_ml']) ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label small fw-bold">File Path</label>
                          <input type="text" name="file_path" class="form-control" value="<?= e($d['file_path']) ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label small fw-bold">File Size (KB)</label>
                          <input type="number" name="file_size_kb" class="form-control" value="<?= e((string)$d['file_size_kb']) ?>" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
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

<!-- New Download Modal -->
<div class="modal fade" id="newDownloadModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/admin/downloads/save" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="0">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Add Downloadable Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-bold">Category</label>
            <select name="category" class="form-select">
              <option value="Loan Forms">Loan Forms</option>
              <option value="Deposit Forms">Deposit Forms</option>
              <option value="Membership & KYC">Membership & KYC</option>
              <option value="Audit Reports">Audit Reports</option>
              <option value="Legal & Governance">Legal & Governance</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Title (English)</label>
            <input type="text" name="title_en" class="form-control" placeholder="e.g. Loan Application Form" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Title (Malayalam)</label>
            <input type="text" name="title_ml" class="form-control" placeholder="വായ്പാ അപേക്ഷാ ഫോം" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">File Path</label>
            <input type="text" name="file_path" class="form-control" value="/downloads/application_form.pdf" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">File Size (KB)</label>
            <input type="number" name="file_size_kb" class="form-control" value="350" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Add Item</button>
        </div>
      </form>
    </div>
  </div>
</div>
