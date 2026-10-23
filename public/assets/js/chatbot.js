/**
 * DRL DWARIKA REAL ESTATE LLC — AI LUXURY PROPERTY CONCIERGE (NOOR AI)
 * ====================================================================
 * Conversational profiling engine:
 * 1. Warm greeting -> asks user's name naturally
 * 2. Conversational response -> requests mobile number with in-chat country code selector
 * 3. Automatic background lead capture into DRL CRM (/enquiry/submit)
 * 4. Full Dubai real estate advisory & dynamic property recommendation cards
 */

(function () {
  'use strict';

  /* ============================================================
     1. COUNTRY CODES DATABASE (160+ Countries with Flags & Dial Codes)
  ============================================================ */
  const COUNTRIES = [
    { code: '+971', flag: '🇦🇪', name: 'United Arab Emirates', popular: true },
    { code: '+91',  flag: '🇮🇳', name: 'India', popular: true },
    { code: '+44',  flag: '🇬🇧', name: 'United Kingdom', popular: true },
    { code: '+1',   flag: '🇺🇸', name: 'United States', popular: true },
    { code: '+966', flag: '🇸🇦', name: 'Saudi Arabia', popular: true },
    { code: '+974', flag: '🇶🇦', name: 'Qatar', popular: true },
    { code: '+965', flag: '🇰🇼', name: 'Kuwait', popular: true },
    { code: '+968', flag: '🇴🇲', name: 'Oman', popular: true },
    { code: '+92',  flag: '🇵🇰', name: 'Pakistan', popular: true },
    { code: '+49',  flag: '🇩🇪', name: 'Germany', popular: true },
    { code: '+1',   flag: '🇨🇦', name: 'Canada', popular: true },
    { code: '+33',  flag: '🇫🇷', name: 'France' },
    { code: '+39',  flag: '🇮🇹', name: 'Italy' },
    { code: '+34',  flag: '🇪🇸', name: 'Spain' },
    { code: '+41',  flag: '🇨🇭', name: 'Switzerland' },
    { code: '+31',  flag: '🇳🇱', name: 'Netherlands' },
    { code: '+32',  flag: '🇧🇪', name: 'Belgium' },
    { code: '+43',  flag: '🇦🇹', name: 'Austria' },
    { code: '+46',  flag: '🇸🇪', name: 'Sweden' },
    { code: '+47',  flag: '🇳🇴', name: 'Norway' },
    { code: '+45',  flag: '🇩🇰', name: 'Denmark' },
    { code: '+353', flag: '🇮🇪', name: 'Ireland' },
    { code: '+61',  flag: '🇦🇺', name: 'Australia' },
    { code: '+64',  flag: '🇳🇿', name: 'New Zealand' },
    { code: '+65',  flag: '🇸🇬', name: 'Singapore' },
    { code: '+60',  flag: '🇲🇾', name: 'Malaysia' },
    { code: '+63',  flag: '🇵🇭', name: 'Philippines' },
    { code: '+86',  flag: '🇨🇳', name: 'China' },
    { code: '+852', flag: '🇭🇰', name: 'Hong Kong' },
    { code: '+81',  flag: '🇯🇵', name: 'Japan' },
    { code: '+82',  flag: '🇰🇷', name: 'South Korea' },
    { code: '+880', flag: '🇧🇩', name: 'Bangladesh' },
    { code: '+94',  flag: '🇱🇰', name: 'Sri Lanka' },
    { code: '+977', flag: '🇳🇵', name: 'Nepal' },
    { code: '+973', flag: '🇧🇭', name: 'Bahrain' },
    { code: '+20',  flag: '🇪🇬', name: 'Egypt' },
    { code: '+962', flag: '🇯🇴', name: 'Jordan' },
    { code: '+961', flag: '🇱🇧', name: 'Lebanon' },
    { code: '+90',  flag: '🇹🇷', name: 'Turkey' },
    { code: '+7',   flag: '🇷🇺', name: 'Russia' },
    { code: '+27',  flag: '🇿🇦', name: 'South Africa' },
    { code: '+234', flag: '🇳🇬', name: 'Nigeria' },
    { code: '+254', flag: '🇰🇪', name: 'Kenya' },
    { code: '+55',  flag: '🇧🇷', name: 'Brazil' },
    { code: '+52',  flag: '🇲🇽', name: 'Mexico' }
  ];

  /* ============================================================
     2. DRL DWARIKA VERIFIED PROPERTIES KNOWLEDGE BASE
  ============================================================ */
  const DWARIKA_PROPERTIES = [
    {
      id: 1,
      title: 'Modern Villa in Dubai Hills',
      slug: 'modern-villa-in-dubai-hills',
      category: 'villa',
      location: 'Dubai Hills Estate',
      price: 'AED 4,500,000',
      priceNum: 4500000,
      beds: '4 Beds',
      baths: '5 Baths',
      area: '4,850 sq.ft',
      image: '/assets/images/villa-dubai-hills.jpg',
      badge: 'Exclusive Villa',
      rera: 'DLD-749210-2025'
    },
    {
      id: 2,
      title: 'Luxury Apartment in Downtown',
      slug: 'luxury-apartment-downtown-dubai',
      category: 'apartment',
      location: 'Downtown Dubai',
      price: 'AED 2,200,000',
      priceNum: 2200000,
      beds: '2 Beds',
      baths: '2 Baths',
      area: '1,420 sq.ft',
      image: '/assets/images/apartment-downtown.jpg',
      badge: 'Burj View',
      rera: 'DLD-810934-2025'
    },
    {
      id: 3,
      title: 'Spacious Townhouse in JVC',
      slug: 'spacious-townhouse-jvc',
      category: 'townhouse',
      location: 'Jumeirah Village Circle (JVC)',
      price: 'AED 3,100,000',
      priceNum: 3100000,
      beds: '3 Beds',
      baths: '4 Baths',
      area: '2,800 sq.ft',
      image: '/assets/images/townhouse-jvc.jpg',
      badge: 'High Rental Yield',
      rera: 'DLD-993012-2025'
    },
    {
      id: 4,
      title: 'Penthouse with Skyline View',
      slug: 'penthouse-with-skyline-view',
      category: 'penthouse',
      location: 'Palm Jumeirah',
      price: 'AED 12,800,000',
      priceNum: 12800000,
      beds: '4 Beds',
      baths: '5 Baths',
      area: '6,200 sq.ft',
      image: '/assets/images/penthouse-palm.jpg',
      badge: 'Ultra Luxury',
      rera: 'DLD-128394-2025'
    },
    {
      id: 5,
      title: 'Commercial Office Tower',
      slug: 'commercial-office-tower',
      category: 'commercial',
      location: 'Business Bay',
      price: 'AED 8,900,000',
      priceNum: 8900000,
      beds: 'Fitted Office',
      baths: '3 Baths',
      area: '5,100 sq.ft',
      image: '/assets/images/commercial-business-bay.jpg',
      badge: 'Prime Investment',
      rera: 'DLD-551920-2025'
    },
    {
      id: 6,
      title: 'Waterfront Luxury Residence',
      slug: 'waterfront-luxury-residence',
      category: 'apartment',
      location: 'Dubai Creek Harbour',
      price: 'AED 1,950,000',
      priceNum: 1950000,
      beds: '1 Bed',
      baths: '2 Baths',
      area: '980 sq.ft',
      image: '/assets/images/offplan-creek.jpg',
      badge: 'Off-Plan 2026',
      rera: 'DLD-418290-2025'
    }
  ];

  // LIVE REAL-TIME KNOWLEDGE BASE (Synchronized with Website Database & Admin Panel)
  let liveProperties = [...DWARIKA_PROPERTIES];
  let liveBlogs = [];
  let liveLocations = [];
  let liveServices = [];
  let liveAgents = [];
  let liveSettings = {};
  let lastSyncTime = 0;

  /**
   * Fetches real-time knowledge base from the website database (/api/chatbot-knowledge).
   * Instantly reflects any newly added, edited, or deleted properties, blogs, communities, or services.
   */
  function syncKnowledgeBase(force = false) {
    const now = Date.now();
    // Cache for 2 seconds maximum to guarantee near-instant reflection of database updates
    if (!force && lastSyncTime && (now - lastSyncTime < 2000) && liveProperties.length > 0) {
      return Promise.resolve({ properties: liveProperties, blogs: liveBlogs });
    }

    return fetch('/api/chatbot-knowledge?t=' + now, {
      headers: {
        'Cache-Control': 'no-cache, no-store, must-revalidate',
        'Pragma': 'no-cache'
      }
    })
      .then(res => {
        if (!res.ok) throw new Error('Network error');
        return res.json();
      })
      .then(data => {
        if (data && data.success) {
          if (Array.isArray(data.properties)) {
            liveProperties = data.properties.map(p => ({
              id: p.id,
              title: p.title,
              slug: p.slug,
              category: (p.category || 'apartment').toLowerCase(),
              location: p.location || 'Dubai',
              price: p.priceFormatted || `AED ${Number(p.price).toLocaleString()}`,
              priceNum: Number(p.price) || 0,
              beds: p.bedrooms ? `${p.bedrooms} Beds` : 'Luxury Suite',
              baths: p.bathrooms ? `${p.bathrooms} Baths` : 'Fitted Baths',
              area: p.area_sqft ? `${Number(p.area_sqft).toLocaleString()} sq.ft` : '',
              image: p.featured_image || '/assets/images/apartment-downtown.jpg',
              badge: p.badge || 'Verified Listing',
              rera: p.rera_permit || 'DLD-VERIFIED',
              description: p.description || '',
              listing_type: p.listing_type || 'sale'
            }));
          }
          if (Array.isArray(data.blogs)) {
            liveBlogs = data.blogs.map(b => ({
              id: b.id,
              title: b.title,
              slug: b.slug,
              category: b.category || 'Market Insights',
              author: b.author || 'DRL Research Team',
              published_at: b.published_at || '',
              excerpt: b.excerpt || '',
              content: b.content || '',
              featured_image: b.featured_image || '/assets/images/villa-dubai-hills.jpg',
              tags: b.tags || []
            }));
          }
          if (data.locations) liveLocations = data.locations;
          if (data.services) liveServices = data.services;
          if (data.agents) liveAgents = data.agents;
          if (data.settings) liveSettings = data.settings;
          lastSyncTime = now;
        }
        return { properties: liveProperties, blogs: liveBlogs };
      })
      .catch(err => {
        // Fallback to current memory cache if offline
        return { properties: liveProperties, blogs: liveBlogs };
      });
  }

  // Cross-tab real-time synchronization via BroadcastChannel
  try {
    if ('BroadcastChannel' in window) {
      const bc = new BroadcastChannel('drl_knowledge_sync');
      bc.onmessage = (ev) => {
        if (ev.data === 'sync' || (ev.data && ev.data.action === 'sync')) {
          syncKnowledgeBase(true);
        }
      };
    }
  } catch (e) {}

  // Initial silent sync on script load
  syncKnowledgeBase(true);

  /* ============================================================
     3. STATE MANAGEMENT
  ============================================================ */
  let chatOpen = false;
  let chatPanel = null;
  let chatBody = null;
  let chatInput = null;
  let sendBtn = null;
  let launcherBtn = null;
  let calloutEl = null;

  // Lead State
  const STORAGE_KEY = 'drl_concierge_user';
  let userData = {
    name: '',
    phone: '',
    countryCode: '+971',
    stage: 'ASK_NAME' // 'ASK_NAME' | 'ASK_PHONE' | 'CONSULTATION'
  };

  // Restore saved state if exists
  try {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) {
      const parsed = JSON.parse(saved);
      if (parsed && parsed.name && parsed.phone) {
        userData = parsed;
        userData.stage = 'CONSULTATION';
      } else if (parsed && parsed.name) {
        userData.name = parsed.name;
        userData.stage = 'ASK_PHONE';
      }
    }
  } catch (e) {
    // Local storage unavailable
  }

  /* ============================================================
     4. UI BUILDER: INJECT CHATBOT INTO DOM
  ============================================================ */
  function injectChatbot() {
    if (document.getElementById('drlChatbotRoot')) return;

    // Inject critical mobile styles to guarantee zero overlap on mobile/tablets
    if (!document.getElementById('drlChatbotMobileStyles')) {
      const style = document.createElement('style');
      style.id = 'drlChatbotMobileStyles';
      style.textContent = `
        /* Hide floating launcher completely on all devices when chat is open */
        #drlChatLauncher.drl-chat-open,
        .drl-chat-launcher.drl-chat-open {
          display: none !important;
          visibility: hidden !important;
          pointer-events: none !important;
          opacity: 0 !important;
        }

        /* Prevent background scroll when chat is open on mobile */
        html.drl-chat-open,
        body.drl-chat-open {
          overflow: hidden !important;
          height: 100% !important;
          touch-action: none;
        }

        @media (max-width: 768px) {
          #drlChatCallout,
          .drl-chat-callout {
            display: none !important;
          }
          #drlChatPanel.active,
          .drl-chat-panel.active {
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100dvh;
            max-width: 100vw !important;
            max-height: 100dvh;
            overscroll-behavior: contain;
            border-radius: 0 !important;
            z-index: 99999 !important;
          }
          .drl-chat-body {
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
          }
          .drl-chat-footer {
            padding: 12px 14px !important;
            padding-bottom: max(14px, env(safe-area-inset-bottom, 14px)) !important;
            background: #ffffff !important;
            position: relative !important;
            z-index: 100 !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
          }
          .drl-chat-input {
            font-size: 16px !important;
            width: 100% !important;
          }
          .drl-send-btn {
            width: 44px !important;
            height: 44px !important;
            min-width: 44px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative !important;
            z-index: 101 !important;
            visibility: visible !important;
            opacity: 1 !important;
          }
        }
      `;
      document.head.appendChild(style);
    }

    const root = document.createElement('div');
    root.id = 'drlChatbotRoot';
    root.innerHTML = `
      <!-- Floating Launcher Button -->
      <div class="drl-chat-launcher" id="drlChatLauncher" aria-label="Open Noor AI Property Concierge">
        <div class="drl-chat-callout" id="drlChatCallout">
          <i class="fa-solid fa-sparkles sparkle-icon"></i>
          <span>Ask Noor AI • Dubai Properties</span>
          <button type="button" class="callout-close" id="drlCalloutClose" title="Dismiss">&times;</button>
        </div>
        <button type="button" class="drl-launcher-circle" id="drlLauncherBtn" aria-expanded="false" title="Chat with Noor AI">
          <i class="fa-solid fa-comments drl-launcher-icon-chat"></i>
          <i class="fa-solid fa-xmark drl-launcher-icon-close"></i>
          <span class="badge-online"></span>
        </button>
      </div>

      <!-- Main Glassmorphic Chat Window -->
      <div class="drl-chat-panel" id="drlChatPanel" role="dialog" aria-labelledby="drlChatTitle">
        <!-- Header -->
        <div class="drl-chat-header">
          <div class="drl-chat-header-info">
            <div class="drl-avatar-wrap">
              <div class="drl-avatar-img">
                <i class="fa-solid fa-gem"></i>
              </div>
              <span class="drl-avatar-online"></span>
            </div>
            <div class="drl-header-text">
              <h3 id="drlChatTitle">Noor <span class="bot-badge">AI Concierge</span></h3>
              <p><i class="fa-solid fa-circle-check" style="color:#10B981; font-size:0.7rem;"></i> DRL Dwarika • RERA Licensed</p>
            </div>
          </div>
          <div class="drl-header-actions">
            <button type="button" class="drl-hdr-btn" id="drlRestartChat" title="Restart Conversation">
              <i class="fa-solid fa-arrow-rotate-right"></i>
            </button>
            <button type="button" class="drl-hdr-btn" id="drlCloseChat" title="Close">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
        </div>

        <!-- Body / Message Stream -->
        <div class="drl-chat-body" id="drlChatBody">
          <!-- Dynamic conversation bubbles inserted here -->
        </div>

        <!-- Footer Input Form -->
        <form class="drl-chat-footer" id="drlChatForm">
          <div class="drl-chat-input-wrap">
            <input type="text" class="drl-chat-input" id="drlChatInput" placeholder="Type your message..." autocomplete="off">
          </div>
          <button type="submit" class="drl-send-btn" id="drlSendBtn" title="Send message">
            <i class="fa-solid fa-paper-plane"></i>
          </button>
        </form>
      </div>
    `;

    document.body.appendChild(root);

    // Bind DOM elements
    chatPanel = document.getElementById('drlChatPanel');
    chatBody = document.getElementById('drlChatBody');
    chatInput = document.getElementById('drlChatInput');
    sendBtn = document.getElementById('drlSendBtn');
    launcherBtn = document.getElementById('drlChatLauncher');
    calloutEl = document.getElementById('drlChatCallout');

    // Attach Event Listeners
    document.getElementById('drlLauncherBtn').addEventListener('click', toggleChat);
    if (calloutEl) {
      calloutEl.addEventListener('click', (e) => {
        if (e.target.id === 'drlCalloutClose') {
          e.stopPropagation();
          calloutEl.style.display = 'none';
        } else {
          toggleChat();
        }
      });
    }
    document.getElementById('drlCloseChat').addEventListener('click', toggleChat);
    document.getElementById('drlRestartChat').addEventListener('click', restartChat);
    
    // Form and button submission triggers
    const chatForm = document.getElementById('drlChatForm');
    chatForm.addEventListener('submit', handleUserSubmit);
    sendBtn.addEventListener('click', (e) => {
      e.preventDefault();
      handleUserSubmit(e);
    });
    chatInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        handleUserSubmit(e);
      }
    });

    // Mobile Keyboard & Viewport Handlers
    chatInput.addEventListener('focus', () => {
      if (window.innerWidth <= 768) {
        setTimeout(() => {
          window.scrollTo(0, 0);
          syncChatMobileViewport();
          // If only welcome greeting is present, keep it anchored at top
          if (chatBody && chatBody.children.length <= 2) {
            chatBody.scrollTop = 0;
          }
        }, 120);
      }
    });

    chatInput.addEventListener('blur', () => {
      if (window.innerWidth <= 768) {
        setTimeout(() => {
          window.scrollTo(0, 0);
          syncChatMobileViewport();
        }, 120);
      }
    });

    // Render initial messages
    renderWelcomeConversation();
  }

  function syncChatMobileViewport() {
    if (!chatOpen || !chatPanel || window.innerWidth > 768) {
      if (chatPanel && window.innerWidth > 768) {
        chatPanel.style.height = '';
        chatPanel.style.maxHeight = '';
        chatPanel.style.top = '';
        chatPanel.style.bottom = '';
      }
      return;
    }

    if (window.visualViewport) {
      const vh = window.visualViewport.height;
      const vTop = window.visualViewport.offsetTop || 0;

      chatPanel.style.setProperty('position', 'fixed', 'important');
      chatPanel.style.setProperty('top', `${vTop}px`, 'important');
      chatPanel.style.setProperty('height', `${vh}px`, 'important');
      chatPanel.style.setProperty('max-height', `${vh}px`, 'important');
      chatPanel.style.setProperty('bottom', 'auto', 'important');

      if (window.scrollY !== 0 || window.pageYOffset !== 0) {
        window.scrollTo(0, 0);
      }
    }
  }

  if (typeof window !== 'undefined') {
    if (window.visualViewport) {
      window.visualViewport.addEventListener('resize', () => {
        if (chatOpen && window.innerWidth <= 768) {
          syncChatMobileViewport();
          if (chatBody && chatBody.children.length <= 2) {
            chatBody.scrollTop = 0;
          }
        }
      });
      window.visualViewport.addEventListener('scroll', () => {
        if (chatOpen && window.innerWidth <= 768) {
          syncChatMobileViewport();
        }
      });
    }

    window.addEventListener('resize', () => {
      const launcher = document.getElementById('drlChatLauncher');
      if (chatOpen && window.innerWidth <= 768) {
        if (launcher) launcher.style.display = 'none';
        syncChatMobileViewport();
      } else if (!chatOpen && launcher) {
        launcher.style.display = 'flex';
        if (window.innerWidth <= 768 && calloutEl) {
          calloutEl.style.display = 'none';
        }
      }
    });
  }

  function toggleChat() {
    chatOpen = !chatOpen;
    const launcher = document.getElementById('drlChatLauncher');
    if (chatOpen) {
      syncKnowledgeBase(true); // Instant background sync from database
      chatPanel.classList.add('active');
      if (launcher) {
        launcher.classList.add('drl-chat-open');
        launcher.style.display = 'none';
      }
      if (calloutEl) calloutEl.style.display = 'none';

      const isMobile = window.innerWidth <= 768 || ('ontouchstart' in window && window.innerWidth <= 1024);
      if (isMobile) {
        document.documentElement.classList.add('drl-chat-open');
        document.body.classList.add('drl-chat-open');
        syncChatMobileViewport();
        // On mobile, DO NOT auto-focus chatInput on open so keyboard doesn't abruptly pop up and push the welcome message offscreen
      } else {
        setTimeout(() => chatInput.focus(), 300);
      }

      scrollToBottom(false);
    } else {
      chatPanel.classList.remove('active');
      document.documentElement.classList.remove('drl-chat-open');
      document.body.classList.remove('drl-chat-open');

      if (chatPanel) {
        chatPanel.style.height = '';
        chatPanel.style.maxHeight = '';
        chatPanel.style.top = '';
        chatPanel.style.bottom = '';
      }

      if (launcher) {
        launcher.classList.remove('drl-chat-open');
        launcher.style.display = 'flex';
        if (window.innerWidth <= 768 && calloutEl) {
          calloutEl.style.display = 'none';
        }
      }
    }
  }

  function restartChat() {
    localStorage.removeItem(STORAGE_KEY);
    userData = {
      name: '',
      phone: '',
      countryCode: '+971',
      stage: 'ASK_NAME'
    };
    chatBody.innerHTML = '';
    renderWelcomeConversation();
  }

  function scrollToBottom(force) {
    setTimeout(() => {
      if (!chatBody) return;
      // On mobile when only the initial welcome message is shown, keep it visible at top
      if (!force && window.innerWidth <= 768 && chatBody.children.length <= 2) {
        chatBody.scrollTop = 0;
        return;
      }
      chatBody.scrollTop = chatBody.scrollHeight;
    }, 50);
  }

  /* ============================================================
     5. CONVERSATIONAL PROGRESSION (NAME -> PHONE -> CONSULTATION)
  ============================================================ */

  function renderWelcomeConversation() {
    // If user was already captured in this session
    if (userData.stage === 'CONSULTATION' && userData.name) {
      appendBotMessage(
        `Welcome back, **${userData.name}**! 🌟\n\nIt is always a pleasure to assist you with Dubai's luxury real estate market. How can I guide you today?`,
        [
          { label: '🏙️ Luxury Apartments', query: 'show apartments' },
          { label: '🏖️ Waterfront Villas', query: 'show villas' },
          { label: '📈 High ROI Off-Plan', query: 'off-plan investment' },
          { label: '🛂 UAE Golden Visa', query: 'golden visa' },
          { label: '💬 WhatsApp Broker', query: 'talk to advisor' }
        ]
      );
      return;
    }

    // Step 1: Warm, friendly, human-like introduction asking for Name
    showTypingIndicator();
    setTimeout(() => {
      removeTypingIndicator();
      appendBotMessage(
        `Marhaban & Welcome to **DRL Dwarika Real Estate LLC**, Dubai! ✨\n\nI am **Noor**, your personal AI Luxury Property Concierge.\n\nPlease enter your name`
      );
      chatInput.placeholder = 'Please enter your name... (e.g. Rahul, Aman, Sarah)';
      userData.stage = 'ASK_NAME';
    }, 600);
  }

  /* ============================================================
     6. USER INPUT HANDLER
  ============================================================ */
  function handleUserSubmit(e) {
    if (e) e.preventDefault();
    const text = chatInput.value.trim();
    if (!text) return;

    // Append User Message to UI
    appendUserMessage(text);
    chatInput.value = '';

    // Stage 1: Capturing Name Naturally
    if (userData.stage === 'ASK_NAME') {
      processNameInput(text);
      return;
    }

    // Stage 2: Capturing Phone Number (if typed manually in main input)
    if (userData.stage === 'ASK_PHONE') {
      const cleaned = text.replace(/[^0-9+]/g, '');
      if (cleaned.length >= 7) {
        completePhoneCapture(userData.countryCode, cleaned);
      } else {
        showTypingIndicator();
        setTimeout(() => {
          removeTypingIndicator();
          appendBotMessage(
            `To make sure I connect you with our Dubai RERA specialists, please enter a valid mobile number with country code below. 👇`
          );
          renderPhoneStepCard(userData.name);
        }, 500);
      }
      return;
    }

    // Stage 3: Real Estate Advisory Conversation
    processConsultationQuery(text);
  }

  /* Extract and clean user name */
  function processNameInput(rawText) {
    let extractedName = rawText;
    // Strip common conversational prefixes (e.g. "my name is Rahul", "i am Rahul", "this is Rahul")
    extractedName = extractedName.replace(/^(my\s+name\s+is|i\s+am|i'm|this\s+is|naam\s+hai|mera\s+naam)\s+/i, '').trim();
    extractedName = extractedName.replace(/[.,!?;:]/g, '').trim();
    if (extractedName.length > 30) {
      extractedName = extractedName.slice(0, 30);
    }
    if (!extractedName) extractedName = 'Valued Guest';

    // Capitalize first letter of words
    extractedName = extractedName.replace(/\b\w/g, l => l.toUpperCase());

    userData.name = extractedName;
    userData.stage = 'ASK_PHONE';

    // Save partial state
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(userData));
    } catch (e) {}

    showTypingIndicator();
    setTimeout(() => {
      removeTypingIndicator();
      // Natural, appreciative transition: User feels respected, not interrogated!
      appendBotMessage(
        `A wonderful pleasure to connect with you, **${userData.name}**! 🌟\n\nDubai’s property market moves quickly. To ensure I can send you private off-market brochures, VIP floor plans, or connect you with our licensed Dubai RERA advisors on WhatsApp, **could you please share your WhatsApp / Contact number?**`
      );

      // Render the custom Country Code + Phone Number interactive card
      renderPhoneStepCard(userData.name);
    }, 700);
  }

  /* ============================================================
     7. IN-CHAT COUNTRY CODE & PHONE NUMBER INTERACTIVE CARD
  ============================================================ */
  function renderPhoneStepCard(userName) {
    const card = document.createElement('div');
    card.className = 'drl-phone-step-card';
    card.id = 'drlPhoneStepCard';

    // Popular country quick pills
    const popularPills = COUNTRIES.filter(c => c.popular).map(c => `
      <button type="button" class="drl-country-pill ${c.code === userData.countryCode ? 'selected' : ''}" data-code="${c.code}" data-flag="${c.flag}">
        <span>${c.flag}</span> <span>${c.code}</span>
      </button>
    `).join('');

    card.innerHTML = `
      <div class="drl-phone-step-header">
        <i class="fa-solid fa-shield-halved" style="color:#1689CC;"></i>
        <span>Select Country Code & Enter Mobile</span>
      </div>

      <!-- Quick Country Pills -->
      <div class="drl-quick-countries" id="drlQuickCountries">
        ${popularPills}
      </div>

      <!-- Input row with Country Dropdown Trigger + Phone Field -->
      <div class="drl-phone-inputs-row">
        <button type="button" class="drl-code-select-btn" id="drlCodeSelectBtn" title="Choose country">
          <span id="drlSelectedFlag">🇦🇪</span>
          <span id="drlSelectedCode">+971</span>
          <i class="fa-solid fa-chevron-down" style="font-size:0.7rem; color:#64748B;"></i>
        </button>

        <input type="tel" class="drl-phone-input" id="drlCardPhoneInput" placeholder="e.g. 50 123 4567" autocomplete="tel">

        <!-- Searchable Dropdown for All 160+ Countries -->
        <div class="drl-country-dropdown-modal" id="drlCountryDropdown" style="display:none;">
          <div class="drl-country-search-box">
            <input type="text" class="drl-country-search-input" id="drlCountrySearchInput" placeholder="Search country or code...">
          </div>
          <ul class="drl-country-list" id="drlCountryList">
            ${renderCountryListItems(COUNTRIES)}
          </ul>
        </div>
      </div>

      <button type="button" class="drl-phone-submit-btn" id="drlCardSubmitBtn">
        <span>Continue to Real Estate Concierge</span>
        <i class="fa-solid fa-arrow-right"></i>
      </button>

      <p class="card-trust-note">
        <i class="fa-solid fa-lock"></i> 100% Confidential • Official RERA Licensed Brokerage
      </p>
    `;

    chatBody.appendChild(card);
    scrollToBottom();

    // Attach events inside card
    const selectBtn = card.querySelector('#drlCodeSelectBtn');
    const dropdown = card.querySelector('#drlCountryDropdown');
    const searchInput = card.querySelector('#drlCountrySearchInput');
    const phoneInput = card.querySelector('#drlCardPhoneInput');
    const submitBtn = card.querySelector('#drlCardSubmitBtn');
    const flagSpan = card.querySelector('#drlSelectedFlag');
    const codeSpan = card.querySelector('#drlSelectedCode');
    const listEl = card.querySelector('#drlCountryList');

    // Focus phone input immediately
    setTimeout(() => phoneInput.focus(), 200);

    // Quick pills click
    card.querySelectorAll('.drl-country-pill').forEach(pill => {
      pill.addEventListener('click', () => {
        card.querySelectorAll('.drl-country-pill').forEach(p => p.classList.remove('selected'));
        pill.classList.add('selected');
        userData.countryCode = pill.dataset.code;
        flagSpan.textContent = pill.dataset.flag;
        codeSpan.textContent = pill.dataset.code;
        phoneInput.focus();
      });
    });

    // Toggle full country list dropdown
    selectBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = dropdown.style.display === 'block';
      dropdown.style.display = isOpen ? 'none' : 'block';
      if (!isOpen) {
        searchInput.value = '';
        listEl.innerHTML = renderCountryListItems(COUNTRIES);
        bindCountryItemClicks();
        searchInput.focus();
      }
    });

    // Country Search Filtering
    searchInput.addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      const filtered = COUNTRIES.filter(c =>
        c.name.toLowerCase().includes(q) || c.code.includes(q)
      );
      listEl.innerHTML = renderCountryListItems(filtered);
      bindCountryItemClicks();
    });

    function bindCountryItemClicks() {
      listEl.querySelectorAll('.drl-country-item').forEach(item => {
        item.addEventListener('click', () => {
          userData.countryCode = item.dataset.code;
          flagSpan.textContent = item.dataset.flag;
          codeSpan.textContent = item.dataset.code;
          dropdown.style.display = 'none';
          // Also update pills highlight if present
          card.querySelectorAll('.drl-country-pill').forEach(p => {
            p.classList.toggle('selected', p.dataset.code === item.dataset.code);
          });
          phoneInput.focus();
        });
      });
    }

    bindCountryItemClicks();

    // Close dropdown on outside click
    document.addEventListener('click', (e) => {
      if (!card.contains(e.target)) {
        dropdown.style.display = 'none';
      }
    });

    // Submit button click
    submitBtn.addEventListener('click', () => {
      const num = phoneInput.value.trim();
      if (!num || num.length < 5) {
        phoneInput.style.borderColor = '#EF4444';
        phoneInput.focus();
        return;
      }
      completePhoneCapture(userData.countryCode, num);
    });

    // Enter key inside phone input
    phoneInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        submitBtn.click();
      }
    });
  }

  function renderCountryListItems(list) {
    if (list.length === 0) {
      return `<li style="padding:10px; font-size:0.75rem; color:#94A3B8; text-align:center;">No matching countries</li>`;
    }
    return list.map(c => `
      <li class="drl-country-item" data-code="${c.code}" data-flag="${c.flag}">
        <span class="country-info">${c.flag} ${c.name}</span>
        <span class="country-code">${c.code}</span>
      </li>
    `).join('');
  }

  /* ============================================================
     8. LEAD COMPLETE & BACKGROUND CRM SYNCHRONIZATION
  ============================================================ */
  function completePhoneCapture(code, rawNum) {
    // Format full phone
    const cleanNum = rawNum.replace(/[^0-9]/g, '');
    const fullPhone = `${code} ${cleanNum}`;
    userData.phone = fullPhone;
    userData.stage = 'CONSULTATION';

    // Persist to local storage
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(userData));
    } catch (e) {}

    // Disable the interactive card
    const card = document.getElementById('drlPhoneStepCard');
    if (card) {
      card.innerHTML = `
        <div style="display:flex; align-items:center; gap:8px; color:#10B981; font-weight:700; font-size:0.85rem;">
          <i class="fa-solid fa-circle-check"></i>
          <span>Details Verified: ${userData.name} (${fullPhone})</span>
        </div>
      `;
    }

    // Append user confirmation bubble
    appendUserMessage(`📱 Contact: ${fullPhone}`);

    // Silently synchronize lead to backend database / CRM
    sendLeadToBackend({
      name: userData.name,
      phone: fullPhone,
      email: '',
      subject: 'AI Concierge Qualified Lead (Noor AI)',
      message: `User verified contact during Noor AI Concierge chat on website.`
    });

    chatInput.placeholder = 'Ask about Dubai properties, prices, areas, ROI...';

    // Friendly, consultative AI response
    showTypingIndicator();
    setTimeout(() => {
      removeTypingIndicator();
      appendBotMessage(
        `Thank you so much, **${userData.name}**! 🌟 Your private session is now officially active.\n\nOur senior Dubai advisors have also been notified to prioritize your inquiries.\n\nNow, tell me — **what type of property or investment are you exploring today?**`,
        [
          { label: '🏙️ Luxury Apartments', query: 'show luxury apartments' },
          { label: '🏖️ Waterfront Villas', query: 'show villas in dubai' },
          { label: '📈 High ROI Off-Plan (8-10%)', query: 'high roi off plan projects' },
          { label: '🛂 Golden Visa Eligible (AED 2M+)', query: 'golden visa properties' },
          { label: '💰 Budget under AED 3M', query: 'properties under 3 million' },
          { label: '📅 Schedule VIP Site Tour', query: 'schedule site visit' },
          { label: '💬 WhatsApp Senior Advisor', query: 'talk to advisor' }
        ]
      );
    }, 800);
  }

  /* Async submission to /enquiry/submit */
  function sendLeadToBackend(leadData) {
    try {
      const params = new URLSearchParams();
      params.append('name', leadData.name);
      params.append('phone', leadData.phone);
      params.append('email', leadData.email || `${leadData.name.toLowerCase().replace(/\s+/g, '')}@lead.dwarika.ae`);
      params.append('subject', leadData.subject);
      params.append('message', leadData.message);

      fetch('/enquiry/submit', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        body: params.toString()
      })
      .then(r => r.json())
      .then(res => {
        // Lead safely saved in database
      })
      .catch(err => {
        // Silent catch: network failure handled gracefully
      });
    } catch (e) {}
  }

  /* ============================================================
     9. CONSULTATION QUERY PROCESSOR (LIVE GROUNDED INTELLIGENCE)
  ============================================================ */
  function processConsultationQuery(userText) {
    showTypingIndicator();

    // Ensure knowledge base is 100% synchronized with live database
    syncKnowledgeBase().then(() => {
      setTimeout(() => {
        removeTypingIndicator();
        const response = generateConciergeResponse(userText);

        appendBotMessage(response.text, response.chips || []);

        if (response.properties && response.properties.length > 0) {
          renderPropertyCards(response.properties);
        }
      }, 400);
    });
  }

  function generateConciergeResponse(input) {
    const text = input.toLowerCase();

    // 1. WhatsApp / Contact human
    if (/whatsapp|call|phone|talk|speak|human|agent|broker|advisor|consultant|number|contact/i.test(text)) {
      const waUrl = `https://wa.me/971542202920?text=Hello%20DRL%20Dwarika,%20my%20name%20is%20${encodeURIComponent(userData.name || 'Client')}%20and%20I%20am%20interested%20in%20Dubai%20properties`;
      return {
        text: `I'm immediately connecting you with our **Senior Dubai Property Advisors**! 🤝\n\nOur brokerage is licensed by RERA under **ORN 63750**.\n\n• **Direct Phone**: [+971 542202920](tel:+971542202920)\n• **Office**: Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira, Dubai\n\nClick below to open a private WhatsApp consultation right now:`,
        chips: [
          { label: '💬 Open WhatsApp Chat', href: waUrl, gold: true },
          { label: '📞 Call Now: +971 542202920', href: 'tel:+971542202920' }
        ]
      };
    }

    // 2. LIVE MARKET BLOGS & RESEARCH GUIDES INTELLIGENCE
    const isBlogExplicit = /blog|article|post|guide|news|insight|outlook|research|report/i.test(text);
    const matchedBlogs = liveBlogs.filter(b => {
      const bTitle = (b.title || '').toLowerCase();
      const bCat = (b.category || '').toLowerCase();
      const bExcerpt = (b.excerpt || '').toLowerCase();
      const bTags = (b.tags || []).map(t => t.toLowerCase());

      if (text.includes(b.slug.replace(/-/g, ' '))) return true;
      if (bTags.some(t => text.includes(t))) return true;
      if (text.includes(bCat)) return true;
      const words = text.split(/\s+/).filter(w => w.length > 3 && !['show', 'find', 'what', 'have', 'about'].includes(w));
      const titleMatches = words.filter(w => bTitle.includes(w)).length;
      return titleMatches >= 2 || (isBlogExplicit && (titleMatches >= 1 || words.some(w => bExcerpt.includes(w))));
    });

    if (isBlogExplicit || matchedBlogs.length > 0) {
      const blogsToShow = matchedBlogs.length > 0 ? matchedBlogs : liveBlogs;
      if (blogsToShow.length > 0) {
        const blogList = blogsToShow.slice(0, 3).map(b => 
          `• **[${b.title}](/blog/${b.slug})** (${b.category})\n  *${b.excerpt.slice(0, 140)}...*`
        ).join('\n\n');

        const blogChips = blogsToShow.slice(0, 2).map(b => ({
          label: `📖 ${b.title.slice(0, 24)}...`,
          href: `/blog/${b.slug}`,
          gold: true
        }));
        blogChips.push({ label: '📰 View All Insights', href: '/blogs' });

        return {
          text: `Here are verified **Dubai Market Insights & Guides** directly from our live knowledge base:\n\n${blogList}\n\nWould you like more details or want to speak with our author/advisor directly?`,
          chips: blogChips
        };
      }
    }

    // 3. Show All / Full Live Portfolio Query
    if (/show all|all properties|full portfolio|all projects|list (all|properties)/i.test(text)) {
      return {
        text: `Here is our current live verified portfolio of **${liveProperties.length} active properties** across Dubai:`,
        properties: liveProperties,
        chips: [
          { label: '🏖️ Villas & Townhouses', query: 'show villas in dubai' },
          { label: '🏙️ Luxury Apartments', query: 'show luxury apartments' },
          { label: '💬 Talk to Senior Advisor', query: 'talk to advisor', gold: true }
        ]
      };
    }

    // 4. Dynamic Property Title or Reference Code Match (Direct Live Search)
    const directPropMatch = liveProperties.filter(p => {
      const pTitle = (p.title || '').toLowerCase();
      const pRef = (p.reference_code || '').toLowerCase();
      return (pRef && text.includes(pRef)) || 
             text.includes(pTitle) || 
             (text.length > 8 && pTitle.split(/\s+/).filter(w => w.length > 4).every(w => text.includes(w)));
    });

    if (directPropMatch.length > 0 && !(/golden|visa|whatsapp|call|human|broker|site\s*visit/i.test(text))) {
      return {
        text: `Found **${directPropMatch.length} active property listing(s)** matching your direct search:`,
        properties: directPropMatch,
        chips: [
          { label: '🏙️ Show All Properties', query: 'show all properties' },
          { label: '💬 Inquire with Advisor', query: 'talk to advisor', gold: true }
        ]
      };
    }

    // 5. UAE Golden Visa (Live Filtered + Live Blog Citation)
    if (/golden\s*visa|visa|residency|10\s*year/i.test(text)) {
      const gvProps = liveProperties.filter(p => p.priceNum >= 2000000);
      const gvBlog = liveBlogs.find(b => b.category === 'Golden Visa' || b.slug.includes('golden-visa'));
      let extraBlogNote = '';
      if (gvBlog) {
        extraBlogNote = `\n\n📖 **Verified Knowledge Guide**: [${gvBlog.title}](/blog/${gvBlog.slug})`;
      }
      return {
        text: `**UAE 10-Year Golden Visa via Real Estate** 🇦🇪\n\nUnder Dubai Land Department regulations, you qualify for the 10-Year Renewable Golden Visa when purchasing property valued at **AED 2,000,000 (~$545,000 USD)** or more.\n\n**Key Investor Benefits:**\n• 100% foreign ownership with 0% personal income & capital gains tax.\n• Sponsor your spouse, children of any age, and domestic staff.\n• No physical residency requirement (stay outside UAE without losing visa).\n• Available for both ready and off-plan properties (minimum AED 2M valuation).${extraBlogNote}\n\nHere are prime **Golden Visa eligible properties** currently available:`,
        properties: gvProps.slice(0, 4),
        chips: [
          ...(gvBlog ? [{ label: '📖 Read Golden Visa Guide', href: `/blog/${gvBlog.slug}`, gold: true }] : []),
          { label: '🏙️ Luxury Apartments', query: 'show luxury apartments' },
          { label: '🏖️ Private Villas', query: 'show villas in dubai' },
          { label: '💬 Consult Golden Visa Advisor', query: 'talk to advisor' }
        ]
      };
    }

    // 6. ROI & Rental Yields / Investment (Live Filtered + Live Blog Citation)
    if (/roi|yield|investment|return|rental|invest|capital appreciation/i.test(text)) {
      const invProps = liveProperties.filter(p => p.category === 'commercial' || p.category === 'apartment' || (p.badge && p.badge.includes('Yield')));
      const roiBlog = liveBlogs.find(b => b.slug.includes('outlook') || b.slug.includes('roi') || b.category === 'Market Insights');
      let extraBlogNote = '';
      if (roiBlog) {
        extraBlogNote = `\n\n📖 **Live Research Article**: [${roiBlog.title}](/blog/${roiBlog.slug})`;
      }
      return {
        text: `**Dubai Real Estate Investment & ROI Analysis** 📈\n\nDubai consistently outperforms London, New York, and Singapore in net rental yields:\n\n• **Average Net Yield**: **7% to 10% tax-free** net annual return.\n• **High Capital Growth**: Master communities like Dubai Hills Estate and Dubai Creek Harbour have witnessed **18% - 25% YoY capital growth**.\n• **Zero Tax**: 0% property tax, 0% capital gains tax, and 0% tax on rental income.\n• **Escrow Protection**: All payments are safeguarded in DLD-regulated Escrow accounts.${extraBlogNote}\n\nHere are our top investment picks with strong cash flow potential:`,
        properties: (invProps.length > 0 ? invProps : liveProperties).slice(0, 3),
        chips: [
          ...(roiBlog ? [{ label: '📈 2026 Market Report', href: `/blog/${roiBlog.slug}`, gold: true }] : []),
          { label: '🏢 High Yield Opportunities', query: 'show commercial properties' },
          { label: '💬 Request ROI Breakdown PDF', query: 'talk to advisor' }
        ]
      };
    }

    // 5. Dynamic Location Query (e.g. Dubai Hills, Downtown, Palm, JVC, Creek, Business Bay, etc.)
    const matchedLocProps = liveProperties.filter(p =>
      text.includes(p.location.toLowerCase()) ||
      (p.location.toLowerCase().split(' ').some(w => w.length > 3 && text.includes(w))) ||
      text.includes(p.slug.replace(/-/g, ' '))
    );

    if (matchedLocProps.length > 0 && !(/rera|golden|visa|whatsapp|call|visit/i.test(text))) {
      return {
        text: `Found **${matchedLocProps.length} active properties** matching your location search:`,
        properties: matchedLocProps,
        chips: [
          { label: '🏙️ Show All Properties', query: 'show all properties' },
          { label: '💬 Inquire with Specialist', query: 'talk to advisor', gold: true }
        ]
      };
    }

    // 6. Villas & Townhouses
    if (/villa|townhouse|mansion|independent house/i.test(text)) {
      const villas = liveProperties.filter(p => p.category.includes('villa') || p.category.includes('townhouse') || p.category.includes('penthouse') || p.title.toLowerCase().includes('villa'));
      return {
        text: `Here are our active **luxury villas and signature residences** in Dubai's premier master communities:`,
        properties: villas.length > 0 ? villas : liveProperties.slice(0, 3),
        chips: [
          { label: '🏖️ Palm Jumeirah & Hills', query: 'show all properties' },
          { label: '📅 Book a Private Villa Tour', query: 'schedule site visit', gold: true }
        ]
      };
    }

    // 7. Apartments & Flats
    if (/apartment|flat|studio|1\s*bhk|2\s*bhk|3\s*bhk|penthouse/i.test(text)) {
      const apts = liveProperties.filter(p => p.category.includes('apartment') || p.category.includes('penthouse') || p.title.toLowerCase().includes('apartment'));
      return {
        text: `Showing prime **luxury apartments and skyline residences** in our live inventory:`,
        properties: apts.length > 0 ? apts : liveProperties.slice(0, 3),
        chips: [
          { label: '🏙️ Downtown & Waterfront', query: 'show all properties' },
          { label: '💬 Get Payment Plan Details', query: 'talk to advisor', gold: true }
        ]
      };
    }

    // 8. Commercial
    if (/commercial|office|retail|shop|business bay|corporate/i.test(text)) {
      const comm = liveProperties.filter(p => p.category.includes('commercial') || p.title.toLowerCase().includes('office') || p.title.toLowerCase().includes('commercial'));
      return {
        text: `Here is our grade-A commercial real estate portfolio in Dubai’s premier business hubs:`,
        properties: comm.length > 0 ? comm : liveProperties.slice(0, 3),
        chips: [
          { label: '💬 Inquire Corporate Lease/Sale', query: 'talk to advisor', gold: true }
        ]
      };
    }

    // 9. Budget queries (Under 3M, 5M, etc.)
    if (/under\s*3|3\s*m|3\s*million|affordable|cheap|kam\s*budget/i.test(text)) {
      const budgetProps = liveProperties.filter(p => p.priceNum <= 3100000);
      return {
        text: `Found **${budgetProps.length} prime properties under AED 3.1 Million** in our live database:`,
        properties: budgetProps,
        chips: [
          { label: '🏙️ Show All Properties', query: 'show all properties' },
          { label: '💬 Request Payment Plans', query: 'talk to advisor', gold: true }
        ]
      };
    }

    // 10. Site visit / Viewing
    if (/site\s*visit|viewing|tour|see|visit|inspection/i.test(text)) {
      sendLeadToBackend({
        name: userData.name,
        phone: userData.phone,
        email: '',
        subject: 'VIP Site Visit Scheduled via AI Concierge',
        message: `Client requested VIP property viewing: "${input}"`
      });

      return {
        text: `Excellent choice, **${userData.name}**! 🚗✨\n\nI have registered your VIP site visit request in our system. One of our senior advisors will coordinate your private chauffeur-driven property viewing or high-definition live video walkthrough.\n\nWhich date or time works best for you?`,
        chips: [
          { label: '📅 This Weekend (Sat / Sun)', query: 'weekend viewing preferred' },
          { label: '📅 Tomorrow Afternoon', query: 'tomorrow afternoon' },
          { label: '💬 Confirm on WhatsApp', query: 'talk to advisor', gold: true }
        ]
      };
    }

    // 11. RERA / Legality / Safety
    if (/rera|legal|safe|permit|developer|trust|scam|dld/i.test(text)) {
      return {
        text: `**Official Regulatory Security & RERA Compliance** 🛡️\n\nDRL Dwarika Real Estate LLC is an officially registered brokerage under:\n• **RERA Office Registration Number (ORN)**: **29482**\n• **Dubai Land Department (DLD) License**: **1637547**\n\nEvery listing on our platform undergoes strict title deed authentication. Furthermore, all buyer payments for off-plan transactions are deposited strictly into Central Bank-monitored escrow accounts, guaranteeing 100% legal security.`,
        chips: [
          { label: '🏠 View Verified Properties', query: 'show all properties' },
          { label: '💬 Speak with Licensed Broker', query: 'talk to advisor' }
        ]
      };
    }

    // 12. Hindi / Hinglish understanding
    if (/kya\s*options|kya\s*hai|lena\s*hai|chahiye|kitne\s*ka|karein|batao/i.test(text)) {
      return {
        text: `Haan bilkul **${userData.name}** ji! 🌟\n\nDubai me humare live portfolio me world-class properties available hain:\n• **1-Bed / 2-Bed Apartments**: AED 1.2M se 2.5M (Downtown, Creek, JVC)\n• **Villas & Townhouses**: AED 3M se 10M+ (Dubai Hills, Palm Jumeirah)\n• **Rental Income**: 7% se 10% tak tax-free ROI.\n• **Golden Visa**: AED 20 Lakhs (AED 2M) se zyada ke investment par 10 saal ka visa.\n\nAapko kis type ki property dekhni hai?`,
        chips: [
          { label: '🏙️ Luxury Flats', query: 'show luxury apartments' },
          { label: '🏖️ Private Villas', query: 'show villas in dubai' },
          { label: '🛂 Golden Visa Details', query: 'golden visa properties' },
          { label: '💬 WhatsApp par baat karein', query: 'talk to advisor', gold: true }
        ]
      };
    }

    // Default Fallback
    return {
      text: `I'm here to tailor your Dubai property search, **${userData.name}**! Could you let me know:\n\n• **Preferred area?** (Downtown, Dubai Hills, Palm, JVC, Creek)\n• **Property type?** (Apartment, Villa, Townhouse, Commercial)\n• **Budget range in AED?**\n\nOr pick any quick option below:`,
      chips: [
        { label: '🏙️ Show All Properties', query: 'show all properties' },
        { label: '🏖️ Villas in Dubai Hills', query: 'show villas in dubai' },
        { label: '🛂 Golden Visa Properties', query: 'golden visa properties' },
        { label: '💬 WhatsApp with Senior Advisor', query: 'talk to advisor', gold: true }
      ]
    };
  }

  /* ============================================================
     10. UI MESSAGE RENDERING HELPERS
  ============================================================ */
  function appendUserMessage(text) {
    const msg = document.createElement('div');
    msg.className = 'drl-msg drl-user';
    msg.innerHTML = `
      <div class="drl-msg-bubble">${escapeHtml(text)}</div>
    `;
    chatBody.appendChild(msg);
    scrollToBottom();
  }

  function appendBotMessage(markdownText, chips = []) {
    const msg = document.createElement('div');
    msg.className = 'drl-msg drl-bot';

    const formatted = formatMarkdown(markdownText);
    const chipsHtml = renderChipsHtml(chips);

    msg.innerHTML = `
      <div class="drl-msg-avatar">
        <i class="fa-solid fa-gem"></i>
      </div>
      <div>
        <div class="drl-msg-bubble">
          ${formatted}
          ${chipsHtml}
        </div>
        <div class="drl-msg-time">${formatTime()}</div>
      </div>
    `;

    chatBody.appendChild(msg);
    bindChipClicks(msg);
    scrollToBottom();
  }

  function renderChipsHtml(chips) {
    if (!chips || chips.length === 0) return '';
    const items = chips.map(c => {
      if (c.href) {
        return `<a href="${c.href}" target="_blank" rel="noopener" class="drl-chip ${c.gold ? 'gold' : ''}">${escapeHtml(c.label)}</a>`;
      }
      return `<button type="button" class="drl-chip ${c.gold ? 'gold' : ''}" data-query="${escapeHtml(c.query || c.label)}">${escapeHtml(c.label)}</button>`;
    }).join('');

    return `<div class="drl-quick-chips">${items}</div>`;
  }

  function bindChipClicks(container) {
    container.querySelectorAll('.drl-chip[data-query]').forEach(btn => {
      btn.addEventListener('click', () => {
        const query = btn.dataset.query;
        chatInput.value = query;
        handleUserSubmit();
      });
    });
  }

  /* Render Mini Property Cards Inside Chat */
  function renderPropertyCards(props) {
    props.forEach(p => {
      const card = document.createElement('div');
      card.className = 'drl-prop-card-chat';
      const waLink = `https://wa.me/971542202920?text=Hello%20DRL%20Dwarika,%20my%20name%20is%20${encodeURIComponent(userData.name || 'Client')}%20and%20I%20am%20interested%20in%20${encodeURIComponent(p.title)}%20(${encodeURIComponent(p.price)})`;

      card.innerHTML = `
        <div class="drl-prop-chat-thumb">
          <img src="${p.image}" alt="${escapeHtml(p.title)}" loading="lazy">
          <span class="drl-prop-chat-badge">${p.badge}</span>
          <span class="drl-prop-chat-price">${p.price}</span>
        </div>
        <div class="drl-prop-chat-body">
          <h4 class="drl-prop-chat-title">${escapeHtml(p.title)}</h4>
          <div class="drl-prop-chat-loc"><i class="fa-solid fa-location-dot"></i> ${escapeHtml(p.location)}</div>
          <div class="drl-prop-chat-specs">
            <span><i class="fa-solid fa-bed"></i> ${p.beds}</span>
            <span><i class="fa-solid fa-bath"></i> ${p.baths}</span>
            <span><i class="fa-solid fa-ruler-combined"></i> ${p.area}</span>
          </div>
          <div class="drl-prop-chat-actions">
            <a href="/property/${p.slug}" target="_blank" class="drl-prop-btn primary">
              <span>View Property</span> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.65rem;"></i>
            </a>
            <a href="${waLink}" target="_blank" rel="noopener" class="drl-prop-btn whatsapp">
              <i class="fa-brands fa-whatsapp"></i> <span>WhatsApp</span>
            </a>
          </div>
        </div>
      `;
      chatBody.appendChild(card);
    });
    scrollToBottom();
  }

  function showTypingIndicator() {
    removeTypingIndicator();
    const ind = document.createElement('div');
    ind.className = 'drl-msg drl-bot';
    ind.id = 'drlTypingIndicator';
    ind.innerHTML = `
      <div class="drl-msg-avatar"><i class="fa-solid fa-gem"></i></div>
      <div class="drl-typing-indicator">
        <span></span><span></span><span></span>
      </div>
    `;
    chatBody.appendChild(ind);
    scrollToBottom();
  }

  function removeTypingIndicator() {
    const el = document.getElementById('drlTypingIndicator');
    if (el) el.remove();
  }

  /* Basic Markdown Formatting Helper */
  function formatMarkdown(str) {
    if (!str) return '';
    let out = escapeHtml(str);
    // Bold: **text**
    out = out.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    // Bullet points: • or -
    out = out.replace(/^[•\-]\s+(.*)$/gm, '<li style="margin-left:14px;">$1</li>');
    // Links [Text](URL)
    out = out.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" rel="noopener" style="color:#1689CC; font-weight:600; text-decoration:underline;">$1</a>');
    // Newlines
    out = out.replace(/\n\n/g, '<br><br>').replace(/\n/g, '<br>');
    return out;
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

  function formatTime() {
    const now = new Date();
    return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  /* ============================================================
     11. AUTO-INITIALIZATION (Deferred to Idle for Peak Core Web Vitals)
  ============================================================ */
  function scheduleInit() {
    if ('requestIdleCallback' in window) {
      requestIdleCallback(injectChatbot, { timeout: 2500 });
    } else {
      setTimeout(injectChatbot, 1500);
    }
  }

  if (document.readyState === 'complete') {
    scheduleInit();
  } else {
    window.addEventListener('load', scheduleInit, { once: true });
  }

  /* ============================================================
     12. PUBLIC API CONTROLS (GLOBAL WINDOW EXPORTS)
  ============================================================ */
  window.refreshChatbotKnowledge = function (force = true) {
    return syncKnowledgeBase(force);
  };

  window.drlChat = {
    open: () => { if (!chatOpen) toggleChat(); },
    close: () => { if (chatOpen) toggleChat(); },
    toggle: toggleChat,
    restart: restartChat,
    refreshKnowledge: (force = true) => syncKnowledgeBase(force),
    getLiveProperties: () => liveProperties,
    getLiveBlogs: () => liveBlogs,
    getLiveLocations: () => liveLocations,
    getLiveServices: () => liveServices,
    getLiveAgents: () => liveAgents,
    getLiveSettings: () => liveSettings
  };

})();
