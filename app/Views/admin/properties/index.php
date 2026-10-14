<?php
/**
 * Admin Properties List View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Property Catalog</h1>
    <p class="page-subtitle">Manage all residential, off-plan, and commercial listings for DRL Dwarika Real Estate LLC.</p>
  </div>
  <div class="header-actions">
    <a href="/admin/properties/create" class="btn-admin-primary" id="btnAdminCreateListing">
      <i class="fa-solid fa-plus"></i> Add New Property
    </a>
  </div>
</div>

<!-- Filter Tabs -->
<div class="admin-filter-bar">
  <div class="status-filter-tabs">
    <a href="/admin/properties" class="tab-btn <?= empty($status) ? 'active' : '' ?>">All Listings</a>
    <a href="/admin/properties?status=published" class="tab-btn <?= $status === 'published' ? 'active' : '' ?>">Published</a>
    <a href="/admin/properties?status=draft" class="tab-btn <?= $status === 'draft' ? 'active' : '' ?>">Drafts</a>
    <a href="/admin/properties?status=sold" class="tab-btn <?= $status === 'sold' ? 'active' : '' ?>">Sold / Rented</a>
  </div>
</div>

<div class="dash-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Property / Ref</th>
          <th>Location</th>
          <th>Type</th>
          <th>Price (AED)</th>
          <th>Beds/Baths</th>
          <th>Status</th>
          <th>Featured</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($properties)): ?>
          <?php foreach ($properties as $prop): ?>
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
              <td><?= ucfirst(e($prop['listing_type'] ?? 'sale')) ?> &bull; <?= e($prop['type_name'] ?? 'Unit') ?></td>
              <td><strong><?= format_price($prop['price'], '') ?></strong></td>
              <td><?= (int)$prop['bedrooms'] ?> Beds / <?= (int)$prop['bathrooms'] ?> Baths</td>
              <td>
                <span class="status-pill status-<?= e($prop['status']) ?>">
                  <?= ucfirst(e($prop['status'])) ?>
                </span>
              </td>
              <td>
                <?php if (!empty($prop['is_featured'])): ?>
                  <span class="badge-featured"><i class="fa-solid fa-star"></i> Featured</span>
                <?php else: ?>
                  <span class="text-muted">—</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="action-buttons-group">
                  <a href="/property/<?= e($prop['slug']) ?>" target="_blank" class="btn-icon" title="View Public Page"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                  <a href="/admin/properties/edit/<?= e((string)$prop['id']) ?>" class="btn-icon" title="Edit Listing"><i class="fa-solid fa-pen-to-square"></i></a>
                  
                  <form action="/admin/properties/delete/<?= e((string)$prop['id']) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this property listing?');" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">
                    <button type="submit" class="btn-icon delete-btn" title="Delete Property"><i class="fa-solid fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="8" class="text-center text-muted">No properties found in this filter view.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
