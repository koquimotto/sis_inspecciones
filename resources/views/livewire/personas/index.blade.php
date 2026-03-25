@extends('layouts.master')
@section('title', 'Personas - EL CUMBE EIRL')

@section('styles') @endsection

@section('content')
    <div  class="row box mt-5">
        
        <livewire:personas.filtro />
        <livewire:personas.tabla />
        
        {{-- <livewire:personas.modal /> --}}
    </div>
    
@endsection

@section('scripts') @endsection