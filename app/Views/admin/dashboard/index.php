<?php
/**
 * Admin Dashboard View — KPIs, Metrics & Recent Inquiries
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Executive Dashboard</h1>
    <p class="page-subtitle">Welcome back. Here is an overview of property performance, leads, and catalog status.</p>
  </div>
  <div class="header-actions">
    <a href="/admin/properties/create" class="btn-admin-primary" id="btnAdminAddProp">
      <i class="fa-solid fa-plus"></i> Add New Property
    </a>
  </div>
</div>

<!-- KPI Metric Cards Grid -->
<div class="metrics-grid">
  <div class="metric-card">
    <div class="metric-icon blue"><i class="fa-solid fa-building"></i></div>
    <div class="metric-data">
      <span class="metric-num"><?= $totalProps ?></span>
      <span class="metric-label">Total Properties</span>
    </div>
  </div>

  <div class="metric-card">
    <div class="metric-icon green"><i class="fa-solid fa-circle-check"></i></div>
    <div class="metric-data">
      <span class="metric-num"><?= $publishedProps ?></span>
      <span class="metric-label">Published Active</span>
    </div>
  </div>

  <div class="metric-card">
    <div class="metric-icon orange"><i class="fa-solid fa-file-pen"></i></div>
    <div class="metric-data">
      <span class="metric-num"><?= $draftProps ?></span>
      <span class="metric-label">Draft Listings</span>
    </div>
  </div>

  <div class="metric-card">
    <div class="metric-icon purple"><i class="fa-solid fa-tags"></i></div>
    <div class="metric-data">
      <span class="metric-num"><?= $soldProps ?></span>
      <span class="metric-label">Sold / Transacted</span>
    </div>
  </div>

  <div class="metric-card">
    <div class="metric-icon teal"><i class="fa-solid fa-envelope-open-text"></i></div>
    <div class="metric-data">
      <span class="metric-num"><?= $totalLeads ?></span>
      <span class="metric-label">Total Inquiries</span>
    </div>
  </div>

  <div class="metric-card">
    <div class="metric-icon red"><i class="fa-solid fa-bell"></i></div>
    <div class="metric-data">
      <span class="metric-num"><?= $newLeads ?></span>
      <span class="metric-label">Pending / New Leads</span>
    </div>
  </div>
</div>

<!-- Dashboard Two-Column Grid: Recent Inquiries & Properties -->
<div class="dashboard-tables-grid">
  
  <!-- Col 1: Recent Inquiries -->
  <div class="dash-card">
    <div class="dash-card-header">
      <div class="card-title-wrap">
        <i class="fa-solid fa-user-tag text-primary"></i>
        <h3>Recent Customer Inquiries</h3>
      </div>
      <a href="/admin/leads" class="dash-card-link">View All Leads <i class="fa-solid fa-arrow-right"></i></a>
    </div>

    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Lead Name</th>
            <th>Contact</th>
            <th>Property / Subject</th>
            <th>Status</th>
            <th>Received</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($recentLeads)): ?>
            <?php foreach ($recentLeads as $lead): ?>
              <tr>
                <td><strong><?= e($lead['name']) ?></strong></td>
                <td>
                  <a href="tel:<?= e($lead['phone']) ?>" class="contact-sublink"><i class="fa-solid fa-phone"></i> <?= e($lead['phone']) ?></a><br>
                  <small class="text-muted"><?= e($lead['email']) ?></small>
                </td>
                <td>
                  <?php if (!empty($lead['property_title'])): ?>
                    <a href="/property/<?= e($lead['property_slug']) ?>" target="_blank" class="table-prop-link">
                      <?= e($lead['property_title']) ?>
                    </a>
                  <?php else: ?>
                    <span class="text-muted"><?= e($lead['subject'] ?? 'Website Inquiry') ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="status-pill status-<?= e($lead['status']) ?>">
                    <?= ucfirst(e($lead['status'])) ?>
                  </span>
                </td>
                <td><small><?= date('M j, H:i', strtotime($lead['created_at'])) ?></small></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-muted">No inquiries received yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Col 2: Recent Properties -->
  <div class="dash-card">
    <div class="dash-card-header">
      <div class="card-title-wrap">
        <i class="fa-solid fa-building text-primary"></i>
        <h3>Recent Property Listings</h3>
      </div>
      <a href="/admin/properties" class="dash-card-link">Manage All <i class="fa-solid fa-arrow-right"></i></a>
    </div>

    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Property</th>
            <th>Location</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($recentProps)): ?>
            <?php foreach ($recentProps as $prop): ?>
              <tr>
                <td>
                  <div class="table-prop-info">
                    <img src="<?= e($prop['featured_image']) ?>" alt="" class="table-prop-thumb">
                    <div>
                      <strong><?= e($prop['title']) ?></strong><br>
                      <small class="text-muted"><?= e($prop['reference_code']) ?></small>
                    </div>
                  </div>
                </td>
                <td><?= e($prop['location_name'] ?? 'Dubai') ?></td>
                <td><strong><?= format_price($prop['price'], $prop['currency'] ?? 'AED') ?></strong></td>
                <td>
                  <span class="status-pill status-<?= e($prop['status']) ?>">
                    <?= ucfirst(e($prop['status'])) ?>
                  </span>
                </td>
                <td>
                  <div class="action-buttons-group">
                    <a href="/property/<?= e($prop['slug']) ?>" target="_blank" class="btn-icon" title="View on site"><i class="fa-solid fa-eye"></i></a>
                    <a href="/admin/properties/edit/<?= e((string)$prop['id']) ?>" class="btn-icon" title="Edit"><i class="fa-solid fa-pen"></i></a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-muted">No properties found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
