<?php
$crumbs = [
    ['title' => __('nav_rates'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
    <div>
      <span class="badge bg-primary text-white mb-2"><?= __('Official Schedule', 'ഔദ്യോഗിക നിരക്കുകൾ') ?></span>
      <h1 class="fw-bold mb-1"><?= __('Comprehensive Interest Rate Schedule', 'പലിശ നിരക്കുകൾ') ?></h1>
      <p class="text-muted small mb-0"><?= __('Updated and verified directly by our Treasury and Accounts Department.', 'ട്രഷറി വിഭാഗം അംഗീകരിച്ച ഏറ്റവും പുതിയ പലിശ നിരക്കുകൾ.') ?></p>
    </div>

    <div class="d-flex gap-2">
      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
        <i class="fa-solid fa-print me-1"></i> <?= __('Print Schedule', 'പ്രിന്റ് ചെയ്യുക') ?>
      </button>
      <a href="<?= url('/downloads') ?>" class="btn btn-outline-primary btn-sm">
        <i class="fa-solid fa-file-pdf me-1"></i> <?= __('Download Rate Card (PDF)', 'റേറ്റ് കാർഡ് (PDF)') ?>
      </a>
    </div>
  </div>

  <!-- Deposit Rates Table Card -->
  <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
      <h4 class="fw-bold text-success mb-0">
        <i class="fa-solid fa-piggy-bank me-2"></i> <?= __('Deposit Interest Rates', 'നിക്ഷേപ പലിശ നിരക്കുകൾ') ?>
      </h4>
      <span class="badge bg-success-subtle text-success small"><?= __('Senior Citizen Bonus: +0.50%', 'മുതിർന്ന പൗരന്മാർക്ക്: +0.50%') ?></span>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th style="width: 40%;"><?= __('Tenure / Slab', 'കാലാവധി') ?></th>
            <th class="text-center"><?= __('General Public', 'പൊതുവിഭാഗം') ?> (% p.a.)</th>
            <th class="text-center"><?= __('Senior Citizens', 'മുതിർന്ന പൗരന്മാർ') ?> (% p.a.)</th>
            <th class="text-end"><?= __('Effective From', 'പ്രാബല്യ തീയതി') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($deposit_rates)): ?>
            <?php foreach ($deposit_rates as $r): ?>
              <tr>
                <td class="fw-semibold text-dark"><?= is_malayalam() ? e($r['tenure_label_ml']) : e($r['tenure_label_en']) ?></td>
                <td class="text-center"><span class="rate-badge fs-6 text-primary"><?= number_format((float)$r['general_rate'], 2) ?>%</span></td>
                <td class="text-center"><span class="rate-badge fs-6 text-success bg-success-subtle"><?= number_format((float)($r['senior_rate'] ?? $r['general_rate']), 2) ?>%</span></td>
                <td class="text-end text-muted small"><?= format_date($r['effective_from']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" class="text-center py-4 text-muted">No deposit rates active.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="p-3 bg-light rounded-3 small text-muted mt-2 border">
      <i class="fa-solid fa-circle-info text-primary me-1"></i>
      <strong><?= __('Regulatory Note', 'നിരാകരണം') ?>:</strong> <?= __('rates_disclaimer') ?>
    </div>
  </div>

  <!-- Loan Rates Table Card -->
  <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
      <h4 class="fw-bold text-primary mb-0">
        <i class="fa-solid fa-hand-holding-dollar me-2"></i> <?= __('Loan & Credit Advance Rates', 'വായ്പാ പലിശ നിരക്കുകൾ') ?>
      </h4>
      <span class="badge bg-primary-subtle text-primary small"><?= __('Reducing Balance Basis', 'കുറയുന്ന നിരക്കിൽ') ?></span>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th style="width: 45%;"><?= __('Loan Scheme', 'വായ്പാ പദ്ധതി') ?></th>
            <th class="text-center"><?= __('Interest Rate (% p.a.)', 'പലിശ നിരക്ക്') ?></th>
            <th class="text-end"><?= __('Effective From', 'പ്രാബല്യ തീയതി') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($loan_rates)): ?>
            <?php foreach ($loan_rates as $lr): ?>
              <tr>
                <td class="fw-semibold text-dark"><?= is_malayalam() ? e($lr['tenure_label_ml']) : e($lr['tenure_label_en']) ?></td>
                <td class="text-center"><span class="rate-badge fs-6 text-primary"><?= number_format((float)$lr['general_rate'], 2) ?>%</span></td>
                <td class="text-end text-muted small"><?= format_date($lr['effective_from']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="3" class="text-center py-4 text-muted">No loan rates active.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
