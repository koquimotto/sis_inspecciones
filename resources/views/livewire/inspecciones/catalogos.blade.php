@extends('layouts.master')
@section('title', 'Inspecciones - EL CUMBE EIRL')

@section('styles')


@endsection

@section('content')
    <livewire:inspecciones.catalogos-manager />

@endsection

@section('scripts')
    <script>
        window.addEventListener('confirmar-eliminar-catalogo-inspeccion', event => {
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
                    Livewire.dispatch('catalogos-inspeccion:delete', {
                        type: detail.type,
                        id: detail.id
                    });
                }
            });
        });
    </script>

@endsection
