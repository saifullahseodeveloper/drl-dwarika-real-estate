<?php
/**
 * Admin Testimonials Management View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Manage Client Testimonials</h1>
    <p class="page-subtitle">Curate and feature client testimonials matching the master homepage design.</p>
  </div>
</div>

<div class="dash-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Client</th>
          <th>Location</th>
          <th>Quote</th>
          <th>Rating</th>
          <th>Featured</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($testimonials as $t): ?>
          <tr>
            <td>
              <div class="table-author-info">
                <span class="avatar-badge"><?= e($t['avatar_initial']) ?></span>
                <div>
                  <strong><?= e($t['client_name']) ?></strong><br>
                  <small class="text-muted"><?= e($t['client_title'] ?? 'Client') ?></small>
                </div>
              </div>
            </td>
            <td><?= e($t['location']) ?></td>
            <td>&ldquo;<?= e($t['quote']) ?>&rdquo;</td>
            <td>
              <span class="text-warning">
                <?php for($i=0; $i<$t['rating']; $i++): ?><i class="fa-solid fa-star"></i><?php endfor; ?>
              </span>
            </td>
            <td>
              <span class="status-pill status-published">Featured on Home</span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
