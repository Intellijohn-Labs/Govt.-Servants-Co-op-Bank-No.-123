<?php
$title = is_malayalam() ? $product['name_ml'] : $product['name_en'];
$crumbs = [
    ['title' => __('nav_services'), 'url' => url('/services')],
    ['title' => $title, 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<div class="container py-4">
  <div class="row g-4">
    <!-- Main Product Content -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
          <span class="badge bg-primary text-white text-uppercase px-3 py-2 fw-semibold">
            <?= is_malayalam() ? e($product['cat_name_ml']) : e($product['cat_name_en']) ?>
          </span>
          <span class="badge bg-light text-muted border px-3 py-2">
            <i class="fa-solid fa-users me-1"></i>
            <?= $product['target_audience'] === 'members_only' ? __('Eligible: Enrolled Members Only', 'അംഗങ്ങൾക്ക് മാത്രം') : __('Eligible: Members & General Public', 'പൊതുജനങ്ങൾക്കും അംഗങ്ങൾക്കും') ?>
          </span>
        </div>

        <h1 class="fw-bold text-dark mb-2"><?= e($title) ?></h1>
        <p class="lead text-muted mb-4"><?= is_malayalam() ? e($product['tagline_ml']) : e($product['tagline_en']) ?></p>

        <!-- Key Financial Parameters Summary Grid -->
        <div class="row g-3 p-3 bg-light rounded-4 border mb-4">
          <div class="col-sm-4 border-end-sm">
            <div class="text-muted small"><?= __('Interest Rate', 'പലിശ നിരക്ക്') ?></div>
            <div class="fs-4 fw-bold text-primary"><?= e($product['interest_rate_display']) ?></div>
            <div class="small text-muted" style="font-size: 0.75rem;">*<?= __('Indicative p.a.', 'പ്രതിവർഷം') ?></div>
          </div>
          <div class="col-sm-4 border-end-sm">
            <div class="text-muted small"><?= __('Tenure / Period', 'കാലാവധി') ?></div>
            <div class="fs-5 fw-bold text-dark"><?= is_malayalam() ? e($product['tenure_display_ml']) : e($product['tenure_display_en']) ?></div>
          </div>
          <div class="col-sm-4">
            <div class="text-muted small"><?= __('Maximum Amount', 'പരമാവധി തുക') ?></div>
            <div class="fs-5 fw-bold text-dark"><?= is_malayalam() ? e($product['max_amount_display_ml']) : e($product['max_amount_display_en']) ?></div>
          </div>
        </div>

        <h4 class="fw-bold text-primary mb-3"><i class="fa-solid fa-circle-info me-2"></i> <?= __('Overview & Scheme Details', 'പദ്ധതി വിവരങ്ങൾ') ?></h4>
        <div class="lead fs-6 lh-lg text-dark mb-4">
          <?= is_malayalam() ? nl2br(e($product['overview_ml'])) : nl2br(e($product['overview_en'])) ?>
        </div>

        <!-- Scheme Variants Table (if any) -->
        <?php if (!empty($variants)): ?>
          <h4 class="fw-bold text-primary mb-3 mt-4"><i class="fa-solid fa-layer-group me-2"></i> <?= __('Available Scheme Variants', 'ലഭ്യമായ വകഭേദങ്ങൾ') ?></h4>
          <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th><?= __('Variant Name', 'പദ്ധതി വകഭേദം') ?></th>
                  <th class="text-center"><?= __('Ceiling', 'പരമാവധി പരിധി') ?></th>
                  <th class="text-center"><?= __('Interest Rate', 'പലിശ') ?></th>
                  <th class="text-end"><?= __('Tenure', 'കാലാവധി') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($variants as $v): ?>
                  <tr>
                    <td class="fw-bold"><?= is_malayalam() ? e($v['name_ml']) : e($v['name_en']) ?></td>
                    <td class="text-center"><?= format_currency($v['ceiling_amount']) ?></td>
                    <td class="text-center"><span class="badge bg-warning text-dark fw-bold"><?= e($v['rate_display']) ?></span></td>
                    <td class="text-end text-muted small"><?= e($v['tenure']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>

        <!-- Terms & Fees Details -->
        <h4 class="fw-bold text-primary mb-3 mt-4"><i class="fa-solid fa-scale-balanced me-2"></i> <?= __('Processing & Repayment Terms', 'പ്രോസസ്സിംഗ് & തിരിച്ചടവ്') ?></h4>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3 h-100 border">
              <strong class="d-block mb-1 text-dark"><?= __('Processing Charges', 'പ്രോസസ്സിംഗ് ചാർജ്ജ്') ?>:</strong>
              <span class="small text-muted"><?= is_malayalam() ? e($product['processing_fee_ml']) : e($product['processing_fee_en']) ?></span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3 h-100 border">
              <strong class="d-block mb-1 text-dark"><?= __('Security / Collateral', 'ഈട് / വ്യവസ്ഥകൾ') ?>:</strong>
              <span class="small text-muted"><?= is_malayalam() ? e($product['security_required_ml'] ?? 'Standard collateral / ornaments as per society rules.') : e($product['security_required_en'] ?? 'Standard collateral / ornaments as per society rules.') ?></span>
            </div>
          </div>
        </div>

        <!-- Required Documents Checklist -->
        <?php if (!empty($documents)): ?>
          <h4 class="fw-bold text-primary mb-3 mt-4"><i class="fa-solid fa-file-circle-check me-2"></i> <?= __('Required Documents', 'ആവശ്യമായ രേഖകൾ') ?></h4>
          <ul class="list-group list-group-flush mb-4">
            <?php foreach ($documents as $doc): ?>
              <li class="list-group-item d-flex align-items-center gap-2 px-0">
                <i class="fa-solid fa-circle-check text-success"></i>
                <span class="fw-semibold"><?= is_malayalam() ? e($doc['title_ml']) : e($doc['title_en']) ?></span>
                <?php if (!empty($doc['is_mandatory'])): ?>
                  <span class="badge bg-danger-subtle text-danger small ms-auto"><?= __('Mandatory', 'നിർബന്ധം') ?></span>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <!-- Product FAQs Accordion -->
        <?php if (!empty($faqs)): ?>
          <h4 class="fw-bold text-primary mb-3 mt-4"><i class="fa-solid fa-circle-question me-2"></i> <?= __('Frequently Asked Questions', 'പതിവുചോദ്യങ്ങൾ') ?></h4>
          <div class="accordion" id="productFaqAccordion">
            <?php foreach ($faqs as $index => $faq): ?>
              <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="heading<?= $index ?>">
                  <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?> fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
                    <?= is_malayalam() ? e($faq['question_ml']) : e($faq['question_en']) ?>
                  </button>
                </h2>
                <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $index ?>" data-bs-parent="#productFaqAccordion">
                  <div class="accordion-body small text-muted lh-base">
                    <?= is_malayalam() ? nl2br(e($faq['answer_ml'])) : nl2br(e($faq['answer_en'])) ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Sticky Sidebar Actions -->
    <div class="col-lg-4">
      <div class="sticky-top" style="top: 100px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-primary text-white">
          <h5 class="fw-bold mb-2"><?= __('Interested in this Scheme?', 'ഈ പദ്ധതിയിൽ താല്പര്യമുണ്ടോ?') ?></h5>
          <p class="small text-white-50 mb-4"><?= __('Submit your details and our branch representative will contact you with quick sanction assistance.', 'വിവരങ്ങൾ നൽകുക; ഞങ്ങളുടെ പ്രതിനിധി ഉടൻ ബന്ധപ്പെടും.') ?></p>
          <a href="<?= url('/service-request') ?>?scheme=<?= urlencode($product['name_en']) ?>" class="btn btn-warning w-100 fw-bold py-2 mb-2 text-dark">
            <i class="fa-solid fa-file-signature me-1"></i> <?= __('Apply / Enquire Now', 'അപേക്ഷ സമർപ്പിക്കുക') ?>
          </a>
          <?php if (!empty(setting('contact.whatsapp_number'))): ?>
            <a href="https://wa.me/<?= e(setting('contact.whatsapp_number')) ?>?text=<?= urlencode('Hello, I am interested in ' . $product['name_en']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success w-100 fw-bold py-2">
              <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp Enquiry
            </a>
          <?php endif; ?>
        </div>

        <!-- Branch Help Box -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
          <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-building-columns text-primary me-2"></i> <?= __('Apply in Person', 'ശാഖ നേരിട്ട് സന്ദർശിക്കാം') ?></h6>
          <p class="small text-muted mb-3"><?= __('Visit your nearest branch for immediate document verification and instant sanction.', 'വേഗത്തിൽ വായ്പ ലഭ്യമാക്കാൻ അടുത്തുള്ള ശാഖ സന്ദർശിക്കുക.') ?></p>
          <a href="<?= url('/branches') ?>" class="btn btn-outline-primary btn-sm fw-bold">
            <?= __('Find Nearest Branch', 'അടുത്തുള്ള ശാഖ കണ്ടെത്തുക') ?> &rarr;
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
