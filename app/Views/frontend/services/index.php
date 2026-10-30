<?php
/**
 * Services Index View — Comprehensive Luxury Real Estate Services
 * DRL Dwarika Real Estate LLC
 */
$cleanPhone = preg_replace('/[^0-9+]/', '', $settings['company_phone'] ?? '+971542202920');
$waPhone    = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '971542202920');
?>

<!-- Page Banner -->
<div class="page-banner services-hero-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">Services</li>
      </ol>
    </nav>
    <span class="banner-pill-badge"><i class="fa-solid fa-gem"></i> BESPOKE DUBAI REAL ESTATE ADVISORY</span>
    <h1 class="page-banner-title">Our Real Estate Services</h1>
    <p class="page-banner-subtitle">
      From private home acquisitions and high-valuation asset sales to regulatory consultancy and high-yield portfolio structuring, DRL Dwarika delivers bespoke excellence across Dubai.
    </p>

    <!-- Quick Trust Badges Strip -->
    <div class="services-trust-strip">
      <div class="trust-strip-item">
        <i class="fa-solid fa-shield-halved"></i>
        <span>RERA &amp; DLD Certified</span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-handshake"></i>
        <span>Tier-1 Developer Access</span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-passport"></i>
        <span>10-Yr Golden Visa Specialist</span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-percent"></i>
        <span>0% Buyer Fee on Off-Plan</span>
      </div>
    </div>
  </div>
</div>

<!-- Main Services Section -->
<section class="services-overview-section section-padding">
  <div class="container">
    
    <div class="services-header-intro text-center">
      <span class="section-badge">— WHAT WE DO —</span>
      <h2 class="section-title">Tailored Solutions for Every Property Ambition</h2>
      <p class="section-desc" style="margin: 0 auto 40px;">
        Every client engagement is supported by rigorous market analytics, licensed RERA compliance, and direct relationships with the UAE's premier developers.
      </p>
    </div>

    <div class="services-cards-grid">
      <?php foreach ($services as $srv): 
        $benefits = json_decode($srv['benefits'] ?? '[]', true) ?: [];
        $icon = match($srv['slug']) {
          'buy-property'         => 'fa-house',
          'sell-property'        => 'fa-hand-holding-dollar',
          'property-consultancy' => 'fa-user-tie',
          'investment-advisory'  => 'fa-chart-line',
          default                => 'fa-briefcase'
        };
        $category = match($srv['slug']) {
          'buy-property'         => 'Acquisition & Home Search',
          'sell-property'        => 'Disposition & Marketing',
          'property-consultancy' => 'Advisory & Regulatory',
          'investment-advisory'  => 'Wealth & Yield Structuring',
          default                => 'Specialist Service'
        };
      ?>
        <div class="service-large-card">
          <div class="card-top-row">
            <div class="card-icon-wrap">
              <i class="fa-solid <?= $icon ?>"></i>
            </div>
            <span class="service-category-badge"><?= e($category) ?></span>
          </div>

          <div class="service-card-body">
            <h2 class="service-card-heading">
              <a href="/services/<?= e($srv['slug']) ?>"><?= e($srv['title']) ?></a>
            </h2>
            <p class="service-card-text"><?= e($srv['short_desc']) ?></p>

            <?php if (!empty($benefits)): ?>
              <div class="service-key-highlights">
                <span class="highlights-label">Key Deliverables:</span>
                <?php foreach (array_slice($benefits, 0, 3) as $bItem): ?>
                  <div class="service-highlight-item">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= e($bItem) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>

          <div class="service-cta-row">
            <a href="/services/<?= e($srv['slug']) ?>" class="btn-explore-service">
              <span>Explore Service</span>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I would like to inquire about your ' . $srv['title'] . ' service.') ?>" target="_blank" rel="noopener" class="service-quick-wa" title="WhatsApp Inquiries">
              <i class="fa-brands fa-whatsapp"></i> Quick Inquiry
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- Trust Section: The Dwarika Advantage -->
<section class="services-trust-section section-padding surface-bg">
  <div class="container text-center">
    <span class="section-badge">— WHY CHOOSE US —</span>
    <h2 class="section-title">The Dwarika Real Estate Advantage</h2>
    <p class="section-desc" style="margin: 0 auto 50px;">
      Delivering uncompromising integrity, institutional-grade analytics, and high-touch private client representation.
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
