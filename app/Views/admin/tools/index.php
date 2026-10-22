<?php
/**
 * Admin Tools & Calculators View
 * Powered by Saifullah SEO Developer Utilities:
 * - Free SEO ROI Calculator
 * - Free PageSpeed Revenue Impact Calculator
 * - Free Local SEO 25-Point Scorecard
 * - Free JSON-LD Schema Formatter & Generator
 * - Free Color Palette & Brand Theme Studio
 */
$curTab = $_GET['tab'] ?? 'seo-roi';
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Growth Tools &amp; Intelligence Hub</h1>
    <p class="page-subtitle">Real-time Dubai real estate SEO ROI forecasting, speed revenue estimators, 25-point local audit &amp; schema generators.</p>
  </div>
  <div class="header-actions">
    <span class="badge-verified-tools"><i class="fa-solid fa-bolt"></i> Integrated Developer Utilities</span>
  </div>
</div>

<!-- Navigation Tabs -->
<div class="tools-tab-bar">
  <button type="button" class="tool-tab-btn <?= $curTab === 'seo-roi' ? 'active' : '' ?>" data-tab="tab-seo-roi">
    <i class="fa-solid fa-chart-line"></i>
    <span>SEO ROI Calculator</span>
  </button>
  <button type="button" class="tool-tab-btn <?= $curTab === 'pagespeed' ? 'active' : '' ?>" data-tab="tab-pagespeed">
    <i class="fa-solid fa-gauge-high"></i>
    <span>PageSpeed Impact</span>
  </button>
  <button type="button" class="tool-tab-btn <?= $curTab === 'local-seo' ? 'active' : '' ?>" data-tab="tab-local-seo">
    <i class="fa-solid fa-map-location-dot"></i>
    <span>Local SEO Scorecard (25-Pt)</span>
  </button>
  <button type="button" class="tool-tab-btn <?= $curTab === 'schema-gen' ? 'active' : '' ?>" data-tab="tab-schema-gen">
    <i class="fa-solid fa-code"></i>
    <span>Schema JSON-LD Studio</span>
  </button>
  <button type="button" class="tool-tab-btn <?= $curTab === 'brand-palette' ? 'active' : '' ?>" data-tab="tab-brand-palette">
    <i class="fa-solid fa-palette"></i>
    <span>Color Palette Studio</span>
  </button>
</div>

<!-- ====================================================================
     TAB 1: SEO ROI & PIPELINE VALUE CALCULATOR
     ==================================================================== -->
