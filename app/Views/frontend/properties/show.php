<?php
/**
 * Single Property Detail View — DRL Dwarika Real Estate LLC
 * Master Luxury Architecture & Optimized Presentation
 */
$cleanPhone = preg_replace('/[^0-9+]/', '', $settings['company_phone'] ?? '+971542202920');
$waPhone    = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '971542202920');
$currentUrl = 'https://dwarikarealestate.ae/properties/' . $property['slug'];

$statusClass = match(strtolower($property['listing_type'] ?? 'sale')) {
  'sale'     => 'status-sale',
  'rent'     => 'status-rent',
  'off-plan' => 'status-offplan',
  default    => 'status-sale'
};

$statusLabel = match(strtolower($property['listing_type'] ?? 'sale')) {
  'sale'     => 'For Sale',
  'rent'     => 'For Rent',
  'off-plan' => 'Off-Plan',
  default    => 'For Sale'
};
?>

<!-- Luxury Property Hero Banner -->
<div class="page-banner property-hero-banner">
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

    <!-- Top Status Badges Row -->
    <div class="property-badges-meta">
      <span class="badge-status-pill <?= $statusClass ?>"><?= e($statusLabel) ?></span>
      <span class="badge-pill-outline"><i class="fa-solid fa-hashtag"></i> Ref: <?= e($property['reference_code']) ?></span>
      <?php if (!empty($property['rera_permit'])): ?>
        <span class="badge-pill-outline badge-rera"><i class="fa-solid fa-circle-check"></i> RERA: <?= e($property['rera_permit']) ?></span>
      <?php endif; ?>
      <?php if (!empty($property['type_name'])): ?>
        <span class="badge-pill-outline"><?= e($property['type_name']) ?></span>
      <?php endif; ?>
    </div>

    <!-- Title & Price Flex Row -->
    <div class="property-banner-inner-row">
      <div class="property-banner-info">
        <h1 class="page-banner-title property-banner-title"><?= e($property['title']) ?></h1>
        <div class="property-banner-address">
          <i class="fa-solid fa-location-dot"></i>
          <span><?= e($property['address'] ?: ($property['location_name'] . ', ' . ($property['location_city'] ?? 'Dubai'))) ?></span>
        </div>
      </div>

      <div class="property-banner-price-card">
        <span class="price-eyebrow">OFFICIAL ASKING PRICE</span>
        <div class="price-value-main" data-price-aed="<?= (float)$property['price'] ?>">
          <?= format_price($property['price'], $property['currency'] ?? 'AED') ?>
        </div>
        <div class="price-quick-actions">
          <a href="#inquirySidebar" class="btn-primary-pill btn-banner-action">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Schedule Viewing</span>
          </a>
          <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I am interested in ' . $property['title'] . ' (Ref: ' . $property['reference_code'] . '): ' . $currentUrl) ?>" target="_blank" rel="noopener" class="btn-whatsapp btn-banner-action">
            <i class="fa-brands fa-whatsapp"></i>
            <span>WhatsApp</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Property Content Area -->
