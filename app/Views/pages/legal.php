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
          <?= e(setting('legal.approved_public_name')) ?> is officially registered under the <strong>Kerala Co-operative Societies Act, 1969</strong> and the statutory rules framed thereunder.
        </p>
        <div class="bg-light p-3 rounded-3 mb-3 border">
          <div class="row g-2 small">
            <div class="col-md-6"><strong><?= __('Verified Legal Name', 'രജിസ്റ്റർ ചെയ്ത പൂർണ്ണ നാമം') ?>:</strong> <?= e(setting('legal.verified_legal_name')) ?></div>
            <div class="col-md-6"><strong><?= __('Registration Number', 'രജിസ്ട്രേഷൻ നമ്പർ') ?>:</strong> <?= e(setting('legal.registration_number')) ?></div>
            <div class="col-md-6"><strong><?= __('Entity Category', 'സ്ഥാപന വിഭാഗം') ?>:</strong> <?= e(strtoupper(setting('legal.entity_type'))) ?></div>
            <div class="col-md-6"><strong><?= __('Statutory Audit Classification', 'ഓഡിറ്റ് ഗ്രേഡ്') ?>:</strong> <?= e(setting('stats.audit_classification', 'Class A')) ?></div>
          </div>
        </div>

        <h4 class="fw-bold text-primary mb-3 mt-4">2. <?= __('Regulatory Scope & Banking Terms', 'റെഗുലേറ്ററി പരിധികളും നിബന്ധനകളും') ?></h4>
        <p>
          <?php if (setting('legal.entity_type') === 'licensed_bank'): ?>
            This institution holds a valid banking license from the Reserve Bank of India under the Banking Regulation Act, 1949 (As Applicable to Co-operative Societies). Deposits accepted from members and eligible public are insured up to ₹5,00,000 per depositor under the Deposit Insurance and Credit Guarantee Corporation (DICGC) Act.
          <?php else: ?>
            This institution operates as a primary service co-operative credit society under the regulatory purview of the Registrar of Co-operative Societies, Government of Kerala. In strict adherence to Section 7 of the Banking Regulation Act (Amendment), it does not represent itself as a commercial bank. All deposit acceptance and credit facilities are conducted exclusively within the society’s registered operational area for enrolled members.
          <?php endif; ?>
        </p>

        <h4 class="fw-bold text-primary mb-3 mt-4">3. <?= __('Membership & Area of Operation', 'അംഗത്വവും പ്രവർത്തന പരിധിയും') ?></h4>
        <p>
          <?= is_malayalam()
            ? 'സൊസൈറ്റിയുടെ അംഗീകൃത പ്രവർത്തന പരിധിയിൽ സ്ഥിരതാമസക്കാരായ വ്യക്തികൾക്ക് ഉപനിയമാനുസരണം എ-ക്ലാസ്, ബി-ക്ലാസ് അംഗത്വം എടുക്കാവുന്നതാണ്. അംഗങ്ങളുടെ സാമ്പത്തിക സുരക്ഷിതത്വവും സ്വാശ്രയത്വവുമാണ് പ്രവർത്തനങ്ങളുടെ മുഖ്യലക്ഷ്യം.'
            : 'Any permanent resident within our notified operational jurisdiction who meets the eligibility criteria laid down in our bylaws may apply for membership. Operations are governed democratically under the principle of one member, one vote.' ?>
        </p>

        <h4 class="fw-bold text-primary mb-3 mt-4">4. <?= __('Information Website Disclaimer', 'വെബ്സൈറ്റ് വിവര നിരാകരണം') ?></h4>
        <p class="small text-muted mb-0">
          <?= __('This portal is published purely for informational dissemination, member notices, interest schedules, and general enquiries. No direct monetary transactions, electronic fund debits, or net banking transfers are executed within this public web interface.', 'ഈ വെബ്സൈറ്റ് വിവരങ്ങൾ അറിയുന്നതിനും അറിയിപ്പുകൾക്കുമായി മാത്രമുള്ളതാണ്. ഇതിലൂടെ സാമ്പത്തിക ഇടപാടുകൾ നേരിട്ട് നടത്തുന്നതല്ല.') ?>
        </p>
      </div>
    </div>
  </div>
</div>
