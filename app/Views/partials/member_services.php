<?php
/**
 * Member & public services grid (5 services). Shared by /welfare and the home page.
 * Optional: $heading (bool, default true), $cta (bool, default false)
 */
$showHeading = $showHeading ?? true;
$showCta = $showCta ?? false;
$memberServices = [
  ['svc-medical',    'fa-kit-medical', 'tone-red',   'Neethi Medical Store', 'നീതി മെഡിക്കൽ സ്റ്റോർ',
   'All English medicines at 15%+ discount, with extra discounts for senior citizens and life-saving drugs.', 'എല്ലാവിധ ഇംഗ്ലീഷ് മരുന്നുകൾക്കും 15%-ലധികം ഡിസ്കൗണ്ട്; മുതിർന്ന പൗരന്മാർക്കും ജീവൻരക്ഷാ മരുന്നുകൾക്കും പ്രത്യേക ഡിസ്കൗണ്ട്.'],
  ['svc-stationery', 'fa-pencil',      'tone-blue',  'Stationery Store', 'സ്റ്റേഷനറി സ്റ്റോർ',
   'School and office supplies that help keep open-market price rises in check.', 'സ്കൂൾ, ഓഫീസ് ഉപകരണങ്ങളുമായി പൊതുവിപണിയിലെ വിലക്കയറ്റം പിടിച്ചു നിർത്താനുപകരിക്കുന്ന സ്റ്റേഷനറി സ്റ്റോർ.'],
  ['svc-canteen',    'fa-utensils',    'tone-amber', 'Canteen', 'കാന്റീൻ',
   'Quality food at affordable prices, run by women from disadvantaged backgrounds.', 'നിർധനരായ വനിതകൾ നടത്തുന്ന, കുറഞ്ഞ നിരക്കിൽ ഗുണമേന്മയുള്ള ഭക്ഷണം ലഭ്യമാക്കുന്ന കാന്റീൻ.'],
  ['svc-janasevana', 'fa-landmark',    'tone-green', 'Janasevana Kendram', 'ജനസേവന കേന്ദ്രം',
   '300+ online government and utility payment services.', '300-ൽ പരം സർക്കാർ ഓൺലൈൻ, യൂട്ടിലിറ്റി സേവനങ്ങൾ.'],
  ['svc-photocopy',  'fa-print',       'tone-slate', 'Photocopy Unit', 'ഫോട്ടോ കോപ്പി യൂണിറ്റ്',
   'Just ₹1 per copy.', 'ഒരു കോപ്പിക്ക് ഒരു രൂപ മാത്രം.'],
];
?>
<section id="member-services" aria-labelledby="member-services-title">
  <?php if ($showHeading): ?>
    <div class="text-center mb-4 mb-lg-5">
      <span class="section-eyebrow"><i class="fa-solid fa-store"></i> <?= __('Member Services', 'സേവനങ്ങൾ') ?></span>
      <h2 id="member-services-title" class="section-title text-balance">
        <?= __('Services for Government Employees & the Public', 'സർക്കാർ ജീവനക്കാർക്കും പൊതുജനങ്ങൾക്കുമായി') ?>
      </h2>
      <p class="section-lead mb-0"><?= __('Run by the institution for the benefit of the community.', 'സ്ഥാപനം നേരിട്ട് നടത്തുന്ന സേവനങ്ങൾ.') ?></p>
    </div>
  <?php endif; ?>
  <div class="row g-3 g-lg-4 justify-content-center">
    <?php foreach ($memberServices as [$anchor, $icon, $tone, $en, $ml, $descEn, $descMl]): ?>
      <div class="col-12 col-sm-6 col-lg-4">
        <article class="service-card" id="<?= $anchor ?>">
          <div class="service-icon <?= $tone ?>"><i class="fa-solid <?= $icon ?>" aria-hidden="true"></i></div>
          <h3><?= is_malayalam() ? $ml : $en ?></h3>
          <p><?= is_malayalam() ? $descMl : $descEn ?></p>
        </article>
      </div>
    <?php endforeach; ?>
  </div>
  <?php if ($showCta): ?>
    <div class="text-center mt-4">
      <a href="<?= url('/welfare') ?>" class="btn btn-outline-primary px-4"><?= __('View all services', 'എല്ലാ സേവനങ്ങളും കാണുക') ?> <i class="fa-solid fa-arrow-right ms-1"></i></a>
    </div>
  <?php endif; ?>
</section>
