<!DOCTYPE html>
<html lang="en">

<x-head />

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl p-6">
        <h1 class="text-xl font-semibold text-center text-gray-800 mb-6">
            Pilih Role
        </h1>

        @if (session('roles'))
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

                @foreach (session('roles') as $data)
                    <form method="POST" action="{{ route('chooseRole') }}">
                        @csrf

                        <input type="hidden" name="role_name" value="{{ $data['role'] }}">
                        <input type="hidden" name="role_id" value="{{ $data['id'] }}">

                        <button type="submit"
                            class="w-full h-24 bg-white border border-gray-200 rounded-lg p-4 
                                   hover:bg-gray-50 text-left flex items-center gap-3">

                            <div class="text-blue-500 text-xl shrink-0">
                                👤
                            </div>

                            <p class="text-gray-800 font-medium truncate w-full">
                                {{ $data['role'] }}
                            </p>

                        </button>
                    </form>
                @endforeach

            </div>
        @else
            <p class="text-center text-gray-500">
                Data role tidak ditemukan
            </p>
        @endif
    </div>
</body>
