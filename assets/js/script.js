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

    // Image Upload Preview functionality
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener('load', function () {
                    imagePreview.src = this.result;
                    if (previewContainer) {
                        previewContainer.classList.remove('hidden');
                    } else {
                        imagePreview.classList.remove('hidden'); // Fallback if no container
                    }
                });

                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                if (previewContainer) {
                    previewContainer.classList.add('hidden');
                } else {
                    imagePreview.classList.add('hidden'); // Fallback
                }
            }
        });
    }
});
