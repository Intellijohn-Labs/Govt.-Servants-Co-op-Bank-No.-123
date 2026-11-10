<?php
// Fetch active announcements of type 'ticker'
$ticker = null;
try {
    $now = date('Y-m-d H:i:s');
    $ticker = \Core\Database::fetchOne(
        "SELECT * FROM announcements 
         WHERE client_slug = ? AND type = 'ticker' AND is_active = 1 
           AND start_date <= ? AND end_date >= ? 
         ORDER BY priority DESC, id DESC LIMIT 1",
        [client_slug(), $now, $now]
    );
} catch (\Throwable $e) {}
?>
<?php if ($ticker): ?>
  <div class="announcement-ticker" role="region" aria-label="Important Announcement">
    <div class="container d-flex align-items-center">
      <span class="badge bg-danger text-white me-2 px-2 py-1 text-uppercase fw-bold" style="font-size: 0.75rem;">
        <i class="fa-solid fa-bullhorn me-1"></i> <?= is_malayalam() ? e($ticker['title_ml']) : e($ticker['title_en']) ?>
      </span>
      <div class="overflow-hidden flex-grow-1">
        <div class="ticker-content fw-medium">
          <?= is_malayalam() ? e($ticker['message_ml']) : e($ticker['message_en']) ?>
          <?php if (!empty($ticker['link_url'])): ?>
            <a href="<?= e($ticker['link_url']) ?>" class="ms-2 text-decoration-underline text-danger fw-bold"><?= __('learn_more') ?> &rarr;</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