<article class="property-detail-page section-padding">
  <div class="container">
    
    <!-- Floating Key Specifications Strip -->
    <div class="property-specs-strip">
      <div class="spec-cell">
        <div class="spec-cell-icon"><i class="fa-solid fa-bed"></i></div>
        <div class="spec-cell-info">
          <span class="spec-cell-val"><?= (int)$property['bedrooms'] > 0 ? (int)$property['bedrooms'] . ' Beds' : 'Studio' ?></span>
          <span class="spec-cell-lbl">Bedrooms</span>
        </div>
      </div>

      <div class="spec-cell">
        <div class="spec-cell-icon"><i class="fa-solid fa-bath"></i></div>
        <div class="spec-cell-info">
          <span class="spec-cell-val"><?= (int)$property['bathrooms'] > 0 ? (int)$property['bathrooms'] . ' Baths' : '1 Bath' ?></span>
          <span class="spec-cell-lbl">Bathrooms</span>
        </div>
      </div>

      <div class="spec-cell">
        <div class="spec-cell-icon"><i class="fa-solid fa-ruler-combined"></i></div>
        <div class="spec-cell-info">
          <span class="spec-cell-val"><?= number_format((float)$property['area_sqft']) ?></span>
          <span class="spec-cell-lbl">Sq. Ft. Built-Up</span>
        </div>
      </div>

      <div class="spec-cell">
        <div class="spec-cell-icon"><i class="fa-solid fa-building"></i></div>
        <div class="spec-cell-info">
          <span class="spec-cell-val"><?= e($property['type_name'] ?? 'Residential') ?></span>
          <span class="spec-cell-lbl">Property Type</span>
        </div>
      </div>

      <?php if (!empty($property['completion_year'])): ?>
        <div class="spec-cell">
          <div class="spec-cell-icon"><i class="fa-solid fa-calendar-check"></i></div>
          <div class="spec-cell-info">
            <span class="spec-cell-val"><?= e($property['completion_year']) ?></span>
            <span class="spec-cell-lbl">Handover Year</span>
          </div>
        </div>
      <?php elseif (!empty($property['furnished_status'])): ?>
        <div class="spec-cell">
          <div class="spec-cell-icon"><i class="fa-solid fa-couch"></i></div>
          <div class="spec-cell-info">
            <span class="spec-cell-val"><?= ucfirst(e($property['furnished_status'])) ?></span>
            <span class="spec-cell-lbl">Furnishing</span>
          </div>
        </div>
      <?php else: ?>
        <div class="spec-cell">
          <div class="spec-cell-icon"><i class="fa-solid fa-shield-halved"></i></div>
          <div class="spec-cell-info">
            <span class="spec-cell-val">Freehold</span>
            <span class="spec-cell-lbl">Ownership</span>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Gallery & Media Stage -->
    <div class="property-gallery-wrap">
      <div class="main-gallery-viewport">
        <img id="mainGalleryImg" src="<?= e($property['featured_image']) ?>" alt="<?= e($property['title']) ?>" class="main-featured-photo" loading="eager">
        <div class="gallery-verified-badge">
          <i class="fa-solid fa-shield-check"></i>
          <span>Verified Listing &amp; Title</span>
        </div>
      </div>
      <?php if (!empty($property['gallery']) && count($property['gallery']) > 1): ?>
        <div class="gallery-thumbs-row">
          <?php foreach ($property['gallery'] as $idx => $gImg): ?>
            <button type="button" class="thumb-btn <?= $idx === 0 ? 'active' : '' ?>" onclick="switchGalleryImg('<?= e($gImg['image_url']) ?>', this)" aria-label="View photo <?= $idx + 1 ?>">
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
        
        <!-- Description Block -->
        <div class="property-section-block">
          <div class="block-badge-row">
            <span class="block-badge"><i class="fa-solid fa-circle-info"></i> OVERVIEW &amp; DETAILS</span>
          </div>
          <h2 class="block-title">About This Residence</h2>
          <div class="property-desc-text">
            <?= nl2br(e($property['description'])) ?>
          </div>
        </div>

        <!-- Amenities Block -->
        <?php if (!empty($property['amenities'])): ?>
          <div class="property-section-block">
            <div class="block-badge-row">
              <span class="block-badge"><i class="fa-solid fa-star"></i> FEATURES &amp; LIFESTYLE</span>
            </div>
            <h2 class="block-title">Premium Amenities &amp; Facilities</h2>
            <div class="amenities-badge-grid">
              <?php foreach ($property['amenities'] as $am): ?>
                <div class="amenity-item">
                  <div class="amenity-item-icon">
                    <i class="fa-solid <?= e($am['icon'] ?? 'fa-check') ?>"></i>
                  </div>
                  <span class="amenity-item-name"><?= e($am['name']) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Location Highlights Card -->
        <?php if (!empty($property['location_name'])): ?>
          <div class="property-section-block community-context-card">
            <div class="community-context-header">
              <div>
                <span class="block-badge"><i class="fa-solid fa-compass"></i> LOCATION &amp; COMMUNITY</span>
                <h3 class="community-context-title"><?= e($property['location_name']) ?></h3>
              </div>
              <a href="/locations/<?= e($property['location_slug']) ?>" class="btn-outline-pill btn-sm">
                <span>Explore Community</span>
                <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
            <p class="community-context-desc">
              <?= e($property['location_description'] ?? 'One of Dubai\'s most prestigious freehold residential and investment destinations, offering unmatched capital growth, luxury lifestyle amenities, and prime connectivity.') ?>
            </p>
          </div>
        <?php endif; ?>

        <!-- Regulatory & Trust Assurance -->
        <div class="property-assurance-card">
          <div class="assurance-icon"><i class="fa-solid fa-certificate"></i></div>
          <div class="assurance-content">
            <h4>Verified by DRL Dwarika Real Estate LLC</h4>
            <p>
              This listing has been verified with authentic Dubai Land Department title deeds. All purchase and escrow settlements are strictly governed under RERA regulations. <strong>RERA ORN: <?= e($settings['rera_orn'] ?? '29482') ?></strong>.
            </p>
          </div>
        </div>

      </div>

      <!-- Right Column: Enquiry Form & Agent Card -->
      <div class="property-sidebar-col" id="inquirySidebar">
        <div class="sticky-sidebar-card">
          
          <?php if (!empty($property['agent_name'])): ?>
            <div class="property-assigned-agent-badge">
              <a href="/agents/<?= e($property['agent_slug']) ?>" class="agent-avatar-wrap">
                <img src="<?= e($property['agent_photo']) ?>" alt="<?= e($property['agent_name']) ?>">
              </a>
              <div class="agent-badge-meta">
                <span class="agent-tag">LISTING SPECIALIST</span>
                <a href="/agents/<?= e($property['agent_slug']) ?>" class="agent-badge-name"><?= e($property['agent_name']) ?></a>
                <span class="agent-badge-desig"><?= e($property['agent_designation']) ?></span>
              </div>
            </div>
          <?php endif; ?>

          <h3 class="inquiry-title">Schedule a Private Viewing</h3>
          <p class="inquiry-subtitle">Directly contact our certified specialist for floor plans, video walkthroughs, and private viewings.</p>

          <form action="/enquiry/submit" method="POST" class="property-inquiry-form" id="propertyInquiryForm">
            <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">
            <input type="hidden" name="property_id" value="<?= e((string)$property['id']) ?>">
            <input type="hidden" name="subject" value="Inquiry: <?= e($property['title']) ?> (Ref: <?= e($property['reference_code']) ?>)">
            
            <!-- Honeypot -->
            <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">

            <div class="form-group">
              <label for="leadName" class="form-label">Full Name <span class="req">*</span></label>
              <div class="input-with-icon">
                <i class="fa-regular fa-user input-icon"></i>
                <input type="text" name="name" id="leadName" class="form-input" placeholder="e.g. John Doe" required>
              </div>
            </div>

            <div class="form-group">
              <label for="leadPhone" class="form-label">Phone / WhatsApp <span class="req">*</span></label>
              <div class="input-with-icon">
                <i class="fa-solid fa-phone input-icon"></i>
                <input type="tel" name="phone" id="leadPhone" class="form-input" placeholder="+971 50 000 0000" required>
              </div>
            </div>

            <div class="form-group">
              <label for="leadEmail" class="form-label">Email Address</label>
              <div class="input-with-icon">
                <i class="fa-regular fa-envelope input-icon"></i>
                <input type="email" name="email" id="leadEmail" class="form-input" placeholder="john@example.com">
              </div>
            </div>

            <div class="form-group">
              <label for="leadMsg" class="form-label">Your Viewing Requirements</label>
              <textarea name="message" id="leadMsg" rows="3" class="form-textarea" placeholder="I am interested in scheduling a viewing for <?= e($property['title']) ?>..."></textarea>
            </div>

            <button type="submit" class="btn-primary-pill full-width btn-submit-lead" id="btnSubmitPropertyInquiry">
              <span>Send Inquiry &amp; Book Viewing</span>
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </form>

          <div class="sidebar-direct-connect">
            <span class="direct-label">Or connect instantly via:</span>
            <div class="direct-buttons-row">
              <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I am interested in ' . $property['title'] . ' (' . $property['reference_code'] . '): ' . $currentUrl) ?>" target="_blank" rel="noopener" class="direct-btn direct-wa">
                <i class="fa-brands fa-whatsapp"></i>
                <span>WhatsApp</span>
              </a>
              <a href="tel:<?= $cleanPhone ?>" class="direct-btn direct-call">
                <i class="fa-solid fa-phone"></i>
                <span>Call Desk</span>
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Similar Properties Section -->
    <?php if (!empty($similar)): ?>
      <div class="similar-properties-block section-padding-top">
        <div class="section-header-row">
          <div>
            <span class="section-badge">— CURATED RECOMMENDATIONS —</span>
            <h2 class="section-title">Similar Properties You May Like</h2>
          </div>
          <a href="/properties" class="btn-outline-pill">
            <span>View All Properties</span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
        <div class="properties-grid">
          <?php foreach ($similar as $simProp): ?>
            <?php \App\Core\View::component('property-card', ['property' => $simProp]); ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>

  <!-- Mobile Sticky Floating Contact Bar (Only visible on mobile screens) -->
  <div class="property-mobile-sticky-bar" id="propMobileStickyBar">
    <div class="sticky-bar-price-col">
      <span class="sticky-bar-eyebrow">Price</span>
      <span class="sticky-bar-price-num"><?= format_price($property['price'], $property['currency'] ?? 'AED') ?></span>
    </div>
    <div class="sticky-bar-btn-group">
      <a href="https://wa.me/<?= $waPhone ?>?text=<?= urlencode('Hello DRL Dwarika, I am interested in ' . $property['title'] . ' (' . $property['reference_code'] . '): ' . $currentUrl) ?>" target="_blank" rel="noopener" class="btn-sticky-action btn-sticky-wa" aria-label="WhatsApp Us">
        <i class="fa-brands fa-whatsapp"></i>
        <span>WhatsApp</span>
      </a>
      <a href="tel:<?= $cleanPhone ?>" class="btn-sticky-action btn-sticky-call" aria-label="Call Brokerage">
        <i class="fa-solid fa-phone"></i>
        <span>Call</span>
      </a>
    </div>
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
  const mainImg = document.getElementById('mainGalleryImg');
  if (mainImg) {
    mainImg.src = src;
  }
  document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');
}
</script>
