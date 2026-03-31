@extends('layouts.master')
@section('title', 'Marcas - EL CUMBE EIRL')

@section('content')
    <div class="row box mt-5">
        <livewire:marcas.filtro />
        <livewire:marcas.tabla />
        <livewire:marcas.modal />
    </div>
@endsection

@section('scripts')
    @include('livewire.catalogos.scripts', ['module' => 'marcas', 'deleteEvent' => 'marcas:confirmar-eliminar'])
@endsection
