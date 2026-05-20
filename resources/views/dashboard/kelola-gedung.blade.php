@extends('layout.layout')
@php
    $title = 'Kelola Gedung';
@endphp

@push('extra_scripts')
    <script src="{{ asset('assets/js/hover-card.js') }}" defer></script>
@endpush

@section('content')
    @livewire('admin.tambah-gedung', [], key('kelola-gedung-' . url()->current()))
@endsection