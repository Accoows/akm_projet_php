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

    // Research header
    const headerSort = document.getElementById('headerSortDropdown');
    if (headerSort) {
        const trigger = headerSort.querySelector('.header-sort-trigger');
        const menu = headerSort.querySelector('.header-sort-menu');
        const input = document.getElementById('headerSortInput');
        const form = headerSort.closest('form');

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });

        headerSort.querySelectorAll('.header-sort-option').forEach(option => {
            option.addEventListener('click', function() {
                input.value = this.dataset.value;
                form.submit();
            });
        });

        document.addEventListener('click', () => {
            menu.style.display = 'none';
        });
    }

    // Custom Filter Dropdown logic (articles.php)
    const sortDropdown = document.getElementById('sortDropdown');
    if (sortDropdown) {
        const trigger = sortDropdown.querySelector('.custom-dropdown-trigger');
        const menu = sortDropdown.querySelector('.custom-dropdown-menu');
        const options = sortDropdown.querySelectorAll('.custom-dropdown-option');
        const input = document.getElementById('sortInput');
        const icon = trigger.querySelector('.fa-chevron-down');

        // Toggle menu
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = menu.style.display === 'block';
            menu.style.display = isOpen ? 'none' : 'block';
            icon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!sortDropdown.contains(e.target)) {
                menu.style.display = 'none';
                icon.style.transform = 'rotate(0deg)';
            }
        });

        // Handle option selection
        options.forEach(option => {
            option.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                input.value = value;

                // Submit the parent form
                input.closest('form').submit();
            });

            // Add hover effect
            option.addEventListener('mouseenter', function () {
                if (!this.classList.contains('active')) {
                    this.style.backgroundColor = 'rgba(255,255,255,0.05)';
                }
            });
            option.addEventListener('mouseleave', function () {
                this.style.backgroundColor = 'transparent';
            });
        });
    }
});
