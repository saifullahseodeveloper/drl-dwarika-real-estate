<?php
/**
 * Homepage View — Exact Master Design Replication for DRL Dwarika Real Estate LLC
 */
?>

<!-- 1. HERO SECTION -->
<section class="hero-section">
  <div class="container hero-container">
    
    <!-- Left Column: Hero Text & Trust Badges -->
    <div class="hero-content">
      <h1 class="hero-title">
        Opening Doors<br>
        To Prosperity
      </h1>
      <p class="hero-subtitle">
        Find your dream home with Dwarika Real Estate
      </p>

      <div class="hero-cta-group">
        <a href="/properties" class="btn-primary-pill" id="btnHeroExplore">
          <span>Explore Properties</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
        <a href="/contact-us" class="btn-outline-pill" id="btnHeroContact">
          <span>Contact Us</span>
        </a>
      </div>

      <!-- Trust Indicators Pill Badges -->
      <div class="hero-trust-badges">
        <div class="trust-badge-item">
          <div class="trust-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          </div>
          <div class="trust-text">
            <strong>Trusted</strong>
            <span>Real Estate Partner</span>
          </div>
        </div>

        <div class="trust-badge-item">
          <div class="trust-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="9" y1="22" x2="9" y2="2"></line><line x1="8" y1="6" x2="8.01" y2="6"></line><line x1="16" y1="6" x2="16.01" y2="6"></line><line x1="8" y1="10" x2="8.01" y2="10"></line><line x1="16" y1="10" x2="16.01" y2="10"></line><line x1="8" y1="14" x2="8.01" y2="14"></line><line x1="16" y1="14" x2="16.01" y2="14"></line><line x1="8" y1="18" x2="8.01" y2="18"></line><line x1="16" y1="18" x2="16.01" y2="18"></line></svg>
          </div>
          <div class="trust-text">
            <strong>Wide Range</strong>
            <span>of Properties</span>
          </div>
        </div>

        <div class="trust-badge-item">
          <div class="trust-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
          </div>
          <div class="trust-text">
            <strong>Transparent</strong>
            <span>&amp; Hassle-Free Deals</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Hero Real Estate Imagery -->
    <div class="hero-media-wrap">
      <div class="hero-image-card">
        <picture>
          <source media="(max-width: 768px)" srcset="/assets/images/hero-building-mobile-v3.webp" type="image/webp">
          <source media="(min-width: 769px)" srcset="/assets/images/hero-building-v3.webp" type="image/webp">
          <img src="/assets/images/hero-building-mobile-v3.webp" alt="Luxury Dubai Residences - DRL Dwarika Real Estate" width="480" height="360" class="hero-img" fetchpriority="high" decoding="async">
        </picture>
      </div>
    </div>

  </div>

  <!-- 2. QUICK PROPERTY SEARCH (Floating Overlapping Card) -->
  <div class="container search-container-wrap">
    <?php \App\Core\View::component('quick-search', [
        'locations'     => $locations,
        'propertyTypes' => $propertyTypes
    ]); ?>
  </div>
</section>

<!-- 3. OUR SERVICES SECTION -->
<section class="services-section section-padding">
  <div class="container">
    <div class="section-header text-center">
      <span class="section-badge">— OUR SERVICES —</span>
      <h2 class="section-title">How We Can Help You</h2>
    </div>

    <div class="services-grid">
      <?php foreach ($services as $service): ?>
        <?php \App\Core\View::component('service-card', ['service' => $service]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 4. FEATURED PROPERTIES SECTION -->
<section class="featured-section section-padding surface-bg">
  <div class="container">
    <div class="featured-header-row">
      <div class="header-left">
        <span class="section-badge">— FEATURED PROPERTIES —</span>
        <h2 class="section-title">Explore Our Best Properties</h2>
        <p class="section-desc">Find the perfect property that matches your lifestyle and budget.</p>
      </div>
      <div class="header-right">
        <a href="/properties" class="btn-primary-pill btn-view-all" id="btnViewAllProps">
          <span>View All Properties</span>
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </div>

    <!-- Properties Grid -->
    <div class="properties-grid">
      <?php if (!empty($featuredProperties)): ?>
        <?php foreach ($featuredProperties as $prop): ?>
          <?php \App\Core\View::component('property-card', ['property' => $prop]); ?>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-muted">No featured properties currently available. Check back soon!</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- 5. ABOUT DWARIKA REAL ESTATE LLC SECTION -->
<section class="about-section section-padding">
  <div class="container about-container">
    
    <!-- Left Column: Dubai Skyline Image with Handwritten Sticker -->
    <div class="about-media-col">
      <div class="about-image-card">
        <picture>
          <source srcset="/assets/images/burj-skyline.webp" type="image/webp">
          <img src="/assets/images/burj-skyline.jpg" alt="Dubai Downtown Skyline - Burj Khalifa" width="560" height="380" class="about-img" loading="lazy" decoding="async">
        </picture>
        <div class="handwritten-sticker">
          <span>Your Trusted<br>Real Estate Partner<br>in Dubai</span>
        </div>
      </div>
    </div>

    <!-- Right Column: Story & Statistics -->
    <div class="about-text-col">
      <span class="section-badge">— ABOUT DWARIKA REAL ESTATE LLC —</span>
      <h2 class="section-title">Building Dreams,<br>One Property at a Time</h2>
      
      <p class="about-paragraph">
        Dwarika Real Estate LLC is a trusted real estate brokerage in Dubai, helping individuals and families find the perfect property. With a commitment to transparency, professionalism, and personalized service, we make your real estate journey smooth and successful.
      </p>

      <!-- 3 Statistic Counters -->
      <div class="about-stats-row">
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_properties_sold'] ?? '100+') ?></div>
          <div class="stat-label">Properties Sold</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_happy_clients'] ?? '50+') ?></div>
          <div class="stat-label">Happy Clients</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-card">
          <div class="stat-number"><?= e($settings['stat_years_experience'] ?? '5+') ?></div>
          <div class="stat-label">Years Experience</div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- 6. WHAT OUR CLIENTS SAY (TESTIMONIALS) SECTION -->
<section class="testimonials-section section-padding surface-bg">
  <div class="container">
    <div class="section-header text-center">
      <span class="section-badge">— WHAT OUR CLIENTS SAY —</span>
      <h2 class="section-title">Trusted by Many, Loved by All</h2>
    </div>

    <!-- Testimonials Grid -->
    <div class="testimonials-grid" id="testimonialsTrack">
      <?php foreach ($testimonials as $testimonial): ?>
        <?php \App\Core\View::component('testimonial-card', ['testimonial' => $testimonial]); ?>
      <?php endforeach; ?>
    </div>

    <!-- Carousel Indicator Dots -->
    <div class="testimonial-carousel-dots" aria-hidden="true">
      <span class="dot active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </div>
</section>
