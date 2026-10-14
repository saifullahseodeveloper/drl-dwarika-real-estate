<?php
/**
 * Testimonials Page View — Client Reviews
 */
?>

<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">Testimonials</li>
      </ol>
    </nav>
    <h1 class="page-banner-title">Client Stories &amp; Testimonials</h1>
    <p class="page-banner-subtitle">Discover how DRL Dwarika Real Estate LLC has empowered families, investors, and business leaders to achieve their property aspirations in Dubai.</p>
  </div>
</div>

<section class="testimonials-page-section section-padding">
  <div class="container">
    <div class="testimonials-full-grid">
      <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-large-card">
          <div class="card-quote-icon">
            <i class="fa-solid fa-quote-left"></i>
          </div>
          <p class="quote-text">&ldquo;<?= e($t['quote']) ?>&rdquo;</p>
          <div class="author-meta-row">
            <div class="author-initial-circle"><?= e($t['avatar_initial']) ?></div>
            <div class="author-details">
              <h4><?= e($t['client_name']) ?></h4>
              <span><?= e($t['client_title'] ? $t['client_title'] . ', ' : '') ?><?= e($t['location']) ?></span>
            </div>
            <div class="star-rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
