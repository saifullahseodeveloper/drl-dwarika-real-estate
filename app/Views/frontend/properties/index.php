<?php
/**
 * All Properties / Filtered Listing View
 */
$cleanQuery = $_GET;
unset($cleanQuery['page']);
$baseQuery = http_build_query($cleanQuery);
?>

<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page"><?= e($pageTitle ?? 'Properties') ?></li>
      </ol>
    </nav>
    <h1 class="page-banner-title"><?= e($pageTitle ?? 'Properties in Dubai') ?></h1>
    <p class="page-banner-subtitle">Browse through our exclusive portfolio of luxury residences, off-plan projects, and commercial spaces across the UAE.</p>
  </div>
</div>

<section class="properties-listing-section section-padding">
  <div class="container">
    
    <!-- Filter Bar Card -->
    <div class="filter-panel-card">
      <form action="" method="GET" class="filter-form" id="propertyFilterForm">
        <div class="filter-grid">
          
          <!-- Keyword -->
          <div class="filter-group">
            <label for="filterQ">Search</label>
            <input type="text" name="q" id="filterQ" placeholder="Community, project or title..." value="<?= e($filters['keyword'] ?? '') ?>" class="filter-input">
          </div>

          <!-- Location -->
          <div class="filter-group">
            <label for="filterLoc">Location</label>
            <select name="location" id="filterLoc" class="filter-select">
              <option value="">All Locations</option>
              <?php foreach ($locations as $loc): ?>
                <option value="<?= e($loc['slug']) ?>" <?= ($filters['location'] ?? '') === $loc['slug'] ? 'selected' : '' ?>>
                  <?= e($loc['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Property Type -->
          <div class="filter-group">
            <label for="filterType">Property Type</label>
            <select name="type" id="filterType" class="filter-select">
              <option value="">All Types</option>
              <?php foreach ($propertyTypes as $pt): ?>
                <option value="<?= e($pt['slug']) ?>" <?= ($filters['type'] ?? '') === $pt['slug'] ? 'selected' : '' ?>>
                  <?= e($pt['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Bedrooms -->
          <div class="filter-group">
            <label for="filterBeds">Bedrooms</label>
            <select name="bedrooms" id="filterBeds" class="filter-select">
              <option value="">Any Bedrooms</option>
              <option value="1" <?= ($filters['bedrooms'] ?? '') === '1' ? 'selected' : '' ?>>1 Bed</option>
              <option value="2" <?= ($filters['bedrooms'] ?? '') === '2' ? 'selected' : '' ?>>2 Beds</option>
              <option value="3" <?= ($filters['bedrooms'] ?? '') === '3' ? 'selected' : '' ?>>3 Beds</option>
              <option value="4+" <?= ($filters['bedrooms'] ?? '') === '4+' ? 'selected' : '' ?>>4+ Beds</option>
            </select>
          </div>

          <!-- Max Budget -->
          <div class="filter-group">
            <label for="filterMaxPrice">Max Budget (AED)</label>
            <select name="max_price" id="filterMaxPrice" class="filter-select">
              <option value="">Any Budget</option>
              <option value="2000000" <?= ($filters['max_price'] ?? '') === '2000000' ? 'selected' : '' ?>>AED 2,000,000</option>
              <option value="3500000" <?= ($filters['max_price'] ?? '') === '3500000' ? 'selected' : '' ?>>AED 3,500,000</option>
              <option value="5000000" <?= ($filters['max_price'] ?? '') === '5000000' ? 'selected' : '' ?>>AED 5,000,000</option>
              <option value="10000000" <?= ($filters['max_price'] ?? '') === '10000000' ? 'selected' : '' ?>>AED 10,000,000</option>
            </select>
          </div>

          <!-- Sort -->
          <div class="filter-group">
            <label for="filterSort">Sort By</label>
            <select name="sort" id="filterSort" class="filter-select">
              <option value="newest" <?= ($currentSort ?? '') === 'newest' ? 'selected' : '' ?>>Newest First</option>
              <option value="price_asc" <?= ($currentSort ?? '') === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
              <option value="price_desc" <?= ($currentSort ?? '') === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
            </select>
          </div>

        </div>

        <div class="filter-actions-row">
          <button type="submit" class="btn-primary-pill btn-apply-filters">
            <i class="fa-solid fa-filter"></i> Apply Filters
          </button>
          <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>" class="btn-clear-filters">
            <i class="fa-solid fa-rotate-left"></i> Reset
          </a>
        </div>
      </form>
    </div>

    <!-- Results Header -->
    <div class="listing-meta-bar">
      <div class="meta-count">
        Showing <strong><?= count($properties) ?></strong> of <strong><?= $total ?></strong> Properties
      </div>
    </div>

    <!-- Properties Grid -->
    <?php if (!empty($properties)): ?>
      <div class="properties-grid">
        <?php foreach ($properties as $prop): ?>
          <?php \App\Core\View::component('property-card', ['property' => $prop]); ?>
        <?php endforeach; ?>
      </div>

      <!-- Pagination -->
      <?php if ($totalPages > 1): ?>
        <div class="pagination-wrap">
          <ul class="pagination-list">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <?php
                $pageUrl = '?' . ($baseQuery ? $baseQuery . '&' : '') . 'page=' . $i;
              ?>
              <li class="page-item <?= $currentPage === $i ? 'active' : '' ?>">
                <a href="<?= e($pageUrl) ?>" class="page-link"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </div>
      <?php endif; ?>

    <?php else: ?>
      <div class="no-results-box">
        <i class="fa-solid fa-magnifying-glass no-results-icon"></i>
        <h3>No Properties Matched Your Criteria</h3>
        <p>Try broadening your search parameters or explore our featured locations below.</p>
        <a href="/properties" class="btn-primary-pill">View All Available Properties</a>
      </div>
    <?php endif; ?>

  </div>
</section>
