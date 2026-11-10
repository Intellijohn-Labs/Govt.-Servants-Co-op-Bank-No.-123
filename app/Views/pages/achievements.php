<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= url('/about') ?>"><?= __('nav_about') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('nav_achievements') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-award text-warning me-2"></i>
      <?= __('nav_achievements') ?> / <?= is_malayalam() ? 'നേട്ടങ്ങളും നാഴികക്കല്ലുകളും' : 'Milestones & Key Achievements' ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= is_malayalam() 
          ? 'ജനവിശ്വാസത്തിലൂടെയും സുതാര്യമായ ഭരണത്തിലൂടെയും കൈവരിച്ച സുപ്രധാന അംഗീകാരങ്ങളും സ്ഥിതിവിവരക്കണക്കുകളും.' 
          : 'Celebrating decades of financial stability, audit excellence, and community trust in Kerala.' ?>
    </p>
  </div>
</div>

<div class="container py-5">
  <!-- Highlights Stat Counters -->
  <div class="row g-4 mb-5">
    <?php foreach ($achievements as $ach): ?>
      <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm text-center p-4 h-100 border-top border-4 border-primary">
          <div class="mb-3 text-primary">
            <i class="fa-solid <?= e($ach['icon'] ?: 'fa-chart-line') ?> fa-2x"></i>
          </div>
          <div class="display-6 fw-bold text-dark mb-1">
            <?= e($ach['count_value']) ?><small class="text-primary"><?= e($ach['suffix'] ?? '') ?></small>
          </div>
          <div class="text-muted fw-semibold small">
            <?= is_malayalam() ? e($ach['title_ml']) : e($ach['title_en']) ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Key Institutional Honors -->
  <div class="row g-4 align-items-center mb-5">
    <div class="col-lg-6">
      <div class="pe-lg-4">
        <div class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill mb-3">
          <i class="fa-solid fa-certificate me-1"></i> <?= __('Awards & Recognition', 'പുരസ്കാരങ്ങളും അംഗീകാരങ്ങളും') ?>
        </div>
        <h3 class="fw-bold text-dark mb-3"><?= __('Class 1 Bank since August 2021', 'ക്ലാസ്സ് 1 ബാങ്ക് (2021 ആഗസ്റ്റ് മുതൽ)') ?></h3>
        <ul class="list-unstyled text-secondary">
          <li class="mb-2"><i class="fa-solid fa-trophy text-warning me-2" aria-hidden="true"></i><?= __('Best Employees Society (Taluk level, consecutively)', 'മികച്ച എംപ്ലോയീസ് സംഘം (താലൂക്ക് തലത്തിൽ തുടർച്ചയായി)') ?></li>
          <li class="mb-2"><i class="fa-solid fa-medal text-warning me-2" aria-hidden="true"></i><?= __('1st and 2nd positions at District level since 2020-21', '2020-21 വർഷം മുതൽ ജില്ലാതലത്തിൽ ഒന്നും രണ്ടും സ്ഥാനങ്ങൾ') ?></li>
          <li class="mb-2"><i class="fa-solid fa-percent text-warning me-2" aria-hidden="true"></i><?= __('25% dividend consistently distributed to members', 'അംഗങ്ങൾക്ക് 25% ഡിവിഡൻഡ് തുടർച്ചയായി നൽകുന്നു') ?></li>
          <li class="mb-2"><i class="fa-solid fa-solar-panel text-success me-2" aria-hidden="true"></i><?= __('20-KW solar power system installed: an eco-friendly green bank', '20-KW സൗരോർജ്ജ പാനലുകൾ: ഹരിത ബാങ്ക്') ?></li>
        </ul>
        <div class="mt-3 p-3 bg-light rounded-3 border">
          <div class="fw-bold text-dark mb-1"><i class="fa-solid fa-hand-holding-heart text-danger me-2" aria-hidden="true"></i><?= __('Social Commitment', 'സാമൂഹിക പ്രതിബദ്ധത') ?></div>
          <div class="small text-muted"><?= __('Nearly ₹15.5 crore of social security pension distributed.', '15 1/2 കോടിയോളം സാമൂഹ്യ സുരക്ഷാ പെൻഷൻ വിതരണം.') ?></div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card border-0 shadow-sm p-4 bg-light">
        <h5 class="fw-bold text-dark mb-3">
          <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>
          <?= is_malayalam() ? 'വളർച്ചാ നാഴികക്കല്ലുകൾ' : 'Historical Milestones' ?>
        </h5>
        <div class="border-start border-2 border-primary ps-3 ms-2 py-2">
          <div class="mb-3">
            <span class="badge bg-primary">1920</span>
            <div class="fw-bold text-dark mt-1"><?= __('Founded', 'സ്ഥാപിതം') ?></div>
            <div class="small text-muted"><?= __('Founded (Malayalam year 1095) by about twenty government employees of Paravur Taluk.', 'പറവൂർ താലൂക്കിലെ ഇരുപതോളം സർക്കാർ ജീവനക്കാർ ചേർന്ന് സ്ഥാപിച്ചു (മലയാള വർഷം 1095).') ?></div>
          </div>
          <div class="mb-3">
            <span class="badge bg-primary">1985</span>
            <div class="fw-bold text-dark mt-1"><?= __('Upgraded to Class IV', 'ക്ലാസ്സ് IV') ?></div>
            <div class="small text-muted"><?= __('Upgraded to Class IV on 01/07/1985.', '01/07/1985 മുതൽ ക്ലാസ്സ് IV.') ?></div>
          </div>
          <div class="mb-3">
            <span class="badge bg-primary">2000</span>
            <div class="fw-bold text-dark mt-1"><?= __('Own building', 'സ്വന്തം കെട്ടിടം') ?></div>
            <div class="small text-muted"><?= __('Moved to its own building on 31/01/2000.', '31/01/2000 മുതൽ സ്വന്തം കെട്ടിടത്തിൽ പ്രവർത്തനം.') ?></div>
          </div>
          <div class="mb-3">
            <span class="badge bg-primary">2001</span>
            <div class="fw-bold text-dark mt-1"><?= __('Upgraded to Class II', 'ക്ലാസ്സ് II') ?></div>
            <div class="small text-muted"><?= __('Upgraded to Class II on 01/03/2001.', '01/03/2001 മുതൽ ക്ലാസ്സ് II.') ?></div>
          </div>
          <div class="mb-3">
            <span class="badge bg-primary">2020-21</span>
            <div class="fw-bold text-dark mt-1"><?= __('District-level recognition', 'ജില്ലാതല അംഗീകാരം') ?></div>
            <div class="small text-muted"><?= __('1st and 2nd positions at District level since 2020-21.', '2020-21 വർഷം മുതൽ ജില്ലാതലത്തിൽ ഒന്നും രണ്ടും സ്ഥാനങ്ങൾ.') ?></div>
          </div>
          <div>
            <span class="badge bg-success">Aug 2021</span>
            <div class="fw-bold text-dark mt-1"><?= __('Class 1 Bank', 'ക്ലാസ്സ് 1 ബാങ്ക്') ?></div>
            <div class="small text-muted"><?= __('Upgraded to Class 1 from August 2021.', '2021 ആഗസ്റ്റ് മുതൽ ക്ലാസ്സ് 1 ബാങ്ക്.') ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
