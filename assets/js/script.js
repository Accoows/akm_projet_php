console.log('Script loaded');

document.addEventListener('DOMContentLoaded', () => {

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
