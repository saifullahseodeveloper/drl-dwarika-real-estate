<?php
/**
 * Founders & Corporate Leadership Page — DRL Dwarika Real Estate LLC
 */
$foundersList = $founders ?? [];
?>

<!-- Schema.org Leadership Page JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "AboutPage",
  "name": "Founders & Executive Leadership | DRL Dwarika Real Estate LLC",
  "description": "Corporate leadership, vision, mission, and governance of DRL Dwarika Real Estate LLC Dubai.",
  "publisher": {
    "@type": "RealEstateAgent",
    "name": "DRL Dwarika Real Estate LLC",
    "url": "https://dwarikarealestate.ae",
    "logo": "https://dwarikarealestate.ae/assets/images/logo.png"
  }
}
</script>

<!-- Distinctive Leadership Hero Section -->
<section class="founders-hero-section">
  <div class="founders-hero-bg-overlay"></div>
  <div class="container founders-hero-container">
    
    <nav class="breadcrumb-nav white-breadcrumbs" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li><a href="/about-us">About Us</a></li>
        <li aria-current="page">Founders &amp; Leadership</li>
      </ol>
    </nav>

    <div class="founders-hero-badge-wrap">
      <span class="founders-hero-badge">
        <i class="fa-solid fa-landmark"></i> CORPORATE GOVERNANCE &amp; EXECUTIVE LEADERSHIP
      </span>
    </div>

    <h1 class="founders-hero-title">
      The Visionaries Behind<br>DRL Dwarika Real Estate LLC
    </h1>

    <p class="founders-hero-lead">
      Founded with a commitment to integrity, transparency, and market acumen, our leadership steers DRL Dwarika Real Estate LLC as a trusted pillar in Dubai’s premier property landscape.
    </p>

    <div class="founders-hero-stats">
      <div class="hero-stat-item">
        <span class="hero-stat-val">RERA <?= e($settings['rera_orn'] ?? '29482') ?></span>
        <span class="hero-stat-lbl">Licensed Brokerage</span>
      </div>
      <div class="hero-stat-sep"></div>
      <div class="hero-stat-item">
        <span class="hero-stat-val">Business Bay</span>
        <span class="hero-stat-lbl">Dubai Headquarters</span>
      </div>
      <div class="hero-stat-sep"></div>
      <div class="hero-stat-item">
        <span class="hero-stat-val">100% Freehold</span>
        <span class="hero-stat-lbl">Dubai Market Focus</span>
      </div>
    </div>

  </div>
</section>

