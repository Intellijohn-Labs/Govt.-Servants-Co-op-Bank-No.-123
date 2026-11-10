<?php
// Home page template
$lakhs = __('Lakhs', 'ലക്ഷം');
$loanSlabs = array_slice($loan_rates ?? [], 0, 3);
$minLoanRate = !empty($loanSlabs) ? min(array_map(fn($r) => (float)$r['general_rate'], $loanSlabs)) : null;
$loanEffective = !empty($loanSlabs) ? $loanSlabs[0]['effective_from'] : null;
?>

<!-- 1. Hero Section -->
<section class="hero-section text-white">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <div class="d-flex flex-wrap gap-2 mb-4">
          <span class="trust-chip"><i class="fa-solid fa-certificate" aria-hidden="true"></i> <?= __('Class 1 Bank', 'Class 1 ബാങ്ക്') ?></span>
          <span class="trust-chip"><i class="fa-solid fa-landmark" aria-hidden="true"></i> <?= __('100 Years of Service Legacy', '100 വർഷത്തെ പാരമ്പര്യം') ?></span>
        </div>
        <h1 class="hero-title">
          <?= is_malayalam() ? e($banner['title_ml'] ?? __('hero_title')) : e($banner['title_en'] ?? __('hero_title')) ?>
        </h1>
        <p class="hero-subtitle">
          <?= is_malayalam() ? e($banner['subtitle_ml'] ?? __('hero_subtitle')) : e($banner['subtitle_en'] ?? __('hero_subtitle')) ?>
        </p>

        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="<?= url('/interest-rates') ?>" class="btn btn-hero-primary btn-lg">
            <i class="fa-solid fa-percent me-2" aria-hidden="true"></i> <?= __('Interest Rates', 'പലിശ നിരക്കുകൾ') ?>
          </a>
          <a href="<?= url('/welfare') ?>" class="btn btn-hero-ghost btn-lg">
            <i class="fa-solid fa-store me-2" aria-hidden="true"></i> <?= __('View Services', 'സേവനങ്ങൾ കാണുക') ?>
          </a>
        </div>
      </div>

      <!-- Quick EMI widget -->
      <div class="col-lg-5">
        <div class="card hero-card border-0 text-dark bg-white p-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h5 fw-bold mb-0 text-primary">
              <i class="fa-solid fa-calculator me-1" aria-hidden="true"></i> <?= __('calculate_emi') ?>
            </h2>
            <span class="badge bg-light text-muted border"><?= __('Indicative', 'ഏകദേശ കണക്ക്') ?></span>
          </div>

          <div class="mb-3">
            <label for="quickEmiAmount" class="form-label small fw-semibold text-muted d-flex justify-content-between">
              <span><?= __('Loan Amount', 'വായ്പാ തുക') ?></span>
              <span id="quickEmiAmountLabel" class="fw-bold text-primary">₹ 5,00,000</span>
            </label>
            <input type="range" class="form-range" id="quickEmiAmount" min="50000" max="1000000" step="25000" value="500000" oninput="document.getElementById('quickEmiAmountLabel').textContent = '₹ ' + parseInt(this.value).toLocaleString('en-IN')">
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label for="quickEmiRate" class="form-label small fw-semibold text-muted"><?= __('Interest Rate (% p.a.)', 'പലിശ നിരക്ക്') ?></label>
              <input type="number" class="form-control" id="quickEmiRate" value="<?= e($minLoanRate !== null ? number_format($minLoanRate, 2, '.', '') : '9.50') ?>" step="0.25" min="5" max="20">
            </div>
            <div class="col-6">
              <label for="quickEmiTenure" class="form-label small fw-semibold text-muted"><?= __('Tenure (Months)', 'കാലാവധി (മാസം)') ?></label>
              <input type="number" class="form-control" id="quickEmiTenure" value="60" min="6" max="180">
            </div>
          </div>

          <div class="bg-light p-3 rounded-4 mb-3 d-flex align-items-center justify-content-between border">
            <div>
              <div class="text-muted small"><?= __('Monthly EMI', 'പ്രതിമാസ ഗഡു') ?></div>
              <div class="fs-4 fw-bold text-success" id="quickEmiResult" aria-live="polite">₹ 10,501</div>
            </div>
            <div class="text-end">
              <div class="text-muted small"><?= __('Total Interest', 'ആകെ പലിശ') ?></div>
              <div class="fw-bold text-secondary" id="quickEmiTotalInterest">₹ 1,30,056</div>
            </div>
          </div>

          <a href="<?= url('/service-request') ?>" class="btn btn-primary w-100 fw-bold">
            <?= __('Apply for Loan', 'വായ്പയ്ക്ക് അപേക്ഷിക്കുക') ?> <i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 2. Key figures -->
