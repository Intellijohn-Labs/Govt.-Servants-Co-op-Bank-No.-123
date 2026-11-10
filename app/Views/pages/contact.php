<?php
$crumbs = [
    ['title' => __('nav_contact'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-primary text-white mb-2"><?= __('Get in Touch', 'ബന്ധപ്പെടുക') ?></span>
    <h1 class="fw-bold mb-2"><?= __('nav_contact') ?></h1>
    <p class="text-muted">
      <?= __('We are here to assist you with all your banking and credit inquiries. Reach out to our head office or visit your nearest branch.', 'നിങ്ങളുടെ എല്ലാ സംശയങ്ങൾക്കും സഹായങ്ങൾക്കുമായി ഞങ്ങളെ ബന്ധപ്പെടാം.') ?>
    </p>
  </div>

  <div class="row g-4">
    <!-- Contact Information & Head Office Card -->
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-building-columns me-2"></i> <?= __('Head Office', 'ഹെഡ് ഓഫീസ്') ?></h5>
        <p class="text-muted small mb-3">
          <i class="fa-solid fa-location-dot me-2 text-danger"></i>
          <?= is_malayalam() ? e(setting('contact.head_office_address_ml')) : e(setting('contact.head_office_address_en')) ?>
        </p>

        <ul class="list-unstyled small mb-4">
          <?php if (!empty(setting('contact.primary_phone'))): ?>
            <li class="mb-2"><i class="fa-solid fa-phone me-2 text-primary"></i> <strong><?= __('Phone', 'ഫോൺ') ?>:</strong> <a href="tel:<?= e(setting('contact.primary_phone')) ?>" class="text-decoration-none text-dark"><?= e(setting('contact.primary_phone')) ?></a></li>
          <?php endif; ?>
          <?php if (!empty(setting('contact.email'))): ?>
            <li class="mb-2"><i class="fa-solid fa-envelope me-2 text-primary"></i> <strong><?= __('Email', 'ഇമെയിൽ') ?>:</strong> <a href="mailto:<?= e(setting('contact.email')) ?>" class="text-decoration-none text-dark"><?= e(setting('contact.email')) ?></a></li>
          <?php endif; ?>
          <?php if (!empty(setting('contact.working_hours_en'))): ?>
            <li class="mb-2"><i class="fa-solid fa-clock me-2 text-warning"></i> <strong><?= __('Hours', 'പ്രവർത്തന സമയം') ?>:</strong> <?= is_malayalam() ? e(setting('contact.working_hours_ml')) : e(setting('contact.working_hours_en')) ?></li>
          <?php endif; ?>
        </ul>

        <?php if (!empty(setting('contact.whatsapp_number'))): ?>
          <a href="https://wa.me/<?= e(setting('contact.whatsapp_number')) ?>" class="btn btn-success w-100 fw-bold" target="_blank" rel="noopener noreferrer">
            <i class="fa-brands fa-whatsapp me-2"></i> <?= __('Chat on WhatsApp', 'വാട്സാപ്പിൽ സംസാരിക്കാം') ?>
          </a>
        <?php endif; ?>
      </div>

      <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
        <h6 class="fw-bold mb-2"><i class="fa-solid fa-map-pin me-2 text-primary"></i> <?= __('Looking for a Branch?', 'ശാഖകൾ തിരയുകയാണോ?') ?></h6>
        <p class="small text-muted mb-3"><?= __('Locate branch addresses, manager contacts, and 365-day evening banking centers across our operational area.', 'നിങ്ങളുടെ പ്രദേശത്തെ ശാഖകളുടെ ഫോൺ നമ്പറുകളും പ്രവർത്തന സമയവും അറിയാൻ ശാഖാ ഡയറക്ടറി കാണുക.') ?></p>
        <a href="<?= url('/branches') ?>" class="btn btn-outline-primary btn-sm fw-bold">
          <?= __('View Branch Directory', 'ശാഖാ വിവരങ്ങൾ കാണുക') ?> &rarr;
        </a>
      </div>
    </div>

    <!-- Contact Form with Validation & CSRF -->
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        <h4 class="fw-bold text-dark mb-1"><?= __('contact_form_title') ?></h4>
        <p class="small text-muted mb-4"><?= __('Fill out this form and our customer relationship representative will reach out to you within 24 business hours.', 'ദയവായി വിവരങ്ങൾ പൂരിപ്പിക്കുക; ഞങ്ങളുടെ പ്രതിനിധി ഉടൻ നിങ്ങളെ ബന്ധപ്പെടും.') ?></p>

        <form action="<?= url('/contact') ?>" method="POST" class="needs-validation">
          <?= csrf_field() ?>

          <!-- Honeypot Anti-Spam (invisible to humans) -->
          <div style="display: none !important;">
            <label for="website_hp">Leave this blank</label>
            <input type="text" name="website_hp" id="website_hp" value="">
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold"><?= __('full_name') ?> <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" value="<?= e(old('name')) ?>" placeholder="<?= is_malayalam() ? 'നിങ്ങളുടെ പേര്' : 'e.g. Rahul Menon' ?>" required>
              <?php if (isset($errors['name'])): ?><div class="invalid-feedback"><?= e($errors['name']) ?></div><?php endif; ?>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold"><?= __('phone_number') ?> <span class="text-danger">*</span></label>
              <input type="tel" name="phone" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" value="<?= e(old('phone')) ?>" placeholder="10-digit mobile number" required>
              <?php if (isset($errors['phone'])): ?><div class="invalid-feedback"><?= e($errors['phone']) ?></div><?php endif; ?>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold"><?= __('email_address') ?> <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= e(old('email')) ?>" placeholder="you@domain.com" required>
              <?php if (isset($errors['email'])): ?><div class="invalid-feedback"><?= e($errors['email']) ?></div><?php endif; ?>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold"><?= __('select_branch') ?></label>
              <select name="branch_id" class="form-select">
                <option value=""><?= __('Head Office / Any Branch', 'ഹെഡ് ഓഫീസ് / ഏത് ശാഖയും') ?></option>
                <?php if (!empty($branches)): ?>
                  <?php foreach ($branches as $br): ?>
                    <option value="<?= (int)$br['id'] ?>"><?= is_malayalam() ? e($br['name_ml']) : e($br['name_en']) ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold"><?= __('Subject / Scheme Category', 'വിഷയം / പദ്ധതി തരം') ?> <span class="text-danger">*</span></label>
              <input type="text" name="subject" class="form-control <?= isset($errors['subject']) ? 'is-invalid' : '' ?>" value="<?= e(old('subject')) ?>" placeholder="<?= is_malayalam() ? 'ഉദാ: സ്വർണ്ണ പണയ വായ്പ അന്വേഷണം' : 'e.g. Enquiry about Gold Loan scheme' ?>" required>
              <?php if (isset($errors['subject'])): ?><div class="invalid-feedback"><?= e($errors['subject']) ?></div><?php endif; ?>
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold"><?= __('message') ?> <span class="text-danger">*</span></label>
              <textarea name="message" rows="4" class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>" placeholder="<?= is_malayalam() ? 'നിങ്ങളുടെ അന്വേഷണത്തിന്റെ വിശദാംശങ്ങൾ ഇവിടെ രേഖപ്പെടുത്തുക...' : 'Please enter your enquiry or requirement details here...' ?>" required><?= e(old('message')) ?></textarea>
              <?php if (isset($errors['message'])): ?><div class="invalid-feedback"><?= e($errors['message']) ?></div><?php endif; ?>
            </div>

            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="consent" id="privacyConsent" value="1" required>
                <label class="form-check-label small text-muted" for="privacyConsent">
                  <?= __('privacy_consent') ?>
                </label>
              </div>
            </div>

            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                <i class="fa-solid fa-paper-plane me-2"></i> <?= __('submit') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
