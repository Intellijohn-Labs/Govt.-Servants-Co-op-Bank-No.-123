<?php
// Fetch active announcements of type 'popup_modal'
$popup = null;
try {
    $now = date('Y-m-d H:i:s');
    $popup = \Core\Database::fetchOne(
        "SELECT * FROM announcements 
         WHERE client_slug = ? AND type = 'popup_modal' AND is_active = 1 
           AND start_date <= ? AND end_date >= ? 
         ORDER BY priority DESC, id DESC LIMIT 1",
        [client_slug(), $now, $now]
    );
} catch (\Throwable $e) {}
?>
<?php if ($popup): ?>
  <div class="modal fade" id="announcementPopupModal" data-notice-id="<?= (int)$popup['id'] ?>" tabindex="-1" aria-labelledby="popupNoticeTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg border-0">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title fs-5" id="popupNoticeTitle">
            <i class="fa-solid fa-bell me-2"></i> <?= is_malayalam() ? e($popup['title_ml']) : e($popup['title_en']) ?>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <p class="mb-3 lead fs-6">
            <?= is_malayalam() ? nl2br(e($popup['message_ml'])) : nl2br(e($popup['message_en'])) ?>
          </p>

          <?php if (!empty($popup['link_url'])): ?>
            <div class="text-end">
              <a href="<?= e($popup['link_url']) ?>" class="btn btn-primary btn-sm">
                <?= __('learn_more') ?> <i class="fa-solid fa-arrow-right ms-1"></i>
              </a>
            </div>
          <?php endif; ?>
        </div>
        <div class="modal-footer bg-light py-2">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><?= __('Close', 'അടയ്ക്കുക') ?></button>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
