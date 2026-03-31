@extends('layouts.master')
@section('title', 'Modelos - EL CUMBE EIRL')

@section('content')
    <div class="row box mt-5">
        <livewire:modelos.filtro />
        <livewire:modelos.tabla />
        <livewire:modelos.modal />
    </div>
@endsection

@section('scripts')
    @include('livewire.catalogos.scripts', ['module' => 'modelos', 'deleteEvent' => 'modelos:confirmar-eliminar'])
@endsection
