<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('nav_careers') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-briefcase text-primary me-2"></i>
      <?= __('nav_careers') ?> / <?= is_malayalam() ? 'തൊഴിലവസരങ്ങൾ' : 'Career Opportunities' ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= is_malayalam() 
          ? 'സഹകരണ സർവീസ് പരീക്ഷാ ബോർഡ് (CSEB) വഴിയും സ്ഥാപനം നേരിട്ടും നടത്തുന്ന നിയമന വിജ്ഞാപനങ്ങൾ.' 
          : 'Official recruitment notifications conducted through Co-operative Service Examination Board (CSEB) and institutional vacancies.' ?>
    </p>
  </div>
</div>

<div class="container py-5">
  <?php if (empty($careers)): ?>
    <div class="card border-0 shadow-sm text-center py-5">
      <div class="card-body">
        <i class="fa-solid fa-user-clock fa-3x text-muted mb-3"></i>
        <h5 class="text-dark"><?= is_malayalam() ? 'നിലവിൽ പുതിയ തൊഴിൽ വിജ്ഞാപനങ്ങൾ ലഭ്യമല്ല' : 'No active recruitment vacancies currently' ?></h5>
        <p class="text-muted small mb-0">
          <?= is_malayalam() 
              ? 'ഭാവിയിലെ ക്ലർക്ക്, കാഷ്യർ, സബ്-സ്റ്റാഫ് ഒഴിവുകൾ കേരള കോ-ഓപ്പറേറ്റീവ് സർവീസ് എക്സാമിനേഷൻ ബോർഡ് (CSEB) മുഖേന വിജ്ഞാപനം ചെയ്യുന്നതാണ്.' 
              : 'Subsequent clerk, cashier, and subordinate staff recruitments are announced via the Kerala Co-operative Service Examination Board (CSEB).' ?>
        </p>
      </div>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($careers as $job): ?>
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-light text-primary border font-monospace"><?= e($job['job_code']) ?></span>
                <span class="badge bg-success-subtle text-success border border-success-subtle"><?= is_malayalam() ? 'അപേക്ഷ ക്ഷണിക്കുന്നു' : 'Open' ?></span>
              </div>
              <h5 class="fw-bold text-dark mb-2">
                <?= is_malayalam() ? e($job['title_ml']) : e($job['title_en']) ?>
              </h5>
              <div class="small text-muted mb-3">
                <i class="fa-solid fa-building me-1"></i> <?= is_malayalam() ? e($job['department_ml']) : e($job['department_en']) ?>
                <span class="mx-2">•</span>
                <i class="fa-solid fa-location-dot me-1"></i> <?= e($job['location']) ?>
              </div>

              <div class="p-3 bg-light rounded small mb-3">
                <div class="mb-1">
                  <strong><?= is_malayalam() ? 'യോഗ്യത' : 'Qualification' ?>:</strong> 
                  <?= is_malayalam() ? e($job['qualification_ml']) : e($job['qualification_en']) ?>
                </div>
                <?php if (!empty($job['experience_en'])): ?>
                  <div>
                    <strong><?= is_malayalam() ? 'പരിചയം' : 'Experience' ?>:</strong> 
                    <?= is_malayalam() ? e($job['experience_ml'] ?? '') : e($job['experience_en']) ?>
                  </div>
                <?php endif; ?>
              </div>

              <p class="small text-muted mb-4">
                <?= is_malayalam() ? e($job['description_ml']) : e($job['description_en']) ?>
              </p>

              <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <div class="small text-muted">
                  <i class="fa-regular fa-clock me-1 text-danger"></i>
                  <?= is_malayalam() ? 'അവസാന തീയതി' : 'Last Date' ?>: <strong><?= date('d M Y', strtotime($job['last_date_to_apply'])) ?></strong>
                </div>
                <a href="<?= url('/downloads') ?>" class="btn btn-outline-primary btn-sm px-3">
                  <i class="fa-solid fa-file-lines me-1"></i> <?= is_malayalam() ? 'വിജ്ഞാപനം' : 'Notification' ?>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- CSEB Statutory Note -->
  <div class="alert alert-secondary border-0 shadow-sm mt-5 small text-muted">
    <i class="fa-solid fa-scale-balanced me-2 text-primary"></i>
    <strong><?= is_malayalam() ? 'നിയമന ചട്ടങ്ങൾ' : 'Statutory Recruitment Process' ?>: </strong>
    <?= is_malayalam() 
        ? 'കേരള സഹകരണ സംഘം നിയമം 1969, ചട്ടം 182 പ്രകാരമുള്ള സ്ഥിരം തസ്തികകളിലെ നിയമനങ്ങൾ കേരള കോ-ഓപ്പറേറ്റീവ് സർവീസ് എക്സാമിനേഷൻ ബോർഡ് (CSEB) വഴിയാണ് നടത്തുന്നത്. വ്യാജ തൊഴിൽ വാഗ്ദാനങ്ങളിൽ വഞ്ചിതരാകാതിരിക്കുക.' 
        : 'All regular staff appointments are governed by Rule 182 of the Kerala Co-operative Societies Act 1969 through the Co-operative Service Examination Board (CSEB), Thiruvananthapuram.' ?>
  </div>
</div>
