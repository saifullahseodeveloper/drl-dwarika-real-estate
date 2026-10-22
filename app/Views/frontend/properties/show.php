<?php
/**
 * Single Property Detail View
 * DRL Dwarika Real Estate LLC
 */
$cleanPhone = preg_replace('/[^0-9+]/', '', $settings['company_phone'] ?? '+971542202920');
$waPhone = preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '971542202920');
$currentUrl = 'https://dwarikarealestate.ae/property/' . $property['slug'];
?>

<div class="property-detail-header-bar">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li><a href="/properties">Properties</a></li>
        <?php if (!empty($property['location_name'])): ?>
          <li><a href="/locations/<?= e($property['location_slug']) ?>"><?= e($property['location_name']) ?></a></li>
        <?php endif; ?>
        <li aria-current="page"><?= e($property['title']) ?></li>
      </ol>
    </nav>
  </div>
</div>

<article class="property-detail-page section-padding">
  <div class="container">
    
    <!-- Top Summary Row: Title & Price -->
    <div class="property-title-price-row">
      <div class="property-title-col">
        <div class="property-badges-meta">
          <span class="badge-status <?= e($property['listing_type']) ?>">
            <?= ucfirst(e($property['listing_type'])) ?>
          </span>
          <span class="ref-code">Ref: <?= e($property['reference_code']) ?></span>
          <?php if (!empty($property['rera_permit'])): ?>
            <span class="rera-badge"><i class="fa-solid fa-certificate"></i> RERA: <?= e($property['rera_permit']) ?></span>
          <?php endif; ?>
        </div>
        <h1 class="single-property-title"><?= e($property['title']) ?></h1>
        <div class="single-property-location">
          <i class="fa-solid fa-location-dot"></i>
          <span><?= e($property['address'] ?: ($property['location_name'] . ', ' . ($property['location_city'] ?? 'Dubai'))) ?></span>
        </div>
      </div>

      <div class="property-price-col">
        <div class="price-label">Asking Price</div>
        <div class="single-property-price">
          <?= format_price($property['price'], $property['currency'] ?? 'AED') ?>
        </div>
      </div>
    </div>

    <!-- Gallery & Media -->
    <div class="property-gallery-wrap">
      <div class="main-gallery-viewport">
        <img id="mainGalleryImg" src="<?= e($property['featured_image']) ?>" alt="<?= e($property['title']) ?>" class="main-featured-photo">
      </div>
      <?php if (!empty($property['gallery']) && count($property['gallery']) > 1): ?>
        <div class="gallery-thumbs-row">
          <?php foreach ($property['gallery'] as $idx => $gImg): ?>
            <button type="button" class="thumb-btn <?= $idx === 0 ? 'active' : '' ?>" onclick="switchGalleryImg('<?= e($gImg['image_url']) ?>', this)">
              <img src="<?= e($gImg['image_url']) ?>" alt="<?= e($gImg['alt_text'] ?? $property['title']) ?>">
            </button>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Main Content Grid: Specs & Description vs Sidebar Form -->
    <div class="property-layout-grid">
      
      <!-- Left Column: Details -->
      <div class="property-main-col">
        
        <!-- Specs Bar -->
        <div class="property-specs-grid">
          <div class="spec-box">
            <i class="fa-solid fa-bed spec-icon"></i>
            <div class="spec-data">
              <span class="spec-value"><?= (int)$property['bedrooms'] > 0 ? (int)$property['bedrooms'] : 'N/A' ?></span>
              <span class="spec-name">Bedrooms</span>
            </div>
          </div>

          <div class="spec-box">
            <i class="fa-solid fa-bath spec-icon"></i>
            <div class="spec-data">
              <span class="spec-value"><?= (int)$property['bathrooms'] > 0 ? (int)$property['bathrooms'] : 'N/A' ?></span>
              <span class="spec-name">Bathrooms</span>
            </div>
          </div>

          <div class="spec-box">
            <i class="fa-solid fa-ruler-combined spec-icon"></i>
            <div class="spec-data">
              <span class="spec-value"><?= number_format((float)$property['area_sqft']) ?></span>
              <span class="spec-name">Sq. Ft.</span>
            </div>
          </div>

          <div class="spec-box">
            <i class="fa-solid fa-building spec-icon"></i>
            <div class="spec-data">
              <span class="spec-value"><?= e($property['type_name'] ?? 'Residential') ?></span>
              <span class="spec-name">Property Type</span>
            </div>
          </div>

          <?php if (!empty($property['completion_year'])): ?>
            <div class="spec-box">
              <i class="fa-solid fa-calendar-check spec-icon"></i>
              <div class="spec-data">
                <span class="spec-value"><?= e($property['completion_year']) ?></span>
                <span class="spec-name">Completion</span>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <!-- Description -->
        <div class="property-section-block">
          <h2 class="block-title">Overview &amp; Property Details</h2>
          <div class="property-desc-text">
            <?= nl2br(e($property['description'])) ?>
          </div>
        </div>

        <!-- Amenities -->
        <?php if (!empty($property['amenities'])): ?>
          <div class="property-section-block">
            <h2 class="block-title">Amenities &amp; Features</h2>
            <div class="amenities-badge-grid">
              <?php foreach ($property['amenities'] as $am): ?>
                <div class="amenity-item">
                  <i class="fa-solid <?= e($am['icon'] ?? 'fa-check') ?>"></i>
                  <span><?= e($am['name']) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Regulatory & Trust Assurance -->
        <div class="property-assurance-card">
          <div class="assurance-icon"><i class="fa-solid fa-shield-check"></i></div>
          <div class="assurance-content">
            <h4>Verified by DRL Dwarika Real Estate LLC</h4>
            <p>This property has been vetted through official title deeds and conforms to Dubai Land Department regulations. RERA ORN: <?= e($settings['rera_orn'] ?? '29482') ?>.</p>
          </div>
        </div>

      </div>

      <!-- Right Column: Enquiry Form & Agent Card -->
      <div class="property-sidebar-col">
        <div class="sticky-sidebar-card">
          <?php if (!empty($property['agent_name'])): ?>
            <div class="property-assigned-agent-badge" style="display:flex; align-items:center; gap:14px; background:#F0F7FC; padding:12px 16px; border-radius:12px; margin-bottom:18px; border:1px solid #E2EBF2;">
              <a href="/agents/<?= e($property['agent_slug']) ?>" style="flex-shrink:0;">
                <img src="<?= e($property['agent_photo']) ?>" alt="<?= e($property['agent_name']) ?>" style="width:52px; height:52px; border-radius:50%; object-fit:cover; border:2px solid #1689CC;">
              </a>
              <div style="flex:1; min-width:0;">
                <div style="font-size:0.75rem; font-weight:700; color:#1689CC; text-transform:uppercase; letter-spacing:0.5px;">Listing Specialist</div>
                <a href="/agents/<?= e($property['agent_slug']) ?>" style="font-weight:700; color:#0F1E2E; text-decoration:none; display:block; font-size:0.95rem; line-height:1.2;"><?= e($property['agent_name']) ?></a>
                <span style="font-size:0.8rem; color:#64748B;"><?= e($property['agent_designation']) ?></span>
              </div>
            </div>
          <?php endif; ?>

          <h3 class="inquiry-title">Inquire About This Property</h3>
          <p class="inquiry-subtitle">Book a private viewing or request floor plans with our luxury specialist.</p>

          <form action="/enquiry/submit" method="POST" class="property-inquiry-form" id="propertyInquiryForm">
            <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">
            <input type="hidden" name="property_id" value="<?= e((string)$property['id']) ?>">
            <input type="hidden" name="subject" value="Inquiry: <?= e($property['title']) ?> (<?= e($property['reference_code']) ?>)">
            
            <!-- Honeypot -->
            <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">

            <div class="form-group">
              <label for="leadName">Full Name *</label>
              <input type="text" name="name" id="leadName" class="form-input" placeholder="e.g. John Doe" required>
            </div>

            <div class="form-group">
              <label for="leadPhone">Phone / WhatsApp *</label>
              <input type="tel" name="phone" id="leadPhone" class="form-input" placeholder="+971 50 000 0000" required>
            </div>

            <div class="form-group">
              <label for="leadEmail">Email Address</label>
              <input type="email" name="email" id="leadEmail" class="form-input" placeholder="john@example.com">
            </div>

            <div class="form-group">
              <label for="leadMsg">Message</label>
              <textarea name="message" id="leadMsg" rows="3" class="form-textarea" placeholder="I am interested in scheduling a viewing for <?= e($property['title']) ?>..."></textarea>
            </div>

            <button type="submit" class="btn-primary-pill full-width btn-submit-lead" id="btnSubmitPropertyInquiry">
              <span>Send Inquiry</span>
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </form>

          <div class="quick-direct-contacts">
            <a href="https://wa.me/<?= $waPhone ?>?text=Hello%20Dwarika%20Real%20Estate,%20I%20am%20interested%20in%20<?= urlencode($property['title']) ?>%20(<?= $property['reference_code'] ?>):%20<?= urlencode($currentUrl) ?>" target="_blank" rel="noopener" class="btn-whatsapp-direct">
              <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
            </a>
            <a href="tel:<?= $cleanPhone ?>" class="btn-call-direct">
              <i class="fa-solid fa-phone"></i> Call Brokerage
            </a>
          </div>
        </div>
      </div>

    </div>

    <!-- Similar Properties Section -->
    <?php if (!empty($similar)): ?>
      <div class="similar-properties-block section-padding-top">
        <div class="section-header">
          <span class="section-badge">— SIMILAR LISTINGS —</span>
          <h2 class="section-title">Properties You May Also Like</h2>
        </div>
        <div class="properties-grid">
          <?php foreach ($similar as $simProp): ?>
            <?php \App\Core\View::component('property-card', ['property' => $simProp]); ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</article>

<!-- JSON-LD SingleFamilyResidence Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SingleFamilyResidence",
  "name": <?= json_encode($property['title']) ?>,
  "description": <?= json_encode(substr(strip_tags($property['description']), 0, 200)) ?>,
  "image": <?= json_encode($property['featured_image']) ?>,
  "url": <?= json_encode($currentUrl) ?>,
  "address": {
    "@type": "PostalAddress",
    "streetAddress": <?= json_encode($property['address'] ?: 'Dubai') ?>,
    "addressLocality": "Dubai",
    "addressCountry": "AE"
  },
  "offers": {
    "@type": "Offer",
    "price": <?= json_encode((float)$property['price']) ?>,
    "priceCurrency": "AED",
    "availability": "https://schema.org/InStock"
  },
  "numberOfRooms": <?= json_encode((int)$property['bedrooms']) ?>,
  "numberOfBathroomsTotal": <?= json_encode((int)$property['bathrooms']) ?>
}
</script>

<script>
function switchGalleryImg(src, btn) {
  document.getElementById('mainGalleryImg').src = src;
  document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
</script>
