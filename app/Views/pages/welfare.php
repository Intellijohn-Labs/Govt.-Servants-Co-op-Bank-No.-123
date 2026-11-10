<div class="bg-light py-4 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= __('nav_home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= __('Member Services', 'സേവനങ്ങൾ') ?></li>
      </ol>
    </nav>
    <h1 class="h2 fw-bold text-dark mb-1">
      <i class="fa-solid fa-store text-primary me-2"></i>
      <?= __('Our Services', 'ഞങ്ങളുടെ സേവനങ്ങൾ') ?>
    </h1>
    <p class="text-muted mb-0 small">
      <?= __('Services run by the institution for government employees and the general public.', 'സർക്കാർ ജീവനക്കാർക്കും പൊതുജനങ്ങൾക്കുമായി സ്ഥാപനം നടത്തുന്ന സേവനങ്ങൾ.') ?>
    </p>
  </div>
</div>

<div class="container py-5">
<?= $this->partial('member_services', ['showHeading' => true]) ?>

  <div class="my-5"></div>

  <!-- Contact CTA -->
  <div class="card border-0 bg-primary text-white shadow-sm p-4 p-md-5">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h4 class="fw-bold mb-2"><?= __('Want to know more?', 'കൂടുതൽ അറിയാൻ') ?></h4>
        <p class="mb-0 text-white opacity-75">
          <?= __('Contact us or visit your nearest branch for details of these services.', 'ഈ സേവനങ്ങളെക്കുറിച്ച് കൂടുതൽ വിവരങ്ങൾക്ക് ഞങ്ങളെ ബന്ധപ്പെടുകയോ അടുത്തുള്ള ശാഖ സന്ദർശിക്കുകയോ ചെയ്യുക.') ?>
        </p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="<?= url('/contact') ?>" class="btn btn-light text-primary fw-bold px-4 py-2 me-2"><?= __('nav_contact') ?></a>
        <a href="<?= url('/branches') ?>" class="btn btn-outline-light px-4 py-2"><?= __('nav_branches') ?></a>
      </div>
    </div>
  </div>
</div>
