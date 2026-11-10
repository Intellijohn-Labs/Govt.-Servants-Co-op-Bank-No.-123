<?php
$crumbs = [
    ['title' => __('nav_calculators'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-primary text-white mb-2"><?= __('Financial Planning Tools', 'സാമ്പത്തിക കാൽക്കുലേറ്ററുകൾ') ?></span>
    <h1 class="fw-bold mb-2"><?= __('nav_calculators') ?></h1>
    <p class="text-muted">
      <?= __('Estimate your monthly loan EMIs, deposit maturity returns, and gold loan advance eligibility using our transparent calculation tools.', 'നിങ്ങളുടെ വായ്പാ പ്രതിമാസ ഗഡുക്കളും നിക്ഷേപ വരുമാനവും മുൻകൂട്ടി കണക്കാക്കാം.') ?>
    </p>
  </div>

  <div class="row g-4">
    <!-- Calculator Tabs Navigation -->
    <div class="col-12">
      <ul class="nav nav-pills justify-content-center gap-2 mb-4" id="calcTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active fw-bold px-4 py-2" id="emi-calc-tab" data-bs-toggle="pill" data-bs-target="#emi-calc" type="button" role="tab" aria-selected="true">
            <i class="fa-solid fa-calculator me-2"></i> <?= __('Loan EMI Calculator', 'ഇ.എം.ഐ കാൽക്കുലേറ്റർ') ?>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fw-bold px-4 py-2" id="fd-calc-tab" data-bs-toggle="pill" data-bs-target="#fd-calc" type="button" role="tab" aria-selected="false">
            <i class="fa-solid fa-vault me-2"></i> <?= __('Deposit Maturity', 'നിക്ഷേപ മെച്യൂരിറ്റി') ?>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fw-bold px-4 py-2" id="gold-calc-tab" data-bs-toggle="pill" data-bs-target="#gold-calc" type="button" role="tab" aria-selected="false">
            <i class="fa-solid fa-coins me-2"></i> <?= __('Gold Loan Eligibility', 'സ്വർണ്ണ വായ്പാ പരിധി') ?>
          </button>
        </li>
      </ul>
    </div>

    <!-- Tab 1: Loan EMI Calculator -->
    <div class="col-12 tab-content" id="calcTabsContent">
      <div class="tab-pane fade show active" id="emi-calc" role="tabpanel" aria-labelledby="emi-calc-tab">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 max-w-900 mx-auto">
          <div class="row g-4 align-items-center">
            <div class="col-lg-7">
              <h4 class="fw-bold text-primary mb-4"><?= __('Loan EMI Estimator (Reducing Balance)', 'ഇ.എം.ഐ കണക്കാക്കാം') ?></h4>

              <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                  <label class="form-label small fw-semibold text-muted"><?= __('Loan Amount', 'വായ്പാ തുക') ?></label>
                  <span id="emiAmountDisplay" class="fw-bold text-primary fs-5">₹ 5,00,000</span>
                </div>
                <input type="range" class="form-range" id="emiAmountSlider" min="25000" max="5000000" step="25000" value="500000">
              </div>

              <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                  <label class="form-label small fw-semibold text-muted"><?= __('Interest Rate (% per annum)', 'പലിശ നിരക്ക്') ?></label>
                  <span id="emiRateDisplay" class="fw-bold text-primary fs-5">9.25 %</span>
                </div>
                <input type="range" class="form-range" id="emiRateSlider" min="6.0" max="18.0" step="0.25" value="9.25">
              </div>

              <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                  <label class="form-label small fw-semibold text-muted"><?= __('Tenure (Months)', 'കാലാവധി (മാസം)') ?></label>
                  <span id="emiTenureDisplay" class="fw-bold text-primary fs-5">60 Months (5 Yrs)</span>
                </div>
                <input type="range" class="form-range" id="emiTenureSlider" min="6" max="180" step="6" value="60">
              </div>
            </div>

            <!-- Result Box -->
            <div class="col-lg-5">
              <div class="bg-primary bg-opacity-10 border border-primary border-opacity-25 p-4 rounded-4 text-center">
                <div class="text-muted small fw-semibold text-uppercase mb-1"><?= __('Calculated Monthly EMI', 'പ്രതിമാസ തിരിച്ചടവ്') ?></div>
                <div class="display-6 fw-bold text-primary mb-3" id="calcEmiValue">₹ 10,442</div>

                <div class="row g-2 pt-3 border-top border-secondary border-opacity-25 small mb-3">
                  <div class="col-6 text-start">
                    <span class="text-muted"><?= __('Principal Amount', 'വായ്പാ തുക') ?>:</span>
                    <strong class="d-block text-dark" id="calcPrincipalValue">₹ 5,00,000</strong>
                  </div>
                  <div class="col-6 text-end">
                    <span class="text-muted"><?= __('Total Interest', 'ആകെ പലിശ') ?>:</span>
                    <strong class="d-block text-danger" id="calcInterestValue">₹ 1,26,499</strong>
                  </div>
                  <div class="col-12 text-center pt-2">
                    <span class="text-muted"><?= __('Total Payable', 'ആകെ തിരിച്ചടയ്ക്കേണ്ടത്') ?>:</span>
                    <strong class="d-block fs-5 text-dark" id="calcTotalPayable">₹ 6,26,499</strong>
                  </div>
                </div>

                <a href="<?= url('/service-request') ?>?scheme=Loan" class="btn btn-primary w-100 fw-bold">
                  <i class="fa-solid fa-paper-plane me-1"></i> <?= __('Apply for This Loan', 'ഈ വായ്പയ്ക്ക് അപേക്ഷിക്കുക') ?>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 2: Fixed Deposit / RD Maturity -->
      <div class="tab-pane fade" id="fd-calc" role="tabpanel" aria-labelledby="fd-calc-tab">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 max-w-900 mx-auto">
          <div class="row g-4 align-items-center">
            <div class="col-lg-7">
              <h4 class="fw-bold text-success mb-4"><?= __('Term Deposit Maturity Calculator', 'നിക്ഷേപ വളർച്ച കണക്കാക്കാം') ?></h4>

              <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                  <label class="form-label small fw-semibold text-muted"><?= __('Deposit Amount', 'നിക്ഷേപ തുക') ?></label>
                  <span id="fdAmountDisplay" class="fw-bold text-success fs-5">₹ 1,00,000</span>
                </div>
                <input type="range" class="form-range" id="fdAmountSlider" min="5000" max="2500000" step="5000" value="100000">
              </div>

              <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                  <label class="form-label small fw-semibold text-muted"><?= __('Deposit Period (Years)', 'കാലാവധി (വർഷം)') ?></label>
                  <span id="fdTenureDisplay" class="fw-bold text-success fs-5">1 Year</span>
                </div>
                <input type="range" class="form-range" id="fdTenureSlider" min="1" max="5" step="1" value="1">
              </div>

              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="seniorCitizenToggle">
                <label class="form-check-label small fw-bold text-dark" for="seniorCitizenToggle">
                  <?= __('Senior Citizen Depositor (+0.50% Extra Rate)', 'മുതിർന്ന പൗരന്മാർ (+0.50% അധിക പലിശ)') ?>
                </label>
              </div>
            </div>

            <div class="col-lg-5">
              <div class="bg-success bg-opacity-10 border border-success border-opacity-25 p-4 rounded-4 text-center">
                <div class="text-muted small fw-semibold text-uppercase mb-1"><?= __('Maturity Value', 'മെച്യൂരിറ്റി തുക') ?></div>
                <div class="display-6 fw-bold text-success mb-3" id="fdMaturityValue">₹ 1,08,510</div>

                <div class="row g-2 pt-3 border-top border-secondary border-opacity-25 small mb-3">
                  <div class="col-6 text-start">
                    <span class="text-muted"><?= __('Base Rate', 'പലിശ നിരക്ക്') ?>:</span>
                    <strong class="d-block text-dark" id="fdRateDisplay">8.25 %</strong>
                  </div>
                  <div class="col-6 text-end">
                    <span class="text-muted"><?= __('Interest Earned', 'പലിശ വരുമാനം') ?>:</span>
                    <strong class="d-block text-success" id="fdInterestEarned">₹ 8,510</strong>
                  </div>
                </div>

                <a href="<?= url('/service-request') ?>?scheme=Fixed+Deposit" class="btn btn-success w-100 fw-bold text-white">
                  <i class="fa-solid fa-vault me-1"></i> <?= __('Open Deposit Account', 'നിക്ഷേപം ആരംഭിക്കുക') ?>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 3: Gold Loan Calculator -->
      <div class="tab-pane fade" id="gold-calc" role="tabpanel" aria-labelledby="gold-calc-tab">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 max-w-900 mx-auto">
          <div class="row g-4 align-items-center">
            <div class="col-lg-7">
              <h4 class="fw-bold text-warning-emphasis mb-4"><?= __('Gold Loan Advance Estimator', 'സ്വർണ്ണ വായ്പാ പരിധി') ?></h4>

              <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                  <label class="form-label small fw-semibold text-muted"><?= __('Net Gold Weight (Grams)', 'സ്വർണ്ണത്തിന്റെ അറ്റ തൂക്കം (ഗ്രാം)') ?></label>
                  <span id="goldWeightDisplay" class="fw-bold text-warning-emphasis fs-5">50 Grams</span>
                </div>
                <input type="range" class="form-range" id="goldWeightSlider" min="5" max="250" step="1" value="50">
              </div>

              <div class="p-3 bg-light rounded-3 small border mb-3">
                <div class="d-flex justify-content-between mb-1">
                  <span class="text-muted"><?= __('Appraised Rate Per Gram (22K)', 'ഗ്രാമിന് കണക്കാക്കുന്ന തുക') ?>:</span>
                  <strong class="text-dark">₹ 5,200 / Gram</strong>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-muted"><?= __('Statutory LTV Ratio', 'നിയമാനുസൃത പരിധി') ?>:</span>
                  <strong class="text-success">75% Advance Value</strong>
                </div>
              </div>
            </div>

            <div class="col-lg-5">
              <div class="bg-warning bg-opacity-10 border border-warning border-opacity-25 p-4 rounded-4 text-center">
                <div class="text-muted small fw-semibold text-uppercase mb-1"><?= __('Eligible Loan Advance', 'ലഭ്യമാകുന്ന വായ്പാ തുക') ?></div>
                <div class="display-6 fw-bold text-dark mb-3" id="goldAdvanceValue">₹ 1,95,000</div>

                <div class="small text-muted mb-3">
                  <i class="fa-solid fa-clock text-warning me-1"></i> <?= __('Instant Sanction in 10 Minutes', '10 മിനിറ്റിനകം ലഭ്യമാക്കുന്നു') ?>
                </div>

                <a href="<?= url('/service-request') ?>?scheme=Gold+Loan" class="btn btn-warning w-100 fw-bold text-dark">
                  <i class="fa-solid fa-coins me-1"></i> <?= __('Apply for Gold Loan', 'സ്വർണ്ണ വായ്പയ്ക്ക് അപേക്ഷിക്കുക') ?>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->push('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // 1. EMI Calculator
  const amountSlider = document.getElementById('emiAmountSlider');
  const rateSlider = document.getElementById('emiRateSlider');
  const tenureSlider = document.getElementById('emiTenureSlider');

  function updateEmi() {
    const P = parseFloat(amountSlider.value);
    const R = parseFloat(rateSlider.value);
    const N = parseInt(tenureSlider.value, 10);

    document.getElementById('emiAmountDisplay').textContent = '₹ ' + P.toLocaleString('en-IN');
    document.getElementById('emiRateDisplay').textContent = R.toFixed(2) + ' %';
    document.getElementById('emiTenureDisplay').textContent = N + ' Months (' + (N/12).toFixed(1) + ' Yrs)';

    const r = (R / 12) / 100;
    const emi = (P * r * Math.pow(1 + r, N)) / (Math.pow(1 + r, N) - 1);
    const total = emi * N;
    const interest = total - P;

    document.getElementById('calcEmiValue').textContent = '₹ ' + Math.round(emi).toLocaleString('en-IN');
    document.getElementById('calcPrincipalValue').textContent = '₹ ' + P.toLocaleString('en-IN');
    document.getElementById('calcInterestValue').textContent = '₹ ' + Math.round(interest).toLocaleString('en-IN');
    document.getElementById('calcTotalPayable').textContent = '₹ ' + Math.round(total).toLocaleString('en-IN');
  }

  [amountSlider, rateSlider, tenureSlider].forEach(el => el.addEventListener('input', updateEmi));
  updateEmi();

  // 2. FD Calculator
  const fdAmount = document.getElementById('fdAmountSlider');
  const fdTenure = document.getElementById('fdTenureSlider');
  const seniorCheck = document.getElementById('seniorCitizenToggle');

  function updateFd() {
    const P = parseFloat(fdAmount.value);
    const Y = parseInt(fdTenure.value, 10);
    const isSenior = seniorCheck.checked;
    const baseRate = (Y >= 2 ? 8.00 : 8.25) + (isSenior ? 0.50 : 0);

    document.getElementById('fdAmountDisplay').textContent = '₹ ' + P.toLocaleString('en-IN');
    document.getElementById('fdTenureDisplay').textContent = Y + (Y === 1 ? ' Year' : ' Years');
    document.getElementById('fdRateDisplay').textContent = baseRate.toFixed(2) + ' %';

    // Quarterly compounding: A = P * (1 + r/4)^(4*Y)
    const r = baseRate / 100;
    const A = P * Math.pow(1 + (r / 4), 4 * Y);
    const interest = A - P;

    document.getElementById('fdMaturityValue').textContent = '₹ ' + Math.round(A).toLocaleString('en-IN');
    document.getElementById('fdInterestEarned').textContent = '₹ ' + Math.round(interest).toLocaleString('en-IN');
  }

  [fdAmount, fdTenure, seniorCheck].forEach(el => el.addEventListener('input', updateFd));
  updateFd();

  // 3. Gold Loan Calculator
  const goldWeight = document.getElementById('goldWeightSlider');
  function updateGold() {
    const W = parseFloat(goldWeight.value);
    document.getElementById('goldWeightDisplay').textContent = W + ' Grams';
    const ratePerGram = 5200;
    const ltv = 0.75;
    const advance = W * ratePerGram * ltv;
    document.getElementById('goldAdvanceValue').textContent = '₹ ' + Math.round(advance).toLocaleString('en-IN');
  }
  goldWeight.addEventListener('input', updateGold);
  updateGold();
});
</script>
<?php $this->endPush(); ?>
