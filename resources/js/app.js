import './bootstrap';

// Impor SwiperJS (jika Anda menginstalnya via npm)
// import Swiper from 'swiper/bundle';
// import 'swiper/css/bundle';

// =========================================================================
//  FUNGSI-FUNGSI BANTUAN (HELPERS)
// =========================================================================

/**
 * Fungsi untuk mengatur toggle lihat/sembunyikan password.
 */
function setupPasswordToggle(inputId, toggleId) {
    const passwordInput = document.getElementById(inputId);
    const toggleButton = document.getElementById(toggleId);

    if (passwordInput && toggleButton) {
        toggleButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const eyeIcon = toggleButton.querySelector('.eye-icon');
            const eyeSlashIcon = toggleButton.querySelector('.eye-slash-icon');
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    }
}

/**
 * Fungsi untuk menampilkan pratinjau gambar pada input file.
 */
function setupImagePreview(inputId, previewContainerId, previewImgId) {
    const fileInput = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewContainerId);
    const previewImage = document.getElementById(previewImgId);

    if (fileInput && previewContainer && previewImage) {
        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.setAttribute('src', e.target.result);
                    // Tampilkan kontainer (hilangkan class 'hidden')
                    // dan pastikan ia terlihat (misal: flex atau block)
                    previewContainer.classList.remove('hidden');
                    previewContainer.style.display = 'flex';
                }
                reader.readAsDataURL(file);
            }
        });
    }
}


// =========================================================================
//  BLOK UTAMA: DIJALANKAN SETELAH HALAMAN SIAP
// =========================================================================

document.addEventListener('DOMContentLoaded', function () {

    // --- 1. Logika untuk Dropdown Navbar ---
    const profileButton = document.getElementById('profile-button');
    const profileDropdown = document.getElementById('profile-dropdown');

    const sidebar = document.getElementById('admin-sidebar');
    const openBtn = document.getElementById('sidebar-open-button');
    const closeBtn = document.getElementById('sidebar-close-button');
    const backdrop = document.getElementById('sidebar-backdrop');

    const openSidebar = () => {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
    };

    const closeSidebar = () => {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    };

    if (openBtn) {
        openBtn.addEventListener('click', openSidebar);
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }
    if (backdrop) {
        backdrop.addEventListener('click', closeSidebar);
    }

    if (profileButton && profileDropdown) {
        profileButton.addEventListener('click', function (event) {
            event.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });

        // Menutup dropdown saat klik di luar
        window.addEventListener('click', function (event) {
            if (!profileDropdown.classList.contains('hidden')) {
                if (!profileDropdown.contains(event.target) && !profileButton.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            }
        });
    }

    // --- 2. Logika untuk Menu Hamburger (Mobile) ---
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

    if (mobileMenuButton && mobileMenu && hamburgerIcon && closeIcon) {
        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
            hamburgerIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    }

    // --- 3. Inisialisasi Semua Toggle Password ---
    setupPasswordToggle('password', 'togglePassword');
    setupPasswordToggle('password_confirmation', 'togglePasswordConfirmation');

    // --- 4. Inisialisasi Semua Pratinjau Gambar ---
    // Halaman Auth
    setupImagePreview('avatar_url', 'image-preview-container', 'image-preview');
    // Halaman News
    setupImagePreview('news_image_url', 'news-image-preview-container', 'news-image-preview');
    // Halaman Sponsor
    setupImagePreview('logo_url_input', 'logo-preview-container', 'logo-preview');
    setupImagePreview('banner_image_input', 'banner-preview-container', 'banner-preview');
    setupImagePreview('edit_logo_url_input', 'edit-logo-preview-container', 'edit-logo-preview');
    setupImagePreview('edit_banner_image_input', 'edit-banner-preview-container', 'edit-banner-preview');
    // Halaman Gallery
    setupImagePreview('cover_url_input', 'cover-preview-container', 'cover-preview');
    setupImagePreview('photo-upload-input', 'photo-preview-container', 'photo-preview');
    // Halaman Events
    setupImagePreview('hero_image_url', 'hero-preview-container', 'hero-preview');
    // Halaman Programs
    setupImagePreview('icon_url', 'icon-preview-container', 'icon-preview');
    // Halaman Home Carousel
    setupImagePreview('image_url_upload', 'carousel-upload-preview-container', 'carousel-upload-preview');
    setupImagePreview('image_url_edit', 'carousel-edit-preview-container', 'carousel-edit-preview');

    // --- 5. Inisialisasi Swiper untuk "Program Kami" ---
    // Cek jika elemennya ada di halaman
    if (document.querySelector('.program-swiper')) {
        new Swiper('.program-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: { delay: 3000, disableOnInteraction: false, pauseOnMouseEnter: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4 },
            }
        });
    }

    // --- 6. Inisialisasi Swiper untuk "Event Mendatang" ---
    // Cek jika elemennya ada di halaman
    if (document.querySelector('.upcoming-events-swiper')) {
        new Swiper('.upcoming-events-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
    }

    const deleteButtons = document.querySelectorAll('.delete-confirm-button');


    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Mencegah aksi default tombol

            const form = this.closest('form'); // Cari form terdekat

            Swal.fire({
                title: 'Anda Yakin?',
                text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Jika dikonfirmasi, kirim form
                }
            });
        });
    });

    const logoutButtons = document.querySelectorAll('.logout-confirm-button');

    logoutButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Anda Yakin Ingin Logout?',
                text: "Sesi Anda akan diakhiri.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // --- LOGIKA BARU UNTUK DROPDOWN GALLERY ---
    const galleryButton = document.getElementById('gallery-dropdown-button');
    const galleryMenu = document.getElementById('gallery-dropdown-menu');

    if (galleryButton && galleryMenu) {
        galleryButton.addEventListener('click', function (event) {
            event.stopPropagation();
            galleryMenu.classList.toggle('hidden');
        });

        // Menutup dropdown saat klik di luar
        window.addEventListener('click', function (event) {
            if (!galleryMenu.classList.contains('hidden') && !galleryButton.contains(event.target)) {
                galleryMenu.classList.add('hidden');
            }
        });
    }
    const exampleModal = document.getElementById('exampleModal');
    const exampleModalText = document.getElementById('exampleModalText');
    const openExampleButtons = document.querySelectorAll('.show-example-btn');
    const closeExampleButtons = document.querySelectorAll('.js-close-example-modal');

    // Fungsi untuk membuka modal contoh
    function openExampleModal(exampleText) {
        exampleModalText.textContent = exampleText; // Isi teks ke dalam modal
        exampleModal.classList.remove('hidden'); // Tampilkan modal
    }

    // Fungsi untuk menutup modal contoh
    function closeExampleModal() {
        exampleModal.classList.add('hidden'); // Sembunyikan modal
    }

    // Tambahkan event listener ke setiap tombol "Show Example"
    openExampleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const text = this.dataset.example; // Ambil teks dari atribut data-example
            openExampleModal(text);
        });
    });

    // Tambahkan event listener ke setiap tombol penutup (X dan Close)
    closeExampleButtons.forEach(button => {
        button.addEventListener('click', closeExampleModal);
    });

    // Tutup modal jika klik di luar area konten modal
    exampleModal.addEventListener('click', function (event) {
        // Cek apakah yang diklik adalah latar belakang modal (bukan konten di dalamnya)
        if (event.target === exampleModal) {
            closeExampleModal();
        }
    });
});