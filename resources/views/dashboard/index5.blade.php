@extends('layout.layout')
@php
    $title = 'Tambah Gedung';
    $script = '

    ';
@endphp

@section('content')
    <h1 class="text-2xl mb-5    ">{{ $title }}</h1>

    <main class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
        <section class="col-span-12 rounded-2xl bg-white shadow-lg p-8">
            <div class="flex flex-col gap-5">
                <h1>Tambah </h1>
            </div>
        </section>

        <section class="col-span-12 rounded-2xl bg-white shadow-lg p-8">
            <div class="">
                
            </div>
        </section>
    </main>
@endsection
