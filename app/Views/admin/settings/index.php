<?php
/**
 * Admin Settings Management View
 */
?>

<div class="admin-page-header">
  <div class="header-titles">
    <h1 class="page-title">Global Site Settings &amp; Brand Config</h1>
    <p class="page-subtitle">Update official contact details, statistics, RERA licenses, and social media channels.</p>
  </div>
</div>

<form action="/admin/settings" method="POST" class="admin-form-card">
  <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">

  <div class="form-section-title">1. Brand Identity &amp; Tagline</div>
  <div class="form-row">
    <div class="form-group half-width">
      <label for="siteName">Company / Site Name</label>
      <input type="text" name="site_name" id="siteName" class="form-input" value="<?= e($settings['site_name'] ?? 'DRL Dwarika Real Estate LLC') ?>" required>
    </div>
    <div class="form-group half-width">
      <label for="siteTagline">Brand Tagline</label>
      <input type="text" name="site_tagline" id="siteTagline" class="form-input" value="<?= e($settings['site_tagline'] ?? 'Opening Doors To Prosperity') ?>" required>
    </div>
  </div>

  <div class="form-section-title">2. Contact Information</div>
  <div class="form-row">
    <div class="form-group third-width">
      <label for="compPhone">Official Phone Number</label>
      <input type="text" name="company_phone" id="compPhone" class="form-input" value="<?= e($settings['company_phone'] ?? '+971 542202920') ?>" required>
    </div>
    <div class="form-group third-width">
      <label for="compWa">WhatsApp Number (e.g. 971542202920)</label>
      <input type="text" name="company_whatsapp" id="compWa" class="form-input" value="<?= e($settings['company_whatsapp'] ?? '971542202920') ?>" required>
    </div>
    <div class="form-group third-width">
      <label for="compEmail">Contact Email</label>
      <input type="email" name="company_email" id="compEmail" class="form-input" value="<?= e($settings['company_email'] ?? 'admin@dwarikarealestate.ae') ?>" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group full-width">
      <label for="compAddr">Office Address (Business Bay, Dubai)</label>
      <input type="text" name="company_address" id="compAddr" class="form-input" value="<?= e($settings['company_address'] ?? 'Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira Dubai, UAE') ?>" required>
    </div>
  </div>

  <div class="form-section-title">3. Legal &amp; Licensing</div>
  <div class="form-row">
    <div class="form-group half-width">
      <label for="reraOrn">RERA ORN (Broker Registration)</label>
      <input type="text" name="rera_orn" id="reraOrn" class="form-input" value="<?= e($settings['rera_orn'] ?? '29482') ?>">
    </div>
    <div class="form-group half-width">
      <label for="dldLic">DLD Commercial License</label>
      <input type="text" name="dld_license" id="dldLic" class="form-input" value="<?= e($settings['dld_license'] ?? '1637547') ?>">
    </div>
  </div>

  <div class="form-section-title">4. Homepage Company Statistics</div>
  <div class="form-row">
    <div class="form-group third-width">
      <label for="statSold">Properties Sold Counter</label>
      <input type="text" name="stat_properties_sold" id="statSold" class="form-input" value="<?= e($settings['stat_properties_sold'] ?? '100+') ?>">
    </div>
    <div class="form-group third-width">
      <label for="statClients">Happy Clients Counter</label>
      <input type="text" name="stat_happy_clients" id="statClients" class="form-input" value="<?= e($settings['stat_happy_clients'] ?? '50+') ?>">
    </div>
    <div class="form-group third-width">
      <label for="statExp">Years Experience Counter</label>
      <input type="text" name="stat_years_experience" id="statExp" class="form-input" value="<?= e($settings['stat_years_experience'] ?? '5+') ?>">
    </div>
  </div>

  <div class="form-section-title">5. Social Media Channels</div>
  <div class="form-row">
    <div class="form-group half-width">
      <label for="socFb">Facebook URL</label>
      <input type="text" name="social_facebook" id="socFb" class="form-input" value="<?= e($settings['social_facebook'] ?? '') ?>">
    </div>
    <div class="form-group half-width">
      <label for="socIg">Instagram URL</label>
      <input type="text" name="social_instagram" id="socIg" class="form-input" value="<?= e($settings['social_instagram'] ?? '') ?>">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group half-width">
      <label for="socLi">LinkedIn URL</label>
      <input type="text" name="social_linkedin" id="socLi" class="form-input" value="<?= e($settings['social_linkedin'] ?? '') ?>">
    </div>
    <div class="form-group half-width">
      <label for="socYt">YouTube URL</label>
      <input type="text" name="social_youtube" id="socYt" class="form-input" value="<?= e($settings['social_youtube'] ?? '') ?>">
    </div>
  </div>

  <div class="form-actions-bar">
    <button type="submit" class="btn-admin-primary">
      <i class="fa-solid fa-floppy-disk"></i> Save Site Settings
    </button>
  </div>
</form>
