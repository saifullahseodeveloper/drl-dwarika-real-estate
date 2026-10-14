<?php
/**
 * Admin Locations Management View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Dubai Locations &amp; Communities</h1>
    <p class="page-subtitle">Configure major Dubai freehold areas showcased in discovery hubs and search filters.</p>
  </div>
</div>

<div class="dash-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Community Name</th>
          <th>Slug</th>
          <th>City / Emirate</th>
          <th>Featured</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($locations as $loc): ?>
          <tr>
            <td>
              <strong><?= e($loc['name']) ?></strong>
            </td>
            <td><code>/locations/<?= e($loc['slug']) ?></code></td>
            <td><?= e($loc['city'] ?? 'Dubai') ?></td>
            <td>
              <?php if (!empty($loc['is_featured'])): ?>
                <span class="status-pill status-published">Featured</span>
              <?php else: ?>
                <span class="text-muted">Standard</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="/locations/<?= e($loc['slug']) ?>" target="_blank" class="btn-icon" title="View Public Landing Page">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
