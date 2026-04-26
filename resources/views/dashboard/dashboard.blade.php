@extends('layout.layout')
@php
    $title = 'Dashboard';
@endphp

@push('extra_scripts')
    <script src="{{ asset('assets/js/basilaChart.js') }}"></script>
@endpush

@section('content')
    <div class="mb-5 flex flex-col gap-2">
        <h1 class="font-extrabold text-3xl text-gray-800 tracking-tight">{{ $title }}</h1>
        <p class="text-gray-400 text-sm font-medium">Selamat datang di dashboard {{ session('username') }}</p>
    </div>

    @if (session('role_name') === 'BAA')
        @livewire('admin.dashboard-admin')
    @else
        @livewire('user.dashboard-user')
    @endif
@endsection
