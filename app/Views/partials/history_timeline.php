<?php
/**
 * Bank history & milestones life cycle (verified from the bank's official letter).
 * Usage: $this->partial('history_timeline', ['compact' => false|true])
 */
$compact = $compact ?? false;
$ml = is_malayalam();

// [badge, date line EN, date line ML, icon, tone, title EN, title ML, [[point EN, point ML], ...]]
$milestones = [
    ['1920', 'Registered 20-07-1095 (M.E.) · Started 05/08/1095 (M.E.)', 'രജിസ്ട്രേഷൻ 20-07-1095 (മ.വ.) · പ്രവർത്തനം 05/08/1095 (മ.വ.)', 'fa-seedling', 'tl-green',
        'Formation & Beginnings', 'രൂപീകരണം & തുടക്കം', [
            ['About twenty government employees of Paravur Taluk came together and started the institution as the No. 123 Multipurpose Co-operative Society.', 'പറവൂർ താലൂക്കിലെ 20-ഓളം സർക്കാർ ജീവനക്കാർ ചേർന്ന് 123-ാം നമ്പർ വിവിധോദ്ദേശ സഹകരണ സംഘമായി തുടക്കം കുറിച്ചു.'],
            ['In the early years it borrowed from the Central Bank to give loans to members and ran chit funds.', 'ആദ്യകാലങ്ങളിൽ സെൻട്രൽ ബാങ്കിൽ നിന്ന് വായ്പയെടുത്ത് അംഗങ്ങൾക്ക് വായ്പകളും ചിട്ടികളും നൽകി.'],
        ]],
    ['1920 – 2000', '80 years in rented premises', '80 വർഷത്തെ വാടകക്കെട്ടിട പ്രവർത്തനം', 'fa-building', 'tl-slate',
        'Years in Rented Buildings', 'വാടകക്കെട്ടിടത്തിലെ വർഷങ്ങൾ', [
            ['For about 79 years it worked from a small room above a hotel, and then from the K.R. Vijayan Memorial Municipal Complex on rent.', 'ആദ്യ 79 വർഷത്തോളം ഹോട്ടലിനു മുകളിലെ ചെറിയ മുറിയിലും, തുടർന്ന് K.R. വിജയൻ മെമ്മോറിയൽ മുൻസിപ്പൽ കോംപ്ലക്സിലും വാടകയ്ക്ക് പ്രവർത്തിച്ചു.'],
        ]],
    ['1985', '01/07/1985', '01/07/1985', 'fa-arrow-up-right-dots', 'tl-blue',
        'Class IV Status', 'Class IV പദവി', [
            ['Upgraded from Class 5 to Class IV.', 'ക്ലാസ്സ് 5-ൽ നിന്ന് ക്ലാസ്സ് 4 പദവിയിലേക്ക് ഉയർത്തപ്പെട്ടു.'],
        ]],
    ['1991 – 1998', 'Own land and construction', 'സ്വന്തം സ്ഥലവും നിർമ്മാണവും', 'fa-map-location-dot', 'tl-amber',
        'Own Land & Construction', 'സ്വന്തം സ്ഥലവും നിർമ്മാണവും', [
            ['1991: bought 15.350 cents of land west of the Paravur court complex.', '1991-ൽ പറവൂർ കോടതി സമുച്ചയത്തിന് പടിഞ്ഞാറുവശത്തായി 15.350 സെന്റ് സ്ഥലം സ്വന്തമായി വാങ്ങി.'],
            ['1998: on the general body’s decision, construction of its own building began.', '1998-ൽ പൊതുയോഗ തീരുമാനപ്രകാരം സ്വന്തം കെട്ടിട നിർമ്മാണത്തിന് തുടക്കം കുറിച്ചു.'],
        ]],
    ['2000', '31/01/2000', '31/01/2000', 'fa-house-flag', 'tl-green',
        'Into Its Own Building', 'സ്വന്തം കെട്ടിടത്തിലേക്ക്', [
            ['The bank moved its operations into its own newly built head-office building.', 'സ്വന്തമായി നിർമ്മിച്ച ആസ്ഥാന മന്ദിരത്തിലേക്ക് ബാങ്കിന്റെ പ്രവർത്തനം മാറ്റി.'],
        ]],
    ['2001', '01/03/2001', '01/03/2001', 'fa-arrow-up-right-dots', 'tl-blue',
        'Class II Status', 'Class II പദവി', [
            ['Upgraded to Class 2.', 'ക്ലാസ്സ് 2 പദവിയിലേക്ക് ഉയർത്തപ്പെട്ടു.'],
        ]],
    ['2002', 'Employees’ strike', 'ജീവനക്കാരുടെ പണിമുടക്ക്', 'fa-hand-holding-heart', 'tl-red',
        'Strike-time Relief', 'പണിമുടക്ക് ആശ്വാസം', [
            ['During the 2002 employees’ strike, 526 members were given their previous month’s salary as a loan to ease financial hardship.', '2002-ലെ ജീവനക്കാരുടെ പണിമുടക്ക് സമരകാലത്ത് സാമ്പത്തിക ക്ലേശം ഒഴിവാക്കാൻ 526 അംഗങ്ങൾക്ക് മുൻ മാസത്തെ ശമ്പളം വായ്പയായി നൽകി സഹായിച്ചു.'],
        ]],
    ['2003', '', '', 'fa-computer', 'tl-blue',
        'Full Computerisation', 'സമ്പൂർണ്ണ കമ്പ്യൂട്ടർവൽക്കരണം', [
            ['The bank was fully computerised to make services efficient and timely.', 'സേവനങ്ങൾ കാര്യക്ഷമവും സമയബന്ധിതവുമാക്കാൻ ബാങ്ക് പൂർണ്ണമായും കമ്പ്യൂട്ടർവൽക്കരിച്ചു.'],
        ]],
    ['2009', '', '', 'fa-kit-medical', 'tl-red',
        'Neethi Medical Store', 'നീതി മെഡിക്കൽ സ്റ്റോർ', [
            ['The Neethi Medical Store began operating, making medicines, including life-saving drugs, available at reasonable prices.', 'ജീവൻരക്ഷാ മരുന്നുകൾ ഉൾപ്പെടെ മിതമായ നിരക്കിൽ ലഭ്യമാക്കുന്ന നീതി മെഡിക്കൽ സ്റ്റോർ പ്രവർത്തനം ആരംഭിച്ചു.'],
        ]],
    ['2018', '', '', 'fa-solar-panel', 'tl-green',
        'Modernisation & Solar Bank', 'ആധുനികവൽക്കരണവും സോളാർ ബാങ്കും', [
            ['The bank was fully air-conditioned and modern digital facilities were introduced.', 'ബാങ്ക് പൂർണ്ണമായി ശീതീകരിച്ച് ആധുനിക ഡിജിറ്റൽ സൗകര്യങ്ങൾ ഏർപ്പെടുത്തി.'],
            ['20-KW solar power panels were installed, making it an eco-friendly green bank.', '20-KW സൗരോർജ്ജ പാനലുകൾ സ്ഥാപിച്ച് പരിസ്ഥിതി സൗഹൃദ ഗ്രീൻ ബാങ്കായി മാറി.'],
        ]],
    ['2021', 'August 2021', '2021 ആഗസ്റ്റ്', 'fa-award', 'tl-amber',
        'Class 1 Status & Janasevana Kendram', 'Class 1 പദവി & ജനസേവന കേന്ദ്രം', [
            ['Reached Class 1 status.', 'Class 1 പദവി കൈവരിച്ചു.'],
            ['Started the Janasevana Kendram with 300+ online government services.', '300-ൽ പരം ഓൺലൈൻ സർക്കാർ സേവനങ്ങളുമായി ജനസേവന കേന്ദ്രം ആരംഭിച്ചു.'],
        ]],
    ['2023', 'From January 2023', '2023 ജനുവരി മുതൽ', 'fa-utensils', 'tl-amber',
        'Canteen Taken Over', 'കാന്റീൻ ഏറ്റെടുക്കൽ', [
            ['The bank took over the canteen directly, giving jobs to 8 women from disadvantaged backgrounds and serving good-quality food at fair prices.', '8 നിർധന വനിതകൾക്ക് തൊഴിൽ നൽകി ന്യായവിലയ്ക്ക് ഗുണമേന്മയുള്ള ഭക്ഷണം നൽകുന്ന കാന്റീൻ ബാങ്ക് നേരിട്ട് ഏറ്റെടുത്തു.'],
        ]],
];

