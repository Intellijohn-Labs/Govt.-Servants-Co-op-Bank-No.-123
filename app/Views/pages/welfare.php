<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('nav_welfare') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-hand-holding-heart text-danger me-2"></i>
      <?= __('nav_welfare') ?> / <?= is_malayalam() ? 'സേവനങ്ങൾ' : 'Our Services' ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= __('Services run by the institution for government employees and the general public.', 'സർക്കാർ ജീവനക്കാർക്കും പൊതുജനങ്ങൾക്കുമായി സ്ഥാപനം നടത്തുന്ന സേവനങ്ങൾ.') ?>
    </p>
  </div>
</div>

<div class="container py-5">
<?php
$memberServices = [
  ['fa-kit-medical',  'danger',    'Neethi Medical Store', 'നീതി മെഡിക്കൽ സ്റ്റോർ',
   'For government employees and the general public.', 'സർക്കാർ ജീവനക്കാർക്കും പൊതുജനങ്ങൾക്കുമായി.'],
  ['fa-pencil',       'primary',   'Stationery Store', 'സ്റ്റേഷനറി സ്റ്റോർ',
   'School and office supplies that help keep open-market price rises in check.', 'സ്കൂൾ, ഓഫീസ് ഉപകരണങ്ങളുമായി പൊതുവിപണിയിലെ വിലക്കയറ്റം പിടിച്ചു നിർത്താനുപകരിക്കുന്ന സ്റ്റേഷനറി സ്റ്റോർ.'],
  ['fa-utensils',     'warning',   'Canteen', 'കാന്റീൻ',
   'A canteen providing good-quality food at low cost.', 'കുറഞ്ഞ നിരക്കിൽ ഗുണമേന്മയുള്ള ഭക്ഷണം ലഭ്യമാക്കുന്നതിനുള്ള കാന്റീൻ.'],
  ['fa-landmark',     'success',   'Janasevana Kendram', 'ജനസേവന കേന്ദ്രം',
   'A service centre offering 300+ services.', '300-ൽ പരം സേവനങ്ങളുമായി ജനസേവന കേന്ദ്രം.'],
  ['fa-print',        'secondary', 'Photocopy Unit', 'ഫോട്ടോ കോപ്പി യൂണിറ്റ്',
   'Photocopying at moderate charges.', 'മിതമായ നിരക്ക് ഈടാക്കിക്കൊണ്ട് ഫോട്ടോ കോപ്പി യൂണിറ്റ്.'],
];
?>
  <section id="member-services" class="mb-5" aria-labelledby="member-services-title">
    <h2 id="member-services-title" class="h4 fw-bold mb-1">
      <?= __('Services for Government Employees & the Public', 'സർക്കാർ ജീവനക്കാർക്കും പൊതുജനങ്ങൾക്കുമായി') ?>
    </h2>
    <p class="text-muted small mb-4"><?= __('Run by the institution for the benefit of the community.', 'സ്ഥാപനം നേരിട്ട് നടത്തുന്ന സേവനങ്ങൾ.') ?></p>
    <div class="row g-4">
      <?php foreach ($memberServices as [$icon, $tone, $en, $ml, $descEn, $descMl]): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
              <div class="rounded-circle bg-<?= $tone ?>-subtle text-<?= $tone ?> d-inline-flex align-items-center justify-content-center mb-3" style="width:56px;height:56px;">
                <i class="fa-solid <?= $icon ?> fa-lg" aria-hidden="true"></i>
              </div>
              <h3 class="h5 fw-bold text-dark mb-2"><?= is_malayalam() ? $ml : $en ?></h3>
              <p class="text-muted small mb-0"><?= is_malayalam() ? $descMl : $descEn ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Contact CTA -->
  <div class="card border-0 bg-primary text-white shadow-sm p-4 p-md-5">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h4 class="fw-bold mb-2"><?= __('Want to know more?', 'കൂടുതൽ അറിയാൻ') ?></h4>
        <p class="mb-0 text-white opacity-75">
          <?= __('Contact us or visit your nearest branch for details of these services.', 'ഈ സേവനങ്ങളെക്കുറിച്ച് കൂടുതൽ വിവരങ്ങൾക്ക് ഞങ്ങളെ ബന്ധപ്പെടുകയോ അടുത്തുള്ള ശാഖ സന്ദർശിക്കുകയോ ചെയ്യുക.') ?>
        </p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="<?= url('/contact') ?>" class="btn btn-light text-primary fw-bold px-4 py-2 me-2"><?= __('nav_contact') ?></a>
        <a href="<?= url('/branches') ?>" class="btn btn-outline-light px-4 py-2"><?= __('nav_branches') ?></a>
      </div>
    </div>
  </div>
</div>
