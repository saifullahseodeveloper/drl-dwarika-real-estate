<?php
/**
 * Header Component — Exact match to DRL Dwarika reference design
 */
$phone = $settings['company_phone'] ?? '+971 50 123 4567';
$cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
$currentNav = $activeNav ?? 'home';
?>
<header class="site-header" id="siteHeader">
  <div class="header-inner container">
    <!-- Brand Logo -->
    <a href="/" class="brand-logo" aria-label="DRL Dwarika Real Estate Home">
      <img src="/assets/images/logo.svg" alt="DRL Dwarika Real Estate LLC - Opening Doors To Prosperity" width="200" height="48" class="logo-img">
    </a>

    <!-- Desktop Navigation Menu -->
    <nav class="main-nav" aria-label="Main Navigation">
      <ul class="nav-list">
        <li class="nav-item">
          <a href="/" class="nav-link <?= $currentNav === 'home' ? 'active' : '' ?>">Home</a>
        </li>
        <li class="nav-item">
          <a href="/about-us" class="nav-link <?= $currentNav === 'about' ? 'active' : '' ?>">About Us</a>
        </li>
        <li class="nav-item">
          <a href="/founders" class="nav-link <?= $currentNav === 'founders' ? 'active' : '' ?>">Founders</a>
        </li>
        <li class="nav-item has-dropdown">
          <a href="/properties" class="nav-link <?= in_array($currentNav, ['properties', 'buy', 'rent', 'off-plan', 'commercial']) ? 'active' : '' ?>">
            Properties <i class="fa-solid fa-chevron-down nav-arrow"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="/properties">All Properties</a></li>
            <li><a href="/properties/buy">Properties for Sale</a></li>
            <li><a href="/properties/rent">Properties for Rent</a></li>
            <li><a href="/properties/off-plan">Off-Plan Projects</a></li>
            <li><a href="/properties/commercial">Commercial Real Estate</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/agents" class="nav-link <?= $currentNav === 'agents' ? 'active' : '' ?>">Agents</a>
        </li>
        <li class="nav-item">
          <a href="/services" class="nav-link <?= $currentNav === 'services' ? 'active' : '' ?>">Services</a>
        </li>
        <li class="nav-item">
          <a href="/contact-us" class="nav-link <?= $currentNav === 'contact' ? 'active' : '' ?>">Contact Us</a>
        </li>
      </ul>
    </nav>

    <!-- Header Actions (Call Us Pill Button) -->
    <div class="header-actions">
      <a href="tel:<?= $cleanPhone ?>" class="btn-call" id="btnCallUs">
        <i class="fa-solid fa-phone"></i>
        <span>Call Us</span>
      </a>

      <!-- Mobile Hamburger Button -->
      <button type="button" class="mobile-toggle-btn" id="mobileMenuBtn" aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>
    </div>
  </div>

  <!-- Mobile Drawer Menu -->
  <div class="mobile-drawer" id="mobileDrawer">
    <div class="mobile-drawer-header">
      <img src="/assets/images/logo.svg" alt="DRL Dwarika Real Estate" width="160" height="40">
      <button type="button" class="mobile-close-btn" id="mobileDrawerClose" aria-label="Close menu">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <ul class="mobile-nav-list">
      <li><a href="/" class="<?= $currentNav === 'home' ? 'active' : '' ?>">Home</a></li>
      <li class="mobile-has-sub">
        <a href="/about-us">About Us</a>
        <ul class="mobile-sub-menu">
          <li><a href="/about-us">Our Story &amp; Presence</a></li>
          <li><a href="/founders">Founders &amp; Leadership</a></li>
        </ul>
      </li>
      <li class="mobile-has-sub">
        <a href="/properties">Properties</a>
        <ul class="mobile-sub-menu">
          <li><a href="/properties/buy">Properties for Sale</a></li>
          <li><a href="/properties/rent">Properties for Rent</a></li>
          <li><a href="/properties/off-plan">Off-Plan Projects</a></li>
          <li><a href="/properties/commercial">Commercial Properties</a></li>
        </ul>
      </li>
      <li><a href="/agents" class="<?= $currentNav === 'agents' ? 'active' : '' ?>">Agents</a></li>
      <li><a href="/services" class="<?= $currentNav === 'services' ? 'active' : '' ?>">Services</a></li>
      <li><a href="/testimonials" class="<?= $currentNav === 'testimonials' ? 'active' : '' ?>">Testimonials</a></li>
      <li><a href="/contact-us" class="<?= $currentNav === 'contact' ? 'active' : '' ?>">Contact Us</a></li>
    </ul>
    <div class="mobile-drawer-footer">
      <a href="tel:<?= $cleanPhone ?>" class="btn-call full-width">
        <i class="fa-solid fa-phone"></i> Call <?= e($phone) ?>
      </a>
      <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '971501234567') ?>" class="btn-whatsapp full-width" target="_blank" rel="noopener">
        <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
      </a>
    </div>
  </div>
  <div class="mobile-backdrop" id="mobileBackdrop"></div>
</header>
