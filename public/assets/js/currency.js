/**
 * DRL Dwarika Real Estate LLC — Live Currency Converter Engine
 * Real-time rates from /api/exchange-rates with fallback & localStorage memory
 */
(function () {
  'use strict';

  const STORAGE_KEY = 'drl_selected_currency';
  const RATES_STORAGE_KEY = 'drl_exchange_rates_cache';

  const CURRENCY_CONFIG = {
    AED: { code: 'AED', symbol: 'AED', flag: '🇦🇪', name: 'UAE Dirham', locale: 'en-AE', space: true },
    USD: { code: 'USD', symbol: '$', flag: '🇺🇸', name: 'US Dollar', locale: 'en-US', space: false },
    EUR: { code: 'EUR', symbol: '€', flag: '🇪🇺', name: 'Euro', locale: 'de-DE', space: true },
    GBP: { code: 'GBP', symbol: '£', flag: '🇬🇧', name: 'British Pound', locale: 'en-GB', space: false },
    INR: { code: 'INR', symbol: '₹', flag: '🇮🇳', name: 'Indian Rupee', locale: 'en-IN', space: false },
    SAR: { code: 'SAR', symbol: 'SAR', flag: '🇸🇦', name: 'Saudi Riyal', locale: 'ar-SA-u-nu-latn', space: true },
    RUB: { code: 'RUB', symbol: '₽', flag: '🇷🇺', name: 'Russian Ruble', locale: 'ru-RU', space: true, symbolAfter: true }
  };

  // Robust fallback rates if network is offline or delayed
  const FALLBACK_RATES = {
    AED: 1,
    USD: 0.272294,
    EUR: 0.2431,
    GBP: 0.203582,
    INR: 25.877873,
    SAR: 1.021103,
    RUB: 22.136607
  };

  let currentRates = Object.assign({}, FALLBACK_RATES);
  let selectedCurrency = localStorage.getItem(STORAGE_KEY) || 'AED';

  // Format number based on locale
  function formatCurrencyValue(num, currencyCode) {
    const config = CURRENCY_CONFIG[currencyCode] || CURRENCY_CONFIG.AED;
    const rounded = Math.round(num);

    let formattedNum;
    try {
      formattedNum = new Intl.NumberFormat(config.locale || 'en-US', {
        maximumFractionDigits: 0
      }).format(rounded);
    } catch (e) {
      formattedNum = rounded.toLocaleString();
    }

    if (config.symbolAfter) {
      return formattedNum + (config.space ? ' ' : '') + config.symbol;
    }
    return config.symbol + (config.space ? ' ' : '') + formattedNum;
  }

  // Update all price elements on the page
  function updateAllPrices() {
    const rate = currentRates[selectedCurrency] || 1;
    const priceElements = document.querySelectorAll('.price-val, [data-base-price]');

    priceElements.forEach(el => {
      const basePrice = parseFloat(el.getAttribute('data-base-price'));
      if (isNaN(basePrice) || basePrice <= 0) return;

      const converted = basePrice * rate;
      el.textContent = formatCurrencyValue(converted, selectedCurrency);
    });
  }

  // Sync UI state for selectors
  function syncUI() {
    const config = CURRENCY_CONFIG[selectedCurrency] || CURRENCY_CONFIG.AED;

    // Desktop Custom Dropdown
    const flagEl = document.getElementById('currentCurrencyFlag');
    const codeEl = document.getElementById('currentCurrencyCode');
    if (flagEl) flagEl.textContent = config.flag;
    if (codeEl) codeEl.textContent = config.code;

    // Highlight active option in desktop list
    document.querySelectorAll('.currency-option').forEach(opt => {
      if (opt.getAttribute('data-currency') === selectedCurrency) {
        opt.classList.add('active');
        opt.setAttribute('aria-selected', 'true');
      } else {
        opt.classList.remove('active');
        opt.setAttribute('aria-selected', 'false');
      }
    });

    // Mobile Select Element
    const mobileSelect = document.getElementById('mobileCurrencySelect');
    if (mobileSelect && mobileSelect.value !== selectedCurrency) {
      mobileSelect.value = selectedCurrency;
    }
  }

  // Change currency handler
  function setCurrency(currencyCode) {
    if (!CURRENCY_CONFIG[currencyCode]) return;
    selectedCurrency = currencyCode;
    try {
      localStorage.setItem(STORAGE_KEY, currencyCode);
    } catch (e) {}

    syncUI();
    updateAllPrices();

    // Fire custom event for any third-party listeners
    window.dispatchEvent(new CustomEvent('drl:currency_change', {
      detail: {
        currency: selectedCurrency,
        rate: currentRates[selectedCurrency] || 1
      }
    }));
  }

  // Fetch live exchange rates from backend API
  async function fetchLiveRates() {
    try {
      // Check cached rates first
      const cached = sessionStorage.getItem(RATES_STORAGE_KEY);
      if (cached) {
        const parsed = JSON.parse(cached);
        if (parsed.rates && Date.now() - parsed.timestamp < 3600000) { // 1 hour cache in browser
          currentRates = Object.assign({}, FALLBACK_RATES, parsed.rates);
          updateAllPrices();
          return;
        }
      }

      const res = await fetch('/api/exchange-rates', {
        headers: { 'Accept': 'application/json' }
      });
      if (!res.ok) throw new Error('API failed');

      const data = await res.json();
      if (data && data.rates) {
        currentRates = Object.assign({}, FALLBACK_RATES, data.rates);
        try {
          sessionStorage.setItem(RATES_STORAGE_KEY, JSON.stringify({
            rates: currentRates,
            timestamp: Date.now()
          }));
        } catch (e) {}
        updateAllPrices();
      }
    } catch (err) {
      // Gracefully silent: fallback rates already in place
      console.warn('Using fallback exchange rates:', err.message);
    }
  }

  // Setup DOM event listeners
  function initCurrencyUI() {
    const wrap = document.getElementById('currencySelectorWrap');
    const trigger = document.getElementById('currencyDropdownBtn');
    const dropdown = document.getElementById('currencyDropdown');
    const mobileSelect = document.getElementById('mobileCurrencySelect');

    if (trigger && dropdown) {
      trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = wrap.classList.toggle('open');
        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });

      // Keyboard navigation
      trigger.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          wrap.classList.toggle('open');
        } else if (e.key === 'Escape') {
          wrap.classList.remove('open');
        }
      });

      // Option selection
      dropdown.addEventListener('click', (e) => {
        const option = e.target.closest('.currency-option');
        if (!option) return;
        const cur = option.getAttribute('data-currency');
        if (cur) {
          setCurrency(cur);
          wrap.classList.remove('open');
          trigger.setAttribute('aria-expanded', 'false');
        }
      });

      // Close on click outside
      document.addEventListener('click', (e) => {
        if (!wrap.contains(e.target)) {
          wrap.classList.remove('open');
          trigger.setAttribute('aria-expanded', 'false');
        }
      });
    }

    if (mobileSelect) {
      mobileSelect.addEventListener('change', (e) => {
        setCurrency(e.target.value);
      });
    }

    // Auto-convert any dynamically added property cards
    if (window.MutationObserver) {
      const observer = new MutationObserver((mutations) => {
        let hasNewPrices = false;
        mutations.forEach(m => {
          m.addedNodes.forEach(node => {
            if (node.nodeType === 1 && (node.matches('.price-val, [data-base-price]') || node.querySelector('.price-val, [data-base-price]'))) {
              hasNewPrices = true;
            }
          });
        });
        if (hasNewPrices) {
          updateAllPrices();
        }
      });

      const mainContent = document.getElementById('mainContent') || document.body;
      observer.observe(mainContent, { childList: true, subtree: true });
    }

    syncUI();
    updateAllPrices();
    fetchLiveRates();
  }

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCurrencyUI);
  } else {
    initCurrencyUI();
  }

  // Expose global API
  window.DRLCurrency = {
    setCurrency,
    getCurrency: () => selectedCurrency,
    getRates: () => currentRates,
    format: formatCurrencyValue
  };
})();
