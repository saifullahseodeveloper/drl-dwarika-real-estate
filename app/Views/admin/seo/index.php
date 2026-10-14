<?php
/**
 * Admin SEO Management View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Technical SEO &amp; Indexing</h1>
    <p class="page-subtitle">Inspect automated XML sitemaps, robots.txt crawl directives, and schema integrity.</p>
  </div>
</div>

<div class="metrics-grid">
  <div class="metric-card">
    <div class="metric-icon blue"><i class="fa-solid fa-sitemap"></i></div>
    <div class="metric-data">
      <span class="metric-num">Dynamic</span>
      <span class="metric-label">XML Sitemap</span>
    </div>
  </div>

  <div class="metric-card">
    <div class="metric-icon green"><i class="fa-solid fa-robot"></i></div>
    <div class="metric-data">
      <span class="metric-num">Active</span>
      <span class="metric-label">Robots.txt Engine</span>
    </div>
  </div>

  <div class="metric-card">
    <div class="metric-icon purple"><i class="fa-solid fa-code"></i></div>
    <div class="metric-data">
      <span class="metric-num">Valid</span>
      <span class="metric-label">Schema.org JSON-LD</span>
    </div>
  </div>
</div>

<div class="dash-card">
  <div class="dash-card-header">
    <div class="card-title-wrap">
      <i class="fa-solid fa-circle-nodes text-primary"></i>
      <h3>Crawling &amp; Indexation Endpoints</h3>
    </div>
  </div>

  <div class="seo-endpoints-list">
    <div class="seo-endpoint-item">
      <div>
        <strong>Dynamic XML Sitemap (sitemap.xml)</strong>
        <p class="text-muted">Includes all published properties, locations, types, services, and static pages with lastmod and changefreq.</p>
      </div>
      <div>
        <a href="/sitemap.xml" target="_blank" class="btn-admin-outline"><i class="fa-solid fa-external-link"></i> View XML Sitemap</a>
      </div>
    </div>

    <div class="seo-endpoint-item">
      <div>
        <strong>Robots.txt Directives (robots.txt)</strong>
        <p class="text-muted">Directs web crawlers to public routes while protecting /admin directories.</p>
      </div>
      <div>
        <a href="/robots.txt" target="_blank" class="btn-admin-outline"><i class="fa-solid fa-external-link"></i> View Robots.txt</a>
      </div>
    </div>
  </div>
</div>
