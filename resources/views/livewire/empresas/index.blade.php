@extends('layouts.master')
@section('title', 'Empresas - EL CUMBE EIRL')

@section('styles')
@endsection

@section('content')
    <div class="row box mt-5">
        <livewire:empresas.filtro />
        <livewire:empresas.tabla />
        <livewire:empresas.modal />
    </div>
@endsection

@section('scripts')
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

        window.addEventListener('confirmar-desactivar-empresa', event => {
            const detail = event.detail?.[0] ?? event.detail ?? {};

            Swal.fire({
                icon: 'warning',
                title: '¿Deseas desactivar esta empresa?',
                text: detail.text || 'La empresa pasará a estado inactivo.',
                showCancelButton: true,
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                zIndex: 20000
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('empresas:confirmar-desactivar', {
                        id: detail.id
                    });
                }
            });
        });
    </script>
@endsection