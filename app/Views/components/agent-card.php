<?php
/**
 * Agent Profile Card Component — DRL Dwarika Real Estate LLC
 */
$languages = $agent['languages'] ?? [];
$specializations = $agent['specializations'] ?? [];
$locations = $agent['locations'] ?? [];
$phone = $agent['phone'] ?? '+971 542202920';
$cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
$whatsapp = $agent['whatsapp'] ?? '971542202920';
$email = $agent['email'] ?? 'admin@dwarikarealestate.ae';
$photo = !empty($agent['photo_url']) ? $agent['photo_url'] : '/assets/images/agents/omar-farooq.jpg';
$webpPhoto = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $photo);
$rera = $agent['rera_brn'] ?? '';
$experience = $agent['experience'] ?? '';
?>
<article class="agent-card" data-agent-id="<?= e((string)$agent['id']) ?>">
  <!-- Card Header Media -->
  <div class="agent-card-media">
    <a href="/agents/<?= e($agent['slug']) ?>" class="agent-image-link" aria-label="View profile of <?= e($agent['name']) ?>">
      <picture>
        <source srcset="<?= e($webpPhoto) ?>" type="image/webp">
        <img src="<?= e($photo) ?>" alt="<?= e($agent['name']) ?> - <?= e($agent['designation']) ?>" loading="lazy" decoding="async" width="380" height="380" class="agent-card-img" onerror="this.onerror=null; this.src='/assets/images/agents/yaseen-mughal.jpg';">
      </picture>
    </a>
    <?php if ($experience): ?>
      <span class="agent-exp-badge"><i class="fa-solid fa-award"></i> <?= e($experience) ?></span>
    <?php endif; ?>
  </div>

  <!-- Card Body -->
  <div class="agent-card-body">
    <div class="agent-meta-header">
      <h3 class="agent-name">
        <a href="/agents/<?= e($agent['slug']) ?>"><?= e($agent['name']) ?></a>
      </h3>
      <p class="agent-designation"><?= e($agent['designation']) ?></p>
    </div>

    <p class="agent-short-bio">
      <?= e($agent['short_bio']) ?>
    </p>

    <!-- Specializations & Focus Tags -->
    <?php if (!empty($specializations)): ?>
      <div class="agent-spec-tags">
        <?php foreach ($specializations as $spec): ?>
          <span class="spec-pill"><i class="fa-solid fa-check"></i> <?= e(ucfirst($spec)) ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Languages Spoken & Locations -->
    <div class="agent-details-row">
      <?php if (!empty($languages)): ?>
        <div class="detail-item">
          <i class="fa-solid fa-globe"></i>
          <span><?= e(implode(', ', $languages)) ?></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($locations)): ?>
        <div class="detail-item">
          <i class="fa-solid fa-location-dot"></i>
          <span><?= e(implode(', ', array_slice($locations, 0, 2))) ?></span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Contact & Action Options: Call, WhatsApp, Email, View Profile -->
    <div class="agent-actions-row">
      <div class="agent-contact-buttons">
        <a href="tel:<?= $cleanPhone ?>" class="agent-btn-circle call" title="Call <?= e($agent['name']) ?>" aria-label="Call <?= e($agent['name']) ?>">
          <i class="fa-solid fa-phone"></i>
        </a>
        <a href="https://wa.me/<?= $whatsapp ?>?text=Hello%20<?= urlencode($agent['name']) ?>,%20I%20am%20inquiring%20about%20Dubai%20properties%20via%20DRL%20Dwarika." target="_blank" rel="noopener" class="agent-btn-circle whatsapp" title="WhatsApp <?= e($agent['name']) ?>" aria-label="WhatsApp <?= e($agent['name']) ?>">
          <i class="fa-brands fa-whatsapp"></i>
        </a>
        <a href="mailto:<?= e($email) ?>" class="agent-btn-circle email" title="Email <?= e($agent['name']) ?>" aria-label="Email <?= e($agent['name']) ?>">
          <i class="fa-solid fa-envelope"></i>
        </a>
      </div>
      <a href="/agents/<?= e($agent['slug']) ?>" class="btn-view-profile">
        <span>View Profile</span>
        <i class="fa-solid fa-arrow-right"></i>
      </a>
    </div>
  </div>
</article>
