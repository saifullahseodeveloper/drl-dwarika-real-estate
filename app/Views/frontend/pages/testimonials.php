<?php
/**
 * Testimonials Page View — Client Reviews & Stories
 * DRL Dwarika Real Estate LLC
 */
$cleanPhone = preg_replace('/[^0-9+]/', '', $settings['company_phone'] ?? '+971542202920');
$waPhone = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '971542202920');
?>

<!-- Page Banner -->
<div class="page-banner testimonials-hero-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">Testimonials</li>
      </ol>
    </nav>
    <span class="banner-pill-badge"><i class="fa-solid fa-star"></i> VERIFIED CLIENT REVIEWS</span>
    <h1 class="page-banner-title">Client Stories &amp; Testimonials</h1>
    <p class="page-banner-subtitle">
      Discover how DRL Dwarika Real Estate LLC has empowered families, international investors, and business leaders to achieve their property aspirations in Dubai.
    </p>
  </div>
</div>

<section class="testimonials-page-section section-padding">
  <div class="container">
    <div class="testimonials-header-intro text-center">
      <span class="section-badge">— PROVEN TRACK RECORD —</span>
      <h2 class="section-title">Reputation Built on Trust &amp; Results</h2>
      <p class="section-desc" style="margin: 0 auto 48px;">
        Read firsthand accounts of the white-glove service, market acumen, and seamless transactions our clients experience.
      </p>
    </div>

    <div class="testimonials-full-grid">
      <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-large-card">
          <div class="card-quote-icon">
            <i class="fa-solid fa-quote-left"></i>
          </div>
          <div class="star-rating">
            <?php for ($i = 0; $i < (int)($t['rating'] ?? 5); $i++): ?>
              <i class="fa-solid fa-star"></i>
            <?php endfor; ?>
          </div>
          <p class="quote-text">&ldquo;<?= e($t['quote']) ?>&rdquo;</p>
          <div class="author-meta-row">
            <div class="author-initial-circle"><?= e($t['avatar_initial'] ?: substr($t['client_name'], 0, 1)) ?></div>
            <div class="author-details">
              <h4 class="author-name"><?= e($t['client_name']) ?></h4>
              <span class="author-location"><?= e($t['client_title'] ? $t['client_title'] . ', ' : '') ?><?= e($t['location'] ?? 'Dubai, UAE') ?></span>
            </div>
            <div class="verified-review-badge">
              <i class="fa-solid fa-circle-check"></i> Verified Client
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Review CTA Box -->
    <div class="testimonial-bottom-cta">
      <div class="cta-inner">
        <h3>Begin Your Own Dubai Real Estate Success Story</h3>
        <p>Whether buying, selling, or structuring high-yield portfolios, our advisors are here for you.</p>
        <div class="cta-btns">
          <a href="/contact" class="btn-primary-pill">
            <span>Contact an Advisor</span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="https://wa.me/<?= $waPhone ?>" target="_blank" rel="noopener" class="btn-whatsapp">
            <i class="fa-brands fa-whatsapp"></i>
            <span>Chat on WhatsApp</span>
          </a>
        </div>
      </div>
    </div>

  </div>
</section>
