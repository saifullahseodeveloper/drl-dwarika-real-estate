<?php
/**
 * Admin Leads / Inquiries Management View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Customer Inquiries &amp; Leads</h1>
    <p class="page-subtitle">Track, follow up, and update conversion stages for all prospective property buyers and tenants.</p>
  </div>
</div>

<!-- Status Filter Tabs -->
<div class="admin-filter-bar">
  <div class="status-filter-tabs">
    <a href="/admin/leads" class="tab-btn <?= empty($status) ? 'active' : '' ?>">All Inquiries</a>
    <a href="/admin/leads?status=new" class="tab-btn <?= $status === 'new' ? 'active' : '' ?>">New</a>
    <a href="/admin/leads?status=contacted" class="tab-btn <?= $status === 'contacted' ? 'active' : '' ?>">Contacted</a>
    <a href="/admin/leads?status=qualified" class="tab-btn <?= $status === 'qualified' ? 'active' : '' ?>">Qualified</a>
    <a href="/admin/leads?status=closed" class="tab-btn <?= $status === 'closed' ? 'active' : '' ?>">Closed</a>
  </div>
</div>

<div class="dash-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Lead / Contact</th>
          <th>Property / Subject</th>
          <th>Message</th>
          <th>Current Status</th>
          <th>Update Status</th>
          <th>Received At</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($leads)): ?>
          <?php foreach ($leads as $lead): ?>
            <tr>
              <td>
                <strong><?= e($lead['name']) ?></strong><br>
                <a href="tel:<?= e($lead['phone']) ?>" class="contact-sublink"><i class="fa-solid fa-phone"></i> <?= e($lead['phone']) ?></a><br>
                <?php if (!empty($lead['email'])): ?>
                  <a href="mailto:<?= e($lead['email']) ?>" class="contact-sublink"><i class="fa-solid fa-envelope"></i> <?= e($lead['email']) ?></a>
                <?php endif; ?>
              </td>
              <td>
                <?php if (!empty($lead['property_title'])): ?>
                  <a href="/property/<?= e($lead['property_slug']) ?>" target="_blank" class="table-prop-link">
                    <?= e($lead['property_title']) ?>
                  </a>
                <?php elseif (!empty($lead['service_title'])): ?>
                  <span class="badge-service"><?= e($lead['service_title']) ?></span>
                <?php else: ?>
                  <span class="text-muted"><?= e($lead['subject'] ?? 'Website Inquiry') ?></span>
                <?php endif; ?>
              </td>
              <td>
                <div class="lead-message-preview">
                  <?= nl2br(e($lead['message'])) ?>
                </div>
              </td>
              <td>
                <span class="status-pill status-<?= e($lead['status']) ?>">
                  <?= ucfirst(e($lead['status'])) ?>
                </span>
              </td>
              <td>
                <form action="/admin/leads/update-status/<?= e((string)$lead['id']) ?>" method="POST" class="status-quick-form">
                  <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">
                  <select name="status" class="form-select-sm" onchange="this.form.submit()">
                    <option value="new" <?= $lead['status'] === 'new' ? 'selected' : '' ?>>New</option>
                    <option value="contacted" <?= $lead['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                    <option value="qualified" <?= $lead['status'] === 'qualified' ? 'selected' : '' ?>>Qualified</option>
                    <option value="closed" <?= $lead['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                  </select>
                </form>
              </td>
              <td>
                <small class="text-muted"><?= date('M j, Y H:i', strtotime($lead['created_at'])) ?></small>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center text-muted">No inquiries found in this view.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
