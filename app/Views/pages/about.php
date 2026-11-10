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
      <h1 class="fw-bold mb-3"><?= is_malayalam() ? 'ഞങ്ങളുടെ ചരിത്രവും പാരമ്പര്യവും' : 'Our History & Heritage' ?></h1>
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
          ? '1920-ൽ (മലയാള വർഷം 1095) പറവൂർ താലൂക്കിലെ ഇരുപതോളം സർക്കാർ ജീവനക്കാർ ചേർന്ന് ആലോചിച്ചതിന്റെ ഫലമായി രൂപം കൊണ്ട സ്ഥാപനമാണ് 123-ാം നമ്പർ പറവൂർ താലൂക്ക് സർക്കാർ ജീവനക്കാരുടെ വിവിധോദ്ദേശ സഹകരണ സംഘം. മലയാള വർഷം 20-07-1095-ൽ രജിസ്റ്റർ ചെയ്ത് 05/08/1095-ൽ പ്രവർത്തനം ആരംഭിച്ചു. 31/01/2000 മുതൽ സ്വന്തം കെട്ടിടത്തിൽ പ്രവർത്തിച്ചു വരുന്നു.'
          : 'Founded in 1920 (Malayalam year 1095) when about twenty government employees of Paravur Taluk came together to set up a co-operative society for the welfare and financial needs of government servants, the institution began as the Paravur Taluk Government Servants’ Multipurpose Co-operative Society No. 123. It was registered on 20-07-1095 (M.E.) and began functioning on 05/08/1095 (M.E.). Since 31/01/2000 it has operated from its own building.' ?>
      </p>
      <div class="row g-3 mb-3">
        <div class="col-sm-6">
          <div class="d-flex gap-3 align-items-start p-3 bg-white border rounded-4 h-100">
            <span class="metric-icon tone-green"><i class="fa-solid fa-solar-panel" aria-hidden="true"></i></span>
            <div class="small"><strong class="d-block"><?= __('Green Bank', 'ഹരിത ബാങ്ക്') ?></strong>
              <?= __('A 20-KW solar power system is installed, making it an eco-friendly bank.', '20-KW സൗരോർജ്ജ പാനലുകൾ സ്ഥാപിച്ച് പരിസ്ഥിതി സൗഹൃദ ബാങ്കായി പ്രവർത്തിക്കുന്നു.') ?></div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="d-flex gap-3 align-items-start p-3 bg-white border rounded-4 h-100">
            <span class="metric-icon tone-amber"><i class="fa-solid fa-percent" aria-hidden="true"></i></span>
            <div class="small"><strong class="d-block"><?= __('25% Dividend', '25% ഡിവിഡൻഡ്') ?></strong>
              <?= __('A dividend of 25% is consistently paid to members.', 'അംഗങ്ങൾക്ക് 25% ഡിവിഡൻഡ് തുടർച്ചയായി നൽകിവരുന്നു.') ?></div>
          </div>
        </div>
      </div>
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
            <span class="fw-bold"><?= __('Govt. Servants’ Co-operative Bank', 'സർക്കാർ ജീവനക്കാരുടെ സഹകരണ ബാങ്ക്') ?></span>
          </li>
          <li class="mb-3 d-flex justify-content-between border-bottom border-light border-opacity-25 pb-2">
            <span class="opacity-75"><?= __('Established', 'സ്ഥാപിതം') ?></span>
            <span class="fw-bold">1920</span>
          </li>
          <li class="mb-3 d-flex justify-content-between border-bottom border-light border-opacity-25 pb-2">
            <span class="opacity-75"><?= __('Registration No.', 'രജിസ്ട്രേഷൻ നമ്പർ') ?></span>
            <span class="fw-bold"><?= e(registration_number()) ?></span>
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
