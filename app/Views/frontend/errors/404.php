<?php
/**
 * 404 Error Page
 */
?>
<section class="error-page-section section-padding text-center">
  <div class="container">
    <div class="error-card">
      <div class="error-code">404</div>
      <h1 class="error-title">Page Not Found</h1>
      <p class="error-desc"><?= e($message ?? "The property, community or page you are looking for does not exist or has been relocated.") ?></p>
      <div class="error-actions">
        <a href="/" class="btn-primary-pill">
          <i class="fa-solid fa-house"></i> Return Home
        </a>
        <a href="/properties" class="btn-outline-pill">
          <i class="fa-solid fa-magnifying-glass"></i> Explore Properties
        </a>
      </div>
    </div>
  </div>
</section>