<!-- Company Vision, Mission & Core Values Section -->
<section class="section-padding founders-vision-section">
  <div class="container">
    <div class="section-header text-center">
      <span class="section-badge">— OUR FOUNDATIONAL PILLARS —</span>
      <h2 class="section-title">Vision, Mission &amp; Guiding Principles</h2>
      <p class="section-subtitle">The enduring values shaping every client relationship and investment advisory at DRL Dwarika.</p>
    </div>

    <div class="pillars-grid">
      <!-- Vision Card -->
      <div class="pillar-card vision-card">
        <div class="pillar-icon-wrap">
          <i class="fa-solid fa-compass"></i>
        </div>
        <h3 class="pillar-title">Corporate Vision</h3>
        <p class="pillar-text">
          To stand as Dubai’s most transparent and respected real estate advisory institution, renowned worldwide for safeguarding client capital, unlocking generational prosperity, and fostering lasting partnerships across the UAE.
        </p>
      </div>

      <!-- Mission Card -->
      <div class="pillar-card mission-card">
        <div class="pillar-icon-wrap">
          <i class="fa-solid fa-bullseye"></i>
        </div>
        <h3 class="pillar-title">Corporate Mission</h3>
        <p class="pillar-text">
          Opening doors to prosperity by equipping global property seekers and institutional allocators with rigorous market data, authentic off-market inventory, and end-to-end conveyance security under Dubai Land Department frameworks.
        </p>
      </div>

      <!-- Governance Card -->
      <div class="pillar-card governance-card">
        <div class="pillar-icon-wrap">
          <i class="fa-solid fa-scale-balanced"></i>
        </div>
        <h3 class="pillar-title">Leadership Philosophy</h3>
        <p class="pillar-text">
          True stewardship in real estate transcends transactions. We operate with fiduciary rigor, impartial advice, and uncompromising ethics to ensure every family and corporate client achieves enduring value.
        </p>
      </div>
    </div>

    <!-- Core Values Row -->
    <div class="core-values-bar">
      <div class="value-item">
        <div class="value-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="value-info">
          <h4>Uncompromising Integrity</h4>
          <p>Absolute transparency in developer credentials, pricing, and conveyancing.</p>
        </div>
      </div>
      <div class="value-item">
        <div class="value-icon"><i class="fa-solid fa-chart-line"></i></div>
        <div class="value-info">
          <h4>Market Intelligence</h4>
          <p>Data-led forecasting across capital appreciation and rental yield cycles.</p>
        </div>
      </div>
      <div class="value-item">
        <div class="value-icon"><i class="fa-solid fa-gem"></i></div>
        <div class="value-info">
          <h4>Client Wealth Preservation</h4>
          <p>Protecting investor principal while capitalizing on high-growth freehold corridors.</p>
        </div>
      </div>
      <div class="value-item">
        <div class="value-icon"><i class="fa-solid fa-handshake"></i></div>
        <div class="value-info">
          <h4>Long-Term Stewardship</h4>
          <p>Guiding clients beyond the sale with turnkey property asset management.</p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Leadership Quote Banner -->
<section class="founders-quote-banner">
  <div class="container quote-container">
    <div class="quote-symbol"><i class="fa-solid fa-quote-left"></i></div>
    <blockquote class="editorial-quote">
      &ldquo;Together, let us build opportunities, create value, and turn aspirations into reality.&rdquo;
    </blockquote>
    <div class="quote-attribution">
      — Nitin Saxena, Founder &bull; DRL – Dwarika Real Estate LLC
    </div>
  </div>
</section>

