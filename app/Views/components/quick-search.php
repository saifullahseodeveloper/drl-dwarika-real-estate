<?php
/**
 * Quick Property Search Component — Floating card from master design
 */
$selectedLoc = $_GET['location'] ?? '';
$selectedType = $_GET['type'] ?? '';
$selectedBudget = $_GET['budget'] ?? '';
?>
<div class="quick-search-box">
  <form action="/properties" method="GET" class="quick-search-form" id="quickSearchForm">
    <div class="quick-search-title">Quick Property Search</div>
    <div class="quick-search-fields">
      
      <!-- Location Dropdown -->
      <div class="search-field">
        <label for="searchLocation" class="sr-only">Location</label>
        <select name="location" id="searchLocation" class="search-select">
          <option value="">Location</option>
          <?php if (!empty($locations)): ?>
            <?php foreach ($locations as $loc): ?>
              <option value="<?= e($loc['slug']) ?>" <?= $selectedLoc === $loc['slug'] ? 'selected' : '' ?>>
                <?= e($loc['name']) ?>
              </option>
            <?php endforeach; ?>
          <?php else: ?>
            <option value="dubai-hills-estate">Dubai Hills Estate</option>
            <option value="downtown-dubai">Downtown Dubai</option>
            <option value="jumeirah-village-circle">Jumeirah Village Circle</option>
            <option value="palm-jumeirah">Palm Jumeirah</option>
            <option value="business-bay">Business Bay</option>
            <option value="dubai-creek-harbour">Dubai Creek Harbour</option>
          <?php endif; ?>
        </select>
        <i class="fa-solid fa-chevron-down select-caret"></i>
      </div>

      <!-- Property Type Dropdown -->
      <div class="search-field">
        <label for="searchType" class="sr-only">Property Type</label>
        <select name="type" id="searchType" class="search-select">
          <option value="">Property Type</option>
          <?php if (!empty($propertyTypes)): ?>
            <?php foreach ($propertyTypes as $pt): ?>
              <option value="<?= e($pt['slug']) ?>" <?= $selectedType === $pt['slug'] ? 'selected' : '' ?>>
                <?= e($pt['name']) ?>
              </option>
            <?php endforeach; ?>
          <?php else: ?>
            <option value="villa">Villa</option>
            <option value="apartment">Apartment</option>
            <option value="townhouse">Townhouse</option>
            <option value="penthouse">Penthouse</option>
            <option value="commercial">Commercial</option>
          <?php endif; ?>
        </select>
        <i class="fa-solid fa-chevron-down select-caret"></i>
      </div>

      <!-- Budget Dropdown -->
      <div class="search-field">
        <label for="searchBudget" class="sr-only">Budget</label>
        <select name="max_price" id="searchBudget" class="search-select">
          <option value="">Budget</option>
          <option value="1500000" <?= $selectedBudget === '1500000' ? 'selected' : '' ?>>Up to AED 1.5M</option>
          <option value="3000000" <?= $selectedBudget === '3000000' ? 'selected' : '' ?>>Up to AED 3.0M</option>
          <option value="5000000" <?= $selectedBudget === '5000000' ? 'selected' : '' ?>>Up to AED 5.0M</option>
          <option value="10000000" <?= $selectedBudget === '10000000' ? 'selected' : '' ?>>Up to AED 10M</option>
          <option value="20000000" <?= $selectedBudget === '20000000' ? 'selected' : '' ?>>AED 10M+</option>
        </select>
        <i class="fa-solid fa-chevron-down select-caret"></i>
      </div>

      <!-- Search Submit Button -->
      <button type="submit" class="btn-search-submit" id="btnQuickSearchSubmit" aria-label="Search Properties">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>

    </div>
  </form>
</div>
