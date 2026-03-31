@extends('layouts.master')
@section('title', 'Tipos - EL CUMBE EIRL')

@section('content')
    <div class="row box mt-5">
        <livewire:tipos.filtro />
        <livewire:tipos.tabla />
        <livewire:tipos.modal />
    </div>
@endsection

@section('scripts')
    @include('livewire.catalogos.scripts', ['module' => 'tipos', 'deleteEvent' => 'tipos:confirmar-eliminar'])
@endsection
