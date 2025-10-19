/**
 * Manual menu hover handler
 * Ensures dropdown menus show on hover
 */
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMenuHover);
    } else {
        initMenuHover();
    }
    
    function initMenuHover() {
        // Find all menu items with children
        var menuItems = document.querySelectorAll('.menu-item-has-children');
        
        menuItems.forEach(function(item) {
            var submenu = item.querySelector('.sub-menu');
            if (!submenu) return;
            
            // Remove inline display:none
            submenu.style.display = '';
            
            // Show submenu on mouseenter
            item.addEventListener('mouseenter', function() {
                submenu.classList.remove('fadeOutDownSmall');
                submenu.classList.add('fadeInUpSmall');
                submenu.style.display = 'block';
                submenu.style.visibility = 'visible';
                submenu.style.opacity = '1';
            });
            
            // Hide submenu on mouseleave
            item.addEventListener('mouseleave', function() {
                submenu.classList.remove('fadeInUpSmall');
                submenu.classList.add('fadeOutDownSmall');
                // Keep display:block but use opacity for animation
                setTimeout(function() {
                    if (!item.matches(':hover')) {
                        submenu.style.display = 'none';
                    }
                }, 200);
            });
        });
    }
})();
