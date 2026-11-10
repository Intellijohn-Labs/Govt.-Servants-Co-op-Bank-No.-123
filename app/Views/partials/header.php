<?php
$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
$rawPath = parse_url($currentUri, PHP_URL_PATH) ?? '/';
$cleanPath = preg_replace('#^/(ml|en)#', '', $rawPath);
if ($cleanPath === '' || $cleanPath === false) {
    $cleanPath = '/';
}
$enUrl = $cleanPath . '?lang=en';
$mlUrl = '/ml' . ($cleanPath === '/' ? '' : $cleanPath) . '?lang=ml';

$helpline = setting('contact.toll_free') ?: setting('contact.primary_phone');
$hours = is_malayalam() ? setting('contact.working_hours_ml') : setting('contact.working_hours_en');

// Member services shown in the mega menu (anchors on /welfare)
$memberServiceLinks = [
    ['svc-medical',   'fa-kit-medical', 'Neethi Medical Store',  'നീതി മെഡിക്കൽ സ്റ്റോർ'],
    ['svc-stationery','fa-pencil',      'Stationery Store',      'സ്റ്റേഷനറി സ്റ്റോർ'],
    ['svc-canteen',   'fa-utensils',    'Canteen',               'കാന്റീൻ'],
    ['svc-janasevana','fa-landmark',    'Janasevana Kendram',    'ജനസേവന കേന്ദ്രം'],
    ['svc-photocopy', 'fa-print',       'Photocopy Unit',        'ഫോട്ടോ കോപ്പി യൂണിറ്റ്'],
];
?>
<!-- Top Utility Bar -->
<div class="top-bar">
  <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="d-flex align-items-center flex-wrap gap-2 gap-lg-3">
      <?php if (!empty($helpline)): ?>
        <span class="util-item"><i class="fa-solid fa-headset"></i> <?= __('Helpline', 'ഹെൽപ്പ്‌ലൈൻ') ?>: <a href="tel:<?= e(preg_replace('/\s+/', '', $helpline)) ?>"><?= e($helpline) ?></a></span>
      <?php endif; ?>
      <?php if (!empty(setting('contact.email'))): ?>
        <span class="util-sep d-none d-md-inline-block"></span>
        <span class="util-item d-none d-md-inline-flex"><i class="fa-solid fa-envelope"></i> <a href="mailto:<?= e(setting('contact.email')) ?>"><?= e(setting('contact.email')) ?></a></span>
      <?php endif; ?>
      <?php if (!empty($hours)): ?>
        <span class="util-sep d-none d-xxl-inline-block"></span>
        <span class="util-item d-none d-xxl-inline-flex"><i class="fa-solid fa-clock"></i> <?= e($hours) ?></span>
      <?php endif; ?>
      <span class="util-sep d-none d-lg-inline-block"></span>
      <a href="<?= url('/branches') ?>" class="util-item util-link d-none d-lg-inline-flex"><i class="fa-solid fa-location-dot"></i> <?= __('Branch Locator', 'ശാഖ കണ്ടെത്തുക') ?></a>
    </div>

    <div class="d-flex align-items-center gap-2">
      <button type="button" class="btn btn-sm text-white p-0 border-0 me-1" id="searchToggleBtn" aria-label="<?= __('search_placeholder') ?>">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
      <div class="d-flex gap-1" role="group" aria-label="Language selection">
        <a href="<?= e($enUrl) ?>" class="btn btn-lang <?= !is_malayalam() ? 'active' : '' ?>" lang="en">English</a>
        <a href="<?= e($mlUrl) ?>" class="btn btn-lang <?= is_malayalam() ? 'active' : '' ?>" lang="ml">മലയാളം</a>
      </div>
      <?php if (auth_check()): ?>
        <a href="/admin" class="btn btn-lang"><i class="fa-solid fa-gauge me-1"></i> CMS</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Collapsible Global Search Bar -->
<div id="searchCollapse" class="d-none bg-light border-bottom py-2">
  <div class="container">
    <form action="<?= url('/search') ?>" method="GET" class="d-flex gap-2">
      <input type="text" name="q" class="form-control" placeholder="<?= __('search_placeholder') ?>" aria-label="<?= __('search_placeholder') ?>" required>
      <button type="submit" class="btn btn-primary" aria-label="<?= __('Search', 'തിരയുക') ?>"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>
</div>

