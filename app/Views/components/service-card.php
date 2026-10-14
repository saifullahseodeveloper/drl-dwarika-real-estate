<?php
/**
 * Service Card Component — Matches Reference Design
 */
$iconClass = match($service['slug']) {
    'buy-property'         => 'fa-solid fa-house',
    'sell-property'        => 'fa-solid fa-hand-holding-dollar',
    'property-consultancy' => 'fa-solid fa-user-tie',
    'investment-advisory'  => 'fa-solid fa-building-columns',
    default                => 'fa-solid fa-briefcase'
};
?>
<div class="service-card">
  <div class="service-icon-circle">
    <i class="<?= $iconClass ?>"></i>
  </div>
  <h3 class="service-title"><?= e($service['title']) ?></h3>
  <p class="service-desc">
    <?= e($service['short_desc']) ?>
  </p>
  <a href="/services/<?= e($service['slug']) ?>" class="service-arrow-link" aria-label="Learn more about <?= e($service['title']) ?>">
    <i class="fa-solid fa-arrow-right"></i>
  </a>
</div>
