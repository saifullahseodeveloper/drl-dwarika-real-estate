<?php
declare(strict_types=1);

$images = [
    'pragati-pandey'    => 'C:/Users/lenovo/.gemini/antigravity-ide/brain/1b07d987-ced2-4282-8a3c-0fbf4a1fc654/.user_uploaded/media_1793206889440.png',
    'dheera-saxena'     => 'C:/Users/lenovo/.gemini/antigravity-ide/brain/1b07d987-ced2-4282-8a3c-0fbf4a1fc654/.user_uploaded/media_1793206896688.jpg',
    'jeet-chande'       => 'C:/Users/lenovo/.gemini/antigravity-ide/brain/1b07d987-ced2-4282-8a3c-0fbf4a1fc654/.user_uploaded/media_1793206904048.png',
    'yaseen-mughal'     => 'C:/Users/lenovo/.gemini/antigravity-ide/brain/1b07d987-ced2-4282-8a3c-0fbf4a1fc654/.user_uploaded/media_1793206910973.png',
    'aman-bhatnagar'    => 'C:/Users/lenovo/.gemini/antigravity-ide/brain/1b07d987-ced2-4282-8a3c-0fbf4a1fc654/.user_uploaded/media_1793206916668.png',
    'chirag-srivastava' => 'C:/Users/lenovo/.gemini/antigravity-ide/brain/1b07d987-ced2-4282-8a3c-0fbf4a1fc654/.user_uploaded/media_1793207193450.png',
];

$targetDir = __DIR__ . '/../public/assets/images/agents';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

foreach ($images as $slug => $srcPath) {
    if (!file_exists($srcPath)) {
        echo "ERROR: Source file missing for $slug: $srcPath\n";
        continue;
    }

    $info = getimagesize($srcPath);
    if (!$info) {
        echo "ERROR: Invalid image format for $slug: $srcPath\n";
        continue;
    }

    $mime = $info['mime'];
    $srcImg = null;
    if ($mime === 'image/jpeg') {
        $srcImg = imagecreatefromjpeg($srcPath);
    } elseif ($mime === 'image/png') {
        $srcImg = imagecreatefrompng($srcPath);
    } elseif ($mime === 'image/webp') {
        $srcImg = imagecreatefromwebp($srcPath);
    }

    if (!$srcImg) {
        echo "ERROR: Failed to load $srcPath\n";
        continue;
    }

    $origW = imagesx($srcImg);
    $origH = imagesy($srcImg);

    // Max dimension 1200px for sharp high-DPI displays without huge payload
    $maxDim = 1200;
    if ($origW > $maxDim || $origH > $maxDim) {
        $ratio = min($maxDim / $origW, $maxDim / $origH);
        $newW = (int)round($origW * $ratio);
        $newH = (int)round($origH * $ratio);
    } else {
        $newW = $origW;
        $newH = $origH;
    }

    $canvas = imagecreatetruecolor($newW, $newH);

    // Fill with solid white in case of transparent background
    $white = imagecolorallocate($canvas, 255, 255, 255);
    imagefill($canvas, 0, 0, $white);

    // Copy with high quality resampling
    imagecopyresampled($canvas, $srcImg, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

    $dstJpg  = "$targetDir/$slug.jpg";
    $dstWebp = "$targetDir/$slug.webp";

    imagejpeg($canvas, $dstJpg, 92);
    imagewebp($canvas, $dstWebp, 90);

    imagedestroy($canvas);
    imagedestroy($srcImg);

    echo "UPDATED: $slug -> JPG (" . filesize($dstJpg) . " bytes), WEBP (" . filesize($dstWebp) . " bytes)\n";
}

echo "All 6 agent images processed successfully!\n";
