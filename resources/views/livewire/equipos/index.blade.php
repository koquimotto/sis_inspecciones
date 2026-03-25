@extends('layouts.master')
@section('title', 'Equipos / Maquinaria - EL CUMBE EIRL')

@section('styles') @endsection

@section('content')
    <div  class="row box mt-5">
        
        <livewire:equipos.filtro />
        <livewire:equipos.tabla />
        
        <livewire:equipos.modal />
    </div>
    
@endsection

@section('scripts') @endsection