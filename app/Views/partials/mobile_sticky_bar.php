<!-- Mobile Sticky Action Bar -->
<div class="mobile-sticky-bar d-md-none" role="navigation" aria-label="Mobile Quick Actions">
  <?php if (!empty(setting('contact.primary_phone'))): ?>
    <a href="tel:<?= e(setting('contact.primary_phone')) ?>" class="btn btn-outline-primary btn-sm flex-fill me-1">
      <i class="fa-solid fa-phone me-1"></i> <?= __('Call', 'വിളിക്കുക') ?>
    </a>
  <?php endif; ?>

  <?php if (!empty(setting('contact.whatsapp_number'))): ?>
    <a href="https://wa.me/<?= e(setting('contact.whatsapp_number')) ?>" class="btn btn-success btn-sm flex-fill me-1" target="_blank" rel="noopener noreferrer">
      <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
    </a>
  <?php endif; ?>

  <a href="<?= url('/calculators') ?>" class="btn btn-warning btn-sm flex-fill me-1 text-dark">
    <i class="fa-solid fa-calculator me-1"></i> EMI
  </a>

  <a href="<?= url('/branches') ?>" class="btn btn-primary btn-sm flex-fill">
    <i class="fa-solid fa-location-dot me-1"></i> <?= __('Branches', 'ശാഖകൾ') ?>
  </a>
</div>
