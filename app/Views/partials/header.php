<?php
$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
$rawPath = parse_url($currentUri, PHP_URL_PATH) ?? '/';
$cleanPath = preg_replace('#^/(ml|en)#', '', $rawPath);
if ($cleanPath === '' || $cleanPath === false) {
    $cleanPath = '/';
}
$enUrl = $cleanPath . '?lang=en';
$mlUrl = '/ml' . ($cleanPath === '/' ? '' : $cleanPath) . '?lang=ml';
?>
<!-- Top Utility Bar -->
<div class="top-bar">
  <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="d-flex align-items-center flex-wrap gap-3 small">
      <?php if (!empty(setting('contact.primary_phone'))): ?>
        <span><i class="fa-solid fa-phone me-1"></i> <a href="tel:<?= e(setting('contact.primary_phone')) ?>"><?= e(setting('contact.primary_phone')) ?></a></span>
      <?php endif; ?>
      <?php if (!empty(setting('contact.email'))): ?>
        <span class="d-none d-md-inline"><i class="fa-solid fa-envelope me-1"></i> <a href="mailto:<?= e(setting('contact.email')) ?>"><?= e(setting('contact.email')) ?></a></span>
      <?php endif; ?>
      <span class="badge bg-warning text-dark d-none d-lg-inline-block">
        <i class="fa-solid fa-clock me-1"></i> <?= __('365_days_badge') ?>
      </span>
    </div>

    <div class="d-flex align-items-center gap-3">
      <!-- Search Toggle -->
      <button type="button" class="btn btn-sm text-white p-0 border-0" id="searchToggleBtn" aria-label="<?= __('search_placeholder') ?>">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>

      <!-- Language Switcher -->
      <div class="btn-group btn-group-sm shadow-sm" role="group" aria-label="Language selection">
        <a href="<?= e($enUrl) ?>" class="btn btn-sm <?= !is_malayalam() ? 'btn-light fw-bold text-primary shadow-sm' : 'btn-outline-light' ?>">
          <i class="fa-solid fa-language me-1"></i> English
        </a>
        <a href="<?= e($mlUrl) ?>" class="btn btn-sm <?= is_malayalam() ? 'btn-light fw-bold text-primary shadow-sm' : 'btn-outline-light' ?>">
          മലയാളം
        </a>
      </div>

      <!-- Admin Portal Link -->
      <?php if (auth_check()): ?>
        <a href="/admin" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-gauge me-1"></i> CMS</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Collapsible Global Search Bar -->
<div id="searchCollapse" class="d-none bg-light border-bottom py-2">
  <div class="container">
    <form action="<?= url('/search') ?>" method="GET" class="d-flex gap-2">
      <input type="text" name="q" class="form-control" placeholder="<?= __('search_placeholder') ?>" required>
      <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>
</div>

<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-lg main-navbar sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= url('/') ?>">
      <div class="brand-icon-box bg-primary text-white rounded p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
        <i class="fa-solid fa-building-columns fa-lg"></i>
      </div>
      <div>
        <div class="fw-bold fs-5 text-dark leading-tight"><?= e(setting('legal.approved_public_name')) ?></div>
        <div class="text-muted small" style="font-size: 0.75rem;"><?= e(setting('legal.registration_number')) ?></div>
      </div>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavigation">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="<?= url('/') ?>"><?= __('nav_home') ?></a>
        </li>

        <!-- About Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= __('nav_about') ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= url('/about') ?>"><?= __('nav_who_we_are') ?></a></li>
            <li><a class="dropdown-item" href="<?= url('/board') ?>"><?= __('nav_board') ?></a></li>
            <li><a class="dropdown-item" href="<?= url('/chairperson-message') ?>"><?= __('nav_chairperson_msg') ?></a></li>
            <li><a class="dropdown-item" href="<?= url('/achievements') ?>"><?= __('nav_achievements') ?></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= url('/legal-framework') ?>"><?= __('nav_legal_framework') ?></a></li>
          </ul>
        </li>

        <!-- Mega Menu: Services -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= __('nav_services') ?>
          </a>
          <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg" style="min-width: 650px;">
            <div class="mega-menu-grid">
              <div>
                <h6 class="text-primary fw-bold mb-2 border-bottom pb-1"><i class="fa-solid fa-hand-holding-dollar me-1"></i> <?= __('nav_loans') ?></h6>
                <ul class="list-unstyled mb-0 small">
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/gold-loan') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('gold_loan') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/housing-loan') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('housing_loan') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/agricultural-loan') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('agricultural_loan') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/business-loan') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('business_loan') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/vehicle-loan') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('vehicle_loan') ?></a></li>
                </ul>
              </div>

              <div>
                <h6 class="text-primary fw-bold mb-2 border-bottom pb-1"><i class="fa-solid fa-piggy-bank me-1"></i> <?= __('nav_deposits') ?></h6>
                <ul class="list-unstyled mb-0 small">
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/fixed-deposit') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('fixed_deposit') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/recurring-deposit') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('recurring_deposit') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/pigmy-deposit') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('pigmy_deposit') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/products/kids-deposit') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('kids_deposit') ?></a></li>
                </ul>
              </div>

              <div>
                <h6 class="text-primary fw-bold mb-2 border-bottom pb-1"><i class="fa-solid fa-shield-halved me-1"></i> <?= __('nav_facilities') ?></h6>
                <ul class="list-unstyled mb-0 small">
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/services/lockers') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('lockers') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/services/neft-rtgs') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('neft_rtgs') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/services/mobile-banking') ?>"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('mobile_banking') ?></a></li>
                  <li class="mb-1"><a class="text-decoration-none text-dark" href="<?= url('/welfare') ?>#member-services"><i class="fa-solid fa-angle-right text-muted me-1"></i> <?= __('Medical Store, Canteen & Janasevana Kendram', 'മെഡിക്കൽ സ്റ്റോർ, കാന്റീൻ, ജനസേവന കേന്ദ്രം') ?></a></li>
                </ul>
              </div>
            </div>
            <div class="bg-light p-2 rounded mt-2 text-center">
              <a href="<?= url('/services') ?>" class="small fw-bold text-primary text-decoration-none"><?= __('view_all') ?> <?= __('nav_services') ?> <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= url('/interest-rates') ?>"><?= __('nav_rates') ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= url('/calculators') ?>"><?= __('nav_calculators') ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= url('/branches') ?>"><?= __('nav_branches') ?></a>
        </li>

        <?php if (module_enabled('welfare_projects')): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= url('/welfare') ?>"><?= __('nav_welfare') ?></a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="<?= url('/contact') ?>"><?= __('nav_contact') ?></a>
        </li>

        <!-- Quick Action CTA -->
        <li class="nav-item ms-lg-2">
          <a href="<?= url('/service-request') ?>" class="btn btn-primary btn-sm px-3">
            <i class="fa-solid fa-file-signature me-1"></i> <?= __('enquire_now') ?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
