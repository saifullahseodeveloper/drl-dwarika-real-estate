<?php
/**
 * Admin Services Management View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Manage Services</h1>
    <p class="page-subtitle">Configure real estate advisory services displayed across the homepage and service hub.</p>
  </div>
</div>

<div class="dash-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Service Title</th>
          <th>Slug</th>
          <th>Summary</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($services as $srv): ?>
          <tr>
            <td>
              <div class="table-service-info">
                <i class="fa-solid fa-briefcase text-primary"></i>
                <strong><?= e($srv['title']) ?></strong>
              </div>
            </td>
            <td><code>/services/<?= e($srv['slug']) ?></code></td>
            <td><?= e($srv['short_desc']) ?></td>
            <td>
              <span class="status-pill status-published">Active</span>
            </td>
            <td>
              <a href="/services/<?= e($srv['slug']) ?>" target="_blank" class="btn-icon" title="View Public Page">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
