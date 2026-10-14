<?php
/**
 * Admin Create Property Form
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Add New Property Listing</h1>
    <p class="page-subtitle">Publish a verified real estate listing to the DRL Dwarika platform.</p>
  </div>
  <div class="header-actions">
    <a href="/admin/properties" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
  </div>
</div>

<form action="/admin/properties/create" method="POST" class="admin-form-card">
  <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">

  <div class="form-section-title">1. Basic Property Information</div>
  <div class="form-row">
    <div class="form-group full-width">
      <label for="propTitle">Property Title *</label>
      <input type="text" name="title" id="propTitle" class="form-input" placeholder="e.g. Modern Villa in Dubai Hills" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group third-width">
      <label for="propPrice">Price (AED) *</label>
      <input type="number" name="price" id="propPrice" class="form-input" placeholder="4500000" step="1000" required>
    </div>

    <div class="form-group third-width">
      <label for="propLocation">Location / Community *</label>
      <select name="location_id" id="propLocation" class="form-select" required>
        <option value="">Select Location</option>
        <?php foreach ($locations as $loc): ?>
          <option value="<?= e((string)$loc['id']) ?>"><?= e($loc['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group third-width">
      <label for="propType">Property Type *</label>
      <select name="property_type_id" id="propType" class="form-select" required>
        <option value="">Select Type</option>
        <?php foreach ($types as $t): ?>
          <option value="<?= e((string)$t['id']) ?>"><?= e($t['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group third-width">
      <label for="propAgent">Assigned Agent</label>
      <select name="agent_id" id="propAgent" class="form-select">
        <option value="">— Unassigned / General Brokerage —</option>
        <?php foreach ($agents ?? [] as $ag): ?>
          <option value="<?= e((string)$ag['id']) ?>">
            <?= e($ag['name']) ?> (<?= e($ag['designation']) ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group fourth-width">
      <label for="propListingType">Listing Category</label>
      <select name="listing_type" id="propListingType" class="form-select">
        <option value="sale">For Sale</option>
        <option value="rent">For Rent</option>
        <option value="off-plan">Off-Plan</option>
        <option value="commercial">Commercial</option>
      </select>
    </div>

    <div class="form-group fourth-width">
      <label for="propStatus">Publishing Status</label>
      <select name="status" id="propStatus" class="form-select">
        <option value="published">Published</option>
        <option value="draft">Draft</option>
        <option value="sold">Sold</option>
        <option value="rented">Rented</option>
      </select>
    </div>

    <div class="form-group fourth-width">
      <label for="propBeds">Bedrooms</label>
      <input type="number" name="bedrooms" id="propBeds" class="form-input" value="3" min="0" max="20">
    </div>

    <div class="form-group fourth-width">
      <label for="propBaths">Bathrooms</label>
      <input type="number" name="bathrooms" id="propBaths" class="form-input" value="3" min="0" max="20">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group half-width">
      <label for="propArea">Built-up Area (Sq. Ft.)</label>
      <input type="number" name="area_sqft" id="propArea" class="form-input" placeholder="2500" step="0.1">
    </div>

    <div class="form-group half-width">
      <label for="propAddress">Full Address / Street</label>
      <input type="text" name="address" id="propAddress" class="form-input" placeholder="e.g. Maple 2, Dubai Hills Estate, Dubai">
    </div>
  </div>

  <div class="form-section-title">2. Media &amp; Regulatory Verification</div>
  <div class="form-row">
    <div class="form-group half-width">
      <label for="propImage">Featured Image URL *</label>
      <input type="text" name="featured_image" id="propImage" class="form-input" value="/assets/images/villa-dubai-hills.jpg" required>
      <small class="text-muted">You can use internal paths (/assets/images/...) or external CDN URLs.</small>
    </div>

    <div class="form-group half-width">
      <label for="propRera">RERA Permit / DLD Number</label>
      <input type="text" name="rera_permit" id="propRera" class="form-input" placeholder="e.g. DLD-749210-2025">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group full-width">
      <label class="checkbox-label">
        <input type="checkbox" name="is_featured" value="1" checked>
        <span>Mark as <strong>Featured Property</strong> on Homepage</span>
      </label>
    </div>
  </div>

  <div class="form-section-title">3. Description &amp; Amenities</div>
  <div class="form-row">
    <div class="form-group full-width">
      <label for="propDesc">Full Property Description *</label>
      <textarea name="description" id="propDesc" rows="6" class="form-textarea" placeholder="Detail the property layout, views, finishes, developer background, and location accessibility..." required></textarea>
    </div>
  </div>

  <div class="form-group full-width">
    <label>Select Amenities &amp; Features</label>
    <div class="checkbox-grid">
      <?php foreach ($amenities as $am): ?>
        <label class="checkbox-pill">
          <input type="checkbox" name="amenities[]" value="<?= e((string)$am['id']) ?>">
          <span><i class="fa-solid <?= e($am['icon'] ?? 'fa-check') ?>"></i> <?= e($am['name']) ?></span>
        </label>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="form-section-title">4. Technical SEO Metadata</div>
  <div class="form-row">
    <div class="form-group half-width">
      <label for="metaTitle">Custom SEO Meta Title</label>
      <input type="text" name="meta_title" id="metaTitle" class="form-input" placeholder="Leave blank to use property title">
    </div>

    <div class="form-group half-width">
      <label for="metaDesc">Custom Meta Description</label>
      <input type="text" name="meta_description" id="metaDesc" class="form-input" placeholder="Leave blank for automatic summary">
    </div>
  </div>

  <div class="form-actions-bar">
    <button type="submit" class="btn-admin-primary">
      <i class="fa-solid fa-cloud-arrow-up"></i> Save &amp; Publish Listing
    </button>
    <a href="/admin/properties" class="btn-admin-outline">Cancel</a>
  </div>
</form>
