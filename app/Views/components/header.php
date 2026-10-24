<?php
/**
 * Header Component — Exact match to DRL Dwarika reference design
 */
$phone = $settings['company_phone'] ?? '+971 542202920';
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

    <!-- Header Actions (Currency Switcher + Call Us Pill Button) -->
    <div class="header-actions">
      <!-- Currency Switcher Dropdown -->
      <div class="currency-selector-wrap" id="currencySelectorWrap">
        <button type="button" class="currency-btn" id="currencyDropdownBtn" aria-haspopup="listbox" aria-expanded="false" aria-label="Select Currency">
          <span class="currency-flag" id="currentCurrencyFlag">🇦🇪</span>
          <span class="currency-code" id="currentCurrencyCode">AED</span>
          <i class="fa-solid fa-chevron-down currency-chevron" aria-hidden="true"></i>
        </button>
        <ul class="currency-dropdown" id="currencyDropdown" role="listbox" aria-label="Currency options">
          <li class="currency-option active" data-currency="AED" role="option" aria-selected="true">
            <span class="currency-flag">🇦🇪</span>
            <span class="currency-name">AED</span>
            <span class="currency-desc">UAE Dirham</span>
          </li>
          <li class="currency-option" data-currency="USD" role="option" aria-selected="false">
            <span class="currency-flag">🇺🇸</span>
            <span class="currency-name">USD</span>
            <span class="currency-desc">US Dollar ($)</span>
          </li>
          <li class="currency-option" data-currency="EUR" role="option" aria-selected="false">
            <span class="currency-flag">🇪🇺</span>
            <span class="currency-name">EUR</span>
            <span class="currency-desc">Euro (€)</span>
          </li>
          <li class="currency-option" data-currency="GBP" role="option" aria-selected="false">
            <span class="currency-flag">🇬🇧</span>
            <span class="currency-name">GBP</span>
            <span class="currency-desc">British Pound (£)</span>
          </li>
          <li class="currency-option" data-currency="INR" role="option" aria-selected="false">
            <span class="currency-flag">🇮🇳</span>
            <span class="currency-name">INR</span>
            <span class="currency-desc">Indian Rupee (₹)</span>
          </li>
          <li class="currency-option" data-currency="SAR" role="option" aria-selected="false">
            <span class="currency-flag">🇸🇦</span>
            <span class="currency-name">SAR</span>
            <span class="currency-desc">Saudi Riyal</span>
          </li>
          <li class="currency-option" data-currency="RUB" role="option" aria-selected="false">
            <span class="currency-flag">🇷🇺</span>
            <span class="currency-name">RUB</span>
            <span class="currency-desc">Russian Ruble (₽)</span>
          </li>
        </ul>
      </div>

      <a href="tel:<?= $cleanPhone ?>" class="btn-call" id="btnCallUs">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
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

    <!-- Mobile Currency Selector -->
    <div class="mobile-currency-wrap">
      <label for="mobileCurrencySelect" class="mobile-currency-label">
        <i class="fa-solid fa-coins"></i> Currency
      </label>
      <div class="mobile-currency-select-box">
        <select id="mobileCurrencySelect" class="mobile-currency-select" aria-label="Select Currency">
          <option value="AED">🇦🇪 AED — UAE Dirham</option>
          <option value="USD">🇺🇸 USD — US Dollar ($)</option>
          <option value="EUR">🇪🇺 EUR — Euro (€)</option>
          <option value="GBP">🇬🇧 GBP — British Pound (£)</option>
          <option value="INR">🇮🇳 INR — Indian Rupee (₹)</option>
          <option value="SAR">🇸🇦 SAR — Saudi Riyal</option>
          <option value="RUB">🇷🇺 RUB — Russian Ruble (₽)</option>
        </select>
        <i class="fa-solid fa-chevron-down mobile-select-arrow" aria-hidden="true"></i>
      </div>
    </div>

    <div class="mobile-drawer-footer">
      <a href="tel:<?= $cleanPhone ?>" class="btn-call full-width">
        <i class="fa-solid fa-phone"></i> Call <?= e($phone) ?>
      </a>
      <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '971542202920') ?>" class="btn-whatsapp full-width" target="_blank" rel="noopener">
        <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
      </a>
    </div>
  </div>
  <div class="mobile-backdrop" id="mobileBackdrop"></div>
</header>