<div class="tool-tab-content <?= $curTab === 'seo-roi' ? 'active' : '' ?>" id="tab-seo-roi">
  <div class="tools-grid-layout">
    
    <!-- Controls Panel -->
    <div class="tool-card controls-card">
      <div class="tool-card-header">
        <div class="card-title-wrap">
          <i class="fa-solid fa-sliders text-primary"></i>
          <h3>Organic Pipeline Parameters</h3>
        </div>
        <div class="preset-dropdown">
          <select id="roiPresetSelect" class="form-select-sm" aria-label="Load Dubai Real Estate Preset">
            <option value="">-- Load Dubai Benchmark Preset --</option>
            <option value="downtown">Downtown Dubai Luxury High-Rises</option>
            <option value="hills">Dubai Hills Estate Family Villas</option>
            <option value="palm">Palm Jumeirah Ultra-Luxury Waterfront</option>
            <option value="offplan">Off-Plan Investor Campaigns</option>
          </select>
        </div>
      </div>

      <div class="tool-card-body">
        <div class="calc-input-group">
          <div class="input-label-row">
            <label for="monthlySearchVol">Monthly Target Search Volume</label>
            <span class="calc-val-badge" id="valSearchVol">45,000 / mo</span>
          </div>
          <input type="range" id="monthlySearchVol" min="5000" max="150000" step="5000" value="45000" class="calc-slider">
          <small class="text-muted">Target Dubai keywords: "Buy villa in Dubai Hills", "Downtown apartments for sale", etc.</small>
        </div>

        <div class="calc-input-group">
          <div class="input-label-row">
            <label for="targetRankCtr">Organic Click-Through Rate (CTR %)</label>
            <span class="calc-val-badge" id="valRankCtr">18.5% (Pos 1-3)</span>
          </div>
          <input type="range" id="targetRankCtr" min="2" max="35" step="0.5" value="18.5" class="calc-slider">
          <small class="text-muted">Google Top 3 organic positions historically capture 18% - 32% of clicks.</small>
        </div>

        <div class="calc-input-group">
          <div class="input-label-row">
            <label for="visitorLeadRate">Visitor to Lead Conversion Rate (%)</label>
            <span class="calc-val-badge" id="valVisitorLead">2.8%</span>
          </div>
          <input type="range" id="visitorLeadRate" min="0.5" max="8.0" step="0.1" value="2.8" class="calc-slider">
          <small class="text-muted">Form submissions, WhatsApp clicks, and Noor AI Chatbot lead captures.</small>
        </div>

        <div class="calc-input-group">
          <div class="input-label-row">
            <label for="leadCloseRate">Lead to Closed Transaction Rate (%)</label>
            <span class="calc-val-badge" id="valLeadClose">4.0%</span>
          </div>
          <input type="range" id="leadCloseRate" min="1.0" max="15.0" step="0.5" value="4.0" class="calc-slider">
          <small class="text-muted">Percentage of qualified inquiries that complete a property deal with agents.</small>
        </div>

        <div class="calc-row-2">
          <div class="calc-input-group">
            <label for="avgDealPrice">Average Property Value (AED)</label>
            <div class="input-currency-wrap">
              <span class="currency-prefix">AED</span>
              <input type="number" id="avgDealPrice" value="3500000" step="100000" class="admin-form-input">
            </div>
          </div>
          <div class="calc-input-group">
            <label for="commissionRate">Agency Commission (%)</label>
            <div class="input-currency-wrap">
              <span class="currency-prefix">%</span>
              <input type="number" id="commissionRate" value="2.0" step="0.1" class="admin-form-input">
            </div>
          </div>
        </div>

        <div class="calc-input-group">
          <label for="monthlySeoCost">Estimated Monthly SEO Investment (AED)</label>
          <div class="input-currency-wrap">
            <span class="currency-prefix">AED</span>
            <input type="number" id="monthlySeoCost" value="8500" step="500" class="admin-form-input">
          </div>
        </div>
      </div>
    </div>

    <!-- Live Results Panel -->
    <div class="tool-card results-card">
      <div class="tool-card-header">
        <div class="card-title-wrap">
          <i class="fa-solid fa-chart-pie text-success"></i>
          <h3>Projected SEO Performance &amp; Revenue</h3>
        </div>
      </div>

      <div class="tool-card-body">
        <div class="results-hero-box">
          <span class="results-hero-label">Projected Annual Brokerage Pipeline</span>
          <div class="results-hero-val" id="resAnnualPipeline">AED 0</div>
          <div class="results-hero-sub">Estimated Organic Transaction Volume</div>
        </div>

        <div class="results-kpi-grid">
          <div class="result-kpi-box">
            <span class="kpi-label">Monthly Organic Clicks</span>
            <span class="kpi-num" id="resMonthlyClicks">0</span>
            <span class="kpi-sub">Target Google Traffic</span>
          </div>
          <div class="result-kpi-box">
            <span class="kpi-label">Monthly Qualified Leads</span>
            <span class="kpi-num" id="resMonthlyLeads">0</span>
            <span class="kpi-sub">Inquiries &amp; WhatsApps</span>
          </div>
          <div class="result-kpi-box">
            <span class="kpi-label">Closed Deals / Month</span>
            <span class="kpi-num" id="resMonthlyDeals">0</span>
            <span class="kpi-sub">Property Transactions</span>
          </div>
          <div class="result-kpi-box highlight-gold">
            <span class="kpi-label">Monthly Gross Commission</span>
            <span class="kpi-num" id="resMonthlyCommission">AED 0</span>
            <span class="kpi-sub">Net Brokerage Earnings</span>
          </div>
        </div>

        <div class="roi-summary-card">
          <div class="roi-stat-row">
            <span>Net Monthly Profit (after SEO Cost):</span>
            <strong id="resNetMonthlyProfit" class="text-success">AED 0</strong>
          </div>
          <div class="roi-stat-row">
            <span>Annual Projected Gross Commission:</span>
            <strong id="resAnnualCommission">AED 0</strong>
          </div>
          <div class="roi-stat-row">
            <span>Calculated SEO Return on Investment (ROI):</span>
            <strong id="resRoiMultiple" class="badge-roi-multiple">0x ROI</strong>
          </div>
        </div>

        <div class="tool-action-bar">
          <button type="button" class="btn-admin-primary" id="btnExportRoiSummary">
            <i class="fa-solid fa-file-arrow-down"></i> Export Executive Forecast (CSV)
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ====================================================================
     TAB 2: PAGESPEED REVENUE IMPACT CALCULATOR
     ==================================================================== -->
