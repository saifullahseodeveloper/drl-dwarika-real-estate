<?php
/**
 * Services Index View — Comprehensive Overview
 */
?>

<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">Services</li>
      </ol>
    </nav>
    <h1 class="page-banner-title">Our Real Estate Services</h1>
    <p class="page-banner-subtitle">From private home acquisitions and strategic asset sales to regulatory consultancy and investment structuring, DRL Dwarika delivers bespoke excellence across Dubai.</p>
  </div>
</div>

<section class="services-overview-section section-padding">
  <div class="container">
    
    <div class="services-cards-grid">
      <?php foreach ($services as $srv): ?>
        <div class="service-large-card">
          <div class="card-icon-wrap">
            <?php
              $icon = match($srv['slug']) {
                'buy-property'         => 'fa-house',
                'sell-property'        => 'fa-hand-holding-dollar',
                'property-consultancy' => 'fa-user-tie',
                'investment-advisory'  => 'fa-chart-line',
                default                => 'fa-briefcase'
              };
            ?>
            <i class="fa-solid <?= $icon ?>"></i>
          </div>
          <div class="card-body">
            <h2 class="service-card-heading"><?= e($srv['title']) ?></h2>
            <p class="service-card-text"><?= e($srv['short_desc']) ?></p>
            <div class="service-cta-row">
              <a href="/services/<?= e($srv['slug']) ?>" class="btn-primary-pill">
                <span>Explore Service</span>
                <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- Trust Section -->
<section class="services-trust-section section-padding surface-bg">
  <div class="container text-center">
    <span class="section-badge">— WHY CHOOSE US —</span>
    <h2 class="section-title">The Dwarika Real Estate Advantage</h2>
    
    <div class="advantage-grid">
      <div class="adv-card">
        <i class="fa-solid fa-file-contract adv-icon"></i>
        <h3>DLD &amp; RERA Compliant</h3>
        <p>Every transaction, escrow agreement, and contract adheres strictly to Dubai Land Department regulations.</p>
      </div>

      <div class="adv-card">
        <i class="fa-solid fa-award adv-icon"></i>
        <h3>Prime Developer Access</h3>
        <p>Direct pre-launch allocation and developer relationships with Emaar, Nakheel, Damac, Sobha, and Meraas.</p>
      </div>

      <div class="adv-card">
        <i class="fa-solid fa-passport adv-icon"></i>
        <h3>Golden Visa Advisory</h3>
        <p>Expert qualification for the 10-Year UAE Golden Visa through qualifying freehold property investments.</p>
      </div>
    </div>
  </div>
</section>
