<?php
/**
 * Property Card Component — Matches Homepage Reference Illustration exactly
 */
$badgeText = match($property['listing_type']) {
    'rent'       => 'For Rent',
    'off-plan'   => 'Off-Plan',
    'commercial' => 'Commercial',
    default      => 'For Sale'
};
$image = !empty($property['featured_image']) ? $property['featured_image'] : '/assets/images/villa-dubai-hills.jpg';
$beds = (int)($property['bedrooms'] ?? 0);
$baths = (int)($property['bathrooms'] ?? 0);
$locationName = $property['location_name'] ?? 'Dubai, UAE';
?>
<article class="property-card" data-id="<?= e((string)$property['id']) ?>">
  <!-- Card Media -->
  <div class="property-card-media">
    <a href="/property/<?= e($property['slug']) ?>" class="property-card-link" aria-label="<?= e($property['title']) ?>">
      <img src="<?= e($image) ?>" alt="<?= e($property['title']) ?>" loading="lazy" width="380" height="240" class="property-card-img">
    </a>
    <span class="property-badge"><?= e($badgeText) ?></span>
  </div>

  <!-- Card Body -->
  <div class="property-card-body">
    <h3 class="property-card-title">
      <a href="/property/<?= e($property['slug']) ?>">
        <?= e($property['title']) ?>
      </a>
    </h3>

    <div class="property-card-location">
      <i class="fa-solid fa-location-dot"></i>
      <span><?= e($locationName) ?></span>
    </div>

    <!-- Specs: Beds and Baths -->
    <div class="property-card-specs">
      <?php if ($beds > 0): ?>
        <span class="spec-item"><i class="fa-solid fa-bed"></i> <?= $beds ?> Beds</span>
      <?php else: ?>
        <span class="spec-item"><i class="fa-solid fa-building"></i> Commercial</span>
      <?php endif; ?>

      <?php if ($baths > 0): ?>
        <span class="spec-item"><i class="fa-solid fa-bath"></i> <?= $baths ?> Baths</span>
      <?php endif; ?>
    </div>

    <!-- Footer: Price and Arrow -->
    <div class="property-card-footer">
      <div class="property-price">
        <?= format_price($property['price'], $property['currency'] ?? 'AED') ?>
      </div>
      <a href="/property/<?= e($property['slug']) ?>" class="property-arrow-link" aria-label="View details for <?= e($property['title']) ?>">
        <i class="fa-solid fa-arrow-right"></i>
      </a>
    </div>
  </div>
</article>
