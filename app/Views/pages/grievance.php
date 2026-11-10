<?php
$crumbs = [
    ['title' => __('nav_about'), 'url' => url('/about')],
    ['title' => __('nav_grievance'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-danger text-white mb-2"><?= __('Member Rights & Fair Banking', 'അംഗങ്ങളുടെ അവകാശങ്ങൾ') ?></span>
    <h1 class="fw-bold mb-2"><?= __('Grievance Redressal Mechanism', 'പരാതി പരിഹാര സംവിധാനം') ?></h1>
    <p class="text-muted">
      <?= __('We are dedicated to resolving customer concerns swiftly and transparently through a structured 3-tier redressal framework.', 'ഉപഭോക്താക്കളുടെ പരാതികൾ സമയബന്ധിതമായും സുതാര്യമായും പരിഹരിക്കുന്നതിനുള്ള 3-ഘട്ട സംവിധാനം.') ?>
    </p>
  </div>

  <div class="row g-4 mb-5">
    <!-- 3-Tier Escalation Matrix -->
    <div class="col-lg-4">
      <div class="card h-100 border-0 shadow-sm rounded-4 p-4 border-top border-4 border-primary">
        <span class="badge bg-primary text-white mb-2"><?= __('Level 1: Branch Level', 'ഘട്ടം 1: ശാഖാ തലം') ?></span>
        <h5 class="fw-bold text-dark mb-2"><?= __('Branch Manager', 'ശാഖാ മാനേജർ') ?></h5>
        <p class="small text-muted mb-3">
          <?= __('Submit your concern directly to the respective Branch Manager in person or in writing. Expected resolution window: 3 to 7 working days.', 'നിങ്ങളുടെ ശാഖാ മാനേജറെ നേരിട്ട് കണ്ട് രേഖാമൂലം പരാതി നൽകുക. പരിഹാര സമയം: 3 മുതൽ 7 പ്രവൃത്തിദിനങ്ങൾ.') ?>
        </p>
        <div class="small fw-semibold text-primary"><i class="fa-solid fa-clock me-1"></i> <?= __('3 - 7 Business Days', '3 - 7 പ്രവൃത്തി ദിനങ്ങൾ') ?></div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card h-100 border-0 shadow-sm rounded-4 p-4 border-top border-4 border-warning">
        <span class="badge bg-warning text-dark mb-2"><?= __('Level 2: Head Office', 'ഘട്ടം 2: ഹെഡ് ഓഫീസ്') ?></span>
        <h5 class="fw-bold text-dark mb-2"><?= __('Principal Grievance Officer', 'ചീഫ് ഗ്രീവൻസ് ഓഫീസർ') ?></h5>
        <p class="small text-muted mb-3">
          <?= __('If unresolved at the branch level, escalate to our appointed Grievance Redressal Officer at Head Office.', 'ശാഖാ തലത്തിൽ പരിഹരിക്കപ്പെടാത്ത പരാതികൾ ഹെഡ് ഓഫീസിലെ ഗ്രീവൻസ് ഓഫീസർക്ക് അയക്കുക.') ?>
        </p>
        <div class="small text-muted border-top pt-2">
          <div><strong><?= __('Email', 'ഇമെയിൽ') ?>:</strong> <a href="mailto:<?= e(setting('contact.grievance_email', 'gscb123paravur@gmail.com')) ?>"><?= e(setting('contact.grievance_email', 'gscb123paravur@gmail.com')) ?></a></div>
        </div>
      </div>
    </div>

    <?php if (!empty(setting('legal.ombudsman_name'))): ?>
    <div class="col-lg-4">
      <div class="card h-100 border-0 shadow-sm rounded-4 p-4 border-top border-4 border-danger">
        <span class="badge bg-danger text-white mb-2"><?= __('Level 3: Ombudsman', 'ഘട്ടം 3: ഓംബുഡ്സ്മാൻ') ?></span>
        <h5 class="fw-bold text-dark mb-2"><?= e(setting('legal.ombudsman_name', 'Co-operative Ombudsman')) ?></h5>
        <p class="small text-muted mb-3">
          <?= __('If you are not satisfied with the institutional response after 30 days, you may approach the statutory Ombudsman.', '30 ദിവസത്തിനകം പരാതി പരിഹരിക്കപ്പെടാത്ത പക്ഷം നിയമാനുസൃത ഓംബുഡ്സ്മാനെ സമീപിക്കാവുന്നതാണ്.') ?>
        </p>
        <?php if (!empty(setting('legal.ombudsman_url'))): ?>
          <a href="<?= e(setting('legal.ombudsman_url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger btn-sm fw-bold w-100 mt-2">
            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> <?= __('Ombudsman Portal', 'ഓംബുഡ്സ്മാൻ പോർട്ടൽ') ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- Online Grievance Submission Card -->
  <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 max-w-900 mx-auto">
    <h4 class="fw-bold text-dark mb-1"><?= __('Submit Online Grievance', 'ഓൺലൈനായി പരാതി സമർപ്പിക്കുക') ?></h4>
    <p class="small text-muted mb-4"><?= __('You will receive an automated reference tracking number via SMS / Email upon submission.', 'പരാതി സമർപ്പിച്ച ശേഷം ട്രാക്കിംഗ് നമ്പർ നിങ്ങളുടെ മൊബൈലിൽ ലഭ്യമാകും.') ?></p>

    <form action="<?= url('/contact') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="category" value="grievance">
      <div style="display: none !important;"><input type="text" name="website_hp" value=""></div>

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label small fw-semibold"><?= __('full_name') ?> <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold"><?= __('phone_number') ?> <span class="text-danger">*</span></label>
          <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile number" required>
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold"><?= __('email_address') ?> <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold"><?= __('Member Account / Reference Number (If applicable)', 'അക്കൗണ്ട് / മെമ്പർ നമ്പർ') ?></label>
          <input type="text" name="account_number" class="form-control" placeholder="Optional">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold"><?= __('Grievance Subject / Branch Concerned', 'പരാതി വിഷയം / ബന്ധപ്പെട്ട ശാഖ') ?> <span class="text-danger">*</span></label>
          <input type="text" name="subject" class="form-control" placeholder="Brief subject" required>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold"><?= __('Detailed Grievance Description', 'പരാതിയുടെ വിശദാംശങ്ങൾ') ?> <span class="text-danger">*</span></label>
          <textarea name="message" rows="5" class="form-control" placeholder="Please describe the incident, dates, and redressal sought..." required></textarea>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="consent" id="grievanceConsent" value="1" required>
            <label class="form-check-label small text-muted" for="grievanceConsent">
              <?= __('I confirm the above statements are true to the best of my knowledge and authorize the Grievance Cell to inspect records.', 'മുകളിൽ പറഞ്ഞ വിവരങ്ങൾ പൂർണ്ണമായും സത്യമാണെന്ന് സാക്ഷ്യപ്പെടുത്തുന്നു.') ?>
            </label>
          </div>
        </div>
        <div class="col-12 mt-4">
          <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
            <i class="fa-solid fa-file-shield me-2"></i> <?= __('Register Official Grievance', 'പരാതി രജിസ്റ്റർ ചെയ്യുക') ?>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
