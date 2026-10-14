<?php
/**
 * Admin Founders & Leadership Profiles List View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Corporate Leadership &amp; Founders</h1>
    <p class="page-subtitle">Manage executive profiles for DRL Dwarika Real Estate LLC. Keep official details verified under UAE corporate registry.</p>
  </div>
  <div class="header-actions">
    <a href="/founders" target="_blank" class="btn-admin-secondary">
      <i class="fa-solid fa-arrow-up-right-from-square"></i> View Public Founders Page
    </a>
  </div>
</div>

<!-- Prominent Governance Warning Banner for Website Administrator -->
<div class="admin-notice-card" style="background:#FFFBEB; border:1px solid #FDE68A; border-left:4px solid #D97706; padding:18px 24px; border-radius:12px; margin-bottom:24px;">
  <div style="display:flex; gap:16px; align-items:flex-start;">
    <i class="fa-solid fa-triangle-exclamation" style="color:#D97706; font-size:1.5rem; margin-top:2px;"></i>
    <div>
      <h3 style="font-size:1rem; color:#92400E; margin-bottom:4px; font-weight:700;">Corporate Compliance &amp; Administrator Action Required</h3>
      <p style="font-size:0.9rem; color:#78350F; line-height:1.5; margin:0;">
        Founder names, qualifications, achievements, official portraits, and biographies must never be fabricated. The profiles below are structured as <strong>editable drafts</strong>. Please update each profile with the verified legal names, credentials, and executive portraits of DRL Dwarika Real Estate LLC leadership before setting their status to Published.
      </p>
    </div>
  </div>
</div>

<div class="dash-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Official Role</th>
          <th>Profile Name</th>
          <th>Status</th>
          <th>Missing Required Information</th>
          <th>Areas of Leadership</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($founders)): ?>
          <?php foreach ($founders as $founder): ?>
            <?php 
              $isDraft = ($founder['status'] ?? 'draft') === 'draft';
            ?>
            <tr>
              <td>
                <strong style="color:var(--color-navy);"><?= e($founder['designation']) ?></strong>
              </td>
              <td>
                <div style="display:flex; align-items:center; gap:10px;">
                  <?php if (!empty($founder['photo_url'])): ?>
                    <img src="<?= e($founder['photo_url']) ?>" alt="" style="width:36px; height:36px; border-radius:50%; object-fit:cover;">
                  <?php else: ?>
                    <div style="width:36px; height:36px; border-radius:50%; background:#F0F7FC; color:#1689CC; display:flex; align-items:center; justify-content:center; font-size:0.9rem;">
                      <i class="fa-solid fa-user-tie"></i>
                    </div>
                  <?php endif; ?>
                  <div>
                    <strong><?= e($founder['name']) ?></strong>
                  </div>
                </div>
              </td>
              <td>
                <?php if ($isDraft): ?>
                  <span class="badge" style="background:#FEF3C7; color:#92400E; font-weight:600; padding:6px 12px; border-radius:20px;">
                    <i class="fa-solid fa-clock"></i> Draft (Pending Info)
                  </span>
                <?php else: ?>
                  <span class="badge badge-success">
                    <i class="fa-solid fa-circle-check"></i> Published
                  </span>
                <?php endif; ?>
              </td>
              <td>
                <?php if (!empty($founder['missing_fields'])): ?>
                  <span style="font-size:0.85rem; color:#B45309; background:#FFFBEB; padding:4px 8px; border-radius:6px; display:inline-block; border:1px dashed #FCD34D;">
                    <i class="fa-solid fa-pen-nib"></i> <?= e($founder['missing_fields']) ?>
                  </span>
                <?php else: ?>
                  <span style="font-size:0.85rem; color:#15803D;"><i class="fa-solid fa-check"></i> Complete</span>
                <?php endif; ?>
              </td>
              <td>
                <small style="color:#64748B;"><?= e($founder['leadership_areas'] ?? '—') ?></small>
              </td>
              <td>
                <a href="/admin/founders/edit/<?= e((string)$founder['id']) ?>" class="btn-table-action" style="background:#1689CC; color:#fff;" title="Edit Founder Profile">
                  <i class="fa-solid fa-pen-to-square"></i> Edit Profile
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center" style="padding:40px;">No leadership records found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
