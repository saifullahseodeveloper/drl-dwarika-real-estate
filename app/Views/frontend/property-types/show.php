<?php
/**
 * Property Type Discovery View (Villas, Apartments, etc.)
 */
?>

<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li><a href="/properties">Properties</a></li>
        <li aria-current="page"><?= e($type['name']) ?>s</li>
      </ol>
    </nav>
    <h1 class="page-banner-title">Luxury <?= e($type['name']) ?>s in Dubai</h1>
    <p class="page-banner-subtitle"><?= e($type['description'] ?: "Discover our curated collection of luxury {$type['name']}s available across premier Dubai locations.") ?></p>
  </div>
</div>

<section class="type-detail-section section-padding">
  <div class="container">
    
    <div class="section-header">
      <span class="section-badge">— CURATED SELECTION —</span>
      <h2 class="section-title">Available <?= e($type['name']) ?> Listings</h2>
      <p class="section-desc">Showing verified <?= strtolower(e($type['name'])) ?> properties with immediate transfer or flexible off-plan payment schedules.</p>
    </div>

    <?php if (!empty($properties)): ?>
      <div class="properties-grid">
        <?php foreach ($properties as $prop): ?>
          <?php \App\Core\View::component('property-card', ['property' => $prop]); ?>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="no-results-box">
        <i class="fa-solid fa-home no-results-icon"></i>
        <h3>No <?= e($type['name']) ?>s Currently Listed</h3>
        <p>Contact our advisors to access unlisted developer releases and private resales.</p>
        <a href="/contact-us" class="btn-primary-pill">Speak with an Advisor</a>
      </div>
    <?php endif; ?>

    <!-- Other Categories -->
    <?php if (!empty($allTypes)): ?>
      <div class="other-types-block section-padding-top">
        <div class="section-header">
          <span class="section-badge">— EXPLORE OTHER CATEGORIES —</span>
          <h2 class="section-title">Browse by Property Type</h2>
        </div>
        <div class="types-nav-grid">
          <?php foreach ($allTypes as $tItem): ?>
            <a href="/property-types/<?= e($tItem['slug']) ?>" class="type-badge-card <?= $tItem['id'] === $type['id'] ? 'active' : '' ?>">
              <i class="fa-solid <?= e($tItem['icon'] ?? 'fa-building') ?>"></i>
              <span><?= e($tItem['name']) ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>
