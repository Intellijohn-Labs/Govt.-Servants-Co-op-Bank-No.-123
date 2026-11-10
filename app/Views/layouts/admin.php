<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title><?= !empty($title) ? e($title) . ' | ' : '' ?><?= e(bank_name()) ?> CMS</title>

  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- FontAwesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    body {
      font-family: 'Inter', system-ui, sans-serif;
      background-color: #F8FAFC;
      color: #0F172A;
      min-height: 100vh;
    }
    .admin-sidebar {
      width: 260px;
      background-color: #0F172A;
      color: #94A3B8;
      min-height: 100vh;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      overflow-y: auto;
      z-index: 100;
    }
    .admin-main {
      margin-left: 260px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .sidebar-brand {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      color: #FFFFFF;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.7rem 1.5rem;
      color: #94A3B8;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.9rem;
      transition: all 0.2s;
    }
    .sidebar-link:hover, .sidebar-link.active {
      color: #FFFFFF;
      background-color: rgba(255, 255, 255, 0.08);
      border-left: 4px solid #38BDF8;
    }
    .sidebar-heading {
      font-size: 0.75rem;
      text-transform: uppercase;
      font-weight: 700;
      color: #64748B;
      padding: 1.25rem 1.5rem 0.5rem;
      letter-spacing: 0.05em;
    }
    .admin-header {
      background-color: #FFFFFF;
      border-bottom: 1px solid #E2E8F0;
      padding: 0.85rem 1.75rem;
    }
    @media (max-width: 992px) {
      .admin-sidebar {
        margin-left: -260px;
        transition: margin 0.3s;
      }
      .admin-sidebar.show {
        margin-left: 0;
      }
      .admin-main {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
  <!-- Admin Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
      <i class="fa-solid fa-building-columns text-info fa-lg"></i>
      <div>
        <div class="small fw-bold text-white lh-1"><?= e(bank_name()) ?></div>
        <div class="text-muted" style="font-size: 0.7rem;">Control Center</div>
      </div>
    </div>

    <nav class="py-2">
      <div class="sidebar-heading">Operations</div>
      <a href="/admin" class="sidebar-link <?= ($activeNav ?? '') === 'dashboard' ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge fa-fw"></i> Dashboard
      </a>
      <a href="/admin/enquiries" class="sidebar-link <?= ($activeNav ?? '') === 'enquiries' ? 'active' : '' ?>">
        <i class="fa-solid fa-inbox fa-fw"></i> Enquiries & Requests
      </a>
      <a href="/admin/branches" class="sidebar-link <?= ($activeNav ?? '') === 'branches' ? 'active' : '' ?>">
        <i class="fa-solid fa-building fa-fw"></i> Branches & Offices
      </a>

      <div class="sidebar-heading">Financial Catalog</div>
      <a href="/admin/products" class="sidebar-link <?= ($activeNav ?? '') === 'products' ? 'active' : '' ?>">
        <i class="fa-solid fa-piggy-bank fa-fw"></i> Products Catalogue
      </a>
      <a href="/admin/rates" class="sidebar-link <?= ($activeNav ?? '') === 'rates' ? 'active' : '' ?>">
        <i class="fa-solid fa-percent fa-fw"></i> Unified Rate Engine
      </a>

      <div class="sidebar-heading">Publishing & Content</div>
      <a href="/admin/pages" class="sidebar-link <?= ($activeNav ?? '') === 'pages' ? 'active' : '' ?>">
        <i class="fa-solid fa-file-lines fa-fw"></i> Pages
      </a>
      <a href="/admin/banners" class="sidebar-link <?= ($activeNav ?? '') === 'banners' ? 'active' : '' ?>">
        <i class="fa-solid fa-images fa-fw"></i> Banners & Sliders
      </a>
      <a href="/admin/announcements" class="sidebar-link <?= ($activeNav ?? '') === 'announcements' ? 'active' : '' ?>">
        <i class="fa-solid fa-bullhorn fa-fw"></i> Announcements
      </a>
      <a href="/admin/news" class="sidebar-link <?= ($activeNav ?? '') === 'news' ? 'active' : '' ?>">
        <i class="fa-solid fa-newspaper fa-fw"></i> News & Events
      </a>
      <a href="/admin/downloads" class="sidebar-link <?= ($activeNav ?? '') === 'downloads' ? 'active' : '' ?>">
        <i class="fa-solid fa-download fa-fw"></i> Downloads & Forms
      </a>
      <a href="/admin/board" class="sidebar-link <?= ($activeNav ?? '') === 'board' ? 'active' : '' ?>">
        <i class="fa-solid fa-users fa-fw"></i> Board of Directors
      </a>

      <div class="sidebar-heading">Administration</div>
      <a href="/admin/theme" class="sidebar-link <?= ($activeNav ?? '') === 'theme' ? 'active' : '' ?>">
        <i class="fa-solid fa-palette fa-fw"></i> Theming & Presets
      </a>
      <a href="/admin/settings" class="sidebar-link <?= ($activeNav ?? '') === 'settings' ? 'active' : '' ?>">
        <i class="fa-solid fa-sliders fa-fw"></i> Settings & Compliance
      </a>
      <a href="/admin/audit" class="sidebar-link <?= ($activeNav ?? '') === 'audit' ? 'active' : '' ?>">
        <i class="fa-solid fa-shield-halved fa-fw"></i> Audit Log
      </a>
    </nav>
  </aside>

  <!-- Admin Main Wrapper -->
  <div class="admin-main">
    <header class="admin-header d-flex justify-content-between align-items-center">
      <button class="btn btn-outline-secondary btn-sm d-lg-none" type="button" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
        <i class="fa-solid fa-bars"></i>
      </button>

      <div class="d-flex align-items-center gap-2">
        <a href="<?= url('/') ?>" target="_blank" class="btn btn-outline-primary btn-sm fw-semibold">
          <i class="fa-solid fa-globe me-1"></i> View Live Site <i class="fa-solid fa-arrow-up-right-from-square fa-xs ms-1"></i>
        </a>
      </div>

      <div class="d-flex align-items-center gap-3">
        <?php $u = auth_user(); ?>
        <div class="text-end d-none d-sm-block">
          <div class="fw-bold small text-dark"><?= e($u['name'] ?? 'Administrator') ?></div>
          <div class="badge bg-primary-subtle text-primary small"><?= e($u['role_name'] ?? 'Super Admin') ?></div>
        </div>

        <form action="/admin/logout" method="POST" class="m-0">
          <?= csrf_field() ?>
          <button type="submit" class="btn btn-sm btn-outline-danger" title="Logout">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
          </button>
        </form>
      </div>
    </header>

    <main class="p-4 flex-grow-1">
      <!-- Flash Alert Banners -->
      <?php if (flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fa-solid fa-circle-check me-2"></i> <?= e(flash('success')) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (flash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= e(flash('error')) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?= $content ?>
    </main>

    <footer class="p-3 text-center text-muted small bg-white border-top">
      <?= e(setting('legal.verified_legal_name')) ?> CMS &copy; <?= date('Y') ?>
    </footer>
  </div>

  <!-- Bootstrap 5.3 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
