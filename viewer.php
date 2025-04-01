<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Stereoscopic Image Viewer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    // Get image names from URL parameters
    $leftImage = isset($_GET['left']) ? htmlspecialchars($_GET['left']) : '';
    $rightImage = isset($_GET['right']) ? htmlspecialchars($_GET['right']) : '';
    
    // Default to the same image for both if only one is provided
    if ($leftImage && !$rightImage) {
        $rightImage = $leftImage;
    }
    
    // Image directory - update this to your actual path
    $imageDir = 'images/';
    ?>
    
    <!-- Back link as the first focusable element (important for bluetooth controller) -->
    <a href="index.php" class="nav-link" tabindex="1">← Back to Gallery</a>
    
    <div class="container">
        <div class="image-container">
            <?php if ($leftImage): ?>
            <div class="stereo-image-wrapper">
                <img src="<?php echo $imageDir . $leftImage; ?>" alt="Left stereoscopic image" class="stereo-image">
            </div>
            <?php endif; ?>
            
            <div class="image-divider"></div>
            
            <?php if ($rightImage): ?>
            <div class="stereo-image-wrapper">
                <img src="<?php echo $imageDir . $rightImage; ?>" alt="Right stereoscopic image" class="stereo-image">
            </div>
            <?php endif; ?>
        </div>
        
        <div class="device-controls">
            <button onclick="setAsOldPhone()">Set as Old Phone</button>
            <button onclick="unsetOldPhone()">Disable Rotation</button>
            <button onclick="toggleStereoscopicMode()">Toggle Stereo Mode</button>
        </div>
    </div>
    
    <script src="viewer.js"></script>
</body>
</html>
