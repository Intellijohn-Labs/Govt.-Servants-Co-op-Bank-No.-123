<?php
$crumbs = [
    ['title' => __('nav_about'), 'url' => url('/about')],
    ['title' => __('nav_legal_framework'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-secondary text-white mb-2"><?= __('Statutory Disclosures', 'നിയമാനുസൃത വിവരങ്ങൾ') ?></span>
    <h1 class="fw-bold mb-2"><?= __('nav_legal_framework') ?></h1>
    <p class="text-muted">
      <?= __('Transparent statutory disclosures governing our operations under Kerala Co-operative Societies legislation and regulatory standards.', 'കേരള സഹകരണ സംഘം നിയമത്തിന് വിധേയമായ ഭരണഘടനാപരമായ ചട്ടക്കൂട്.') ?>
    </p>
  </div>

  <div class="row g-4 justify-content-center">
    <div class="col-lg-10">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4">
        <h4 class="fw-bold text-primary mb-3">1. <?= __('Incorporation & Registration Status', 'രജിസ്ട്രേഷനും നിയമസാധുതയും') ?></h4>
        <p>
          <?= e(bank_name()) ?> is officially registered under the <strong>Kerala Co-operative Societies Act, 1969</strong> and the statutory rules framed thereunder.
        </p>
        <div class="bg-light p-3 rounded-3 mb-3 border">
          <div class="row g-2 small">
            <div class="col-md-6"><strong><?= __('Verified Legal Name', 'രജിസ്റ്റർ ചെയ്ത പൂർണ്ണ നാമം') ?>:</strong> <?= e(setting('legal.verified_legal_name')) ?></div>
            <div class="col-md-6"><strong><?= __('Registration Number', 'രജിസ്ട്രേഷൻ നമ്പർ') ?>:</strong> <?= e(setting('legal.registration_number')) ?></div>
            <div class="col-md-6"><strong><?= __('Entity Category', 'സ്ഥാപന വിഭാഗം') ?>:</strong> <?= __('Govt. Servants’ Co-operative Bank', 'സർക്കാർ ജീവനക്കാരുടെ സഹകരണ ബാങ്ക്') ?></div>
            <div class="col-md-6"><strong><?= __('Statutory Audit Classification', 'ഓഡിറ്റ് ഗ്രേഡ്') ?>:</strong> <?= e(setting('stats.audit_classification', 'Class 1')) ?></div>
          </div>
        </div>

        <h4 class="fw-bold text-primary mb-3 mt-4">2. <?= __('Regulatory Scope & Banking Terms', 'റെഗുലേറ്ററി പരിധികളും നിബന്ധനകളും') ?></h4>
        <p>
          <?= is_malayalam()
            ? 'ഇത് കേരള സഹകരണ സംഘം നിയമം, 1969 പ്രകാരം രജിസ്റ്റർ ചെയ്ത (രജി. നമ്പർ 123) സഹകരണ സ്ഥാപനമാണ്; കേരള സർക്കാരിന്റെ സഹകരണ സംഘം രജിസ്ട്രാറുടെ നിയന്ത്രണത്തിൽ പ്രവർത്തിക്കുന്നു. 2021 ആഗസ്റ്റ് മുതൽ ക്ലാസ്സ് 1 ബാങ്കായി തരംതിരിച്ചിരിക്കുന്നു.'
            : 'This institution is a co-operative society registered under the Kerala Co-operative Societies Act, 1969 (Reg. No. 123) and operates under the regulatory purview of the Registrar of Co-operative Societies, Government of Kerala. It has been classified as a Class 1 bank since August 2021.' ?>
        </p>

        <h4 class="fw-bold text-primary mb-3 mt-4">3. <?= __('Membership & Area of Operation', 'അംഗത്വവും പ്രവർത്തന പരിധിയും') ?></h4>
        <p>
          <?php
            $elig = is_malayalam() ? setting('legal.membership_eligibility_ml') : setting('legal.membership_eligibility_en');
            if (!empty($elig)):
          ?>
            <?= __('Membership is open to:', 'അംഗത്വം നൽകുന്നത്:') ?> <?= e($elig) ?>
          <?php else: ?>
            <?= __('Membership is governed by the bank’s bylaws.', 'അംഗത്വം ബാങ്കിന്റെ ഉപനിയമങ്ങൾക്ക് വിധേയമാണ്.') ?>
          <?php endif; ?>
        </p>

        <h4 class="fw-bold text-primary mb-3 mt-4">4. <?= __('Information Website Disclaimer', 'വെബ്സൈറ്റ് വിവര നിരാകരണം') ?></h4>
        <p class="small text-muted mb-0">
          <?= __('This portal is published purely for informational dissemination, member notices, interest schedules, and general enquiries. No direct monetary transactions, electronic fund debits, or net banking transfers are executed within this public web interface.', 'ഈ വെബ്സൈറ്റ് വിവരങ്ങൾ അറിയുന്നതിനും അറിയിപ്പുകൾക്കുമായി മാത്രമുള്ളതാണ്. ഇതിലൂടെ സാമ്പത്തിക ഇടപാടുകൾ നേരിട്ട് നടത്തുന്നതല്ല.') ?>
        </p>
      </div>
    </div>
  </div>
</div>
