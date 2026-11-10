<?php /** Minimal placeholder shown until authentic content is published. Optional: $icon */ ?>
<div class="empty-state table-card mx-auto" style="max-width: 560px;">
  <i class="fa-solid <?= e($icon ?? 'fa-hourglass-half') ?> d-block" aria-hidden="true"></i>
  <div class="h5 fw-bold text-dark mb-1"><?= __('Updates coming soon', 'വിവരങ്ങൾ ഉടൻ ലഭ്യമാകും') ?></div>
  <div class="small"><?= __('This section will be updated shortly.', 'ഈ വിഭാഗം ഉടൻ അപ്ഡേറ്റ് ചെയ്യുന്നതാണ്.') ?></div>
</div>
