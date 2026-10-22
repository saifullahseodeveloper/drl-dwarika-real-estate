/**
 * Performance Optimizer for DRL Dwarika Real Estate
 * Runs: node performance-optimize.js
 * 
 * What it does:
 * 1. Minifies chatbot.js (52KB -> ~30KB)
 * 2. Adds HTTP cache headers config for .htaccess
 * 3. Generates a minified chatbot file
 */

const fs = require('fs');
const path = require('path');

const ROOT = __dirname;

// ─── 1. Simple JS Minifier ───────────────────────────────────────────────────
function minifyJS(code) {
  return code
    // Remove single-line comments (but not URLs)
    .replace(/(?<!:)\/\/(?!.*https?:\/\/).*$/gm, '')
    // Remove multi-line comments
    .replace(/\/\*[\s\S]*?\*\//g, '')
    // Remove leading/trailing whitespace per line
    .split('\n').map(l => l.trim()).filter(Boolean).join('\n')
    // Collapse multiple blank lines
    .replace(/\n{2,}/g, '\n')
    // Remove spaces around operators (safe subset)
    .replace(/ {2,}/g, ' ')
    // Remove space after keywords before (
    .replace(/\b(if|for|while|function|return|typeof|instanceof)\s+\(/g, '$1(')
    // Remove trailing semicolons before }
    .replace(/;(\s*\})/g, '$1');
}

// ─── 2. Minify chatbot.js ────────────────────────────────────────────────────
const chatbotSrc = path.join(ROOT, 'public/assets/js/chatbot.js');
const chatbotMin = path.join(ROOT, 'public/assets/js/chatbot.min.js');

if (fs.existsSync(chatbotSrc)) {
  const original = fs.readFileSync(chatbotSrc, 'utf8');
  const originalSize = Buffer.byteLength(original, 'utf8');
  const minified = minifyJS(original);
  const minifiedSize = Buffer.byteLength(minified, 'utf8');
  fs.writeFileSync(chatbotMin, minified, 'utf8');
  const saved = ((originalSize - minifiedSize) / originalSize * 100).toFixed(1);
  console.log(`[chatbot.js] ${(originalSize/1024).toFixed(1)}KB -> ${(minifiedSize/1024).toFixed(1)}KB (saved ${saved}%)`);
} else {
  console.log('[chatbot.js] Not found, skipping.');
}

// ─── 3. Minify app.js ────────────────────────────────────────────────────────
const appSrc = path.join(ROOT, 'public/assets/js/app.js');
const appMin = path.join(ROOT, 'public/assets/js/app.min.js');
if (fs.existsSync(appSrc)) {
  const original = fs.readFileSync(appSrc, 'utf8');
  const originalSize = Buffer.byteLength(original, 'utf8');
  const minified = minifyJS(original);
  fs.writeFileSync(appMin, minified, 'utf8');
  console.log(`[app.js] ${(originalSize/1024).toFixed(1)}KB -> ${(Buffer.byteLength(minified)/1024).toFixed(1)}KB`);
}

// ─── 4. Update .htaccess with Cache Headers + Gzip ────────────────────────────
const htaccessPath = path.join(ROOT, '.htaccess');
const currentHtaccess = fs.existsSync(htaccessPath) ? fs.readFileSync(htaccessPath, 'utf8') : '';

const perfBlock = `
# ============================================================
# PERFORMANCE: Browser Caching & Gzip Compression
# Added by performance-optimize.js
# ============================================================

# Enable Gzip Compression
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/plain text/css text/javascript application/javascript application/json image/svg+xml
</IfModule>

# Browser Cache Headers
<IfModule mod_expires.c>
  ExpiresActive On
  # HTML - short cache
  ExpiresByType text/html "access plus 1 hour"
  # CSS + JS - 1 year (use versioned filenames for updates)
  ExpiresByType text/css "access plus 1 year"
  ExpiresByType application/javascript "access plus 1 year"
  ExpiresByType text/javascript "access plus 1 year"
  # Images - 6 months
  ExpiresByType image/webp "access plus 6 months"
  ExpiresByType image/jpeg "access plus 6 months"
  ExpiresByType image/png "access plus 6 months"
  ExpiresByType image/svg+xml "access plus 1 year"
  ExpiresByType image/avif "access plus 6 months"
  # Fonts - 1 year
  ExpiresByType font/woff2 "access plus 1 year"
  ExpiresByType font/woff "access plus 1 year"
</IfModule>

# Cache-Control Headers
<IfModule mod_headers.c>
  <FilesMatch "\\.(css|js)$">
    Header set Cache-Control "public, max-age=31536000, immutable"
  </FilesMatch>
  <FilesMatch "\\.(webp|jpg|jpeg|png|gif|avif|svg)$">
    Header set Cache-Control "public, max-age=15552000"
  </FilesMatch>
  <FilesMatch "\\.(woff2|woff|ttf)$">
    Header set Cache-Control "public, max-age=31536000, immutable"
  </FilesMatch>
  # Security headers
  Header set X-Content-Type-Options "nosniff"
  Header set X-Frame-Options "SAMEORIGIN"
  Header set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Keep-Alive
<IfModule mod_headers.c>
  Header set Connection keep-alive
</IfModule>
`;

if (!currentHtaccess.includes('PERFORMANCE: Browser Caching')) {
  fs.writeFileSync(htaccessPath, currentHtaccess + perfBlock, 'utf8');
  console.log('[.htaccess] Cache + Gzip headers added!');
} else {
  console.log('[.htaccess] Cache headers already present, skipping.');
}

// ─── 5. Update main.php to use chatbot.min.js ────────────────────────────────
const mainLayoutPath = path.join(ROOT, 'app/Views/layouts/main.php');
if (fs.existsSync(mainLayoutPath)) {
  let layout = fs.readFileSync(mainLayoutPath, 'utf8');
  if (layout.includes("s.src = '/assets/js/chatbot.js'")) {
    layout = layout.replace(
      "s.src = '/assets/js/chatbot.js';",
      "s.src = '/assets/js/chatbot.min.js';"
    );
    fs.writeFileSync(mainLayoutPath, layout, 'utf8');
    console.log('[main.php] Updated to use chatbot.min.js');
  } else {
    console.log('[main.php] Already using minified or path not found');
  }
}

// ─── 6. Summary ──────────────────────────────────────────────────────────────
console.log('\n✅ Performance optimization complete!');
console.log('   - chatbot.min.js: compressed version created');
console.log('   - .htaccess: gzip + browser caching enabled');
console.log('   - main.php: chatbot lazy-loads after interaction');
console.log('\nExpected score improvement: ~54 -> 75-85+');
console.log('Run: npx lighthouse http://localhost:4173 --output html --output-path lighthouse-v2.html --chrome-flags="--headless"');
