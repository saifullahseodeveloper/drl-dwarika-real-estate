<?php
/**
 * Individual Agent Profile View — DRL Dwarika Real Estate LLC
 */
$languages = $agent['languages'] ?? [];
$specializations = $agent['specializations'] ?? [];
$locations = $agent['locations'] ?? [];
$phone = $agent['phone'] ?? '+971 50 123 4567';
$cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
$whatsapp = $agent['whatsapp'] ?? '971501234567';
$email = $agent['email'] ?? 'info@dwarikarealestate.ae';
$photo = !empty($agent['photo_url']) ? $agent['photo_url'] : '/assets/images/agents/omar-farooq.jpg';
$rera = $agent['rera_brn'] ?? '';
$experience = $agent['experience'] ?? '';
?>

<!-- Schema.org Person JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": <?= json_encode($agent['name']) ?>,
  "jobTitle": <?= json_encode($agent['designation']) ?>,
  "image": <?= json_encode('https://dwarikarealestate.ae' . $photo) ?>,
  "telephone": <?= json_encode($phone) ?>,
  "email": <?= json_encode($email) ?>,
  "worksFor": {
    "@type": "RealEstateAgent",
    "name": "DRL Dwarika Real Estate LLC",
    "url": "https://dwarikarealestate.ae"
  },
  "knowsAbout": <?= json_encode(array_merge($specializations, $locations)) ?>
}
</script>

<!-- Agent Profile Header Hero -->
<div class="agent-profile-banner">
  <div class="container">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li><a href="/agents">Agents</a></li>
        <li aria-current="page"><?= e($agent['name']) ?></li>
      </ol>
    </nav>

    <div class="agent-hero-card">
      <div class="agent-hero-media">
        <img src="<?= e($photo) ?>" alt="<?= e($agent['name']) ?>" width="280" height="280" class="agent-hero-avatar">
        <div class="agent-verified-badge">
          <i class="fa-solid fa-circle-check"></i> Verified RERA Agent
        </div>
      </div>

      <div class="agent-hero-details">
        <div class="agent-hero-badges">
          <?php if ($rera): ?>
            <span class="hero-pill-badge"><i class="fa-solid fa-id-badge"></i> RERA BRN: <?= e($rera) ?></span>
          <?php endif; ?>
          <?php if ($experience): ?>
            <span class="hero-pill-badge accent"><i class="fa-solid fa-award"></i> <?= e($experience) ?></span>
          <?php endif; ?>
        </div>

        <h1 class="agent-hero-name"><?= e($agent['name']) ?></h1>
        <p class="agent-hero-title"><?= e($agent['designation']) ?> at DRL Dwarika Real Estate LLC</p>

        <p class="agent-hero-summary"><?= e($agent['short_bio']) ?></p>

        <div class="agent-hero-contact-bar">
          <a href="tel:<?= $cleanPhone ?>" class="btn-hero-contact call">
            <i class="fa-solid fa-phone"></i>
            <span>Call <?= e($phone) ?></span>
          </a>
          <a href="https://wa.me/<?= $whatsapp ?>?text=Hello%20<?= urlencode($agent['name']) ?>,%20I%20am%20inquiring%20about%20properties%20via%20DRL%20Dwarika." target="_blank" rel="noopener" class="btn-hero-contact whatsapp">
            <i class="fa-brands fa-whatsapp"></i>
            <span>Chat on WhatsApp</span>
          </a>
          <a href="mailto:<?= e($email) ?>" class="btn-hero-contact email">
            <i class="fa-solid fa-envelope"></i>
            <span>Email Agent</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Profile Content Grid -->