if ($compact) {
    $pick = [0, 4, 5, 8, 10, 11]; // 1920, 2000, 2001, 2009, 2021, 2023
    ?>
<section id="journey" class="py-5 bg-white border-top" aria-labelledby="journey-title">
  <div class="container">
    <div class="text-center mb-4 mb-lg-5">
      <span class="section-eyebrow"><i class="fa-solid fa-clock-rotate-left"></i> <?= __('Our Journey', 'ഞങ്ങളുടെ യാത്ര') ?></span>
      <h2 id="journey-title" class="section-title text-balance"><?= __('A Century of Service, Milestone by Milestone', 'ഒരു നൂറ്റാണ്ടിന്റെ സേവനം, ഘട്ടം ഘട്ടമായി') ?></h2>
    </div>
    <ol class="tl-compact list-unstyled">
      <?php foreach ($pick as $i): [$badge, , , $icon, $tone, $tEn, $tMl, $points] = $milestones[$i]; ?>
        <li class="tl-compact-item">
          <span class="tl-compact-icon <?= $tone ?>"><i class="fa-solid <?= $icon ?>" aria-hidden="true"></i></span>
          <div>
            <span class="tl-badge"><?= e($badge) ?></span>
            <h3 class="tl-compact-title"><?= e($ml ? $tMl : $tEn) ?></h3>
            <p class="tl-compact-text"><?= e($ml ? $points[0][1] : $points[0][0]) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
    <div class="text-center mt-4">
      <a href="<?= url('/about') ?>#history" class="btn btn-outline-primary px-4"><?= __('View the full history', 'പൂർണ്ണ ചരിത്രം കാണുക') ?> <i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i></a>
    </div>
  </div>
</section>
    <?php
    return;
}
?>
<section id="history" class="py-5" aria-labelledby="history-title">
  <div class="container">
    <div class="text-center mb-4 mb-lg-5">
      <span class="section-eyebrow"><i class="fa-solid fa-clock-rotate-left"></i> <?= __('History & Milestones', 'ചരിത്രവും നാഴികക്കല്ലുകളും') ?></span>
      <h2 id="history-title" class="section-title text-balance"><?= __('Our Life Cycle: From 1920 to Today', 'ഞങ്ങളുടെ ചരിത്ര നാൾവഴി: 1920 മുതൽ ഇന്നുവരെ') ?></h2>
      <p class="section-lead mb-0"><?= __('Key milestones in the journey of the Govt. Servants’ Co-operative Bank No. 123, N. Paravur.', 'സർക്കാർ ജീവനക്കാരുടെ സഹകരണ ബാങ്ക് നമ്പർ 123, എൻ. പറവൂരിന്റെ യാത്രയിലെ പ്രധാന നാഴികക്കല്ലുകൾ.') ?></p>
    </div>

    <ol class="timeline list-unstyled">
      <?php foreach ($milestones as $n => [$badge, $dEn, $dMl, $icon, $tone, $tEn, $tMl, $points]): ?>
        <li class="tl-item">
          <span class="tl-dot <?= $tone ?>" aria-hidden="true"><i class="fa-solid <?= $icon ?>"></i></span>
          <article class="tl-card">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
              <span class="tl-badge"><?= e($badge) ?></span>
              <?php $dateLine = $ml ? $dMl : $dEn; if ($dateLine !== ''): ?>
                <span class="tl-date"><?= e($dateLine) ?></span>
              <?php endif; ?>
            </div>
            <h3 class="tl-title"><?= e($ml ? $tMl : $tEn) ?></h3>
            <ul class="tl-points">
              <?php foreach ($points as [$pEn, $pMl]): ?>
                <li><?= e($ml ? $pMl : $pEn) ?></li>
              <?php endforeach; ?>
            </ul>
          </article>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
