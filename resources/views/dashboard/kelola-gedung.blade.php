@extends('layout.layout')
@php
    $title = 'Kelola Gedung';
@endphp

@push('extra_scripts')
    <script src="{{ asset('assets/js/hover-card.js') }}" defer></script>
    <script type="module" src="{{ asset('assets/js/leaflet.js') }}" defer></script>
@endpush

@section('content')
    @livewire('admin.tambah-gedung') 
@endsection