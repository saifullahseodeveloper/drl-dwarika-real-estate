<?php
/**
 * Location Community Discovery View — DRL Dwarika Real Estate LLC
 */
$phone = $settings['company_phone'] ?? '+971 54 220 2920';
$cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
$waPhone = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '971542202920');

// Community amenities/lifestyle defaults if not specified
$communityHighlights = match($location['slug']) {
  'dubai-hills-estate' => [
    ['icon' => 'fa-golf-ball-tee', 'title' => '18-Hole Championship Golf', 'desc' => 'Home to Dubai Hills Golf Club with iconic Downtown skyline views.'],
    ['icon' => 'fa-tree', 'title' => '1,450,000 Sq. M. of Parks', 'desc' => 'Lush green boulevards, walking trails, and championship sports courts.'],
    ['icon' => 'fa-bag-shopping', 'title' => 'Dubai Hills Mall', 'desc' => 'Over 650 retail stores, fine dining, and The Storm Coaster.'],
    ['icon' => 'fa-hospital', 'title' => 'King’s College Hospital', 'desc' => 'World-renowned healthcare facilities directly within the community.']
  ],
  'downtown-dubai' => [
    ['icon' => 'fa-monument', 'title' => 'Burj Khalifa & Fountains', 'desc' => 'Unrivaled views of the world’s tallest tower and dancing fountains.'],
    ['icon' => 'fa-bag-shopping', 'title' => 'The Dubai Mall', 'desc' => 'Direct indoor pedestrian access to the world’s most visited shopping destination.'],
    ['icon' => 'fa-masks-theater', 'title' => 'Dubai Opera District', 'desc' => 'World-class performing arts, cultural events, and Michelin dining.'],
    ['icon' => 'fa-train-subway', 'title' => 'Dubai Metro Connected', 'desc' => 'Effortless transit connecting you to DIFC, DXB Airport, and the coast.']
  ],
  'palm-jumeirah' => [
    ['icon' => 'fa-umbrella-beach', 'title' => 'Private Beach Access', 'desc' => 'Direct private beachfront residences with Arabian Gulf vistas.'],
    ['icon' => 'fa-anchor', 'title' => 'Superyacht Marinas', 'desc' => 'Exclusive berths, sailing clubs, and private yacht charters.'],
    ['icon' => 'fa-hotel', 'title' => 'Atlantis The Royal', 'desc' => 'Neighboring Dubai’s most celebrated ultra-luxury resort and beach clubs.'],
    ['icon' => 'fa-utensils', 'title' => 'The Pointe & Club Vista', 'desc' => 'Waterside promenade with world-renowned dining and entertainment.']
  ],
  default => [
    ['icon' => 'fa-shield-halved', 'title' => 'RERA Freehold Zone', 'desc' => '100% foreign ownership allowed with protected escrow frameworks.'],
    ['icon' => 'fa-chart-line', 'title' => 'High Rental Yields', 'desc' => 'Strong tenant demand generating competitive 7% - 9%+ annual ROI.'],
    ['icon' => 'fa-road', 'title' => 'Prime Highway Connectivity', 'desc' => 'Rapid access to Al Khail Road, Sheikh Zayed Road, and DXB Airport.'],
    ['icon' => 'fa-passport', 'title' => 'Golden Visa Eligible', 'desc' => 'Qualifying AED 2M+ freehold acquisitions grant 10-Year residency.']
  ]
};
?>

<!-- Page Banner -->
<div class="page-banner location-hero-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li><a href="/properties">Properties</a></li>
        <li aria-current="page"><?= e($location['name']) ?></li>
      </ol>
    </nav>
    <span class="banner-pill-badge"><i class="fa-solid fa-map-pin"></i> DUBAI FREEHOLD MASTER COMMUNITY</span>
    <h1 class="page-banner-title">Properties in <?= e($location['name']) ?></h1>
    <p class="page-banner-subtitle">
      <?= e($location['description'] ?: "Discover luxury freehold villas, modern golf residences, and high-yield investment apartments across {$location['name']}, Dubai.") ?>
    </p>

    <!-- Trust Stats Strip -->
    <div class="services-trust-strip">
      <div class="trust-strip-item">
        <i class="fa-solid fa-shield-halved"></i>
        <span>100% Freehold Zone</span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-chart-pie"></i>
        <span>High Capital Growth</span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-passport"></i>
        <span>10-Yr Golden Visa Eligible</span>
      </div>
      <div class="trust-strip-item">
        <i class="fa-solid fa-door-open"></i>
        <span><?= (int)$total ?> Active Listings</span>
      </div>
    </div>
  </div>
</div>

