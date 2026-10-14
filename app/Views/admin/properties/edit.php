<?php
/**
 * Admin Edit Property Form
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Edit Listing: <?= e($property['title']) ?></h1>
    <p class="page-subtitle">Ref: <?= e($property['reference_code']) ?> &bull; Slug: /property/<?= e($property['slug']) ?></p>
  </div>
  <div class="header-actions">
    <a href="/property/<?= e($property['slug']) ?>" target="_blank" class="btn-admin-outline"><i class="fa-solid fa-eye"></i> View Live</a>
    <a href="/admin/properties" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
  </div>
</div>

<form action="/admin/properties/edit/<?= e((string)$property['id']) ?>" method="POST" class="admin-form-card">
  <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">

  <div class="form-section-title">1. Basic Property Information</div>
  <div class="form-row">
    <div class="form-group full-width">
      <label for="propTitle">Property Title *</label>
      <input type="text" name="title" id="propTitle" class="form-input" value="<?= e($property['title']) ?>" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group third-width">
      <label for="propPrice">Price (AED) *</label>
      <input type="number" name="price" id="propPrice" class="form-input" value="<?= (float)$property['price'] ?>" step="1000" required>
    </div>

    <div class="form-group third-width">
      <label for="propLocation">Location / Community *</label>
      <select name="location_id" id="propLocation" class="form-select" required>
        <?php foreach ($locations as $loc): ?>
          <option value="<?= e((string)$loc['id']) ?>" <?= (int)$property['location_id'] === (int)$loc['id'] ? 'selected' : '' ?>>
            <?= e($loc['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group third-width">
      <label for="propType">Property Type *</label>
      <select name="property_type_id" id="propType" class="form-select" required>
        <?php foreach ($types as $t): ?>
          <option value="<?= e((string)$t['id']) ?>" <?= (int)$property['property_type_id'] === (int)$t['id'] ? 'selected' : '' ?>>
            <?= e($t['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group third-width">
      <label for="propAgent">Assigned Agent</label>
      <select name="agent_id" id="propAgent" class="form-select">
        <option value="">— Unassigned / General Brokerage —</option>
        <?php foreach ($agents ?? [] as $ag): ?>
          <option value="<?= e((string)$ag['id']) ?>" <?= (int)($property['agent_id'] ?? 0) === (int)$ag['id'] ? 'selected' : '' ?>>
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
        <option value="sale" <?= $property['listing_type'] === 'sale' ? 'selected' : '' ?>>For Sale</option>
        <option value="rent" <?= $property['listing_type'] === 'rent' ? 'selected' : '' ?>>For Rent</option>
        <option value="off-plan" <?= $property['listing_type'] === 'off-plan' ? 'selected' : '' ?>>Off-Plan</option>
        <option value="commercial" <?= $property['listing_type'] === 'commercial' ? 'selected' : '' ?>>Commercial</option>
      </select>
    </div>

    <div class="form-group fourth-width">
      <label for="propStatus">Publishing Status</label>
      <select name="status" id="propStatus" class="form-select">
        <option value="published" <?= $property['status'] === 'published' ? 'selected' : '' ?>>Published</option>
        <option value="draft" <?= $property['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
        <option value="sold" <?= $property['status'] === 'sold' ? 'selected' : '' ?>>Sold</option>
        <option value="rented" <?= $property['status'] === 'rented' ? 'selected' : '' ?>>Rented</option>
      </select>
    </div>

    <div class="form-group fourth-width">
      <label for="propBeds">Bedrooms</label>
      <input type="number" name="bedrooms" id="propBeds" class="form-input" value="<?= (int)$property['bedrooms'] ?>" min="0" max="20">
    </div>

    <div class="form-group fourth-width">
      <label for="propBaths">Bathrooms</label>
      <input type="number" name="bathrooms" id="propBaths" class="form-input" value="<?= (int)$property['bathrooms'] ?>" min="0" max="20">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group half-width">
      <label for="propArea">Built-up Area (Sq. Ft.)</label>
      <input type="number" name="area_sqft" id="propArea" class="form-input" value="<?= (float)$property['area_sqft'] ?>" step="0.1">
    </div>

    <div class="form-group half-width">
      <label for="propAddress">Full Address / Street</label>
      <input type="text" name="address" id="propAddress" class="form-input" value="<?= e($property['address']) ?>">
    </div>
  </div>

  <div class="form-section-title">2. Media &amp; Regulatory Verification</div>
  <div class="form-row">
    <div class="form-group half-width">
      <label for="propImage">Featured Image URL *</label>
      <input type="text" name="featured_image" id="propImage" class="form-input" value="<?= e($property['featured_image']) ?>" required>
    </div>

    <div class="form-group half-width">
      <label for="propRera">RERA Permit / DLD Number</label>
      <input type="text" name="rera_permit" id="propRera" class="form-input" value="<?= e($property['rera_permit']) ?>">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group full-width">
      <label class="checkbox-label">
        <input type="checkbox" name="is_featured" value="1" <?= !empty($property['is_featured']) ? 'checked' : '' ?>>
        <span>Mark as <strong>Featured Property</strong> on Homepage</span>
      </label>
    </div>
  </div>

  <div class="form-section-title">3. Description</div>
  <div class="form-row">
    <div class="form-group full-width">
      <label for="propDesc">Full Property Description *</label>
      <textarea name="description" id="propDesc" rows="6" class="form-textarea" required><?= e($property['description']) ?></textarea>
    </div>
  </div>

  <div class="form-section-title">4. Technical SEO Metadata</div>
  <div class="form-row">
    <div class="form-group half-width">
      <label for="metaTitle">Custom SEO Meta Title</label>
      <input type="text" name="meta_title" id="metaTitle" class="form-input" value="<?= e($property['meta_title']) ?>">
    </div>

    <div class="form-group half-width">
      <label for="metaDesc">Custom Meta Description</label>
      <input type="text" name="meta_description" id="metaDesc" class="form-input" value="<?= e($property['meta_description']) ?>">
    </div>
  </div>

  <div class="form-actions-bar">
    <button type="submit" class="btn-admin-primary">
      <i class="fa-solid fa-floppy-disk"></i> Save Changes
    </button>
    <a href="/admin/properties" class="btn-admin-outline">Cancel</a>
  </div>
</form>
