<?php
$crumbs = [
    ['title' => __('Terms & Conditions', 'വ്യവസ്ഥകളും നിബന്ധനകളും'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        <h1 class="fw-bold mb-3"><?= __('Website Terms of Use & Disclaimers', 'ഉപയോഗ നിബന്ധനകളും വിവര നിരാകരണവും') ?></h1>
        <div class="text-muted small mb-4">
          <?= e(setting('legal.approved_public_name')) ?> | <?= __('Last Updated', 'അവസാനം പുതുക്കിയത്') ?>: <?= date('F Y') ?>
        </div>

        <div class="content-body lh-lg text-dark">
          <h5 class="fw-bold text-primary">1. <?= __('Informational Purpose', 'വിവരങ്ങൾ നൽകുന്നതിനുള്ള ഉദ്ദേശ്യം') ?></h5>
          <p>
            The contents of this website (including interest rates, loan eligibility criteria, deposit calculators, and branch timings) are published for informational purposes only. While every attempt is made to keep information updated, rates and terms are subject to formal decisions of the Board of Management and applicable regulatory notifications without prior notice.
          </p>

          <h5 class="fw-bold text-primary mt-4">2. <?= __('Loan & Deposit Calculations', 'വായ്പ, നിക്ഷേപ കണക്കുകൂട്ടലുകൾ') ?></h5>
          <p>
            All EMI estimates, gold loan advance amounts, and maturity projections rendered by the online calculators are purely indicative. Actual sanctions, documentation charges, and interest rates are governed by society bylaws and appraisal protocols at the sanctioning branch.
          </p>

          <h5 class="fw-bold text-primary mt-4">3. <?= __('Intellectual Property', 'പകർപ്പവകാശം') ?></h5>
          <p>
            All text, logos, graphical assets, and digital downloads published on this portal are the intellectual property of <?= e(setting('legal.verified_legal_name')) ?>. Unauthorized copying, modification, or commercial reproduction without written permission is prohibited.
          </p>

          <h5 class="fw-bold text-primary mt-4">4. <?= __('Governing Jurisdiction', 'നിയമപരിധി') ?></h5>
          <p class="mb-0">
            Any dispute arising out of the use of this website or electronic submissions herein shall be subject to the exclusive jurisdiction of the competent courts and Co-operative Arbitration tribunals in the district of <?= e(setting('legal.district', 'Kerala, India')) ?>.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
