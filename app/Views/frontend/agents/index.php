<?php
/**
 * Agents Directory Listing View — DRL Dwarika Real Estate LLC
 */
$currentSearch = $filters['search'] ?? '';
$currentSpec = $filters['specialization'] ?? 'all';
$currentLang = $filters['language'] ?? 'all';
$currentLoc = $filters['location'] ?? 'all';
?>

<!-- Page Banner -->
<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">Our Agents</li>
      </ol>
    </nav>
    <span class="banner-pill-badge"><i class="fa-solid fa-certificate"></i> RERA LICENSED &amp; DLD ACCREDITED</span>
    <h1 class="page-banner-title">Meet Our Dubai Property Specialists</h1>
    <p class="page-banner-subtitle">
      Our licensed, multilingual real estate consultants provide transparent advisory, private off-market allocations, and bespoke investment portfolio management.
    </p>
  </div>
</div>

<!-- Agents Catalog & Filter Section -->
<section class="section-padding surface-bg">
  <div class="container">

    <!-- Search & Multi-Filter Bar -->
    <div class="agents-filter-card">
      <form action="/agents" method="GET" class="agents-filter-form" id="agentFilterForm">
        <div class="filter-grid-row">
          
          <!-- Name Search -->
          <div class="filter-col search-col">
            <label for="agentSearchInput" class="filter-label"><i class="fa-solid fa-magnifying-glass"></i> Search Agent</label>
            <input 
              type="text" 
              name="search" 
              id="agentSearchInput" 
              value="<?= e($currentSearch) ?>" 
              placeholder="Search by agent name, title..." 
              class="filter-input-field"
            >
          </div>

          <!-- Specialization Filter -->
          <div class="filter-col">
            <label for="agentSpecSelect" class="filter-label"><i class="fa-solid fa-layer-group"></i> Specialization</label>
            <select name="specialization" id="agentSpecSelect" class="filter-select-field">
              <?php foreach ($specializations as $val => $label): ?>
                <option value="<?= e($val) ?>" <?= $currentSpec === $val ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Language Filter -->
          <div class="filter-col">
            <label for="agentLangSelect" class="filter-label"><i class="fa-solid fa-language"></i> Language</label>
            <select name="language" id="agentLangSelect" class="filter-select-field">
              <?php foreach ($languages as $val => $label): ?>
                <option value="<?= e($val) ?>" <?= $currentLang === $val ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Location Filter -->
          <div class="filter-col">
            <label for="agentLocSelect" class="filter-label"><i class="fa-solid fa-map-pin"></i> Community</label>
            <select name="location" id="agentLocSelect" class="filter-select-field">
              <?php foreach ($locations as $val => $label): ?>
                <option value="<?= e($val) ?>" <?= $currentLoc === $val ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Submit & Reset Buttons -->
          <div class="filter-col-actions">
            <button type="submit" class="btn-filter-apply" id="btnFilterApply">
              <i class="fa-solid fa-filter"></i>
              <span>Filter</span>
            </button>
            <?php if (!empty($currentSearch) || $currentSpec !== 'all' || $currentLang !== 'all' || $currentLoc !== 'all'): ?>
              <a href="/agents" class="btn-filter-reset" title="Clear all filters">
                <i class="fa-solid fa-rotate-left"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </form>
    </div>

    <!-- Results Header -->
    <div class="catalog-results-header">
      <div class="results-count-text">
        Showing <strong><?= count($agents) ?></strong> of <strong><?= $total ?></strong> certified real estate advisors
      </div>
      <div class="results-meta-badges">
        <span class="rera-guarantee-pill"><i class="fa-solid fa-shield-check"></i> 100% RERA Registered</span>
      </div>
    </div>

    <!-- Agents Grid -->
    <?php if (!empty($agents)): ?>
      <div class="agents-grid">
        <?php foreach ($agents as $agent): ?>
          <?php include APP_ROOT . '/app/Views/components/agent-card.php'; ?>
        <?php endforeach; ?>
      </div>

      <!-- Pagination -->
      <?php if ($lastPage > 1): ?>
        <nav class="pagination-wrapper" aria-label="Agents page navigation">
          <ul class="pagination-list">
            <?php if ($currentPage > 1): ?>
              <?php
                $prevParams = array_merge($filters, ['page' => $currentPage - 1]);
                $prevUrl = '/agents?' . http_build_query(array_filter($prevParams));
              ?>
              <li>
                <a href="<?= e($prevUrl) ?>" class="page-link prev-link" aria-label="Previous Page">
                  <i class="fa-solid fa-chevron-left"></i> Previous
                </a>
              </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $lastPage; $i++): ?>
              <?php
                $pageParams = array_merge($filters, ['page' => $i]);
                $pageUrl = '/agents?' . http_build_query(array_filter($pageParams));
              ?>
              <li>
                <a href="<?= e($pageUrl) ?>" class="page-link <?= $i === $currentPage ? 'active' : '' ?>" aria-current="<?= $i === $currentPage ? 'page' : 'false' ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>

            <?php if ($currentPage < $lastPage): ?>
              <?php
                $nextParams = array_merge($filters, ['page' => $currentPage + 1]);
                $nextUrl = '/agents?' . http_build_query(array_filter($nextParams));
              ?>
              <li>
                <a href="<?= e($nextUrl) ?>" class="page-link next-link" aria-label="Next Page">
                  Next <i class="fa-solid fa-chevron-right"></i>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>

    <?php else: ?>
      <div class="no-results-box">
        <div class="no-results-icon"><i class="fa-solid fa-user-slash"></i></div>
        <h3>No Agents Found Matching Your Criteria</h3>
        <p>Try resetting your filters or search keywords to view our complete advisory team.</p>
        <a href="/agents" class="btn-primary-pill">Reset All Filters</a>
      </div>
    <?php endif; ?>

    <!-- Bottom Advisory Enquiry Banner -->
    <div class="agents-cta-banner">
      <div class="agents-cta-content">
        <span class="cta-mini-badge">BESPOKE CLIENT MATCHING</span>
        <h3 class="cta-title">Not Sure Which Specialist Fits Your Requirements?</h3>
        <p class="cta-desc">
          Speak with our client matching concierge. We will pair you with the ideal advisor based on your community interest, target ROI, or language preference.
        </p>
      </div>
      <div class="agents-cta-action">
        <a href="/contact-us" class="btn-cta-white">
          <span>Request an Advisor Match</span>
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </div>

  </div>
</section>
