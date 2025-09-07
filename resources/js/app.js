// resources/js/app.js

import './bootstrap';

// Jalankan script setelah seluruh halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    
    // --- Logika untuk Dropdown Profil (Desktop) ---
    const profileButton = document.getElementById('profile-button');
    const profileDropdown = document.getElementById('profile-dropdown');

    if (profileButton) {
        profileButton.addEventListener('click', function(event) {
            // Mencegah event 'click' menyebar ke window
            event.stopPropagation(); 
            // Toggle (tampilkan/sembunyikan) dropdown
            profileDropdown.classList.toggle('hidden');
        });
    }

    // --- Logika untuk Menutup Dropdown Saat Klik di Luar ---
    window.addEventListener('click', function(event) {
        if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
            // Sembunyikan dropdown jika klik terjadi di luar area dropdown dan tombolnya
            if (!profileDropdown.contains(event.target) && !profileButton.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        }
    });

    // --- Logika untuk Menu Hamburger (Mobile) ---
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            hamburgerIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    }
});

/**
 * Fungsi untuk mengatur toggle lihat/sembunyikan password.
 * @param {string} inputId - ID dari input field password.
 * @param {string} toggleId - ID dari tombol ikon mata.
 */
function setupPasswordToggle(inputId, toggleId) {
    const passwordInput = document.getElementById(inputId);
    const toggleButton = document.getElementById(toggleId);

    // Hanya jalankan jika kedua elemen ada di halaman
    if (passwordInput && toggleButton) {
        toggleButton.addEventListener('click', function() {
            // Ubah tipe input dari 'password' ke 'text' atau sebaliknya
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon mata yang ditampilkan
            const icons = toggleButton.querySelectorAll('.iconify');
            icons.forEach(icon => icon.classList.toggle('hidden'));
        });
    }
}

// Jalankan fungsi setelah seluruh halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Terapkan fungsi ke semua input password yang kita punya
    setupPasswordToggle('password', 'togglePassword');
    setupPasswordToggle('password_confirmation', 'togglePasswordConfirmation');
});

/**
 * Fungsi untuk menampilkan pratinjau gambar pada input file.
 * @param {string} inputId - ID dari input file.
 * @param {string} previewContainerId - ID dari div pembungkus pratinjau.
 * @param {string} previewImgId - ID dari elemen img untuk pratinjau.
 */
function setupImagePreview(inputId, previewContainerId, previewImgId) {
    const fileInput = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewContainerId);
    const previewImage = document.getElementById(previewImgId);

    if (fileInput && previewContainer && previewImage) {
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.setAttribute('src', e.target.result);
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }
}

// Jalankan setelah halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    setupImagePreview('avatar_url', 'image-preview-container', 'image-preview');
    setupImagePreview('news_image_url', 'news-image-preview-container', 'news-image-preview');
    setupImagePreview('logo_url_input', 'logo-preview-container', 'logo-preview');
    setupImagePreview('banner_image_input', 'banner-preview-container', 'banner-preview');
    setupImagePreview('edit_logo_url_input', 'edit-logo-preview-container', 'edit-logo-preview');
    setupImagePreview('edit_banner_image_input', 'edit-banner-preview-container', 'edit-banner-preview');
    setupImagePreview('cover_url_input', 'cover-preview-container', 'cover-preview');
    setupImagePreview('photo-upload-input', 'photo-preview-container', 'photo-preview');
    setupImagePreview('hero_image_url', 'hero-preview-container', 'hero-preview');
    setupImagePreview('hero_image_url', 'hero-preview-container', 'hero-preview');
    setupImagePreview('icon_url', 'icon-preview-container', 'icon-preview');
    setupImagePreview('image_url_upload', 'carousel-upload-preview-container', 'carousel-upload-preview');
    setupImagePreview('image_url_edit', 'carousel-edit-preview-container', 'carousel-edit-preview');
});