/**
 * DRL Dwarika Real Estate LLC — Public JavaScript Engine
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Mobile Drawer Navigation
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const mobileDrawer = document.getElementById('mobileDrawer');
  const mobileDrawerClose = document.getElementById('mobileDrawerClose');
  const mobileBackdrop = document.getElementById('mobileBackdrop');

  function openMobileMenu() {
    mobileDrawer?.classList.add('open');
    mobileBackdrop?.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileMenu() {
    mobileDrawer?.classList.remove('open');
    mobileBackdrop?.classList.remove('open');
    document.body.style.overflow = '';
  }

  mobileMenuBtn?.addEventListener('click', openMobileMenu);
  mobileDrawerClose?.addEventListener('click', closeMobileMenu);
  mobileBackdrop?.addEventListener('click', closeMobileMenu);

  // 2. Header Scroll Shadow (Optimized with requestAnimationFrame to eliminate Forced Reflow)
  const header = document.getElementById('siteHeader');
  let scrollTicking = false;
  window.addEventListener('scroll', () => {
    if (!scrollTicking) {
      window.requestAnimationFrame(() => {
        if (window.scrollY > 20) {
          header?.classList.add('scrolled');
        } else {
          header?.classList.remove('scrolled');
        }
        scrollTicking = false;
      });
      scrollTicking = true;
    }
  }, { passive: true });

  // 3. Property Inquiry AJAX Handler
  const inquiryForms = document.querySelectorAll('#propertyInquiryForm, #mainContactForm');
  inquiryForms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn ? submitBtn.innerHTML : '';

      try {
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
        }

        const formData = new FormData(form);
        const res = await fetch(form.action, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();
        if (data.success) {
          showToast(data.message || 'Inquiry sent successfully!', 'success');
          form.reset();
        } else {
          showToast(data.error || 'Failed to submit inquiry. Please try again.', 'error');
        }
      } catch (err) {
        // Fallback to normal form submit if fetch fails
        form.submit();
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }
      }
      e.preventDefault();
    });
  });

  // 4. Toast Notification Helper
  function showToast(message, type = 'success') {
    const existing = document.getElementById('toastAlert');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.id = 'toastAlert';
    toast.innerHTML = `
      <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
      <span>${message}</span>
      <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
      toast.remove();
    }, 5000);
  }

  // 5. Testimonials Dot Indicators Interaction
  const dots = document.querySelectorAll('.testimonial-carousel-dots .dot');
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      dots.forEach(d => d.classList.remove('active'));
      dot.classList.add('active');
    });
  });
});
