<?php
/**
 * About Us Page View — DRL Dwarika Real Estate LLC
 * Master Luxury Real Estate Heritage & Company Story
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

    <!-- Trust Stats Strip -->
    <div class="services-trust-strip">
      <div class="trust-strip-item">
        <i class="fa-solid fa-shield-halved"></i>
        <span>RERA ORN: <?= e($settings['rera_orn'] ?? '29482') ?></span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-award"></i>
        <span>DLD Licensed Advisory</span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-handshake"></i>
        <span>Prime Developer Partner</span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-passport"></i>
        <span>10-Yr Golden Visa Desk</span>
      </div>
    </div>
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
        DRL Dwarika Real Estate LLC is an officially licensed Dubai real estate brokerage (RERA ORN: <?= e($settings['rera_orn'] ?? '29482') ?>), established with a foundational vision: to deliver world-class real estate advisory anchored in radical transparency, deep analytical market intelligence, and unyielding client representation.
      </p>

      <p class="about-paragraph">
        Headquartered in Dubai, UAE, we represent private wealth individuals, family offices, and first-time home buyers worldwide. Our multilingual advisory team possesses granular fluency in Dubai’s premier freehold master communities, including Dubai Hills Estate, Downtown Dubai, Palm Jumeirah, Dubai Creek Harbour, and Business Bay.
      </p>

      <!-- Statistics Counters Row -->
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
        <div class="stat-divider"></div>
        <div class="stat-card">
          <div class="stat-number">100%</div>
          <div class="stat-label">Escrow Protected</div>
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
        The foundational principles that govern every transaction, client relationship, and advisory engagement we undertake.
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
          <i class="fa-solid fa-circle-check"></i> 100% Verified DLD &amp; RERA Data
        </div>
      </div>

      <div class="value-card">
        <div class="value-icon-box">
          <i class="fa-solid fa-scale-balanced value-icon"></i>
        </div>
        <h3 class="value-title">Fiduciary Integrity</h3>
        <p class="value-desc">We negotiate fiercely on behalf of our clients to secure optimal valuations, pre-launch developer allotments, and flexible payment milestone timelines.</p>
        <div class="value-card-highlight">
          <i class="fa-solid fa-circle-check"></i> Strict Price Protection
        </div>
      </div>

      <div class="value-card">
        <div class="value-icon-box">
          <i class="fa-solid fa-gem value-icon"></i>
        </div>
        <h3 class="value-title">Bespoke Luxury Experience</h3>
        <p class="value-desc">From private airport chauffeurs to personal walkthroughs, golden visa conveyance, and post-handover property asset management, your journey is seamless.</p>
        <div class="value-card-highlight">
          <i class="fa-solid fa-circle-check"></i> White-Glove VIP Concierge
        </div>
      </div>

    </div>
  </div>
</section>

<!-- The Dwarika Advantage Section -->
<section class="services-trust-section section-padding">
  <div class="container text-center">
    <span class="section-badge">— THE DWARIKA ADVANTAGE —</span>
    <h2 class="section-title">Why Dubai’s Discerning Clients Partner With Us</h2>
    <p class="section-desc" style="margin: 0 auto 50px;">
      Delivering institutional-grade analytics, priority developer allotments, and high-touch private client representation.
    </p>
    
    <div class="advantage-grid">
      <div class="adv-card">
        <div class="adv-icon-box">
          <i class="fa-solid fa-file-contract adv-icon"></i>
        </div>
        <h3>DLD &amp; RERA Compliant</h3>
        <p>Every transaction, escrow agreement, and sales contract adheres strictly to Dubai Land Department regulations with zero hidden fees.</p>
      </div>

      <div class="adv-card">
        <div class="adv-icon-box">
          <i class="fa-solid fa-award adv-icon"></i>
        </div>
        <h3>Prime Developer Access</h3>
        <p>Direct pre-launch allocation and priority booking units with Emaar, Nakheel, Damac, Sobha, Meraas, and Omniyat.</p>
      </div>

      <div class="adv-card">
        <div class="adv-icon-box">
          <i class="fa-solid fa-passport adv-icon"></i>
        </div>
        <h3>10-Year Golden Visa Advisory</h3>
        <p>Strategic qualification for UAE Golden Residency via qualifying AED 2M+ freehold property purchases with complete government conveyance.</p>
      </div>

      <div class="adv-card">
        <div class="adv-icon-box">
          <i class="fa-solid fa-hand-holding-hand adv-icon"></i>
        </div>
        <h3>Lifecycle Concierge</h3>
        <p>Post-handover property asset management, snagging inspections, tenant screening, and mortgage facilitation under one roof.</p>
      </div>
    </div>
  </div>
</section>

<!-- Founder Spotlight Card -->
<section class="about-founder-spotlight section-padding surface-bg">
  <div class="container">
    <div class="founder-spotlight-card">
      <div class="founder-photo-col">
        <img src="/assets/images/founders/founder-nitin-saxena.jpg" alt="Nitin Saxena - Founder of DRL Dwarika Real Estate LLC" class="founder-photo">
      </div>
      <div class="founder-quote-col">
        <span class="section-badge">— LEADERSHIP VISION —</span>
        <h3 class="founder-quote-title">&ldquo;Opening Doors to Prosperity Across Dubai&rdquo;</h3>
        <p class="founder-quote-text">
          &ldquo;At DRL – Dwarika Real Estate LLC, our vision goes beyond property transactions. We strive to create lasting relationships, build trust, and open doors to opportunities that help our clients achieve their dreams. Every client deserves transparency, professionalism, and a personalized approach, and these principles remain at the heart of everything we do.&rdquo;
        </p>
        <div class="founder-signoff">
          <strong>Nitin Saxena</strong>
          <span>Founder &amp; Managing Director — DRL Dwarika Real Estate LLC</span>
        </div>
        <div class="founder-cta-row">
          <a href="/founders" class="btn-primary-pill">
            <span>Explore Leadership Profiles</span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Bottom VIP Consultation Banner -->
<section class="services-vip-cta-section">
  <div class="container">
    <div class="vip-cta-card">
      <div class="vip-cta-content">
        <span class="cta-pill-label">CONFIDENTIAL ADVISORY</span>
        <h2 class="vip-cta-title">Ready to Discuss Your Property Objectives in Dubai?</h2>
        <p class="vip-cta-desc">
          Connect directly with our senior consultants for unbiased market insights, off-market opportunities, or portfolio structuring.
        </p>
      </div>
      <div class="vip-cta-actions">
        <a href="tel:<?= $cleanPhone ?>" class="btn-primary-pill">
          <i class="fa-solid fa-phone"></i>
          <span>Call <?= e($settings['company_phone'] ?? '+971 54 220 2920') ?></span>
        </a>
        <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I would like to book a private real estate consultation.') ?>" target="_blank" rel="noopener" class="btn-whatsapp">
          <i class="fa-brands fa-whatsapp"></i>
          <span>WhatsApp Private Desk</span>
        </a>
      </div>
    </div>
  </div>
</section>