<div class="tool-tab-content <?= $curTab === 'pagespeed' ? 'active' : '' ?>" id="tab-pagespeed">
  <div class="tools-grid-layout">
    
    <div class="tool-card controls-card">
      <div class="tool-card-header">
        <div class="card-title-wrap">
          <i class="fa-solid fa-stopwatch text-primary"></i>
          <h3>Page Load Speed &amp; Traffic Inputs</h3>
        </div>
      </div>

      <div class="tool-card-body">
        <div class="calc-row-2">
          <div class="calc-input-group">
            <label for="currentLoadSec">Current Mobile Load Time (sec)</label>
            <input type="number" id="currentLoadSec" value="4.2" step="0.1" min="1.0" max="15.0" class="admin-form-input">
            <small class="text-muted">Pre-optimization mobile benchmark</small>
          </div>
          <div class="calc-input-group">
            <label for="optimizedLoadSec">Optimized Target Time (sec)</label>
            <input type="number" id="optimizedLoadSec" value="1.2" step="0.1" min="0.5" max="5.0" class="admin-form-input">
            <small class="text-muted">Target under Google 2.5s Core Web Vitals LCP</small>
          </div>
        </div>

        <div class="calc-input-group">
          <div class="input-label-row">
            <label for="monthlyMobileVisitors">Monthly Mobile Visitors</label>
            <span class="calc-val-badge" id="valMobileVisitors">18,500</span>
          </div>
          <input type="range" id="monthlyMobileVisitors" min="1000" max="100000" step="500" value="18500" class="calc-slider">
        </div>

        <div class="calc-input-group">
          <label for="currentLeadConvRate">Current Lead Conversion Rate (%)</label>
          <div class="input-currency-wrap">
            <span class="currency-prefix">%</span>
            <input type="number" id="currentLeadConvRate" value="2.2" step="0.1" class="admin-form-input">
          </div>
        </div>

        <div class="calc-input-group">
          <label for="avgLeadValueAed">Estimated Commission Value per Lead (AED)</label>
          <div class="input-currency-wrap">
            <span class="currency-prefix">AED</span>
            <input type="number" id="avgLeadValueAed" value="2800" step="100" class="admin-form-input">
          </div>
          <small class="text-muted">Based on 4% close rate on average AED 70,000 commission.</small>
        </div>

        <div class="alert-info-box">
          <i class="fa-solid fa-circle-info"></i>
          <span><strong>Google &amp; Deloitte Research Benchmark:</strong> Every 0.1 second speed improvement boosts real estate conversions by ~8.4% and decreases mobile bounce rate by up to 24%.</span>
        </div>
      </div>
    </div>

    <div class="tool-card results-card">
      <div class="tool-card-header">
        <div class="card-title-wrap">
          <i class="fa-solid fa-arrow-trend-up text-success"></i>
          <h3>Speed Gains &amp; Recovered Revenue</h3>
        </div>
      </div>

      <div class="tool-card-body">
        <div class="results-hero-box" style="background: linear-gradient(135deg, #0D1B2A 0%, #1689CC 100%);">
          <span class="results-hero-label">Annual Revenue Recovered from Page Speed</span>
          <div class="results-hero-val" id="resSpeedAnnualRev">AED 0</div>
          <div class="results-hero-sub" id="resSpeedGainHeadline">Speed Improvement: 3.0s faster</div>
        </div>

        <div class="results-kpi-grid">
          <div class="result-kpi-box">
            <span class="kpi-label">Bounce Rate Reduction</span>
            <span class="kpi-num text-success" id="resBounceDrop">-0%</span>
            <span class="kpi-sub">Drop in Abandoned Visits</span>
          </div>
          <div class="result-kpi-box">
            <span class="kpi-label">Saved Mobile Visitors</span>
            <span class="kpi-num" id="resVisitorsSaved">+0 / mo</span>
            <span class="kpi-sub">Retained High-Intent Users</span>
          </div>
          <div class="result-kpi-box">
            <span class="kpi-label">Additional Leads / Mo</span>
            <span class="kpi-num text-success" id="resNewLeadsSpeed">+0</span>
            <span class="kpi-sub">Phone &amp; Form Inquiries</span>
          </div>
          <div class="result-kpi-box highlight-gold">
            <span class="kpi-label">Monthly Revenue Gain</span>
            <span class="kpi-num" id="resMonthlySpeedRev">AED 0</span>
            <span class="kpi-sub">Additional Monthly Commission</span>
          </div>
        </div>

        <div class="speed-vitals-status">
          <h4>Core Web Vitals Readiness</h4>
          <div class="vitals-row">
            <span>Largest Contentful Paint (LCP):</span>
            <span class="badge-vitals-good" id="badgeLcp">1.2s — Good (&lt; 2.5s)</span>
          </div>
          <div class="vitals-row">
            <span>First Input Delay / INP:</span>
            <span class="badge-vitals-good">48ms — Good (&lt; 200ms)</span>
          </div>
          <div class="vitals-row">
            <span>Cumulative Layout Shift (CLS):</span>
            <span class="badge-vitals-good">0.00 — Zero Shift</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ====================================================================
     TAB 3: DUBAI LOCAL SEO 25-POINT SCORECARD
     ==================================================================== -->