<section class="location-detail-section section-padding">
  <div class="container">
    
    <!-- Community Spotlight Card -->
    <div class="location-meta-hero-card">
      <div class="loc-image-side">
        <div class="loc-image-wrap">
          <img src="<?= e($location['image_url'] ?: '/assets/images/villa-dubai-hills.jpg') ?>" alt="<?= e($location['name']) ?>" class="loc-img" loading="eager">
          <div class="loc-floating-badge">
            <i class="fa-solid fa-gem"></i>
            <span>Premier Lifestyle Enclave</span>
          </div>
        </div>
      </div>

      <div class="loc-info-side">
        <div class="loc-info-header">
          <span class="section-badge">— COMMUNITY OVERVIEW —</span>
          <h2 class="loc-title">Live &amp; Invest in <?= e($location['name']) ?></h2>
        </div>
        <p class="loc-desc"><?= e($location['description']) ?></p>

        <!-- Community Tags -->
        <div class="loc-tags">
          <span class="tag-pill"><i class="fa-solid fa-location-dot"></i> <?= e($location['city'] ?? 'Dubai') ?>, UAE</span>
          <span class="tag-pill"><i class="fa-solid fa-certificate"></i> Freehold Ownership</span>
          <span class="tag-pill"><i class="fa-solid fa-house-chimney"></i> <?= (int)$total ?> Public Listings</span>
        </div>

        <!-- Community Action Buttons -->
        <div class="loc-action-row">
          <a href="#availableListings" class="btn-primary-pill">
            <span>View Available Properties</span>
            <i class="fa-solid fa-arrow-down"></i>
          </a>
          <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I am interested in property opportunities in ' . $location['name'] . '.') ?>" target="_blank" rel="noopener" class="btn-whatsapp">
            <i class="fa-brands fa-whatsapp"></i>
            <span>Inquire Community</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Community Lifestyle & Key Features Grid -->
    <div class="community-highlights-section section-padding-top">
      <div class="section-header text-center">
        <span class="section-badge">— LIFESTYLE &amp; AMENITIES —</span>
        <h2 class="section-title">Why Live in <?= e($location['name']) ?></h2>
        <p class="section-desc" style="margin: 0 auto 40px;">
          Explore the world-class infrastructure, connectivity, and lifestyle privileges that make this enclave one of Dubai’s most desirable addresses.
        </p>
      </div>

      <div class="community-amenities-grid">
        <?php foreach ($communityHighlights as $hItem): ?>
          <div class="community-amenity-card">
            <div class="amenity-icon-box">
              <i class="fa-solid <?= $hItem['icon'] ?>"></i>
            </div>
            <h3 class="amenity-title"><?= e($hItem['title']) ?></h3>
            <p class="amenity-desc"><?= e($hItem['desc']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Listings in this location -->
    <div class="location-listings-block section-padding-top" id="availableListings">
      <div class="section-header-row">
        <div>
          <span class="section-badge">— CURRENT INVENTORY —</span>
          <h2 class="section-title">Available Listings in <?= e($location['name']) ?></h2>
        </div>
        <span class="inventory-count-pill"><?= (int)$total ?> Verified Properties</span>
      </div>

      <?php if (!empty($properties)): ?>
        <div class="properties-grid">
          <?php foreach ($properties as $prop): ?>
            <?php \App\Core\View::component('property-card', ['property' => $prop]); ?>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="no-results-box">
          <div class="no-results-icon-wrap">
            <i class="fa-solid fa-building-circle-check no-results-icon"></i>
          </div>
          <h3>Private Off-Market &amp; Pre-Launch Opportunities Available</h3>
          <p>
            Due to high demand in <strong><?= e($location['name']) ?></strong>, several luxury units and pre-launch developer allotments are transacted confidentially off-market. Contact our specialist desk to access unlisted inventory.
          </p>
          <div class="no-results-btns">
            <a href="tel:<?= $cleanPhone ?>" class="btn-primary-pill">
              <i class="fa-solid fa-phone"></i>
              <span>Call Specialist Desk</span>
            </a>
            <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, please share off-market options in ' . $location['name'] . '.') ?>" target="_blank" rel="noopener" class="btn-whatsapp">
              <i class="fa-brands fa-whatsapp"></i>
              <span>Request Off-Market Brochure</span>
            </a>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Related Locations Grid -->
    <?php if (!empty($allLocations)): ?>
      <div class="other-locations-block section-padding-top">
        <div class="section-header text-center">
          <span class="section-badge">— EXPLORE MORE —</span>
          <h2 class="section-title">Other Top Dubai Communities</h2>
          <p class="section-desc" style="margin: 0 auto 36px;">
            Compare yields, master developments, and lifestyle options across Dubai’s leading freehold enclaves.
          </p>
        </div>
        
        <div class="locations-cards-grid">
          <?php foreach ($allLocations as $locItem): ?>
            <a href="/locations/<?= e($locItem['slug']) ?>" class="location-nav-card <?= $locItem['id'] === $location['id'] ? 'current' : '' ?>">
              <div class="loc-card-thumb">
                <img src="<?= e($locItem['image_url'] ?: '/assets/images/villa-dubai-hills.jpg') ?>" alt="<?= e($locItem['name']) ?>" loading="lazy">
                <span class="loc-card-badge"><?= e($locItem['city'] ?? 'Dubai') ?></span>
              </div>
              <div class="loc-card-body">
                <h4 class="loc-card-name"><?= e($locItem['name']) ?></h4>
                <div class="loc-card-footer">
                  <span>Explore Community</span>
                  <i class="fa-solid fa-arrow-right"></i>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- Bottom VIP Consultation Banner -->
<section class="services-vip-cta-section">
  <div class="container">
    <div class="vip-cta-card">
      <div class="vip-cta-content">
        <span class="cta-pill-label">COMMUNITY ADVISORY</span>
        <h2 class="vip-cta-title">Looking to Buy or Sell in <?= e($location['name']) ?>?</h2>
        <p class="vip-cta-desc">
          Speak with our dedicated <?= e($location['name']) ?> community specialists for transparent market pricing, tenant demand analysis, and direct developer availability.
        </p>
      </div>
      <div class="vip-cta-actions">
        <a href="tel:<?= $cleanPhone ?>" class="btn-primary-pill">
          <i class="fa-solid fa-phone"></i>
          <span>Call <?= e($settings['company_phone'] ?? '+971 54 220 2920') ?></span>
        </a>
        <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I would like to consult on properties in ' . $location['name'] . '.') ?>" target="_blank" rel="noopener" class="btn-whatsapp">
          <i class="fa-brands fa-whatsapp"></i>
          <span>WhatsApp Specialist Desk</span>
        </a>
      </div>
    </div>
  </div>
</section>
