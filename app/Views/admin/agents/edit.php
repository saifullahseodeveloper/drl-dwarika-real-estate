<?php
/**
 * Admin Agent Edit / Create Form View
 */
$isEdit = !empty($agent['id']);
$formAction = $isEdit ? "/admin/agents/edit/{$agent['id']}" : "/admin/agents/create";
$languagesStr = '';
if (!empty($agent['languages'])) {
    $langs = is_string($agent['languages']) ? json_decode($agent['languages'], true) : $agent['languages'];
    $languagesStr = implode(', ', (array)$langs);
}
$specStr = '';
if (!empty($agent['specializations'])) {
    $specs = is_string($agent['specializations']) ? json_decode($agent['specializations'], true) : $agent['specializations'];
    $specStr = implode(', ', (array)$specs);
}
$locStr = '';
if (!empty($agent['locations'])) {
    $locs = is_string($agent['locations']) ? json_decode($agent['locations'], true) : $agent['locations'];
    $locStr = implode(', ', (array)$locs);
}
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title"><?= $isEdit ? 'Edit Agent: ' . e($agent['name']) : 'Add New Real Estate Agent' ?></h1>
    <p class="page-subtitle">Configure agent credentials, contact channels, bio, and property assignments.</p>
  </div>
  <div class="header-actions">
    <a href="/admin/agents" class="btn-admin-secondary">
      <i class="fa-solid fa-arrow-left"></i> Back to Agents
    </a>
  </div>
</div>

<form action="<?= $formAction ?>" method="POST" class="admin-form-card">
  <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">

  <div class="form-section-title">Primary Credentials</div>
  <div class="form-grid-2">
    <div class="form-group">
      <label>Full Name *</label>
      <input type="text" name="name" value="<?= e($agent['name'] ?? '') ?>" class="admin-input" required placeholder="e.g. Yaseen Mughal">
    </div>
    <div class="form-group">
      <label>Profile Slug (URL)</label>
      <input type="text" name="slug" value="<?= e($agent['slug'] ?? '') ?>" class="admin-input" placeholder="e.g. yaseen-mughal">
    </div>
    <div class="form-group">
      <label>Designation / Title *</label>
      <input type="text" name="designation" value="<?= e($agent['designation'] ?? '') ?>" class="admin-input" required placeholder="e.g. Senior Portfolio Manager">
    </div>
    <div class="form-group">
      <label>RERA BRN License Number</label>
      <input type="text" name="rera_brn" value="<?= e($agent['rera_brn'] ?? '') ?>" class="admin-input" placeholder="e.g. 42918">
    </div>
    <div class="form-group">
      <label>Years of Experience</label>
      <input type="text" name="experience" value="<?= e($agent['experience'] ?? '') ?>" class="admin-input" placeholder="e.g. 9+ Years Experience">
    </div>
    <div class="form-group">
      <label>Photo URL *</label>
      <input type="text" name="photo_url" value="<?= e($agent['photo_url'] ?? '') ?>" class="admin-input" required placeholder="/assets/images/agents/yaseen-mughal.jpg">
    </div>
  </div>

  <div class="form-section-title" style="margin-top:24px;">Direct Contact Options</div>
  <div class="form-grid-3">
    <div class="form-group">
      <label>Direct Phone *</label>
      <input type="tel" name="phone" value="<?= e($agent['phone'] ?? '') ?>" class="admin-input" required placeholder="+971 50 234 5671">
    </div>
    <div class="form-group">
      <label>WhatsApp Number *</label>
      <input type="text" name="whatsapp" value="<?= e($agent['whatsapp'] ?? '') ?>" class="admin-input" required placeholder="971502345671">
    </div>
    <div class="form-group">
      <label>Email Address *</label>
      <input type="email" name="email" value="<?= e($agent['email'] ?? '') ?>" class="admin-input" required placeholder="omar.farooq@dwarikarealestate.ae">
    </div>
  </div>

  <div class="form-section-title" style="margin-top:24px;">Biographies &amp; Editorial</div>
  <div class="form-group">
    <label>Short Summary Bio (Card display) *</label>
    <textarea name="short_bio" rows="2" class="admin-textarea" required placeholder="Brief introductory bio for catalog card..."><?= e($agent['short_bio'] ?? '') ?></textarea>
  </div>
  <div class="form-group">
    <label>Full Detailed Biography (Profile page) *</label>
    <textarea name="full_bio" rows="6" class="admin-textarea" required placeholder="Comprehensive background, track record, and achievements..."><?= e($agent['full_bio'] ?? '') ?></textarea>
  </div>

  <div class="form-section-title" style="margin-top:24px;">Taxonomy &amp; Specializations (Comma-separated)</div>
  <div class="form-grid-3">
    <div class="form-group">
      <label>Specializations</label>
      <input type="text" name="specializations" value="<?= e($specStr) ?>" class="admin-input" placeholder="luxury, residential, off-plan, commercial, rental">
    </div>
    <div class="form-group">
      <label>Spoken Languages</label>
      <input type="text" name="languages" value="<?= e($languagesStr) ?>" class="admin-input" placeholder="English, Arabic, Urdu, Russian, French">
    </div>
    <div class="form-group">
      <label>Dubai Communities / Locations</label>
      <input type="text" name="locations" value="<?= e($locStr) ?>" class="admin-input" placeholder="Dubai Hills Estate, Downtown Dubai, Palm Jumeirah">
    </div>
  </div>

  <div class="form-grid-2" style="margin-top:16px;">
    <div class="form-group">
      <label>Status</label>
      <select name="status" class="admin-select">
        <option value="active" <?= ($agent['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active (Published)</option>
        <option value="inactive" <?= ($agent['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
      </select>
    </div>
    <div class="form-group">
      <label>Display Sort Order</label>
      <input type="number" name="sort_order" value="<?= (int)($agent['sort_order'] ?? 0) ?>" class="admin-input">
    </div>
  </div>

  <div class="form-actions-bar" style="margin-top:28px;">
    <button type="submit" class="btn-admin-primary">
      <i class="fa-solid fa-floppy-disk"></i> Save Agent Profile
    </button>
    <a href="/admin/agents" class="btn-admin-secondary">Cancel</a>
  </div>
</form>