<?php if (!empty($achievements)): ?>
<section class="metrics-strip" aria-label="<?= __('Key financial figures', 'പ്രധാന സാമ്പത്തിക വിവരങ്ങൾ') ?>">
  <div class="container">
    <div class="row g-3">
      <?php foreach ($achievements as $ach): ?>
        <div class="col-6 col-lg-3">
          <div class="metric-card">
            <div class="d-flex align-items-center justify-content-between">
              <span class="metric-label"><?= is_malayalam() ? e(preg_replace('/\s*\(.*\)/u', '', $ach['title_ml'])) : e(preg_replace('/\s*\(.*\)/u', '', $ach['title_en'])) ?></span>
              <span class="metric-icon"><i class="fa-solid <?= e($ach['icon'] ?: 'fa-chart-line') ?>" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">₹ <?= e($ach['count_value']) ?><small><?= e($ach['suffix'] ?? '') ?></small></div>
            <div class="metric-foot"><?= __('in ₹ Lakhs', 'ലക്ഷം രൂപയിൽ') ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- 3. Featured: 3-tier loan scheme + government employee rebate -->
<section class="py-5 mt-lg-4" aria-labelledby="featured-title">
  <div class="container">
    <div class="text-center mb-4 mb-lg-5">
      <span class="section-eyebrow"><i class="fa-solid fa-star"></i> <?= __('Featured', 'പ്രത്യേക ആനുകൂല്യങ്ങൾ') ?></span>
      <h2 id="featured-title" class="section-title text-balance"><?= __('Affordable Loans for Our Members', 'അംഗങ്ങൾക്ക് മിതമായ നിരക്കിൽ വായ്പകൾ') ?></h2>
    </div>

    <div class="row g-4 align-items-stretch">
      <!-- Loan tiers -->
      <div class="col-lg-6">
        <div class="table-card h-100 d-flex flex-column">
          <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
            <div>
              <div class="metric-label mb-1"><?= __('Loan Interest Rates', 'വായ്പാ പലിശ നിരക്കുകൾ') ?></div>
              <?php if ($minLoanRate !== null): ?>
                <div class="d-flex align-items-baseline gap-2 flex-wrap">
                  <span class="text-muted"><?= __('from', 'ആരംഭ നിരക്ക്') ?></span>
                  <span class="rate-pill fs-4"><?= number_format($minLoanRate, 1) ?>% <small>p.a.</small></span>
                </div>
              <?php endif; ?>
            </div>
            <span class="metric-icon"><i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i></span>
          </div>

          <?php if (!empty($loanSlabs)): ?>
            <ul class="list-unstyled mb-3">
              <?php foreach ($loanSlabs as $slab): ?>
                <li class="d-flex align-items-center justify-content-between gap-3 py-3 border-top">
                  <div>
                    <?php $sb = is_malayalam() ? ($slab['notes_ml'] ?? '') : ($slab['notes_en'] ?? ''); $sl = is_malayalam() ? $slab['tenure_label_ml'] : $slab['tenure_label_en']; ?>
                    <span class="slab-badge"><?= e($sb) ?></span>
                    <?php if ($sl !== $sb): ?><span class="small text-muted d-block d-sm-inline mt-1 mt-sm-0"><?= e($sl) ?></span><?php endif; ?>
                  </div>
                  <span class="rate-pill"><?= number_format((float)$slab['general_rate'], 2) ?>% <small>p.a.</small></span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <div class="mt-auto d-flex flex-wrap align-items-center justify-content-between gap-2">
            <?php if ($loanEffective): ?>
              <span class="small text-muted"><i class="fa-regular fa-calendar me-1"></i> <?= __('Effective from', 'പ്രാബല്യ തീയതി') ?> <?= e(format_date($loanEffective)) ?></span>
            <?php endif; ?>
            <a href="<?= url('/interest-rates') ?>#loan-rates" class="btn btn-primary btn-sm px-3"><?= __('Full rate schedule', 'പൂർണ്ണ നിരക്കുകൾ') ?> <i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>

      <!-- Government employee rebate (premium card) -->
      <div class="col-lg-6">
        <div class="benefit-card h-100 p-4 p-lg-5 d-flex flex-column justify-content-between">
          <div class="position-relative">
            <span class="benefit-badge mb-3"><i class="fa-solid fa-user-shield" aria-hidden="true"></i> <?= __('For Government Employee Members', 'അംഗങ്ങളായ സർക്കാർ ജീവനക്കാർക്ക്') ?></span>
            <div class="d-flex align-items-end gap-3 flex-wrap">
              <div class="benefit-figure">10<sup>%</sup></div>
              <div class="pb-2">
                <h3 class="h4 fw-bold mb-1"><?= __('Interest Rebate', 'പലിശ റിബേറ്റ്') ?></h3>
                <div class="small opacity-75"><?= __('on interest paid', 'അടച്ച പലിശയുടെ') ?></div>
              </div>
            </div>
            <p class="mt-3 mb-0 opacity-90">
              <?= is_malayalam()
                ? 'അംഗങ്ങളായ സർക്കാർ ജീവനക്കാർക്ക് മിതമായ പലിശനിരക്കിൽ വായ്പാ സൗകര്യങ്ങൾ; തവണകൾ തെറ്റാതെ തിരിച്ചടക്കുന്ന വായ്പകൾക്ക് അടച്ച പലിശയുടെ 10% റിബേറ്റ്.'
                : 'Loan facilities at moderate interest rates for government employee members, with a 10% rebate on interest paid for loans repaid on time without missing instalments.' ?>
            </p>
            <ul class="benefit-points">
              <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> <?= __('Moderate interest rates', 'മിതമായ പലിശനിരക്ക്') ?></li>
              <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> <?= __('Rebate for instalments paid on time', 'തവണകൾ തെറ്റാതെ അടയ്ക്കുന്നവർക്ക് റിബേറ്റ്') ?></li>
              <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> <?= __('Class 1 Bank · 100 years of service', 'Class 1 ബാങ്ക് · 100 വർഷത്തെ സേവനം') ?></li>
            </ul>
          </div>
          <a href="<?= url('/service-request') ?>" class="btn btn-hero-primary align-self-start mt-4">
            <?= __('Enquire now', 'അന്വേഷിക്കുക') ?> <i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 4. Interest rate tabs (Deposits & Loans) -->
