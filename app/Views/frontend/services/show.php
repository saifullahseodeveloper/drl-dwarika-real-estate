<?php
/**
 * Single Service Detail View — DRL Dwarika Real Estate LLC
 */
$benefits = json_decode($service['benefits'] ?? '[]', true) ?: [];
$process = json_decode($service['process'] ?? '[]', true) ?: [];
$cleanPhone = preg_replace('/[^0-9+]/', '', $settings['company_phone'] ?? '+971542202920');
$waPhone    = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '971542202920');

$icon = match($service['slug']) {
  'buy-property'         => 'fa-house',
  'sell-property'        => 'fa-hand-holding-dollar',
  'property-consultancy' => 'fa-user-tie',
  'investment-advisory'  => 'fa-chart-line',
  default                => 'fa-briefcase'
};

$category = match($service['slug']) {
  'buy-property'         => 'Residential & Commercial Acquisition',
  'sell-property'        => 'Global Asset Disposition',
  'property-consultancy' => 'Strategic Advisory & Compliance',
  'investment-advisory'  => 'High-Yield Wealth Structuring',
  default                => 'Real Estate Service'
};
?>

<!-- Page Banner -->
<div class="page-banner service-detail-hero">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li><a href="/services">Services</a></li>
        <li aria-current="page"><?= e($service['title']) ?></li>
      </ol>
    </nav>
    <div class="service-hero-header-row">
      <div class="service-hero-icon-box">
        <i class="fa-solid <?= $icon ?>"></i>
      </div>
      <div>
        <span class="banner-pill-badge"><i class="fa-solid fa-certificate"></i> <?= e($category) ?></span>
        <h1 class="page-banner-title"><?= e($service['title']) ?></h1>
      </div>
    </div>
    <p class="page-banner-subtitle"><?= e($service['short_desc']) ?></p>
  </div>
</div>

