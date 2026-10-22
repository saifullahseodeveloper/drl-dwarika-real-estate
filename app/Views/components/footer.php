<?php
/**
 * Footer Component — Exact match to DRL Dwarika reference design
 */
$phone = $settings['company_phone'] ?? '+971 542202920';
$cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
$email = $settings['company_email'] ?? 'admin@dwarikarealestate.ae';
$address = $settings['company_address'] ?? 'Dubai, UAE';
?>
<footer class="site-footer">
  <div class="footer-top container">
    <div class="footer-grid">
      <!-- Col 1: Brand & Logo -->
      <div class="footer-col footer-brand-col">
        <a href="/" class="footer-logo-link" aria-label="DRL Dwarika Real Estate LLC">
          <img src="/assets/images/logo-white.svg" alt="DRL Dwarika Real Estate LLC" width="180" height="60" class="footer-logo-img">
        </a>
        <p class="footer-tagline">
          Opening Doors To Prosperity — Your trusted real estate brokerage partner in Dubai, guiding you through premium residential and commercial investments with complete transparency.
        </p>
      </div>

      <!-- Col 2: Quick Links -->
      <div class="footer-col">
        <h4 class="footer-title">Quick Links</h4>
        <ul class="footer-links">
          <li><a href="/">Home</a></li>
          <li><a href="/about-us">About Us</a></li>
          <li><a href="/founders">Founders &amp; Leadership</a></li>
          <li><a href="/agents">Our Agents</a></li>
          <li><a href="/properties">Properties</a></li>
          <li><a href="/services">Services</a></li>
          <li><a href="/testimonials">Testimonials</a></li>
          <li><a href="/contact-us">Contact Us</a></li>
        </ul>
      </div>

      <!-- Col 3: Our Services -->
      <div class="footer-col">
        <h4 class="footer-title">Our Services</h4>
        <ul class="footer-links">
          <li><a href="/services/buy-property">Buy Home</a></li>
          <li><a href="/services/sell-property">Sell Property</a></li>
          <li><a href="/services/property-consultancy">Consultancy</a></li>
          <li><a href="/services/investment-advisory">Investment Advisory</a></li>
          <li><a href="/properties/off-plan">Off-Plan Projects</a></li>
          <li><a href="/properties/commercial">Commercial Real Estate</a></li>
        </ul>
      </div>

      <!-- Col 4: Get In Touch -->
      <div class="footer-col">
        <h4 class="footer-title">Get In Touch</h4>
        <ul class="footer-contact-list">
          <li>
            <i class="fa-solid fa-phone"></i>
            <a href="tel:<?= $cleanPhone ?>"><?= e($phone) ?></a>
          </li>
          <li>
            <i class="fa-solid fa-envelope"></i>
            <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
          </li>
          <li>
            <i class="fa-solid fa-location-dot"></i>
            <span><?= e($address) ?></span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Footer Bottom Bar -->
  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <p class="copyright-text">
        &copy; <?= date('Y') ?> Dwarika Real Estate LLC. All rights reserved.
      </p>
      <div class="footer-social-icons">
        <a href="<?= e($settings['social_facebook'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="<?= e($settings['social_instagram'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="<?= e($settings['social_linkedin'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="<?= e($settings['social_youtube'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
      </div>
    </div>
  </div>
</footer>
