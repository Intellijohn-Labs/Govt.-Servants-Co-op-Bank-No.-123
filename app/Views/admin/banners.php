<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Banners & Sliders</h3>
    <p class="text-muted small mb-0">Hero homepage carousel sliders promoting seasonal schemes and loan offers.</p>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Order</th>
            <th class="py-3">Title (English)</th>
            <th class="py-3">Title (Malayalam)</th>
            <th class="py-3">Target Link</th>
            <th class="py-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($banners)): ?>
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">No banners found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($banners as $b): ?>
              <tr>
                <td class="ps-3 font-monospace small"><?= (int)$b['sort_order'] ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= e($b['title_en']) ?></div>
                  <div class="small text-muted"><?= e($b['subtitle_en'] ?? '') ?></div>
                </td>
                <td class="fw-medium text-dark small">
                  <div><?= e($b['title_ml']) ?></div>
                  <div class="small text-muted"><?= e($b['subtitle_ml'] ?? '') ?></div>
                </td>
                <td class="small font-monospace text-primary"><?= e($b['link_url'] ?? '/') ?></td>
                <td>
                  <span class="badge bg-<?= $b['status'] === 'active' ? 'success' : 'secondary' ?> text-uppercase"><?= e($b['status']) ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