<section class="service-detail-section section-padding">
  <div class="container">
    
    <div class="service-layout-grid">
      
      <!-- Main Content Column -->
      <div class="service-main-content">
        
        <!-- About This Service -->
        <div class="content-block service-overview-block">
          <div class="block-badge-row">
            <span class="block-badge"><i class="fa-solid fa-circle-info"></i> OVERVIEW &amp; SCOPE</span>
          </div>
          <h2 class="content-block-heading">About Our <?= e($service['title']) ?> Service</h2>
          <div class="body-text service-body-text">
            <?= nl2br(e($service['full_desc'])) ?>
          </div>
        </div>

        <!-- Key Benefits & Deliverables -->
        <?php if (!empty($benefits)): ?>
          <div class="content-block">
            <div class="block-badge-row">
              <span class="block-badge"><i class="fa-solid fa-star"></i> CLIENT ADVANTAGE</span>
            </div>
            <h3 class="content-block-heading">Key Benefits &amp; Deliverables</h3>
            <p class="content-block-sub">What you receive when partnering with DRL Dwarika for this service:</p>
            <div class="benefits-list-wrap">
              <?php foreach ($benefits as $benefit): ?>
                <div class="benefit-item">
                  <div class="benefit-icon-circle">
                    <i class="fa-solid fa-circle-check"></i>
                  </div>
                  <div class="benefit-text">
                    <?= e($benefit) ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Step-by-Step Process -->
        <?php if (!empty($process)): ?>
          <div class="content-block">
            <div class="block-badge-row">
              <span class="block-badge"><i class="fa-solid fa-route"></i> STRUCTURED ROADMAP</span>
            </div>
            <h3 class="content-block-heading">Our Proven Step-by-Step Process</h3>
            <p class="content-block-sub">A transparent, milestone-driven workflow ensuring zero friction and complete clarity:</p>
            <div class="process-steps-wrap">
              <?php foreach ($process as $idx => $step): ?>
                <div class="process-step-item">
                  <div class="step-num-col">
                    <div class="step-num"><?= sprintf('%02d', $idx + 1) ?></div>
                    <?php if ($idx < count($process) - 1): ?>
                      <div class="step-connector"></div>
                    <?php endif; ?>
                  </div>
                  <div class="step-desc-col">
                    <span class="step-phase-badge">Phase <?= $idx + 1 ?></span>
                    <h4 class="step-title"><?= e($step) ?></h4>
                    <p class="step-summary">Executed with strict adherence to Dubai Land Department regulations and private client discretion.</p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Reassurance Banner -->
        <div class="service-reassurance-card">
          <div class="reassurance-grid">
            <div class="reassurance-item">
              <i class="fa-solid fa-shield-halved"></i>
              <h4>100% Escrow Protected</h4>
              <p>All transactions comply with RERA trust accounts and DLD conveyance.</p>
            </div>
            <div class="reassurance-item">
              <i class="fa-solid fa-handshake-angle"></i>
              <h4>Dedicated Senior Lead</h4>
              <p>Direct communication with a seasoned Dubai market specialist.</p>
            </div>
            <div class="reassurance-item">
              <i class="fa-solid fa-clock-rotate-left"></i>
              <h4>End-to-End Speed</h4>
              <p>Swift contract drafting, valuation, and verified title transfer.</p>
            </div>
          </div>
        </div>

      </div>

      <!-- Sticky Sidebar -->
      <aside class="service-sidebar">
        
        <!-- Contact Specialist Card -->
        <div class="sidebar-card service-contact-card">
          <div class="card-header-badge">
            <span class="badge-mini"><i class="fa-solid fa-bolt"></i> FAST RESPONSE</span>
          </div>
          <h3 class="sidebar-card-title">Consult a Specialist</h3>
          <p class="sidebar-card-desc">Request a callback or schedule a confidential advisory session regarding <?= e($service['title']) ?>.</p>

          <form action="/enquiry/submit" method="POST" class="service-form" id="serviceEnquiryForm">
            <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">
            <input type="hidden" name="service_id" value="<?= e((string)$service['id']) ?>">
            <input type="hidden" name="subject" value="Service Request: <?= e($service['title']) ?>">
            <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">

            <div class="form-group">
              <label for="srvName" class="form-label">Full Name <span class="req">*</span></label>
              <div class="input-with-icon">
                <i class="fa-regular fa-user input-icon"></i>
                <input type="text" name="name" id="srvName" class="form-input" placeholder="e.g. David Miller" required>
              </div>
            </div>

            <div class="form-group">
              <label for="srvPhone" class="form-label">Phone / WhatsApp <span class="req">*</span></label>
              <div class="input-with-icon">
                <i class="fa-solid fa-phone input-icon"></i>
                <input type="tel" name="phone" id="srvPhone" class="form-input" placeholder="+971 50 000 0000" required>
              </div>
            </div>

            <div class="form-group">
              <label for="srvEmail" class="form-label">Email Address</label>
              <div class="input-with-icon">
                <i class="fa-regular fa-envelope input-icon"></i>
                <input type="email" name="email" id="srvEmail" class="form-input" placeholder="david@domain.com">
              </div>
            </div>

            <div class="form-group">
              <label for="srvMsg" class="form-label">Your Objectives / Requirements</label>
              <textarea name="message" id="srvMsg" rows="3" class="form-textarea" placeholder="Budget, timeline, preferred communities or advisory scope..."></textarea>
            </div>

            <button type="submit" class="btn-primary-pill full-width">
              <span>Send Advisory Request</span>
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </form>

          <div class="sidebar-direct-connect">
            <span class="direct-label">Or connect instantly via:</span>
            <div class="direct-buttons-row">
              <a href="tel:<?= $cleanPhone ?>" class="direct-btn direct-call" title="Call Us">
                <i class="fa-solid fa-phone"></i>
                <span>Call Desk</span>
              </a>
              <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I am inquiring about your ' . $service['title'] . ' service.') ?>" target="_blank" rel="noopener" class="direct-btn direct-wa" title="WhatsApp Us">
                <i class="fa-brands fa-whatsapp"></i>
                <span>WhatsApp</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Other Services List -->
        <div class="sidebar-card other-services-card">
          <h4 class="sidebar-card-title-sm"><i class="fa-solid fa-compass"></i> Other Real Estate Services</h4>
          <ul class="sidebar-services-list">
            <?php foreach ($allServices as $otherSrv): ?>
              <?php if ($otherSrv['id'] !== $service['id']): 
                $otherIcon = match($otherSrv['slug']) {
                  'buy-property'         => 'fa-house',
                  'sell-property'        => 'fa-hand-holding-dollar',
                  'property-consultancy' => 'fa-user-tie',
                  'investment-advisory'  => 'fa-chart-line',
                  default                => 'fa-briefcase'
                };
              ?>
                <li>
                  <a href="/services/<?= e($otherSrv['slug']) ?>" class="sidebar-service-link">
                    <div class="sidebar-service-meta">
                      <span class="sidebar-srv-icon"><i class="fa-solid <?= $otherIcon ?>"></i></span>
                      <span class="sidebar-srv-name"><?= e($otherSrv['title']) ?></span>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow-icon"></i>
                  </a>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- RERA Trust Card -->
        <div class="sidebar-card rera-compliance-box">
          <i class="fa-solid fa-certificate rera-icon"></i>
          <div>
            <strong>Licensed &amp; Regulated</strong>
            <p>DRL Dwarika Real Estate LLC is authorized by RERA under the Dubai Land Department.</p>
          </div>
        </div>

      </aside>

    </div>

  </div>
</section>