<section class="py-5 bg-white border-top border-bottom" aria-labelledby="rates-title">
  <div class="container">
    <div class="text-center mb-4">
      <span class="section-eyebrow"><i class="fa-solid fa-percent"></i> <?= __('Rates', 'നിരക്കുകൾ') ?></span>
      <h2 id="rates-title" class="section-title"><?= __('rates_panel_title') ?></h2>
    </div>

    <div class="rates-card max-w-900 mx-auto bg-white">
      <ul class="nav rates-tabs nav-fill" id="ratePanelTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="loan-rates-tab" data-bs-toggle="tab" data-bs-target="#loan-rates-content" type="button" role="tab" aria-controls="loan-rates-content" aria-selected="true">
            <i class="fa-solid fa-hand-holding-dollar me-2" aria-hidden="true"></i> <?= __('rates_loan_tab') ?>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="deposit-rates-tab" data-bs-toggle="tab" data-bs-target="#deposit-rates-content" type="button" role="tab" aria-controls="deposit-rates-content" aria-selected="false">
            <i class="fa-solid fa-piggy-bank me-2" aria-hidden="true"></i> <?= __('rates_deposit_tab') ?>
          </button>
        </li>
      </ul>

      <div class="tab-content p-3 p-md-4">
        <div class="tab-pane fade show active" id="loan-rates-content" role="tabpanel" aria-labelledby="loan-rates-tab" tabindex="0">
          <div class="table-responsive">
            <table class="table rates-table align-middle">
              <caption class="visually-hidden"><?= __('Loan interest rates', 'വായ്പാ പലിശ നിരക്കുകൾ') ?></caption>
              <thead>
                <tr>
                  <th scope="col"><?= __('Loan Slab', 'വായ്പാ തുക') ?></th>
                  <th scope="col" class="text-center"><?= __('Interest Rate', 'പലിശ നിരക്ക്') ?></th>
                  <th scope="col" class="text-end d-none d-sm-table-cell"><?= __('effective_from') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($loan_rates)): ?>
                  <?php foreach ($loan_rates as $lRate): ?>
                    <tr>
                      <td>
                        <?php $sb = is_malayalam() ? ($lRate['notes_ml'] ?? '') : ($lRate['notes_en'] ?? ''); $sl = is_malayalam() ? $lRate['tenure_label_ml'] : $lRate['tenure_label_en']; ?>
                        <?php if (!empty($sb)): ?><span class="slab-badge"><?= e($sb) ?></span><?php endif; ?>
                        <?php if ($sl !== $sb): ?><span class="fw-semibold"><?= e($sl) ?></span><?php endif; ?>
                      </td>
                      <td class="text-center"><span class="rate-pill"><?= number_format((float)$lRate['general_rate'], 2) ?>% <small>p.a.</small></span></td>
                      <td class="text-end text-muted small d-none d-sm-table-cell"><?= format_date($lRate['effective_from']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="3"><div class="empty-state"><i class="fa-regular fa-clock d-block"></i><?= __('Rates will be published soon.', 'നിരക്കുകൾ ഉടൻ ലഭ്യമാകും.') ?></div></td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="tab-pane fade" id="deposit-rates-content" role="tabpanel" aria-labelledby="deposit-rates-tab" tabindex="0">
          <?php if (!empty($deposit_rates)): ?>
            <div class="table-responsive">
              <table class="table rates-table align-middle">
                <caption class="visually-hidden"><?= __('Deposit interest rates', 'നിക്ഷേപ പലിശ നിരക്കുകൾ') ?></caption>
                <thead>
                  <tr>
                    <th scope="col"><?= __('tenure') ?></th>
                    <th scope="col" class="text-center"><?= __('general_public') ?></th>
                    <th scope="col" class="text-center"><?= __('senior_citizens') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($deposit_rates as $rate): ?>
                    <tr>
                      <td class="fw-semibold"><?= is_malayalam() ? e($rate['tenure_label_ml']) : e($rate['tenure_label_en']) ?></td>
                      <td class="text-center"><span class="rate-pill"><?= number_format((float)$rate['general_rate'], 2) ?>%</span></td>
                      <td class="text-center"><span class="rate-pill"><?= number_format((float)($rate['senior_rate'] ?? $rate['general_rate']), 2) ?>%</span></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="empty-state">
              <i class="fa-solid fa-piggy-bank d-block"></i>
              <div class="fw-semibold text-dark"><?= __('Attractive deposit schemes', 'ആകർഷകമായ നിക്ഷേപ പദ്ധതികൾ') ?></div>
              <div class="small"><?= __('Please contact your nearest branch for current deposit rates.', 'നിലവിലെ നിക്ഷേപ നിരക്കുകൾക്ക് അടുത്തുള്ള ശാഖയുമായി ബന്ധപ്പെടുക.') ?></div>
              <a href="<?= url('/contact') ?>" class="btn btn-outline-primary btn-sm mt-3"><?= __('nav_contact') ?></a>
            </div>
          <?php endif; ?>
        </div>

        <div class="rate-card-note mt-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
          <span><i class="fa-solid fa-circle-info text-primary me-1" aria-hidden="true"></i> <?= __('rates_disclaimer') ?></span>
          <a href="<?= url('/interest-rates') ?>" class="fw-bold text-decoration-none"><?= __('view_full_rates') ?> <i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Intro video -->
<section id="video" class="py-5" aria-labelledby="video-title">
  <div class="container">
    <div class="text-center mb-4">
      <span class="section-eyebrow"><i class="fa-solid fa-circle-play"></i> <?= __('Watch Our Story', 'ഞങ്ങളുടെ കഥ കാണാം') ?></span>
      <h2 id="video-title" class="section-title"><?= __('Get to Know Us', 'ഞങ്ങളെ അറിയുക') ?></h2>
      <p class="section-lead mb-0"><?= __('See our century of service in this short film.', 'ഒരു നൂറ്റാണ്ടിന്റെ സേവനത്തിന്റെ കഥ വീഡിയോയിലൂടെ കാണാം.') ?></p>
    </div>
    <div class="video-frame">
      <video controls playsinline preload="none" poster="<?= asset('assets/videos/bank-poster.jpg') ?>">
        <source src="<?= asset('assets/videos/bank-intro.mp4') ?>" type="video/mp4">
        <?= __('Your browser does not support video playback.', 'നിങ്ങളുടെ ബ്രൗസർ വീഡിയോ പ്ലേബാക്ക് പിന്തുണയ്ക്കുന്നില്ല.') ?>
      </video>
    </div>
  </div>
</section>

<!-- 5. Member services (5 services) -->
<section class="py-5">
  <div class="container">
    <?= $this->partial('member_services', ['showHeading' => true, 'showCta' => true]) ?>
  </div>
</section>

<!-- 6. Chairperson message (shown only when authentic content is published) -->
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
          <div class="col-md-9 ps-md-4">
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

<!-- 7. Visit us -->
<section class="py-5 bg-white border-top">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-6">
        <span class="section-eyebrow"><i class="fa-solid fa-location-dot"></i> <?= __('Visit Us', 'സന്ദർശിക്കുക') ?></span>
        <h2 class="section-title"><?= __('We are here to help', 'ഞങ്ങൾ സഹായിക്കാൻ ഇവിടെയുണ്ട്') ?></h2>
        <p class="text-muted"><?= __('Visit the Head Office or call our helpline to know more about loans, deposits and member services.', 'വായ്പകൾ, നിക്ഷേപങ്ങൾ, സേവനങ്ങൾ എന്നിവയെക്കുറിച്ച് അറിയാൻ ഹെഡ് ഓഫീസ് സന്ദർശിക്കുകയോ ഹെൽപ്പ്‌ലൈനിൽ വിളിക്കുകയോ ചെയ്യുക.') ?></p>
        <div class="d-flex flex-wrap gap-2">
          <a href="<?= url('/contact') ?>" class="btn btn-primary px-4"><i class="fa-solid fa-envelope me-2" aria-hidden="true"></i><?= __('nav_contact') ?></a>
          <a href="<?= url('/branches') ?>" class="btn btn-outline-primary px-4"><i class="fa-solid fa-location-arrow me-2" aria-hidden="true"></i><?= __('locate_branch') ?></a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="table-card py-2">
          <div class="info-tile">
            <span class="metric-icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
            <div>
              <div class="metric-label"><?= __('Head Office', 'ഹെഡ് ഓഫീസ്') ?></div>
              <div><?= is_malayalam() ? e(setting('contact.head_office_address_ml')) : e(setting('contact.head_office_address_en')) ?></div>
            </div>
          </div>
          <?php if (!empty(setting('contact.primary_phone'))): ?>
            <div class="info-tile">
              <span class="metric-icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></span>
              <div>
                <div class="metric-label"><?= __('Phone', 'ഫോൺ') ?></div>
                <a class="text-decoration-none fw-semibold" href="tel:<?= e(preg_replace('/\s+/', '', setting('contact.primary_phone'))) ?>"><?= e(setting('contact.primary_phone')) ?></a>
              </div>
            </div>
          <?php endif; ?>
          <?php $hrs = is_malayalam() ? setting('contact.working_hours_ml') : setting('contact.working_hours_en'); ?>
          <?php if (!empty($hrs)): ?>
            <div class="info-tile">
              <span class="metric-icon"><i class="fa-solid fa-clock" aria-hidden="true"></i></span>
              <div>
                <div class="metric-label"><?= __('Working Hours', 'പ്രവർത്തന സമയം') ?></div>
                <div><?= e($hrs) ?></div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
