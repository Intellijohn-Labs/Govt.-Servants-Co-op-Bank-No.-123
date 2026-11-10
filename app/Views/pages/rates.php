<?php
$crumbs = [
    ['title' => __('nav_rates'), 'url' => '']
];
$loanEffective = !empty($loan_rates) ? $loan_rates[0]['effective_from'] : null;
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4 py-lg-5">
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4 mb-lg-5">
    <div>
      <span class="section-eyebrow"><i class="fa-solid fa-percent"></i> <?= __('Official Schedule', 'ഔദ്യോഗിക നിരക്കുകൾ') ?></span>
      <h1 class="section-title mb-1"><?= __('Interest Rate Schedule', 'പലിശ നിരക്കുകൾ') ?></h1>
      <p class="text-muted mb-0"><?= __('Current interest rates applicable to members and customers.', 'അംഗങ്ങൾക്കും ഇടപാടുകാർക്കും ബാധകമായ നിലവിലെ പലിശ നിരക്കുകൾ.') ?></p>
    </div>
    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
      <i class="fa-solid fa-print me-1" aria-hidden="true"></i> <?= __('Print Schedule', 'പ്രിന്റ് ചെയ്യുക') ?>
    </button>
  </div>

  <!-- Loan rates -->
  <section id="loan-rates" class="table-card mb-4 mb-lg-5" aria-labelledby="loan-rates-title">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-3 border-bottom">
      <h2 id="loan-rates-title" class="h4 fw-bold text-primary mb-0">
        <i class="fa-solid fa-hand-holding-dollar me-2" aria-hidden="true"></i> <?= __('Loan Interest Rates', 'വായ്പാ പലിശ നിരക്കുകൾ') ?>
      </h2>
      <?php if ($loanEffective): ?>
        <span class="badge rounded-pill text-bg-light border px-3 py-2"><i class="fa-regular fa-calendar me-1"></i> <?= __('Effective from', 'പ്രാബല്യ തീയതി') ?> <?= e(format_date($loanEffective)) ?></span>
      <?php endif; ?>
    </div>

    <div class="table-responsive">
      <table class="table rates-table align-middle">
        <caption class="visually-hidden"><?= __('Loan interest rates by loan amount', 'വായ്പാ തുക അനുസരിച്ചുള്ള പലിശ നിരക്കുകൾ') ?></caption>
        <thead>
          <tr>
            <th scope="col"><?= __('Loan Amount', 'വായ്പാ തുക') ?></th>
            <th scope="col" class="text-center"><?= __('Interest Rate', 'പലിശ നിരക്ക്') ?></th>
            <th scope="col" class="text-end d-none d-sm-table-cell"><?= __('Effective From', 'പ്രാബല്യ തീയതി') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($loan_rates)): ?>
            <?php foreach ($loan_rates as $lr): ?>
              <tr>
                <td>
                  <?php $sb = is_malayalam() ? ($lr['notes_ml'] ?? '') : ($lr['notes_en'] ?? ''); $sl = is_malayalam() ? $lr['tenure_label_ml'] : $lr['tenure_label_en']; ?>
                  <?php if (!empty($sb)): ?><span class="slab-badge"><?= e($sb) ?></span><?php endif; ?>
                  <?php if ($sl !== $sb): ?><span class="fw-semibold"><?= e($sl) ?></span><?php endif; ?>
                </td>
                <td class="text-center"><span class="rate-pill"><?= number_format((float)$lr['general_rate'], 2) ?>% <small>p.a.</small></span></td>
                <td class="text-end text-muted small d-none d-sm-table-cell"><?= format_date($lr['effective_from']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="3"><div class="empty-state"><i class="fa-regular fa-clock d-block"></i><?= __('Rates will be published soon.', 'നിരക്കുകൾ ഉടൻ ലഭ്യമാകും.') ?></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="rate-card-note mt-3">
      <div class="fw-semibold text-dark mb-1"><i class="fa-solid fa-circle-info text-primary me-1" aria-hidden="true"></i> <?= __('Terms', 'വ്യവസ്ഥകൾ') ?></div>
      <ul class="mb-0 ps-3">
        <?php if ($loanEffective): ?>
          <li><?= __('Rates are effective from', 'ഈ നിരക്കുകൾ പ്രാബല്യത്തിൽ വന്ന തീയതി') ?> <strong><?= e(format_date($loanEffective)) ?></strong>.</li>
        <?php endif; ?>
        <li><?= __('Government employee members: 10% rebate on interest paid for loans repaid on time without missing instalments.', 'അംഗങ്ങളായ സർക്കാർ ജീവനക്കാർക്ക് തവണകൾ തെറ്റാതെ തിരിച്ചടക്കുന്ന വായ്പകളിൽ അടച്ച പലിശയുടെ 10% റിബേറ്റ്.') ?></li>
        <li><?= __('rates_disclaimer') ?></li>
      </ul>
    </div>
  </section>

  <!-- Deposit rates -->
  <section id="deposit-rates" class="table-card" aria-labelledby="deposit-rates-title">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-3 border-bottom">
      <h2 id="deposit-rates-title" class="h4 fw-bold text-success mb-0">
        <i class="fa-solid fa-piggy-bank me-2" aria-hidden="true"></i> <?= __('Deposit Schemes', 'നിക്ഷേപ പദ്ധതികൾ') ?>
      </h2>
    </div>

    <?php if (!empty($deposit_rates)): ?>
      <div class="table-responsive">
        <table class="table rates-table align-middle">
          <caption class="visually-hidden"><?= __('Deposit interest rates', 'നിക്ഷേപ പലിശ നിരക്കുകൾ') ?></caption>
          <thead>
            <tr>
              <th scope="col"><?= __('Tenure / Slab', 'കാലാവധി') ?></th>
              <th scope="col" class="text-center"><?= __('General Public', 'പൊതുവിഭാഗം') ?></th>
              <th scope="col" class="text-center"><?= __('Senior Citizens', 'മുതിർന്ന പൗരന്മാർ') ?></th>
              <th scope="col" class="text-end d-none d-sm-table-cell"><?= __('Effective From', 'പ്രാബല്യ തീയതി') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($deposit_rates as $r): ?>
              <tr>
                <td class="fw-semibold"><?= is_malayalam() ? e($r['tenure_label_ml']) : e($r['tenure_label_en']) ?></td>
                <td class="text-center"><span class="rate-pill"><?= number_format((float)$r['general_rate'], 2) ?>%</span></td>
                <td class="text-center"><span class="rate-pill"><?= number_format((float)($r['senior_rate'] ?? $r['general_rate']), 2) ?>%</span></td>
                <td class="text-end text-muted small d-none d-sm-table-cell"><?= format_date($r['effective_from']) ?></td>
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
  </section>
</div>
