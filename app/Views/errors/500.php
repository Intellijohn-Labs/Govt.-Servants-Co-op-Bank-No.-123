<div class="container py-5 text-center my-5">
  <div class="max-w-600 mx-auto">
    <div class="text-danger display-1 fw-bold mb-3">500</div>
    <h2 class="fw-bold mb-3"><?= __('Internal Server Error', 'സെർവർ തകരാർ') ?></h2>
    <p class="lead text-muted mb-4">
      <?= __('An unexpected technical issue occurred while processing your request. Our technical administration team has been notified.', 'സെർവറിൽ സാങ്കേതിക തകരാർ നേരിട്ടു. ദയവായി അല്പം കഴിഞ്ഞ് വീണ്ടും ശ്രമിക്കുക.') ?>
    </p>
    <a href="<?= url('/') ?>" class="btn btn-primary fw-bold px-4">
      <i class="fa-solid fa-house me-2"></i> <?= __('Return to Home', 'ഹോം പേജിലേക്ക്') ?>
    </a>
  </div>
</div>
