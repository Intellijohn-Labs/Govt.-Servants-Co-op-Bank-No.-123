<footer class="main-footer">
  <div class="container">
    <div class="row g-4">
      <!-- Col 1: Organization & Legal Profile -->
      <div class="col-lg-4 col-md-6">
        <h5 class="text-white"><?= e(setting('legal.approved_public_name')) ?></h5>
        <p class="small text-light opacity-75 mb-3">
          <?= e(setting('tagline', 'Dedicated to empowering the local community through trustworthy, customer-centric co-operative financial services.')) ?>
        </p>

        <div class="small text-light opacity-75 mb-2">
          <div><strong><?= __('reg_no') ?>:</strong> <?= e(setting('legal.registration_number')) ?></div>
          <?php if (!empty(setting('legal.pan'))): ?>
            <div><strong><?= __('pan_no') ?>:</strong> <?= e(mask_pan(setting('legal.pan'))) ?></div>
          <?php endif; ?>
          <?php if (!empty(setting('legal.gst'))): ?>
            <div><strong><?= __('gst_no') ?>:</strong> <?= e(setting('legal.gst')) ?></div>
          <?php endif; ?>
        </div>

        <!-- Conditional DICGC Badge (Licensed Banks only) -->
        <?php if (setting('legal.entity_type') === 'licensed_bank' && setting('legal.dicgc_enabled')): ?>
          <div class="dicgc-badge">
            <i class="fa-solid fa-shield-halved"></i>
            <div>
              <div class="fw-bold text-white"><?= __('dicgc_insured') ?></div>
              <div class="small opacity-75" style="font-size: 0.75rem;"><?= is_malayalam() ? e(setting('legal.dicgc_statement_ml')) : e(setting('legal.dicgc_statement_en')) ?></div>
            </div>
          </div>
        <?php elseif (!empty(setting('legal.dicgc_statement_en'))): ?>
          <div class="mt-2 p-2 rounded bg-dark small text-warning" style="font-size: 0.75rem;">
            <?= is_malayalam() ? e(setting('legal.dicgc_statement_ml')) : e(setting('legal.dicgc_statement_en')) ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Col 2: Quick Links -->
      <div class="col-lg-2 col-md-6">
        <h5><?= __('nav_about') ?></h5>
        <ul class="list-unstyled small mb-0">
          <li class="mb-2"><a href="<?= url('/about') ?>"><?= __('nav_who_we_are') ?></a></li>
          <li class="mb-2"><a href="<?= url('/board') ?>"><?= __('nav_board') ?></a></li>
          <li class="mb-2"><a href="<?= url('/chairperson-message') ?>"><?= __('nav_chairperson_msg') ?></a></li>
          <li class="mb-2"><a href="<?= url('/achievements') ?>"><?= __('nav_achievements') ?></a></li>
          <li class="mb-2"><a href="<?= url('/legal-framework') ?>"><?= __('nav_legal_framework') ?></a></li>
          <li class="mb-2"><a href="<?= url('/grievance') ?>"><?= __('nav_grievance') ?></a></li>
          <?php if (module_enabled('tenders')): ?>
            <li class="mb-2"><a href="<?= url('/tenders') ?>"><?= __('nav_tenders') ?></a></li>
          <?php endif; ?>
          <?php if (module_enabled('careers')): ?>
            <li class="mb-2"><a href="<?= url('/careers') ?>"><?= __('nav_careers') ?></a></li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Col 3: Services & Rates -->
      <div class="col-lg-3 col-md-6">
        <h5><?= __('nav_services') ?></h5>
        <ul class="list-unstyled small mb-0">
          <li class="mb-2"><a href="<?= url('/products/gold-loan') ?>"><?= __('gold_loan') ?></a></li>
          <li class="mb-2"><a href="<?= url('/products/housing-loan') ?>"><?= __('housing_loan') ?></a></li>
          <li class="mb-2"><a href="<?= url('/products/fixed-deposit') ?>"><?= __('fixed_deposit') ?></a></li>
          <li class="mb-2"><a href="<?= url('/products/recurring-deposit') ?>"><?= __('recurring_deposit') ?></a></li>
          <li class="mb-2"><a href="<?= url('/interest-rates') ?>"><?= __('nav_rates') ?></a></li>
          <li class="mb-2"><a href="<?= url('/calculators') ?>"><?= __('nav_calculators') ?></a></li>
          <li class="mb-2"><a href="<?= url('/branches') ?>"><?= __('nav_branches') ?></a></li>
          <li class="mb-2"><a href="<?= url('/downloads') ?>"><?= __('nav_downloads') ?></a></li>
        </ul>
      </div>

      <!-- Col 4: Contact & Ombudsman -->
      <div class="col-lg-3 col-md-6">
        <h5><?= __('nav_contact') ?></h5>
        <p class="small text-light opacity-75 mb-2">
          <i class="fa-solid fa-location-dot me-1 text-warning"></i>
          <?= is_malayalam() ? e(setting('contact.head_office_address_ml')) : e(setting('contact.head_office_address_en')) ?>
        </p>

        <?php if (!empty(setting('contact.primary_phone'))): ?>
          <p class="small text-light opacity-75 mb-1">
            <i class="fa-solid fa-phone me-1 text-warning"></i> <?= e(setting('contact.primary_phone')) ?>
          </p>
        <?php endif; ?>

        <?php if (!empty(setting('contact.email'))): ?>
          <p class="small text-light opacity-75 mb-3">
            <i class="fa-solid fa-envelope me-1 text-warning"></i> <?= e(setting('contact.email')) ?>
          </p>
        <?php endif; ?>

        <?php if (!empty(setting('legal.ombudsman_url'))): ?>
          <div class="mt-2 pt-2 border-top border-secondary">
            <a href="<?= e(setting('legal.ombudsman_url')) ?>" target="_blank" rel="noopener noreferrer" class="small text-info text-decoration-none">
              <i class="fa-solid fa-scale-balanced me-1"></i> <?= e(setting('legal.ombudsman_name', 'Co-operative Ombudsman')) ?> <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Bottom Strip -->
    <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        &copy; <?= date('Y') ?> <?= e(setting('legal.verified_legal_name')) ?>. <?= __('copyright') ?>
        <span class="d-none d-md-inline ms-2">| <?= __('last_updated') ?>: <?= date('d M Y') ?></span>
      </div>

      <div class="d-flex align-items-center gap-3">
        <a href="<?= url('/privacy-policy') ?>" class="small"><?= __('Privacy Policy', 'സ്വകാര്യതാ നയം') ?></a>
        <a href="<?= url('/terms') ?>" class="small"><?= __('Terms', 'വ്യവസ്ഥകൾ') ?></a>
        <a href="<?= url('/sitemap') ?>" class="small"><?= __('Sitemap', 'സൈറ്റ്മാപ്പ്') ?></a>
        <span class="badge bg-secondary"><i class="fa-solid fa-lock me-1"></i> <?= __('ssl_secure') ?></span>
      </div>
    </div>
  </div>
</footer>
