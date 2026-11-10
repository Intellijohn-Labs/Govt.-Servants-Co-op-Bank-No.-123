<?php
$crumbs = [
    ['title' => __('Privacy Policy', 'സ്വകാര്യതാ നയം'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        <h1 class="fw-bold mb-3"><?= __('Privacy Policy & Data Protection', 'സ്വകാര്യതാ നയവും വിവര സംരക്ഷണവും') ?></h1>
        <div class="text-muted small mb-4">
          <?= __('Aligned with the Digital Personal Data Protection (DPDP) Act, India', 'ഡിജിറ്റൽ പേഴ്സണൽ ഡാറ്റാ പ്രൊട്ടക്ഷൻ ആക്ട് പ്രകാരമുള്ള നയം') ?> | <?= __('Last Updated', 'അവസാനം പുതുക്കിയത്') ?>: <?= date('F Y') ?>
        </div>

        <div class="content-body lh-lg text-dark">
          <h5 class="fw-bold text-primary">1. <?= __('Commitment to Member Privacy', 'വ്യക്തിഗത വിവര സംരക്ഷണം') ?></h5>
          <p>
            <?= e(setting('legal.approved_public_name')) ?> is committed to safeguarding personal information submitted through this website. We process only minimal data necessary to respond to financial service enquiries, loan applications, and customer feedback.
          </p>

          <h5 class="fw-bold text-primary mt-4">2. <?= __('Strict No-Aadhaar and No-Card Policy on Web Forms', 'ആധാർ, കാർഡ് വിവരങ്ങൾ ശേഖരിക്കാതിരിക്കാനുള്ള നയം') ?></h5>
          <div class="alert alert-info border-0 rounded-3">
            <i class="fa-solid fa-shield-halved me-2"></i>
            <strong><?= __('Security Protocol', 'സുരക്ഷാ മാനദണ്ഡം') ?>:</strong>
            <?= __('We NEVER collect biometric data, Aadhaar card numbers, credit/debit card numbers, CVVs, or Net Banking login passwords on this informational portal. PAN numbers, where referenced, are strictly masked in administrative databases for privacy.', 'ഈ വെബ്സൈറ്റിലൂടെ ആധാർ നമ്പർ, കാർഡ് വിവരങ്ങൾ, ഒ.ടി.പി എന്നിവ ശേഖരിക്കുന്നതല്ല. പാൻ കാർഡ് വിവരങ്ങൾ എൻക്രിപ്റ്റ് ചെയ്ത് സൂക്ഷിക്കുന്നു.') ?>
          </div>

          <h5 class="fw-bold text-primary mt-4">3. <?= __('Information We Collect & Purpose', 'ശേഖരിക്കുന്ന വിവരങ്ങളും ഉദ്ദേശ്യവും') ?></h5>
          <p>
            When you submit a contact enquiry or service request, we collect your Name, Phone Number, Email, and Branch Preference solely for contacting you regarding your specific financial enquiry. We never sell, rent, or lease contact information to third-party marketing companies.
          </p>

          <h5 class="fw-bold text-primary mt-4">4. <?= __('Right to Data Correction and Erasure', 'വിവരങ്ങൾ തിരുത്താനും നീക്കം ചെയ്യാനുമുള്ള അവകാശം') ?></h5>
          <p>
            In accordance with Indian data protection regulations, any user may request the correction or complete erasure of their submitted contact records from our web server. To initiate a data deletion request, write to: <a href="mailto:<?= e(setting('contact.email')) ?>"><?= e(setting('contact.email')) ?></a> with your original tracking code.
          </p>

          <h5 class="fw-bold text-primary mt-4">5. <?= __('Cookie Notice', 'കുക്കികൾ സംബന്ധിച്ച നയം') ?></h5>
          <p class="mb-0">
            This website utilizes minimal, essential session cookies required for security verification (CSRF tokens) and maintaining your preferred language selection (English or Malayalam). No tracking advertising cookies are placed on your device.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
