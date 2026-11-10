<?php
$crumbs = [
    ['title' => __('Sitemap', 'സൈറ്റ്മാപ്പ്'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-primary text-white mb-2"><?= __('Directory & Navigation', 'ഡയറക്ടറി') ?></span>
    <h1 class="fw-bold mb-2"><?= __('HTML Sitemap', 'സൈറ്റ്മാപ്പ്') ?></h1>
    <p class="text-muted">
      <?= __('Hierarchical overview of all public sections, product catalogues, and service portals available on this website.', 'ഈ വെബ്സൈറ്റിലെ എല്ലാ പ്രധാന പേജുകളുടെയും പട്ടിക.') ?>
    </p>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-circle-info me-2"></i> <?= __('About the Institution', 'ഞങ്ങളെക്കുറിച്ച്') ?></h5>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
          <li class="mb-2"><a href="<?= url('/about') ?>"><?= __('nav_who_we_are') ?></a></li>
          <li class="mb-2"><a href="<?= url('/board') ?>"><?= __('nav_board') ?></a></li>
          <li class="mb-2"><a href="<?= url('/chairperson-message') ?>"><?= __('nav_chairperson_msg') ?></a></li>
          <li class="mb-2"><a href="<?= url('/achievements') ?>"><?= __('nav_achievements') ?></a></li>
          <li class="mb-2"><a href="<?= url('/legal-framework') ?>"><?= __('nav_legal_framework') ?></a></li>
        </ul>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-piggy-bank me-2"></i> <?= __('Products & Services', 'സേവനങ്ങൾ') ?></h5>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="<?= url('/services') ?>"><?= __('Services Hub Overview', 'സേവനങ്ങൾ') ?></a></li>
          <li class="mb-2"><a href="<?= url('/products/gold-loan') ?>"><?= __('gold_loan') ?></a></li>
          <li class="mb-2"><a href="<?= url('/products/housing-loan') ?>"><?= __('housing_loan') ?></a></li>
          <li class="mb-2"><a href="<?= url('/products/fixed-deposit') ?>"><?= __('fixed_deposit') ?></a></li>
          <li class="mb-2"><a href="<?= url('/products/recurring-deposit') ?>"><?= __('recurring_deposit') ?></a></li>
          <li class="mb-2"><a href="<?= url('/interest-rates') ?>"><?= __('nav_rates') ?></a></li>
          <li class="mb-2"><a href="<?= url('/calculators') ?>"><?= __('nav_calculators') ?></a></li>
        </ul>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-headset me-2"></i> <?= __('Branch & Contact Services', 'സഹായ കേന്ദ്രങ്ങൾ') ?></h5>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="<?= url('/branches') ?>"><?= __('nav_branches') ?></a></li>
          <li class="mb-2"><a href="<?= url('/contact') ?>"><?= __('nav_contact') ?></a></li>
          <li class="mb-2"><a href="<?= url('/service-request') ?>"><?= __('Service Request Portal', 'സേവന അഭ്യർത്ഥന') ?></a></li>
          <li class="mb-2"><a href="<?= url('/feedback') ?>"><?= __('Customer Feedback', 'അഭിപ്രായങ്ങൾ') ?></a></li>
          <li class="mb-2"><a href="<?= url('/grievance') ?>"><?= __('nav_grievance') ?></a></li>
          <li class="mb-2"><a href="<?= url('/downloads') ?>"><?= __('nav_downloads') ?></a></li>
          <li class="mb-2"><a href="<?= url('/privacy-policy') ?>"><?= __('Privacy Policy', 'സ്വകാര്യതാ നയം') ?></a></li>
          <li class="mb-2"><a href="<?= url('/terms') ?>"><?= __('Terms and Conditions', 'ഉപയോഗ നിബന്ധനകൾ') ?></a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
