<?php
// Home page template
$isBank = (setting('legal.entity_type') === 'licensed_bank');
?>

<!-- 1. Hero Section -->
<section class="hero-section text-white py-5">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <span class="badge bg-warning text-dark px-3 py-2 fw-bold text-uppercase mb-3">
          <i class="fa-solid fa-award me-1"></i> <?= __('Class 1 Bank', 'ക്ലാസ്സ് 1 ബാങ്ക്') ?>
        </span>
        <h1 class="hero-title fw-bold">
          <?= is_malayalam() ? e($banner['title_ml'] ?? __('hero_title')) : e($banner['title_en'] ?? __('hero_title')) ?>
        </h1>
        <p class="hero-subtitle lead opacity-90">
          <?= is_malayalam() ? e($banner['subtitle_ml'] ?? __('hero_subtitle')) : e($banner['subtitle_en'] ?? __('hero_subtitle')) ?>
        </p>

        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="<?= url('/services') ?>" class="btn btn-warning btn-lg text-dark fw-bold px-4 shadow">
            <i class="fa-solid fa-hand-holding-dollar me-2"></i> <?= __('explore_loans') ?>
          </a>
          <a href="<?= url('/service-request') ?>" class="btn btn-outline-light btn-lg fw-bold px-4">
            <i class="fa-solid fa-file-signature me-2"></i> <?= __('open_account') ?>
          </a>
        </div>
      </div>

      <!-- Quick EMI Teaser Widget in Hero -->
      <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-4 text-dark bg-white p-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0 text-primary">
              <i class="fa-solid fa-calculator me-1"></i> <?= __('calculate_emi') ?>
            </h5>
            <span class="badge bg-light text-muted border small"><?= __('Reducing Balance', 'കുറയുന്ന നിരക്കിൽ') ?></span>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-muted d-flex justify-content-between">
              <span><?= __('Loan Amount', 'വായ്പാ തുക') ?></span>
              <span id="quickEmiAmountLabel" class="fw-bold text-primary">₹ 5,00,000</span>
            </label>
            <input type="range" class="form-range" id="quickEmiAmount" min="50000" max="2500000" step="25000" value="500000" oninput="document.getElementById('quickEmiAmountLabel').textContent = '₹ ' + parseInt(this.value).toLocaleString('en-IN')">
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-semibold text-muted"><?= __('Interest Rate (% p.a.)', 'പലിശ നിരക്ക്') ?></label>
              <input type="number" class="form-control" id="quickEmiRate" value="9.25" step="0.25" min="5" max="20">
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-muted"><?= __('Tenure (Months)', 'കാലാവധി (മാസം)') ?></label>
              <input type="number" class="form-control" id="quickEmiTenure" value="60" min="6" max="180">
            </div>
          </div>

          <div class="bg-light p-3 rounded-3 mb-3 d-flex align-items-center justify-content-between border">
            <div>
              <div class="text-muted small"><?= __('Monthly EMI', 'പ്രതിമാസ ഗഡു') ?></div>
              <div class="fs-4 fw-bold text-success" id="quickEmiResult">₹ 10,442</div>
            </div>
            <div class="text-end">
              <div class="text-muted small"><?= __('Total Interest', 'ആകെ പലിശ') ?></div>
              <div class="fw-bold text-secondary" id="quickEmiTotalInterest">₹ 1,26,499</div>
            </div>
          </div>

          <a href="<?= url('/service-request') ?>?scheme=loan" class="btn btn-primary w-100 fw-bold">
            <i class="fa-solid fa-arrow-right me-1"></i> <?= __('Apply for Loan', 'വായ്പയ്ക്ക് അപേക്ഷിക്കുക') ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Member Benefit & Recognition Highlights -->
