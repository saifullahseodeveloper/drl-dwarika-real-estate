<?php
/**
 * Contact Us Page View — DRL Dwarika Real Estate LLC
 */
$phone = $settings['company_phone'] ?? '+971 542202920';
$cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
$waPhone = preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '971542202920');
$email = $settings['company_email'] ?? 'admin@dwarikarealestate.ae';
$address = $settings['company_address'] ?? 'Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira, Dubai, UAE';
?>

<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">Contact Us</li>
      </ol>
    </nav>
    <h1 class="page-banner-title">Contact Dwarika Real Estate LLC</h1>
    <p class="page-banner-subtitle">Get in touch with our team of luxury real estate consultants in Dubai. We are ready to assist you with inquiries, viewings, and property advisory.</p>
  </div>
</div>

<section class="contact-section section-padding">
  <div class="container">
    
    <div class="contact-layout-grid">
      <!-- Contact Info Cards -->
      <div class="contact-info-col">
        <div class="info-card">
          <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
          <div class="info-details">
            <h3>Direct Phone</h3>
            <p>Speak directly with our client advisory desk.</p>
            <a href="tel:<?= $cleanPhone ?>" class="info-link"><?= e($phone) ?></a>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon"><i class="fa-brands fa-whatsapp"></i></div>
          <div class="info-details">
            <h3>WhatsApp Concierge</h3>
            <p>Instant responses for property links &amp; viewings.</p>
            <a href="https://wa.me/<?= $waPhone ?>" target="_blank" rel="noopener" class="info-link">+<?= e($waPhone) ?></a>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
          <div class="info-details">
            <h3>Email Desk</h3>
            <p>Send detailed requirements or documentation.</p>
            <a href="mailto:<?= e($email) ?>" class="info-link"><?= e($email) ?></a>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div class="info-details">
            <h3>Brokerage Office</h3>
            <p><?= e($address) ?></p>
            <span class="rera-info">RERA ORN: <?= e($settings['rera_orn'] ?? '29482') ?> | DLD License: <?= e($settings['dld_license'] ?? '1637547') ?></span>
          </div>
        </div>
      </div>

      <!-- Contact Inquiry Form -->
      <div class="contact-form-col">
        <div class="contact-form-card">
          <h2 class="form-title">Send Us a Message</h2>
          <p class="form-subtitle">Fill in the form below and an advisor will be in touch within 2 hours.</p>

          <form action="/enquiry/submit" method="POST" id="mainContactForm" class="contact-form">
            <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">
            <input type="hidden" name="subject" value="General Contact Inquiry">
            <input type="text" name="website_hp" style="display:none;" tabindex="-1">

            <div class="form-row">
              <div class="form-group half-width">
                <label for="contactName">Full Name *</label>
                <input type="text" name="name" id="contactName" class="form-input" placeholder="e.g. Sarah Jenkins" required>
              </div>

              <div class="form-group half-width">
                <label for="contactPhone">Phone / WhatsApp *</label>
                <input type="tel" name="phone" id="contactPhone" class="form-input" placeholder="+971 542202920" required>
              </div>
            </div>

            <div class="form-group">
              <label for="contactEmail">Email Address</label>
              <input type="email" name="email" id="contactEmail" class="form-input" placeholder="sarah@example.com">
            </div>

            <div class="form-group">
              <label for="contactSubject">Subject of Inquiry</label>
              <select name="subject" id="contactSubject" class="form-select">
                <option value="Buying a Property in Dubai">Buying a Property in Dubai</option>
                <option value="Selling My Dubai Property">Selling My Dubai Property</option>
                <option value="Off-Plan Investment Advisory">Off-Plan Investment Advisory</option>
                <option value="10-Year Golden Visa Consultancy">10-Year Golden Visa Consultancy</option>
                <option value="Commercial Leasing or Acquisition">Commercial Leasing or Acquisition</option>
                <option value="General Inquiry">General Inquiry</option>
              </select>
            </div>

            <div class="form-group">
              <label for="contactMsg">Message / Specific Requests *</label>
              <textarea name="message" id="contactMsg" rows="4" class="form-textarea" placeholder="Tell us about the property type, preferred community, or budget..." required></textarea>
            </div>

            <button type="submit" class="btn-primary-pill full-width" id="btnSubmitContact">
              <span>Send Message</span>
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </form>
        </div>
      </div>

    </div>

  </div>
</section>
