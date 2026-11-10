<?php
$old = \Core\Session::getFlash('old', []);
$errors = \Core\Session::getFlash('errors', []);
$successMsg = \Core\Session::getFlash('success_message');
$successTrackingCode = \Core\Session::getFlash('success_tracking_code');
?>

<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('enquire_now') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-file-signature text-primary me-2"></i>
      <?= __('enquire_now') ?> / <?= is_malayalam() ? 'ഓൺലൈൻ അപേക്ഷ' : 'Online Application' ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= is_malayalam() 
          ? 'വായ്പകൾ, നിക്ഷേപങ്ങൾ, ബാങ്കിംഗ് സേവനങ്ങൾ എന്നിവയ്ക്കായുള്ള ഓൺലൈൻ അപേക്ഷ ഇവിടെ സമർപ്പിക്കാം.' 
          : 'Apply online for loans, deposits, and customer facilities. Our branch team will assist you.' ?>
    </p>
  </div>
</div>

<div class="container py-5">
  <?php if ($successMsg): ?>
    <div class="alert alert-success shadow-sm d-flex align-items-center mb-4" role="alert">
      <i class="fa-solid fa-circle-check fs-3 me-3 text-success"></i>
      <div>
        <div class="fw-bold fs-5"><?= e($successMsg) ?></div>
        <?php if ($successTrackingCode): ?>
          <div class="mt-1">
            <strong><?= is_malayalam() ? 'നിങ്ങളുടെ ട്രാക്കിംഗ് കോഡ്' : 'Your Application Reference Number' ?>: </strong>
            <span class="badge bg-primary fs-6 px-3 py-1"><?= e($successTrackingCode) ?></span>
          </div>
          <div class="small text-muted mt-1">
            <?= is_malayalam() ? 'ഈ നമ്പർ ഭാവി റഫറൻസിനായി സൂക്ഷിക്കുക.' : 'Please keep this tracking code for reviewing your application status.' ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <!-- Left Column: Form -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
          <h4 class="card-title fw-bold text-dark mb-4 pb-2 border-bottom">
            <i class="fa-solid fa-pen-to-square text-primary me-2"></i>
            <?= is_malayalam() ? 'അപേക്ഷാ ഫോം' : 'Service Request Application' ?>
          </h4>

          <form action="<?= url('/service-request') ?>" method="POST" class="needs-validation" novalidate>
            <?= csrf_field() ?>

            <div class="row g-3">
              <!-- Full Name -->
              <div class="col-md-6">
                <label for="full_name" class="form-label fw-semibold small text-muted">
                  <?= is_malayalam() ? 'പൂർണ്ണ നാമം' : 'Full Name' ?> <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                  <input type="text" 
                         class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" 
                         id="full_name" 
                         name="full_name" 
                         value="<?= e($old['full_name'] ?? '') ?>" 
                         placeholder="e.g. Suresh Kumar" 
                         required>
                  <?php if (isset($errors['full_name'])): ?>
                    <div class="invalid-feedback"><?= e($errors['full_name']) ?></div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Phone -->
              <div class="col-md-6">
                <label for="phone" class="form-label fw-semibold small text-muted">
                  <?= is_malayalam() ? 'മൊബൈൽ നമ്പർ' : 'Mobile Number' ?> <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light">+91</span>
                  <input type="tel" 
                         class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" 
                         id="phone" 
                         name="phone" 
                         value="<?= e($old['phone'] ?? '') ?>" 
                         placeholder="10-digit Mobile No." 
                         maxlength="10" 
                         required>
                  <?php if (isset($errors['phone'])): ?>
                    <div class="invalid-feedback"><?= e($errors['phone']) ?></div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <label for="email" class="form-label fw-semibold small text-muted">
                  <?= is_malayalam() ? 'ഇമെയിൽ വിലാസം' : 'Email Address' ?> <span class="text-muted">(Optional)</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                  <input type="email" 
                         class="form-control" 
                         id="email" 
                         name="email" 
                         value="<?= e($old['email'] ?? '') ?>" 
                         placeholder="name@example.com">
                </div>
              </div>

              <!-- Member Number -->
              <div class="col-md-6">
                <label for="member_number" class="form-label fw-semibold small text-muted">
                  <?= is_malayalam() ? 'അംഗത്വ നമ്പർ (ഉണ്ടെങ്കിൽ)' : 'Membership Number (If Member)' ?>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="fa-solid fa-id-card text-muted"></i></span>
                  <input type="text" 
                         class="form-control" 
                         id="member_number" 
                         name="member_number" 
                         value="<?= e($old['member_number'] ?? '') ?>" 
                         placeholder="e.g. M-1042">
                </div>
              </div>

              <!-- Nearest Branch -->
              <div class="col-md-6">
                <label for="branch_id" class="form-label fw-semibold small text-muted">
                  <?= is_malayalam() ? 'സമീപമുള്ള ശാഖ' : 'Nearest Branch' ?> <span class="text-danger">*</span>
                </label>
                <select class="form-select <?= isset($errors['branch_id']) ? 'is-invalid' : '' ?>" id="branch_id" name="branch_id" required>
                  <option value=""><?= is_malayalam() ? '-- ശാഖ തിരഞ്ഞെടുക്കുക --' : '-- Select Branch --' ?></option>
                  <?php foreach ($branches as $b): ?>
                    <option value="<?= (int)$b['id'] ?>" <?= ((int)($old['branch_id'] ?? 0) === (int)$b['id']) ? 'selected' : '' ?>>
                      <?= is_malayalam() ? e($b['name_ml']) : e($b['name_en']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <?php if (isset($errors['branch_id'])): ?>
                  <div class="invalid-feedback"><?= e($errors['branch_id']) ?></div>
                <?php endif; ?>
              </div>

              <!-- Service Type -->
              <div class="col-md-6">
                <label for="request_type" class="form-label fw-semibold small text-muted">
                  <?= is_malayalam() ? 'ആവശ്യമുള്ള സേവനം' : 'Service Required' ?> <span class="text-danger">*</span>
                </label>
                <select class="form-select" id="request_type" name="request_type" required>
                  <option value="General Inquiry"><?= is_malayalam() ? 'പൊതുവായ അന്വേഷണം' : 'General Inquiry' ?></option>
                  <option value="Loan Enquiry"><?= __('Loan Enquiry (up to ₹10 Lakh)', 'വായ്പാ അന്വേഷണം (10 ലക്ഷം വരെ)') ?></option>
                  <option value="Deposit Enquiry"><?= __('Deposit Enquiry', 'നിക്ഷേപ അന്വേഷണം') ?></option>
                  <option value="Membership"><?= __('New Membership', 'പുതിയ അംഗത്വം') ?></option>
                  <option value="Member Services"><?= __('Medical Store / Stationery / Canteen / Janasevana Kendram', 'മെഡിക്കൽ സ്റ്റോർ / സ്റ്റേഷനറി / കാന്റീൻ / ജനസേവന കേന്ദ്രം') ?></option>
                </select>
              </div>

              <!-- Message / Requirement details -->
              <div class="col-12">
                <label for="message" class="form-label fw-semibold small text-muted">
                  <?= is_malayalam() ? 'കൂടുതൽ വിവരങ്ങൾ / ആവശ്യങ്ങൾ' : 'Additional Details / Requirements' ?>
                </label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="<?= is_malayalam() ? 'നിങ്ങളുടെ സാമ്പത്തിക ആവശ്യകതയെക്കുറിച്ചോ സംശയങ്ങളെക്കുറിച്ചോ ഇവിടെ വിശദീകരിക്കാം...' : 'Briefly describe your loan amount, deposit tenure, or specific requirement...' ?>"><?= e($old['message'] ?? '') ?></textarea>
              </div>

              <!-- DPDP Privacy Compliance Notice -->
              <div class="col-12">
                <div class="p-3 bg-light rounded border small text-muted">
                  <i class="fa-solid fa-shield-halved text-success me-1"></i>
                  <strong><?= is_malayalam() ? 'സ്വകാര്യതാ സുരക്ഷ' : 'Data Privacy Notice' ?>: </strong>
                  <?= is_malayalam() 
                      ? 'നിങ്ങൾ നൽകുന്ന വിവരങ്ങൾ അപേക്ഷാ പരിശോധനയ്ക്കും ഔദ്യോഗിക ബന്ധപ്പെടലുകൾക്കും മാത്രമേ ഉപയോഗിക്കൂ. ബാങ്ക് യാതൊരു കാരണവശാലും ഉപഭോക്തൃ വിവരങ്ങൾ മൂന്നാം കക്ഷികൾക്ക് കൈമാറില്ല.' 
                      : 'Under the Digital Personal Data Protection Act, your information is strictly utilized by authorized branch personnel to respond to your request. We never share customer data.' ?>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                  <i class="fa-solid fa-paper-plane me-2"></i>
                  <?= is_malayalam() ? 'അപേക്ഷ സമർപ്പിക്കുക' : 'Submit Application' ?>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Right Column: Tracking Tool & Direct Support -->
    <div class="col-lg-4">
      <!-- Tracker Box -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white py-3">
          <h5 class="mb-0 fw-bold">
            <i class="fa-solid fa-magnifying-glass me-2 text-warning"></i>
            <?= is_malayalam() ? 'അപേക്ഷ പരിശോധിക്കുക' : 'Track Application Status' ?>
          </h5>
        </div>
        <div class="card-body p-4">
          <p class="small text-muted mb-3">
            <?= is_malayalam() 
                ? 'നിങ്ങൾക്ക് ലഭിച്ച റഫറൻസ് കോഡ് നൽകി അപേക്ഷയുടെ നില പരിശോധിക്കാം:' 
                : 'Enter your application reference code to view the live progress of your request:' ?>
          </p>

          <form action="<?= url('/service-request') ?>" method="GET" class="mb-3">
            <div class="input-group">
              <input type="text" 
                     name="track" 
                     class="form-control" 
                     placeholder="e.g. SR-KAL-261003-1234" 
                     value="<?= e($tracking_code) ?>" 
                     required>
              <button class="btn btn-primary" type="submit">
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </form>

          <?php if ($tracked_request): ?>
            <div class="p-3 bg-light rounded border mt-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small text-muted"><?= is_malayalam() ? 'അവസ്ഥ' : 'Status' ?>:</span>
                <span class="badge bg-<?= $tracked_request['status'] === 'completed' ? 'success' : ($tracked_request['status'] === 'in_progress' ? 'info' : 'warning') ?> text-dark text-uppercase">
                  <?= e($tracked_request['status']) ?>
                </span>
              </div>
              <div class="small mb-1">
                <strong><?= is_malayalam() ? 'സേവനം' : 'Service' ?>:</strong> <?= e($tracked_request['request_type']) ?>
              </div>
              <div class="small mb-1">
                <strong><?= is_malayalam() ? 'ശാഖ' : 'Branch' ?>:</strong> <?= is_malayalam() ? e($tracked_request['branch_name_ml'] ?? 'ഹെഡ് ഓഫീസ്') : e($tracked_request['branch_name_en'] ?? 'Head Office') ?>
              </div>
              <div class="small mb-2">
                <strong><?= is_malayalam() ? 'തീയതി' : 'Submitted' ?>:</strong> <?= date('d M Y, h:i A', strtotime($tracked_request['created_at'])) ?>
              </div>
              <?php if (!empty($tracked_request['branch_phone'])): ?>
                <div class="small pt-2 border-top">
                  <i class="fa-solid fa-phone text-primary me-1"></i>
                  <?= is_malayalam() ? 'ശാഖാ ഫോൺ' : 'Branch Phone' ?>: <a href="tel:<?= e($tracked_request['branch_phone']) ?>"><?= e($tracked_request['branch_phone']) ?></a>
                </div>
              <?php endif; ?>
            </div>
          <?php elseif ($tracking_code !== ''): ?>
            <div class="alert alert-warning small mb-0">
              <i class="fa-solid fa-circle-exclamation me-1"></i>
              <?= is_malayalam() ? 'ഈ റഫറൻസ് കോഡിൽ അപേക്ഷ കണ്ടെത്താനായില്ല. നമ്പർ പരിശോധിച്ച് വീണ്ടും ശ്രമിക്കുക.' : 'No application found with this reference code. Please verify and try again.' ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Quick Contact Box -->
      <div class="card border-0 shadow-sm bg-primary text-white">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-3">
            <i class="fa-solid fa-headset me-2"></i>
            <?= is_malayalam() ? 'സഹായം വേണോ?' : 'Need Instant Assistance?' ?>
          </h5>
          <p class="small text-white opacity-75 mb-3">
            <?= is_malayalam() 
                ? 'നിങ്ങൾക്ക് നേരിട്ട് വിളിച്ച് അന്വേഷിക്കാനോ അടുത്തുള്ള ശാഖ സന്ദർശിക്കാനോ സാധിക്കും.' 
                : 'Our customer support team is available during working hours to answer your questions.' ?>
          </p>
          <?php if (!empty(setting('contact.primary_phone'))): ?>
            <div class="d-flex align-items-center mb-3">
              <i class="fa-solid fa-phone-volume fs-4 text-warning me-3"></i>
              <div>
                <div class="small text-white opacity-75"><?= is_malayalam() ? 'സഹായവാണി' : 'Helpline' ?></div>
                <div class="fs-5 fw-bold"><a href="tel:<?= e(setting('contact.primary_phone')) ?>" class="text-white text-decoration-none"><?= e(setting('contact.primary_phone')) ?></a></div>
              </div>
            </div>
          <?php endif; ?>
          <a href="<?= url('/branches') ?>" class="btn btn-light btn-sm text-primary fw-bold w-100">
            <i class="fa-solid fa-building-columns me-1"></i>
            <?= __('nav_branches') ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
