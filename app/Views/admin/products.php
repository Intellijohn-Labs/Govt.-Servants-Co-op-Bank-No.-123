<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Products & Schemes Catalogue</h3>
    <p class="text-muted small mb-0">Overview of all loans, savings, deposit schemes, and digital banking facilities.</p>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Code & Name</th>
            <th class="py-3">Malayalam Title</th>
            <th class="py-3">Category</th>
            <th class="py-3">Interest Rate Display</th>
            <th class="py-3">Tenure / Max Amount</th>
            <th class="py-3">Target Audience</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end pe-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($products)): ?>
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">No products found in catalogue.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($products as $p): ?>
              <tr>
                <td class="ps-3">
                  <div class="fw-bold text-dark"><?= e($p['name_en']) ?></div>
                  <span class="badge bg-light text-muted border font-monospace"><?= e($p['code']) ?></span>
                </td>
                <td class="fw-medium text-dark small">
                  <?= e($p['name_ml']) ?>
                </td>
                <td>
                  <span class="badge bg-secondary-subtle text-secondary"><?= e($p['cat_name']) ?></span>
                </td>
                <td class="small fw-bold text-primary">
                  <?= e($p['interest_rate_display']) ?>
                </td>
                <td class="small text-muted">
                  <div><?= e($p['tenure_display_en']) ?></div>
                  <div class="fw-semibold text-dark"><?= e($p['max_amount_display_en']) ?></div>
                </td>
                <td>
                  <span class="badge bg-<?= $p['target_audience'] === 'open_to_public' ? 'success-subtle text-success' : 'info-subtle text-info-emphasis' ?>">
                    <?= $p['target_audience'] === 'open_to_public' ? 'Open to Public' : 'Members Only' ?>
                  </span>
                </td>
                <td>
                  <span class="badge bg-<?= $p['status'] === 'published' ? 'success' : 'secondary' ?> text-uppercase">
                    <?= e($p['status']) ?>
                  </span>
                </td>
                <td class="text-end pe-3">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="/products/<?= e($p['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Public Page">
                      <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    <form action="/admin/products/toggle" method="POST" class="d-inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="id" value="<?= $p['id'] ?>">
                      <input type="hidden" name="status" value="<?= $p['status'] ?>">
                      <button type="submit" class="btn btn-sm <?= $p['status'] === 'published' ? 'btn-outline-warning' : 'btn-outline-success' ?>">
                        <?= $p['status'] === 'published' ? 'Unpublish' : 'Publish' ?>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