<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-xl main-navbar sticky-top" aria-label="<?= __('Main navigation', 'പ്രധാന മെനു') ?>">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= url('/') ?>">
      <?php if (!empty(setting('branding.logo'))): ?>
        <span class="brand-logo-wrap"><img src="<?= e(asset(setting('branding.logo'))) ?>" alt="<?= e(setting('legal.short_name', 'Logo')) ?>" class="brand-logo" width="48" height="48"></span>
      <?php else: ?>
        <div class="brand-icon-box text-white p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
          <i class="fa-solid fa-building-columns fa-lg"></i>
        </div>
      <?php endif; ?>
      <div>
        <div class="fw-bold fs-5 text-dark lh-sm"><?= e(bank_name()) ?></div>
        <div class="text-muted" style="font-size: 0.72rem;"><?= __('Class 1 Bank', 'ക്ലാസ്സ് 1 ബാങ്ക്') ?> · <?= e(registration_number()) ?></div>
      </div>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavigation">
      <ul class="navbar-nav ms-auto mb-2 mb-xl-0 align-items-xl-center">
        <li class="nav-item">
          <a class="nav-link<?= $cleanPath === '/' ? ' active' : '' ?>" href="<?= url('/') ?>"<?= $cleanPath === '/' ? ' aria-current="page"' : '' ?>><?= __('nav_home') ?></a>
        </li>

        <!-- About Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= __('nav_about') ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= url('/about') ?>"><?= __('nav_who_we_are') ?></a></li>
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
          <div class="dropdown-menu dropdown-menu-end mega-menu">
            <div class="mega-menu-grid">
              <div class="mega-col">
                <h6><i class="fa-solid fa-hand-holding-dollar me-1"></i> <?= __('nav_loans') ?></h6>
                <a href="<?= url('/interest-rates') ?>#loan-rates"><i class="fa-solid fa-percent"></i> <?= __('Loan Interest Rates', 'വായ്പാ പലിശ നിരക്കുകൾ') ?></a>
                <a href="<?= url('/calculators') ?>"><i class="fa-solid fa-calculator"></i> <?= __('EMI Calculator', 'ഇ.എം.ഐ കാൽക്കുലേറ്റർ') ?></a>
                <a href="<?= url('/service-request') ?>"><i class="fa-solid fa-file-signature"></i> <?= __('Apply for a Loan', 'വായ്പയ്ക്ക് അപേക്ഷിക്കുക') ?></a>
              </div>

              <div class="mega-col">
                <h6><i class="fa-solid fa-piggy-bank me-1"></i> <?= __('nav_deposits') ?></h6>
                <a href="<?= url('/interest-rates') ?>#deposit-rates"><i class="fa-solid fa-percent"></i> <?= __('Deposit Schemes', 'നിക്ഷേപ പദ്ധതികൾ') ?></a>
                <a href="<?= url('/service-request') ?>"><i class="fa-solid fa-file-signature"></i> <?= __('Deposit Enquiry', 'നിക്ഷേപ അന്വേഷണം') ?></a>
                <a href="<?= url('/branches') ?>"><i class="fa-solid fa-location-dot"></i> <?= __('Visit a Branch', 'ശാഖ സന്ദർശിക്കുക') ?></a>
              </div>

              <div class="mega-col">
                <h6><i class="fa-solid fa-store me-1"></i> <?= __('Member Services', 'സേവനങ്ങൾ') ?></h6>
                <?php foreach ($memberServiceLinks as [$anchor, $icon, $en, $ml]): ?>
                  <a href="<?= url('/welfare') ?>#<?= $anchor ?>"><i class="fa-solid <?= $icon ?>"></i> <?= is_malayalam() ? $ml : $en ?></a>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link<?= $cleanPath === '/interest-rates' ? ' active' : '' ?>" href="<?= url('/interest-rates') ?>"><?= __('nav_rates') ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link<?= $cleanPath === '/calculators' ? ' active' : '' ?>" href="<?= url('/calculators') ?>"><?= __('nav_calculators') ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link<?= $cleanPath === '/branches' ? ' active' : '' ?>" href="<?= url('/branches') ?>"><?= __('nav_branches') ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link<?= $cleanPath === '/contact' ? ' active' : '' ?>" href="<?= url('/contact') ?>"><?= __('nav_contact') ?></a>
        </li>

        <!-- Quick Action CTA -->
        <li class="nav-item ms-xl-2 mt-2 mt-xl-0">
          <a href="<?= url('/service-request') ?>" class="btn btn-cta btn-sm">
            <i class="fa-solid fa-file-signature me-1"></i> <?= __('Enquire Now', 'അന്വേഷിക്കുക') ?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
