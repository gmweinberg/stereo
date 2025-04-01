<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stereoscopic Image Gallery</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            padding: 15px;
        }
        
        .gallery-item {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }
        
        .gallery-item img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        
        .gallery-item a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Stereoscopic Image Gallery</h1>
        
        <div class="gallery">
            <?php
            // Image directory - update this to your actual path
            $imageDir = 'images/';
            
            // Get all stereo image pairs
            $images = [];
            
            // Read the directory for image files
            if (is_dir($imageDir)) {
                $files = scandir($imageDir);
                
                // Group stereo pairs based on naming convention
                // Assumes naming like "scene1_L.jpg" and "scene1_R.jpg"
                foreach ($files as $file) {
                    if (is_file($imageDir . $file) && preg_match('/(.*?)_(L|R)\.(jpe?g|png)$/i', $file, $matches)) {
                        $baseName = $matches[1];
                        $side = strtoupper($matches[2]);
                        $ext = $matches[3];
                        
                        if (!isset($images[$baseName])) {
                            $images[$baseName] = [];
                        }
                        
                        $images[$baseName][$side] = $file;
                    }
                }
                
                // Display each stereo pair
                foreach ($images as $baseName => $pair) {
                    $leftImage = isset($pair['L']) ? $pair['L'] : '';
                    $rightImage = isset($pair['R']) ? $pair['R'] : '';
                    
                    // If missing one side, use the other for both
                    if (!$leftImage && $rightImage) $leftImage = $rightImage;
                    if (!$rightImage && $leftImage) $rightImage = $leftImage;
                    
                    if ($leftImage && $rightImage) {
                        echo '<div class="gallery-item">';
                        echo '<a href="viewer.php?left=' . urlencode($leftImage) . '&right=' . urlencode($rightImage) . '">';
                        echo '<img src="' . $imageDir . $leftImage . '" alt="' . htmlspecialchars($baseName) . '">';
                        echo '<p>' . htmlspecialchars($baseName) . '</p>';
                        echo '</a>';
                        echo '</div>';
                    }
                }
            }
            
            // If no images were found
            if (empty($images)) {
                echo '<p>No stereoscopic images found.</p>';
            }
            ?>
        </div>
    </div>
    
    <script src="viewer.js"></script>
</body>
</html>
