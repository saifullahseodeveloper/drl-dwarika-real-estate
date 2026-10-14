<?php
/**
 * Admin Agents List View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Real Estate Agents &amp; Advisors</h1>
    <p class="page-subtitle">Manage licensed brokers, contact credentials, RERA BRN numbers, and community specializations.</p>
  </div>
  <div class="header-actions">
    <a href="/admin/agents/create" class="btn-admin-primary">
      <i class="fa-solid fa-plus"></i> Add New Agent
    </a>
  </div>
</div>

<div class="dash-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Agent</th>
          <th>Designation</th>
          <th>RERA BRN</th>
          <th>Contact</th>
          <th>Languages</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($agents)): ?>
          <?php foreach ($agents as $agent): ?>
            <?php 
              $languages = is_string($agent['languages'] ?? '') ? json_decode($agent['languages'], true) : ($agent['languages'] ?? []);
            ?>
            <tr>
              <td>
                <div class="table-prop-info">
                  <img src="<?= e($agent['photo_url']) ?>" alt="" class="table-prop-thumb" style="border-radius:50%; width:44px; height:44px; object-fit:cover;">
                  <div>
                    <strong><?= e($agent['name']) ?></strong><br>
                    <small class="text-muted"><a href="/agents/<?= e($agent['slug']) ?>" target="_blank" class="text-primary">/agents/<?= e($agent['slug']) ?> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.75rem;"></i></a></small>
                  </div>
                </div>
              </td>
              <td><?= e($agent['designation']) ?></td>
              <td><span class="badge badge-light" style="font-family:monospace;"><?= e($agent['rera_brn'] ?: '—') ?></span></td>
              <td>
                <small>
                  <i class="fa-solid fa-phone"></i> <?= e($agent['phone']) ?><br>
                  <i class="fa-solid fa-envelope"></i> <?= e($agent['email']) ?>
                </small>
              </td>
              <td>
                <small><?= e(implode(', ', (array)$languages)) ?></small>
              </td>
              <td>
                <span class="badge <?= ($agent['status'] ?? 'active') === 'active' ? 'badge-success' : 'badge-warning' ?>">
                  <?= ucfirst(e($agent['status'] ?? 'active')) ?>
                </span>
              </td>
              <td>
                <div class="table-actions-row">
                  <a href="/admin/agents/edit/<?= e((string)$agent['id']) ?>" class="btn-table-action" title="Edit Agent">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <a href="/agents/<?= e($agent['slug']) ?>" target="_blank" class="btn-table-action" title="View Public Profile">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center" style="padding:40px;">No agents found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
