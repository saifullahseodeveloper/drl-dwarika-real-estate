<?php
/**
 * About Us Page View — DRL Dwarika Real Estate LLC
 */
$phone = $settings['company_phone'] ?? '+971 54 220 2920';
$cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
$waPhone = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '971542202920');
?>

<!-- Page Banner -->
<div class="page-banner about-hero-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">About Us</li>
      </ol>
    </nav>
    <span class="banner-pill-badge"><i class="fa-solid fa-gem"></i> DUBAI'S PREMIER LUXURY BROKERAGE</span>
    <h1 class="page-banner-title">About Dwarika Real Estate LLC</h1>
    <p class="page-banner-subtitle">
      Opening Doors To Prosperity — Guiding global property seekers, high-net-worth families, and international investors through the dynamic landscape of Dubai real estate.
    </p>
  </div>
</div>

<!-- Story & Heritage Section -->
<section class="about-page-story section-padding">
  <div class="container about-container">
    
    <div class="about-media-col">
      <div class="about-image-card">
        <img src="/assets/images/burj-skyline.jpg" alt="Dubai Downtown Skyline - Burj Khalifa" width="560" height="420" class="about-img" loading="eager">
        <div class="about-experience-badge">
          <span class="badge-num"><?= e($settings['stat_years_experience'] ?? '5+') ?></span>
          <span class="badge-text">Years of Trusted Advisory in Dubai</span>
        </div>
      </div>
    </div>

    <div class="about-text-col">
      <span class="section-badge">— OUR HERITAGE &amp; MISSION —</span>
      <h2 class="section-title">Building Dreams,<br>One Property at a Time</h2>
      
      <p class="about-paragraph">
        DRL Dwarika Real Estate LLC is an officially licensed Dubai real estate brokerage (RERA ORN: <?= e($settings['rera_orn'] ?? '29482') ?>), established with a foundational vision: to deliver world-class real estate services anchored in radical transparency, deep analytical market intelligence, and unyielding client representation.
      </p>

      <p class="about-paragraph">
        Headquartered in Dubai, UAE, we represent private wealth individuals, home buyers, and institutional capital allocators worldwide. Our multilingual advisory team possesses granular fluency in Dubai’s most coveted freehold master communities, including Dubai Hills Estate, Downtown Dubai, Palm Jumeirah, Dubai Creek Harbour, and Jumeirah Village Circle.
      </p>

      <!-- Statistics Counters -->
      <div class="about-stats-row">
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_properties_sold'] ?? '100+') ?></div>
          <div class="stat-label">Properties Transacted</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_happy_clients'] ?? '50+') ?></div>
          <div class="stat-label">Satisfied HNW Clients</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_years_experience'] ?? '5+') ?></div>
          <div class="stat-label">Years Dubai Experience</div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Values Section (What Defines DRL Dwarika) -->
<section class="values-section section-padding surface-bg">
  <div class="container">
    <div class="values-header text-center">
      <span class="section-badge">— OUR CORE VALUES —</span>
      <h2 class="section-title">What Defines DRL Dwarika</h2>
      <p class="section-desc" style="margin: 0 auto 48px;">
        The principles that govern every transaction, client relationship, and advisory engagement we undertake.
      </p>
    </div>

    <div class="values-grid">
      
      <div class="value-card">
        <div class="value-icon-box">
          <i class="fa-solid fa-handshake-angle value-icon"></i>
        </div>
        <h3 class="value-title">Radical Transparency</h3>
        <p class="value-desc">No concealed fees, hidden commissions, or misleading listings. We provide verified property histories, official DLD titles, and transparent escrow frameworks.</p>
        <div class="value-card-highlight">
          <i class="fa-solid fa-check"></i> 100% Verified DLD &amp; RERA Data
        </div>
      </div>

      <div class="value-card">
        <div class="value-icon-box">
          <i class="fa-solid fa-scale-balanced value-icon"></i>
        </div>
        <h3 class="value-title">Fiduciary Integrity</h3>
        <p class="value-desc">We negotiate fiercely on behalf of our clients to secure optimal valuations, pre-launch developer allotments, and flexible payment milestone timelines.</p>
        <div class="value-card-highlight">
          <i class="fa-solid fa-check"></i> Strict Price Protection
        </div>
      </div>

      <div class="value-card">
        <div class="value-icon-box">
          <i class="fa-solid fa-gem value-icon"></i>
        </div>
        <h3 class="value-title">Bespoke Luxury Experience</h3>
        <p class="value-desc">From private airport chauffeurs to personal walkthroughs, golden visa conveyance, and post-handover property asset management, your journey is seamless.</p>
        <div class="value-card-highlight">
          <i class="fa-solid fa-check"></i> White-Glove VIP Concierge
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Leadership CTA Banner -->
<section class="about-cta-section">
  <div class="container">
    <div class="about-cta-box">
      <div class="about-cta-text">
        <span class="cta-pill-label">EXECUTIVE ADVISORY</span>
        <h2 class="about-cta-title">Looking to Acquire or Sell Prime Dubai Property?</h2>
        <p class="about-cta-desc">Connect with our leadership team for a confidential advisory session tailored to your portfolio objectives.</p>
      </div>
      <div class="about-cta-btns">
        <a href="/founders" class="btn-primary-pill">
          <span>Meet Our Leadership</span>
          <i class="fa-solid fa-arrow-right"></i>
        </a>
        <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I would like to schedule an advisory consultation.') ?>" target="_blank" rel="noopener" class="btn-whatsapp">
          <i class="fa-brands fa-whatsapp"></i>
          <span>WhatsApp Us</span>
        </a>
      </div>
    </div>
  </div>
</section>
