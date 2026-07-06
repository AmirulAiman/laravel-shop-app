@if(session()->has('success') || session()->has('error') || session()->has('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach(['success', 'error', 'info'] as $type)
                @if(session()->has($type))
                    Toastify({
                        text: @json(session($type)),
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        className: "toast-{{ $type }}",
                    }).showToast();
                @endif
            @endforeach
        });
    </script>
@endif