/**
 * DRL DWARIKA REAL ESTATE LLC — HIGH-INTERACTIVITY ADMIN PORTAL ENGINE
 * Integrates Developer & SEO Repositories from Saifullah SEO Developer:
 * - Free SEO ROI Calculator
 * - Free PageSpeed Revenue Impact Calculator
 * - Free Local SEO 25-Point Scorecard
 * - Free Schema JSON-LD Studio & Formatter
 * - Free Color Palette & Contrast Studio
 * Plus:
 * - Real-time Live Table Filter
 * - One-click AJAX Lead Status Updates
 * - Interactive Dashboard SVG Trend Charts
 * - Toast Notification System
 */

document.addEventListener('DOMContentLoaded', () => {

  // ====================================================================
  // 1. SIDEBAR TOGGLE & AUTO-DISMISS ALERTS
  // ====================================================================
  const sidebarToggle = document.getElementById('sidebarToggle');
  const adminSidebar = document.getElementById('adminSidebar');

  sidebarToggle?.addEventListener('click', () => {
    adminSidebar?.classList.toggle('open');
  });

  const alerts = document.querySelectorAll('.admin-alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.4s ease';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 400);
    }, 4500);
  });

  // Global Toast Helper
  window.showAdminToast = function(message, type = 'success') {
    const existing = document.getElementById('adminGlobalToast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'adminGlobalToast';
    toast.className = `admin-alert ${type}`;
    toast.style.position = 'fixed';
    toast.style.bottom = '24px';
    toast.style.right = '24px';
    toast.style.zIndex = '9999';
    toast.style.boxShadow = '0 10px 30px rgba(0,0,0,0.15)';
    toast.style.animation = 'fadeIn 0.3s ease';
    toast.innerHTML = `
      <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'}"></i>
      <span>${message}</span>
      <button type="button" style="background:none;border:none;margin-left:12px;cursor:pointer;font-size:1.1rem;color:inherit;" onclick="this.parentElement.remove()">&times;</button>
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
      toast.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(10px)';
      setTimeout(() => toast.remove(), 400);
    }, 4000);
  };

  // ====================================================================
  // 2. LIVE TABLE INSTANT SEARCH (Dashboard, Properties, Leads)
  // ====================================================================
  const topSearchInput = document.querySelector('.topbar-search input');
  if (topSearchInput) {
    topSearchInput.addEventListener('input', (e) => {
      const term = e.target.value.trim().toLowerCase();
      const tables = document.querySelectorAll('.admin-table tbody');

      tables.forEach(tbody => {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          if (!term || text.includes(term)) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
      });
    });
  }

  // ====================================================================
  // 3. ONE-CLICK AJAX STATUS UPDATES (Inquiries / Leads CRM)
  // ====================================================================
  const quickStatusForms = document.querySelectorAll('.status-quick-form select');
  quickStatusForms.forEach(select => {
    // Override standard onchange
    select.onchange = null;
    select.addEventListener('change', async (e) => {
      const selectEl = e.target;
      const form = selectEl.closest('form');
      const actionUrl = form.action;
      const newStatus = selectEl.value;

      try {
        const formData = new FormData(form);
        const res = await fetch(actionUrl, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          },
          body: formData
        });

        // Update status pill styling on the same row
        const row = selectEl.closest('tr');
        const pill = row ? row.querySelector('.status-pill') : null;
        if (pill) {
          pill.className = `status-pill status-${newStatus}`;
          pill.textContent = newStatus.toUpperCase();
        }

        window.showAdminToast(`Lead status updated to ${newStatus.toUpperCase()}`, 'success');
      } catch (err) {
        // Fallback to normal form submit if fetch fails
        form.submit();
      }
    });
  });

  // ====================================================================
  // 4. GROWTH TOOLS HUB TAB SWITCHING
  // ====================================================================
  const tabBtns = document.querySelectorAll('.tool-tab-btn');
  const tabContents = document.querySelectorAll('.tool-tab-content');

  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-tab');

      tabBtns.forEach(b => b.classList.remove('active'));
      tabContents.forEach(c => c.classList.remove('active'));

      btn.classList.add('active');
      const targetContent = document.getElementById(targetId);
      if (targetContent) {
        targetContent.classList.add('active');
      }

      // Update URL hash without scroll
      const tabName = targetId.replace('tab-', '');
      const newUrl = new URL(window.location);
      newUrl.searchParams.set('tab', tabName);
      window.history.replaceState({}, '', newUrl);
    });
  });

  // ====================================================================
  // 5. SEO ROI CALCULATOR ENGINE (Saifullah free-seo-roi-calculator)
  // ====================================================================
  const searchVolInput = document.getElementById('monthlySearchVol');
  const rankCtrInput = document.getElementById('targetRankCtr');
  const visitorLeadInput = document.getElementById('visitorLeadRate');
  const leadCloseInput = document.getElementById('leadCloseRate');
  const avgDealPriceInput = document.getElementById('avgDealPrice');
  const commissionRateInput = document.getElementById('commissionRate');
  const monthlyCostInput = document.getElementById('monthlySeoCost');
  const roiPresetSelect = document.getElementById('roiPresetSelect');

  // Presets mapping
  const PRESETS = {
    downtown: { vol: 62000, ctr: 22.0, conv: 3.2, close: 4.5, price: 2800000, comm: 2.0, cost: 9500 },
    hills: { vol: 48000, ctr: 19.5, conv: 3.0, close: 5.0, price: 5500000, comm: 2.0, cost: 8500 },
    palm: { vol: 35000, ctr: 16.0, conv: 2.2, close: 3.5, price: 18500000, comm: 2.0, cost: 12000 },
    offplan: { vol: 85000, ctr: 24.0, conv: 3.8, close: 4.0, price: 1950000, comm: 3.0, cost: 10000 }
  };

  roiPresetSelect?.addEventListener('change', (e) => {
    const val = e.target.value;
    if (PRESETS[val]) {
      const p = PRESETS[val];
      if (searchVolInput) searchVolInput.value = p.vol;
      if (rankCtrInput) rankCtrInput.value = p.ctr;
      if (visitorLeadInput) visitorLeadInput.value = p.conv;
      if (leadCloseInput) leadCloseInput.value = p.close;
      if (avgDealPriceInput) avgDealPriceInput.value = p.price;
      if (commissionRateInput) commissionRateInput.value = p.comm;
      if (monthlyCostInput) monthlyCostInput.value = p.cost;
      calculateRoi();
      window.showAdminToast(`Loaded preset benchmark for ${e.target.options[e.target.selectedIndex].text}`, 'success');
    }
  });

  function formatAed(num) {
    return 'AED ' + Math.round(num).toLocaleString('en-US');
  }

  function calculateRoi() {
    if (!searchVolInput) return;

    const vol = parseFloat(searchVolInput.value) || 0;
    const ctr = parseFloat(rankCtrInput.value) || 0;
    const conv = parseFloat(visitorLeadInput.value) || 0;
    const close = parseFloat(leadCloseInput.value) || 0;
    const price = parseFloat(avgDealPriceInput.value) || 0;
    const commRate = parseFloat(commissionRateInput.value) || 0;
    const cost = parseFloat(monthlyCostInput.value) || 0;

    // Badges update
    document.getElementById('valSearchVol').textContent = `${vol.toLocaleString()} / mo`;
    document.getElementById('valRankCtr').textContent = `${ctr.toFixed(1)}% (Ranked)`;
    document.getElementById('valVisitorLead').textContent = `${conv.toFixed(1)}%`;
    document.getElementById('valLeadClose').textContent = `${close.toFixed(1)}%`;

    // Formulas
    const monthlyClicks = vol * (ctr / 100);
    const monthlyLeads = monthlyClicks * (conv / 100);
    const monthlyDeals = monthlyLeads * (close / 100);
    const avgCommission = price * (commRate / 100);
    const monthlyGrossCommission = monthlyDeals * avgCommission;
    const annualGrossCommission = monthlyGrossCommission * 12;
    const annualPipelineValue = monthlyDeals * price * 12;
    const netMonthlyProfit = monthlyGrossCommission - cost;
    const roiMultiple = cost > 0 ? (monthlyGrossCommission / cost) : 0;

    // Render results
    document.getElementById('resAnnualPipeline').textContent = formatAed(annualPipelineValue);
    document.getElementById('resMonthlyClicks').textContent = Math.round(monthlyClicks).toLocaleString();
    document.getElementById('resMonthlyLeads').textContent = Math.round(monthlyLeads).toLocaleString();
    document.getElementById('resMonthlyDeals').textContent = (monthlyDeals).toFixed(1) + ' / mo';
    document.getElementById('resMonthlyCommission').textContent = formatAed(monthlyGrossCommission);
    document.getElementById('resNetMonthlyProfit').textContent = formatAed(netMonthlyProfit);
    document.getElementById('resAnnualCommission').textContent = formatAed(annualGrossCommission);
    document.getElementById('resRoiMultiple').textContent = `${roiMultiple.toFixed(1)}x ROI`;
  }

  // Bind input listeners
  [searchVolInput, rankCtrInput, visitorLeadInput, leadCloseInput, avgDealPriceInput, commissionRateInput, monthlyCostInput].forEach(inp => {
    inp?.addEventListener('input', calculateRoi);
  });
  calculateRoi();

  // Export ROI Summary CSV
  const btnExportRoi = document.getElementById('btnExportRoiSummary');
  btnExportRoi?.addEventListener('click', () => {
    const csvContent = "data:text/csv;charset=utf-8,"
      + "Metric,Value\n"
      + `Target Monthly Search Volume,${searchVolInput.value}\n`
      + `Target Organic CTR %,${rankCtrInput.value}%\n`
      + `Visitor Lead Conversion %,${visitorLeadInput.value}%\n`
      + `Lead Close Rate %,${leadCloseInput.value}%\n`
      + `Average Property Deal (AED),${avgDealPriceInput.value}\n`
      + `Agency Commission %,${commissionRateInput.value}%\n`
      + `Projected Annual Pipeline Value,${document.getElementById('resAnnualPipeline').textContent.replace(/,/g, '')}\n`
      + `Projected Monthly Commission,${document.getElementById('resMonthlyCommission').textContent.replace(/,/g, '')}\n`
      + `Projected Annual Gross Commission,${document.getElementById('resAnnualCommission').textContent.replace(/,/g, '')}\n`
      + `Calculated ROI Multiple,${document.getElementById('resRoiMultiple').textContent}\n`;

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `DRL_Dwarika_SEO_ROI_Forecast_${new Date().toISOString().slice(0,10)}.csv`);
    document.body.appendChild(link);
    link.click();
    link.remove();
    window.showAdminToast('Executive SEO ROI Forecast exported to CSV!', 'success');
  });

  // ====================================================================
  // 6. PAGESPEED IMPACT CALCULATOR (Saifullah free-page-speed-calculator)
  // ====================================================================
  const curLoadInput = document.getElementById('currentLoadSec');
  const optLoadInput = document.getElementById('optimizedLoadSec');
  const mobileVisInput = document.getElementById('monthlyMobileVisitors');
  const curConvInput = document.getElementById('currentLeadConvRate');
  const avgLeadValInput = document.getElementById('avgLeadValueAed');

  function calculatePageSpeedImpact() {
    if (!curLoadInput) return;

    const curSec = parseFloat(curLoadInput.value) || 4.0;
    const optSec = parseFloat(optLoadInput.value) || 1.2;
    const visitors = parseFloat(mobileVisInput.value) || 18000;
    const convRate = parseFloat(curConvInput.value) || 2.0;
    const leadVal = parseFloat(avgLeadValInput.value) || 2800;

    document.getElementById('valMobileVisitors').textContent = visitors.toLocaleString();

    const speedDiff = Math.max(0, curSec - optSec);
    // Deloitte & Google: 0.1s improvement = ~8.4% conversion uplift
    const bounceReduction = Math.min(48, Math.round(speedDiff * 8.5));
    const visitorsSaved = Math.round(visitors * (bounceReduction / 100));

    // Conversion rate increase
    const conversionUpliftFactor = 1 + (speedDiff * 0.12);
    const newConvRate = convRate * conversionUpliftFactor;
    const originalLeads = visitors * (convRate / 100);
    const newTotalLeads = (visitors + (visitorsSaved * 0.4)) * (newConvRate / 100);
    const additionalMonthlyLeads = Math.max(0, Math.round(newTotalLeads - originalLeads));
    const monthlySpeedRevenue = additionalMonthlyLeads * leadVal;
    const annualSpeedRevenue = monthlySpeedRevenue * 12;

    document.getElementById('resSpeedAnnualRev').textContent = formatAed(annualSpeedRevenue);
    document.getElementById('resSpeedGainHeadline').textContent = `Speed Gain: ${speedDiff.toFixed(1)}s faster load time`;
    document.getElementById('resBounceDrop').textContent = `-${bounceReduction}%`;
    document.getElementById('resVisitorsSaved').textContent = `+${visitorsSaved.toLocaleString()} / mo`;
    document.getElementById('resNewLeadsSpeed').textContent = `+${additionalMonthlyLeads} Leads/mo`;
    document.getElementById('resMonthlySpeedRev').textContent = formatAed(monthlySpeedRevenue);

    const badgeLcp = document.getElementById('badgeLcp');
    if (badgeLcp) {
      if (optSec <= 2.5) {
        badgeLcp.className = 'badge-vitals-good';
        badgeLcp.textContent = `${optSec.toFixed(1)}s — Good (Google Passed)`;
      } else {
        badgeLcp.className = 'badge-vitals-good';
        badgeLcp.style.background = '#FEF3C7';
        badgeLcp.style.color = '#B45309';
        badgeLcp.textContent = `${optSec.toFixed(1)}s — Needs Improvement`;
      }
    }
  }

  [curLoadInput, optLoadInput, mobileVisInput, curConvInput, avgLeadValInput].forEach(inp => {
    inp?.addEventListener('input', calculatePageSpeedImpact);
  });
  calculatePageSpeedImpact();

  // ====================================================================
  // 7. DUBAI LOCAL SEO 25-POINT SCORECARD (Saifullah free-local-seo-audit)
  // ====================================================================
  const scorecardChecklist = document.getElementById('scorecardChecklist');
  const STORAGE_KEY = 'dwarika_local_seo_scorecard_state';

  function updateScorecard() {
    if (!scorecardChecklist) return;
    const checkboxes = scorecardChecklist.querySelectorAll('input[type="checkbox"]');
    let totalChecked = 0;
    const total = checkboxes.length || 25;

    checkboxes.forEach(cb => {
      if (cb.checked) totalChecked++;
    });

    const percent = Math.round((totalChecked / total) * 100);
    document.getElementById('scorecardNum').textContent = `${totalChecked} / ${total}`;
    document.getElementById('scoreProgressFill').style.width = `${percent}%`;
    document.getElementById('scorePercentLabel').textContent = `${percent}% Optimization Complete`;

    const gradeEl = document.getElementById('scorecardGrade');
    if (gradeEl) {
      if (percent >= 90) {
        gradeEl.textContent = 'Grade: A+ (Local 3-Pack Ready)';
        gradeEl.style.color = '#10B981';
      } else if (percent >= 80) {
        gradeEl.textContent = 'Grade: A (Strong Visibility)';
        gradeEl.style.color = '#C5A880';
      } else if (percent >= 70) {
        gradeEl.textContent = 'Grade: B (Good)';
        gradeEl.style.color = '#38BDF8';
      } else if (percent >= 60) {
        gradeEl.textContent = 'Grade: C (Average)';
        gradeEl.style.color = '#F59E0B';
      } else {
        gradeEl.textContent = 'Grade: Needs Polish';
        gradeEl.style.color = '#EF4444';
      }
    }
  }

  // Load saved state
  if (scorecardChecklist) {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) {
      try {
        const stateArray = JSON.parse(saved);
        const checkboxes = scorecardChecklist.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach((cb, idx) => {
          if (stateArray[idx] !== undefined) {
            cb.checked = stateArray[idx];
          }
        });
      } catch (e) {}
    }

    scorecardChecklist.addEventListener('change', updateScorecard);
    updateScorecard();

    document.getElementById('btnSaveScorecard')?.addEventListener('click', () => {
      const checkboxes = scorecardChecklist.querySelectorAll('input[type="checkbox"]');
      const state = Array.from(checkboxes).map(cb => cb.checked);
      localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
      window.showAdminToast('Local SEO Scorecard state saved successfully!', 'success');
    });

    document.getElementById('btnResetScorecard')?.addEventListener('click', () => {
      localStorage.removeItem(STORAGE_KEY);
      location.reload();
    });
  }

  // ====================================================================
  // 8. SCHEMA JSON-LD STUDIO & FORMATTER (Saifullah free-json-formatter)
  // ====================================================================
  const schemaTypeSelect = document.getElementById('schemaTypeSelect');
  const schemaDynamicFields = document.getElementById('schemaDynamicFields');
  const schemaCodeOutput = document.getElementById('schemaCodeOutput');
  const btnGenerateSchema = document.getElementById('btnGenerateSchema');
  const btnCopySchema = document.getElementById('btnCopySchema');

  const SCHEMAS = {
    RealEstateAgent: {
      name: "DRL Dwarika Real Estate LLC",
      legalName: "DRL Dwarika Real Estate LLC",
      url: "https://dwarikarealestate.ae",
      logo: "https://dwarikarealestate.ae/assets/images/logo.svg",
      telephone: "+971542202920",
      email: "admin@dwarikarealestate.ae",
      address: {
        "@type": "PostalAddress",
        streetAddress: "Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira",
        addressLocality: "Dubai",
        addressRegion: "Dubai",
        addressCountry: "AE"
      },
      geo: {
        "@type": "GeoCoordinates",
        latitude: 25.1857,
        longitude: 55.2687
      },
      priceRange: "AED 1,000,000 - 50,000,000"
    },
    SingleFamilyResidence: {
      "@context": "https://schema.org",
      "@type": "SingleFamilyResidence",
      name: "Modern Villa in Dubai Hills Estate",
      description: "Contemporary 4-bedroom luxury villa with private infinity pool and golf course views.",
      numberOfRooms: 4,
      numberOfBathroomsTotal: 5,
      floorSize: {
        "@type": "QuantitativeValue",
        value: 4850,
        unitCode: "FTK"
      },
      address: {
        "@type": "PostalAddress",
        addressLocality: "Dubai Hills Estate",
        addressRegion: "Dubai",
        addressCountry: "AE"
      },
      offers: {
        "@type": "Offer",
        price: 4500000,
        priceCurrency: "AED",
        availability: "https://schema.org/InStock",
        businessFunction: "https://schema.org/SellAction"
      }
    },
    Apartment: {
      "@context": "https://schema.org",
      "@type": "Apartment",
      name: "Downtown Dubai Skyline Penthouse",
      description: "Direct Burj Khalifa and Dubai Fountain view duplex luxury residence.",
      numberOfBedrooms: 3,
      numberOfBathroomsTotal: 4,
      floorSize: {
        "@type": "QuantitativeValue",
        value: 3200,
        unitCode: "FTK"
      },
      offers: {
        "@type": "Offer",
        price: 7800000,
        priceCurrency: "AED",
        availability: "https://schema.org/InStock"
      }
    },
    FAQPage: {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      mainEntity: [
        {
          "@type": "Question",
          name: "Can foreigners buy freehold property in Dubai?",
          acceptedAnswer: {
            "@type": "Answer",
            text: "Yes, non-UAE citizens can purchase 100% freehold properties in designated investment communities like Downtown Dubai, Dubai Hills, Business Bay, and Palm Jumeirah."
          }
        },
        {
          "@type": "Question",
          name: "How do I qualify for the UAE Golden Visa through real estate?",
          acceptedAnswer: {
            "@type": "Answer",
            text: "Investors who purchase property valued at AED 2,000,000 or more are eligible for a 10-year renewable UAE Golden Visa for themselves and their immediate family."
          }
        }
      ]
    }
  };

  function renderSchemaOutput() {
    if (!schemaTypeSelect || !schemaCodeOutput) return;
    const type = schemaTypeSelect.value;
    const data = SCHEMAS[type] || SCHEMAS.RealEstateAgent;
    const fullSchema = {
      "@context": "https://schema.org",
      ...data
    };
    schemaCodeOutput.textContent = `<script type="application/ld+json">\n${JSON.stringify(fullSchema, null, 2)}\n</script>`;
  }

  schemaTypeSelect?.addEventListener('change', renderSchemaOutput);
  btnGenerateSchema?.addEventListener('click', () => {
    renderSchemaOutput();
    window.showAdminToast('Structured schema generated and formatted!', 'success');
  });
  renderSchemaOutput();

  btnCopySchema?.addEventListener('click', () => {
    if (!schemaCodeOutput) return;
    navigator.clipboard.writeText(schemaCodeOutput.textContent).then(() => {
      window.showAdminToast('JSON-LD copied to clipboard!', 'success');
    });
  });

  // ====================================================================
  // 9. BRAND COLOR PALETTE & CONTRAST STUDIO (Saifullah free-color-picker)
  // ====================================================================
  const colorPickerNative = document.getElementById('interactiveColorPicker');
  const colorHexInput = document.getElementById('colorHexInput');
  const colorRgbOutput = document.getElementById('colorRgbOutput');
  const colorHslOutput = document.getElementById('colorHslOutput');

  function hexToRgb(hex) {
    hex = hex.replace(/^#/, '');
    if (hex.length === 3) hex = hex.split('').map(c => c + c).join('');
    const num = parseInt(hex, 16);
    return { r: (num >> 16) & 255, g: (num >> 8) & 255, b: num & 255 };
  }

  function rgbToHsl(r, g, b) {
    r /= 255; g /= 255; b /= 255;
    const max = Math.max(r, g, b), min = Math.min(r, g, b);
    let h, s, l = (max + min) / 2;
    if (max === min) {
      h = s = 0;
    } else {
      const d = max - min;
      s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
      switch (max) {
        case r: h = (g - b) / d + (g < b ? 6 : 0); break;
        case g: h = (b - r) / d + 2; break;
        case b: h = (r - g) / d + 4; break;
      }
      h /= 6;
    }
    return {
      h: Math.round(h * 360),
      s: Math.round(s * 100),
      l: Math.round(l * 100)
    };
  }

  function updateColorValues(hex) {
    if (!/^#[0-9A-Fa-f]{6}$/.test(hex)) return;
    const rgb = hexToRgb(hex);
    const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);

    if (colorHexInput) colorHexInput.value = hex.toUpperCase();
    if (colorRgbOutput) colorRgbOutput.value = `rgb(${rgb.r}, ${rgb.g}, ${rgb.b})`;
    if (colorHslOutput) colorHslOutput.value = `hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)`;
    if (colorPickerNative) colorPickerNative.value = hex;
  }

  colorPickerNative?.addEventListener('input', (e) => updateColorValues(e.target.value));
  colorHexInput?.addEventListener('input', (e) => {
    let val = e.target.value.trim();
    if (!val.startsWith('#')) val = '#' + val;
    if (/^#[0-9A-Fa-f]{6}$/.test(val)) updateColorValues(val);
  });

  // Click on swatch card to load into inspector
  document.querySelectorAll('.color-swatch-card').forEach(card => {
    card.addEventListener('click', () => {
      const hex = card.getAttribute('data-hex');
      if (hex) {
        updateColorValues(hex);
        window.showAdminToast(`Selected ${hex} in inspector`, 'success');
      }
    });
  });

  // ====================================================================
  // 10. INTERACTIVE DASHBOARD TRENDS CHART (Canvas/SVG Sparkline)
  // ====================================================================
  const chartWrap = document.getElementById('dashboardTrendsChart');
  if (chartWrap) {
    const months = ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'];
    const inquiryData = [12, 18, 22, 29, 35, 42, 48, 55, 62, 74, 88, 105];

    let svgPoints = '';
    const width = 800, height = 180, padding = 30;
    const maxVal = Math.max(...inquiryData);

    inquiryData.forEach((val, idx) => {
      const x = padding + (idx * ((width - (padding * 2)) / (inquiryData.length - 1)));
      const y = height - padding - ((val / maxVal) * (height - (padding * 2)));
      svgPoints += `${idx === 0 ? 'M' : 'L'} ${x} ${y} `;
    });

    chartWrap.innerHTML = `
      <svg viewBox="0 0 ${width} ${height}" style="width:100%; height:100%; overflow:visible;">
        <defs>
          <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#1689CC" stop-opacity="0.3"/>
            <stop offset="100%" stop-color="#1689CC" stop-opacity="0.0"/>
          </linearGradient>
        </defs>
        <path d="${svgPoints} L ${width - padding} ${height - padding} L ${padding} ${height - padding} Z" fill="url(#chartGrad)"/>
        <path d="${svgPoints}" fill="none" stroke="#1689CC" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        ${inquiryData.map((val, idx) => {
          const x = padding + (idx * ((width - (padding * 2)) / (inquiryData.length - 1)));
          const y = height - padding - ((val / maxVal) * (height - (padding * 2)));
          return `
            <circle cx="${x}" cy="${y}" r="5" fill="#FFFFFF" stroke="#0F1E2E" stroke-width="2.5" class="chart-point" style="cursor:pointer;">
              <title>${months[idx]}: ${val} Inquiries</title>
            </circle>
            <text x="${x}" y="${height - 8}" text-anchor="middle" font-size="11" fill="#64748B" font-weight="600">${months[idx]}</text>
          `;
        }).join('')}
      </svg>
    `;
  }

});
