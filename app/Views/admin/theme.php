<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Theme Customization & Accessibility</h3>
    <p class="text-muted small mb-0">Switch white-label color palettes and verify WCAG 2.1 AA contrast compliance.</p>
  </div>
</div>

<!-- Active Theme Status -->
<div class="row g-4 mb-4">
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-light py-3">
        <h5 class="fw-bold mb-0 text-dark">Current Active Color Tokens</h5>
      </div>
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3 p-3 rounded" style="background-color: <?= e($activeTheme['primary']) ?>; color: <?= e($activeTheme['primary_contrast']) ?>;">
          <i class="fa-solid fa-building-columns fa-2x"></i>
          <div>
            <div class="fw-bold fs-5">Primary Brand Color</div>
            <div class="font-monospace small"><?= e($activeTheme['primary']) ?></div>
          </div>
        </div>

        <div class="row g-2 text-center small font-monospace">
          <div class="col-4">
            <div class="p-2 rounded text-white" style="background-color: <?= e($activeTheme['secondary']) ?>;">
              Secondary<br><?= e($activeTheme['secondary']) ?>
            </div>
          </div>
          <div class="col-4">
            <div class="p-2 rounded text-white" style="background-color: <?= e($activeTheme['accent']) ?>;">
              Accent<br><?= e($activeTheme['accent']) ?>
            </div>
          </div>
          <div class="col-4">
            <div class="p-2 rounded text-white bg-dark">
              Footer<br><?= e($activeTheme['footer_bg'] ?? '#0A2540') ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-light py-3">
        <h5 class="fw-bold mb-0 text-dark">WCAG 2.1 AA Compliance Checker</h5>
      </div>
      <div class="card-body text-center d-flex flex-column justify-content-center">
        <div class="display-5 fw-bold mb-1 <?= $contrast['status'] === 'PASS' ? 'text-success' : 'text-danger' ?>">
          <?= e((string)$contrast['ratio']) ?>:1
        </div>
        <div class="badge bg-<?= $contrast['status'] === 'PASS' ? 'success' : 'danger' ?> fs-6 py-2 px-4 rounded-pill mx-auto mb-3">
          <i class="fa-solid <?= $contrast['status'] === 'PASS' ? 'fa-circle-check' : 'fa-triangle-exclamation' ?> me-1"></i>
          WCAG AA <?= e($contrast['status']) ?>
        </div>
        <p class="text-muted small mb-0">
          The contrast between primary brand text and its background fulfills the mandatory 4.5:1 minimum ratio for standard body text and 3:1 for large display headings.
        </p>
      </div>
    </div>
  </div>
</div>

<!-- 5 Curated Light Presets -->
<div class="card border-0 shadow-sm">
  <div class="card-header bg-light py-3">
    <h5 class="fw-bold mb-0 text-dark">Curated Kerala Co-operative Presets</h5>
  </div>
  <div class="card-body p-4">
    <div class="row g-4">
      <?php foreach ($presets as $key => $preset): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border p-3">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="d-inline-block rounded-circle" style="width: 24px; height: 24px; background-color: <?= e($preset['primary']) ?>;"></span>
              <span class="d-inline-block rounded-circle" style="width: 24px; height: 24px; background-color: <?= e($preset['secondary']) ?>;"></span>
              <span class="d-inline-block rounded-circle" style="width: 24px; height: 24px; background-color: <?= e($preset['accent']) ?>;"></span>
            </div>
            <h6 class="fw-bold text-dark mb-1"><?= e($preset['name']) ?></h6>
            <div class="font-monospace small text-muted mb-3">Primary: <?= e($preset['primary']) ?></div>

            <form action="/admin/theme/apply" method="POST" class="mt-auto">
              <?= csrf_field() ?>
              <input type="hidden" name="preset" value="<?= e($key) ?>">
              <button type="submit" class="btn btn-outline-primary btn-sm w-100 fw-bold">
                <i class="fa-solid fa-check me-1"></i> Apply Preset
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
