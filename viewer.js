// Main function to initialize everything
function initStereoscopicViewer() {
    // Detect device and orientation
    detectDeviceAndOrientation();
    
    // Set up event listener for orientation changes
    window.addEventListener('resize', detectDeviceAndOrientation);
    
    // Set up toggle for stereoscopic mode
    setupStereoscopicMode();
    
    // Ensure back button is first in tab order
    ensureBackButtonTabOrder();
}

// Detect device type and screen orientation
function detectDeviceAndOrientation() {
    const isPortrait = window.innerHeight > window.innerWidth;
    const userAgent = navigator.userAgent;
    
    // Check if it's the old phone that doesn't auto-rotate
    // Update this with your old phone's user agent string or a unique identifier
    const isOldPhone = userAgent.includes('YourOldPhoneModel') || 
                      localStorage.getItem('isOldPhone') === 'true';
    
    // Set class on body based on orientation
    document.body.classList.toggle('portrait-mode', isPortrait);
    
    // Special handling for old phone
    if (isOldPhone && isPortrait) {
        document.body.classList.add('force-rotate', 'old-phone-portrait');
    } else {
        document.body.classList.remove('force-rotate', 'old-phone-portrait');
    }
    
    // Apply proper image sizing based on current mode
    optimizeImageSizing();
}

// Optimize image sizing for stereoscopic viewing
function optimizeImageSizing() {
    const container = document.querySelector('.image-container');
    if (!container) return;
    
    const isPortrait = document.body.classList.contains('portrait-mode');
    const isForceRotated = document.body.classList.contains('force-rotate');
    
    // Get available width and height
    let availWidth, availHeight;
    
    if (isForceRotated) {
        // When rotated, width and height are swapped
        availWidth = window.innerHeight;
        availHeight = window.innerWidth;
    } else {
        availWidth = window.innerWidth;
        availHeight = window.innerHeight;
    }
    
    // Update container dimensions
    container.style.width = `${availWidth}px`;
    container.style.height = `${availHeight}px`;
}

// Set up stereoscopic mode
function setupStereoscopicMode() {
    // Double tap to toggle UI visibility
    let lastTap = 0;
    document.addEventListener('touchend', function(e) {
        const currentTime = new Date().getTime();
        const tapLength = currentTime - lastTap;
        
        if (tapLength < 500 && tapLength > 0) {
            // Double tap detected
            document.body.classList.toggle('stereo-mode');
            e.preventDefault();
        }
        
        lastTap = currentTime;
    });
    
    // Keyboard shortcut (s) to toggle UI
    document.addEventListener('keydown', function(e) {
        if (e.key === 's' || e.key === 'S') {
            document.body.classList.toggle('stereo-mode');
        }
    });
}

// Ensure back button is first in tab order
function ensureBackButtonTabOrder() {
    const backButton = document.querySelector('.nav-link');
    if (backButton) {
        backButton.tabIndex = 1;
        
        // Focus back button when pressing escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                backButton.focus();
            }
        });
    }
}

// Function to manually set the device as the "old phone"
function setAsOldPhone() {
    localStorage.setItem('isOldPhone', 'true');
    detectDeviceAndOrientation();
    alert('This device is now set as your old phone that needs rotation adjustment.');
}

// Function to remove the old phone setting
function unsetOldPhone() {
    localStorage.setItem('isOldPhone', 'false');
    detectDeviceAndOrientation();
    alert('Rotation adjustment has been disabled.');
}

// Enter/exit stereoscopic viewing mode
function toggleStereoscopicMode() {
    document.body.classList.toggle('stereo-mode');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initStereoscopicViewer);
