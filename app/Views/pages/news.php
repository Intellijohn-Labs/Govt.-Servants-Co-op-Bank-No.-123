<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('nav_news') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-newspaper text-primary me-2"></i>
      <?= __('nav_news') ?> / <?= is_malayalam() ? 'വാർത്തകളും അറിയിപ്പുകളും' : 'News & Announcements' ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= is_malayalam() 
          ? 'ബാങ്കിന്റെ പുതിയ പദ്ധതികൾ, ശാഖാ പ്രവർത്തനങ്ങൾ, പലിശ നിരക്ക് പരിഷ്കരണങ്ങൾ എന്നിവയെക്കുറിച്ചുള്ള ഔദ്യോഗിക വാർത്തകൾ.' 
          : 'Stay updated with our latest banking initiatives, branch events, public notices, and interest rate updates.' ?>
    </p>
  </div>
</div>

<div class="container py-5">
  <?php if (empty($news_list)): ?>
    <div class="card border-0 shadow-sm text-center py-5">
      <div class="card-body">
        <i class="fa-solid fa-newspaper fa-3x text-muted mb-3"></i>
        <h5 class="text-dark"><?= is_malayalam() ? 'നിലവിൽ വാർത്തകൾ ലഭ്യമല്ല' : 'No news articles available' ?></h5>
      </div>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($news_list as $article): ?>
        <div class="col-lg-4 col-md-6">
          <div class="card border-0 shadow-sm h-100">
            <?php if (!empty($article['image'])): ?>
              <img src="<?= e($article['image']) ?>" class="card-img-top" alt="<?= e($article['title_en']) ?>" style="height: 200px; object-fit: cover;">
            <?php else: ?>
              <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                <i class="fa-solid fa-newspaper fa-3x opacity-50"></i>
              </div>
            <?php endif; ?>
            <div class="card-body p-4 d-flex flex-column">
              <div class="small text-muted mb-2">
                <i class="fa-regular fa-calendar me-1"></i>
                <?= date('d M Y', strtotime($article['publish_date'])) ?>
              </div>
              <h5 class="card-title fw-bold text-dark mb-2">
                <a href="<?= url('/news/' . $article['slug']) ?>" class="text-decoration-none text-dark hover-primary">
                  <?= is_malayalam() ? e($article['title_ml']) : e($article['title_en']) ?>
                </a>
              </h5>
              <p class="card-text text-muted small flex-grow-1">
                <?= is_malayalam() ? e($article['excerpt_ml'] ?? '') : e($article['excerpt_en'] ?? '') ?>
              </p>
              <div class="pt-3 border-top mt-auto">
                <a href="<?= url('/news/' . $article['slug']) ?>" class="btn btn-outline-primary btn-sm">
                  <?= is_malayalam() ? 'പൂർണ്ണമായി വായിക്കുക' : 'Read Full Story' ?> <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
