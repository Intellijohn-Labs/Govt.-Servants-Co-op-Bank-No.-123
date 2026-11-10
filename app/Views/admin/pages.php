<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Static & Governance Pages</h3>
    <p class="text-muted small mb-0">Overview of public institutional, statutory, and legal policy pages.</p>
  </div>
</div>

<div class="row g-4">
  <?php foreach ($pages as $p): ?>
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 border-0 shadow-sm p-4">
        <h5 class="fw-bold text-dark mb-2"><?= e($p['title']) ?></h5>
        <p class="text-muted small flex-grow-1"><?= e($p['desc']) ?></p>
        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
          <span class="font-monospace small text-primary"><?= e($p['url']) ?></span>
          <a href="<?= e($p['url']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Page
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
