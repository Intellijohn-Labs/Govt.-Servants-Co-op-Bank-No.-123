<?php
$hours = is_malayalam() ? setting('contact.working_hours_ml') : setting('contact.working_hours_en');
$tollFree = setting('contact.toll_free');
$phone = setting('contact.primary_phone');
$grievanceEmail = setting('contact.grievance_email') ?: setting('contact.email');
$dicgcShown = setting('legal.entity_type') === 'licensed_bank'
    && setting('legal.dicgc_enabled')
    && !empty(is_malayalam() ? setting('legal.dicgc_statement_ml') : setting('legal.dicgc_statement_en'));
?>
<div class="main-footer">
  <div class="container">
    <div class="row g-4 g-xl-5">

      <!-- Regulated entity -->
      <div class="col-lg-4 col-md-12">
        <div class="footer-brand">
          <div class="brand-icon-box"><i class="fa-solid fa-building-columns"></i></div>
          <div class="fw-bold text-white fs-5 lh-sm"><?= e(setting('legal.approved_public_name')) ?></div>
        </div>
        <p class="small opacity-75 mb-3"><?= e(setting('tagline')) ?></p>

        <div class="mb-3">
          <span class="footer-badge"><i class="fa-solid fa-certificate"></i> <?= __('Class 1 Bank', 'Class 1 ബാങ്ക്') ?></span>
          <span class="footer-badge"><i class="fa-solid fa-landmark"></i> <?= __('100 Years of Service', '100 വർഷത്തെ പാരമ്പര്യം') ?></span>
        </div>

        <h5 class="mt-4"><?= __('Regulated Entity', 'സ്ഥാപന വിവരങ്ങൾ') ?></h5>
        <div class="small">
          <div class="hours-row"><span class="opacity-75"><?= e(__('reg_no')) ?></span><strong class="text-white text-end"><?= e(setting('legal.registration_number')) ?></strong></div>
          <?php if (!empty(setting('legal.rbi_license_number'))): ?>
            <div class="hours-row"><span class="opacity-75"><?= __('RBI Licence', 'ആർ.ബി.ഐ ലൈസൻസ്') ?></span><strong class="text-white"><?= e(setting('legal.rbi_license_number')) ?></strong></div>
          <?php endif; ?>
          <?php if (!empty(setting('legal.pan'))): ?>
            <div class="hours-row"><span class="opacity-75"><?= e(__('pan_no')) ?></span><strong class="text-white"><?= e(mask_pan(setting('legal.pan'))) ?></strong></div>
          <?php endif; ?>
          <?php if (!empty(setting('legal.gst'))): ?>
            <div class="hours-row"><span class="opacity-75"><?= e(__('gst_no')) ?></span><strong class="text-white"><?= e(setting('legal.gst')) ?></strong></div>
          <?php endif; ?>
        </div>

        <?php if ($dicgcShown): ?>
          <div class="dicgc-badge mt-3">
            <i class="fa-solid fa-shield-halved"></i>
            <div>
              <div class="fw-bold text-white"><?= __('dicgc_insured') ?></div>
              <div class="small opacity-75" style="font-size: .75rem;"><?= is_malayalam() ? e(setting('legal.dicgc_statement_ml')) : e(setting('legal.dicgc_statement_en')) ?></div>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Quick links -->
      <div class="col-lg-2 col-6">
        <h5><?= __('Quick Links', 'പ്രധാന ലിങ്കുകൾ') ?></h5>
        <ul class="list-unstyled small mb-0">
          <li class="mb-2"><a href="<?= url('/about') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('nav_who_we_are') ?></a></li>
          <li class="mb-2"><a href="<?= url('/achievements') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('nav_achievements') ?></a></li>
          <li class="mb-2"><a href="<?= url('/interest-rates') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('nav_rates') ?></a></li>
          <li class="mb-2"><a href="<?= url('/calculators') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('nav_calculators') ?></a></li>
          <li class="mb-2"><a href="<?= url('/welfare') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('Member Services', 'സേവനങ്ങൾ') ?></a></li>
          <li class="mb-2"><a href="<?= url('/branches') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('nav_branches') ?></a></li>
          <li class="mb-2"><a href="<?= url('/contact') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('nav_contact') ?></a></li>
        </ul>
      </div>

      <!-- Disclosures -->
      <div class="col-lg-2 col-6">
        <h5><?= __('Important Disclosures', 'പ്രധാന വെളിപ്പെടുത്തലുകൾ') ?></h5>
        <ul class="list-unstyled small mb-0">
          <li class="mb-2"><a href="<?= url('/legal-framework') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('nav_legal_framework') ?></a></li>
          <li class="mb-2"><a href="<?= url('/privacy-policy') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('Privacy Policy', 'സ്വകാര്യതാ നയം') ?></a></li>
          <li class="mb-2"><a href="<?= url('/terms') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('Terms', 'വ്യവസ്ഥകൾ') ?></a></li>
          <li class="mb-2"><a href="<?= url('/sitemap') ?>"><i class="fa-solid fa-chevron-right"></i> <?= __('Sitemap', 'സൈറ്റ്മാപ്പ്') ?></a></li>
        </ul>
        <p class="footer-disclosure mt-3 mb-0"><?= __('rates_disclaimer') ?></p>
      </div>

      <!-- Working hours -->
      <div class="col-lg-2 col-md-6">
        <h5><?= __('Working Hours', 'പ്രവർത്തന സമയം') ?></h5>
        <?php if (!empty($hours)): ?>
          <div class="help-card">
            <div class="help-label"><i class="fa-solid fa-clock me-1"></i> <?= __('Head Office', 'ഹെഡ് ഓഫീസ്') ?></div>
            <div class="small text-white mt-1"><?= e($hours) ?></div>
          </div>
        <?php endif; ?>
        <p class="small opacity-75 mb-0">
          <i class="fa-solid fa-location-dot me-1" style="color: var(--accent);"></i>
          <?= is_malayalam() ? e(setting('contact.head_office_address_ml')) : e(setting('contact.head_office_address_en')) ?>
        </p>
      </div>

      <!-- Helpline & grievance -->
      <div class="col-lg-2 col-md-6">
        <h5><?= __('Helpline & Grievance', 'ഹെൽപ്പ്‌ലൈൻ / പരാതി') ?></h5>
        <?php if (!empty($tollFree) || !empty($phone)): ?>
          <div class="help-card">
            <div class="help-label"><?= !empty($tollFree) ? __('Toll Free', 'ടോൾ ഫ്രീ') : __('Phone', 'ഫോൺ') ?></div>
            <a href="tel:<?= e(preg_replace('/\s+/', '', (string)($tollFree ?: $phone))) ?>"><?= e($tollFree ?: $phone) ?></a>
          </div>
        <?php endif; ?>
        <?php if (!empty($grievanceEmail)): ?>
          <div class="help-card">
            <div class="help-label"><?= __('Grievance Email', 'പരാതികൾക്ക്') ?></div>
            <a href="mailto:<?= e($grievanceEmail) ?>" class="small text-break"><?= e($grievanceEmail) ?></a>
          </div>
        <?php endif; ?>
        <a href="<?= url('/grievance') ?>" class="btn btn-sm btn-outline-light w-100 mb-2"><i class="fa-solid fa-comment-dots me-1"></i> <?= __('nav_grievance') ?></a>
        <a href="<?= url('/feedback') ?>" class="btn btn-sm btn-outline-light w-100"><i class="fa-solid fa-star me-1"></i> <?= __('Feedback', 'അഭിപ്രായം') ?></a>
        <?php if (!empty(setting('legal.ombudsman_url'))): ?>
          <a href="<?= e(setting('legal.ombudsman_url')) ?>" target="_blank" rel="noopener noreferrer" class="small d-inline-block mt-3">
            <i class="fa-solid fa-scale-balanced me-1"></i> <?= e(setting('legal.ombudsman_name', 'Ombudsman')) ?> <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Bottom Strip -->
    <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>&copy; <?= date('Y') ?> <?= e(setting('legal.verified_legal_name')) ?>. <?= __('copyright') ?></div>
      <span class="badge bg-secondary"><i class="fa-solid fa-lock me-1"></i> <?= __('ssl_secure') ?></span>
    </div>
  </div>
</div>
