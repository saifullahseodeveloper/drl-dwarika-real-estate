const fs = require('fs');
const path = require('path');
const sharp = require('sharp');

const imagesDir = path.join(__dirname, 'public', 'assets', 'images');

async function optimizeImages() {
  console.log('Starting image optimization...');

  // 1. Hero image
  const heroPath = path.join(imagesDir, 'hero-building.jpg');
  if (fs.existsSync(heroPath)) {
    const inputBuf = fs.readFileSync(heroPath);

    // Mobile WebP (600px)
    await sharp(inputBuf)
      .resize({ width: 600, withoutEnlargement: true })
      .webp({ quality: 80, effort: 6 })
      .toFile(path.join(imagesDir, 'hero-building-mobile.webp'));

    // Desktop WebP (1200px)
    await sharp(inputBuf)
      .resize({ width: 1200, withoutEnlargement: true })
      .webp({ quality: 82, effort: 6 })
      .toFile(path.join(imagesDir, 'hero-building.webp'));

    // Optimized fallback JPG (1200px, progressive)
    const heroJpgBuffer = await sharp(inputBuf)
      .resize({ width: 1200, withoutEnlargement: true })
      .jpeg({ quality: 80, progressive: true, mozjpeg: true })
      .toBuffer();
    fs.writeFileSync(heroPath, heroJpgBuffer);
    console.log('Hero building optimized: webp + progressive jpg');
  }

  // 2. All property listings and reference images
  const standardImages = [
    'apartment-downtown.jpg',
    'burj-skyline.jpg',
    'commercial-business-bay.jpg',
    'design-reference.jpg',
    'offplan-creek.jpg',
    'penthouse-palm.jpg',
    'townhouse-jvc.jpg',
    'villa-dubai-hills.jpg'
  ];

  for (const file of standardImages) {
    const fullPath = path.join(imagesDir, file);
    if (fs.existsSync(fullPath)) {
      const inputBuf = fs.readFileSync(fullPath);
      const webpPath = fullPath.replace(/\.jpg$/, '.webp');

      await sharp(inputBuf)
        .resize({ width: 800, withoutEnlargement: true })
        .webp({ quality: 80, effort: 6 })
        .toFile(webpPath);

      const jpgBuffer = await sharp(inputBuf)
        .resize({ width: 800, withoutEnlargement: true })
        .jpeg({ quality: 80, progressive: true, mozjpeg: true })
        .toBuffer();
      fs.writeFileSync(fullPath, jpgBuffer);
      console.log(`Optimized ${file} -> webp & progressive jpg`);
    }
  }

  // 3. Founders images
  const foundersDir = path.join(imagesDir, 'founders');
  if (fs.existsSync(foundersDir)) {
    for (const file of fs.readdirSync(foundersDir)) {
      if (file.endsWith('.jpg')) {
        const fullPath = path.join(foundersDir, file);
        const inputBuf = fs.readFileSync(fullPath);
        const webpPath = fullPath.replace(/\.jpg$/, '.webp');

        await sharp(inputBuf)
          .resize({ width: 600, height: 750, fit: 'cover' })
          .webp({ quality: 80, effort: 6 })
          .toFile(webpPath);

        const jpgBuffer = await sharp(inputBuf)
          .resize({ width: 600, height: 750, fit: 'cover' })
          .jpeg({ quality: 80, progressive: true, mozjpeg: true })
          .toBuffer();
        fs.writeFileSync(fullPath, jpgBuffer);
        console.log(`Optimized founder: ${file}`);
      }
    }
  }

  // 4. Agents images
  const agentsDir = path.join(imagesDir, 'agents');
  if (fs.existsSync(agentsDir)) {
    for (const file of fs.readdirSync(agentsDir)) {
      if (file.endsWith('.jpg')) {
        const fullPath = path.join(agentsDir, file);
        const inputBuf = fs.readFileSync(fullPath);
        const webpPath = fullPath.replace(/\.jpg$/, '.webp');

        await sharp(inputBuf)
          .resize({ width: 500, height: 600, fit: 'cover' })
          .webp({ quality: 80, effort: 6 })
          .toFile(webpPath);

        const jpgBuffer = await sharp(inputBuf)
          .resize({ width: 500, height: 600, fit: 'cover' })
          .jpeg({ quality: 80, progressive: true, mozjpeg: true })
          .toBuffer();
        fs.writeFileSync(fullPath, jpgBuffer);
        console.log(`Optimized agent: ${file}`);
      }
    }
  }

  console.log('All image optimizations completed successfully!');
}

optimizeImages().catch(err => {
  console.error('Error optimizing images:', err);
  process.exit(1);
});