<div class="tool-tab-content <?= $curTab === 'local-seo' ? 'active' : '' ?>" id="tab-local-seo">
  <div class="tool-card">
    <div class="tool-card-header">
      <div class="card-title-wrap">
        <i class="fa-solid fa-list-check text-primary"></i>
        <h3>Dubai Real Estate Local SEO &amp; Google Business Profile 25-Point Scorecard</h3>
      </div>
      <div class="scorecard-summary-pill">
        <span>Current Score:</span>
        <strong id="scorecardNum">0 / 25</strong>
        <span class="scorecard-grade" id="scorecardGrade">Grade: C</span>
      </div>
    </div>

    <div class="tool-card-body">
      <div class="score-progress-container">
        <div class="score-progress-bar">
          <div class="score-progress-fill" id="scoreProgressFill" style="width: 0%;"></div>
        </div>
        <div class="score-progress-labels">
          <span id="scorePercentLabel">0% Complete</span>
          <span>Target: 100% (25/25 for Top 3 Google Local Pack)</span>
        </div>
      </div>

      <div class="scorecard-sections-grid" id="scorecardChecklist">
        <!-- Section 1 -->
        <div class="scorecard-group">
          <h4 class="group-title"><i class="fa-brands fa-google text-primary"></i> 1. Google Business Profile (GBP) Foundations</h4>
          <div class="checklist-items">
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Primary Category set to <strong>"Real Estate Agency"</strong></span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Secondary Categories set: "Real Estate Consultant", "Commercial Real Estate Agency"</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Exact Name matches RERA License: <strong>"DRL Dwarika Real Estate LLC"</strong></span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Physical Office Address verified in Business Bay (Office 702, Prime Tower)</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Operating Hours, Holiday Schedules &amp; 24/7 WhatsApp contact active</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>High-res exterior building, reception, and team portraits uploaded</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>Weekly Google Business Updates / Property Showcase posts published</span></label>
          </div>
        </div>

        <!-- Section 2 -->
        <div class="scorecard-group">
          <h4 class="group-title"><i class="fa-solid fa-code text-primary"></i> 2. Website On-Page &amp; Local Schema</h4>
          <div class="checklist-items">
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Schema.org <strong>RealEstateAgent</strong> JSON-LD implemented in layout head</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>GeoCoordinates (Lat/Long) for Business Bay embedded in structured data</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>NAP (Name, Address, Phone) in site footer matches Google Profile exactly</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Dedicated Community Landing Pages (Downtown, Dubai Hills, Palm, Business Bay)</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Google Maps embed on Contact Page with custom office pin</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>RERA ORN (29482) &amp; DLD License (1637547) clearly displayed</span></label>
          </div>
        </div>

        <!-- Section 3 -->
        <div class="scorecard-group">
          <h4 class="group-title"><i class="fa-solid fa-globe text-primary"></i> 3. UAE &amp; Dubai Citations &amp; Portals</h4>
          <div class="checklist-items">
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>Verified Brokerage Profile on <strong>Property Finder UAE</strong></span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>Verified Agency Profile on <strong>Bayut / Dubizzle</strong></span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>Listing on Dubai Chamber of Commerce &amp; Industry (DCCI) Directory</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>Listing on UAE YellowPages / Yalwa / ReachUAE</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Apple Maps / Apple Business Connect listing submitted</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Bing Places for Business verified and synced with Google Profile</span></label>
          </div>
        </div>

        <!-- Section 4 -->
        <div class="scorecard-group">
          <h4 class="group-title"><i class="fa-solid fa-star text-primary"></i> 4. Reputation &amp; Customer Reviews</h4>
          <div class="checklist-items">
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>At least 25+ verified 5-star Google Reviews with detailed comments</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>100% Review Response rate within 24 hours (with local keywords)</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>Automated post-transaction review invite workflow for buyers/tenants</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1" checked> <span>Client video and written testimonials published on website</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>Trustpilot / Google Seller Ratings widget integrated</span></label>
            <label class="check-item"><input type="checkbox" data-weight="1"> <span>Active social media check-ins and geotagged Instagram reels</span></label>
          </div>
        </div>
      </div>

      <div class="scorecard-footer-bar">
        <button type="button" class="btn-admin-primary" id="btnSaveScorecard">
          <i class="fa-solid fa-floppy-disk"></i> Save Scorecard State
        </button>
        <button type="button" class="btn-admin-outline" id="btnResetScorecard">
          <i class="fa-solid fa-rotate-left"></i> Reset Defaults
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ====================================================================
     TAB 4: SCHEMA JSON-LD FORMATTER & GENERATOR
     ==================================================================== -->
