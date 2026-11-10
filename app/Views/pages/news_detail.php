<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= url('/news') ?>"><?= __('nav_news') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= is_malayalam() ? e($article['title_ml']) : e($article['title_en']) ?></li>
      </ol>
    </nav>
    <div class="small text-muted mb-2">
      <i class="fa-regular fa-calendar me-1"></i>
      <?= date('l, d F Y', strtotime($article['publish_date'])) ?>
    </div>
    <h1 class="h2 fw-bold text-dark mb-0">
      <?= is_malayalam() ? e($article['title_ml']) : e($article['title_en']) ?>
    </h1>
  </div>
</div>

<div class="container py-5">
  <div class="row g-5">
    <!-- Main Article Body -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm p-4 p-md-5">
        <?php if (!empty($article['image'])): ?>
          <img src="<?= e($article['image']) ?>" class="img-fluid rounded mb-4" alt="<?= e($article['title_en']) ?>">
        <?php endif; ?>

        <?php if (!empty($article['excerpt_en'])): ?>
          <div class="lead fw-semibold text-primary mb-4 pb-3 border-bottom">
            <?= is_malayalam() ? e($article['excerpt_ml']) : e($article['excerpt_en']) ?>
          </div>
        <?php endif; ?>

        <div class="article-body leading-relaxed text-dark">
          <p style="white-space: pre-line; line-height: 1.8;">
            <?= is_malayalam() ? e($article['body_ml']) : e($article['body_en']) ?>
          </p>
        </div>

        <div class="pt-4 mt-5 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
          <a href="<?= url('/news') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> <?= is_malayalam() ? 'എല്ലാ വാർത്തകളും' : 'Back to All News' ?>
          </a>
          <div class="d-flex align-items-center gap-2">
            <span class="small text-muted"><?= is_malayalam() ? 'പങ്കുവെക്കുക' : 'Share' ?>:</span>
            <a href="https://api.whatsapp.com/send?text=<?= urlencode(is_malayalam() ? $article['title_ml'] : $article['title_en']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-success">
              <i class="fa-brands fa-whatsapp"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar: Recent News & Quick Links -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm p-4 mb-4">
        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
          <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>
          <?= is_malayalam() ? 'മറ്റ് വാർത്തകൾ' : 'Recent News' ?>
        </h5>
        <?php if (empty($recent)): ?>
          <p class="text-muted small mb-0"><?= is_malayalam() ? 'മറ്റ് വാർത്തകൾ ലഭ്യമല്ല.' : 'No other recent news available.' ?></p>
        <?php else: ?>
          <div class="list-group list-group-flush">
            <?php foreach ($recent as $r): ?>
              <a href="<?= url('/news/' . $r['slug']) ?>" class="list-group-item list-group-item-action px-0 py-2 border-0">
                <div class="small text-muted"><?= date('d M Y', strtotime($r['publish_date'])) ?></div>
                <div class="fw-semibold text-dark small">
                  <?= is_malayalam() ? e($r['title_ml']) : e($r['title_en']) ?>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="card border-0 shadow-sm p-4 bg-light">
        <h5 class="fw-bold text-dark mb-3">
          <i class="fa-solid fa-bell text-warning me-2"></i>
          <?= is_malayalam() ? 'പ്രധാന അറിയിപ്പുകൾ' : 'Customer Notices' ?>
        </h5>
        <p class="small text-muted mb-3">
          <?= is_malayalam() ? 'ഏറ്റവും പുതിയ പലിശ നിരക്കുകളും പൊതു അറിയിപ്പുകളും പരിശോധിക്കാം.' : 'Review published statutory rates and interest revisions.' ?>
        </p>
        <a href="<?= url('/interest-rates') ?>" class="btn btn-primary btn-sm w-100 mb-2">
          <i class="fa-solid fa-percent me-1"></i> <?= __('nav_rates') ?>
        </a>
        <a href="<?= url('/downloads') ?>" class="btn btn-outline-primary btn-sm w-100">
          <i class="fa-solid fa-file-arrow-down me-1"></i> <?= __('nav_downloads') ?>
        </a>
      </div>
    </div>
  </div>
</div>
