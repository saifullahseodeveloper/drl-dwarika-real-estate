<?php
/**
 * Master Admin Layout
 * DRL Dwarika Real Estate LLC Control Panel
 */
$currentUser = $currentUser ?? ['name' => 'Admin', 'email' => 'admin@dwarikarealestate.ae', 'role' => 'super_admin'];
$curNav = $activeNav ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($meta_title ?? 'Admin Dashboard | DRL Dwarika') ?></title>
  <link rel="icon" type="image/png" href="/assets/images/logo.png">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Admin Styles -->
  <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body">

  <div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="sidebar-brand">
        <a href="/admin/dashboard" class="brand-link">
          <img src="/assets/images/logo-white.svg" alt="DRL Dwarika" width="140" height="48">
        </a>
      </div>

      <nav class="sidebar-nav">
        <div class="nav-group-title">MAIN</div>
        <a href="/admin/dashboard" class="nav-item <?= $curNav === 'dashboard' ? 'active' : '' ?>">
          <i class="fa-solid fa-chart-pie"></i>
          <span>Dashboard</span>
        </a>

        <div class="nav-group-title">REAL ESTATE</div>
        <a href="/admin/properties" class="nav-item <?= $curNav === 'properties' ? 'active' : '' ?>">
          <i class="fa-solid fa-building"></i>
          <span>Properties</span>
        </a>
        <a href="/admin/agents" class="nav-item <?= $curNav === 'agents' ? 'active' : '' ?>">
          <i class="fa-solid fa-users"></i>
          <span>Agents</span>
        </a>
        <a href="/admin/founders" class="nav-item <?= $curNav === 'founders' ? 'active' : '' ?>">
          <i class="fa-solid fa-landmark"></i>
          <span>Founders &amp; Leadership</span>
        </a>
        <a href="/admin/leads" class="nav-item <?= $curNav === 'leads' ? 'active' : '' ?>">
          <i class="fa-solid fa-user-tag"></i>
          <span>Inquiries / Leads</span>
        </a>

        <div class="nav-group-title">CONTENT & TAXONOMY</div>
        <a href="/admin/services" class="nav-item <?= $curNav === 'services' ? 'active' : '' ?>">
          <i class="fa-solid fa-briefcase"></i>
          <span>Services</span>
        </a>
        <a href="/admin/testimonials" class="nav-item <?= $curNav === 'testimonials' ? 'active' : '' ?>">
          <i class="fa-solid fa-comment-dots"></i>
          <span>Testimonials</span>
        </a>
        <a href="/admin/locations" class="nav-item <?= $curNav === 'locations' ? 'active' : '' ?>">
          <i class="fa-solid fa-location-dot"></i>
          <span>Locations</span>
        </a>

        <div class="nav-group-title">SYSTEM & SEO</div>
        <a href="/admin/tools" class="nav-item <?= $curNav === 'tools' ? 'active' : '' ?>">
          <i class="fa-solid fa-calculator"></i>
          <span>Tools &amp; Calculators</span>
        </a>
        <a href="/admin/seo" class="nav-item <?= $curNav === 'seo' ? 'active' : '' ?>">
          <i class="fa-solid fa-magnifying-glass-chart"></i>
          <span>SEO Management</span>
        </a>
        <a href="/admin/settings" class="nav-item <?= $curNav === 'settings' ? 'active' : '' ?>">
          <i class="fa-solid fa-sliders"></i>
          <span>Site Settings</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <a href="/" target="_blank" class="footer-btn view-site">
          <i class="fa-solid fa-arrow-up-right-from-square"></i> View Website
        </a>
        <a href="/admin/logout" class="footer-btn logout-btn">
          <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
        </a>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
      <!-- Top Bar -->
      <header class="admin-topbar">
        <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle Sidebar">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="topbar-search">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" placeholder="Search properties, leads, records..." aria-label="Search admin portal">
        </div>
        <div class="topbar-user">
          <div class="user-avatar"><?= strtoupper(substr($currentUser['name'] ?? 'A', 0, 1)) ?></div>
          <div class="user-meta">
            <span class="user-name"><?= e($currentUser['name'] ?? 'Admin') ?></span>
            <span class="user-role"><?= ucfirst(e($currentUser['role'] ?? 'Super Admin')) ?></span>
          </div>
        </div>
      </header>

      <!-- Alert Flash Messages -->
      <div class="admin-content-wrap">
        <?php if ($flashSuccess = \App\Core\Session::flash('success')): ?>
          <div class="admin-alert success" role="alert">
            <i class="fa-solid fa-circle-check"></i>
            <span><?= e($flashSuccess) ?></span>
          </div>
        <?php endif; ?>
        <?php if ($flashError = \App\Core\Session::flash('error')): ?>
          <div class="admin-alert error" role="alert">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span><?= e($flashError) ?></span>
          </div>
        <?php endif; ?>

        <?= $content ?>
      </div>
    </div>
  </div>

  <script src="/assets/js/admin.js"></script>
</body>
</html>