<div class="tool-tab-content <?= $curTab === 'schema-gen' ? 'active' : '' ?>" id="tab-schema-gen">
  <div class="tools-grid-layout">
    
    <div class="tool-card controls-card">
      <div class="tool-card-header">
        <div class="card-title-wrap">
          <i class="fa-solid fa-wrench text-primary"></i>
          <h3>Schema Type &amp; Properties</h3>
        </div>
      </div>

      <div class="tool-card-body">
        <div class="calc-input-group">
          <label for="schemaTypeSelect">Select Schema Type</label>
          <select id="schemaTypeSelect" class="admin-form-input">
            <option value="RealEstateAgent">RealEstateAgent (Headquarters Organization)</option>
            <option value="SingleFamilyResidence">SingleFamilyResidence (Villa Listing)</option>
            <option value="Apartment">Apartment (High-Rise / Penthouse Listing)</option>
            <option value="FAQPage">FAQPage (Real Estate FAQs &amp; Golden Visa)</option>
          </select>
        </div>

        <div id="schemaDynamicFields">
          <!-- Filled dynamically by JavaScript based on type -->
        </div>

        <button type="button" class="btn-admin-primary" id="btnGenerateSchema" style="width:100%; margin-top:16px;">
          <i class="fa-solid fa-arrows-rotate"></i> Generate Clean JSON-LD
        </button>
      </div>
    </div>

    <div class="tool-card results-card">
      <div class="tool-card-header">
        <div class="card-title-wrap">
          <i class="fa-solid fa-code text-success"></i>
          <h3>Formatted JSON-LD Output</h3>
        </div>
        <div class="card-actions">
          <button type="button" class="btn-admin-sm-outline" id="btnCopySchema">
            <i class="fa-solid fa-copy"></i> Copy Script
          </button>
          <a href="https://search.google.com/test/rich-results" target="_blank" rel="noopener" class="btn-admin-sm-outline">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Test in Google
          </a>
        </div>
      </div>

      <div class="tool-card-body">
        <pre class="schema-code-preview" id="schemaCodeOutput"><code>// Click "Generate Clean JSON-LD" to format structured data</code></pre>
      </div>
    </div>
  </div>
