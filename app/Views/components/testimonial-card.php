<?php
/**
 * Testimonial Card Component — Matches Reference Design
 */
$initial = !empty($testimonial['avatar_initial']) ? $testimonial['avatar_initial'] : strtoupper(substr($testimonial['client_name'], 0, 1));
?>
<div class="testimonial-card">
  <div class="testimonial-avatar-initial">
    <?= e($initial) ?>
  </div>
  <blockquote class="testimonial-quote">
    &ldquo;<?= e($testimonial['quote']) ?>&rdquo;
  </blockquote>
  <div class="testimonial-author-info">
    <div class="author-name"><?= e($testimonial['client_name']) ?></div>
    <div class="author-location"><?= e($testimonial['location']) ?></div>
  </div>
</div>
