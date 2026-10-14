/**
 * DRL Dwarika Real Estate LLC — Admin JavaScript Engine
 */

document.addEventListener('DOMContentLoaded', () => {
  // Mobile sidebar toggle
  const sidebarToggle = document.getElementById('sidebarToggle');
  const adminSidebar = document.getElementById('adminSidebar');

  sidebarToggle?.addEventListener('click', () => {
    adminSidebar?.classList.toggle('open');
  });

  // Auto-dismiss alerts after 4 seconds
  const alerts = document.querySelectorAll('.admin-alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.4s ease';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 400);
    }, 4000);
  });
});
