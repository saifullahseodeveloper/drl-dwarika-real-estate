<?php
/**
 * Admin Founder Edit Profile Form View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Edit Leadership Profile: <?= e($founder['designation']) ?></h1>
    <p class="page-subtitle">Update authentic legal name, executive portrait, credentials, and leadership focus areas.</p>
  </div>
  <div class="header-actions">
    <a href="/admin/founders" class="btn-admin-secondary">
      <i class="fa-solid fa-arrow-left"></i> Back to Leadership
    </a>
  </div>
</div>

<form action="/admin/founders/edit/<?= e((string)$founder['id']) ?>" method="POST" class="admin-form-card">
  <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">

  <div class="admin-notice-card" style="background:#EFF6FF; border:1px solid #BFDBFE; padding:16px; border-radius:10px; margin-bottom:20px;">
    <strong style="color:#1E40AF;"><i class="fa-solid fa-circle-info"></i> Missing Information Checklist:</strong>
    <p style="color:#1E3A8A; font-size:0.9rem; margin-top:4px;">
      Currently marked missing: <strong><?= e($founder['missing_fields'] ?: 'None') ?></strong>. Once official credentials have been entered and verified, clear this field and set status to <em>Published</em>.
    </p>
  </div>

  <div class="form-section-title">Official Identity &amp; Title</div>
  <div class="form-grid-2">
    <div class="form-group">
      <label>Full Legal Name *</label>
      <input type="text" name="name" value="<?= e($founder['name']) ?>" class="admin-input" required placeholder="e.g. Johnathan Dwarika">
      <small style="color:#64748B;">Enter the verified full name as registered under company trade license.</small>
    </div>
    <div class="form-group">
      <label>Official Corporate Designation *</label>
      <input type="text" name="designation" value="<?= e($founder['designation']) ?>" class="admin-input" required placeholder="e.g. Founder & Managing Director">
    </div>
  </div>

  <div class="form-section-title" style="margin-top:24px;">Executive Media &amp; Portrait</div>
  <div class="form-grid-2">
    <div class="form-group">
      <label>Official Portrait URL</label>
      <input type="text" name="photo_url" value="<?= e($founder['photo_url'] ?? '') ?>" class="admin-input" placeholder="/assets/images/founders/executive-portrait.jpg">
      <small style="color:#64748B;">Leave blank to display the corporate monogram crest until official photography is uploaded.</small>
    </div>
    <div class="form-group">
      <label>Missing Fields Note (Administrator Checklist)</label>
      <input type="text" name="missing_fields" value="<?= e($founder['missing_fields'] ?? '') ?>" class="admin-input" placeholder="e.g. Full Legal Name, Official Executive Portrait">
    </div>
  </div>

  <div class="form-section-title" style="margin-top:24px;">Biographies &amp; Leadership Governance</div>
  <div class="form-group">
    <label>Executive Quote / Guiding Philosophy</label>
    <input type="text" name="quote" value="<?= e($founder['quote'] ?? '') ?>" class="admin-input" placeholder="e.g. Opening doors to prosperity through uncompromising transparency...">
  </div>
  <div class="form-group">
    <label>Professional Biography *</label>
    <textarea name="full_bio" rows="6" class="admin-textarea" required><?= e($founder['full_bio'] ?? $founder['short_bio'] ?? '') ?></textarea>
  </div>
  <div class="form-group">
    <label>Professional Background &amp; Verified Qualifications</label>
    <input type="text" name="background" value="<?= e($founder['background'] ?? '') ?>" class="admin-input" placeholder="e.g. Real estate advisory, institutional acquisitions, and corporate governance in Dubai">
  </div>
  <div class="form-group">
    <label>Areas of Leadership &amp; Oversight (Comma-separated)</label>
    <input type="text" name="leadership_areas" value="<?= e($founder['leadership_areas'] ?? '') ?>" class="admin-input" placeholder="Strategic Vision, Institutional Alliances, Corporate Governance, Market Expansion">
  </div>

  <div class="form-section-title" style="margin-top:24px;">Corporate Desk Contact Channels</div>
  <div class="form-grid-3">
    <div class="form-group">
      <label>Executive Desk Email</label>
      <input type="email" name="email" value="<?= e($founder['email'] ?? '') ?>" class="admin-input" placeholder="leadership@dwarikarealestate.ae">
    </div>
    <div class="form-group">
      <label>Headquarters Phone</label>
      <input type="tel" name="phone" value="<?= e($founder['phone'] ?? '') ?>" class="admin-input" placeholder="+971 50 123 4567">
    </div>
    <div class="form-group">
      <label>Executive LinkedIn URL</label>
      <input type="url" name="linkedin_url" value="<?= e($founder['linkedin_url'] ?? '') ?>" class="admin-input" placeholder="https://linkedin.com/in/...">
    </div>
  </div>

  <div class="form-grid-2" style="margin-top:16px;">
    <div class="form-group">
      <label>Profile Status</label>
      <select name="status" class="admin-select">
        <option value="draft" <?= ($founder['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draft Profile (Pending Official Details)</option>
        <option value="published" <?= ($founder['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published (Fully Verified Details)</option>
      </select>
    </div>
  </div>

  <div class="form-actions-bar" style="margin-top:28px;">
    <button type="submit" class="btn-admin-primary">
      <i class="fa-solid fa-floppy-disk"></i> Update Leadership Profile
    </button>
    <a href="/admin/founders" class="btn-admin-secondary">Cancel</a>
  </div>
</form>