<section class="py-4 bg-warning-subtle border-bottom" aria-labelledby="member-benefit-title">
  <div class="container">
    <div class="d-flex align-items-start gap-3">
      <div class="rounded-circle bg-warning text-dark d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width:56px;height:56px;">
        <i class="fa-solid fa-percent fa-lg" aria-hidden="true"></i>
      </div>
      <div>
        <h2 id="member-benefit-title" class="h5 fw-bold mb-1">
          <?= __('Special Benefit for Government Employee Members', 'അംഗങ്ങളായ സർക്കാർ ജീവനക്കാർക്ക് പ്രത്യേക ആനുകൂല്യം') ?>
        </h2>
        <p class="mb-2">
          <?= is_malayalam()
            ? 'അംഗങ്ങളായ സർക്കാർ ജീവനക്കാർക്ക് മിതമായ പലിശനിരക്കിൽ വായ്പാ സൗകര്യങ്ങൾ; തവണകൾ തെറ്റാതെ തിരിച്ചടക്കുന്ന വായ്പകൾക്ക് അടച്ച പലിശയുടെ 10% റിബേറ്റ്.'
            : 'Loan facilities at moderate interest rates for government employee members, with a 10% rebate on interest paid for loans repaid on time without missing instalments.' ?>
        </p>
        <p class="mb-3 fw-semibold">
          <i class="fa-solid fa-piggy-bank text-success me-1" aria-hidden="true"></i>
          <?= __('Attractive deposit schemes', 'ആകർഷകമായ നിക്ഷേപ പദ്ധതികൾ') ?>
        </p>
        <div class="d-flex flex-wrap gap-2">
          <span class="badge bg-white text-dark border px-3 py-2"><i class="fa-solid fa-landmark text-primary me-1" aria-hidden="true"></i> <?= __('100 Years of Service Legacy', '100 വർഷങ്ങളുടെ സേവനപാരമ്പര്യം') ?></span>
          <span class="badge bg-white text-dark border px-3 py-2"><i class="fa-solid fa-certificate text-warning me-1" aria-hidden="true"></i> <?= __('Class 1 Bank', 'Class 1 ബാങ്ക്') ?></span>
          <span class="badge bg-white text-dark border px-3 py-2"><i class="fa-solid fa-trophy text-warning me-1" aria-hidden="true"></i> <?= __('Best Employees Society – Taluk level, consecutively', 'മികച്ച എംപ്ലോയീസ് സംഘം (താലൂക്ക് തലത്തിൽ തുടർച്ചയായി)') ?></span>
          <span class="badge bg-white text-dark border px-3 py-2"><i class="fa-solid fa-medal text-warning me-1" aria-hidden="true"></i> <?= __('District-level 1st & 2nd places since 2020-21', '2020-21 മുതൽ ജില്ലാതലത്തിൽ ഒന്നും രണ്ടും സ്ഥാനങ്ങൾ') ?></span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 2. "Why Us" Achievements & Stats Counters -->
