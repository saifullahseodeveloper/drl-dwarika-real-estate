<?php
/**
 * Master Frontend Layout
 * DRL Dwarika Real Estate LLC
 */
$pageTitle = $meta_title ?? ($settings['meta_default_title'] ?? 'DRL Dwarika Real Estate LLC | Dubai');
$pageDesc = $meta_description ?? ($settings['meta_default_description'] ?? 'Premier Dubai real estate brokerage offering luxury villas, apartments, townhouses, and investment advisory.');
$canonical = $canonical_url ?? ('https://dwarikarealestate.ae' . ($_SERVER['REQUEST_URI'] ?? '/'));
$ogImage = $featured_image ?? '/assets/images/design-reference.jpg';
if (!str_starts_with($ogImage, 'http')) {
    $ogImage = 'https://dwarikarealestate.ae' . $ogImage;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDesc) ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?= e($canonical) ?>">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:title" content="<?= e($pageTitle) ?>">
  <meta property="og:description" content="<?= e($pageDesc) ?>">
  <meta property="og:image" content="<?= e($ogImage) ?>">
  <meta property="og:site_name" content="DRL Dwarika Real Estate LLC">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($pageTitle) ?>">
  <meta name="twitter:description" content="<?= e($pageDesc) ?>">
  <meta name="twitter:image" content="<?= e($ogImage) ?>">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assets/images/logo.png">

  <!-- DNS Prefetch & Preconnect for High-Speed Asset Handshake -->
  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

  <?php if (($activeNav ?? '') === 'home'): ?>
  <!-- Preload LCP Hero Image for Instant Mobile & Desktop Painting -->
  <link rel="preload" as="image" href="/assets/images/hero-building-mobile.webp" type="image/webp" media="(max-width: 768px)" fetchpriority="high">
  <link rel="preload" as="image" href="/assets/images/hero-building.webp" type="image/webp" media="(min-width: 769px)" fetchpriority="high">
  <?php endif; ?>

  <!-- Inline Critical Above-The-Fold CSS for Instant 0ms Render-Blocking Paint -->
  <?php 
  $criticalCssPath = (defined('APP_ROOT') ? APP_ROOT : dirname(__DIR__, 2)) . '/public/assets/css/critical.min.css';
  if (file_exists($criticalCssPath)): ?>
    <style id="critical-css"><?= file_get_contents($criticalCssPath) ?></style>
    <link rel="preload" as="style" href="/assets/css/styles.min.css">
    <link rel="stylesheet" href="/assets/css/styles.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="/assets/css/styles.min.css"></noscript>
  <?php else: ?>
    <link rel="preload" as="style" href="/assets/css/styles.min.css">
    <link rel="stylesheet" href="/assets/css/styles.min.css">
  <?php endif; ?>

  <!-- Google Fonts: Playfair Display & Plus Jakarta Sans (Non-blocking async load) -->
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
  <noscript>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  </noscript>

  <!-- Font Awesome 6 (Non-blocking async load) -->
  <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" media="print" onload="this.media='all'">
  <noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  </noscript>

  <!-- JSON-LD Structured Data: Organization & RealEstateAgent -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "RealEstateAgent",
    "name": "DRL Dwarika Real Estate LLC",
    "legalName": "DRL Dwarika Real Estate LLC",
    "url": "https://dwarikarealestate.ae",
    "logo": "https://dwarikarealestate.ae/assets/images/logo.png",
    "image": "https://dwarikarealestate.ae/assets/images/design-reference.jpg",
    "telephone": "+971501234567",
    "email": "info@dwarikarealestate.ae",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Office 702, Prime Tower, Business Bay",
      "addressLocality": "Dubai",
      "addressRegion": "Dubai",
      "addressCountry": "AE"
    },
    "priceRange": "AED 1,000,000 - 50,000,000"
  }
  </script>
</head>
<body>

  <!-- Flash Alerts (if any) -->
  <?php if ($flashSuccess = \App\Core\Session::flash('success')): ?>
    <div class="toast-notification success" id="toastAlert" role="alert">
      <i class="fa-solid fa-circle-check"></i>
      <span><?= e($flashSuccess) ?></span>
      <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
    </div>
  <?php endif; ?>
  <?php if ($flashError = \App\Core\Session::flash('error')): ?>
    <div class="toast-notification error" id="toastAlert" role="alert">
      <i class="fa-solid fa-circle-exclamation"></i>
      <span><?= e($flashError) ?></span>
      <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
    </div>
  <?php endif; ?>

  <!-- Top Site Header -->
  <?php \App\Core\View::component('header', ['settings' => $settings, 'activeNav' => $activeNav ?? 'home']); ?>

  <!-- Main Content Slot -->
  <main id="mainContent">
    <?= $content ?>
  </main>

  <!-- Pre-Footer CTA Banner (Reference design exact section) -->
  <section class="pre-footer-cta">
    <div class="container pre-footer-container">
      <div class="pre-footer-content">
        <h2 class="pre-footer-title">Ready to Find Your Dream Property?</h2>
        <p class="pre-footer-subtitle">Let’s make your real estate goals a reality. Get in touch with our experts today!</p>
      </div>
      <div class="pre-footer-action">
        <a href="/contact-us" class="btn-cta-white" id="btnPreFooterContact">
          <span>Contact Us</span>
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- Site Footer -->
  <?php \App\Core\View::component('footer', ['settings' => $settings]); ?>

  <!-- Core JavaScript (Minified & Deferred) -->
  <script src="/assets/js/app.min.js" defer></script>
</body>
</html>
