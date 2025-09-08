@if (session('success') || session('error') || session('warning') || session('info'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif

    @if (session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
        });
    @endif
    
    @if (session('warning'))
        Toast.fire({
            icon: 'warning',
            title: '{{ session('warning') }}'
        });
    @endif

    @if (session('info'))
        Toast.fire({
            icon: 'info',
            title: '{{ session('info') }}'
        });
    @endif

    @if ($errors->any())
        Toast.fire({
            icon: 'error',
            title: 'Oops! Periksa kembali input Anda.'
        });
    @endif
});
</script>
@endif