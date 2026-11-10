<?php
$crumbs = [
    ['title' => __('nav_about'), 'url' => url('/about')],
    ['title' => __('nav_who_we_are'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="row g-4 align-items-center mb-5">
    <div class="col-lg-7">
      <span class="badge bg-primary text-white mb-2"><?= __('nav_who_we_are') ?></span>
      <h1 class="fw-bold mb-3"><?= is_malayalam() ? 'ഞങ്ങളുടെ ചരിത്രവും പാരമ്പര്യവും' : 'Our History, Heritage & Mission' ?></h1>
      <p class="lead text-muted">
        <?= e(setting('tagline')) ?>
      </p>
      <div class="alert alert-light border-start border-4 border-warning shadow-sm" role="note">
        <i class="fa-solid fa-circle-check text-success me-1" aria-hidden="true"></i>
        <?= is_malayalam()
          ? 'ഏകദേശം 25 വർഷമായി തുടർച്ചയായി ലാഭത്തിൽ പ്രവർത്തിക്കുന്നു. 15 1/2 കോടിയോളം രൂപയുടെ സാമൂഹ്യ സുരക്ഷാ പെൻഷൻ വിതരണം ചെയ്തു.'
          : 'Operating continuously at a profit for about 25 years, and has distributed nearly ₹15.5 crore in social security pensions.' ?>
      </div>
      <p>
        <?= is_malayalam()
          ? 'കേരളത്തിലെ സാധാരണക്കാരായ ജനങ്ങൾക്കും കർഷകർക്കും ചെറുകിട വ്യാപാരികൾക്കും തുണയായി സ്ഥാപിതമായ ഈ സഹകരണ പ്രസ്ഥാനം, സുതാര്യവും സുരക്ഷിതവുമായ ധനകാര്യ സേവനങ്ങളിലൂടെ നാടിന്റെ സമഗ്ര സാമ്പത്തിക പുരോഗതി ലക്ഷ്യമിടുന്നു.'
          : 'Established to provide ethical, transparent, and member-centric financial empowerment, our institution has grown to become a cornerstone of local economic resilience. We combine traditional co-operative ethics with modern technology.' ?>
      </p>
      <div class="row g-3 mt-2">
        <div class="col-sm-6">
          <div class="card p-3 border-0 bg-light rounded-3">
            <div class="text-primary fs-3 mb-2"><i class="fa-solid fa-bullseye"></i></div>
            <h6 class="fw-bold"><?= __('Our Vision', 'ഞങ്ങളുടെ കാഴ്ചപ്പാട്') ?></h6>
            <p class="small text-muted mb-0">
              <?= __('To be the most trusted and digitally progressive co-operative institution uplifting every household in our operational area.', 'പ്രവർത്തന പരിധിയിലെ ഓരോ കുടുംബത്തിന്റെയും സാമ്പത്തിക ഉന്നമനം ഉറപ്പാക്കുന്ന ഏറ്റവും വിശ്വസനീയ സഹകരണ സ്ഥാപനമാകുക.') ?>
            </p>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card p-3 border-0 bg-light rounded-3">
            <div class="text-primary fs-3 mb-2"><i class="fa-solid fa-hand-holding-heart"></i></div>
            <h6 class="fw-bold"><?= __('Our Mission', 'ഞങ്ങളുടെ ദൗത്യം') ?></h6>
            <p class="small text-muted mb-0">
              <?= __('Delivering affordable credit, attractive savings returns, and proactive social welfare with uncompromised integrity.', 'താങ്ങാനാവുന്ന വായ്പകളും ആകർഷകമായ നിക്ഷേപ പദ്ധതികളും സാമൂഹ്യക്ഷേമ പ്രവർത്തനങ്ങളും സുതാര്യമായി ലഭ്യമാക്കുക.') ?>
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-primary text-white p-4">
        <h4 class="fw-bold mb-4"><?= __('Institutional Profile', 'സ്ഥാപന വിവരങ്ങൾ') ?></h4>
        <ul class="list-unstyled mb-0">
          <li class="mb-3 d-flex justify-content-between border-bottom border-light border-opacity-25 pb-2">
            <span class="opacity-75"><?= __('Entity Type', 'സ്ഥാപന തരം') ?></span>
            <span class="fw-bold text-uppercase"><?= str_replace('_', ' ', setting('legal.entity_type')) ?></span>
          </li>
          <li class="mb-3 d-flex justify-content-between border-bottom border-light border-opacity-25 pb-2">
            <span class="opacity-75"><?= __('Registration No.', 'രജിസ്ട്രേഷൻ നമ്പർ') ?></span>
            <span class="fw-bold"><?= e(setting('legal.registration_number')) ?></span>
          </li>
          <li class="mb-3 d-flex justify-content-between border-bottom border-light border-opacity-25 pb-2">
            <span class="opacity-75"><?= __('Audit Grade', 'ഓഡിറ്റ് ഗ്രേഡ്') ?></span>
            <span class="fw-bold text-warning"><?= e(setting('stats.audit_classification', 'Class A')) ?></span>
          </li>
          <li class="mb-3 d-flex justify-content-between border-bottom border-light border-opacity-25 pb-2">
            <span class="opacity-75"><?= __('Working Capital', 'പ്രവർത്തന മൂലധനം') ?></span>
            <span class="fw-bold">₹ <?= e(setting('stats.working_capital')) ?> <?= __('Lakhs', 'ലക്ഷം') ?></span>
          </li>
          <li class="mb-3 d-flex justify-content-between border-bottom border-light border-opacity-25 pb-2">
            <span class="opacity-75"><?= __('Total Deposits', 'നിക്ഷേപ ബാക്കി') ?></span>
            <span class="fw-bold">₹ <?= e(setting('stats.total_deposits')) ?> <?= __('Lakhs', 'ലക്ഷം') ?></span>
          </li>
          <li class="mb-3 d-flex justify-content-between border-bottom border-light border-opacity-25 pb-2">
            <span class="opacity-75"><?= __('Total Loans', 'വായ്പാ ബാക്കി') ?></span>
            <span class="fw-bold">₹ <?= e(setting('stats.total_loans')) ?> <?= __('Lakhs', 'ലക്ഷം') ?></span>
          </li>
          <li class="d-flex justify-content-between">
            <span class="opacity-75"><?= __('Share Capital', 'ഓഹരി മൂലധനം') ?></span>
            <span class="fw-bold">₹ <?= e(setting('stats.share_capital')) ?> <?= __('Lakhs', 'ലക്ഷം') ?></span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
