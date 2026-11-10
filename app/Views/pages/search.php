<?php
$totalCount = count($results['products']) + count($results['branches']) + count($results['downloads']) + count($results['news']);
?>

<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('search_placeholder') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-magnifying-glass text-primary me-2"></i>
      <?= is_malayalam() ? 'തിരച്ചിൽ ഫലങ്ങൾ' : 'Search Results' ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= is_malayalam() 
          ? 'തിരഞ്ഞ വാക്ക്: "' . e($query) . '" (' . $totalCount . ' ഫലങ്ങൾ ലഭിച്ചു)' 
          : 'Query: "' . e($query) . '" (' . $totalCount . ' items found)' ?>
    </p>
  </div>
</div>

<div class="container py-5">
  <!-- Search input box to refine query -->
  <div class="row justify-content-center mb-5">
    <div class="col-lg-8">
      <form action="<?= url('/search') ?>" method="GET">
        <div class="input-group input-group-lg shadow-sm">
          <input type="text" 
                 name="q" 
                 class="form-control" 
                 placeholder="<?= __('search_placeholder') ?>" 
                 value="<?= e($query) ?>" 
                 required>
          <button class="btn btn-primary px-4" type="submit">
            <i class="fa-solid fa-magnifying-glass me-2"></i> <?= is_malayalam() ? 'തിരയുക' : 'Search' ?>
          </button>
        </div>
      </form>
    </div>
  </div>

  <?php if ($totalCount === 0): ?>
    <div class="card border-0 shadow-sm text-center py-5">
      <div class="card-body">
        <i class="fa-solid fa-search fa-3x text-muted mb-3"></i>
        <h4 class="text-dark"><?= is_malayalam() ? 'ഫലങ്ങളൊന്നും കണ്ടെത്താനായില്ല' : 'No matches found' ?></h4>
        <p class="text-muted small">
          <?= is_malayalam() 
              ? 'മറ്റൊരു വാക്ക് നൽകി തിരയാൻ ശ്രമിക്കുക അല്ലെങ്കിൽ താഴെയുള്ള പ്രധാന വിഭാഗങ്ങൾ സന്ദർശിക്കുക.' 
              : 'Try checking your spelling or use different keywords like "Loan", "Gold", "Deposit", "Locker".' ?>
        </p>
        <div class="d-flex justify-content-center gap-2 mt-4 flex-wrap">
          <a href="<?= url('/services') ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-hand-holding-dollar me-1"></i> <?= __('nav_services') ?></a>
          <a href="<?= url('/interest-rates') ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-percent me-1"></i> <?= __('nav_rates') ?></a>
          <a href="<?= url('/branches') ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-building-columns me-1"></i> <?= __('nav_branches') ?></a>
          <a href="<?= url('/downloads') ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-download me-1"></i> <?= __('nav_downloads') ?></a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Products Results -->
    <?php if (!empty($results['products'])): ?>
      <div class="mb-5">
        <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">
          <i class="fa-solid fa-hand-holding-dollar text-primary me-2"></i>
          <?= __('nav_services') ?> & <?= is_malayalam() ? 'പദ്ധതികൾ' : 'Schemes' ?>
        </h4>
        <div class="row g-3">
          <?php foreach ($results['products'] as $prod): ?>
            <div class="col-md-6">
              <div class="card border-0 shadow-sm p-3 h-100">
                <h5 class="fw-bold mb-1">
                  <a href="<?= url('/products/' . $prod['slug']) ?>" class="text-decoration-none text-primary">
                    <?= is_malayalam() ? e($prod['name_ml']) : e($prod['name_en']) ?>
                  </a>
                </h5>
                <p class="small text-muted mb-3">
                  <?= is_malayalam() ? e($prod['tagline_ml'] ?? '') : e($prod['tagline_en'] ?? '') ?>
                </p>
                <div class="mt-auto">
                  <a href="<?= url('/products/' . $prod['slug']) ?>" class="btn btn-sm btn-link p-0 text-decoration-none">
                    <?= __('view_all') ?> <i class="fa-solid fa-arrow-right ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Branches Results -->
    <?php if (!empty($results['branches'])): ?>
      <div class="mb-5">
        <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">
          <i class="fa-solid fa-building-columns text-primary me-2"></i>
          <?= __('nav_branches') ?>
        </h4>
        <div class="row g-3">
          <?php foreach ($results['branches'] as $b): ?>
            <div class="col-md-6">
              <div class="card border-0 shadow-sm p-3 h-100">
                <h5 class="fw-bold mb-1 text-dark">
                  <?= is_malayalam() ? e($b['name_ml']) : e($b['name_en']) ?>
                </h5>
                <p class="small text-muted mb-2">
                  <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                  <?= is_malayalam() ? e($b['address_ml']) : e($b['address_en']) ?>
                </p>
                <?php if (!empty($b['phone'])): ?>
                  <div class="small text-muted">
                    <i class="fa-solid fa-phone me-1 text-success"></i> <?= e($b['phone']) ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Downloads Results -->
    <?php if (!empty($results['downloads'])): ?>
      <div class="mb-5">
        <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">
          <i class="fa-solid fa-file-arrow-down text-primary me-2"></i>
          <?= __('nav_downloads') ?>
        </h4>
        <div class="list-group shadow-sm">
          <?php foreach ($results['downloads'] as $d): ?>
            <a href="<?= e($d['file_path']) ?>" download class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
              <div>
                <i class="fa-solid fa-file-pdf text-danger me-2"></i>
                <span class="fw-semibold text-dark"><?= is_malayalam() ? e($d['title_ml']) : e($d['title_en']) ?></span>
                <span class="badge bg-light text-muted border ms-2"><?= e($d['category']) ?></span>
              </div>
              <span class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-download"></i></span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- News Results -->
    <?php if (!empty($results['news'])): ?>
      <div class="mb-5">
        <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">
          <i class="fa-solid fa-newspaper text-primary me-2"></i>
          <?= __('nav_news') ?>
        </h4>
        <div class="row g-3">
          <?php foreach ($results['news'] as $n): ?>
            <div class="col-md-6">
              <div class="card border-0 shadow-sm p-3 h-100">
                <div class="small text-muted mb-1"><?= date('d M Y', strtotime($n['publish_date'])) ?></div>
                <h5 class="fw-bold mb-1">
                  <a href="<?= url('/news/' . $n['slug']) ?>" class="text-decoration-none text-primary">
                    <?= is_malayalam() ? e($n['title_ml']) : e($n['title_en']) ?>
                  </a>
                </h5>
                <p class="small text-muted mb-0">
                  <?= is_malayalam() ? e($n['excerpt_ml'] ?? '') : e($n['excerpt_en'] ?? '') ?>
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
