/**
 * DRL DWARIKA REAL ESTATE LLC — HIGH-PERFORMANCE STANDALONE DEV SERVER
 * Zero-dependency Node.js engine providing 100% full-stack functionality:
 * - Dynamic SSR routing matching PHP MVC
 * - Stateful Database engine (storage/local-database.json)
 * - Complete Admin Panel CRUD & Session Authentication
 * - Server-side property search, filtering & pagination
 * - Live lead capture & CRM status pipeline
 * - Dynamic XML Sitemap & Robots.txt
 */

const http = require('http');
const fs = require('fs');
const path = require('path');
const url = require('url');
const querystring = require('querystring');

const PORT = process.env.PORT || 4173;
const ROOT_DIR = __dirname;
const PUBLIC_DIR = path.join(ROOT_DIR, 'public');
const STORAGE_DIR = path.join(ROOT_DIR, 'storage');
const DB_FILE = path.join(STORAGE_DIR, 'local-database.json');

// Ensure storage directory
if (!fs.existsSync(STORAGE_DIR)) {
  fs.mkdirSync(STORAGE_DIR, { recursive: true });
}

// Initial Seed Data
const INITIAL_DATA = {
  settings: {
    site_name: 'DRL Dwarika Real Estate LLC',
    site_tagline: 'Opening Doors To Prosperity',
    company_phone: '+971 542202920',
    company_whatsapp: '971542202920',
    company_email: 'admin@dwarikarealestate.ae',
    company_address: 'Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira Dubai, UAE',
    rera_orn: '29482',
    dld_license: '1637547',
    stat_properties_sold: '100+',
    stat_happy_clients: '50+',
    stat_years_experience: '5+',
    social_facebook: 'https://facebook.com/dwarikarealestate',
    social_instagram: 'https://instagram.com/dwarikarealestate',
    social_linkedin: 'https://linkedin.com/company/dwarikarealestate',
    social_youtube: 'https://youtube.com/@dwarikarealestate',
  },
  locations: [
    { id: 1, name: 'Dubai Hills Estate', slug: 'dubai-hills-estate', city: 'Dubai', description: 'The green heart of Dubai, featuring an 18-hole championship golf course, Dubai Hills Mall, and luxury villas.', is_featured: 1, image_url: '/assets/images/villa-dubai-hills.jpg' },
    { id: 2, name: 'Downtown Dubai', slug: 'downtown-dubai', city: 'Dubai', description: 'The centre of now, home to the Burj Khalifa, Dubai Mall, and premier luxury high-rise residences.', is_featured: 1, image_url: '/assets/images/apartment-downtown.jpg' },
    { id: 3, name: 'Jumeirah Village Circle (JVC)', slug: 'jumeirah-village-circle', city: 'Dubai', description: 'A serene, family-friendly freehold community offering modern townhouses and investment apartments.', is_featured: 1, image_url: '/assets/images/townhouse-jvc.jpg' },
    { id: 4, name: 'Palm Jumeirah', slug: 'palm-jumeirah', city: 'Dubai', description: 'World-renowned archipelago offering beachfront villas, ultra-luxury penthouses, and private marinas.', is_featured: 1, image_url: '/assets/images/penthouse-palm.jpg' },
    { id: 5, name: 'Business Bay', slug: 'business-bay', city: 'Dubai', description: 'Dubai central commercial district along the Dubai Canal, featuring grade-A corporate offices and towers.', is_featured: 1, image_url: '/assets/images/commercial-business-bay.jpg' },
    { id: 6, name: 'Dubai Creek Harbour', slug: 'dubai-creek-harbour', city: 'Dubai', description: 'Next-generation waterfront destination boasting panoramic wildlife sanctuary and futuristic skyline views.', is_featured: 1, image_url: '/assets/images/offplan-creek.jpg' }
  ],
  property_types: [
    { id: 1, name: 'Villa', slug: 'villa', description: 'Standalone luxury private villas with landscaped gardens and private pools.', icon: 'fa-home', is_featured: 1 },
    { id: 2, name: 'Apartment', slug: 'apartment', description: 'Modern contemporary urban residences and serviced apartments.', icon: 'fa-building', is_featured: 1 },
    { id: 3, name: 'Townhouse', slug: 'townhouse', description: 'Family-oriented multi-level townhouses in master-planned communities.', icon: 'fa-door-open', is_featured: 1 },
    { id: 4, name: 'Penthouse', slug: 'penthouse', description: 'Crown skyline penthouses offering panoramic vistas and private sky pools.', icon: 'fa-crown', is_featured: 1 },
    { id: 5, name: 'Commercial', slug: 'commercial', description: 'Prime corporate offices, retail spaces, and commercial investments.', icon: 'fa-briefcase', is_featured: 1 }
  ],
  amenities: [
    { id: 1, name: 'Swimming Pool', icon: 'fa-water-ladder' },
    { id: 2, name: 'Gymnasium', icon: 'fa-dumbbell' },
    { id: 3, name: '24/7 Security & CCTV', icon: 'fa-shield-halved' },
    { id: 4, name: 'Covered Parking', icon: 'fa-square-parking' },
    { id: 5, name: 'Balcony & Terrace', icon: 'fa-sun' },
    { id: 6, name: 'Central Air Conditioning', icon: 'fa-snowflake' },
    { id: 7, name: 'Concierge Service', icon: 'fa-bell-concierge' },
    { id: 8, name: 'Children Play Area', icon: 'fa-children' },
    { id: 9, name: 'Private Garden', icon: 'fa-seedling' },
    { id: 10, name: 'High Speed Elevators', icon: 'fa-arrow-up-wide-short' }
  ],
  properties: [
    {
      id: 1,
      title: 'Modern Villa in Dubai Hills',
      slug: 'modern-villa-in-dubai-hills',
      reference_code: 'DRL-DH-401',
      description: 'Experience timeless architectural elegance in this masterfully crafted 4-bedroom contemporary villa in Dubai Hills Estate. Designed with expansive floor-to-ceiling double-glazed glass curtain walls, this residence welcomes natural daylight into open-plan living, dining, and show kitchen areas.\n\nKey features include an infinity-edge private swimming pool, integrated smart home automation, high-end Italian porcelain finishes, maid room with en-suite bath, and double private covered parking. Steps away from the Dubai Hills Golf Club, private international schools, and King’s College Hospital.',
      price: 4500000,
      currency: 'AED',
      bedrooms: 4,
      bathrooms: 5,
      area_sqft: 4850,
      listing_type: 'sale',
      property_type_id: 1,
      location_id: 1,
      address: 'Maple Avenue, Dubai Hills Estate, Dubai',
      status: 'published',
      is_featured: 1,
      featured_image: '/assets/images/villa-dubai-hills.jpg',
      rera_permit: 'DLD-749210-2025',
      completion_year: '2024',
      amenities: [1, 2, 3, 4, 5, 6, 8, 9]
    },
    {
      id: 2,
      title: 'Luxury Apartment',
      slug: 'luxury-apartment-downtown-dubai',
      reference_code: 'DRL-DT-202',
      description: 'Positioned in the vibrant epicenter of Downtown Dubai, this immaculate 2-bedroom luxury residence redefines cosmopolitan living. Offering uninterrupted panoramic views toward the Dubai Fountain and Burj Khalifa Boulevard, the property features a designer European kitchen with built-in Miele appliances, hardwood parquet flooring, and two lavish marble en-suite bathrooms.\n\nResidents enjoy direct indoor footbridge access to Dubai Mall, an Olympic-length skyline pool deck, state-of-the-art gym, valet parking, and 24/7 dedicated concierge services.',
      price: 2200000,
      currency: 'AED',
      bedrooms: 2,
      bathrooms: 2,
      area_sqft: 1420,
      listing_type: 'sale',
      property_type_id: 2,
      location_id: 2,
      address: 'Burj Crown Tower, Downtown Dubai',
      status: 'published',
      is_featured: 1,
      featured_image: '/assets/images/apartment-downtown.jpg',
      rera_permit: 'DLD-810934-2025',
      completion_year: '2023',
      amenities: [1, 2, 3, 4, 5, 6, 7, 10]
    },
    {
      id: 3,
      title: 'Spacious Townhouse',
      slug: 'spacious-townhouse-jvc',
      reference_code: 'DRL-JVC-303',
      description: 'A sanctuary for modern family living, this pristine 3-bedroom plus maid townhouse in Jumeirah Village Circle (JVC) combines space, privacy, and superior connectivity. Spread across two sunlit levels, the property features high ceilings, a generous private landscaped rear garden, and a rooftop leisure terrace perfect for evening entertainment.\n\nIncludes three spacious master suites with built-in wardrobes, fitted quartz kitchen, covered dual car parking, and immediate access to central community parks and Circle Mall.',
      price: 3100000,
      currency: 'AED',
      bedrooms: 3,
      bathrooms: 3,
      area_sqft: 2680,
      listing_type: 'sale',
      property_type_id: 3,
      location_id: 3,
      address: 'District 12, Jumeirah Village Circle, Dubai',
      status: 'published',
      is_featured: 1,
      featured_image: '/assets/images/townhouse-jvc.jpg',
      rera_permit: 'DLD-528391-2025',
      completion_year: '2024',
      amenities: [2, 3, 4, 5, 6, 8, 9]
    },
    {
      id: 4,
      title: 'Signature Beachfront Penthouse',
      slug: 'signature-beachfront-penthouse-palm-jumeirah',
      reference_code: 'DRL-PJ-501',
      description: 'An ultra-exclusive sky palace occupying the top two floors on the iconic Palm Jumeirah crescent. Featuring 360-degree views of the Arabian Gulf and Dubai Marina skyline, private infinity sky pool, private elevator foyer, Gaggenau kitchen, and private yacht berth privileges.',
      price: 12500000,
      currency: 'AED',
      bedrooms: 4,
      bathrooms: 5,
      area_sqft: 6800,
      listing_type: 'sale',
      property_type_id: 4,
      location_id: 4,
      address: 'Crescent West, Palm Jumeirah, Dubai',
      status: 'published',
      is_featured: 1,
      featured_image: '/assets/images/penthouse-palm.jpg',
      rera_permit: 'DLD-991204-2025',
      completion_year: '2024',
      amenities: [1, 2, 3, 4, 5, 6, 7, 10]
    },
    {
      id: 5,
      title: 'Grade-A Executive Office',
      slug: 'grade-a-executive-office-business-bay',
      reference_code: 'DRL-BB-105',
      description: 'Fully fitted corporate office space perched high in a trophy tower along the Dubai Canal in Business Bay. Turnkey layout with executive boardroom, 4 private manager cabins, open collaboration bullpen for 24 workstations, and dedicated server room. Ideal for international firms and family offices.',
      price: 1850000,
      currency: 'AED',
      bedrooms: 0,
      bathrooms: 2,
      area_sqft: 2150,
      listing_type: 'commercial',
      property_type_id: 5,
      location_id: 5,
      address: 'The Opus by Omniyat, Business Bay, Dubai',
      status: 'published',
      is_featured: 1,
      featured_image: '/assets/images/commercial-business-bay.jpg',
      rera_permit: 'DLD-332918-2025',
      completion_year: '2023',
      amenities: [3, 4, 6, 7, 10]
    },
    {
      id: 6,
      title: 'Waterfront Haven at Dubai Creek Harbour',
      slug: 'waterfront-haven-dubai-creek-harbour',
      reference_code: 'DRL-DCH-204',
      description: 'High-capital-growth off-plan investment located directly on the Creek Promenade. Attractive 80/20 multi-tiered payment plan with handover scheduled for Q4 2026. Panoramic views overlooking the Ras Al Khor Flamingo Sanctuary and futuristic Creek Tower.',
      price: 2800000,
      currency: 'AED',
      bedrooms: 2,
      bathrooms: 3,
      area_sqft: 1620,
      listing_type: 'off-plan',
      property_type_id: 2,
      location_id: 6,
      address: 'Creek Promenade, Dubai Creek Harbour, Dubai',
      status: 'published',
      is_featured: 1,
      featured_image: '/assets/images/offplan-creek.jpg',
      rera_permit: 'DLD-418290-2025',
      completion_year: '2026',
      amenities: [1, 2, 3, 4, 5, 6, 8, 10]
    }
  ],
  services: [
    { id: 1, title: 'Buy Home', slug: 'buy-property', short_desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.', full_desc: 'Whether you are purchasing your primary family home or a blue-chip vacation property, our seasoned advisors guide you through inventory selection, developer credentials, title deed verification, and escrow account procedures. We provide transparent access to off-market listings, pre-launch allotments, and ready resale transactions.', icon: 'fa-house' },
    { id: 2, title: 'Sell Property', slug: 'sell-property', short_desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.', full_desc: 'Selling luxury real estate in Dubai demands strategic positioning, premium architectural photography, and international buyer reach. Dwarika Real Estate LLC deploys precision digital syndication, targeted private wealth matching, and strict price protection to close transactions swiftly at premium market multiples.', icon: 'fa-hand-holding-dollar' },
    { id: 3, title: 'Consultancy', slug: 'property-consultancy', short_desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.', full_desc: 'The UAE real estate market evolves rapidly with new laws, Golden Visa regulations, and tax policies. Our experienced property consultants provide impartial, data-driven counsel on ownership structures, freehold zones, corporate acquisitions, leasehold conversions, and mortgage structuring.', icon: 'fa-user-tie' },
    { id: 4, title: 'Investment Advisory', slug: 'investment-advisory', short_desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.', full_desc: 'We help international investors and wealth managers build resilient property portfolios in Dubai generating 7% to 10% net yields. We analyze rental demand heatmaps, off-plan capital appreciation trajectories, short-term holiday home projections, and exit strategies across market cycles.', icon: 'fa-building-columns' }
  ],
  testimonials: [
    { id: 1, client_name: 'Amit Sharma', location: 'Dubai', quote: 'Dwarika Real Estate made our home buying process so easy. Their team was professional, responsive and genuinely helpful.', avatar_initial: 'A', rating: 5 },
    { id: 2, client_name: 'Priya Nair', location: 'Abu Dhabi', quote: 'Excellent service and great property options. Highly recommended for anyone looking to invest in Dubai.', avatar_initial: 'P', rating: 5 },
    { id: 3, client_name: 'Rahul Verma', location: 'Sharjah', quote: 'From property search to final paperwork, everything was handled smoothly. Truly a reliable real estate partner.', avatar_initial: 'R', rating: 5 }
  ],
  enquiries: [
    { id: 1, property_id: 1, property_title: 'Modern Villa in Dubai Hills', name: 'Farhan Al Qasimi', email: 'farhan.qasimi@emirates.ae', phone: '+971 52 984 1120', message: 'Hello, I am interested in scheduling a viewing for the 4-bedroom Modern Villa in Dubai Hills Estate this Saturday afternoon.', status: 'new', created_at: new Date().toISOString() },
    { id: 2, property_id: 2, property_title: 'Luxury Apartment', name: 'Sophie Laurent', email: 'sophie.laurent@outlook.com', phone: '+33 6 42 19 88 02', message: 'I am an investor based in Paris looking for ready 2-bed apartments in Downtown Dubai for high rental yields. Is this unit currently rented or vacant on transfer?', status: 'contacted', created_at: new Date(Date.now() - 3600000 * 5).toISOString() }
  ]
};

// Database read/write helpers
function getDB() {
  let db;
  if (!fs.existsSync(DB_FILE)) {
    db = INITIAL_DATA;
    fs.writeFileSync(DB_FILE, JSON.stringify(INITIAL_DATA, null, 2), 'utf8');
  } else {
    try {
      db = JSON.parse(fs.readFileSync(DB_FILE, 'utf8'));
    } catch (e) {
      db = INITIAL_DATA;
    }
  }
  if (!db.agents) db.agents = [];
  if (!db.founders) db.founders = [];
  return db;
}

function saveDB(data) {
  fs.writeFileSync(DB_FILE, JSON.stringify(data, null, 2), 'utf8');
}

// MIME Types
const MIME_TYPES = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'application/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.png': 'image/png',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.svg': 'image/svg+xml',
  '.webp': 'image/webp',
  '.ico': 'image/x-icon',
  '.xml': 'application/xml; charset=utf-8',
  '.txt': 'text/plain; charset=utf-8'
};

function formatPrice(num, curr = 'AED') {
  return `${curr} ${Number(num).toLocaleString()}`;
}

function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

// Template Render Helper
function renderPage(title, content, activeNav = 'home', extraMeta = {}) {
  const db = getDB();
  const settings = db.settings;
  const canonical = extraMeta.canonical || 'https://dwarikarealestate.ae';

  return `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title>${escapeHtml(title)}</title>
  <meta name="description" content="${escapeHtml(extraMeta.description || settings.site_name + ' - Luxury Real Estate in Dubai')}">
  <link rel="canonical" href="${canonical}">
  <link rel="icon" type="image/svg+xml" href="/assets/images/logo.svg">
  
  <!-- DNS Prefetch & Preconnect for High-Speed Connection Setup -->
  <!-- Preload Local WOFF2 Webfonts for Instant 0ms Paint -->
  <link rel="preload" href="/assets/fonts/playfair-display.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="/assets/fonts/plus-jakarta-sans.woff2" as="font" type="font/woff2" crossorigin>

  ${activeNav === 'home' ? `
  <!-- Preload LCP Hero Image for Instant Mobile & Desktop Painting -->
  <link rel="preload" as="image" href="/assets/images/hero-building-mobile-v3.webp" type="image/webp" media="(max-width: 768px)" fetchpriority="high">
  <link rel="preload" as="image" href="/assets/images/hero-building-v3.webp" type="image/webp" media="(min-width: 769px)" fetchpriority="high">
  ` : ''}

  <!-- Inlined Critical CSS -->
  <style id="critical-css">${fs.existsSync(path.join(PUBLIC_DIR, 'assets', 'css', 'critical.min.css')) ? fs.readFileSync(path.join(PUBLIC_DIR, 'assets', 'css', 'critical.min.css'), 'utf8') : ''}</style>
  <link rel="stylesheet" href="/assets/css/styles.min.css" media="print" onload="this.media='all'">
  <noscript><link rel="stylesheet" href="/assets/css/styles.min.css"></noscript>
  <link rel="stylesheet" href="/assets/css/chatbot.css" media="print" onload="this.media='all'">
  <noscript><link rel="stylesheet" href="/assets/css/chatbot.css"></noscript>

  <!-- Non-blocking Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" media="print" onload="this.media='all'">
  <noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  </noscript>

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "RealEstateAgent",
    "name": "DRL Dwarika Real Estate LLC",
    "legalName": "DRL Dwarika Real Estate LLC",
    "url": "https://dwarikarealestate.ae",
    "logo": "https://dwarikarealestate.ae/assets/images/logo.svg",
    "telephone": "+971542202920",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira",
      "addressLocality": "Dubai",
      "addressCountry": "AE"
    }
  }
  </script>
</head>
<body>
  
  <!-- Header matching Reference Illustration -->
  <header class="site-header" id="siteHeader">
    <div class="header-inner container">
      <a href="/" class="brand-logo" aria-label="DRL Dwarika Real Estate Home">
        <img src="/assets/images/logo.svg" alt="DRL Dwarika Real Estate LLC" width="200" height="48" class="logo-img">
      </a>

      <nav class="main-nav" aria-label="Main Navigation">
        <ul class="nav-list">
          <li class="nav-item"><a href="/" class="nav-link ${activeNav === 'home' ? 'active' : ''}">Home</a></li>
          <li class="nav-item"><a href="/about-us" class="nav-link ${activeNav === 'about' ? 'active' : ''}">About Us</a></li>
          <li class="nav-item"><a href="/founders" class="nav-link ${activeNav === 'founders' ? 'active' : ''}">Founders</a></li>
          <li class="nav-item has-dropdown">
            <a href="/properties" class="nav-link ${['properties', 'buy', 'rent', 'off-plan', 'commercial'].includes(activeNav) ? 'active' : ''}">
              Properties <i class="fa-solid fa-chevron-down nav-arrow"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a href="/properties">All Properties</a></li>
              <li><a href="/properties/buy">Properties for Sale</a></li>
              <li><a href="/properties/rent">Properties for Rent</a></li>
              <li><a href="/properties/off-plan">Off-Plan Projects</a></li>
              <li><a href="/properties/commercial">Commercial Real Estate</a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="/agents" class="nav-link ${activeNav === 'agents' ? 'active' : ''}">Agents</a></li>
          <li class="nav-item"><a href="/services" class="nav-link ${activeNav === 'services' ? 'active' : ''}">Services</a></li>
          <li class="nav-item"><a href="/contact-us" class="nav-link ${activeNav === 'contact' ? 'active' : ''}">Contact Us</a></li>
        </ul>
      </nav>

      <div class="header-actions">
        <a href="tel:${settings.company_phone.replace(/[^0-9+]/g, '')}" class="btn-call" id="btnCallUs">
          <i class="fa-solid fa-phone"></i>
          <span>Call Us</span>
        </a>
        <button type="button" class="mobile-toggle-btn" id="mobileMenuBtn" aria-label="Toggle navigation menu">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </button>
      </div>
    </div>

    <!-- Mobile Drawer -->
    <div class="mobile-drawer" id="mobileDrawer">
      <div class="mobile-drawer-header">
        <img src="/assets/images/logo.svg" alt="DRL Dwarika Real Estate" width="160" height="40">
        <button type="button" class="mobile-close-btn" id="mobileDrawerClose"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <ul class="mobile-nav-list">
        <li><a href="/" class="${activeNav === 'home' ? 'active' : ''}">Home</a></li>
        <li><a href="/about-us" class="${activeNav === 'about' ? 'active' : ''}">About Us</a></li>
        <li><a href="/founders" class="${activeNav === 'founders' ? 'active' : ''}">Founders &amp; Leadership</a></li>
        <li class="mobile-has-sub">
          <a href="/properties">Properties</a>
          <ul class="mobile-sub-menu">
            <li><a href="/properties/buy">Properties for Sale</a></li>
            <li><a href="/properties/rent">Properties for Rent</a></li>
            <li><a href="/properties/off-plan">Off-Plan Projects</a></li>
            <li><a href="/properties/commercial">Commercial</a></li>
          </ul>
        </li>
        <li><a href="/agents" class="${activeNav === 'agents' ? 'active' : ''}">Our Agents</a></li>
        <li><a href="/services" class="${activeNav === 'services' ? 'active' : ''}">Services</a></li>
        <li><a href="/testimonials" class="${activeNav === 'testimonials' ? 'active' : ''}">Testimonials</a></li>
        <li><a href="/contact-us" class="${activeNav === 'contact' ? 'active' : ''}">Contact Us</a></li>
      </ul>
      <div class="mobile-drawer-footer">
        <a href="tel:${settings.company_phone.replace(/[^0-9+]/g, '')}" class="btn-call full-width">
          <i class="fa-solid fa-phone"></i> Call Us
        </a>
      </div>
    </div>
    <div class="mobile-backdrop" id="mobileBackdrop"></div>
  </header>

  <main id="mainContent">
    ${content}
  </main>

  <!-- Pre-Footer CTA Banner matching Reference Design -->
  <section class="pre-footer-cta">
    <div class="container pre-footer-container">
      <div class="pre-footer-content">
        <h2 class="pre-footer-title">Ready to Find Your Dream Property?</h2>
        <p class="pre-footer-subtitle">Let’s make your real estate goals a reality. Get in touch with our experts today!</p>
      </div>
      <div class="pre-footer-action">
        <a href="/contact-us" class="btn-cta-white" id="btnPreFooterContact">
          <span>Contact Us</span>
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- Footer matching Reference Design -->
  <footer class="site-footer">
    <div class="footer-top container">
      <div class="footer-grid">
        <div class="footer-col footer-brand-col">
          <a href="/" class="footer-logo-link">
            <img src="/assets/images/logo-white.svg" alt="DRL Dwarika Real Estate LLC" width="180" height="60" class="footer-logo-img">
          </a>
          <p class="footer-tagline">
            Opening Doors To Prosperity — Your trusted real estate brokerage partner in Dubai, guiding you through premium residential and commercial investments with complete transparency.
          </p>
        </div>

        <div class="footer-col">
          <h4 class="footer-title">Quick Links</h4>
          <ul class="footer-links">
            <li><a href="/">Home</a></li>
            <li><a href="/about-us">About Us</a></li>
            <li><a href="/founders">Founders &amp; Leadership</a></li>
            <li><a href="/agents">Our Agents</a></li>
            <li><a href="/properties">Properties</a></li>
            <li><a href="/services">Services</a></li>
            <li><a href="/testimonials">Testimonials</a></li>
            <li><a href="/contact-us">Contact Us</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4 class="footer-title">Our Services</h4>
          <ul class="footer-links">
            <li><a href="/services/buy-property">Buy Home</a></li>
            <li><a href="/services/sell-property">Sell Property</a></li>
            <li><a href="/services/property-consultancy">Consultancy</a></li>
            <li><a href="/services/investment-advisory">Investment Advisory</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4 class="footer-title">Get In Touch</h4>
          <ul class="footer-contact-list">
            <li><i class="fa-solid fa-phone"></i> <a href="tel:${settings.company_phone.replace(/[^0-9+]/g, '')}">${escapeHtml(settings.company_phone)}</a></li>
            <li><i class="fa-solid fa-envelope"></i> <a href="mailto:${escapeHtml(settings.company_email)}">${escapeHtml(settings.company_email)}</a></li>
            <li><i class="fa-solid fa-location-dot"></i> <span>${escapeHtml(settings.company_address)}</span></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container footer-bottom-inner">
        <p class="copyright-text">&copy; ${new Date().getFullYear()} Dwarika Real Estate LLC. All rights reserved.</p>
        <div class="footer-social-icons">
          <a href="${settings.social_facebook}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="${settings.social_instagram}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="${settings.social_linkedin}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
          <a href="${settings.social_youtube}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Core JavaScript (Minified & Deferred) -->
  <script src="/assets/js/app.min.js" defer></script>
  <!-- Noor AI Luxury Property Concierge Script -->
  <script src="/assets/js/chatbot.js" defer></script>
</body>
</html>`;
}

// Render Admin Page Wrapper
function renderAdmin(title, content, activeNav = 'dashboard') {
  return `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>${escapeHtml(title)} | DRL Dwarika Admin</title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/logo.svg">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body">
  <div class="admin-layout">
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="sidebar-brand">
        <a href="/admin/dashboard" class="brand-link">
          <img src="/assets/images/logo-white.svg" alt="DRL Dwarika" width="140" height="48">
        </a>
      </div>
      <nav class="sidebar-nav">
        <div class="nav-group-title">MAIN</div>
        <a href="/admin/dashboard" class="nav-item ${activeNav === 'dashboard' ? 'active' : ''}">
          <i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span>
        </a>
        <div class="nav-group-title">REAL ESTATE</div>
        <a href="/admin/properties" class="nav-item ${activeNav === 'properties' ? 'active' : ''}">
          <i class="fa-solid fa-building"></i> <span>Properties</span>
        </a>
        <a href="/admin/leads" class="nav-item ${activeNav === 'leads' ? 'active' : ''}">
          <i class="fa-solid fa-user-tag"></i> <span>Inquiries / Leads</span>
        </a>
        <div class="nav-group-title">TEAM &amp; LEADERSHIP</div>
        <a href="/admin/agents" class="nav-item ${activeNav === 'agents' ? 'active' : ''}">
          <i class="fa-solid fa-users"></i> <span>Agents Management</span>
        </a>
        <a href="/admin/founders" class="nav-item ${activeNav === 'founders' ? 'active' : ''}">
          <i class="fa-solid fa-landmark"></i> <span>Founders &amp; Leadership</span>
        </a>
        <div class="nav-group-title">TAXONOMY &amp; CONTENT</div>
        <a href="/admin/services" class="nav-item ${activeNav === 'services' ? 'active' : ''}">
          <i class="fa-solid fa-briefcase"></i> <span>Services</span>
        </a>
        <a href="/admin/testimonials" class="nav-item ${activeNav === 'testimonials' ? 'active' : ''}">
          <i class="fa-solid fa-comment-dots"></i> <span>Testimonials</span>
        </a>
        <a href="/admin/locations" class="nav-item ${activeNav === 'locations' ? 'active' : ''}">
          <i class="fa-solid fa-location-dot"></i> <span>Locations</span>
        </a>
        <a href="/admin/blogs" class="nav-item ${activeNav === 'blogs' ? 'active' : ''}">
          <i class="fa-solid fa-newspaper"></i> <span>Market Blogs &amp; Guides</span>
        </a>
        <div class="nav-group-title">SYSTEM &amp; GROWTH</div>
        <a href="/admin/tools" class="nav-item ${activeNav === 'tools' ? 'active' : ''}">
          <i class="fa-solid fa-calculator"></i> <span>Tools &amp; Calculators</span>
        </a>
        <a href="/admin/seo" class="nav-item ${activeNav === 'seo' ? 'active' : ''}">
          <i class="fa-solid fa-magnifying-glass-chart"></i> <span>SEO Management</span>
        </a>
        <a href="/admin/settings" class="nav-item ${activeNav === 'settings' ? 'active' : ''}">
          <i class="fa-solid fa-sliders"></i> <span>Site Settings</span>
        </a>
      </nav>
      <div class="sidebar-footer">
        <a href="/" target="_blank" class="footer-btn view-site"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Website</a>
        <a href="/admin/logout" class="footer-btn logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out</a>
      </div>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <button type="button" class="sidebar-toggle-btn" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
        <div class="topbar-search">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" placeholder="Search properties or leads...">
        </div>
        <div class="topbar-user">
          <div class="user-avatar">A</div>
          <div class="user-meta">
            <span class="user-name">Dwarika Admin</span>
            <span class="user-role">Super Admin</span>
          </div>
        </div>
      </header>

      <div class="admin-content-wrap">
        ${content}
      </div>
    </div>
  </div>
  <script src="/assets/js/admin.js"></script>
</body>
</html>`;
}

// HTTP Server
const server = http.createServer((req, res) => {
  const parsedUrl = url.parse(req.url, true);
  const pathname = parsedUrl.pathname.replace(/\/+$/, '') || '/';
  const query = parsedUrl.query;

  // 1. Static Asset Serving
  if (pathname.startsWith('/assets/')) {
    const filePath = path.join(PUBLIC_DIR, pathname);
    if (fs.existsSync(filePath) && fs.statSync(filePath).isFile()) {
      const ext = path.extname(filePath).toLowerCase();
      const mime = MIME_TYPES[ext] || 'application/octet-stream';
      res.writeHead(200, { 'Content-Type': mime, 'Cache-Control': 'no-cache, must-revalidate' });
      return fs.createReadStream(filePath).pipe(res);
    }
  }

  // 2. Robots.txt & Sitemap.xml
  if (pathname === '/robots.txt') {
    res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
    return res.end(`User-agent: *\nDisallow: /admin/\nDisallow: /admin\nAllow: /\n\nSitemap: http://localhost:${PORT}/sitemap.xml\n`);
  }

  if (pathname === '/sitemap.xml') {
    const db = getDB();
    const baseUrl = `http://localhost:${PORT}`;
    let xml = `<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n`;
    const staticRoutes = ['/', '/about-us', '/founders', '/agents', '/properties', '/properties/buy', '/properties/rent', '/properties/off-plan', '/properties/commercial', '/services', '/testimonials', '/contact-us'];
    staticRoutes.forEach(r => {
      xml += `  <url><loc>${baseUrl}${r}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>\n`;
    });
    (db.agents || []).filter(a => a.status === 'active').forEach(a => {
      xml += `  <url><loc>${baseUrl}/agents/${a.slug}</loc><changefreq>weekly</changefreq><priority>0.85</priority></url>\n`;
    });
    db.properties.filter(p => p.status === 'published').forEach(p => {
      xml += `  <url><loc>${baseUrl}/property/${p.slug}</loc><changefreq>daily</changefreq><priority>0.9</priority></url>\n`;
    });
    db.locations.forEach(l => {
      xml += `  <url><loc>${baseUrl}/locations/${l.slug}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>\n`;
    });
    db.services.forEach(s => {
      xml += `  <url><loc>${baseUrl}/services/${s.slug}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>\n`;
    });
    xml += `</urlset>`;
    res.writeHead(200, { 'Content-Type': 'application/xml; charset=utf-8' });
    return res.end(xml);
  }

  // 2.5 Live AI Concierge Knowledge Base API (Real-Time Synchronized)
  if (pathname === '/api/chatbot-knowledge') {
    const db = getDB();
    const publishedProps = (db.properties || []).filter(p => p.status === 'published').map(p => {
      const loc = (db.locations || []).find(l => l.id == p.location_id) || {};
      const type = (db.property_types || []).find(t => t.id == p.property_type_id) || {};
      return {
        id: p.id,
        title: p.title,
        slug: p.slug,
        reference_code: p.reference_code,
        price: p.price,
        priceFormatted: `${p.currency || 'AED'} ${Number(p.price).toLocaleString()}`,
        currency: p.currency || 'AED',
        bedrooms: p.bedrooms,
        bathrooms: p.bathrooms,
        area_sqft: p.area_sqft,
        listing_type: p.listing_type,
        category: (type.slug || 'residential').toLowerCase(),
        typeName: type.name || 'Property',
        location: loc.name || 'Dubai',
        locationSlug: loc.slug || 'dubai',
        address: p.address,
        featured_image: p.featured_image,
        badge: p.is_featured ? 'Featured' : (p.listing_type === 'off-plan' ? 'Off-Plan' : 'Verified'),
        rera_permit: p.rera_permit || 'DLD-VERIFIED',
        description: p.description
      };
    });

    const publishedBlogs = (db.blogs || []).filter(b => b.status === 'published').map(b => ({
      id: b.id,
      title: b.title,
      slug: b.slug,
      category: b.category || 'Market Insights',
      author: b.author || 'DRL Research Team',
      published_at: b.published_at || new Date().toISOString().split('T')[0],
      excerpt: b.excerpt || '',
      content: b.content || '',
      featured_image: b.featured_image || '/assets/images/villa-dubai-hills.jpg',
      tags: b.tags || []
    }));

    res.writeHead(200, {
      'Content-Type': 'application/json; charset=utf-8',
      'Cache-Control': 'no-cache, no-store, must-revalidate, max-age=0',
      'Pragma': 'no-cache',
      'Expires': '0'
    });
    return res.end(JSON.stringify({
      success: true,
      updated_at: new Date().toISOString(),
      properties: publishedProps,
      blogs: publishedBlogs,
      locations: db.locations || [],
      services: db.services || [],
      agents: (db.agents || []).map(a => ({
        id: a.id,
        name: a.name,
        slug: a.slug,
        designation: a.designation,
        rera_brn: a.rera_brn,
        phone: a.phone,
        email: a.email,
        languages: a.languages,
        specializations: a.specializations,
        photo_url: a.photo_url
      })),
      founders: (db.founders || []).map(f => ({
        id: f.id,
        name: f.name,
        title: f.title,
        bio: f.bio
      })),
      settings: db.settings || {}
    }));
  }

  // Helper to read POST body (supports JSON & URL-encoded)
  function parseBody(cb) {
    let body = '';
    req.on('data', chunk => body += chunk);
    req.on('end', () => {
      const ctype = req.headers['content-type'] || '';
      if (ctype.includes('application/json')) {
        try {
          return cb(JSON.parse(body));
        } catch (e) {
          return cb({});
        }
      }
      cb(querystring.parse(body));
    });
  }

  // 3. Lead Inquiry Form Submission (POST)
  if (req.method === 'POST' && pathname === '/enquiry/submit') {
    parseBody(data => {
      const db = getDB();
      const leadId = db.enquiries.length + 1;
      let propTitle = '';
      if (data.property_id) {
        const prop = db.properties.find(p => p.id == data.property_id);
        if (prop) propTitle = prop.title;
      }

      const newLead = {
        id: leadId,
        property_id: data.property_id ? Number(data.property_id) : null,
        property_title: propTitle,
        service_id: data.service_id ? Number(data.service_id) : null,
        name: data.name || 'Anonymous',
        email: data.email || '',
        phone: data.phone || '',
        subject: data.subject || 'Website Inquiry',
        message: data.message || '',
        status: 'new',
        created_at: new Date().toISOString()
      };

      db.enquiries.unshift(newLead);
      saveDB(db);

      const isAjax = req.headers['x-requested-with'] === 'XMLHttpRequest' || (req.headers['accept'] && req.headers['accept'].includes('application/json'));
      if (isAjax) {
        res.writeHead(200, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ success: true, message: 'Thank you! Your inquiry has been sent to our property team.', lead_id: leadId }));
      }
      res.writeHead(302, { 'Location': req.headers.referer || '/contact-us' });
      return res.end();
    });
    return;
  }

  // 4. Admin Authentication & Session check
  const cookies = req.headers.cookie || '';
  const isAdminLoggedIn = cookies.includes('dwarika_admin=logged_in');

  // Admin Login (GET & POST)
  if (pathname === '/admin/login') {
    if (req.method === 'POST') {
      parseBody(data => {
        if (data.email === 'admin@dwarikarealestate.ae' && data.password === 'AdminPassword2025!') {
          res.writeHead(302, {
            'Set-Cookie': 'dwarika_admin=logged_in; Path=/; HttpOnly',
            'Location': '/admin/dashboard'
          });
          return res.end();
        }
        res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
        return res.end(fs.readFileSync(path.join(ROOT_DIR, 'app/Views/admin/auth/login.php'), 'utf8')
          .replace('<?= e($error) ?>', 'Invalid email or password.')
          .replace('<?= e($csrf_token ?? \'\') ?>', 'demo-csrf'));
      });
      return;
    }
    if (isAdminLoggedIn) {
      res.writeHead(302, { 'Location': '/admin/dashboard' });
      return res.end();
    }
    const loginHtml = fs.readFileSync(path.join(ROOT_DIR, 'app/Views/admin/auth/login.php'), 'utf8')
      .replace('<?= e($error) ?>', '')
      .replace('<?= e($csrf_token ?? \'\') ?>', 'demo-csrf');
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(loginHtml);
  }

  if (pathname === '/admin/logout') {
    res.writeHead(302, {
      'Set-Cookie': 'dwarika_admin=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT',
      'Location': '/admin/login'
    });
    return res.end();
  }

  // 5. Admin Panel Endpoints
  if (pathname.startsWith('/admin')) {
    if (!isAdminLoggedIn) {
      res.writeHead(302, { 'Location': '/admin/login' });
      return res.end();
    }

    const db = getDB();

    // Admin Dashboard
    if (pathname === '/admin' || pathname === '/admin/dashboard') {
      const totalProps = db.properties.length;
      const publishedProps = db.properties.filter(p => p.status === 'published').length;
      const draftProps = db.properties.filter(p => p.status === 'draft').length;
      const soldProps = db.properties.filter(p => p.status === 'sold').length;
      const totalLeads = db.enquiries.length;
      const newLeads = db.enquiries.filter(e => e.status === 'new').length;

      const recentLeadsRows = db.enquiries.slice(0, 5).map(l => `
        <tr>
          <td><strong>${escapeHtml(l.name)}</strong></td>
          <td><a href="tel:${escapeHtml(l.phone)}" class="contact-sublink"><i class="fa-solid fa-phone"></i> ${escapeHtml(l.phone)}</a></td>
          <td>${l.property_title ? `<a href="/property/${l.property_id}" class="table-prop-link">${escapeHtml(l.property_title)}</a>` : escapeHtml(l.subject || 'Website Inquiry')}</td>
          <td><span class="status-pill status-${l.status}">${l.status.toUpperCase()}</span></td>
          <td><small>${new Date(l.created_at).toLocaleDateString()}</small></td>
        </tr>
      `).join('');

      const recentPropsRows = db.properties.slice(0, 5).map(p => `
        <tr>
          <td>
            <div class="table-prop-info">
              <img src="${p.featured_image}" alt="" class="table-prop-thumb">
              <div><strong>${escapeHtml(p.title)}</strong><br><small class="text-muted">${p.reference_code}</small></div>
            </div>
          </td>
          <td>${(db.locations.find(l => l.id == p.location_id) || {}).name || 'Dubai'}</td>
          <td><strong>${formatPrice(p.price)}</strong></td>
          <td><span class="status-pill status-${p.status}">${p.status.toUpperCase()}</span></td>
          <td>
            <div class="action-buttons-group">
              <a href="/property/${p.slug}" target="_blank" class="btn-icon" title="View"><i class="fa-solid fa-eye"></i></a>
              <a href="/admin/properties/edit/${p.id}" class="btn-icon" title="Edit"><i class="fa-solid fa-pen"></i></a>
            </div>
          </td>
        </tr>
      `).join('');

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Executive Dashboard</h1>
            <p class="page-subtitle">Welcome back, Dwarika Admin. Active listings, leads, and operational status.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/properties/create" class="btn-admin-primary"><i class="fa-solid fa-plus"></i> Add New Property</a>
          </div>
        </div>

        <div class="metrics-grid">
          <div class="metric-card"><div class="metric-icon blue"><i class="fa-solid fa-building"></i></div><div class="metric-data"><span class="metric-num">${totalProps}</span><span class="metric-label">Total Properties</span></div></div>
          <div class="metric-card"><div class="metric-icon green"><i class="fa-solid fa-circle-check"></i></div><div class="metric-data"><span class="metric-num">${publishedProps}</span><span class="metric-label">Published Active</span></div></div>
          <div class="metric-card"><div class="metric-icon orange"><i class="fa-solid fa-file-pen"></i></div><div class="metric-data"><span class="metric-num">${draftProps}</span><span class="metric-label">Draft Listings</span></div></div>
          <div class="metric-card"><div class="metric-icon purple"><i class="fa-solid fa-tags"></i></div><div class="metric-data"><span class="metric-num">${soldProps}</span><span class="metric-label">Sold / Transacted</span></div></div>
          <div class="metric-card"><div class="metric-icon teal"><i class="fa-solid fa-envelope-open-text"></i></div><div class="metric-data"><span class="metric-num">${totalLeads}</span><span class="metric-label">Total Inquiries</span></div></div>
          <div class="metric-card"><div class="metric-icon red"><i class="fa-solid fa-bell"></i></div><div class="metric-data"><span class="metric-num">${newLeads}</span><span class="metric-label">New / Pending Leads</span></div></div>
        </div>

        <div class="dashboard-tables-grid">
          <div class="dash-card">
            <div class="dash-card-header">
              <div class="card-title-wrap"><i class="fa-solid fa-user-tag text-primary"></i> <h3>Recent Customer Inquiries</h3></div>
              <a href="/admin/leads" class="dash-card-link">View All Leads <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
              <table class="admin-table">
                <thead><tr><th>Name</th><th>Phone</th><th>Property</th><th>Status</th><th>Received</th></tr></thead>
                <tbody>${recentLeadsRows}</tbody>
              </table>
            </div>
          </div>

          <div class="dash-card">
            <div class="dash-card-header">
              <div class="card-title-wrap"><i class="fa-solid fa-building text-primary"></i> <h3>Recent Listings</h3></div>
              <a href="/admin/properties" class="dash-card-link">Manage All <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
              <table class="admin-table">
                <thead><tr><th>Property</th><th>Location</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>${recentPropsRows}</tbody>
              </table>
            </div>
          </div>
        </div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Dashboard', content, 'dashboard'));
    }

    // Admin Properties List
    if (pathname === '/admin/properties') {
      const statusFilter = query.status || '';
      let list = db.properties;
      if (statusFilter) list = list.filter(p => p.status === statusFilter);

      const rows = list.map(p => {
        const loc = db.locations.find(l => l.id == p.location_id) || {};
        const type = db.property_types.find(t => t.id == p.property_type_id) || {};
        const agent = (db.agents || []).find(a => a.id == p.agent_id);
        return `
          <tr>
            <td>
              <div class="table-prop-info">
                <img src="${p.featured_image}" alt="" class="table-prop-thumb">
                <div><strong>${escapeHtml(p.title)}</strong><br><small class="text-muted">${p.reference_code}</small></div>
              </div>
            </td>
            <td>${escapeHtml(loc.name || 'Dubai')}</td>
            <td>${escapeHtml(type.name || 'Residential')}</td>
            <td><strong>${formatPrice(p.price)}</strong></td>
            <td>${agent ? `<span class="agent-tag"><i class="fa-solid fa-user-tie"></i> ${escapeHtml(agent.name)}</span>` : '<span class="text-muted">—</span>'}</td>
            <td><span class="status-pill status-${p.status}">${p.status.toUpperCase()}</span></td>
            <td>${p.is_featured ? '<span class="badge-featured"><i class="fa-solid fa-star"></i> Featured</span>' : '—'}</td>
            <td>
              <div class="action-buttons-group">
                <a href="/property/${p.slug}" target="_blank" class="btn-icon" title="View"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                <a href="/admin/properties/edit/${p.id}" class="btn-icon" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                <form action="/admin/properties/delete/${p.id}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this listing?');">
                  <button type="submit" class="btn-icon delete-btn"><i class="fa-solid fa-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
        `;
      }).join('');

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Property Catalog (${list.length})</h1>
            <p class="page-subtitle">Manage all published, draft, and transacted properties.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/properties/create" class="btn-admin-primary"><i class="fa-solid fa-plus"></i> Add New Property</a>
          </div>
        </div>

        <div class="status-filter-tabs">
          <a href="/admin/properties" class="tab-btn ${!statusFilter ? 'active' : ''}">All Listings</a>
          <a href="/admin/properties?status=published" class="tab-btn ${statusFilter === 'published' ? 'active' : ''}">Published</a>
          <a href="/admin/properties?status=draft" class="tab-btn ${statusFilter === 'draft' ? 'active' : ''}">Drafts</a>
          <a href="/admin/properties?status=sold" class="tab-btn ${statusFilter === 'sold' ? 'active' : ''}">Sold / Rented</a>
        </div>

        <div class="dash-card">
          <div class="table-responsive">
            <table class="admin-table">
              <thead><tr><th>Property / Ref</th><th>Location</th><th>Type</th><th>Price</th><th>Assigned Agent</th><th>Status</th><th>Featured</th><th>Actions</th></tr></thead>
              <tbody>${rows || '<tr><td colspan="8" class="text-center text-muted">No properties found.</td></tr>'}</tbody>
            </table>
          </div>
        </div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Properties', content, 'properties'));
    }

    // Admin Add Property
    if (pathname === '/admin/properties/create') {
      if (req.method === 'POST') {
        parseBody(data => {
          const newId = db.properties.length > 0 ? Math.max(...db.properties.map(p => p.id)) + 1 : 1;
          const slug = data.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '') + '-' + Math.floor(Math.random() * 900 + 100);
          const newProp = {
            id: newId,
            title: data.title,
            slug: slug,
            reference_code: 'DRL-DXB-' + Math.floor(Math.random() * 900 + 100),
            description: data.description || '',
            price: Number(data.price) || 0,
            currency: 'AED',
            bedrooms: Number(data.bedrooms) || 0,
            bathrooms: Number(data.bathrooms) || 0,
            area_sqft: Number(data.area_sqft) || 0,
            listing_type: data.listing_type || 'sale',
            property_type_id: Number(data.property_type_id) || 1,
            location_id: Number(data.location_id) || 1,
            agent_id: data.agent_id ? Number(data.agent_id) : null,
            address: data.address || '',
            status: data.status || 'published',
            is_featured: data.is_featured ? 1 : 0,
            featured_image: data.featured_image || '/assets/images/villa-dubai-hills.jpg',
            rera_permit: data.rera_permit || '',
            amenities: [1, 2, 3, 4]
          };
          db.properties.unshift(newProp);
          saveDB(db);
          res.writeHead(302, { 'Location': '/admin/properties' });
          return res.end();
        });
        return;
      }

      const locOptions = db.locations.map(l => `<option value="${l.id}">${escapeHtml(l.name)}</option>`).join('');
      const typeOptions = db.property_types.map(t => `<option value="${t.id}">${escapeHtml(t.name)}</option>`).join('');
      const agentOptions = (db.agents || []).map(a => `<option value="${a.id}">${escapeHtml(a.name)} (${escapeHtml(a.designation)})</option>`).join('');

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Add New Property Listing</h1>
            <p class="page-subtitle">Publish a verified real estate listing to the DRL Dwarika platform.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/properties" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back</a>
          </div>
        </div>

        <form action="/admin/properties/create" method="POST" class="admin-form-card">
          <div class="form-section-title">1. Basic Information</div>
          <div class="form-group"><label>Property Title *</label><input type="text" name="title" class="form-input" required placeholder="e.g. Modern Villa in Dubai Hills"></div>
          <div class="form-row">
            <div class="form-group third-width"><label>Price (AED) *</label><input type="number" name="price" class="form-input" required value="4500000"></div>
            <div class="form-group third-width"><label>Location *</label><select name="location_id" class="form-select">${locOptions}</select></div>
            <div class="form-group third-width"><label>Property Type *</label><select name="property_type_id" class="form-select">${typeOptions}</select></div>
          </div>
          <div class="form-row">
            <div class="form-group third-width"><label>Assigned Agent Specialist</label><select name="agent_id" class="form-select"><option value="">-- No Agent Assigned --</option>${agentOptions}</select></div>
            <div class="form-group third-width"><label>Listing Category</label><select name="listing_type" class="form-select"><option value="sale">For Sale</option><option value="rent">For Rent</option><option value="off-plan">Off-Plan</option><option value="commercial">Commercial</option></select></div>
            <div class="form-group third-width"><label>Status</label><select name="status" class="form-select"><option value="published">Published</option><option value="draft">Draft</option><option value="sold">Sold</option></select></div>
          </div>
          <div class="form-row">
            <div class="form-group third-width"><label>Bedrooms</label><input type="number" name="bedrooms" class="form-input" value="4"></div>
            <div class="form-group third-width"><label>Bathrooms</label><input type="number" name="bathrooms" class="form-input" value="5"></div>
            <div class="form-group third-width"><label>Area (Sq. Ft.)</label><input type="number" name="area_sqft" class="form-input" value="4500"></div>
          </div>
          <div class="form-group"><label>Address / Street</label><input type="text" name="address" class="form-input" placeholder="e.g. Dubai Hills Estate, Dubai"></div>
          <div class="form-section-title">2. Media &amp; RERA Permit</div>
          <div class="form-row">
            <div class="form-group half-width"><label>Featured Image URL</label><input type="text" name="featured_image" class="form-input" value="/assets/images/villa-dubai-hills.jpg"></div>
            <div class="form-group half-width"><label>RERA Permit / DLD License</label><input type="text" name="rera_permit" class="form-input" value="DLD-749210-2025"></div>
          </div>
          <div class="form-group"><label class="checkbox-label"><input type="checkbox" name="is_featured" value="1" checked> <span>Mark as <strong>Featured Property</strong> on Homepage</span></label></div>
          <div class="form-section-title">3. Description</div>
          <div class="form-group"><label>Property Description *</label><textarea name="description" rows="5" class="form-textarea" required>Luxury contemporary property offering high-end finishing, private garden and world-class community amenities.</textarea></div>
          <div class="form-actions-bar">
            <button type="submit" class="btn-admin-primary"><i class="fa-solid fa-check"></i> Save &amp; Publish</button>
            <a href="/admin/properties" class="btn-admin-outline">Cancel</a>
          </div>
        </form>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Add Property', content, 'properties'));
    }

    // Admin Edit Property
    if (pathname.startsWith('/admin/properties/edit/')) {
      const propId = Number(pathname.split('/').pop());
      const prop = db.properties.find(p => p.id === propId);
      if (!prop) {
        res.writeHead(302, { 'Location': '/admin/properties' });
        return res.end();
      }

      if (req.method === 'POST') {
        parseBody(data => {
          prop.title = data.title || prop.title;
          prop.price = Number(data.price) || prop.price;
          prop.location_id = Number(data.location_id) || prop.location_id;
          prop.property_type_id = Number(data.property_type_id) || prop.property_type_id;
          prop.agent_id = data.agent_id ? Number(data.agent_id) : null;
          prop.listing_type = data.listing_type || prop.listing_type;
          prop.status = data.status || prop.status;
          prop.bedrooms = Number(data.bedrooms) || 0;
          prop.bathrooms = Number(data.bathrooms) || 0;
          prop.area_sqft = Number(data.area_sqft) || prop.area_sqft;
          prop.address = data.address || prop.address;
          prop.featured_image = data.featured_image || prop.featured_image;
          prop.rera_permit = data.rera_permit || prop.rera_permit;
          prop.is_featured = data.is_featured ? 1 : 0;
          prop.description = data.description || prop.description;
          saveDB(db);
          res.writeHead(302, { 'Location': '/admin/properties' });
          return res.end();
        });
        return;
      }

      const locOptions = db.locations.map(l => `<option value="${l.id}" ${prop.location_id == l.id ? 'selected' : ''}>${escapeHtml(l.name)}</option>`).join('');
      const typeOptions = db.property_types.map(t => `<option value="${t.id}" ${prop.property_type_id == t.id ? 'selected' : ''}>${escapeHtml(t.name)}</option>`).join('');
      const agentOptions = (db.agents || []).map(a => `<option value="${a.id}" ${prop.agent_id == a.id ? 'selected' : ''}>${escapeHtml(a.name)} (${escapeHtml(a.designation)})</option>`).join('');

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Edit Property: ${escapeHtml(prop.title)}</h1>
            <p class="page-subtitle">Update property details, assigned agent, and listing status.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/properties" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back</a>
          </div>
        </div>

        <form action="/admin/properties/edit/${prop.id}" method="POST" class="admin-form-card">
          <div class="form-section-title">1. Basic Information</div>
          <div class="form-group"><label>Property Title *</label><input type="text" name="title" class="form-input" required value="${escapeHtml(prop.title)}"></div>
          <div class="form-row">
            <div class="form-group third-width"><label>Price (AED) *</label><input type="number" name="price" class="form-input" required value="${prop.price}"></div>
            <div class="form-group third-width"><label>Location *</label><select name="location_id" class="form-select">${locOptions}</select></div>
            <div class="form-group third-width"><label>Property Type *</label><select name="property_type_id" class="form-select">${typeOptions}</select></div>
          </div>
          <div class="form-row">
            <div class="form-group third-width"><label>Assigned Agent Specialist</label><select name="agent_id" class="form-select"><option value="">-- No Agent Assigned --</option>${agentOptions}</select></div>
            <div class="form-group third-width"><label>Listing Category</label><select name="listing_type" class="form-select"><option value="sale" ${prop.listing_type==='sale'?'selected':''}>For Sale</option><option value="rent" ${prop.listing_type==='rent'?'selected':''}>For Rent</option><option value="off-plan" ${prop.listing_type==='off-plan'?'selected':''}>Off-Plan</option><option value="commercial" ${prop.listing_type==='commercial'?'selected':''}>Commercial</option></select></div>
            <div class="form-group third-width"><label>Status</label><select name="status" class="form-select"><option value="published" ${prop.status==='published'?'selected':''}>Published</option><option value="draft" ${prop.status==='draft'?'selected':''}>Draft</option><option value="sold" ${prop.status==='sold'?'selected':''}>Sold</option></select></div>
          </div>
          <div class="form-row">
            <div class="form-group third-width"><label>Bedrooms</label><input type="number" name="bedrooms" class="form-input" value="${prop.bedrooms}"></div>
            <div class="form-group third-width"><label>Bathrooms</label><input type="number" name="bathrooms" class="form-input" value="${prop.bathrooms}"></div>
            <div class="form-group third-width"><label>Area (Sq. Ft.)</label><input type="number" name="area_sqft" class="form-input" value="${prop.area_sqft}"></div>
          </div>
          <div class="form-group"><label>Address / Street</label><input type="text" name="address" class="form-input" value="${escapeHtml(prop.address || '')}"></div>
          <div class="form-section-title">2. Media &amp; RERA Permit</div>
          <div class="form-row">
            <div class="form-group half-width"><label>Featured Image URL</label><input type="text" name="featured_image" class="form-input" value="${escapeHtml(prop.featured_image)}"></div>
            <div class="form-group half-width"><label>RERA Permit / DLD License</label><input type="text" name="rera_permit" class="form-input" value="${escapeHtml(prop.rera_permit || '')}"></div>
          </div>
          <div class="form-group"><label class="checkbox-label"><input type="checkbox" name="is_featured" value="1" ${prop.is_featured ? 'checked' : ''}> <span>Mark as <strong>Featured Property</strong> on Homepage</span></label></div>
          <div class="form-section-title">3. Description</div>
          <div class="form-group"><label>Property Description *</label><textarea name="description" rows="5" class="form-textarea" required>${escapeHtml(prop.description)}</textarea></div>
          <div class="form-actions-bar">
            <button type="submit" class="btn-admin-primary"><i class="fa-solid fa-check"></i> Update Property</button>
            <a href="/admin/properties" class="btn-admin-outline">Cancel</a>
          </div>
        </form>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Edit Property', content, 'properties'));
    }

    // Admin Delete Property
    if (pathname.startsWith('/admin/properties/delete/')) {
      const propId = Number(pathname.split('/').pop());
      db.properties = db.properties.filter(p => p.id !== propId);
      saveDB(db);
      res.writeHead(302, { 'Location': '/admin/properties' });
      return res.end();
    }

    // Admin Leads CRM
    if (pathname === '/admin/leads') {
      const statusFilter = query.status || '';
      let list = db.enquiries;
      if (statusFilter) list = list.filter(e => e.status === statusFilter);

      const rows = list.map(l => `
        <tr>
          <td>
            <strong>${escapeHtml(l.name)}</strong><br>
            <a href="tel:${escapeHtml(l.phone)}" class="contact-sublink"><i class="fa-solid fa-phone"></i> ${escapeHtml(l.phone)}</a><br>
            <small class="text-muted">${escapeHtml(l.email)}</small>
          </td>
          <td>${l.property_title ? `<a href="/property/${l.property_id}" target="_blank" class="table-prop-link">${escapeHtml(l.property_title)}</a>` : escapeHtml(l.subject || 'Website Inquiry')}</td>
          <td><div class="lead-message-preview">${escapeHtml(l.message)}</div></td>
          <td><span class="status-pill status-${l.status}">${l.status.toUpperCase()}</span></td>
          <td>
            <form action="/admin/leads/update-status/${l.id}" method="POST">
              <select name="status" class="form-select-sm" onchange="this.form.submit()">
                <option value="new" ${l.status === 'new' ? 'selected' : ''}>New</option>
                <option value="contacted" ${l.status === 'contacted' ? 'selected' : ''}>Contacted</option>
                <option value="qualified" ${l.status === 'qualified' ? 'selected' : ''}>Qualified</option>
                <option value="closed" ${l.status === 'closed' ? 'selected' : ''}>Closed</option>
              </select>
            </form>
          </td>
          <td><small class="text-muted">${new Date(l.created_at).toLocaleDateString()}</small></td>
        </tr>
      `).join('');

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Customer Inquiries &amp; Leads CRM</h1>
            <p class="page-subtitle">Manage incoming property viewings and client communication.</p>
          </div>
        </div>

        <div class="status-filter-tabs">
          <a href="/admin/leads" class="tab-btn ${!statusFilter ? 'active' : ''}">All Inquiries</a>
          <a href="/admin/leads?status=new" class="tab-btn ${statusFilter === 'new' ? 'active' : ''}">New</a>
          <a href="/admin/leads?status=contacted" class="tab-btn ${statusFilter === 'contacted' ? 'active' : ''}">Contacted</a>
          <a href="/admin/leads?status=qualified" class="tab-btn ${statusFilter === 'qualified' ? 'active' : ''}">Qualified</a>
          <a href="/admin/leads?status=closed" class="tab-btn ${statusFilter === 'closed' ? 'active' : ''}">Closed</a>
        </div>

        <div class="dash-card">
          <div class="table-responsive">
            <table class="admin-table">
              <thead><tr><th>Lead / Contact</th><th>Property</th><th>Message</th><th>Current Status</th><th>Update</th><th>Received</th></tr></thead>
              <tbody>${rows || '<tr><td colspan="6" class="text-center text-muted">No inquiries found.</td></tr>'}</tbody>
            </table>
          </div>
        </div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Inquiries CRM', content, 'leads'));
    }

    if (pathname.startsWith('/admin/leads/update-status/')) {
      const leadId = Number(pathname.split('/').pop());
      parseBody(data => {
        const lead = db.enquiries.find(l => l.id === leadId);
        if (lead && data.status) {
          lead.status = data.status;
          saveDB(db);
        }
        if (req.headers['x-requested-with'] === 'XMLHttpRequest' || (req.headers.accept && req.headers.accept.includes('application/json'))) {
          res.writeHead(200, { 'Content-Type': 'application/json' });
          return res.end(JSON.stringify({ success: true, lead_id: leadId, status: data.status }));
        }
        res.writeHead(302, { 'Location': '/admin/leads' });
        return res.end();
      });
      return;
    }

    // ==========================================
    // Admin Agents Management
    // ==========================================
    if (pathname === '/admin/agents') {
      const agents = db.agents || [];
      const rows = agents.map(a => `
        <tr>
          <td>
            <div class="table-prop-info">
              <img src="${a.photo_url || '/assets/images/agents/omar-farooq.jpg'}" alt="" class="table-prop-thumb" style="border-radius:50%; object-fit:cover;">
              <div>
                <strong>${escapeHtml(a.name)}</strong><br>
                <small class="text-muted">${escapeHtml(a.designation)}</small>
              </div>
            </div>
          </td>
          <td>
            <strong>BRN ${escapeHtml(a.rera_brn || '—')}</strong><br>
            <small class="text-muted">${escapeHtml(a.experience || '')}</small>
          </td>
          <td>
            <div style="display:flex; flex-wrap:wrap; gap:4px;">
              ${(a.specializations || []).map(s => `<span class="spec-pill" style="font-size:0.75rem; padding:2px 8px;">${escapeHtml(s)}</span>`).join('')}
            </div>
          </td>
          <td>${(a.languages || []).join(', ')}</td>
          <td><span class="status-pill status-${a.status === 'active' ? 'published' : 'draft'}">${(a.status || 'active').toUpperCase()}</span></td>
          <td>
            <div class="action-buttons-group">
              <a href="/agents/${a.slug}" target="_blank" class="btn-icon" title="View Public Profile"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
              <a href="/admin/agents/edit/${a.id}" class="btn-icon" title="Edit Agent"><i class="fa-solid fa-pen-to-square"></i></a>
              <form action="/admin/agents/delete/${a.id}" method="POST" style="display:inline;" onsubmit="return confirm('Remove agent profile?');">
                <button type="submit" class="btn-icon delete-btn" title="Delete Agent"><i class="fa-solid fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
      `).join('');

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Real Estate Agents &amp; Advisors (${agents.length})</h1>
            <p class="page-subtitle">Manage licensed RERA consultants, areas of expertise, and contact details.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/agents/create" class="btn-admin-primary"><i class="fa-solid fa-user-plus"></i> Add New Agent</a>
          </div>
        </div>

        <div class="dash-card">
          <div class="table-responsive">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Agent &amp; Designation</th>
                  <th>RERA BRN &amp; Experience</th>
                  <th>Specializations</th>
                  <th>Languages</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                ${rows || '<tr><td colspan="6" class="text-center text-muted">No agents registered yet.</td></tr>'}
              </tbody>
            </table>
          </div>
        </div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Agents Management', content, 'agents'));
    }

    // Admin Create Agent
    if (pathname === '/admin/agents/create') {
      if (req.method === 'POST') {
        parseBody(data => {
          const agents = db.agents || [];
          const newId = agents.length > 0 ? Math.max(...agents.map(a => a.id)) + 1 : 1;
          const slug = (data.slug || data.name).toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
          const newAgent = {
            id: newId,
            name: data.name || '',
            slug: slug,
            designation: data.designation || 'Property Consultant',
            rera_brn: data.rera_brn || '',
            experience: data.experience || '5+ Years Experience',
            photo_url: data.photo_url || '/assets/images/agents/omar-farooq.jpg',
            email: data.email || '',
            phone: data.phone || '',
            whatsapp: (data.whatsapp || '').replace(/[^0-9]/g, ''),
            short_bio: data.short_bio || '',
            full_bio: data.full_bio || '',
            languages: (data.languages || 'English').split(',').map(s => s.trim()).filter(Boolean),
            specializations: (data.specializations || 'residential').split(',').map(s => s.trim().toLowerCase()).filter(Boolean),
            locations: (data.locations || 'Dubai').split(',').map(s => s.trim()).filter(Boolean),
            testimonial_quote: data.testimonial_quote || '',
            testimonial_client: data.testimonial_client || '',
            status: data.status || 'active',
            sort_order: Number(data.sort_order) || agents.length + 1
          };
          db.agents.push(newAgent);
          saveDB(db);
          res.writeHead(302, { 'Location': '/admin/agents' });
          return res.end();
        });
        return;
      }

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Add New Property Consultant</h1>
            <p class="page-subtitle">Publish a licensed agent profile to the public website.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/agents" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back to Agents</a>
          </div>
        </div>

        <form action="/admin/agents/create" method="POST" class="admin-form-card">
          <div class="form-section-title">1. Personal &amp; Professional Identity</div>
          <div class="form-row">
            <div class="form-group half-width"><label>Full Name *</label><input type="text" name="name" class="form-input" required placeholder="e.g. Tariq Mansoor"></div>
            <div class="form-group half-width"><label>Official Designation *</label><input type="text" name="designation" class="form-input" required placeholder="e.g. Senior Luxury Property Consultant"></div>
          </div>
          <div class="form-row">
            <div class="form-group third-width"><label>RERA BRN Number *</label><input type="text" name="rera_brn" class="form-input" required placeholder="e.g. 54321"></div>
            <div class="form-group third-width"><label>Professional Experience</label><input type="text" name="experience" class="form-input" placeholder="e.g. 8+ Years Experience"></div>
            <div class="form-group third-width"><label>Status</label><select name="status" class="form-select"><option value="active">Active (Visible)</option><option value="inactive">Inactive</option></select></div>
          </div>

          <div class="form-section-title">2. Contact Channels &amp; Portrait</div>
          <div class="form-row">
            <div class="form-group third-width"><label>Official Email *</label><input type="email" name="email" class="form-input" required placeholder="agent@dwarikarealestate.ae"></div>
            <div class="form-group third-width"><label>Phone Number *</label><input type="text" name="phone" class="form-input" required placeholder="+971 542202920"></div>
            <div class="form-group third-width"><label>WhatsApp (digits only)</label><input type="text" name="whatsapp" class="form-input" placeholder="971542202920"></div>
          </div>
          <div class="form-group"><label>Portrait Photo URL</label><input type="text" name="photo_url" class="form-input" placeholder="/assets/images/agents/omar-farooq.jpg"></div>

          <div class="form-section-title">3. Skills, Languages &amp; Focus Communities</div>
          <div class="form-row">
            <div class="form-group third-width"><label>Specializations (comma-separated)</label><input type="text" name="specializations" class="form-input" placeholder="luxury, residential, off-plan"></div>
            <div class="form-group third-width"><label>Languages Spoken (comma-separated)</label><input type="text" name="languages" class="form-input" placeholder="English, Arabic, Russian"></div>
            <div class="form-group third-width"><label>Communities (comma-separated)</label><input type="text" name="locations" class="form-input" placeholder="Dubai Hills Estate, Downtown Dubai"></div>
          </div>

          <div class="form-section-title">4. Biographies &amp; Testimonial</div>
          <div class="form-group"><label>Short Summary Bio (Card preview) *</label><textarea name="short_bio" rows="2" class="form-textarea" required placeholder="Brief 2-3 line summary for directory listing..."></textarea></div>
          <div class="form-group"><label>Full Professional Biography *</label><textarea name="full_bio" rows="6" class="form-textarea" required placeholder="Detailed career overview, transaction track record, advisory background..."></textarea></div>
          <div class="form-row">
            <div class="form-group half-width"><label>Client Testimonial Quote (Optional)</label><textarea name="testimonial_quote" rows="2" class="form-textarea" placeholder="Authentic client testimonial text..."></textarea></div>
            <div class="form-group half-width"><label>Testimonial Client Name &amp; Title</label><input type="text" name="testimonial_client" class="form-input" placeholder="e.g. Amit Sharma, Homeowner"></div>
          </div>

          <div class="form-actions-bar">
            <button type="submit" class="btn-admin-primary"><i class="fa-solid fa-check"></i> Save Agent Profile</button>
            <a href="/admin/agents" class="btn-admin-outline">Cancel</a>
          </div>
        </form>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Add Agent', content, 'agents'));
    }

    // Admin Edit Agent
    if (pathname.startsWith('/admin/agents/edit/')) {
      const agentId = Number(pathname.split('/').pop());
      const agent = (db.agents || []).find(a => a.id === agentId);
      if (!agent) {
        res.writeHead(302, { 'Location': '/admin/agents' });
        return res.end();
      }

      if (req.method === 'POST') {
        parseBody(data => {
          agent.name = data.name || agent.name;
          agent.designation = data.designation || agent.designation;
          agent.rera_brn = data.rera_brn || agent.rera_brn;
          agent.experience = data.experience || agent.experience;
          agent.photo_url = data.photo_url || agent.photo_url;
          agent.email = data.email || agent.email;
          agent.phone = data.phone || agent.phone;
          agent.whatsapp = (data.whatsapp || agent.whatsapp || '').replace(/[^0-9]/g, '');
          agent.short_bio = data.short_bio || agent.short_bio;
          agent.full_bio = data.full_bio || agent.full_bio;
          agent.languages = (data.languages || '').split(',').map(s => s.trim()).filter(Boolean);
          agent.specializations = (data.specializations || '').split(',').map(s => s.trim().toLowerCase()).filter(Boolean);
          agent.locations = (data.locations || '').split(',').map(s => s.trim()).filter(Boolean);
          agent.testimonial_quote = data.testimonial_quote || '';
          agent.testimonial_client = data.testimonial_client || '';
          agent.status = data.status || agent.status;
          agent.sort_order = Number(data.sort_order) || agent.sort_order || 1;
          saveDB(db);
          res.writeHead(302, { 'Location': '/admin/agents' });
          return res.end();
        });
        return;
      }

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Edit Agent: ${escapeHtml(agent.name)}</h1>
            <p class="page-subtitle">Update credentials, biography, specializations, and contact options.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/agents" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back to Agents</a>
          </div>
        </div>

        <form action="/admin/agents/edit/${agent.id}" method="POST" class="admin-form-card">
          <div class="form-section-title">1. Personal &amp; Professional Identity</div>
          <div class="form-row">
            <div class="form-group half-width"><label>Full Name *</label><input type="text" name="name" class="form-input" required value="${escapeHtml(agent.name)}"></div>
            <div class="form-group half-width"><label>Official Designation *</label><input type="text" name="designation" class="form-input" required value="${escapeHtml(agent.designation)}"></div>
          </div>
          <div class="form-row">
            <div class="form-group third-width"><label>RERA BRN Number *</label><input type="text" name="rera_brn" class="form-input" required value="${escapeHtml(agent.rera_brn || '')}"></div>
            <div class="form-group third-width"><label>Professional Experience</label><input type="text" name="experience" class="form-input" value="${escapeHtml(agent.experience || '')}"></div>
            <div class="form-group third-width"><label>Status</label><select name="status" class="form-select"><option value="active" ${agent.status==='active'?'selected':''}>Active (Visible)</option><option value="inactive" ${agent.status==='inactive'?'selected':''}>Inactive</option></select></div>
          </div>

          <div class="form-section-title">2. Contact Channels &amp; Portrait</div>
          <div class="form-row">
            <div class="form-group third-width"><label>Official Email *</label><input type="email" name="email" class="form-input" required value="${escapeHtml(agent.email || '')}"></div>
            <div class="form-group third-width"><label>Phone Number *</label><input type="text" name="phone" class="form-input" required value="${escapeHtml(agent.phone || '')}"></div>
            <div class="form-group third-width"><label>WhatsApp (digits only)</label><input type="text" name="whatsapp" class="form-input" value="${escapeHtml(agent.whatsapp || '')}"></div>
          </div>
          <div class="form-group"><label>Portrait Photo URL</label><input type="text" name="photo_url" class="form-input" value="${escapeHtml(agent.photo_url || '')}"></div>

          <div class="form-section-title">3. Skills, Languages &amp; Focus Communities</div>
          <div class="form-row">
            <div class="form-group third-width"><label>Specializations (comma-separated)</label><input type="text" name="specializations" class="form-input" value="${escapeHtml((agent.specializations || []).join(', '))}"></div>
            <div class="form-group third-width"><label>Languages Spoken (comma-separated)</label><input type="text" name="languages" class="form-input" value="${escapeHtml((agent.languages || []).join(', '))}"></div>
            <div class="form-group third-width"><label>Communities (comma-separated)</label><input type="text" name="locations" class="form-input" value="${escapeHtml((agent.locations || []).join(', '))}"></div>
          </div>

          <div class="form-section-title">4. Biographies &amp; Testimonial</div>
          <div class="form-group"><label>Short Summary Bio (Card preview) *</label><textarea name="short_bio" rows="2" class="form-textarea" required>${escapeHtml(agent.short_bio || '')}</textarea></div>
          <div class="form-group"><label>Full Professional Biography *</label><textarea name="full_bio" rows="6" class="form-textarea" required>${escapeHtml(agent.full_bio || '')}</textarea></div>
          <div class="form-row">
            <div class="form-group half-width"><label>Client Testimonial Quote (Optional)</label><textarea name="testimonial_quote" rows="2" class="form-textarea">${escapeHtml(agent.testimonial_quote || '')}</textarea></div>
            <div class="form-group half-width"><label>Testimonial Client Name &amp; Title</label><input type="text" name="testimonial_client" class="form-input" value="${escapeHtml(agent.testimonial_client || '')}"></div>
          </div>

          <div class="form-actions-bar">
            <button type="submit" class="btn-admin-primary"><i class="fa-solid fa-check"></i> Update Agent Profile</button>
            <a href="/admin/agents" class="btn-admin-outline">Cancel</a>
          </div>
        </form>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Edit Agent', content, 'agents'));
    }

    // Admin Delete Agent
    if (pathname.startsWith('/admin/agents/delete/')) {
      const agentId = Number(pathname.split('/').pop());
      db.agents = (db.agents || []).filter(a => a.id !== agentId);
      saveDB(db);
      res.writeHead(302, { 'Location': '/admin/agents' });
      return res.end();
    }

    // ==========================================
    // Admin Founders & Leadership Management
    // ==========================================
    if (pathname === '/admin/founders') {
      const founders = db.founders || [];
      const rows = founders.map(f => `
        <tr>
          <td>
            <div class="table-prop-info">
              ${f.photo_url ? `<img src="${f.photo_url}" alt="" class="table-prop-thumb" style="border-radius:8px;">` : `<div style="width:48px; height:48px; border-radius:8px; background:#0F1E2E; color:#C5A880; display:flex; align-items:center; justify-content:center; font-size:1.2rem;"><i class="fa-solid fa-user-tie"></i></div>`}
              <div>
                <strong>${escapeHtml(f.name)}</strong><br>
                <small class="text-muted">${escapeHtml(f.designation)}</small>
              </div>
            </div>
          </td>
          <td>
            <span class="status-pill status-${f.status === 'published' ? 'published' : 'draft'}">
              ${(f.status || 'draft').toUpperCase()}
            </span>
          </td>
          <td>
            ${f.missing_fields ? `<span class="badge-featured" style="background:#FFF3CD; color:#856404; border:1px solid #FFEEBA; font-size:0.75rem;"><i class="fa-solid fa-triangle-exclamation"></i> ${escapeHtml(f.missing_fields)}</span>` : '<span class="status-pill status-published">Profile Complete</span>'}
          </td>
          <td><small>${escapeHtml(f.leadership_areas || 'Corporate Governance')}</small></td>
          <td>
            <div class="action-buttons-group">
              <a href="/founders" target="_blank" class="btn-icon" title="View Public Founders Page"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
              <a href="/admin/founders/edit/${f.id}" class="btn-icon" title="Edit Profile Details"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
            </div>
          </td>
        </tr>
      `).join('');

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Founders &amp; Corporate Leadership</h1>
            <p class="page-subtitle">Manage executive leadership profiles, vision pillars, and administrative verification statuses.</p>
          </div>
          <div class="header-actions">
            <a href="/founders" target="_blank" class="btn-admin-outline"><i class="fa-solid fa-eye"></i> View Founders Page</a>
          </div>
        </div>

        <div style="background:#EFF6FF; border:1px solid #BFDBFE; border-left:4px solid #1689CC; border-radius:10px; padding:18px 20px; margin-bottom:24px;">
          <h4 style="margin:0 0 6px 0; color:#1E3A8A; font-size:1rem;"><i class="fa-solid fa-shield-halved"></i> Governance &amp; Truthfulness Policy</h4>
          <p style="margin:0; font-size:0.9rem; color:#1E40AF; line-height:1.5;">
            In strict adherence to project specifications, founder names, biographies, and qualifications must never be fabricated. Draft profiles with unverified placeholders remain clearly labeled until official executive documents and approved portraits are entered below by the site administrator.
          </p>
        </div>

        <div class="dash-card">
          <div class="table-responsive">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Executive Profile</th>
                  <th>Status</th>
                  <th>Verification Checklist</th>
                  <th>Leadership Focus</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                ${rows || '<tr><td colspan="5" class="text-center text-muted">No founder profiles found.</td></tr>'}
              </tbody>
            </table>
          </div>
        </div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Founders Management', content, 'founders'));
    }

    // Admin Edit Founder
    if (pathname.startsWith('/admin/founders/edit/')) {
      const founderId = Number(pathname.split('/').pop());
      const founder = (db.founders || []).find(f => f.id === founderId);
      if (!founder) {
        res.writeHead(302, { 'Location': '/admin/founders' });
        return res.end();
      }

      if (req.method === 'POST') {
        parseBody(data => {
          founder.name = data.name || founder.name;
          founder.designation = data.designation || founder.designation;
          founder.photo_url = data.photo_url || '';
          founder.status = data.status || founder.status;
          founder.missing_fields = data.missing_fields || '';
          founder.short_bio = data.short_bio || founder.short_bio;
          founder.full_bio = data.full_bio || founder.full_bio;
          founder.background = data.background || founder.background;
          founder.leadership_areas = data.leadership_areas || founder.leadership_areas;
          founder.quote = data.quote || founder.quote;
          founder.email = data.email || founder.email;
          founder.phone = data.phone || founder.phone;
          founder.linkedin_url = data.linkedin_url || founder.linkedin_url;
          saveDB(db);
          res.writeHead(302, { 'Location': '/admin/founders' });
          return res.end();
        });
        return;
      }

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Edit Leadership Profile: ${escapeHtml(founder.designation)}</h1>
            <p class="page-subtitle">Configure official executive details, background, and publication status.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/founders" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back to Founders</a>
          </div>
        </div>

        <form action="/admin/founders/edit/${founder.id}" method="POST" class="admin-form-card">
          <div class="form-section-title">1. Leadership Title &amp; Status</div>
          <div class="form-row">
            <div class="form-group half-width"><label>Official Legal Name</label><input type="text" name="name" class="form-input" value="${escapeHtml(founder.name)}"></div>
            <div class="form-group half-width"><label>Official Designation *</label><input type="text" name="designation" class="form-input" required value="${escapeHtml(founder.designation)}"></div>
          </div>
          <div class="form-row">
            <div class="form-group half-width">
              <label>Publication Status</label>
              <select name="status" class="form-select">
                <option value="draft" ${founder.status==='draft'?'selected':''}>Draft (Displays Administrative Compliance Notice)</option>
                <option value="published" ${founder.status==='published'?'selected':''}>Published (Certified &amp; Complete)</option>
              </select>
            </div>
            <div class="form-group half-width">
              <label>Missing Fields Checklist (Leave blank once verified)</label>
              <input type="text" name="missing_fields" class="form-input" value="${escapeHtml(founder.missing_fields || '')}" placeholder="e.g. Official Executive Portrait, Verified Qualifications">
            </div>
          </div>

          <div class="form-section-title">2. Executive Portrait &amp; Contact</div>
          <div class="form-row">
            <div class="form-group half-width"><label>Official Portrait URL (Leave blank to show corporate crest)</label><input type="text" name="photo_url" class="form-input" value="${escapeHtml(founder.photo_url || '')}"></div>
            <div class="form-group half-width"><label>Official Email</label><input type="email" name="email" class="form-input" value="${escapeHtml(founder.email || '')}"></div>
          </div>
          <div class="form-row">
            <div class="form-group half-width"><label>Phone / Desk</label><input type="text" name="phone" class="form-input" value="${escapeHtml(founder.phone || '')}"></div>
            <div class="form-group half-width"><label>LinkedIn Executive URL</label><input type="url" name="linkedin_url" class="form-input" value="${escapeHtml(founder.linkedin_url || '')}"></div>
          </div>

          <div class="form-section-title">3. Leadership Areas &amp; Professional Background</div>
          <div class="form-group"><label>Areas of Executive Leadership *</label><input type="text" name="leadership_areas" class="form-input" required value="${escapeHtml(founder.leadership_areas || '')}" placeholder="Strategic Vision, Institutional Alliances, Corporate Governance"></div>
          <div class="form-group"><label>Professional Background &amp; Industry Acumen *</label><input type="text" name="background" class="form-input" required value="${escapeHtml(founder.background || '')}" placeholder="Institutional Capital Markets, Real Estate Brokerage Leadership..."></div>
          <div class="form-group"><label>Executive Leadership Philosophy Quote *</label><textarea name="quote" rows="2" class="form-textarea" required>${escapeHtml(founder.quote || '')}</textarea></div>

          <div class="form-section-title">4. Biography</div>
          <div class="form-group"><label>Executive Summary (Short)</label><textarea name="short_bio" rows="2" class="form-textarea">${escapeHtml(founder.short_bio || '')}</textarea></div>
          <div class="form-group"><label>Comprehensive Corporate Biography *</label><textarea name="full_bio" rows="6" class="form-textarea" required>${escapeHtml(founder.full_bio || '')}</textarea></div>

          <div class="form-actions-bar">
            <button type="submit" class="btn-admin-primary"><i class="fa-solid fa-check"></i> Update Founder Profile</button>
            <a href="/admin/founders" class="btn-admin-outline">Cancel</a>
          </div>
        </form>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Edit Founder', content, 'founders'));
    }

    // Admin Services
    if (pathname === '/admin/services') {
      const rows = db.services.map(s => `
        <tr>
          <td><strong>${escapeHtml(s.title)}</strong></td>
          <td><code>/services/${s.slug}</code></td>
          <td>${escapeHtml(s.short_desc)}</td>
          <td><span class="status-pill status-published">ACTIVE</span></td>
          <td><a href="/services/${s.slug}" target="_blank" class="btn-icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
        </tr>
      `).join('');
      const content = `
        <div class="admin-page-header">
          <div class="header-titles"><h1 class="page-title">Manage Services</h1><p class="page-subtitle">Configure real estate advisory services.</p></div>
        </div>
        <div class="dash-card"><div class="table-responsive"><table class="admin-table"><thead><tr><th>Service</th><th>Route</th><th>Summary</th><th>Status</th><th>Actions</th></tr></thead><tbody>${rows}</tbody></table></div></div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Services', content, 'services'));
    }

    // Admin Testimonials
    if (pathname === '/admin/testimonials') {
      const rows = db.testimonials.map(t => `
        <tr>
          <td><strong>${escapeHtml(t.client_name)}</strong></td>
          <td>${escapeHtml(t.location)}</td>
          <td>&ldquo;${escapeHtml(t.quote)}&rdquo;</td>
          <td><span class="status-pill status-published">Featured on Home</span></td>
        </tr>
      `).join('');
      const content = `
        <div class="admin-page-header">
          <div class="header-titles"><h1 class="page-title">Manage Testimonials</h1><p class="page-subtitle">Curate client reviews matching master homepage design.</p></div>
        </div>
        <div class="dash-card"><div class="table-responsive"><table class="admin-table"><thead><tr><th>Client</th><th>Location</th><th>Quote</th><th>Status</th></tr></thead><tbody>${rows}</tbody></table></div></div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Testimonials', content, 'testimonials'));
    }

    // Admin Locations
    if (pathname === '/admin/locations') {
      const rows = db.locations.map(l => `
        <tr>
          <td><strong>${escapeHtml(l.name)}</strong></td>
          <td><code>/locations/${l.slug}</code></td>
          <td>${escapeHtml(l.city)}</td>
          <td><span class="status-pill status-published">Featured</span></td>
          <td><a href="/locations/${l.slug}" target="_blank" class="btn-icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
        </tr>
      `).join('');
      const content = `
        <div class="admin-page-header">
          <div class="header-titles"><h1 class="page-title">Locations &amp; Communities</h1><p class="page-subtitle">Manage major Dubai freehold areas.</p></div>
        </div>
        <div class="dash-card"><div class="table-responsive"><table class="admin-table"><thead><tr><th>Community</th><th>Slug</th><th>Emirate</th><th>Status</th><th>Actions</th></tr></thead><tbody>${rows}</tbody></table></div></div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Locations', content, 'locations'));
    }

    // Admin Market Blogs & Insights Management
    if (pathname === '/admin/blogs') {
      const blogs = db.blogs || [];
      const rows = blogs.map(b => `
        <tr>
          <td>
            <div class="table-prop-info">
              <img src="${b.featured_image || '/assets/images/villa-dubai-hills.jpg'}" alt="" class="table-prop-thumb">
              <div>
                <strong>${escapeHtml(b.title)}</strong><br>
                <small class="text-muted"><i class="fa-solid fa-folder"></i> ${escapeHtml(b.category)} &bull; ${escapeHtml(b.author)}</small>
              </div>
            </div>
          </td>
          <td><span class="agent-tag">${escapeHtml(b.category)}</span></td>
          <td>${escapeHtml(b.author)}</td>
          <td><small>${escapeHtml(b.published_at || '')}</small></td>
          <td><span class="status-pill status-${b.status}">${(b.status || 'published').toUpperCase()}</span></td>
          <td>
            <div class="action-buttons-group">
              <a href="/blog/${b.slug}" target="_blank" class="btn-icon" title="View Public Article"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
              <a href="/admin/blogs/edit/${b.id}" class="btn-icon" title="Edit Article"><i class="fa-solid fa-pen-to-square"></i></a>
              <form action="/admin/blogs/delete/${b.id}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this blog post?');">
                <button type="submit" class="btn-icon delete-btn" title="Delete Article"><i class="fa-solid fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
      `).join('');

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Market Blogs, Insights &amp; Guides (${blogs.length})</h1>
            <p class="page-subtitle">Publish and curate Dubai real estate intelligence, market trends, and investment guides.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/blogs/create" class="btn-admin-primary"><i class="fa-solid fa-plus"></i> Add New Blog Post</a>
          </div>
        </div>

        <div class="dash-card">
          <div class="table-responsive">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Article &amp; Topic</th>
                  <th>Category</th>
                  <th>Author</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                ${rows || '<tr><td colspan="6" class="text-center text-muted">No blog posts available. Click "Add New Blog Post" to publish one.</td></tr>'}
              </tbody>
            </table>
          </div>
        </div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Market Blogs', content, 'blogs'));
    }

    // Admin Create Blog
    if (pathname === '/admin/blogs/create') {
      if (req.method === 'POST') {
        parseBody(data => {
          const blogs = db.blogs || [];
          const newId = blogs.length > 0 ? Math.max(...blogs.map(b => b.id)) + 1 : 1;
          const slug = (data.slug || data.title).toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '') + '-' + Math.floor(Math.random() * 900 + 100);
          const newBlog = {
            id: newId,
            title: data.title || 'Untitled Article',
            slug: slug,
            category: data.category || 'Market Insights',
            author: data.author || 'DRL Research Team',
            published_at: data.published_at || new Date().toISOString().split('T')[0],
            status: data.status || 'published',
            is_featured: data.is_featured ? 1 : 0,
            featured_image: data.featured_image || '/assets/images/apartment-downtown.jpg',
            excerpt: data.excerpt || '',
            content: data.content || '',
            tags: (data.tags || '').split(',').map(s => s.trim()).filter(Boolean)
          };
          db.blogs.unshift(newBlog);
          saveDB(db);
          res.writeHead(302, { 'Location': '/admin/blogs' });
          return res.end();
        });
        return;
      }

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Create New Market Blog / Guide</h1>
            <p class="page-subtitle">Draft a research article or investment guide for investors and buyers.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/blogs" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back to Blogs</a>
          </div>
        </div>

        <form action="/admin/blogs/create" method="POST" class="admin-form-card">
          <div class="form-section-title">1. Article Headline &amp; Metadata</div>
          <div class="form-group">
            <label>Article Title *</label>
            <input type="text" name="title" class="form-input" required placeholder="e.g. Dubai Real Estate Market Outlook 2026: Capital Growth & Rental Yields">
          </div>
          <div class="form-row">
            <div class="form-group third-width">
              <label>Category *</label>
              <select name="category" class="form-select">
                <option value="Market Insights">Market Insights</option>
                <option value="Golden Visa">Golden Visa</option>
                <option value="Investment Advisory">Investment Advisory</option>
                <option value="Communities">Communities & Areas</option>
                <option value="Legal & RERA">Legal & RERA Guides</option>
              </select>
            </div>
            <div class="form-group third-width">
              <label>Author *</label>
              <input type="text" name="author" class="form-input" value="Vikram Dwarika">
            </div>
            <div class="form-group third-width">
              <label>Status</label>
              <select name="status" class="form-select">
                <option value="published">Published (Live)</option>
                <option value="draft">Draft (Hidden)</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group half-width">
              <label>Featured Image URL</label>
              <input type="text" name="featured_image" class="form-input" value="/assets/images/apartment-downtown.jpg">
            </div>
            <div class="form-group half-width">
              <label>Tags (comma-separated)</label>
              <input type="text" name="tags" class="form-input" placeholder="Dubai, Investment, ROI, Golden Visa">
            </div>
          </div>

          <div class="form-section-title">2. Excerpt &amp; Full Body</div>
          <div class="form-group">
            <label>Short Summary / Excerpt *</label>
            <textarea name="excerpt" rows="2" class="form-textarea" required placeholder="Brief 1-2 sentence overview shown in search results and AI summary..."></textarea>
          </div>
          <div class="form-group">
            <label>Full Content Body *</label>
            <textarea name="content" rows="8" class="form-textarea" required placeholder="Detailed guide content, analysis, statistical yields, community highlights..."></textarea>
          </div>

          <div class="form-actions-bar">
            <button type="submit" class="btn-admin-primary"><i class="fa-solid fa-check"></i> Publish Article</button>
            <a href="/admin/blogs" class="btn-admin-outline">Cancel</a>
          </div>
        </form>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Add Blog Post', content, 'blogs'));
    }

    // Admin Edit Blog
    if (pathname.startsWith('/admin/blogs/edit/')) {
      const blogId = Number(pathname.split('/').pop());
      const blog = (db.blogs || []).find(b => b.id === blogId);
      if (!blog) {
        res.writeHead(302, { 'Location': '/admin/blogs' });
        return res.end();
      }

      if (req.method === 'POST') {
        parseBody(data => {
          blog.title = data.title || blog.title;
          blog.category = data.category || blog.category;
          blog.author = data.author || blog.author;
          blog.status = data.status || blog.status;
          blog.featured_image = data.featured_image || blog.featured_image;
          blog.excerpt = data.excerpt || blog.excerpt;
          blog.content = data.content || blog.content;
          blog.tags = (data.tags || '').split(',').map(s => s.trim()).filter(Boolean);
          saveDB(db);
          res.writeHead(302, { 'Location': '/admin/blogs' });
          return res.end();
        });
        return;
      }

      const content = `
        <div class="admin-page-header">
          <div class="header-titles">
            <h1 class="page-title">Edit Blog: ${escapeHtml(blog.title)}</h1>
            <p class="page-subtitle">Update article analysis, category, and publication status.</p>
          </div>
          <div class="header-actions">
            <a href="/admin/blogs" class="btn-admin-outline"><i class="fa-solid fa-arrow-left"></i> Back to Blogs</a>
          </div>
        </div>

        <form action="/admin/blogs/edit/${blog.id}" method="POST" class="admin-form-card">
          <div class="form-section-title">1. Article Headline &amp; Metadata</div>
          <div class="form-group">
            <label>Article Title *</label>
            <input type="text" name="title" class="form-input" required value="${escapeHtml(blog.title)}">
          </div>
          <div class="form-row">
            <div class="form-group third-width">
              <label>Category *</label>
              <select name="category" class="form-select">
                <option value="Market Insights" ${blog.category === 'Market Insights' ? 'selected' : ''}>Market Insights</option>
                <option value="Golden Visa" ${blog.category === 'Golden Visa' ? 'selected' : ''}>Golden Visa</option>
                <option value="Investment Advisory" ${blog.category === 'Investment Advisory' ? 'selected' : ''}>Investment Advisory</option>
                <option value="Communities" ${blog.category === 'Communities' ? 'selected' : ''}>Communities & Areas</option>
                <option value="Legal & RERA" ${blog.category === 'Legal & RERA' ? 'selected' : ''}>Legal & RERA Guides</option>
              </select>
            </div>
            <div class="form-group third-width">
              <label>Author *</label>
              <input type="text" name="author" class="form-input" value="${escapeHtml(blog.author)}">
            </div>
            <div class="form-group third-width">
              <label>Status</label>
              <select name="status" class="form-select">
                <option value="published" ${blog.status === 'published' ? 'selected' : ''}>Published (Live)</option>
                <option value="draft" ${blog.status === 'draft' ? 'selected' : ''}>Draft (Hidden)</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group half-width">
              <label>Featured Image URL</label>
              <input type="text" name="featured_image" class="form-input" value="${escapeHtml(blog.featured_image || '')}">
            </div>
            <div class="form-group half-width">
              <label>Tags (comma-separated)</label>
              <input type="text" name="tags" class="form-input" value="${escapeHtml((blog.tags || []).join(', '))}">
            </div>
          </div>

          <div class="form-section-title">2. Excerpt &amp; Full Body</div>
          <div class="form-group">
            <label>Short Summary / Excerpt *</label>
            <textarea name="excerpt" rows="2" class="form-textarea" required>${escapeHtml(blog.excerpt || '')}</textarea>
          </div>
          <div class="form-group">
            <label>Full Content Body *</label>
            <textarea name="content" rows="8" class="form-textarea" required>${escapeHtml(blog.content || '')}</textarea>
          </div>

          <div class="form-actions-bar">
            <button type="submit" class="btn-admin-primary"><i class="fa-solid fa-check"></i> Update Article</button>
            <a href="/admin/blogs" class="btn-admin-outline">Cancel</a>
          </div>
        </form>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Edit Blog', content, 'blogs'));
    }

    // Admin Delete Blog
    if (pathname.startsWith('/admin/blogs/delete/')) {
      const blogId = Number(pathname.split('/').pop());
      db.blogs = (db.blogs || []).filter(b => b.id !== blogId);
      saveDB(db);
      res.writeHead(302, { 'Location': '/admin/blogs' });
      return res.end();
    }

    // Admin Growth Tools Hub (Saifullah Developer Repos: SEO ROI, PageSpeed, Scorecard, Schema, Palette)
    if (pathname === '/admin/tools') {
      const curTab = query.tab || 'seo-roi';
      let toolsHtml = fs.readFileSync(path.join(ROOT_DIR, 'app/Views/admin/tools/index.php'), 'utf8');
      toolsHtml = toolsHtml.replace(/<\?php[\s\S]*?\?>/g, '');
      // Mark active tab
      toolsHtml = toolsHtml.replace(new RegExp(`data-tab="tab-${curTab}"`, 'g'), `data-tab="tab-${curTab}" class="tool-tab-btn active"`);
      toolsHtml = toolsHtml.replace(new RegExp(`id="tab-${curTab}" class="tool-tab-content"`, 'g'), `id="tab-${curTab}" class="tool-tab-content active"`);
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Growth Tools & Intelligence Hub', toolsHtml, 'tools'));
    }

    // Admin SEO
    if (pathname === '/admin/seo') {
      const content = `
        <div class="admin-page-header">
          <div class="header-titles"><h1 class="page-title">SEO &amp; Indexation Management</h1><p class="page-subtitle">Inspect automated XML sitemaps, robots.txt crawl directives, and schema integrity.</p></div>
        </div>
        <div class="dash-card">
          <div class="seo-endpoint-item" style="padding: 16px 0; border-bottom: 1px solid #eee;">
            <strong>Dynamic XML Sitemap (sitemap.xml)</strong>
            <p class="text-muted">Includes all published properties, locations, types, services, and static pages.</p>
            <a href="/sitemap.xml" target="_blank" class="btn-admin-outline" style="margin-top:8px;"><i class="fa-solid fa-external-link"></i> Inspect XML Sitemap</a>
          </div>
          <div class="seo-endpoint-item" style="padding: 16px 0;">
            <strong>Robots.txt Crawl Directives</strong>
            <p class="text-muted">Directs web crawlers to public routes while protecting /admin directories.</p>
            <a href="/robots.txt" target="_blank" class="btn-admin-outline" style="margin-top:8px;"><i class="fa-solid fa-external-link"></i> Inspect Robots.txt</a>
          </div>
        </div>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('SEO Management', content, 'seo'));
    }

    // Admin Settings
    if (pathname === '/admin/settings') {
      if (req.method === 'POST') {
        parseBody(data => {
          Object.keys(data).forEach(k => {
            if (db.settings[k] !== undefined) db.settings[k] = data[k];
          });
          saveDB(db);
          res.writeHead(302, { 'Location': '/admin/settings' });
          return res.end();
        });
        return;
      }

      const content = `
        <div class="admin-page-header">
          <div class="header-titles"><h1 class="page-title">Global Site Settings</h1><p class="page-subtitle">Update official contact details, statistics, and RERA credentials.</p></div>
        </div>
        <form action="/admin/settings" method="POST" class="admin-form-card">
          <div class="form-section-title">1. Brand Identity &amp; Contact</div>
          <div class="form-row">
            <div class="form-group half-width"><label>Company Name</label><input type="text" name="site_name" class="form-input" value="${escapeHtml(db.settings.site_name)}"></div>
            <div class="form-group half-width"><label>Tagline</label><input type="text" name="site_tagline" class="form-input" value="${escapeHtml(db.settings.site_tagline)}"></div>
          </div>
          <div class="form-row">
            <div class="form-group third-width"><label>Phone</label><input type="text" name="company_phone" class="form-input" value="${escapeHtml(db.settings.company_phone)}"></div>
            <div class="form-group third-width"><label>WhatsApp</label><input type="text" name="company_whatsapp" class="form-input" value="${escapeHtml(db.settings.company_whatsapp)}"></div>
            <div class="form-group third-width"><label>Email</label><input type="email" name="company_email" class="form-input" value="${escapeHtml(db.settings.company_email)}"></div>
          </div>
          <div class="form-group"><label>Address</label><input type="text" name="company_address" class="form-input" value="${escapeHtml(db.settings.company_address)}"></div>
          <div class="form-section-title">2. Homepage Statistics Counters</div>
          <div class="form-row">
            <div class="form-group third-width"><label>Properties Sold</label><input type="text" name="stat_properties_sold" class="form-input" value="${escapeHtml(db.settings.stat_properties_sold)}"></div>
            <div class="form-group third-width"><label>Happy Clients</label><input type="text" name="stat_happy_clients" class="form-input" value="${escapeHtml(db.settings.stat_happy_clients)}"></div>
            <div class="form-group third-width"><label>Years Experience</label><input type="text" name="stat_years_experience" class="form-input" value="${escapeHtml(db.settings.stat_years_experience)}"></div>
          </div>
          <div class="form-actions-bar">
            <button type="submit" class="btn-admin-primary"><i class="fa-solid fa-floppy-disk"></i> Save Settings</button>
          </div>
        </form>
      `;
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderAdmin('Settings', content, 'settings'));
    }
  }

  // ==========================================
  // 6. PUBLIC FRONTEND ENDPOINTS
  // ==========================================
  const db = getDB();

  // Helper for rendering Property Cards
  function renderPropertyCard(p) {
    const loc = db.locations.find(l => l.id == p.location_id) || {};
    const badgeText = p.listing_type === 'rent' ? 'For Rent' : (p.listing_type === 'off-plan' ? 'Off-Plan' : (p.listing_type === 'commercial' ? 'Commercial' : 'For Sale'));
    return `
      <article class="property-card" data-id="${p.id}">
        <div class="property-card-media">
          <a href="/property/${p.slug}" class="property-card-link" aria-label="${escapeHtml(p.title)}">
            <img src="${p.featured_image}" alt="${escapeHtml(p.title)}" loading="lazy" width="380" height="240" class="property-card-img">
          </a>
          <span class="property-badge">${badgeText}</span>
        </div>
        <div class="property-card-body">
          <h3 class="property-card-title"><a href="/property/${p.slug}">${escapeHtml(p.title)}</a></h3>
          <div class="property-card-location"><i class="fa-solid fa-location-dot"></i> <span>${escapeHtml(loc.name || 'Dubai, UAE')}</span></div>
          <div class="property-card-specs">
            ${p.bedrooms > 0 ? `<span class="spec-item"><i class="fa-solid fa-bed"></i> ${p.bedrooms} Beds</span>` : `<span class="spec-item"><i class="fa-solid fa-building"></i> Commercial</span>`}
            ${p.bathrooms > 0 ? `<span class="spec-item"><i class="fa-solid fa-bath"></i> ${p.bathrooms} Baths</span>` : ''}
          </div>
          <div class="property-card-footer">
            <div class="property-price">${formatPrice(p.price, p.currency)}</div>
            <a href="/property/${p.slug}" class="property-arrow-link" aria-label="View details"><i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </article>
    `;
  }

  // Helper for rendering Agent Profile Cards
  function renderAgentCard(a) {
    const photo = a.photo_url || '/assets/images/agents/omar-farooq.jpg';
    const specs = (a.specializations || []).map(s => `<span class="spec-pill"><i class="fa-solid fa-check"></i> ${escapeHtml(s.charAt(0).toUpperCase() + s.slice(1))}</span>`).join('');
    const langs = (a.languages || []).join(', ');
    const locs = (a.locations || []).slice(0, 2).join(', ');
    const cleanPhone = (a.phone || '+971 542202920').replace(/[^0-9+]/g, '');
    const wa = (a.whatsapp || '971542202920').replace(/[^0-9]/g, '');

    return `
      <article class="agent-card" data-agent-id="${a.id}">
        <div class="agent-card-media">
          <a href="/agents/${a.slug}" class="agent-image-link" aria-label="View profile of ${escapeHtml(a.name)}">
            <img src="${photo}" alt="${escapeHtml(a.name)} - ${escapeHtml(a.designation)}" loading="lazy" width="380" height="380" class="agent-card-img">
          </a>
          ${a.rera_brn ? `<span class="agent-rera-badge"><i class="fa-solid fa-id-badge"></i> BRN ${escapeHtml(a.rera_brn)}</span>` : ''}
          ${a.experience ? `<span class="agent-exp-badge"><i class="fa-solid fa-award"></i> ${escapeHtml(a.experience)}</span>` : ''}
        </div>
        <div class="agent-card-body">
          <div class="agent-meta-header">
            <h3 class="agent-name"><a href="/agents/${a.slug}">${escapeHtml(a.name)}</a></h3>
            <p class="agent-designation">${escapeHtml(a.designation)}</p>
          </div>
          <p class="agent-short-bio">${escapeHtml(a.short_bio || '')}</p>
          ${specs ? `<div class="agent-spec-tags">${specs}</div>` : ''}
          <div class="agent-details-row">
            ${langs ? `<div class="detail-item"><i class="fa-solid fa-globe"></i> <span>${escapeHtml(langs)}</span></div>` : ''}
            ${locs ? `<div class="detail-item"><i class="fa-solid fa-location-dot"></i> <span>${escapeHtml(locs)}</span></div>` : ''}
          </div>
          <div class="agent-actions-row">
            <div class="agent-contact-buttons">
              <a href="tel:${cleanPhone}" class="agent-btn-circle call" title="Call ${escapeHtml(a.name)}" aria-label="Call ${escapeHtml(a.name)}"><i class="fa-solid fa-phone"></i></a>
              <a href="https://wa.me/${wa}?text=Hello%20${encodeURIComponent(a.name)},%20I%20am%20inquiring%20about%20Dubai%20properties%20via%20DRL%20Dwarika." target="_blank" rel="noopener" class="agent-btn-circle whatsapp" title="WhatsApp ${escapeHtml(a.name)}" aria-label="WhatsApp ${escapeHtml(a.name)}"><i class="fa-brands fa-whatsapp"></i></a>
              <a href="mailto:${escapeHtml(a.email)}" class="agent-btn-circle email" title="Email ${escapeHtml(a.name)}" aria-label="Email ${escapeHtml(a.name)}"><i class="fa-solid fa-envelope"></i></a>
            </div>
            <a href="/agents/${a.slug}" class="btn-view-profile">
              <span>View Profile</span>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
    `;
  }

  // 6.1 HOMEPAGE (Exact match to Master Design Illustration)
  if (pathname === '/') {
    const featuredListings = db.properties.filter(p => p.status === 'published' && p.is_featured).slice(0, 3);
    const featuredCards = featuredListings.map(renderPropertyCard).join('');

    const locOptions = db.locations.map(l => `<option value="${l.slug}">${escapeHtml(l.name)}</option>`).join('');
    const typeOptions = db.property_types.map(t => `<option value="${t.slug}">${escapeHtml(t.name)}</option>`).join('');

    const serviceCards = db.services.map(s => `
      <div class="service-card">
        <div class="service-icon-circle"><i class="fa-solid ${s.icon}"></i></div>
        <h3 class="service-title">${escapeHtml(s.title)}</h3>
        <p class="service-desc">${escapeHtml(s.short_desc)}</p>
        <a href="/services/${s.slug}" class="service-arrow-link" aria-label="Learn more"><i class="fa-solid fa-arrow-right"></i></a>
      </div>
    `).join('');

    const testimonialCards = db.testimonials.map(t => `
      <div class="testimonial-card">
        <div class="testimonial-avatar-initial">${escapeHtml(t.avatar_initial)}</div>
        <blockquote class="testimonial-quote">&ldquo;${escapeHtml(t.quote)}&rdquo;</blockquote>
        <div class="testimonial-author-info">
          <div class="author-name">${escapeHtml(t.client_name)}</div>
          <div class="author-location">${escapeHtml(t.location)}</div>
        </div>
      </div>
    `).join('');

    const homeHtml = `
      <!-- 1. Hero Section -->
      <section class="hero-section">
        <div class="container hero-container">
          <div class="hero-content">
            <h1 class="hero-title">Opening Doors<br>To Prosperity</h1>
            <p class="hero-subtitle">Find your dream home with Dwarika Real Estate</p>
            <div class="hero-cta-group">
              <a href="/properties" class="btn-primary-pill" id="btnHeroExplore">
                <span>Explore Properties</span> <i class="fa-solid fa-arrow-right"></i>
              </a>
              <a href="/contact-us" class="btn-outline-pill" id="btnHeroContact">
                <span>Contact Us</span>
              </a>
            </div>

            <!-- Trust Indicators -->
            <div class="hero-trust-badges">
              <div class="trust-badge-item">
                <div class="trust-icon"><i class="fa-solid fa-user-shield"></i></div>
                <div class="trust-text"><strong>Trusted</strong><span>Real Estate Partner</span></div>
              </div>
              <div class="trust-badge-item">
                <div class="trust-icon"><i class="fa-solid fa-city"></i></div>
                <div class="trust-text"><strong>Wide Range</strong><span>of Properties</span></div>
              </div>
              <div class="trust-badge-item">
                <div class="trust-icon"><i class="fa-solid fa-handshake"></i></div>
                <div class="trust-text"><strong>Transparent</strong><span>&amp; Hassle-Free Deals</span></div>
              </div>
            </div>
          </div>

          <div class="hero-media-wrap">
            <div class="hero-image-card">
              <picture>
                <source media="(max-width: 768px)" srcset="/assets/images/hero-building-mobile.webp" type="image/webp">
                <source media="(min-width: 769px)" srcset="/assets/images/hero-building.webp" type="image/webp">
                <img src="/assets/images/hero-building.jpg" alt="Luxury Dubai Residences" width="620" height="520" class="hero-img" fetchpriority="high" decoding="async">
              </picture>
            </div>
          </div>
        </div>

        <!-- 2. Quick Property Search Floating Card -->
        <div class="container search-container-wrap">
          <div class="quick-search-box">
            <form action="/properties" method="GET" class="quick-search-form" id="quickSearchForm">
              <div class="quick-search-title">Quick Property Search</div>
              <div class="quick-search-fields">
                <div class="search-field">
                  <select name="location" class="search-select">
                    <option value="">Location</option>
                    ${locOptions}
                  </select>
                  <i class="fa-solid fa-chevron-down select-caret"></i>
                </div>
                <div class="search-field">
                  <select name="type" class="search-select">
                    <option value="">Property Type</option>
                    ${typeOptions}
                  </select>
                  <i class="fa-solid fa-chevron-down select-caret"></i>
                </div>
                <div class="search-field">
                  <select name="max_price" class="search-select">
                    <option value="">Budget</option>
                    <option value="2500000">Up to AED 2.5M</option>
                    <option value="5000000">Up to AED 5.0M</option>
                    <option value="10000000">Up to AED 10M</option>
                    <option value="25000000">AED 10M+</option>
                  </select>
                  <i class="fa-solid fa-chevron-down select-caret"></i>
                </div>
                <button type="submit" class="btn-search-submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
              </div>
            </form>
          </div>
        </div>
      </section>

      <!-- 3. Our Services Section -->
      <section class="services-section section-padding">
        <div class="container">
          <div class="section-header text-center">
            <span class="section-badge">— OUR SERVICES —</span>
            <h2 class="section-title">How We Can Help You</h2>
          </div>
          <div class="services-grid">${serviceCards}</div>
        </div>
      </section>

      <!-- 4. Featured Properties Section -->
      <section class="featured-section section-padding surface-bg">
        <div class="container">
          <div class="featured-header-row">
            <div class="header-left">
              <span class="section-badge">— FEATURED PROPERTIES —</span>
              <h2 class="section-title">Explore Our Best Properties</h2>
              <p class="section-desc">Find the perfect property that matches your lifestyle and budget.</p>
            </div>
            <div class="header-right">
              <a href="/properties" class="btn-primary-pill" id="btnViewAllProps">
                <span>View All Properties</span> <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>
          <div class="properties-grid">${featuredCards}</div>
        </div>
      </section>

      <!-- 5. About Dwarika Real Estate Section -->
      <section class="about-section section-padding">
        <div class="container about-container">
          <div class="about-media-col">
            <div class="about-image-card">
              <img src="/assets/images/burj-skyline.jpg" alt="Dubai Skyline" width="560" height="380" class="about-img">
              <div class="handwritten-sticker"><span>Your Trusted<br>Real Estate Partner<br>in Dubai</span></div>
            </div>
          </div>
          <div class="about-text-col">
            <span class="section-badge">— ABOUT DWARIKA REAL ESTATE LLC —</span>
            <h2 class="section-title">Building Dreams,<br>One Property at a Time</h2>
            <p class="about-paragraph">
              Dwarika Real Estate LLC is a trusted real estate brokerage in Dubai, helping individuals and families find the perfect property. With a commitment to transparency, professionalism, and personalized service, we make your real estate journey smooth and successful.
            </p>
            <div class="about-stats-row">
              <div class="stat-card"><div class="stat-number">${escapeHtml(db.settings.stat_properties_sold)}</div><div class="stat-label">Properties Sold</div></div>
              <div class="stat-divider"></div>
              <div class="stat-card"><div class="stat-number">${escapeHtml(db.settings.stat_happy_clients)}</div><div class="stat-label">Happy Clients</div></div>
              <div class="stat-divider"></div>
              <div class="stat-card"><div class="stat-number">${escapeHtml(db.settings.stat_years_experience)}</div><div class="stat-label">Years Experience</div></div>
            </div>
            <div class="about-action-btns" style="margin-top: 28px; display: flex; gap: 14px; flex-wrap: wrap;">
              <a href="/founders" class="btn-primary-pill" id="btnHomeFounders">
                <span>Meet Our Founders &amp; Leadership</span> <i class="fa-solid fa-arrow-right"></i>
              </a>
              <a href="/about-us" class="btn-outline-pill" id="btnHomeAbout">
                <span>Company Story</span>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- 6. What Our Clients Say (Testimonials) -->
      <section class="testimonials-section section-padding surface-bg">
        <div class="container">
          <div class="section-header text-center">
            <span class="section-badge">— WHAT OUR CLIENTS SAY —</span>
            <h2 class="section-title">Trusted by Many, Loved by All</h2>
          </div>
          <div class="testimonials-grid">${testimonialCards}</div>
          <div class="testimonial-carousel-dots"><span class="dot active"></span><span class="dot"></span><span class="dot"></span></div>
        </div>
      </section>
    `;

    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage('DRL Dwarika Real Estate LLC | Opening Doors To Prosperity', homeHtml, 'home'));
  }

  // 6.2 PROPERTIES LISTING & FILTERS
  if (pathname === '/properties' || pathname === '/properties/buy' || pathname === '/properties/rent' || pathname === '/properties/off-plan' || pathname === '/properties/commercial') {
    let list = db.properties.filter(p => p.status === 'published');
    let pageTitle = 'All Properties in Dubai';
    let navActive = 'properties';

    if (pathname.includes('/buy')) { list = list.filter(p => p.listing_type === 'sale'); pageTitle = 'Properties for Sale in Dubai'; navActive = 'buy'; }
    if (pathname.includes('/rent')) { list = list.filter(p => p.listing_type === 'rent'); pageTitle = 'Properties for Rent in Dubai'; navActive = 'rent'; }
    if (pathname.includes('/off-plan')) { list = list.filter(p => p.listing_type === 'off-plan'); pageTitle = 'Off-Plan Projects in Dubai'; navActive = 'off-plan'; }
    if (pathname.includes('/commercial')) { list = list.filter(p => p.listing_type === 'commercial'); pageTitle = 'Commercial Real Estate in Dubai'; navActive = 'commercial'; }

    // Apply URL query filters
    if (query.location) {
      const loc = db.locations.find(l => l.slug === query.location || l.id == query.location);
      if (loc) list = list.filter(p => p.location_id == loc.id);
    }
    if (query.type) {
      const type = db.property_types.find(t => t.slug === query.type || t.id == query.type);
      if (type) list = list.filter(p => p.property_type_id == type.id);
    }
    if (query.bedrooms) {
      if (query.bedrooms === '4+') list = list.filter(p => p.bedrooms >= 4);
      else list = list.filter(p => p.bedrooms == query.bedrooms);
    }
    if (query.max_price) {
      list = list.filter(p => p.price <= Number(query.max_price));
    }
    if (query.q) {
      const qLower = query.q.toLowerCase();
      list = list.filter(p => p.title.toLowerCase().includes(qLower) || p.description.toLowerCase().includes(qLower) || p.reference_code.toLowerCase().includes(qLower));
    }

    // Sort
    if (query.sort === 'price_asc') list.sort((a,b) => a.price - b.price);
    else if (query.sort === 'price_desc') list.sort((a,b) => b.price - a.price);

    const cardsHtml = list.map(renderPropertyCard).join('');
    const locOptions = db.locations.map(l => `<option value="${l.slug}" ${query.location === l.slug ? 'selected' : ''}>${escapeHtml(l.name)}</option>`).join('');
    const typeOptions = db.property_types.map(t => `<option value="${t.slug}" ${query.type === t.slug ? 'selected' : ''}>${escapeHtml(t.name)}</option>`).join('');

    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li aria-current="page">${escapeHtml(pageTitle)}</li></ol></nav>
          <h1 class="page-banner-title">${escapeHtml(pageTitle)}</h1>
          <p class="page-banner-subtitle">Explore our portfolio of verified luxury apartments, private villas, and commercial spaces across the UAE.</p>
        </div>
      </div>

      <section class="properties-listing-section section-padding">
        <div class="container">
          <div class="filter-panel-card">
            <form action="" method="GET" class="filter-form">
              <div class="filter-grid">
                <div class="filter-group"><label>Search</label><input type="text" name="q" value="${escapeHtml(query.q || '')}" placeholder="Search..." class="filter-input"></div>
                <div class="filter-group"><label>Location</label><select name="location" class="filter-select"><option value="">All Locations</option>${locOptions}</select></div>
                <div class="filter-group"><label>Type</label><select name="type" class="filter-select"><option value="">All Types</option>${typeOptions}</select></div>
                <div class="filter-group"><label>Bedrooms</label><select name="bedrooms" class="filter-select"><option value="">Any Beds</option><option value="1" ${query.bedrooms==='1'?'selected':''}>1 Bed</option><option value="2" ${query.bedrooms==='2'?'selected':''}>2 Beds</option><option value="3" ${query.bedrooms==='3'?'selected':''}>3 Beds</option><option value="4+" ${query.bedrooms==='4+'?'selected':''}>4+ Beds</option></select></div>
                <div class="filter-group"><label>Budget (Max)</label><select name="max_price" class="filter-select"><option value="">Any</option><option value="2500000" ${query.max_price==='2500000'?'selected':''}>AED 2.5M</option><option value="5000000" ${query.max_price==='5000000'?'selected':''}>AED 5.0M</option><option value="10000000" ${query.max_price==='10000000'?'selected':''}>AED 10M</option></select></div>
                <div class="filter-group"><label>Sort</label><select name="sort" class="filter-select"><option value="newest">Newest First</option><option value="price_asc" ${query.sort==='price_asc'?'selected':''}>Price: Low to High</option><option value="price_desc" ${query.sort==='price_desc'?'selected':''}>Price: High to Low</option></select></div>
              </div>
              <div class="filter-actions-row">
                <button type="submit" class="btn-primary-pill"><i class="fa-solid fa-filter"></i> Apply Filters</button>
                <a href="${pathname}" class="btn-clear-filters"><i class="fa-solid fa-rotate-left"></i> Reset</a>
              </div>
            </form>
          </div>

          <div class="listing-meta-bar">
            <div>Showing <strong>${list.length}</strong> verified properties</div>
          </div>

          ${cardsHtml ? `<div class="properties-grid">${cardsHtml}</div>` : `<div class="no-results-box"><i class="fa-solid fa-magnifying-glass no-results-icon"></i><h3>No properties found matching your filter criteria.</h3><p>Try adjusting your search filters or browse all listings.</p><a href="/properties" class="btn-primary-pill">View All Properties</a></div>`}
        </div>
      </section>
    `;

    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage(pageTitle, html, navActive));
  }

  // 6.3 SINGLE PROPERTY DETAILS (/property/:slug)
  if (pathname.startsWith('/property/')) {
    const slug = pathname.replace('/property/', '');
    const prop = db.properties.find(p => p.slug === slug || String(p.id) === slug);
    if (!prop) {
      res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderPage('Property Not Found', `<div class="container section-padding text-center"><h1>Property Not Found</h1><p>The requested listing could not be found.</p><a href="/properties" class="btn-primary-pill">Return to Listings</a></div>`));
    }

    const loc = db.locations.find(l => l.id == prop.location_id) || {};
    const type = db.property_types.find(t => t.id == prop.property_type_id) || {};
    const agent = (db.agents || []).find(a => a.id == prop.agent_id);
    const similar = db.properties.filter(p => p.id !== prop.id && (p.location_id == prop.location_id || p.property_type_id == prop.property_type_id)).slice(0, 3);
    const similarCards = similar.map(renderPropertyCard).join('');

    const amenitiesList = (prop.amenities || [1,2,3,4,5,6]).map(id => {
      const a = db.amenities.find(item => item.id == id);
      return a ? `<div class="amenity-item"><i class="fa-solid ${a.icon}"></i> <span>${escapeHtml(a.name)}</span></div>` : '';
    }).join('');

    const html = `
      <div class="property-detail-header-bar">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li><a href="/properties">Properties</a></li><li><a href="/locations/${loc.slug}">${escapeHtml(loc.name || 'Dubai')}</a></li><li aria-current="page">${escapeHtml(prop.title)}</li></ol></nav>
        </div>
      </div>

      <article class="property-detail-page section-padding">
        <div class="container">
          <div class="property-title-price-row">
            <div class="property-title-col">
              <div class="property-badges-meta">
                <span class="badge-status">${prop.listing_type.toUpperCase()}</span>
                <span class="ref-code">Ref: ${escapeHtml(prop.reference_code)}</span>
                <span class="rera-badge"><i class="fa-solid fa-certificate"></i> RERA: ${escapeHtml(prop.rera_permit || 'DLD-749210-2025')}</span>
              </div>
              <h1 class="single-property-title">${escapeHtml(prop.title)}</h1>
              <div class="single-property-location"><i class="fa-solid fa-location-dot"></i> <span>${escapeHtml(prop.address || loc.name + ', Dubai')}</span></div>
            </div>
            <div class="property-price-col">
              <div class="price-label">Asking Price</div>
              <div class="single-property-price">${formatPrice(prop.price, prop.currency)}</div>
            </div>
          </div>

          <div class="property-gallery-wrap">
            <div class="main-gallery-viewport">
              <img id="mainGalleryImg" src="${prop.featured_image}" alt="${escapeHtml(prop.title)}" class="main-featured-photo">
            </div>
            <div class="gallery-thumbs-row">
              <button type="button" class="thumb-btn active" onclick="document.getElementById('mainGalleryImg').src='${prop.featured_image}'"><img src="${prop.featured_image}"></button>
              <button type="button" class="thumb-btn" onclick="document.getElementById('mainGalleryImg').src='/assets/images/hero-building.jpg'"><img src="/assets/images/hero-building.jpg"></button>
              <button type="button" class="thumb-btn" onclick="document.getElementById('mainGalleryImg').src='/assets/images/burj-skyline.jpg'"><img src="/assets/images/burj-skyline.jpg"></button>
            </div>
          </div>

          <div class="property-layout-grid">
            <div class="property-main-col">
              <div class="property-specs-grid">
                <div class="spec-box"><i class="fa-solid fa-bed spec-icon"></i><div class="spec-data"><span class="spec-value">${prop.bedrooms || '—'}</span><span class="spec-name">Bedrooms</span></div></div>
                <div class="spec-box"><i class="fa-solid fa-bath spec-icon"></i><div class="spec-data"><span class="spec-value">${prop.bathrooms || '—'}</span><span class="spec-name">Bathrooms</span></div></div>
                <div class="spec-box"><i class="fa-solid fa-ruler-combined spec-icon"></i><div class="spec-data"><span class="spec-value">${Number(prop.area_sqft).toLocaleString()}</span><span class="spec-name">Sq. Ft.</span></div></div>
                <div class="spec-box"><i class="fa-solid fa-building spec-icon"></i><div class="spec-data"><span class="spec-value">${escapeHtml(type.name || 'Unit')}</span><span class="spec-name">Property Type</span></div></div>
              </div>

              <div class="property-section-block">
                <h2 class="block-title">Overview &amp; Property Details</h2>
                <div class="property-desc-text" style="white-space: pre-line;">${escapeHtml(prop.description)}</div>
              </div>

              <div class="property-section-block">
                <h2 class="block-title">Amenities &amp; Features</h2>
                <div class="amenities-badge-grid">${amenitiesList}</div>
              </div>

              <div class="property-assurance-card">
                <div class="assurance-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="assurance-content">
                  <h4>Verified by DRL Dwarika Real Estate LLC</h4>
                  <p>Inspected with official title deed and approved under DLD / RERA ORN ${escapeHtml(db.settings.rera_orn)}.</p>
                </div>
              </div>
            </div>

            <div class="property-sidebar-col">
              ${agent ? `
                <div class="property-agent-sidebar-badge" style="background:#fff; border:1px solid #E2EBF2; border-radius:18px; padding:20px; margin-bottom:20px; display:flex; gap:16px; align-items:center; box-shadow:0 6px 18px rgba(15,30,46,0.04);">
                  <img src="${agent.photo_url || '/assets/images/agents/omar-farooq.jpg'}" alt="${escapeHtml(agent.name)}" style="width:68px; height:68px; border-radius:50%; object-fit:cover; border:2px solid #1689CC; flex-shrink:0;">
                  <div style="flex:1;">
                    <span style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; color:#1689CC; font-weight:700;"><i class="fa-solid fa-award"></i> Listing Specialist</span>
                    <h4 style="margin:2px 0 4px 0; font-size:1.05rem;"><a href="/agents/${agent.slug}" style="color:#0F1E2E; text-decoration:none;">${escapeHtml(agent.name)}</a></h4>
                    <p style="margin:0 0 10px 0; font-size:0.8rem; color:#64748B;">${escapeHtml(agent.designation)} ${agent.rera_brn ? `&bull; BRN ${escapeHtml(agent.rera_brn)}` : ''}</p>
                    <div style="display:flex; gap:8px;">
                      <a href="tel:${(agent.phone || '').replace(/[^0-9+]/g, '')}" class="btn-icon" title="Call Agent" style="width:34px; height:34px; border-radius:50%; background:#F0F7FC; color:#1689CC; display:inline-flex; align-items:center; justify-content:center;"><i class="fa-solid fa-phone" style="font-size:0.85rem;"></i></a>
                      <a href="https://wa.me/${agent.whatsapp}?text=Hello%20${encodeURIComponent(agent.name)},%20I%20am%20inquiring%20about%20${encodeURIComponent(prop.title)}" target="_blank" rel="noopener" class="btn-icon" title="WhatsApp Agent" style="width:34px; height:34px; border-radius:50%; background:#25D366; color:#fff; display:inline-flex; align-items:center; justify-content:center;"><i class="fa-brands fa-whatsapp" style="font-size:0.9rem;"></i></a>
                      <a href="/agents/${agent.slug}" style="font-size:0.82rem; color:#1689CC; font-weight:600; align-self:center; margin-left:auto; text-decoration:none;">Profile &rarr;</a>
                    </div>
                  </div>
                </div>
              ` : ''}
              <div class="sticky-sidebar-card">
                <h3 class="inquiry-title">Inquire About This Property</h3>
                <p class="inquiry-subtitle">Book a private viewing or request the investor pack.</p>
                <form action="/enquiry/submit" method="POST" id="propertyInquiryForm">
                  <input type="hidden" name="property_id" value="${prop.id}">
                  <input type="hidden" name="subject" value="Inquiry: ${escapeHtml(prop.title)}">
                  <div class="form-group"><label>Full Name *</label><input type="text" name="name" class="form-input" required placeholder="John Doe"></div>
                  <div class="form-group"><label>Phone / WhatsApp *</label><input type="tel" name="phone" class="form-input" required placeholder="+971 542202920"></div>
                  <div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-input" placeholder="john@example.com"></div>
                  <div class="form-group"><label>Message</label><textarea name="message" rows="3" class="form-textarea" placeholder="I am interested in scheduling a viewing..."></textarea></div>
                  <button type="submit" class="btn-primary-pill full-width"><span>Send Inquiry</span> <i class="fa-solid fa-paper-plane"></i></button>
                </form>

                <div class="quick-direct-contacts">
                  <a href="https://wa.me/${db.settings.company_whatsapp}?text=Hello%20Dwarika%20Real%20Estate,%20I%20am%20interested%20in%20${encodeURIComponent(prop.title)}" target="_blank" rel="noopener" class="btn-whatsapp-direct">
                    <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
                  </a>
                  <a href="tel:${db.settings.company_phone.replace(/[^0-9+]/g, '')}" class="btn-call-direct">
                    <i class="fa-solid fa-phone"></i> Call Brokerage Desk
                  </a>
                </div>
              </div>
            </div>
          </div>

          ${similarCards ? `
            <div class="similar-properties-block section-padding-top">
              <div class="section-header"><span class="section-badge">— SIMILAR LISTINGS —</span><h2 class="section-title">Properties You May Also Like</h2></div>
              <div class="properties-grid">${similarCards}</div>
            </div>
          ` : ''}
        </div>
      </article>

      <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "SingleFamilyResidence",
        "name": ${JSON.stringify(prop.title)},
        "description": ${JSON.stringify(prop.description.substring(0, 150))},
        "image": ${JSON.stringify(prop.featured_image)},
        "offers": { "@type": "Offer", "price": ${prop.price}, "priceCurrency": "AED" }
      }
      </script>
    `;

    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage(prop.title + ' | DRL Dwarika', html, 'properties'));
  }

  // 6.4 SERVICES HUB & INDIVIDUAL SERVICES
  if (pathname === '/services') {
    const srvCards = db.services.map(s => `
      <div class="service-large-card" style="background:#fff; border:1px solid #E2EBF2; border-radius:18px; padding:32px; margin-bottom:24px; display:flex; gap:24px; align-items:flex-start;">
        <div class="service-icon-circle" style="font-size:1.8rem;"><i class="fa-solid ${s.icon}"></i></div>
        <div>
          <h2 style="font-family:var(--font-heading); margin-bottom:8px;">${escapeHtml(s.title)}</h2>
          <p style="color:#64748B; margin-bottom:16px;">${escapeHtml(s.full_desc || s.short_desc)}</p>
          <a href="/services/${s.slug}" class="btn-primary-pill"><span>Explore Service</span> <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
    `).join('');

    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li aria-current="page">Services</li></ol></nav>
          <h1 class="page-banner-title">Our Real Estate Services</h1>
          <p class="page-banner-subtitle">From luxury home acquisitions to commercial advisory and high-yield portfolio allocation.</p>
        </div>
      </div>
      <section class="section-padding"><div class="container">${srvCards}</div></section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage('Services | DRL Dwarika Real Estate LLC', html, 'services'));
  }

  if (pathname.startsWith('/services/')) {
    const slug = pathname.replace('/services/', '');
    const srv = db.services.find(s => s.slug === slug);
    if (!srv) {
      res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderPage('Service Not Found', '<div class="container section-padding"><h1>Service Not Found</h1></div>'));
    }

    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li><a href="/services">Services</a></li><li aria-current="page">${escapeHtml(srv.title)}</li></ol></nav>
          <h1 class="page-banner-title">${escapeHtml(srv.title)}</h1>
          <p class="page-banner-subtitle">${escapeHtml(srv.short_desc)}</p>
        </div>
      </div>

      <section class="section-padding">
        <div class="container">
          <div class="property-layout-grid">
            <div>
              <h2 style="font-family:var(--font-heading); font-size:1.8rem; margin-bottom:14px;">Bespoke ${escapeHtml(srv.title)} in Dubai</h2>
              <div style="font-size:1.05rem; line-height:1.7; color:#475569; margin-bottom:24px;">${escapeHtml(srv.full_desc || srv.short_desc)}</div>
              
              <div class="property-assurance-card">
                <div class="assurance-icon"><i class="fa-solid fa-award"></i></div>
                <div>
                  <h4>Professional Regulatory Guidance</h4>
                  <p>Our advisors are licensed by RERA and work in close coordination with the Dubai Land Department.</p>
                </div>
              </div>
            </div>

            <div>
              <div class="sticky-sidebar-card">
                <h3 class="inquiry-title">Consult a Specialist</h3>
                <p class="inquiry-subtitle">Book a private consultation regarding ${escapeHtml(srv.title)}.</p>
                <form action="/enquiry/submit" method="POST" id="mainContactForm">
                  <input type="hidden" name="service_id" value="${srv.id}">
                  <input type="hidden" name="subject" value="Service Inquiry: ${escapeHtml(srv.title)}">
                  <div class="form-group"><label>Full Name *</label><input type="text" name="name" class="form-input" required placeholder="John Doe"></div>
                  <div class="form-group"><label>Phone / WhatsApp *</label><input type="tel" name="phone" class="form-input" required placeholder="+971 542202920"></div>
                  <div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-input" placeholder="john@example.com"></div>
                  <div class="form-group"><label>Requirements</label><textarea name="message" rows="3" class="form-textarea" placeholder="Tell us about your requirements..."></textarea></div>
                  <button type="submit" class="btn-primary-pill full-width"><span>Submit Request</span> <i class="fa-solid fa-paper-plane"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage(`${srv.title} | DRL Dwarika Real Estate LLC`, html, 'services'));
  }

  // 6.5 ABOUT US
  if (pathname === '/about-us') {
    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li aria-current="page">About Us</li></ol></nav>
          <h1 class="page-banner-title">About Dwarika Real Estate LLC</h1>
          <p class="page-banner-subtitle">Opening Doors To Prosperity — Guiding global property seekers, families, and international investors through the dynamic landscape of Dubai real estate.</p>
        </div>
      </div>

      <section class="section-padding">
        <div class="container about-container">
          <div class="about-media-col">
            <div class="about-image-card">
              <img src="/assets/images/burj-skyline.jpg" alt="Dubai Downtown Skyline" class="about-img">
              <div class="handwritten-sticker"><span>Your Trusted<br>Real Estate Partner<br>in Dubai</span></div>
            </div>
          </div>
          <div class="about-text-col">
            <span class="section-badge">— OUR STORY &amp; MISSION —</span>
            <h2 class="section-title">Building Dreams,<br>One Property at a Time</h2>
            <p class="about-paragraph">
              DRL Dwarika Real Estate LLC is an officially licensed Dubai real estate brokerage (RERA ORN: ${escapeHtml(db.settings.rera_orn)}), established with a single foundational vision: to deliver world-class real estate services anchored in transparency, deep market knowledge, and unyielding client dedication.
            </p>
            <p class="about-paragraph">
              Headquartered in Business Bay, Dubai, we serve high-net-worth individuals, first-time home buyers, and institutional capital allocators worldwide. Our multilingual advisory team possesses granular fluency in Dubai’s premier freehold zones.
            </p>
            <div class="about-stats-row">
              <div class="stat-card"><div class="stat-number">${escapeHtml(db.settings.stat_properties_sold)}</div><div class="stat-label">Properties Sold</div></div>
              <div class="stat-divider"></div>
              <div class="stat-card"><div class="stat-number">${escapeHtml(db.settings.stat_happy_clients)}</div><div class="stat-label">Happy Clients</div></div>
              <div class="stat-divider"></div>
              <div class="stat-card"><div class="stat-number">${escapeHtml(db.settings.stat_years_experience)}</div><div class="stat-label">Years Experience</div></div>
            </div>
          </div>
        </div>
      </section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage('About Us | DRL Dwarika Real Estate LLC', html, 'about'));
  }

  // 6.5.1 FOUNDERS & CORPORATE LEADERSHIP (/founders)
  if (pathname === '/founders') {
    const founders = db.founders || [];

    const foundersEditorialHtml = founders.map((f, idx) => {
      const isDraft = f.status === 'draft';
      const leadershipBadges = (f.leadership_areas || 'Corporate Governance').split(',').map(s => `<span class="founder-focus-pill"><i class="fa-solid fa-check"></i> ${escapeHtml(s.trim())}</span>`).join('');

      return `
        <article class="founder-editorial-card ${idx % 2 === 1 ? 'reverse-card' : ''}" id="founder-${f.id}">
          <div class="founder-media-column">
            <div class="founder-photo-frame">
              ${f.photo_url ? `
                <img src="${f.photo_url}" alt="${escapeHtml(f.name)}" loading="lazy" class="founder-portrait-img">
              ` : `
                <div class="founder-crest-placeholder">
                  <div class="crest-shield"><i class="fa-solid fa-landmark"></i></div>
                  <div class="crest-title">DRL DWARIKA</div>
                  <div class="crest-subtitle">Executive Leadership</div>
                  <div class="crest-orn">RERA ORN ${escapeHtml(db.settings.rera_orn)}</div>
                </div>
              `}
              <div class="founder-title-ribbon">
                <span>${escapeHtml(f.designation)}</span>
              </div>
            </div>

            ${isDraft ? `
              <div class="compliance-draft-notice">
                <i class="fa-solid fa-clipboard-check"></i>
                <div class="notice-text">
                  <strong>Verification in Progress</strong>
                  <span>Official credentials undergoing certification by company administration.</span>
                </div>
              </div>
            ` : ''}
          </div>

          <div class="founder-content-column">
            <div class="founder-header-meta">
              <span class="founder-designation-badge">${escapeHtml(f.designation)}</span>
              <h2 class="founder-name">${escapeHtml(f.name)}</h2>
              ${f.background ? `<p class="founder-background-line"><i class="fa-solid fa-briefcase"></i> ${escapeHtml(f.background)}</p>` : ''}
            </div>

            <div class="founder-bio-text" style="white-space:pre-line;">
              ${escapeHtml(f.full_bio || f.short_bio || '')}
            </div>

            <div class="founder-leadership-focus">
              <h4 class="focus-title">Areas of Executive Leadership</h4>
              <div class="focus-pills-wrap">
                ${leadershipBadges}
              </div>
            </div>

            ${f.quote ? `
              <div class="founder-quote-callout">
                <i class="fa-solid fa-quote-left quote-icon"></i>
                <blockquote class="founder-quote-text">&ldquo;${escapeHtml(f.quote)}&rdquo;</blockquote>
                <div class="quote-author-tag">— Executive Leadership Philosophy</div>
              </div>
            ` : ''}

            <div class="founder-contact-actions">
              ${f.email ? `<a href="mailto:${escapeHtml(f.email)}" class="btn-founder-contact"><i class="fa-solid fa-envelope"></i> <span>Executive Desk</span></a>` : ''}
              ${f.linkedin_url ? `<a href="${escapeHtml(f.linkedin_url)}" target="_blank" rel="noopener" class="btn-founder-contact linkedin"><i class="fa-brands fa-linkedin"></i> <span>LinkedIn</span></a>` : ''}
              <a href="/contact-us" class="btn-founder-contact primary"><i class="fa-solid fa-calendar-check"></i> <span>Schedule Corporate Meeting</span></a>
            </div>
          </div>
        </article>
      `;
    }).join('');

    const html = `
      <!-- Distinctive Leadership Hero Section -->
      <section class="founders-hero-section">
        <div class="founders-hero-bg-overlay"></div>
        <div class="container founders-hero-container">
          <nav class="breadcrumb-nav white-breadcrumbs" aria-label="Breadcrumb">
            <ol class="breadcrumb-list">
              <li><a href="/">Home</a></li>
              <li><a href="/about-us">About Us</a></li>
              <li aria-current="page">Founders &amp; Leadership</li>
            </ol>
          </nav>

          <div class="founders-hero-badge-wrap">
            <span class="founders-hero-badge">
              <i class="fa-solid fa-landmark"></i> CORPORATE GOVERNANCE &amp; EXECUTIVE LEADERSHIP
            </span>
          </div>

          <h1 class="founders-hero-title">
            The Visionaries Behind<br>DRL Dwarika Real Estate LLC
          </h1>

          <p class="founders-hero-lead">
            Founded with a commitment to integrity, transparency, and market acumen, our leadership steers DRL Dwarika Real Estate LLC as a trusted pillar in Dubai’s premier property landscape.
          </p>

          <div class="founders-hero-stats">
            <div class="hero-stat-item">
              <span class="hero-stat-val">RERA ${escapeHtml(db.settings.rera_orn)}</span>
              <span class="hero-stat-lbl">Licensed Brokerage</span>
            </div>
            <div class="hero-stat-sep"></div>
            <div class="hero-stat-item">
              <span class="hero-stat-val">Business Bay</span>
              <span class="hero-stat-lbl">Dubai Headquarters</span>
            </div>
            <div class="hero-stat-sep"></div>
            <div class="hero-stat-item">
              <span class="hero-stat-val">100% Freehold</span>
              <span class="hero-stat-lbl">Dubai Market Focus</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Foundational Pillars Section -->
      <section class="section-padding founders-vision-section">
        <div class="container">
          <div class="section-header text-center">
            <span class="section-badge">— OUR FOUNDATIONAL PILLARS —</span>
            <h2 class="section-title">Vision, Mission &amp; Guiding Principles</h2>
            <p class="section-subtitle">The enduring values shaping every client relationship and investment advisory at DRL Dwarika.</p>
          </div>

          <div class="pillars-grid">
            <div class="pillar-card vision-card">
              <div class="pillar-icon-wrap"><i class="fa-solid fa-compass"></i></div>
              <h3 class="pillar-title">Corporate Vision</h3>
              <p class="pillar-text">
                To stand as Dubai’s most transparent and respected real estate advisory institution, renowned worldwide for safeguarding client capital, unlocking generational prosperity, and fostering lasting partnerships across the UAE.
              </p>
            </div>

            <div class="pillar-card mission-card">
              <div class="pillar-icon-wrap"><i class="fa-solid fa-bullseye"></i></div>
              <h3 class="pillar-title">Corporate Mission</h3>
              <p class="pillar-text">
                Opening doors to prosperity by equipping global property seekers and institutional allocators with rigorous market data, authentic off-market inventory, and end-to-end conveyance security under Dubai Land Department frameworks.
              </p>
            </div>

            <div class="pillar-card values-card">
              <div class="pillar-icon-wrap"><i class="fa-solid fa-scale-balanced"></i></div>
              <h3 class="pillar-title">Core Values</h3>
              <ul class="pillar-values-list">
                <li><i class="fa-solid fa-circle-check"></i> <strong>Integrity &amp; Candor:</strong> Uncompromising fiduciary ethics in every transaction.</li>
                <li><i class="fa-solid fa-circle-check"></i> <strong>Market Acumen:</strong> Deep data analytics over promotional hyperbole.</li>
                <li><i class="fa-solid fa-circle-check"></i> <strong>Client-Centricity:</strong> Long-term investor capital protection above all.</li>
                <li><i class="fa-solid fa-circle-check"></i> <strong>Regulatory Excellence:</strong> Strict compliance with DLD &amp; RERA frameworks.</li>
              </ul>
            </div>

            <div class="pillar-card philosophy-card">
              <div class="pillar-icon-wrap"><i class="fa-solid fa-lightbulb"></i></div>
              <h3 class="pillar-title">Leadership Philosophy</h3>
              <p class="pillar-text">
                Real estate leadership is defined not by transaction volume alone, but by the trust earned when navigating clients through pivotal financial decisions. We build enduring institutions through meticulous stewardship and authentic human relationships.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Founders Profiles Editorial Section -->
      <section class="section-padding founders-profiles-section surface-bg">
        <div class="container">
          <div class="section-header text-center">
            <span class="section-badge">— EXECUTIVE LEADERSHIP —</span>
            <h2 class="section-title">Founders &amp; Managing Directors</h2>
            <p class="section-subtitle">Guiding strategic direction, institutional alliances, and transaction integrity across DRL Dwarika Real Estate LLC.</p>
          </div>

          <div class="founders-editorial-list">
            ${foundersEditorialHtml}
          </div>
        </div>
      </section>

      <!-- Institutional Closing CTA -->
      <section class="founders-closing-cta">
        <div class="container">
          <div class="cta-inner-card">
            <div class="cta-content-col">
              <span class="cta-mini-tag">PARTNER WITH LEADERSHIP</span>
              <h2 class="cta-main-title">Direct Executive &amp; Institutional Advisory</h2>
              <p class="cta-description">
                For family offices, fund allocators, and prospective strategic partners seeking private consultation with the leadership of DRL Dwarika Real Estate LLC.
              </p>
            </div>
            <div class="cta-actions-col">
              <a href="/contact-us" class="btn-primary-pill white-bg">
                <span>Contact Executive Desk</span>
                <i class="fa-solid fa-arrow-right"></i>
              </a>
              <a href="tel:${db.settings.company_phone.replace(/[^0-9+]/g, '')}" class="btn-outline-pill white-border">
                <i class="fa-solid fa-phone"></i>
                <span>Direct Office Line</span>
              </a>
            </div>
          </div>
        </div>
      </section>
    `;

    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage('Founders & Executive Leadership | DRL Dwarika Real Estate LLC', html, 'founders', {
      description: 'Corporate leadership, executive vision, mission, and guiding philosophy of DRL Dwarika Real Estate LLC Dubai.'
    }));
  }

  // 6.5.2 AGENTS DIRECTORY (/agents)
  if (pathname === '/agents') {
    let list = (db.agents || []).filter(a => a.status === 'active');

    // Filters
    const searchQuery = (query.search || query.q || '').trim().toLowerCase();
    const specFilter = (query.specialization || 'all').trim().toLowerCase();
    const langFilter = (query.language || 'all').trim();
    const locFilter = (query.location || 'all').trim();

    if (searchQuery) {
      list = list.filter(a => 
        a.name.toLowerCase().includes(searchQuery) ||
        (a.designation && a.designation.toLowerCase().includes(searchQuery)) ||
        (a.short_bio && a.short_bio.toLowerCase().includes(searchQuery)) ||
        (a.specializations && a.specializations.some(s => s.toLowerCase().includes(searchQuery)))
      );
    }

    if (specFilter && specFilter !== 'all') {
      list = list.filter(a => a.specializations && a.specializations.includes(specFilter));
    }

    if (langFilter && langFilter !== 'all') {
      list = list.filter(a => a.languages && a.languages.includes(langFilter));
    }

    if (locFilter && locFilter !== 'all') {
      list = list.filter(a => a.locations && a.locations.includes(locFilter));
    }

    const totalFiltered = list.length;

    // Pagination (6 per page)
    const perPage = 6;
    const currentPage = Math.max(1, parseInt(query.page) || 1);
    const totalPages = Math.ceil(totalFiltered / perPage) || 1;
    const startIndex = (currentPage - 1) * perPage;
    const paginatedAgents = list.slice(startIndex, startIndex + perPage);

    const cardsHtml = paginatedAgents.map(renderAgentCard).join('');

    // Filter Options
    const specOptions = [
      { val: 'all', label: 'All Specializations' },
      { val: 'residential', label: 'Residential' },
      { val: 'commercial', label: 'Commercial' },
      { val: 'luxury', label: 'Luxury Estates' },
      { val: 'rental', label: 'Rental Properties' },
      { val: 'off-plan', label: 'Off-Plan Projects' },
      { val: 'investment', label: 'Investment Advisory' }
    ].map(o => `<option value="${o.val}" ${specFilter === o.val ? 'selected' : ''}>${o.label}</option>`).join('');

    const allLangs = Array.from(new Set((db.agents || []).flatMap(a => a.languages || [])));
    const langOptions = ['<option value="all">All Languages</option>'].concat(allLangs.map(l => `<option value="${escapeHtml(l)}" ${langFilter === l ? 'selected' : ''}>${escapeHtml(l)}</option>`)).join('');

    const allLocs = Array.from(new Set((db.agents || []).flatMap(a => a.locations || [])));
    const locOptions = ['<option value="all">All Communities</option>'].concat(allLocs.map(l => `<option value="${escapeHtml(l)}" ${locFilter === l ? 'selected' : ''}>${escapeHtml(l)}</option>`)).join('');

    let paginationHtml = '';
    if (totalPages > 1) {
      paginationHtml += '<div class="pagination-wrap" style="display:flex; justify-content:center; gap:8px; margin-top:40px;">';
      for (let i = 1; i <= totalPages; i++) {
        const queryParams = new URLSearchParams(query);
        queryParams.set('page', i);
        paginationHtml += `<a href="/agents?${queryParams.toString()}" class="page-num-btn ${i === currentPage ? 'active' : ''}">${i}</a>`;
      }
      paginationHtml += '</div>';
    }

    const isFiltered = searchQuery || (specFilter !== 'all') || (langFilter !== 'all') || (locFilter !== 'all');

    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav" aria-label="Breadcrumb">
            <ol class="breadcrumb-list">
              <li><a href="/">Home</a></li>
              <li aria-current="page">Our Agents</li>
            </ol>
          </nav>
          <span class="banner-pill-badge"><i class="fa-solid fa-certificate"></i> RERA LICENSED &amp; DLD ACCREDITED</span>
          <h1 class="page-banner-title">Meet Our Dubai Property Specialists</h1>
          <p class="page-banner-subtitle">
            Our licensed, multilingual real estate consultants provide transparent advisory, private off-market allocations, and bespoke investment portfolio management.
          </p>
        </div>
      </div>

      <section class="section-padding surface-bg">
        <div class="container">
          <div class="agents-filter-card">
            <form action="/agents" method="GET" class="agents-filter-form" id="agentFilterForm">
              <div class="filter-grid-row">
                <div class="filter-col search-col">
                  <label for="agentSearchInput" class="filter-label"><i class="fa-solid fa-magnifying-glass"></i> Search Agent</label>
                  <input type="text" name="search" id="agentSearchInput" value="${escapeHtml(searchQuery)}" placeholder="Search by agent name, title..." class="filter-input-field">
                </div>
                <div class="filter-col">
                  <label for="agentSpecSelect" class="filter-label"><i class="fa-solid fa-layer-group"></i> Specialization</label>
                  <select name="specialization" id="agentSpecSelect" class="filter-select-field">
                    ${specOptions}
                  </select>
                </div>
                <div class="filter-col">
                  <label for="agentLangSelect" class="filter-label"><i class="fa-solid fa-language"></i> Language</label>
                  <select name="language" id="agentLangSelect" class="filter-select-field">
                    ${langOptions}
                  </select>
                </div>
                <div class="filter-col">
                  <label for="agentLocSelect" class="filter-label"><i class="fa-solid fa-map-pin"></i> Community</label>
                  <select name="location" id="agentLocSelect" class="filter-select-field">
                    ${locOptions}
                  </select>
                </div>
                <div class="filter-col-actions">
                  <button type="submit" class="btn-filter-apply" id="btnFilterApply">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                  </button>
                  ${isFiltered ? `<a href="/agents" class="btn-filter-reset" title="Clear all filters"><i class="fa-solid fa-rotate-left"></i></a>` : ''}
                </div>
              </div>
            </form>
          </div>

          <div class="catalog-results-header">
            <div class="results-count-text">
              Showing <strong>${paginatedAgents.length}</strong> of <strong>${totalFiltered}</strong> certified real estate advisors
            </div>
            ${isFiltered ? `<div class="active-filter-indicator">Filtered Results (${totalFiltered} found) <a href="/agents" class="clear-indicator">Reset</a></div>` : ''}
          </div>

          ${cardsHtml ? `
            <div class="agents-grid">
              ${cardsHtml}
            </div>
            ${paginationHtml}
          ` : `
            <div class="no-agents-found">
              <div class="no-results-icon"><i class="fa-solid fa-users-slash"></i></div>
              <h3>No advisors found matching your criteria</h3>
              <p>Try resetting your search filters or browse our full advisory team directory.</p>
              <a href="/agents" class="btn-primary-pill">View All Agents</a>
            </div>
          `}
        </div>
      </section>

      <!-- Clear Property Enquiry / Agent Matchmaker CTA -->
      <section class="section-padding" style="background:#fff; border-top:1px solid #E2EBF2;">
        <div class="container text-center" style="max-width:760px; margin:0 auto;">
          <span class="section-badge">— BESPOKE PROPERTY ADVISORY —</span>
          <h2 class="section-title">Need Guidance Finding the Right Agent?</h2>
          <p style="color:#64748B; font-size:1.05rem; line-height:1.7; margin-bottom:28px;">
            Whether you are evaluating luxury golf villas, high-yielding Downtown apartments, or off-plan pre-allocations, our client desk matches you directly with the specialist possessing verified expertise in your target asset class.
          </p>
          <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
            <a href="/contact-us" class="btn-primary-pill"><span>Request Specialist Matching</span> <i class="fa-solid fa-arrow-right"></i></a>
            <a href="https://wa.me/${db.settings.company_whatsapp}?text=Hello%20DRL%20Dwarika,%20I%20would%20like%20to%20be%20connected%20with%20a%20property%20specialist." target="_blank" rel="noopener" class="btn-outline-pill"><i class="fa-brands fa-whatsapp"></i> <span>Chat with Advisory Desk</span></a>
          </div>
        </div>
      </section>
    `;

    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage('Our Licensed Agents & Property Advisors | DRL Dwarika Real Estate LLC', html, 'agents', {
      description: 'Meet our certified RERA real estate specialists at DRL Dwarika Real Estate LLC. Multilingual advisors in Dubai Hills, Downtown, Palm Jumeirah and luxury UAE properties.'
    }));
  }

  // 6.5.3 INDIVIDUAL AGENT PROFILE (/agents/:slug)
  if (pathname.startsWith('/agents/')) {
    const slug = pathname.replace('/agents/', '').replace(/\/$/, '');
    const agent = (db.agents || []).find(a => a.slug === slug || String(a.id) === slug);
    if (!agent) {
      res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderPage('Agent Profile Not Found', `
        <div class="container section-padding text-center">
          <h1 style="font-size:2.4rem; font-family:var(--font-heading); color:#0F1E2E; margin-bottom:12px;">Agent Profile Not Found</h1>
          <p style="color:#64748B; margin-bottom:24px;">The property consultant you are looking for is not listed or has moved.</p>
          <a href="/agents" class="btn-primary-pill">Return to Agents Directory</a>
        </div>
      `));
    }

    const assignedProps = (db.properties || []).filter(p => p.agent_id == agent.id && p.status === 'published');
    const assignedCards = assignedProps.map(renderPropertyCard).join('');

    const photo = agent.photo_url || '/assets/images/agents/omar-farooq.jpg';
    const cleanPhone = (agent.phone || '+971 542202920').replace(/[^0-9+]/g, '');
    const wa = (agent.whatsapp || '971542202920').replace(/[^0-9]/g, '');

    const specsPills = (agent.specializations || []).map(s => `
      <div class="spec-tag-card">
        <i class="fa-solid fa-circle-check"></i>
        <span>${escapeHtml(s.charAt(0).toUpperCase() + s.slice(1))}</span>
      </div>
    `).join('');

    const langsPills = (agent.languages || []).map(l => `
      <div class="lang-tag-pill">
        <i class="fa-solid fa-language"></i>
        <span>${escapeHtml(l)}</span>
      </div>
    `).join('');

    const locsPills = (agent.locations || []).map(loc => `
      <div class="location-tag-pill">
        <i class="fa-solid fa-map-pin"></i>
        <span>${escapeHtml(loc)}</span>
      </div>
    `).join('');

    const hasTestimonial = Boolean(agent.testimonial_quote && agent.testimonial_client);

    const html = `
      <div class="agent-profile-banner">
        <div class="container">
          <nav class="breadcrumb-nav" aria-label="Breadcrumb">
            <ol class="breadcrumb-list">
              <li><a href="/">Home</a></li>
              <li><a href="/agents">Agents</a></li>
              <li aria-current="page">${escapeHtml(agent.name)}</li>
            </ol>
          </nav>

          <div class="agent-hero-card">
            <div class="agent-hero-media">
              <img src="${photo}" alt="${escapeHtml(agent.name)}" width="280" height="280" class="agent-hero-avatar">
              <div class="agent-verified-badge">
                <i class="fa-solid fa-circle-check"></i> Verified RERA Agent
              </div>
            </div>

            <div class="agent-hero-details">
              <div class="agent-hero-badges">
                ${agent.rera_brn ? `<span class="hero-pill-badge"><i class="fa-solid fa-id-badge"></i> RERA BRN: ${escapeHtml(agent.rera_brn)}</span>` : ''}
                ${agent.experience ? `<span class="hero-pill-badge accent"><i class="fa-solid fa-award"></i> ${escapeHtml(agent.experience)}</span>` : ''}
              </div>

              <h1 class="agent-hero-name">${escapeHtml(agent.name)}</h1>
              <p class="agent-hero-title">${escapeHtml(agent.designation)} at DRL Dwarika Real Estate LLC</p>
              <p class="agent-hero-summary">${escapeHtml(agent.short_bio || '')}</p>

              <div class="agent-hero-contact-bar">
                <a href="tel:${cleanPhone}" class="btn-hero-contact call">
                  <i class="fa-solid fa-phone"></i>
                  <span>Call ${escapeHtml(agent.phone || '')}</span>
                </a>
                <a href="https://wa.me/${wa}?text=Hello%20${encodeURIComponent(agent.name)},%20I%20am%20inquiring%20about%20properties%20via%20DRL%20Dwarika." target="_blank" rel="noopener" class="btn-hero-contact whatsapp">
                  <i class="fa-brands fa-whatsapp"></i>
                  <span>Chat on WhatsApp</span>
                </a>
                <a href="mailto:${escapeHtml(agent.email)}" class="btn-hero-contact email">
                  <i class="fa-solid fa-envelope"></i>
                  <span>Email Agent</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <section class="section-padding">
        <div class="container">
          <div class="property-layout-grid">
            <div class="property-main-col">
              
              <div class="property-section-block">
                <h2 class="block-title">Professional Biography &amp; Experience</h2>
                <div class="agent-bio-body" style="font-size:1.05rem; line-height:1.75; color:#475569; white-space:pre-line;">
                  ${escapeHtml(agent.full_bio || agent.short_bio || '')}
                </div>
              </div>

              <div class="property-section-block">
                <h2 class="block-title">Areas of Expertise &amp; Specialization</h2>
                <div class="agent-spec-cards-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:12px; margin-bottom:24px;">
                  ${specsPills}
                </div>

                <div style="display:flex; flex-wrap:wrap; gap:20px; align-items:center; background:#F8FAFC; border:1px solid #E2EBF2; border-radius:14px; padding:18px 22px;">
                  <div style="flex:1; min-width:220px;">
                    <span style="display:block; font-size:0.8rem; font-weight:700; color:#1689CC; text-transform:uppercase; margin-bottom:8px;">Languages Spoken</span>
                    <div style="display:flex; flex-wrap:wrap; gap:8px;">${langsPills}</div>
                  </div>
                  <div style="flex:1; min-width:220px;">
                    <span style="display:block; font-size:0.8rem; font-weight:700; color:#1689CC; text-transform:uppercase; margin-bottom:8px;">Focus Communities</span>
                    <div style="display:flex; flex-wrap:wrap; gap:8px;">${locsPills}</div>
                  </div>
                </div>
              </div>

              ${hasTestimonial ? `
                <div class="property-section-block">
                  <h2 class="block-title">Client Recommendation &amp; Review</h2>
                  <div class="agent-testimonial-box" style="background:#F0F7FC; border-left:4px solid #1689CC; border-radius:14px; padding:24px 28px;">
                    <div style="color:#C5A880; font-size:1.2rem; margin-bottom:10px;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <blockquote style="font-size:1.05rem; font-style:italic; color:#0F1E2E; line-height:1.6; margin:0 0 12px 0;">
                      &ldquo;${escapeHtml(agent.testimonial_quote)}&rdquo;
                    </blockquote>
                    <div style="font-weight:700; color:#1689CC; font-size:0.95rem;">
                      ${escapeHtml(agent.testimonial_client)}
                    </div>
                  </div>
                </div>
              ` : ''}

              <div class="property-section-block">
                <div class="section-title-between" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                  <h2 class="block-title" style="margin:0;">Listings Assigned to ${escapeHtml(agent.name)} (${assignedProps.length})</h2>
                  <a href="/properties" style="font-size:0.9rem; color:#1689CC; font-weight:600; text-decoration:none;">Browse All Properties &rarr;</a>
                </div>

                ${assignedCards ? `
                  <div class="properties-grid">${assignedCards}</div>
                ` : `
                  <div style="background:#F8FAFC; border:1px dashed #CBD5E1; border-radius:14px; padding:32px; text-align:center;">
                    <i class="fa-solid fa-house-chimney" style="font-size:2rem; color:#94A3B8; margin-bottom:12px;"></i>
                    <h4 style="margin:0 0 6px 0; color:#0F1E2E;">Exclusive Listings Available on Request</h4>
                    <p style="color:#64748B; margin:0 0 16px 0; font-size:0.95rem;">This advisor specializes in off-market allocations and private client portfolios. Contact directly for upcoming availability.</p>
                    <a href="/contact-us" class="btn-primary-pill">Inquire for Off-Market Units</a>
                  </div>
                `}
              </div>

            </div>

            <div class="property-sidebar-col">
              <div class="sticky-sidebar-card">
                <h3 class="inquiry-title">Inquire with ${escapeHtml(agent.name)}</h3>
                <p class="inquiry-subtitle">Direct consultation on acquisitions, private viewings, or property sales in Dubai.</p>

                <form action="/enquiry/submit" method="POST" id="agentInquiryForm">
                  <input type="hidden" name="subject" value="Inquiry for Agent: ${escapeHtml(agent.name)}">
                  <div class="form-group"><label>Full Name *</label><input type="text" name="name" class="form-input" required placeholder="John Doe"></div>
                  <div class="form-group"><label>Phone / WhatsApp *</label><input type="tel" name="phone" class="form-input" required placeholder="+971 542202920"></div>
                  <div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-input" placeholder="john@example.com"></div>
                  <div class="form-group"><label>Your Message / Requirements *</label><textarea name="message" rows="3" class="form-textarea" required placeholder="I am interested in exploring properties with ${escapeHtml(agent.name)}..."></textarea></div>
                  <button type="submit" class="btn-primary-pill full-width"><span>Send Request to Agent</span> <i class="fa-solid fa-paper-plane"></i></button>
                </form>

                <div class="quick-direct-contacts">
                  <a href="https://wa.me/${wa}?text=Hello%20${encodeURIComponent(agent.name)},%20I%20am%20inquiring%20about%20properties%20via%20DRL%20Dwarika." target="_blank" rel="noopener" class="btn-whatsapp-direct">
                    <i class="fa-brands fa-whatsapp"></i> Chat with ${escapeHtml(agent.name.split(' ')[0])}
                  </a>
                  <a href="tel:${cleanPhone}" class="btn-call-direct">
                    <i class="fa-solid fa-phone"></i> Call Direct: ${escapeHtml(agent.phone || '')}
                  </a>
                </div>

                <div style="margin-top:20px; padding-top:16px; border-top:1px solid #E2EBF2; font-size:0.8rem; color:#64748B;">
                  <i class="fa-solid fa-shield-halved" style="color:#1689CC; margin-right:4px;"></i> Licensed under RERA ORN ${escapeHtml(db.settings.rera_orn)} | DLD Licensed Brokerage
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": ${JSON.stringify(agent.name)},
        "jobTitle": ${JSON.stringify(agent.designation)},
        "image": ${JSON.stringify('http://localhost:' + PORT + photo)},
        "telephone": ${JSON.stringify(agent.phone)},
        "email": ${JSON.stringify(agent.email)},
        "worksFor": {
          "@type": "RealEstateAgent",
          "name": "DRL Dwarika Real Estate LLC",
          "url": "http://localhost:" + PORT
        }
      }
      </script>
    `;

    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage(`${agent.name} — ${agent.designation} | DRL Dwarika Real Estate LLC`, html, 'agents', {
      description: `${agent.name} is a licensed ${agent.designation} at DRL Dwarika Real Estate LLC in Dubai. Contact for luxury villas, apartments, and off-plan investments.`
    }));
  }

  // 6.6 CONTACT US
  if (pathname === '/contact-us') {
    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li aria-current="page">Contact Us</li></ol></nav>
          <h1 class="page-banner-title">Contact Dwarika Real Estate LLC</h1>
          <p class="page-banner-subtitle">Get in touch with our team of luxury real estate consultants in Dubai. We are ready to assist you with inquiries, viewings, and property advisory.</p>
        </div>
      </div>

      <section class="section-padding">
        <div class="container">
          <div class="contact-layout-grid">
            <div class="contact-info-col">
              <div class="info-card">
                <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                <div class="info-details">
                  <h3>Direct Phone</h3>
                  <p>Speak directly with our client advisory desk.</p>
                  <a href="tel:${db.settings.company_phone.replace(/[^0-9+]/g, '')}" class="info-link">${escapeHtml(db.settings.company_phone)}</a>
                </div>
              </div>
              <div class="info-card">
                <div class="info-icon"><i class="fa-brands fa-whatsapp"></i></div>
                <div class="info-details">
                  <h3>WhatsApp Concierge</h3>
                  <p>Instant responses for property links &amp; viewings.</p>
                  <a href="https://wa.me/${db.settings.company_whatsapp}" target="_blank" rel="noopener" class="info-link">+${escapeHtml(db.settings.company_whatsapp)}</a>
                </div>
              </div>
              <div class="info-card">
                <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                <div class="info-details">
                  <h3>Email Desk</h3>
                  <p>Send detailed requirements or documentation.</p>
                  <a href="mailto:${escapeHtml(db.settings.company_email)}" class="info-link">${escapeHtml(db.settings.company_email)}</a>
                </div>
              </div>
              <div class="info-card">
                <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div class="info-details">
                  <h3>Brokerage Office</h3>
                  <p>${escapeHtml(db.settings.company_address)}</p>
                  <span class="rera-info" style="font-size:0.8rem; color:#64748B;">RERA ORN: ${escapeHtml(db.settings.rera_orn)} | DLD License: ${escapeHtml(db.settings.dld_license)}</span>
                </div>
              </div>
            </div>

            <div class="contact-form-col">
              <div class="contact-form-card">
                <h2 class="form-title" style="font-family:var(--font-heading); margin-bottom:6px;">Send Us a Message</h2>
                <p class="form-subtitle" style="color:#64748B; margin-bottom:20px;">Fill in the form below and an advisor will contact you within 2 hours.</p>
                <form action="/enquiry/submit" method="POST" id="mainContactForm">
                  <div class="form-row">
                    <div class="form-group half-width"><label>Full Name *</label><input type="text" name="name" class="form-input" required placeholder="e.g. Sarah Jenkins"></div>
                    <div class="form-group half-width"><label>Phone / WhatsApp *</label><input type="tel" name="phone" class="form-input" required placeholder="+971 542202920"></div>
                  </div>
                  <div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-input" placeholder="sarah@example.com"></div>
                  <div class="form-group"><label>Subject</label><input type="text" name="subject" class="form-input" value="General Inquiry"></div>
                  <div class="form-group"><label>Message *</label><textarea name="message" rows="4" class="form-textarea" required placeholder="Tell us about your property goals..."></textarea></div>
                  <button type="submit" class="btn-primary-pill full-width"><span>Send Message</span> <i class="fa-solid fa-paper-plane"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage('Contact Us | DRL Dwarika Real Estate LLC', html, 'contact'));
  }

  // 6.7 TESTIMONIALS PAGE
  if (pathname === '/testimonials') {
    const cards = db.testimonials.map(t => `
      <div class="testimonial-card" style="padding:28px;">
        <div class="testimonial-avatar-initial">${escapeHtml(t.avatar_initial)}</div>
        <blockquote class="testimonial-quote">&ldquo;${escapeHtml(t.quote)}&rdquo;</blockquote>
        <div class="testimonial-author-info">
          <div class="author-name">${escapeHtml(t.client_name)}</div>
          <div class="author-location">${escapeHtml(t.location)}</div>
        </div>
      </div>
    `).join('');

    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li aria-current="page">Testimonials</li></ol></nav>
          <h1 class="page-banner-title">Client Stories &amp; Testimonials</h1>
          <p class="page-banner-subtitle">Read feedback from satisfied home buyers and international investors who chose DRL Dwarika Real Estate LLC.</p>
        </div>
      </div>
      <section class="section-padding surface-bg"><div class="container"><div class="testimonials-grid">${cards}</div></div></section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage('Client Testimonials | DRL Dwarika Real Estate LLC', html, 'testimonials'));
  }

  // 6.8 LOCATIONS DISCOVERY PAGE (/locations/:slug)
  if (pathname.startsWith('/locations/')) {
    const slug = pathname.replace('/locations/', '');
    const loc = db.locations.find(l => l.slug === slug);
    if (!loc) {
      res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderPage('Location Not Found', '<div class="container section-padding"><h1>Location Not Found</h1></div>'));
    }
    const matching = db.properties.filter(p => p.location_id == loc.id && p.status === 'published');
    const cards = matching.map(renderPropertyCard).join('');

    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li><a href="/properties">Properties</a></li><li aria-current="page">${escapeHtml(loc.name)}</li></ol></nav>
          <h1 class="page-banner-title">Properties in ${escapeHtml(loc.name)}</h1>
          <p class="page-banner-subtitle">${escapeHtml(loc.description)}</p>
        </div>
      </div>
      <section class="section-padding">
        <div class="container">
          ${cards ? `<div class="properties-grid">${cards}</div>` : `<div class="no-results-box"><h3>No public listings in ${escapeHtml(loc.name)} right now.</h3><p>Contact us for off-market or upcoming units.</p><a href="/contact-us" class="btn-primary-pill">Inquire About ${escapeHtml(loc.name)}</a></div>`}
        </div>
      </section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage(`${loc.name} Properties | DRL Dwarika`, html, 'locations'));
  }

  // 6.9 PROPERTY TYPES DISCOVERY PAGE (/property-types/:slug)
  if (pathname.startsWith('/property-types/')) {
    const slug = pathname.replace('/property-types/', '');
    const type = db.property_types.find(t => t.slug === slug);
    if (!type) {
      res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderPage('Type Not Found', '<div class="container section-padding"><h1>Property Type Not Found</h1></div>'));
    }
    const matching = db.properties.filter(p => p.property_type_id == type.id && p.status === 'published');
    const cards = matching.map(renderPropertyCard).join('');

    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li><a href="/properties">Properties</a></li><li aria-current="page">${escapeHtml(type.name)}s</li></ol></nav>
          <h1 class="page-banner-title">Luxury ${escapeHtml(type.name)}s in Dubai</h1>
          <p class="page-banner-subtitle">${escapeHtml(type.description)}</p>
        </div>
      </div>
      <section class="section-padding">
        <div class="container">
          ${cards ? `<div class="properties-grid">${cards}</div>` : `<div class="no-results-box"><h3>No ${escapeHtml(type.name)}s currently available.</h3><a href="/properties" class="btn-primary-pill">View All Properties</a></div>`}
        </div>
      </section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage(`${type.name}s in Dubai | DRL Dwarika`, html, 'properties'));
  }

  // 6.10 PUBLIC MARKET BLOGS & INSIGHTS (/blogs & /blog/:slug)
  if (pathname === '/blogs' || pathname === '/blog') {
    const blogs = (db.blogs || []).filter(b => b.status === 'published');
    const categoryFilter = query.category || '';
    const filteredBlogs = categoryFilter ? blogs.filter(b => b.category === categoryFilter) : blogs;

    const cards = filteredBlogs.map(b => `
      <article class="property-card" style="display:flex; flex-direction:column;">
        <div class="property-card-media">
          <a href="/blog/${b.slug}">
            <img src="${b.featured_image || '/assets/images/villa-dubai-hills.jpg'}" alt="${escapeHtml(b.title)}" class="property-card-img" style="height:220px; object-fit:cover;">
          </a>
          <span class="property-badge" style="background:#0F1E2E;">${escapeHtml(b.category)}</span>
        </div>
        <div class="property-card-body" style="flex:1; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <div style="font-size:0.8rem; color:#64748B; margin-bottom:6px;">
              <i class="fa-regular fa-calendar"></i> ${escapeHtml(b.published_at)} &bull; <i class="fa-solid fa-user-pen"></i> ${escapeHtml(b.author)}
            </div>
            <h3 class="property-card-title" style="font-size:1.15rem; line-height:1.4; margin-bottom:10px;">
              <a href="/blog/${b.slug}">${escapeHtml(b.title)}</a>
            </h3>
            <p style="font-size:0.9rem; color:#475569; line-height:1.5; margin-bottom:16px;">
              ${escapeHtml(b.excerpt)}
            </p>
          </div>
          <div style="border-top:1px solid #E2E8F0; padding-top:12px; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:0.8rem; font-weight:600; color:#1689CC;">Read Full Guide</span>
            <a href="/blog/${b.slug}" class="property-arrow-link" aria-label="Read article"><i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </article>
    `).join('');

    const html = `
      <div class="page-banner">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li aria-current="page">Market Insights &amp; Blogs</li></ol></nav>
          <h1 class="page-banner-title">Dubai Real Estate Insights &amp; Investment Guides</h1>
          <p class="page-banner-subtitle">In-depth research, Golden Visa analysis, rental yield breakdowns, and regulatory updates from certified Dubai property advisors.</p>
        </div>
      </div>
      <section class="section-padding">
        <div class="container">
          <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:30px;">
            <a href="/blogs" class="btn-outline-pill ${!categoryFilter ? 'active' : ''}" style="${!categoryFilter ? 'background:#0F1E2E; color:#fff;' : ''}">All Insights (${blogs.length})</a>
            <a href="/blogs?category=Golden+Visa" class="btn-outline-pill ${categoryFilter === 'Golden Visa' ? 'active' : ''}" style="${categoryFilter === 'Golden Visa' ? 'background:#0F1E2E; color:#fff;' : ''}">Golden Visa</a>
            <a href="/blogs?category=Market+Insights" class="btn-outline-pill ${categoryFilter === 'Market Insights' ? 'active' : ''}" style="${categoryFilter === 'Market Insights' ? 'background:#0F1E2E; color:#fff;' : ''}">Market Trends</a>
            <a href="/blogs?category=Investment+Advisory" class="btn-outline-pill ${categoryFilter === 'Investment Advisory' ? 'active' : ''}" style="${categoryFilter === 'Investment Advisory' ? 'background:#0F1E2E; color:#fff;' : ''}">ROI &amp; Yields</a>
            <a href="/blogs?category=Communities" class="btn-outline-pill ${categoryFilter === 'Communities' ? 'active' : ''}" style="${categoryFilter === 'Communities' ? 'background:#0F1E2E; color:#fff;' : ''}">Communities</a>
          </div>
          <div class="properties-grid" style="grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));">
            ${cards}
          </div>
        </div>
      </section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage('Dubai Real Estate Market Blogs & Guides | DRL Dwarika', html, 'blogs'));
  }

  if (pathname.startsWith('/blog/')) {
    const slug = pathname.replace('/blog/', '');
    const blog = (db.blogs || []).find(b => b.slug === slug && b.status === 'published');
    if (!blog) {
      res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end(renderPage('Article Not Found', '<div class="container section-padding text-center"><h1>Article Not Found</h1><p>The requested blog guide may have been updated or relocated.</p><a href="/blogs" class="btn-primary-pill">View All Blogs</a></div>'));
    }

    const tagsHtml = (blog.tags || []).map(t => `<span class="badge-tag" style="background:#EEF2F6; color:#0F1E2E; padding:4px 10px; border-radius:12px; font-size:0.8rem; margin-right:6px;">#${escapeHtml(t)}</span>`).join('');

    const html = `
      <div class="page-banner" style="padding:60px 0 40px;">
        <div class="container">
          <nav class="breadcrumb-nav"><ol class="breadcrumb-list"><li><a href="/">Home</a></li><li><a href="/blogs">Market Blogs</a></li><li aria-current="page">${escapeHtml(blog.title)}</li></ol></nav>
          <div style="display:inline-block; background:#C5A880; color:#fff; font-weight:700; font-size:0.75rem; text-transform:uppercase; padding:4px 12px; border-radius:20px; margin-bottom:12px;">${escapeHtml(blog.category)}</div>
          <h1 class="page-banner-title" style="font-size:2.4rem; max-width:900px;">${escapeHtml(blog.title)}</h1>
          <div style="color:rgba(255,255,255,0.8); font-size:0.9rem; margin-top:12px;">
            <i class="fa-solid fa-user-pen"></i> By <strong>${escapeHtml(blog.author)}</strong> &bull; <i class="fa-regular fa-calendar"></i> ${escapeHtml(blog.published_at)} &bull; Official RERA Licensed Research
          </div>
        </div>
      </div>
      <section class="section-padding">
        <div class="container" style="max-width:880px;">
          <img src="${blog.featured_image || '/assets/images/villa-dubai-hills.jpg'}" alt="${escapeHtml(blog.title)}" style="width:100%; max-height:420px; object-fit:cover; border-radius:16px; margin-bottom:32px; box-shadow:0 12px 30px rgba(0,0,0,0.08);">
          <div style="font-size:1.15rem; line-height:1.7; color:#1E293B; font-weight:500; margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid #E2E8F0;">
            ${escapeHtml(blog.excerpt)}
          </div>
          <div style="font-size:1.05rem; line-height:1.8; color:#334155; margin-bottom:40px;">
            <p>${escapeHtml(blog.content)}</p>
          </div>
          <div style="margin-bottom:32px;">
            ${tagsHtml}
          </div>
          <div style="background:#0F1E2E; color:#fff; padding:32px; border-radius:16px; display:flex; flex-direction:column; gap:16px; align-items:center; text-align:center;">
            <h3 style="color:#C5A880; font-size:1.5rem; margin:0;">Consult With Our Dubai Property Specialists</h3>
            <p style="color:#E2E8F0; max-width:600px; margin:0;">Have questions about this guide, Golden Visa qualification, or current developer payment plans? Speak directly with our verified RERA advisors.</p>
            <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
              <a href="https://wa.me/971542202920?text=Hello%20DRL%20Dwarika,%20I%20read%20your%20article%20'${encodeURIComponent(blog.title)}'%20and%20would%20like%20more%20information" target="_blank" rel="noopener" class="btn-primary-pill" style="background:#25D366; color:#fff;">
                <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
              </a>
              <a href="/contact-us" class="btn-outline-pill" style="border-color:#fff; color:#fff;">Request Advisory Callback</a>
            </div>
          </div>
        </div>
      </section>
    `;
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    return res.end(renderPage(`${blog.title} | DRL Dwarika Real Estate`, html, 'blogs'));
  }

  // Fallback 404
  res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
  return res.end(renderPage('404 Page Not Found', `
    <div class="container section-padding text-center">
      <h1 style="font-size:3rem; font-family:var(--font-heading); color:#0F1E2E; margin-bottom:12px;">404 - Page Not Found</h1>
      <p style="color:#64748B; margin-bottom:24px;">The page you requested could not be located on the server.</p>
      <a href="/" class="btn-primary-pill">Return to Homepage</a>
    </div>
  `));
});

server.listen(PORT, () => {
  console.log(`====================================================================`);
  console.log(` DRL DWARIKA REAL ESTATE LLC — HIGH PERFORMANCE LOCAL SERVER`);
  console.log(` Master Design Reference: Exact Match to Attached Illustration`);
  console.log(` Public Website:    http://localhost:${PORT}`);
  console.log(` Admin Control:     http://localhost:${PORT}/admin`);
  console.log(` Admin Login:       admin@dwarikarealestate.ae / AdminPassword2025!`);
  console.log(` Dynamic Sitemap:   http://localhost:${PORT}/sitemap.xml`);
  console.log(`====================================================================`);
});
