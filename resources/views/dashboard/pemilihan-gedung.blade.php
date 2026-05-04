@extends('layout.layout')
@php
    $title = 'Reservasi Ruangan';
@endphp

@push('extra_scripts')
    <script src="{{ asset('assets/js/hover-card.js') }}" defer></script>
@endpush

@section('content')
    @livewire('user.pilih-gedung', [], key('pilih-gedung-' . url()->current()))
@endsection
