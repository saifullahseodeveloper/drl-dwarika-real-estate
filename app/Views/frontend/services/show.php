<?php
/**
 * Single Service Detail View
 */
$benefits = json_decode($service['benefits'] ?? '[]', true) ?: [];
$process = json_decode($service['process'] ?? '[]', true) ?: [];
$cleanPhone = preg_replace('/[^0-9+]/', '', $settings['company_phone'] ?? '+971542202920');
?>

<div class="page-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li><a href="/services">Services</a></li>
        <li aria-current="page"><?= e($service['title']) ?></li>
      </ol>
    </nav>
    <h1 class="page-banner-title"><?= e($service['title']) ?></h1>
    <p class="page-banner-subtitle"><?= e($service['short_desc']) ?></p>
  </div>
</div>

<section class="service-detail-section section-padding">
  <div class="container">
    
    <div class="service-layout-grid">
      <!-- Main Content -->
      <div class="service-main-content">
        <div class="content-block">
          <h2>About Our <?= e($service['title']) ?> Service</h2>
          <div class="body-text">
            <?= nl2br(e($service['full_desc'])) ?>
          </div>
        </div>

        <?php if (!empty($benefits)): ?>
          <div class="content-block">
            <h3>Key Benefits &amp; Deliverables</h3>
            <div class="benefits-list-wrap">
              <?php foreach ($benefits as $benefit): ?>
                <div class="benefit-item">
                  <i class="fa-solid fa-circle-check benefit-check"></i>
                  <span><?= e($benefit) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($process)): ?>
          <div class="content-block">
            <h3>Our Proven Step-by-Step Process</h3>
            <div class="process-steps-wrap">
              <?php foreach ($process as $idx => $step): ?>
                <div class="process-step-item">
                  <div class="step-num"><?= $idx + 1 ?></div>
                  <div class="step-desc">
                    <strong>Phase <?= $idx + 1 ?></strong>
                    <p><?= e($step) ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Sidebar Enquiry -->
      <div class="service-sidebar">
        <div class="sidebar-card service-contact-card">
          <h3>Consult a Specialist</h3>
          <p>Get in touch for bespoke advice regarding <?= e($service['title']) ?> in Dubai.</p>

          <form action="/enquiry/submit" method="POST" class="service-form">
            <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">
            <input type="hidden" name="service_id" value="<?= e((string)$service['id']) ?>">
            <input type="hidden" name="subject" value="Service Request: <?= e($service['title']) ?>">
            <input type="text" name="website_hp" style="display:none;" tabindex="-1">

            <div class="form-group">
              <label for="srvName">Full Name *</label>
              <input type="text" name="name" id="srvName" class="form-input" placeholder="Your name" required>
            </div>

            <div class="form-group">
              <label for="srvPhone">Phone / WhatsApp *</label>
              <input type="tel" name="phone" id="srvPhone" class="form-input" placeholder="+971 50 000 0000" required>
            </div>

            <div class="form-group">
              <label for="srvEmail">Email Address</label>
              <input type="email" name="email" id="srvEmail" class="form-input" placeholder="name@domain.com">
            </div>

            <div class="form-group">
              <label for="srvMsg">Details / Requirements</label>
              <textarea name="message" id="srvMsg" rows="3" class="form-textarea" placeholder="Describe your budget, timeline, or requirements..."></textarea>
            </div>

            <button type="submit" class="btn-primary-pill full-width">
              <span>Submit Request</span>
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </form>

          <div class="sidebar-call-box">
            <span>Or call us directly at:</span>
            <a href="tel:<?= $cleanPhone ?>" class="phone-link"><?= e($settings['company_phone'] ?? '+971 542202920') ?></a>
          </div>
        </div>

        <!-- Other Services List -->
        <div class="sidebar-card">
          <h4>Other Services</h4>
          <ul class="sidebar-services-list">
            <?php foreach ($allServices as $otherSrv): ?>
              <?php if ($otherSrv['id'] !== $service['id']): ?>
                <li>
                  <a href="/services/<?= e($otherSrv['slug']) ?>">
                    <span><?= e($otherSrv['title']) ?></span>
                    <i class="fa-solid fa-chevron-right"></i>
                  </a>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

  </div>
</section>
