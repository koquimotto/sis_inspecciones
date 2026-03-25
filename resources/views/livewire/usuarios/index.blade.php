@extends('layouts.master')
@section('title', 'Usuarios - EL CUMBE EIRL')

@section('styles') @endsection

@section('content')
    <div  class="row box mt-5">
        
        <livewire:usuarios.filtro />
        <livewire:usuarios.tabla />
        
        <livewire:usuarios.modal />
    </div>
    
@endsection

@section('scripts') @endsection

<script>
  document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('swal', (e) => {
      const d = e.detail || {};
      if (!window.Swal) return;

      Swal.fire({
        icon: d.icon || 'info',
        title: d.title || '',
        text: d.text || '',
        html: d.html || undefined,
        confirmButtonText: d.confirmText || 'Aceptar',
        timer: d.timer || undefined,
        timerProgressBar: !!d.timer,
        allowOutsideClick: d.allowOutsideClick ?? true,
        allowEscapeKey: d.allowEscapeKey ?? true,
        customClass: {
          popup: 'rounded-2xl',
          confirmButton: 'rounded-lg',
        }
      });
    });
  });
</script>