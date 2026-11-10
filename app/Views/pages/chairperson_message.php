<?php
$crumbs = [
    ['title' => __('nav_about'), 'url' => url('/about')],
    ['title' => __('nav_chairperson_msg'), 'url' => '']
];
?>

<?= $this->partial('breadcrumbs', ['crumbs' => $crumbs]) ?>

<?php if (empty($chairperson)): ?>
  <div class="container py-5"><?= $this->partial('coming_soon', ['icon' => 'fa-user-tie']) ?></div>
<?php return; endif; ?>
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        <div class="row align-items-center g-4 mb-4 pb-4 border-bottom">
          <div class="col-md-3 text-center">
            <div class="portrait-frame mx-auto mb-3 bg-secondary d-flex align-items-center justify-content-center text-white fs-1">
              <i class="fa-solid fa-user-tie"></i>
            </div>
            <h5 class="fw-bold mb-1 text-primary"><?= is_malayalam() ? e($chairperson['name_ml']) : e($chairperson['name_en']) ?></h5>
            <div class="badge bg-light text-muted border"><?= is_malayalam() ? e($chairperson['designation_ml']) : e($chairperson['designation_en']) ?></div>
          </div>
          <div class="col-md-9">
            <span class="badge bg-primary text-white mb-2"><?= __('presidents_message_heading') ?></span>
            <h2 class="fw-bold mb-2"><?= is_malayalam() ? 'ജനവിശ്വാസത്തിന്റെ കരുത്തിൽ മുന്നോട്ട്' : 'Building Community Prosperity Through Co-operative Solidarity' ?></h2>
            <div class="text-muted small">
              <i class="fa-solid fa-calendar me-1"></i> <?= date('F Y') ?> | <?= e(bank_name()) ?>
            </div>
          </div>
        </div>

        <div class="content-body lead fs-6 lh-lg text-dark">
          <p>
            <?= is_malayalam() ? nl2br(e($chairperson['message_ml'])) : nl2br(e($chairperson['message_en'])) ?>
          </p>

          <p class="mt-4">
            <?= is_malayalam()
              ? 'ആധുനിക ബാങ്കിംഗ് സൗകര്യങ്ങളോടൊപ്പം തന്നെ സാധാരണക്കാരുടെ സുരക്ഷിതത്വം ഉറപ്പുവരുത്താൻ ഞങ്ങൾ പ്രതിജ്ഞാബദ്ധരാണ്. ഞങ്ങളുടെ പ്രവർത്തനങ്ങളിൽ അർപ്പിച്ച വിശ്വാസത്തിന് എല്ലാ അംഗങ്ങൾക്കും ഹൃദയം നിറഞ്ഞ നന്ദി അറിയിക്കുന്നു.'
              : 'As we navigate changing economic landscapes, our core guiding principle remains unchanged: to stand shoulder-to-shoulder with our members and ensure that financial services remain compassionate, transparent, and universally accessible.' ?>
          </p>

          <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
            <div>
              <div class="fw-bold fs-5 text-primary"><?= is_malayalam() ? e($chairperson['name_ml']) : e($chairperson['name_en']) ?></div>
              <div class="text-muted small"><?= is_malayalam() ? e($chairperson['designation_ml']) : e($chairperson['designation_en']) ?></div>
            </div>
            <div class="text-muted small fst-italic">
              <?= e(bank_name()) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
