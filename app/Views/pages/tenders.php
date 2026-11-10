<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('nav_tenders') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-bullhorn text-primary me-2"></i>
      <?= __('nav_tenders') ?> / <?= is_malayalam() ? 'ടെണ്ടറുകളും കൊട്ടേഷനുകളും' : 'Tenders & Quotations' ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= is_malayalam() 
          ? 'സ്ഥാപനത്തിന്റെ വികസന പ്രവർത്തനങ്ങൾ, ഉപകരണങ്ങൾ, നിർമ്മാണങ്ങൾ എന്നിവയ്ക്കായുള്ള ഔദ്യോഗിക ദർഘാസുകൾ.' 
          : 'Public tenders, expression of interest (EOI), and sealed quotations invited from authorized vendors.' ?>
    </p>
  </div>
</div>

<div class="container py-5">
  <?php if (empty($tenders)): ?>
    <div class="card border-0 shadow-sm text-center py-5">
      <div class="card-body">
        <i class="fa-solid fa-clipboard-check fa-3x text-muted mb-3"></i>
        <h5 class="text-dark"><?= is_malayalam() ? 'നിലവിൽ പുതിയ ടെണ്ടറുകൾ ലഭ്യമല്ല' : 'No active tenders at this moment' ?></h5>
        <p class="text-muted small"><?= is_malayalam() ? 'ഭാവി അറിയിപ്പുകൾക്കായി ഈ പേജ് വീണ്ടും സന്ദർശിക്കുക.' : 'Please check back later or review published notices in leading daily newspapers.' ?></p>
      </div>
    </div>
  <?php else: ?>
    <div class="table-responsive bg-white rounded shadow-sm border">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th scope="col" class="py-3 ps-3"><?= is_malayalam() ? 'റഫറൻസ് നമ്പർ' : 'Ref. No.' ?></th>
            <th scope="col" class="py-3"><?= is_malayalam() ? 'വിഷയം / വിവരണം' : 'Tender Title & Scope' ?></th>
            <th scope="col" class="py-3"><?= is_malayalam() ? 'അവസാന തീയതി' : 'Closing Date' ?></th>
            <th scope="col" class="py-3"><?= is_malayalam() ? 'അവസ്ഥ' : 'Status' ?></th>
            <th scope="col" class="py-3 text-end pe-3"><?= is_malayalam() ? 'രേഖ' : 'Document' ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tenders as $tender): ?>
            <?php 
              $isExpired = strtotime($tender['closing_date']) < time();
            ?>
            <tr>
              <td class="ps-3 fw-bold font-monospace small text-primary">
                <?= e($tender['tender_ref_no']) ?>
              </td>
              <td>
                <div class="fw-semibold text-dark">
                  <?= is_malayalam() ? e($tender['title_ml']) : e($tender['title_en']) ?>
                </div>
                <?php if (!empty($tender['description_en'])): ?>
                  <div class="text-muted small">
                    <?= is_malayalam() ? e($tender['description_ml'] ?? '') : e($tender['description_en']) ?>
                  </div>
                <?php endif; ?>
              </td>
              <td class="small">
                <i class="fa-regular fa-calendar me-1 text-muted"></i>
                <?= date('d M Y, h:i A', strtotime($tender['closing_date'])) ?>
              </td>
              <td>
                <span class="badge bg-<?= $isExpired ? 'secondary' : 'success' ?>">
                  <?= $isExpired ? (is_malayalam() ? 'കാലാവധി കഴിഞ്ഞു' : 'Closed') : (is_malayalam() ? 'സജീവം' : 'Active') ?>
                </span>
              </td>
              <td class="text-end pe-3">
                <?php if (!empty($tender['file_path'])): ?>
                  <a href="<?= e($tender['file_path']) ?>" download class="btn btn-sm btn-outline-primary">
                    <i class="fa-solid fa-download me-1"></i> PDF
                  </a>
                <?php else: ?>
                  <span class="text-muted small"><?= is_malayalam() ? 'ഹെഡ് ഓഫീസിൽ ലഭ്യമാണ്' : 'At Head Office' ?></span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <!-- General Conditions Notice -->
  <div class="card border-0 bg-light shadow-sm mt-5">
    <div class="card-body p-4 small text-muted">
      <h6 class="fw-bold text-dark mb-2">
        <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i>
        <?= is_malayalam() ? 'പൊതു നിർദ്ദേശങ്ങൾ' : 'Tender Guidelines & Submission Rules' ?>
      </h6>
      <p class="mb-1">
        <?= is_malayalam() 
            ? '1. മുദ്രവച്ച കവറിൽ ടെണ്ടർ റഫറൻസ് നമ്പർ രേഖപ്പെടുത്തി കൃത്യസമയത്തിന് മുൻപായി ഹെഡ് ഓഫീസിൽ നേരിട്ടോ രജിസ്റ്റേർഡ് തപാലിലോ എത്തിക്കേണ്ടതാണ്.' 
            : '1. Sealed quotations superscribed with the tender reference number must reach the Secretary / Chief Executive before the stipulated cutoff.' ?>
      </p>
      <p class="mb-0">
        <?= is_malayalam() 
            ? '2. യാതൊരു കാരണവും വ്യക്തമാക്കാതെ ഏതൊരു ടെണ്ടറും സ്വീകരിക്കാനോ നിരസിക്കാനോ ഉള്ള പൂർണ്ണ അധികാരം ബാങ്ക് ഭരണസമിതിയിൽ നിക്ഷിപ്തമാണ്.' 
            : '2. The board of management reserves unconditional authority to accept or reject any quotation without assigning reasons thereof.' ?>
      </p>
    </div>
  </div>
</div>
