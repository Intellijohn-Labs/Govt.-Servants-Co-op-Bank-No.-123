<!DOCTYPE html>
<html lang="<?= e(current_lang()) ?>" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title><?= !empty($meta_title) ? e($meta_title) . ' | ' : '' ?><?= e(setting('legal.approved_public_name', 'Services Co-operative Bank')) ?></title>
  <meta name="description" content="<?= e($meta_desc ?? setting('legal.verified_legal_name', 'Services Co-operative Bank in Kerala')) ?>">

  <!-- Open Graph / Social Meta -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= !empty($meta_title) ? e($meta_title) : e(setting('legal.approved_public_name')) ?>">
  <meta property="og:description" content="<?= e($meta_desc ?? setting('tagline', '')) ?>">
  <meta property="og:url" content="<?= e($app_url . ($_SERVER['REQUEST_URI'] ?? '/')) ?>">

  <!-- SEO Alternate hreflang tags -->
  <?= \Core\I18n::hreflangTags($_SERVER['REQUEST_URI'] ?? '/') ?>

  <!-- Google Fonts: Inter, Poppins, Noto Sans Malayalam, Manjari -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manjari:wght@400;700&family=Noto+Sans+Malayalam:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- FontAwesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Core Stylesheet -->
  <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">

  <!-- Injected White-Label Theme Custom Properties (Overrides stylesheet defaults) -->
  <style id="theme-custom-properties">
    <?= $theme_css ?? '' ?>
  </style>

  <!-- Schema.org FinancialService / LocalBusiness Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "<?= setting('legal.entity_type') === 'licensed_bank' ? 'FinancialService' : 'LocalBusiness' ?>",
    "name": "<?= e(setting('legal.approved_public_name')) ?>",
    "legalName": "<?= e(setting('legal.verified_legal_name')) ?>",
    "description": "<?= e(setting('tagline', 'Co-operative Financial Institution in Kerala')) ?>",
    "url": "<?= e($app_url) ?>",
    "telephone": "<?= e(setting('contact.primary_phone', '')) ?>",
    "email": "<?= e(setting('contact.email', '')) ?>",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "<?= e(setting('contact.head_office_address_en', '')) ?>",
      "addressRegion": "Kerala",
      "addressCountry": "IN"
    }
  }
  </script>
</head>
<body>
  <!-- WCAG Skip to Main Content Link -->
  <a href="#main-content" class="skip-link"><?= __('Skip to main content', 'പ്രധാന ഉള്ളടക്കത്തിലേക്ക് പോവുക') ?></a>

  <!-- Header Landmark -->
  <header role="banner">
    <?= $this->partial('header') ?>
    <?= $this->partial('ticker') ?>
  </header>

  <!-- Main Content Landmark -->
  <main id="main-content" role="main">
    <!-- Flash Notifications -->
    <?php if (flash('success')): ?>
      <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fa-solid fa-circle-check me-2"></i> <?= e(flash('success')) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    <?php endif; ?>

    <?php if (flash('error')): ?>
      <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= e(flash('error')) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    <?php endif; ?>

    <?= $content ?>
  </main>

  <!-- Footer Landmark -->
  <footer role="contentinfo">
    <?= $this->partial('footer') ?>
  </footer>

  <!-- Modal Notices (AGM / Emergency Popups) -->
  <?= $this->partial('modal_notice') ?>

  <!-- Sticky Actions Bar for Mobile -->
  <?= $this->partial('mobile_sticky_bar') ?>

  <!-- Floating WhatsApp Action -->
  <?php if (!empty(setting('contact.whatsapp_number'))): ?>
    <a href="https://wa.me/<?= e(setting('contact.whatsapp_number')) ?>?text=<?= urlencode(__('Hello, I would like to know more about your financial schemes.', 'നമസ്കാരം, നിങ്ങളുടെ പദ്ധതികളെക്കുറിച്ച് കൂടുതൽ അറിയാൻ ആഗ്രഹിക്കുന്നു.')) ?>"
       class="floating-whatsapp"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="<?= __('Chat on WhatsApp', 'വാട്സാപ്പിൽ ബന്ധപ്പെടുക') ?>">
      <i class="fa-brands fa-whatsapp"></i>
    </a>
  <?php endif; ?>

  <!-- Bootstrap 5.3 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- Core JavaScript -->
  <script src="<?= asset('assets/js/main.js') ?>"></script>

  <?= $this->renderStack('scripts') ?>
</body>
</html>
