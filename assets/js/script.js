// DEV MODE ======================================================================

console.log('Script loaded');

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM ready');
    const devMenuBtn = document.querySelector('.dev-menu-btn');
    const devMenuDropdown = document.querySelector('.dev-menu-dropdown');

    if (devMenuBtn && devMenuDropdown) {
        console.log('Dev menu elements found');

        // Toggle menu on button click
        devMenuBtn.addEventListener('click', (e) => {
            console.log('Dev menu clicked');
            e.stopPropagation();
            devMenuDropdown.classList.toggle('show');
            console.log('Classes:', devMenuDropdown.classList);
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!devMenuDropdown.contains(e.target) && !devMenuBtn.contains(e.target)) {
                if (devMenuDropdown.classList.contains('show')) {
                    console.log('Closing dev menu (outside click)');
                    devMenuDropdown.classList.remove('show');
                }
            }
        });
    } else {
        console.error('Dev menu elements NOT found');
    }
});

// DEV MODE ======================================================================