<!-- Founders & Leadership Profiles Section -->
<section class="section-padding surface-bg" id="foundersProfiles">
  <div class="container">
    
    <div class="section-header">
      <span class="section-badge">— A MESSAGE FROM THE FOUNDER —</span>
      <h2 class="section-title">Leadership &amp; Corporate Vision</h2>
      <p class="section-subtitle">A message from Nitin Saxena, Founder of DRL – Dwarika Real Estate LLC.</p>
    </div>

    <!-- Dynamic Founders List -->
    <div class="founders-editorial-list">
      <?php if (!empty($foundersList)): ?>
        <?php foreach ($foundersList as $index => $founder): ?>
          <?php 
            $isDraft = ($founder['status'] ?? 'draft') === 'draft';
            $hasPhoto = !empty($founder['photo_url']);
            $missingFields = $founder['missing_fields'] ?? '';
          ?>
          <article class="founder-editorial-card <?= $index % 2 === 1 ? 'reverse' : '' ?>" id="founder-<?= e((string)$founder['id']) ?>">
            
            <!-- Founder Media Column -->
            <div class="founder-media-col">
              <div class="founder-frame">
                <?php if ($hasPhoto): 
                  $webpPhoto = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $founder['photo_url']);
                ?>
                  <picture>
                    <source srcset="<?= e($webpPhoto) ?>" type="image/webp">
                    <img src="<?= e($founder['photo_url']) ?>" alt="<?= e($founder['name']) ?>" class="founder-photo" loading="lazy" decoding="async" width="600" height="750">
                  </picture>
                <?php else: ?>
                  <div class="founder-placeholder-crest">
                    <div class="crest-monogram">
                      <i class="fa-solid fa-building-user"></i>
                    </div>
                    <span class="crest-caption"><?= e($founder['designation']) ?></span>
                    <span class="crest-corp">DRL DWARIKA REAL ESTATE LLC</span>
                  </div>
                <?php endif; ?>
                <div class="founder-role-tag">
                  <i class="fa-solid fa-star"></i> <?= e($founder['designation']) ?>
                </div>
              </div>
            </div>

            <!-- Founder Content Column -->
            <div class="founder-content-col">
              
              <!-- Draft / Administration Notice Badge -->
              <?php if ($isDraft): ?>
                <div class="draft-admin-notice">
                  <i class="fa-solid fa-circle-info"></i>
                  <div class="draft-notice-text">
                    <strong>Corporate Administration Record:</strong>
                    <span>Official executive dossier and verified biographical records are undergoing final certification by DRL Dwarika administration. Editable in the Admin Panel.</span>
                  </div>
                </div>
              <?php endif; ?>

              <div class="founder-header">
                <h3 class="founder-name"><?= e($founder['name']) ?></h3>
                <p class="founder-official-title"><?= e($founder['designation']) ?></p>
              </div>

              <?php if (!empty($founder['quote'])): ?>
                <div class="founder-personal-quote">
                  <i class="fa-solid fa-quote-left"></i>
                  <p>&ldquo;<?= e($founder['quote']) ?>&rdquo;</p>
                </div>
              <?php endif; ?>

              <div class="founder-bio-text">
                <?= nl2br(e($founder['full_bio'] ?? $founder['short_bio'] ?? '')) ?>
              </div>

              <?php if (!empty($founder['background'])): ?>
                <div class="founder-info-row">
                  <div class="info-block">
                    <span class="info-label"><i class="fa-solid fa-graduation-cap"></i> Professional Background</span>
                    <span class="info-value"><?= e($founder['background']) ?></span>
                  </div>
                </div>
              <?php endif; ?>

              <?php if (!empty($founder['leadership_areas'])): ?>
                <div class="founder-leadership-areas">
                  <span class="info-label"><i class="fa-solid fa-chess-knight"></i> Areas of Leadership &amp; Oversight</span>
                  <div class="areas-pill-group">
                    <?php 
                      $areas = array_map('trim', explode(',', $founder['leadership_areas']));
                      foreach ($areas as $area): 
                    ?>
                      <span class="area-pill"><i class="fa-solid fa-check"></i> <?= e($area) ?></span>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>

              <!-- Direct Executive Desk Contact -->
              <div class="founder-contact-actions">
                <?php if (!empty($founder['email'])): ?>
                  <a href="mailto:<?= e($founder['email']) ?>" class="btn-executive-contact email">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Contact Executive Office</span>
                  </a>
                <?php endif; ?>
                <a href="/contact-us" class="btn-executive-contact outline">
                  <i class="fa-solid fa-handshake"></i>
                  <span>Schedule Leadership Advisory</span>
                </a>
              </div>

            </div>

          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-results-box">
          <p>Founder profiles are currently being updated by the corporate administration.</p>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<!-- Closing Executive Consultation CTA -->
<section class="founders-closing-cta">
  <div class="container closing-cta-container">
    <div class="closing-cta-card">
      <div class="cta-inner-grid">
        <div class="cta-text-col">
          <span class="cta-pill-label">INSTITUTIONAL &amp; PRIVATE WEALTH ADVISORY</span>
          <h2 class="closing-cta-title">Looking to Partner with DRL Dwarika Real Estate LLC?</h2>
          <p class="closing-cta-desc">
            Whether you are an institutional developer exploring marketing syndication, a family office seeking sovereign wealth portfolio allocation, or an international investor desiring private counsel, our executive office is at your service.
          </p>
        </div>
        <div class="cta-btn-col">
          <a href="/contact-us" class="btn-primary-pill large">
            <span>Connect with Executive Leadership</span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="tel:<?= preg_replace('/[^0-9+]/', '', $settings['company_phone'] ?? '+971542202920') ?>" class="btn-call-subtle">
            <i class="fa-solid fa-phone"></i> Call Corporate Office: <?= e($settings['company_phone'] ?? '+971 542202920') ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
