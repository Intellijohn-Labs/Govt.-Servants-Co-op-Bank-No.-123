<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('nav_downloads') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-file-arrow-down text-primary me-2"></i>
      <?= __('nav_downloads') ?> / <?= is_malayalam() ? 'ഫോമുകളും രേഖകളും' : 'Forms & Publications' ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= is_malayalam() 
          ? 'അക്കൗണ്ട് ഓപ്പണിംഗ്, വിവിധ വായ്പകൾ, അംഗത്വ അപേക്ഷകൾ, വാർഷിക റിപ്പോർട്ടുകൾ എന്നിവ ഇവിടെ ഡൗൺലോഡ് ചെയ്യാം.' 
          : 'Official printable PDF application forms, account opening mandates, KYC guidelines, and published annual reports.' ?>
    </p>
  </div>
</div>

<div class="container py-5">
  <?php if (empty($grouped_downloads)): ?>
    <div class="text-center py-5">
      <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
      <h5 class="text-dark"><?= is_malayalam() ? 'രേഖകൾ ലഭ്യമല്ല' : 'No downloadable forms found' ?></h5>
      <p class="text-muted small"><?= is_malayalam() ? 'കൂടുതൽ വിവരങ്ങൾക്ക് ശാഖയുമായി ബന്ധപ്പെടുക.' : 'Please contact your local branch for physical application stationery.' ?></p>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($grouped_downloads as $category => $items): ?>
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-light py-3 border-bottom d-flex align-items-center justify-content-between">
              <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-folder text-warning me-2"></i>
                <?= e($category) ?>
              </h5>
              <span class="badge bg-secondary rounded-pill"><?= count($items) ?> <?= count($items) === 1 ? 'Form' : 'Forms' ?></span>
            </div>
            <div class="card-body p-0">
              <ul class="list-group list-group-flush">
                <?php foreach ($items as $item): ?>
                  <li class="list-group-item p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                      <div class="rounded bg-danger-subtle text-danger p-2 text-center" style="width: 44px; height: 44px;">
                        <i class="fa-solid fa-file-pdf fa-lg"></i>
                      </div>
                      <div>
                        <div class="fw-semibold text-dark">
                          <?= is_malayalam() ? e($item['title_ml']) : e($item['title_en']) ?>
                        </div>
                        <div class="text-muted small">
                          <span class="badge bg-light text-secondary border me-1"><?= e($item['file_type'] ?? 'PDF') ?></span>
                          <span><?= (int)$item['file_size_kb'] > 0 ? (int)$item['file_size_kb'] . ' KB' : 'Standard PDF' ?></span>
                        </div>
                      </div>
                    </div>
                    <div>
                      <a href="<?= e($item['file_path']) ?>" download class="btn btn-outline-primary btn-sm px-3">
                        <i class="fa-solid fa-download me-1"></i> <?= is_malayalam() ? 'ഡൗൺലോഡ്' : 'Download' ?>
                      </a>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Need Help Notice -->
  <div class="alert alert-info border-0 shadow-sm mt-5 d-flex align-items-center" role="alert">
    <i class="fa-solid fa-circle-question fs-3 me-3 text-info"></i>
    <div class="small">
      <strong><?= is_malayalam() ? 'സഹായം ആവശ്യമെങ്കിൽ' : 'Need Form Assistance?' ?>: </strong>
      <?= is_malayalam() 
          ? 'പൂരിപ്പിച്ച അപേക്ഷാ ഫോമുകൾ ആവശ്യമായ കെ.വൈ.സി (KYC) രേഖകൾ സഹിതം നിങ്ങളുടെ തൊട്ടടുത്തുള്ള ശാഖാ കൗണ്ടറിൽ സമർപ്പിക്കുക. ഫോം പൂരിപ്പിക്കാൻ ശാഖാ ജീവനക്കാർ നിങ്ങളെ സഹായിക്കും.' 
          : 'Duly filled application forms along with verified KYC identity and address proofs can be submitted at any of our branches. Our customer desk is pleased to assist with form completion.' ?>
    </div>
  </div>
</div>
