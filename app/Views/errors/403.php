<div class="container py-5 text-center my-5">
  <div class="max-w-600 mx-auto">
    <div class="text-warning display-1 fw-bold mb-3">403</div>
    <h2 class="fw-bold mb-3"><?= __('Access Forbidden', 'പ്രവേശന അനുമതിയില്ല') ?></h2>
    <p class="lead text-muted mb-4">
      <?= __('You do not have the required administrative permissions to access this confidential resource.', 'ഈ പേജ് ആക്സസ് ചെയ്യാനുള്ള അധികാരമില്ല.') ?>
    </p>
    <a href="<?= url('/admin') ?>" class="btn btn-primary fw-bold px-4">
      <i class="fa-solid fa-arrow-left me-2"></i> <?= __('Return to Dashboard', 'ഡാഷ്ബോർഡിലേക്ക്') ?>
    </a>
  </div>
</div>
