<script>
    window.addEventListener('swal', event => {
        const detail = event.detail?.[0] ?? event.detail ?? {};

        Swal.fire({
            icon: detail.type || 'info',
            title: detail.title || 'Mensaje',
            text: detail.text || '',
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'rounded-2xl'
            },
            zIndex: 20000
        });
    });

    window.addEventListener('confirmar-eliminar-{{ $module }}', event => {
        const detail = event.detail?.[0] ?? event.detail ?? {};

        Swal.fire({
            icon: 'warning',
            title: 'Deseas eliminar este registro?',
            text: detail.text || 'El registro se eliminara logicamente.',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            zIndex: 20000
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('{{ $deleteEvent }}', {
                    id: detail.id
                });
            }
        });
    });
</script>
