@extends('layouts.master')
@section('title', 'Formulario de Inspeccion - EL CUMBE EIRL')

@section('styles')
@endsection

@section('content')
    <livewire:inspecciones.formulario :inspeccion="$inspeccion ?? null" />
@endsection

@section('scripts')
@endsection
