<?php
// $crumbs is an array of ['title' => '...', 'url' => '...']
?>
<?php if (!empty($crumbs)): ?>
  <nav aria-label="breadcrumb" class="bg-light py-2 border-bottom mb-4">
    <div class="container">
      <ol class="breadcrumb mb-0 small" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <a href="<?= url('/') ?>" itemprop="item" class="text-decoration-none text-muted">
            <span itemprop="name"><i class="fa-solid fa-house me-1"></i> <?= __('nav_home') ?></span>
          </a>
          <meta itemprop="position" content="1" />
        </li>
        <?php foreach ($crumbs as $index => $crumb): ?>
          <?php $isLast = ($index === count($crumbs) - 1); ?>
          <li class="breadcrumb-item <?= $isLast ? 'active text-primary fw-semibold' : '' ?>" <?= $isLast ? 'aria-current="page"' : '' ?> itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <?php if (!$isLast && !empty($crumb['url'])): ?>
              <a href="<?= e($crumb['url']) ?>" itemprop="item" class="text-decoration-none text-muted">
                <span itemprop="name"><?= e($crumb['title']) ?></span>
              </a>
            <?php else: ?>
              <span itemprop="name"><?= e($crumb['title']) ?></span>
            <?php endif; ?>
            <meta itemprop="position" content="<?= $index + 2 ?>" />
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </nav>
<?php endif; ?>
