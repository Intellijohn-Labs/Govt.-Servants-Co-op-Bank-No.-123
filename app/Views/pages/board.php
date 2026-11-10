<?php
$crumbs = [
    ['title' => __('nav_about'), 'url' => url('/about')],
    ['title' => __('nav_board'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-primary text-white mb-2"><?= __('Governance & Leadership', 'ഭരണസമിതി നേതൃത്വം') ?></span>
    <h1 class="fw-bold mb-2"><?= __('nav_board') ?></h1>
    <p class="text-muted">
      <?= __('Elected democratic leadership dedicated to upholding the highest standards of financial prudence and member welfare.', 'ബാങ്കിന്റെയും അംഗങ്ങളുടെയും സമഗ്ര ഉന്നമനത്തിനായി പ്രവർത്തിക്കുന്ന തെരഞ്ഞെടുക്കപ്പെട്ട ഭരണസമിതി അംഗങ്ങൾ.') ?>
    </p>
  </div>

  <div class="row g-4">
    <?php if (!empty($members)): ?>
      <?php foreach ($members as $m): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
            <div class="portrait-frame mx-auto mb-3 bg-secondary d-flex align-items-center justify-content-center text-white fs-1">
              <i class="fa-solid fa-user-tie"></i>
            </div>
            <h5 class="fw-bold mb-1 text-primary"><?= is_malayalam() ? e($m['name_ml']) : e($m['name_en']) ?></h5>
            <div class="badge bg-light text-dark border mb-3"><?= is_malayalam() ? e($m['designation_ml']) : e($m['designation_en']) ?></div>

            <?php if (!empty($m['phone'])): ?>
              <div class="small text-muted mb-1">
                <i class="fa-solid fa-phone me-1"></i> <?= e($m['phone']) ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($m['email'])): ?>
              <div class="small text-muted mb-3">
                <i class="fa-solid fa-envelope me-1"></i> <?= e($m['email']) ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($m['message_en'])): ?>
              <p class="small text-muted fst-italic mt-2 mb-0">
                &ldquo;<?= is_malayalam() ? e($m['message_ml']) : e($m['message_en']) ?>&rdquo;
              </p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12 text-center text-muted py-5">
        <p>Board member information will be updated shortly.</p>
      </div>
    <?php endif; ?>
  </div>
</div>