<section class="section-padding">
  <div class="container">
    <div class="property-layout-grid">
      
      <!-- Left Column: Biography, Expertise, Testimonials, Properties -->
      <div class="property-main-col">
        
        <!-- Biography & Professional Background -->
        <div class="property-section-block">
          <h2 class="block-title">Professional Biography &amp; Experience</h2>
          <div class="agent-bio-body">
            <?= nl2br(e($agent['full_bio'])) ?>
          </div>
        </div>

        <!-- Specializations & Fluency Grid -->
        <div class="property-section-block">
          <h2 class="block-title">Advisory Focus &amp; Fluency</h2>
          <div class="agent-meta-spec-grid">
            
            <div class="spec-category-box">
              <h3 class="spec-cat-title"><i class="fa-solid fa-briefcase"></i> Specializations</h3>
              <div class="pill-group">
                <?php foreach ($specializations as $spec): ?>
                  <span class="spec-tag"><i class="fa-solid fa-check"></i> <?= e(ucfirst($spec)) ?></span>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="spec-category-box">
              <h3 class="spec-cat-title"><i class="fa-solid fa-language"></i> Spoken Languages</h3>
              <div class="pill-group">
                <?php foreach ($languages as $lang): ?>
                  <span class="spec-tag language"><i class="fa-solid fa-globe"></i> <?= e($lang) ?></span>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="spec-category-box full">
              <h3 class="spec-cat-title"><i class="fa-solid fa-map-location-dot"></i> Prime Communities Covered</h3>
              <div class="pill-group">
                <?php foreach ($locations as $loc): ?>
                  <span class="spec-tag location"><i class="fa-solid fa-location-dot"></i> <?= e($loc) ?></span>
                <?php endforeach; ?>
              </div>
            </div>

          </div>
        </div>

        <!-- Authentic Client Testimonial (When available) -->
        <?php if (!empty($agent['testimonial_quote'])): ?>
          <div class="property-section-block">
            <h2 class="block-title">Client Feedback &amp; Endorsement</h2>
            <div class="agent-testimonial-box">
              <div class="quote-icon"><i class="fa-solid fa-quote-left"></i></div>
              <blockquote class="agent-quote-text">&ldquo;<?= e($agent['testimonial_quote']) ?>&rdquo;</blockquote>
              <?php if (!empty($agent['testimonial_client'])): ?>
                <div class="agent-quote-author">
                  <div class="author-avatar"><i class="fa-solid fa-user-check"></i></div>
                  <div>
                    <strong><?= e($agent['testimonial_client']) ?></strong>
                    <span class="verified-tag"><i class="fa-solid fa-check"></i> Verified Client Transaction</span>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Properties Assigned to this Agent -->
        <div class="property-section-block">
          <div class="block-header-flex">
            <div>
              <h2 class="block-title">Featured Listings by <?= e($agent['name']) ?></h2>
              <p class="block-subtitle">Directly inspected, verified, and marketed by this advisor.</p>
            </div>
            <a href="/properties" class="view-all-link">Browse All Listings <i class="fa-solid fa-arrow-right"></i></a>
          </div>

          <?php if (!empty($assignedProperties)): ?>
            <div class="properties-grid assigned-properties-grid">
              <?php foreach ($assignedProperties as $property): ?>
                <?php include APP_ROOT . '/app/Views/components/property-card.php'; ?>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="agent-no-properties">
              <i class="fa-solid fa-building-circle-check"></i>
              <p>All active listings assigned to <?= e($agent['name']) ?> are currently undergoing DLD permit renewal or are offered off-market via private placement.</p>
              <a href="/contact-us" class="btn-primary-pill">Inquire for Off-Market Portfolios</a>
            </div>
          <?php endif; ?>
        </div>

        <!-- Related Internal Links & Community Guides -->
        <div class="property-section-block internal-links-block">
          <h2 class="block-title">Explore Related Dubai Real Estate</h2>
          <div class="internal-links-grid">
            <a href="/properties/buy" class="internal-link-card">
              <i class="fa-solid fa-house"></i>
              <span>Properties for Sale</span>
            </a>
            <a href="/properties/rent" class="internal-link-card">
              <i class="fa-solid fa-key"></i>
              <span>Properties for Rent</span>
            </a>
            <a href="/properties/off-plan" class="internal-link-card">
              <i class="fa-solid fa-crane"></i>
              <span>Off-Plan Launches</span>
            </a>
            <a href="/locations/dubai-hills-estate" class="internal-link-card">
              <i class="fa-solid fa-tree-city"></i>
              <span>Dubai Hills Estate</span>
            </a>
            <a href="/locations/downtown-dubai" class="internal-link-card">
              <i class="fa-solid fa-city"></i>
              <span>Downtown Dubai</span>
            </a>
            <a href="/locations/palm-jumeirah" class="internal-link-card">
              <i class="fa-solid fa-water"></i>
              <span>Palm Jumeirah</span>
            </a>
          </div>
        </div>

      </div>

      <!-- Right Column: Sticky Direct Contact Form & Agency Assurance -->
      <div class="property-sidebar-col">
        <div class="sticky-sidebar-card">
          <h3 class="inquiry-title">Consult with <?= e($agent['name']) ?></h3>
          <p class="inquiry-subtitle">Book a private property viewing, market evaluation, or portfolio consultation.</p>

          <form action="/enquiry/submit" method="POST" id="agentInquiryForm">
            <input type="hidden" name="subject" value="Consultation with <?= e($agent['name']) ?>">
            
            <div class="form-group">
              <label for="leadName">Your Full Name *</label>
              <input type="text" name="name" id="leadName" class="form-input" required placeholder="e.g. Tariq Mansoor">
            </div>

            <div class="form-group">
              <label for="leadPhone">Phone / WhatsApp *</label>
              <input type="tel" name="phone" id="leadPhone" class="form-input" required placeholder="+971 50 123 4567">
            </div>

            <div class="form-group">
              <label for="leadEmail">Email Address</label>
              <input type="email" name="email" id="leadEmail" class="form-input" placeholder="tariq@example.com">
            </div>

            <div class="form-group">
              <label for="leadMessage">How can <?= e($agent['name']) ?> assist you?</label>
              <textarea name="message" id="leadMessage" rows="4" class="form-textarea" placeholder="I am looking for a 3-4 bedroom villa in Dubai Hills Estate..."></textarea>
            </div>

            <button type="submit" class="btn-primary-pill full-width">
              <span>Send Direct Inquiry</span>
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </form>

          <div class="quick-direct-contacts">
            <a href="https://wa.me/<?= $whatsapp ?>?text=Hello%20<?= urlencode($agent['name']) ?>,%20I%20am%20reaching%20out%20via%20your%20DRL%20Dwarika%20profile." target="_blank" rel="noopener" class="btn-whatsapp-direct">
              <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
            </a>
            <a href="tel:<?= $cleanPhone ?>" class="btn-call-direct">
              <i class="fa-solid fa-phone"></i> Direct Call: <?= e($phone) ?>
            </a>
          </div>

          <div class="brokerage-badge-note">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Authorized broker under DRL Dwarika Real Estate LLC (RERA ORN: <?= e($settings['rera_orn'] ?? '29482') ?>). Regulated by Dubai Land Department.</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
