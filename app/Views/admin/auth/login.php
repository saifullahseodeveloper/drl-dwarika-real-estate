<?php
/**
 * Admin Login Page
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($meta_title ?? 'Admin Login | DRL Dwarika') ?></title>
  <link rel="icon" type="image/png" href="/assets/images/logo.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="login-body">

  <div class="login-card-wrap">
    <div class="login-header text-center">
      <img src="/assets/images/logo.png" alt="DRL Dwarika Real Estate LLC" width="180" height="60" class="login-logo">
      <h1 class="login-title">Admin Management Portal</h1>
      <p class="login-subtitle">Sign in with your administrative credentials to manage listings, leads, and content.</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="admin-alert error" role="alert">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?= e($error) ?></span>
      </div>
    <?php endif; ?>

    <form action="/admin/login" method="POST" class="login-form">
      <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? '') ?>">

      <div class="form-group">
        <label for="adminEmail">Email Address</label>
        <div class="input-icon-wrap">
          <i class="fa-solid fa-envelope"></i>
          <input type="email" name="email" id="adminEmail" class="form-input" placeholder="admin@dwarikarealestate.ae" value="admin@dwarikarealestate.ae" required autofocus>
        </div>
      </div>

      <div class="form-group">
        <label for="adminPassword">Password</label>
        <div class="input-icon-wrap">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" id="adminPassword" class="form-input" placeholder="••••••••••••" value="AdminPassword2025!" required>
        </div>
      </div>

      <button type="submit" class="btn-admin-primary full-width" id="btnAdminSignIn">
        <span>Sign In to Dashboard</span>
        <i class="fa-solid fa-arrow-right"></i>
      </button>

      <div class="login-credentials-hint">
        <small><i class="fa-solid fa-circle-info"></i> Demo Admin Account: <strong>admin@dwarikarealestate.ae</strong> / <strong>AdminPassword2025!</strong></small>
      </div>
    </form>

    <div class="login-footer text-center">
      <a href="/" class="back-home-link"><i class="fa-solid fa-arrow-left"></i> Return to Public Website</a>
    </div>
  </div>

</body>
</html>