<section class="py-5 bg-white border-bottom">
  <div class="container">
    <div class="row g-4">
      <?php if (!empty($achievements)): ?>
        <?php foreach ($achievements as $ach): ?>
          <div class="col-6 col-md-3">
            <div class="stat-box text-center p-3 h-100">
              <div class="text-primary mb-2 fs-3"><i class="fa-solid <?= e($ach['icon'] ?? 'fa-award') ?>"></i></div>
              <div class="stat-number"><?= e($ach['count_value']) ?><?= e($ach['suffix'] ?? '') ?></div>
              <div class="text-muted small fw-bold text-uppercase"><?= is_malayalam() ? e($ach['title_ml']) : e($ach['title_en']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-6 col-md-3">
          <div class="stat-box text-center p-3">
            <div class="stat-number">Class A</div>
            <div class="text-muted small fw-bold">Audit Classification</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-box text-center p-3">
            <div class="stat-number">45,000+</div>
            <div class="text-muted small fw-bold">Active Members</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-box text-center p-3">
            <div class="stat-number">14+</div>
            <div class="text-muted small fw-bold">Branches & Depots</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-box text-center p-3">
            <div class="stat-number">₹ 450 Cr+</div>
            <div class="text-muted small fw-bold">Working Capital</div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- 3. Tabbed Interest Rates Panel (Deposits & Loans) -->
<section class="py-5" style="background-color: rgba(10, 77, 146, 0.02);">
  <div class="container">
    <div class="text-center max-w-700 mx-auto mb-4">
      <h2 class="fw-bold mb-2"><?= __('rates_panel_title') ?></h2>
      <p class="text-muted"><?= __('rates_panel_subtitle') ?></p>
    </div>

    <div class="rates-card max-w-900 mx-auto shadow-sm">
      <ul class="nav nav-tabs rates-tabs nav-fill" id="ratePanelTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="deposit-rates-tab" data-bs-toggle="tab" data-bs-target="#deposit-rates-content" type="button" role="tab" aria-controls="deposit-rates-content" aria-selected="true">
            <i class="fa-solid fa-piggy-bank me-2"></i> <?= __('rates_deposit_tab') ?>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="loan-rates-tab" data-bs-toggle="tab" data-bs-target="#loan-rates-content" type="button" role="tab" aria-controls="loan-rates-content" aria-selected="false">
            <i class="fa-solid fa-hand-holding-dollar me-2"></i> <?= __('rates_loan_tab') ?>
          </button>
        </li>
      </ul>

      <div class="tab-content p-4" id="ratePanelTabsContent">
        <!-- Deposit Rates Tab -->
        <div class="tab-pane fade show active" id="deposit-rates-content" role="tabpanel" aria-labelledby="deposit-rates-tab">
          <div class="table-responsive">
            <table class="table rates-table align-middle">
              <thead>
                <tr>
                  <th><?= __('tenure') ?></th>
                  <th class="text-center"><?= __('general_public') ?> (% p.a.)</th>
                  <th class="text-center"><?= __('senior_citizens') ?> (% p.a.)</th>
                  <th class="text-end"><?= __('effective_from') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($deposit_rates)): ?>
                  <?php foreach ($deposit_rates as $rate): ?>
                    <tr>
                      <td class="fw-semibold"><?= is_malayalam() ? e($rate['tenure_label_ml']) : e($rate['tenure_label_en']) ?></td>
                      <td class="text-center"><span class="rate-badge fs-6"><?= number_format((float)$rate['general_rate'], 2) ?>%</span></td>
                      <td class="text-center"><span class="rate-badge fs-6 text-success bg-success-subtle"><?= number_format((float)($rate['senior_rate'] ?? $rate['general_rate']), 2) ?>%</span></td>
                      <td class="text-end text-muted small"><?= format_date($rate['effective_from']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="4" class="text-center py-3 text-muted">No deposit rates active currently.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3 pt-3 border-top">
            <div class="small text-muted fst-italic">
              <i class="fa-solid fa-circle-info me-1"></i> <?= __('rates_disclaimer') ?>
            </div>
            <a href="<?= url('/interest-rates') ?>" class="btn btn-outline-primary btn-sm fw-bold">
              <?= __('view_full_rates') ?> <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>

        <!-- Loan Rates Tab -->
        <div class="tab-pane fade" id="loan-rates-content" role="tabpanel" aria-labelledby="loan-rates-tab">
          <div class="table-responsive">
            <table class="table rates-table align-middle">
              <thead>
                <tr>
                  <th><?= __('Scheme / Loan Type', 'പദ്ധതി / വായ്പാ തരം') ?></th>
                  <th class="text-center"><?= __('Interest Rate', 'പലിശ നിരക്ക്') ?> (% p.a.)</th>
                  <th class="text-end"><?= __('effective_from') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($loan_rates)): ?>
                  <?php foreach ($loan_rates as $lRate): ?>
                    <tr>
                      <td class="fw-semibold"><?= is_malayalam() ? e($lRate['tenure_label_ml']) : e($lRate['tenure_label_en']) ?></td>
                      <td class="text-center"><span class="rate-badge fs-6 text-primary bg-primary-subtle"><?= number_format((float)$lRate['general_rate'], 2) ?>%</span></td>
                      <td class="text-end text-muted small"><?= format_date($lRate['effective_from']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="3" class="text-center py-3 text-muted">No loan rates active currently.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3 pt-3 border-top">
            <div class="small text-muted fst-italic">
              <i class="fa-solid fa-circle-info me-1"></i> <?= __('rates_disclaimer') ?>
            </div>
            <a href="<?= url('/interest-rates') ?>" class="btn btn-outline-primary btn-sm fw-bold">
              <?= __('view_full_rates') ?> <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 4. Services Grid (Loans, Deposits, Facilities) -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="text-center max-w-700 mx-auto mb-5">
      <h2 class="fw-bold mb-2"><?= __('services_title') ?></h2>
      <p class="text-muted"><?= __('services_subtitle') ?></p>
    </div>

    <div class="row g-4">
      <!-- Gold Loan Card -->
      <div class="col-md-4">
        <div class="feature-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="p-3 bg-warning bg-opacity-25 text-warning-emphasis rounded-3 fs-3">
              <i class="fa-solid fa-coins"></i>
            </div>
            <div>
              <span class="badge bg-warning text-dark small mb-1"><?= __('Instant Liquidity', 'ഉടനടി ലഭ്യമാക്കുന്നു') ?></span>
              <h5 class="fw-bold mb-0"><?= __('gold_loan') ?></h5>
            </div>
          </div>
          <p class="text-muted small mb-4"><?= __('gold_loan_desc') ?></p>
          <div class="border-top pt-3 d-flex justify-content-between align-items-center">
            <span class="fw-bold text-primary">8.50% p.a.</span>
            <a href="<?= url('/products/gold-loan') ?>" class="btn btn-sm btn-outline-primary fw-bold">
              <?= __('learn_more') ?> <i class="fa-solid fa-angle-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Fixed Deposit Card -->
      <div class="col-md-4">
        <div class="feature-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="p-3 bg-primary bg-opacity-25 text-primary rounded-3 fs-3">
              <i class="fa-solid fa-vault"></i>
            </div>
            <div>
              <span class="badge bg-success small mb-1"><?= __('High Yield', 'ഉയർന്ന റിട്ടേൺ') ?></span>
              <h5 class="fw-bold mb-0"><?= __('fixed_deposit') ?></h5>
            </div>
          </div>
          <p class="text-muted small mb-4"><?= __('fixed_deposit_desc') ?></p>
          <div class="border-top pt-3 d-flex justify-content-between align-items-center">
            <span class="fw-bold text-success">Up to 9.00%</span>
            <a href="<?= url('/products/fixed-deposit') ?>" class="btn btn-sm btn-outline-primary fw-bold">
              <?= __('learn_more') ?> <i class="fa-solid fa-angle-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Safe Lockers Card -->
      <div class="col-md-4">
        <div class="feature-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="p-3 bg-info bg-opacity-25 text-info-emphasis rounded-3 fs-3">
              <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
              <span class="badge bg-info text-dark small mb-1"><?= __('Security', 'സുരക്ഷിതത്വം') ?></span>
              <h5 class="fw-bold mb-0"><?= __('lockers') ?></h5>
            </div>
          </div>
          <p class="text-muted small mb-4"><?= __('lockers_desc') ?></p>
          <div class="border-top pt-3 d-flex justify-content-between align-items-center">
            <span class="fw-bold text-dark"><?= __('Available', 'ലഭ്യമാണ്') ?></span>
            <a href="<?= url('/services/lockers') ?>" class="btn btn-sm btn-outline-primary fw-bold">
              <?= __('learn_more') ?> <i class="fa-solid fa-angle-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 5. Chairperson / President Message -->
<?php if (!empty($chairperson)): ?>
  <section class="py-5 bg-light border-top border-bottom">
    <div class="container">
      <div class="message-card">
        <div class="row align-items-center g-4">
          <div class="col-md-3 text-center">
            <div class="portrait-frame mx-auto mb-3 bg-secondary d-flex align-items-center justify-content-center text-white fs-1">
              <i class="fa-solid fa-user-tie"></i>
            </div>
            <h5 class="fw-bold mb-1 text-primary"><?= is_malayalam() ? e($chairperson['name_ml']) : e($chairperson['name_en']) ?></h5>
            <div class="text-muted small fw-semibold"><?= is_malayalam() ? e($chairperson['designation_ml']) : e($chairperson['designation_en']) ?></div>
          </div>
          <div class="col-md-9 border-start-md ps-md-4">
            <span class="badge bg-primary text-white mb-2"><?= __('presidents_message_heading') ?></span>
            <blockquote class="lead fs-6 mb-3 fst-italic text-dark">
              &ldquo;<?= is_malayalam() ? nl2br(e($chairperson['message_ml'])) : nl2br(e($chairperson['message_en'])) ?>&rdquo;
            </blockquote>
            <a href="<?= url('/chairperson-message') ?>" class="btn btn-link text-primary fw-bold p-0 text-decoration-none">
              <?= __('read_more') ?> <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- 6. Branch Locator & 365 Days Banking Teaser -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <span class="badge bg-success px-3 py-2 fw-bold text-uppercase mb-2">
          <i class="fa-solid fa-map-location-dot me-1"></i> <?= __('Branch Network', 'ശാഖാ ശൃംഖല') ?>
        </span>
        <h2 class="fw-bold mb-3"><?= __('Find Your Nearest Branch & ATM', 'നിങ്ങളുടെ അടുത്തുള്ള ശാഖ കണ്ടെത്തുക') ?></h2>
        <p class="text-muted">
          <?= __('Visit our air-conditioned branches equipped with safe lockers, computerized gold loan counters, and evening banking facilities.', 'സേഫ് ലോക്കറുകളും സായാഹ്ന ബാങ്കിംഗ് സൗകര്യങ്ങളുമുള്ള ശാഖകൾ സന്ദർശിക്കുക.') ?>
        </p>

        <div class="card p-3 bg-light border mb-4">
          <div class="d-flex align-items-center gap-3">
            <div class="fs-1 text-warning"><i class="fa-solid fa-clock"></i></div>
            <div>
              <h6 class="fw-bold mb-1"><?= __('365 Days Evening Banking', '365 ദിവസവും സായാഹ്ന ബാങ്കിംഗ്') ?></h6>
              <div class="small text-muted"><?= __('Selected branches open up to 7:00 PM including Sundays and public holidays for your convenience.', 'ഞായറാഴ്ചകളിലും വൈകുന്നേരം 7:00 മണി വരെ തിരഞ്ഞെടുത്ത ശാഖകൾ പ്രവർത്തിക്കുന്നു.') ?></div>
            </div>
          </div>
        </div>

        <a href="<?= url('/branches') ?>" class="btn btn-primary fw-bold">
          <i class="fa-solid fa-location-arrow me-2"></i> <?= __('locate_branch') ?>
        </a>
      </div>

      <!-- Quick Branch List Preview -->
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
          <div class="card-header bg-primary text-white py-3 fw-bold d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-building me-2"></i> <?= __('Key Branches & Offices', 'പ്രധാന ശാഖകൾ') ?></span>
            <a href="<?= url('/branches') ?>" class="btn btn-sm btn-light text-primary fw-bold"><?= __('view_all') ?></a>
          </div>
          <div class="list-group list-group-flush">
            <?php if (!empty($branches)): ?>
              <?php foreach (array_slice($branches, 0, 3) as $br): ?>
                <div class="list-group-item p-3">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <h6 class="fw-bold mb-1"><?= is_malayalam() ? e($br['name_ml']) : e($br['name_en']) ?></h6>
                      <div class="small text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i> <?= is_malayalam() ? e($br['address_ml']) : e($br['address_en']) ?></div>
                      <div class="small text-muted mt-1"><i class="fa-solid fa-phone me-1 text-primary"></i> <a href="tel:<?= e($br['phone']) ?>" class="text-decoration-none text-muted"><?= e($br['phone']) ?></a></div>
                    </div>
                    <?php if (!empty($br['has_365_days'])): ?>
                      <span class="badge bg-warning text-dark small">365 Days</span>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 7. Mobile App Promotion Strip -->
<?php if (module_enabled('mobile_app_promo')): ?>
  <section class="py-5" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #FFFFFF;">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <h2 class="fw-bold mb-2 text-white"><?= __('app_promo_title') ?></h2>
          <p class="lead fs-6 text-white opacity-90 mb-4"><?= __('app_promo_subtitle') ?></p>
          <div class="d-flex flex-wrap gap-3">
            <?php if (!empty(setting('social.play_store'))): ?>
              <a href="<?= e(setting('social.play_store')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-dark btn-lg d-flex align-items-center gap-2">
                <i class="fa-brands fa-google-play fa-xl text-warning"></i>
                <div class="text-start">
                  <div class="small text-light opacity-75" style="font-size: 0.7rem; line-height: 1;">GET IT ON</div>
                  <div class="fw-bold">Google Play</div>
                </div>
              </a>
            <?php endif; ?>
            <?php if (!empty(setting('social.app_store'))): ?>
              <a href="<?= e(setting('social.app_store')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-dark btn-lg d-flex align-items-center gap-2">
                <i class="fa-brands fa-apple fa-xl"></i>
                <div class="text-start">
                  <div class="small text-light opacity-75" style="font-size: 0.7rem; line-height: 1;">DOWNLOAD ON THE</div>
                  <div class="fw-bold">App Store</div>
                </div>
              </a>
            <?php endif; ?>
          </div>
        </div>

        <div class="col-lg-4 text-center">
          <div class="p-3 bg-white text-dark rounded-4 shadow-lg d-inline-block">
            <i class="fa-solid fa-qrcode fa-5x text-primary mb-2"></i>
            <div class="small fw-bold text-muted"><?= __('Scan to Download App', 'ആപ്പ് ഡൗൺലോഡ് ചെയ്യാൻ സ്കാൻ ചെയ്യുക') ?></div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
