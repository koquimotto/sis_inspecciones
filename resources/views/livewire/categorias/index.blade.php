@extends('layouts.master')
@section('title', 'Categorias - EL CUMBE EIRL')

@section('content')
    <div class="row box mt-5">
        <livewire:categorias.filtro />
        <livewire:categorias.tabla />
        <livewire:categorias.modal />
    </div>
@endsection

@section('scripts')
    @include('livewire.catalogos.scripts', ['module' => 'categorias', 'deleteEvent' => 'categorias:confirmar-eliminar'])
@endsection
