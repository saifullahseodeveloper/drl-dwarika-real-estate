const fs = require('fs');
const path = require('path');
const CleanCSS = require('clean-css');
const terser = require('terser');

async function build() {
  console.log('--- Building Optimized Production Assets ---');

  // 1. Minify styles.css -> styles.min.css
  const cssPath = path.join(__dirname, 'public', 'assets', 'css', 'styles.css');
  const minCssPath = path.join(__dirname, 'public', 'assets', 'css', 'styles.min.css');
  const criticalPath = path.join(__dirname, 'public', 'assets', 'css', 'critical.min.css');

  if (fs.existsSync(cssPath)) {
    const rawCss = fs.readFileSync(cssPath, 'utf8');
    const minifiedCss = new CleanCSS({ level: 2 }).minify(rawCss).styles;
    fs.writeFileSync(minCssPath, minifiedCss, 'utf8');
    console.log(`CSS: ${(rawCss.length / 1024).toFixed(1)} KB -> ${(minifiedCss.length / 1024).toFixed(1)} KB`);

    // Extract critical above-the-fold CSS (Header + Hero + Quick Search)
    const criticalMarker = '/* ====================================================================\n   OUR SERVICES SECTION';
    const criticalRaw = rawCss.includes(criticalMarker) ? rawCss.slice(0, rawCss.indexOf(criticalMarker)) : rawCss;
    const minCritical = new CleanCSS({ level: 2 }).minify(criticalRaw).styles;
    fs.writeFileSync(criticalPath, minCritical, 'utf8');
    console.log(`Critical CSS: ${(minCritical.length / 1024).toFixed(1)} KB`);
  }

  // 2. Minify app.js -> app.min.js
  const jsPath = path.join(__dirname, 'public', 'assets', 'js', 'app.js');
  const minJsPath = path.join(__dirname, 'public', 'assets', 'js', 'app.min.js');
  if (fs.existsSync(jsPath)) {
    const rawJs = fs.readFileSync(jsPath, 'utf8');
    const minifiedJs = await terser.minify(rawJs);
    if (minifiedJs.code) {
      fs.writeFileSync(minJsPath, minifiedJs.code, 'utf8');
      console.log(`JS: ${(rawJs.length / 1024).toFixed(1)} KB -> ${(minifiedJs.code.length / 1024).toFixed(1)} KB`);
    }
  }

  console.log('--- Assets Built Successfully ---');
}

build().catch(err => {
  console.error(err);
  process.exit(1);
});