</div>

<!-- ====================================================================
     TAB 5: BRAND COLOR PALETTE & CONTRAST STUDIO
     ==================================================================== -->
<div class="tool-tab-content <?= $curTab === 'brand-palette' ? 'active' : '' ?>" id="tab-brand-palette">
  <div class="tool-card">
    <div class="tool-card-header">
      <div class="card-title-wrap">
        <i class="fa-solid fa-palette text-primary"></i>
        <h3>DRL Dwarika Brand Palette &amp; Accessibility (WCAG) Studio</h3>
      </div>
    </div>

    <div class="tool-card-body">
      <div class="palette-swatches-grid" id="paletteGrid">
        <!-- Swatch 1 -->
        <div class="color-swatch-card" data-hex="#0F1E2E">
          <div class="swatch-color-box" style="background-color: #0F1E2E;"></div>
          <div class="swatch-info">
            <span class="swatch-role">Deep Navy (Headings &amp; Luxury Body)</span>
            <strong class="swatch-hex">#0F1E2E</strong>
            <span class="swatch-contrast">Contrast vs White: <strong>16.2:1 (AAA)</strong></span>
          </div>
        </div>

        <!-- Swatch 2 -->
        <div class="color-swatch-card" data-hex="#1689CC">
          <div class="swatch-color-box" style="background-color: #1689CC;"></div>
          <div class="swatch-info">
            <span class="swatch-role">Sky Blue (Primary Action / Buttons)</span>
            <strong class="swatch-hex">#1689CC</strong>
            <span class="swatch-contrast">Contrast vs White: <strong>3.4:1 (AA Large)</strong></span>
          </div>
        </div>

        <!-- Swatch 3 -->
        <div class="color-swatch-card" data-hex="#C5A880">
          <div class="swatch-color-box" style="background-color: #C5A880;"></div>
          <div class="swatch-info">
            <span class="swatch-role">Dubai Sand Gold (Accents &amp; Badges)</span>
            <strong class="swatch-hex">#C5A880</strong>
            <span class="swatch-contrast">Contrast vs Navy: <strong>8.9:1 (AAA)</strong></span>
          </div>
        </div>

        <!-- Swatch 4 -->
        <div class="color-swatch-card" data-hex="#25D366">
          <div class="swatch-color-box" style="background-color: #25D366;"></div>
          <div class="swatch-info">
            <span class="swatch-role">WhatsApp Green (Live Concierge)</span>
            <strong class="swatch-hex">#25D366</strong>
            <span class="swatch-contrast">Contrast vs Dark: <strong>10.1:1 (AAA)</strong></span>
          </div>
        </div>
      </div>

      <!-- Interactive Color Tester & Converter -->
      <div class="color-converter-box">
        <h4 style="margin-bottom:12px;"><i class="fa-solid fa-eye-dropper"></i> Interactive Color Inspector</h4>
        <div class="converter-inputs-row">
          <div>
            <label>Pick Custom Color:</label>
            <input type="color" id="interactiveColorPicker" value="#1689CC" class="color-native-input">
          </div>
          <div>
            <label>HEX Code:</label>
            <input type="text" id="colorHexInput" value="#1689CC" class="admin-form-input">
          </div>
          <div>
            <label>RGB Code:</label>
            <input type="text" id="colorRgbOutput" value="rgb(22, 137, 204)" readonly class="admin-form-input">
          </div>
          <div>
            <label>HSL Code:</label>
            <input type="text" id="colorHslOutput" value="hsl(202, 80%, 44%)" readonly class="admin-form-input">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
