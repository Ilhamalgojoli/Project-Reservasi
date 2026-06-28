@extends('layout.layout')
@php
    $title = 'Peminjaman Aktif';
@endphp

@section('content')
    <div class="mb-5 flex flex-col gap-2">
        <h1 class="font-extrabold text-3xl text-gray-800 tracking-tight">{{ $title }}</h1>
        <p class="text-gray-400 text-sm font-medium">Daftar peminjaman yang sudah disetujui dan dapat dibatalkan jika
            diperlukan</p>
    </div>

    <main class="grid grid-cols-1 gap-6">
        <section class="col-span-12">
            <livewire:admin.cancel-booking :detail-id="$detailId" />
        </section>
    </main>

    @if (!empty($detailId))
        @push('scripts')
            <script>
                document.addEventListener('livewire:load', function () {
                    window.dispatchEvent(new CustomEvent('showApprovalDetail', {
                        detail: { id: {{ $detailId }} }
                    }));
                });
            </script>
        @endpush
    @endif
@endsection
