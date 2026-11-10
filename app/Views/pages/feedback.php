<?php
$crumbs = [
    ['title' => __('Customer Feedback', 'ഉപഭോക്തൃ അഭിപ്രായം'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        <div class="text-center mb-4">
          <span class="badge bg-primary text-white mb-2"><?= __('Service Quality', 'സേവന മികവ്') ?></span>
          <h2 class="fw-bold"><?= __('Member & Customer Feedback', 'നിങ്ങളുടെ അഭിപ്രായം രേഖപ്പെടുത്താം') ?></h2>
          <p class="text-muted small">
            <?= __('Your honest opinions help us continually enhance our banking standards and branch experiences.', 'നിങ്ങളുടെ വിലയേറിയ അഭിപ്രായങ്ങൾ മികച്ച സേവനം നൽകാൻ ഞങ്ങളെ സഹായിക്കുന്നു.') ?>
          </p>
        </div>

        <form action="<?= url('/feedback') ?>" method="POST">
          <?= csrf_field() ?>
          <div style="display: none !important;"><input type="text" name="website_hp" value=""></div>

          <div class="mb-4 text-center p-3 bg-light rounded-3 border">
            <label class="form-label fw-bold d-block mb-2"><?= __('Overall Satisfaction Rating', 'മൊത്തത്തിലുള്ള സംതൃപ്തി') ?></label>
            <div class="d-flex justify-content-center gap-3">
              <?php for ($i = 5; $i >= 1; $i--): ?>
                <div class="form-check form-check-inline m-0 text-center">
                  <input class="form-check-input d-block mx-auto mb-1" type="radio" name="rating" id="rating<?= $i ?>" value="<?= $i ?>" <?= $i === 5 ? 'checked' : '' ?>>
                  <label class="form-check-label small fw-bold" for="rating<?= $i ?>">
                    <?= $i ?> <i class="fa-solid fa-star text-warning"></i>
                  </label>
                </div>
              <?php endfor; ?>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold"><?= __('full_name') ?> <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold"><?= __('phone_number') ?></label>
              <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile number">
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold"><?= __('email_address') ?></label>
              <input type="email" name="email" class="form-control">
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
              <label class="form-label small fw-semibold"><?= __('Feedback Category', 'വിഭാഗം') ?></label>
              <select name="category" class="form-select">
                <option value="counter_service"><?= __('Counter / Cashier Service', 'കൗണ്ടർ സേവനം') ?></option>
                <option value="loan_processing"><?= __('Loan Appraisal & Sanctioning', 'വായ്പാ നടപടികൾ') ?></option>
                <option value="member_services"><?= __('Member Services (Medical Store, Canteen, Janasevana Kendram)', 'സേവനങ്ങൾ (മെഡിക്കൽ സ്റ്റോർ, കാന്റീൻ, ജനസേവന കേന്ദ്രം)') ?></option>
                <option value="staff_courtesy"><?= __('Staff Courtesy & Assistance', 'ജീവനക്കാരുടെ പെരുമാറ്റം') ?></option>
                <option value="other"><?= __('Other Suggestions', 'മറ്റ് നിർദ്ദേശങ്ങൾ') ?></option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold"><?= __('Your Detailed Feedback / Experience', 'നിങ്ങളുടെ അഭിപ്രായം') ?> <span class="text-danger">*</span></label>
              <textarea name="comments" rows="4" class="form-control" placeholder="<?= is_malayalam() ? 'നിങ്ങളുടെ അനുഭവം അല്ലെങ്കിൽ നിർദ്ദേശങ്ങൾ ഇവിടെ രേഖപ്പെടുത്തുക...' : 'Share your experience or suggestions...' ?>" required></textarea>
            </div>
            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                <i class="fa-solid fa-check me-2"></i> <?= __('Submit Customer Feedback', 'അഭിപ്രായം സമർപ്പിക്കുക') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
