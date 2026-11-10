<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Settings & Statutory Compliance</h3>
    <p class="text-muted small mb-0">Legal profile configuration, entity type compliance, and DPDP personal data handling policies.</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm p-4">
      <h5 class="fw-bold mb-3 text-dark">Institutional Legal Profile</h5>
      <div class="table-responsive">
      <table class="table table-bordered small">
        <tbody>
          <tr>
            <th class="bg-light" style="width: 35%;">Approved Public Name</th>
            <td class="fw-bold text-primary"><?= e(bank_name()) ?></td>
          </tr>
          <tr>
            <th class="bg-light">Entity Classification</th>
            <td><span class="badge bg-dark"><?= e(setting('legal.entity_type')) ?></span></td>
          </tr>
          <tr>
            <th class="bg-light">Registration Number</th>
            <td><?= e(setting('legal.registration_number')) ?></td>
          </tr>
          <tr>
            <th class="bg-light">DICGC Insurance Enabled</th>
            <td>
              <span class="badge bg-<?= setting('legal.dicgc_enabled') ? 'success' : 'secondary' ?>">
                <?= setting('legal.dicgc_enabled') ? 'YES (Licensed Bank)' : 'NO (Credit Society)' ?>
              </span>
            </td>
          </tr>
          <tr>
            <th class="bg-light">PAN (Masked for Compliance)</th>
            <td><?= e(mask_pan(setting('legal.pan', ''))) ?></td>
          </tr>
          <tr>
            <th class="bg-light">GST Identification</th>
            <td><?= e(setting('legal.gst', 'Not Applicable')) ?></td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card border-0 shadow-sm p-4">
      <h5 class="fw-bold mb-3 text-dark">Regulatory Notes</h5>
      <div class="alert alert-info small mb-3">
        <i class="fa-solid fa-scale-balanced me-1"></i>
        <strong>Banking Regulation Act (AACS):</strong>
        Under Section 49B/56 of the Banking Regulation Act, primary credit societies and cooperative societies not licensed by RBI are prohibited from using the word "Bank" or "Banking" in their nomenclature.
      </div>
      <div class="alert alert-success small mb-0">
        <i class="fa-solid fa-shield-halved me-1"></i>
        <strong>DPDP Act 2023 Compliance:</strong>
        Personal data collected through enquiries and loan forms is encrypted in transit and purged in compliance with retention mandates.
      </div>
    </div>
  </div>
</div>
