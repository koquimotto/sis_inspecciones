@extends('layouts.master')
@section('title', 'Servicios - EL CUMBE EIRL')

@section('content')
    <div class="row box mt-5">
        <livewire:servicios.filtro />
        <livewire:servicios.tabla />
        <livewire:servicios.modal />
    </div>
@endsection

@section('scripts')
    @include('livewire.catalogos.scripts', ['module' => 'servicios', 'deleteEvent' => 'servicios:confirmar-eliminar'])
@endsection
