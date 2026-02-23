console.log('Script loaded');

document.addEventListener('DOMContentLoaded', () => {
    // DEV MODE ======================================================================
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
    // DEV MODE ======================================================================

    // Profile Edit Form Toggle
    const btnEditProfile = document.getElementById('btn-edit-profile');
    const btnCancelEdit = document.getElementById('btn-cancel-edit');
    const profileInfo = document.getElementById('profile-info');
    const profileEdit = document.getElementById('profile-edit');

    if (btnEditProfile && btnCancelEdit && profileInfo && profileEdit) {
        btnEditProfile.addEventListener('click', () => {
            profileInfo.classList.add('hidden');
            profileEdit.classList.remove('hidden');
        });

        btnCancelEdit.addEventListener('click', () => {
            profileInfo.classList.remove('hidden');
            profileEdit.classList.add('hidden');
        });
    }

    // Balance Edit Form Toggle
    const btnAddBalance = document.getElementById('btn-add-balance');
    const btnCancelBalance = document.getElementById('btn-cancel-balance');
    const balanceEdit = document.getElementById('balance-edit');

    if (btnAddBalance && btnCancelBalance && profileInfo && balanceEdit) {
        btnAddBalance.addEventListener('click', () => {
            profileInfo.classList.add('hidden');
            balanceEdit.classList.remove('hidden');
        });

        btnCancelBalance.addEventListener('click', () => {
            profileInfo.classList.remove('hidden');
            balanceEdit.classList.add('hidden');
        });
    }
});
