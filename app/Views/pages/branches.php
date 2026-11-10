<?php
$crumbs = [
    ['title' => __('nav_branches'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<!-- Leaflet CSS for OpenStreetMap -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<div class="container py-4">
  <div class="text-center max-w-700 mx-auto mb-4">
    <span class="badge bg-primary text-white mb-2"><?= __('Physical Network', 'ശാഖാ ശൃംഖല') ?></span>
    <h1 class="fw-bold mb-2"><?= __('Branch & Office Network', 'ശാഖാ വിവരങ്ങൾ') ?></h1>
    <p class="text-muted">
      <?= __('Locate our fully computerized branches and service counters across the operational territory.', 'നിങ്ങൾക്ക് ഏറ്റവും അടുത്തുള്ള ശാഖ സന്ദർശിക്കുക.') ?>
    </p>
  </div>

  <!-- Search & Filter Controls -->
  <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-light">
    <form action="<?= url('/branches') ?>" method="GET" class="row g-2 align-items-center">
      <div class="col-md-5">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
          <input type="text" name="q" class="form-control border-start-0" placeholder="<?= __('Search by branch name, place, or district...', 'ശാഖയുടെ പേര് അല്ലെങ്കിൽ സ്ഥലം തിരയുക...') ?>" value="<?= e($search_query ?? '') ?>">
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="locker" value="1" id="filterLocker" <?= !empty($filter_locker) ? 'checked' : '' ?> onchange="this.form.submit()">
          <label class="form-check-label small fw-semibold" for="filterLocker">
            <i class="fa-solid fa-vault text-primary me-1"></i> <?= __('Safe Lockers Only', 'ലോക്കർ സൗകര്യമുള്ളവ') ?>
          </label>
        </div>
      </div>
      <div class="col-sm-6 col-md-2">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="365" value="1" id="filter365" <?= !empty($filter_365) ? 'checked' : '' ?> onchange="this.form.submit()">
          <label class="form-check-label small fw-semibold" for="filter365">
            <i class="fa-solid fa-clock text-warning me-1"></i> <?= __('365 Days Only', '365 ദിവസവും') ?>
          </label>
        </div>
      </div>
      <div class="col-md-2 text-end">
        <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold"><?= __('Filter', 'തിരയുക') ?></button>
      </div>
    </form>
  </div>

  <!-- Interactive OpenStreetMap Container -->
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div id="branchMap" style="height: 380px; width: 100%; z-index: 10;"></div>
  </div>

  <!-- Branch Cards Grid -->
  <div class="row g-4">
    <?php if (!empty($branches)): ?>
      <?php foreach ($branches as $br): ?>
        <div class="col-md-6">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 border-start border-4 <?= !empty($br['is_head_office']) ? 'border-primary' : 'border-secondary' ?>">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="fw-bold text-dark mb-0">
                <?= is_malayalam() ? e($br['name_ml']) : e($br['name_en']) ?>
              </h5>
              <?php if (!empty($br['is_head_office'])): ?>
                <span class="badge bg-primary text-white small"><?= __('Head Office', 'ഹെഡ് ഓഫീസ്') ?></span>
              <?php endif; ?>
            </div>

            <!-- Branch Amenities Badges -->
            <div class="d-flex flex-wrap gap-1 mb-3">
              <?php if (!empty($br['has_365_days'])): ?>
                <span class="badge bg-warning text-dark small"><i class="fa-solid fa-clock me-1"></i> 365 Days</span>
              <?php endif; ?>
              <?php if (!empty($br['has_locker'])): ?>
                <span class="badge bg-info-subtle text-info-emphasis small"><i class="fa-solid fa-vault me-1"></i> Locker</span>
              <?php endif; ?>
              <?php if (!empty($br['has_gold_loan'])): ?>
                <span class="badge bg-light text-muted border small"><i class="fa-solid fa-coins me-1"></i> Gold Loan</span>
              <?php endif; ?>
            </div>

            <p class="small text-muted mb-2">
              <i class="fa-solid fa-location-dot text-danger me-1"></i>
              <?= is_malayalam() ? e($br['address_ml']) : e($br['address_en']) ?>
            </p>

            <div class="small text-muted mb-3">
              <i class="fa-solid fa-clock text-warning me-1"></i>
              <strong><?= __('Timings', 'പ്രവർത്തന സമയം') ?>:</strong> <?= is_malayalam() ? e($br['working_hours_ml']) : e($br['working_hours_en']) ?>
            </div>

            <?php if (!empty($br['manager_name'])): ?>
              <div class="small text-muted mb-3 pb-2 border-bottom">
                <i class="fa-solid fa-user-tie text-primary me-1"></i>
                <strong><?= __('Branch Manager', 'മാനേജർ') ?>:</strong> <?= e($br['manager_name']) ?>
                <?php if (!empty($br['manager_phone'])): ?>
                  (<?= e($br['manager_phone']) ?>)
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <div class="d-flex gap-2 mt-auto pt-2">
              <a href="tel:<?= e($br['phone']) ?>" class="btn btn-outline-primary btn-sm flex-fill fw-bold">
                <i class="fa-solid fa-phone me-1"></i> <?= e($br['phone']) ?>
              </a>
              <?php if (!empty($br['latitude']) && !empty($br['longitude'])): ?>
                <a href="https://www.google.com/maps?q=<?= e($br['latitude']) ?>,<?= e($br['longitude']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm fw-bold">
                  <i class="fa-solid fa-directions me-1"></i> <?= __('Directions', 'റൂട്ട്') ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12 text-center py-5 text-muted">
        <i class="fa-solid fa-circle-question fa-3x mb-3 text-secondary"></i>
        <h5><?= __('No branches match your search criteria.', 'ശാഖകൾ കണ്ടെത്താനായില്ല.') ?></h5>
        <a href="<?= url('/branches') ?>" class="btn btn-outline-primary btn-sm mt-2"><?= __('Clear Filter', 'ഫിൽട്ടർ ഒഴിവാക്കുക') ?></a>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Leaflet JavaScript Bundle -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<?php $this->push('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const mapElement = document.getElementById('branchMap');
  if (!mapElement) return;

  const branches = <?= json_encode($branches ?? []) ?>;

  // Default coordinate (Kerala region)
  let defaultLat = 10.1450;
  let defaultLng = 76.2250;

  if (branches.length > 0 && branches[0].latitude) {
    defaultLat = parseFloat(branches[0].latitude);
    defaultLng = parseFloat(branches[0].longitude);
  }

  const map = L.map('branchMap').setView([defaultLat, defaultLng], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  const bounds = [];
  branches.forEach(b => {
    if (b.latitude && b.longitude) {
      const lat = parseFloat(b.latitude);
      const lng = parseFloat(b.longitude);
      bounds.push([lat, lng]);

      const title = <?= is_malayalam() ? 'b.name_ml' : 'b.name_en' ?> || b.name_en;
      const addr = <?= is_malayalam() ? 'b.address_ml' : 'b.address_en' ?> || b.address_en;
      const phone = b.phone ? `<br><a href="tel:${b.phone}">${b.phone}</a>` : '';

      L.marker([lat, lng])
        .addTo(map)
        .bindPopup(`<strong>${title}</strong><br>${addr || ''}${phone}`);
    }
  });

  if (bounds.length > 1) {
    map.fitBounds(bounds, { padding: [30, 30] });
  }
});
</script>
<?php $this->endPush(); ?>
