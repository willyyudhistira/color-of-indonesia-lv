@if (session('success') || session('error') || session('warning') || session('info') || $errors->any())
<script>
document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 4000, // Durasi sedikit lebih lama untuk pesan error
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    @if (session('success'))
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif

    @if (session('error'))
        Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
    @endif
    
    @if (session('warning'))
        Toast.fire({ icon: 'warning', title: '{{ session('warning') }}' });
    @endif

    @if (session('info'))
        Toast.fire({ icon: 'info', title: '{{ session('info') }}' });
    @endif

    {{-- ## BAGIAN BARU UNTUK MENANGANI ERROR VALIDASI ## --}}
    @if ($errors->any())
        Toast.fire({
            icon: 'error',
            title: '{{ $errors->first() }}'
        });
    @endif
});
</script>
@endif