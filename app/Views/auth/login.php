<div class="container py-5 my-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
        <div class="text-center mb-4">
          <?php if (!empty(setting('branding.logo'))): ?>
            <img src="<?= e(asset(setting('branding.logo'))) ?>" alt="<?= e(setting('legal.short_name', 'Logo')) ?>" width="72" height="72" class="mb-3">
          <?php else: ?>
            <div class="brand-icon-box bg-primary text-white rounded p-3 d-inline-flex mb-3">
              <i class="fa-solid fa-lock fa-2x"></i>
            </div>
          <?php endif; ?>
          <h4 class="fw-bold mb-1"><?= __('Administrative Login', 'അഡ്മിൻ ലോഗിൻ') ?></h4>
          <p class="text-muted small"><?= e(bank_name()) ?> CMS</p>
        </div>

        <?php if (flash('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            <i class="fa-solid fa-circle-exclamation me-1"></i> <?= e(flash('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if (flash('success')): ?>
          <div class="alert alert-success alert-dismissible fade show small" role="alert">
            <i class="fa-solid fa-circle-check me-1"></i> <?= e(flash('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <form action="/admin/login" method="POST">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label small fw-semibold"><?= __('Username or Email', 'യൂസർനെയിം / ഇമെയിൽ') ?></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-user text-muted"></i></span>
              <input type="text" name="username" class="form-control" placeholder="admin or email" required autofocus>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label small fw-semibold"><?= __('Password', 'പാസ്‌വേഡ്') ?></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-key text-muted"></i></span>
              <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary py-2 fw-bold">
              <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> <?= __('Sign In to Portal', 'ലോഗിൻ ചെയ്യുക') ?>
            </button>
          </div>

          <div class="text-center">
            <a href="<?= url('/') ?>" class="small text-muted text-decoration-none">
              <i class="fa-solid fa-arrow-left me-1"></i> <?= __('Back to Public Website', 'പ്രധാന വെബ്സൈറ്റിലേക്ക്') ?>
            </a>
          </div>
        </form>
      </div>

      <div class="text-center text-muted small mt-4">
        &copy; <?= date('Y') ?> <?= e(setting('legal.verified_legal_name')) ?>
      </div>
    </div>
  </div>
</div>
