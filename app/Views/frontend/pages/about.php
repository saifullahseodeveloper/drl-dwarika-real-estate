<?php
/**
 * About Us Page View — DRL Dwarika Real Estate LLC
 */
?>

<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">About Us</li>
      </ol>
    </nav>
    <h1 class="page-banner-title">About Dwarika Real Estate LLC</h1>
    <p class="page-banner-subtitle">Opening Doors To Prosperity — Guiding global property seekers, families, and international investors through the dynamic landscape of Dubai real estate.</p>
  </div>
</div>

<section class="about-page-story section-padding">
  <div class="container about-container">
    
    <div class="about-media-col">
      <div class="about-image-card">
        <img src="/assets/images/burj-skyline.jpg" alt="Dubai Downtown Skyline - Burj Khalifa" width="560" height="380" class="about-img">
        <div class="handwritten-sticker">
          <span>Your Trusted<br>Real Estate Partner<br>in Dubai</span>
        </div>
      </div>
    </div>

    <div class="about-text-col">
      <span class="section-badge">— OUR HERITAGE &amp; MISSION —</span>
      <h2 class="section-title">Building Dreams,<br>One Property at a Time</h2>
      
      <p class="about-paragraph">
        DRL Dwarika Real Estate LLC is an officially licensed Dubai real estate brokerage (RERA ORN: <?= e($settings['rera_orn'] ?? '29482') ?>), established with a single foundational vision: to deliver world-class real estate services anchored in transparency, deep market knowledge, and unyielding client dedication.
      </p>

      <p class="about-paragraph">
        Headquartered in Business Bay, Dubai, we serve high-net-worth individuals, first-time home buyers, and institutional capital allocators worldwide. Our multilingual advisory team possesses granular fluency in Dubai’s premier freehold zones, including Dubai Hills Estate, Downtown Dubai, Palm Jumeirah, and Jumeirah Village Circle.
      </p>

      <!-- Statistics Counters -->
      <div class="about-stats-row">
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_properties_sold'] ?? '100+') ?></div>
          <div class="stat-label">Properties Sold</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_happy_clients'] ?? '50+') ?></div>
          <div class="stat-label">Happy Clients</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_years_experience'] ?? '5+') ?></div>
          <div class="stat-label">Years Experience</div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Values Section -->
<section class="values-section section-padding surface-bg">
  <div class="container text-center">
    <span class="section-badge">— OUR CORE VALUES —</span>
    <h2 class="section-title">What Defines DRL Dwarika</h2>

    <div class="values-grid">
      <div class="value-card">
        <div class="value-icon"><i class="fa-solid fa-handshake-angle"></i></div>
        <h3>Radical Transparency</h3>
        <p>No concealed fees, hidden commissions, or misleading listings. We provide verified property histories and clear escrow frameworks.</p>
      </div>

      <div class="value-card">
        <div class="value-icon"><i class="fa-solid fa-scale-balanced"></i></div>
        <h3>Fiduciary Integrity</h3>
        <p>We negotiate fiercely on behalf of our clients to secure optimal valuations, terms, and payment milestone timelines.</p>
      </div>

      <div class="value-card">
        <div class="value-icon"><i class="fa-solid fa-gem"></i></div>
        <h3>Bespoke Luxury Experience</h3>
        <p>From private airport chauffeurs to personal walkthroughs and post-handover property asset management, your journey is seamless.</p>
      </div>
    </div>
  </div>
</section>
