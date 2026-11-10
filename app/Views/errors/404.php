<div class="container py-5 text-center my-5">
  <div class="max-w-600 mx-auto">
    <div class="text-primary display-1 fw-bold mb-3">404</div>
    <h2 class="fw-bold mb-3"><?= __('Page Not Found', 'പേജ് കണ്ടെത്താനായില്ല') ?></h2>
    <p class="lead text-muted mb-4">
      <?= __('The page or document you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'നിങ്ങൾ തിരയുന്ന പേജ് നിലവിലില്ല അല്ലെങ്കിൽ നീക്കം ചെയ്യപ്പെട്ടിരിക്കുന്നു.') ?>
    </p>
    <div class="d-flex justify-content-center gap-3">
      <a href="<?= url('/') ?>" class="btn btn-primary fw-bold px-4">
        <i class="fa-solid fa-house me-2"></i> <?= __('Return to Home', 'ഹോം പേജിലേക്ക്') ?>
      </a>
      <a href="<?= url('/contact') ?>" class="btn btn-outline-secondary fw-bold px-4">
        <i class="fa-solid fa-headset me-2"></i> <?= __('Contact Support', 'സഹായത്തിന്') ?>
      </a>
    </div>
  </div>
</div>
