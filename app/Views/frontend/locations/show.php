<?php
/**
 * Location Community Discovery View
 */
?>

<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li><a href="/properties">Properties</a></li>
        <li aria-current="page"><?= e($location['name']) ?></li>
      </ol>
    </nav>
    <h1 class="page-banner-title">Properties in <?= e($location['name']) ?></h1>
    <p class="page-banner-subtitle"><?= e($location['description'] ?: "Discover luxury freehold properties and high-yield investments in {$location['name']}, Dubai.") ?></p>
  </div>
</div>

<section class="location-detail-section section-padding">
  <div class="container">
    
    <div class="location-meta-hero-card">
      <div class="loc-image-side">
        <img src="<?= e($location['image_url'] ?: '/assets/images/villa-dubai-hills.jpg') ?>" alt="<?= e($location['name']) ?>" class="loc-img">
      </div>
      <div class="loc-info-side">
        <span class="section-badge">— DUBAI FREEHOLD COMMUNITY —</span>
        <h2>About <?= e($location['name']) ?></h2>
        <p><?= e($location['description']) ?></p>
        <div class="loc-tags">
          <span class="tag-pill"><i class="fa-solid fa-location-dot"></i> <?= e($location['city'] ?? 'Dubai') ?></span>
          <span class="tag-pill"><i class="fa-solid fa-building"></i> Freehold Area</span>
          <span class="tag-pill"><i class="fa-solid fa-home"></i> <?= $total ?> Active Listings</span>
        </div>
      </div>
    </div>

    <!-- Listings in this location -->
    <div class="location-listings-block section-padding-top">
      <div class="section-header">
        <span class="section-badge">— CURRENT AVAILABILITY —</span>
        <h2 class="section-title">Available Listings in <?= e($location['name']) ?></h2>
      </div>

      <?php if (!empty($properties)): ?>
        <div class="properties-grid">
          <?php foreach ($properties as $prop): ?>
            <?php \App\Core\View::component('property-card', ['property' => $prop]); ?>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="no-results-box">
          <i class="fa-solid fa-building-circle-exclamation no-results-icon"></i>
          <h3>No Public Listings Found in <?= e($location['name']) ?> Currently</h3>
          <p>We frequently have off-market and pre-launch units in this community. Contact our specialists for private inventory.</p>
          <a href="/contact-us" class="btn-primary-pill">Inquire About Off-Market Properties</a>
        </div>
      <?php endif; ?>
    </div>

    <!-- Related Locations -->
    <?php if (!empty($allLocations)): ?>
      <div class="other-locations-block section-padding-top">
        <div class="section-header">
          <span class="section-badge">— EXPLORE MORE —</span>
          <h2 class="section-title">Other Top Dubai Communities</h2>
        </div>
        <div class="locations-pill-grid">
          <?php foreach ($allLocations as $locItem): ?>
            <a href="/locations/<?= e($locItem['slug']) ?>" class="location-bubble <?= $locItem['id'] === $location['id'] ? 'active' : '' ?>">
              <i class="fa-solid fa-location-dot"></i>
              <span><?= e($locItem['name']) ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>
