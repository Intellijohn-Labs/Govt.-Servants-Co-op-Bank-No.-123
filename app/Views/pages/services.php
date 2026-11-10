<?php
$crumbs = [
    ['title' => __('nav_services'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-primary text-white mb-2"><?= __('Product & Service Catalogue', 'സേവനങ്ങളുടെ പട്ടിക') ?></span>
    <h1 class="fw-bold mb-2"><?= __('nav_services') ?></h1>
    <p class="text-muted">
      <?= __('Explore our complete portfolio of competitive loans, secure deposit schemes, and digital banking facilities tailored to our community.', 'നിങ്ങളുടെ ഓരോ സാമ്പത്തിക ആവശ്യങ്ങൾക്കും അനുയോജ്യമായ സുരക്ഷിത നിക്ഷേപ, വായ്പാ പദ്ധതികൾ.') ?>
    </p>
  </div>

  <!-- Category Groups -->
  <!-- 1. Loans & Advances -->
  <div class="mb-5">
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
      <div>
        <h3 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-hand-holding-dollar me-2"></i> <?= __('nav_loans') ?></h3>
        <p class="small text-muted mb-0"><?= __('Low interest rates, high valuation, and minimal documentation.', 'ലളിതമായ തിരിച്ചടവ് വ്യവസ്ഥകളും കുറഞ്ഞ പലിശ നിരക്കുകളും.') ?></p>
      </div>
      <a href="<?= url('/calculators') ?>" class="btn btn-outline-primary btn-sm fw-bold">
        <i class="fa-solid fa-calculator me-1"></i> <?= __('calculate_emi') ?>
      </a>
    </div>

    <div class="row g-4">
      <?php if (!empty($grouped_products['loan'])): ?>
        <?php foreach ($grouped_products['loan'] as $prod): ?>
          <div class="col-md-6 col-lg-4">
            <div class="feature-card d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <span class="badge bg-primary-subtle text-primary fw-bold text-uppercase small"><?= e($prod['cat_name_en']) ?></span>
                  <span class="badge bg-light text-muted border small">
                    <?= $prod['target_audience'] === 'members_only' ? __('Members Only', 'അംഗങ്ങൾക്ക് മാത്രം') : __('Open to Public', 'പൊതുജനങ്ങൾക്കും') ?>
                  </span>
                </div>
                <h5 class="fw-bold text-dark mb-1"><?= is_malayalam() ? e($prod['name_ml']) : e($prod['name_en']) ?></h5>
                <p class="small text-muted mb-3"><?= is_malayalam() ? e($prod['tagline_ml']) : e($prod['tagline_en']) ?></p>

                <div class="bg-light p-2 rounded-3 small mb-3 border">
                  <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted"><?= __('Interest Rate', 'പലിശ') ?>:</span>
                    <strong class="text-primary"><?= e($prod['interest_rate_display']) ?></strong>
                  </div>
                  <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted"><?= __('Max Amount', 'പരമാവധി തുക') ?>:</span>
                    <strong class="text-dark"><?= is_malayalam() ? e($prod['max_amount_display_ml']) : e($prod['max_amount_display_en']) ?></strong>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted"><?= __('Tenure', 'കാലാവധി') ?>:</span>
                    <strong class="text-dark"><?= is_malayalam() ? e($prod['tenure_display_ml']) : e($prod['tenure_display_en']) ?></strong>
                  </div>
                </div>
              </div>

              <div class="d-flex gap-2 pt-2 border-top">
                <a href="<?= url('/products/' . $prod['slug']) ?>" class="btn btn-outline-primary btn-sm flex-fill fw-bold">
                  <?= __('learn_more') ?>
                </a>
                <a href="<?= url('/service-request') ?>?scheme=<?= urlencode($prod['name_en']) ?>" class="btn btn-primary btn-sm flex-fill fw-bold">
                  <?= __('apply_now') ?>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-muted">No loan products currently listed.</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- 2. Deposits & Savings -->
  <div class="mb-5">
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
      <div>
        <h3 class="fw-bold mb-0 text-success"><i class="fa-solid fa-piggy-bank me-2"></i> <?= __('nav_deposits') ?></h3>
        <p class="small text-muted mb-0"><?= __('Safe, high-yield wealth generation with special senior citizen bonuses.', 'മുതിർന്ന പൗരന്മാർക്ക് പ്രത്യേക അധിക പലിശയും സുരക്ഷിതത്വവും.') ?></p>
      </div>
      <a href="<?= url('/interest-rates') ?>" class="btn btn-outline-success btn-sm fw-bold">
        <i class="fa-solid fa-percent me-1"></i> <?= __('nav_rates') ?>
      </a>
    </div>

    <div class="row g-4">
      <?php if (!empty($grouped_products['deposit'])): ?>
        <?php foreach ($grouped_products['deposit'] as $prod): ?>
          <div class="col-md-6 col-lg-4">
            <div class="feature-card d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <span class="badge bg-success-subtle text-success fw-bold text-uppercase small"><?= e($prod['cat_name_en']) ?></span>
                  <span class="badge bg-light text-muted border small">
                    <?= $prod['target_audience'] === 'members_only' ? __('Members Only', 'അംഗങ്ങൾക്ക് മാത്രം') : __('Open to Public', 'പൊതുജനങ്ങൾക്കും') ?>
                  </span>
                </div>
                <h5 class="fw-bold text-dark mb-1"><?= is_malayalam() ? e($prod['name_ml']) : e($prod['name_en']) ?></h5>
                <p class="small text-muted mb-3"><?= is_malayalam() ? e($prod['tagline_ml']) : e($prod['tagline_en']) ?></p>

                <div class="bg-light p-2 rounded-3 small mb-3 border">
                  <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted"><?= __('Interest Rate', 'പലിശ') ?>:</span>
                    <strong class="text-success"><?= e($prod['interest_rate_display']) ?></strong>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted"><?= __('Tenure Slabs', 'കാലാവധി') ?>:</span>
                    <strong class="text-dark"><?= is_malayalam() ? e($prod['tenure_display_ml']) : e($prod['tenure_display_en']) ?></strong>
                  </div>
                </div>
              </div>

              <div class="d-flex gap-2 pt-2 border-top">
                <a href="<?= url('/products/' . $prod['slug']) ?>" class="btn btn-outline-success btn-sm flex-fill fw-bold">
                  <?= __('learn_more') ?>
                </a>
                <a href="<?= url('/service-request') ?>?scheme=<?= urlencode($prod['name_en']) ?>" class="btn btn-success btn-sm flex-fill fw-bold text-white">
                  <?= __('open_account') ?>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-muted">No deposit schemes currently listed.</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- 3. Banking Facilities -->
  <div class="mb-4">
    <div class="mb-4 pb-2 border-bottom">
      <h3 class="fw-bold mb-0 text-info-emphasis"><i class="fa-solid fa-shield-halved me-2"></i> <?= __('nav_facilities') ?></h3>
      <p class="small text-muted mb-0"><?= __('Safe deposit lockers, immediate fund transfers, and digital access.', 'സുരക്ഷിത ലോക്കറുകൾ, ഡിജിറ്റൽ ബാങ്കിംഗ് സൗകര്യങ്ങൾ.') ?></p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card">
          <div class="fs-2 text-primary mb-2"><i class="fa-solid fa-vault"></i></div>
          <h5 class="fw-bold mb-1"><?= __('lockers') ?></h5>
          <p class="small text-muted mb-3"><?= __('lockers_desc') ?></p>
          <a href="<?= url('/service-request') ?>?scheme=Safe+Deposit+Locker" class="btn btn-outline-primary btn-sm fw-bold">
            <?= __('Enquire Availability', 'ലഭ്യത അറിയാൻ') ?> &rarr;
          </a>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-card">
          <div class="fs-2 text-primary mb-2"><i class="fa-solid fa-money-bill-transfer"></i></div>
          <h5 class="fw-bold mb-1"><?= __('neft_rtgs') ?></h5>
          <p class="small text-muted mb-3"><?= __('neft_rtgs_desc') ?></p>
          <a href="<?= url('/contact') ?>" class="btn btn-outline-primary btn-sm fw-bold">
            <?= __('learn_more') ?> &rarr;
          </a>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-card">
          <div class="fs-2 text-primary mb-2"><i class="fa-solid fa-mobile-screen-button"></i></div>
          <h5 class="fw-bold mb-1"><?= __('mobile_banking') ?></h5>
          <p class="small text-muted mb-3"><?= __('mobile_banking_desc') ?></p>
          <a href="<?= url('/contact') ?>" class="btn btn-outline-primary btn-sm fw-bold">
            <?= __('learn_more') ?> &rarr;
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
