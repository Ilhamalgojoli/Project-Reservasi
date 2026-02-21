@extends('layout.layout')
@php
    $title = 'Kelola Gedung';
    $script = '
        <script src="' . asset('assets/js/hover-card.js') . '" defer></script>
        <script type="module" src="' . asset('assets/js/leaflet.js') . '" defer></script>
    ';
@endphp

@section('content')
    @livewire('tambah-gedung') 
@endsection