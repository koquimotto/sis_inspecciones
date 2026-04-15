@extends('layouts.master')
@section('title', 'Items - EL CUMBE EIRL')

@section('styles') @endsection

@section('content')
    <div  class="row box mt-5">
        
        <livewire:pages.items.filtro />
        <livewire:pages.items.tabla />
        
        {{-- <livewire:equipos.modal /> --}}
    </div>
    
@endsection

@section('scripts') @endsection