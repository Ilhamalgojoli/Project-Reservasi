<!DOCTYPE html>
<html lang="en">

<x-head />

<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center p-4">
    <section class="w-full max-w-4xl">
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden">
            <div class="p-8 md:p-12">
                <!-- Header -->
                <div class="text-center mb-10">
                    <a href="{{ route('login') }}" class="inline-block mb-4">
                        <img src="{{ asset('assets/basila_images/basila_color.png') }}" width="120" alt="Basila Logo">
                    </a>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Pilih Role Anda</h2>
                    <p class="text-gray-500 mt-2">Silakan pilih akses role Anda untuk melanjutkan</p>
                </div>

                <!-- Role List -->
                @if (session('roles'))
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[50vh] overflow-y-auto px-2 custom-scrollbar">
                        @foreach (session('roles') as $data)
                            <form method="POST" action="{{ route('chooseRole') }}" class="h-full">
                                @csrf
                                <input type="hidden" name="role_name" value="{{ $data['role'] }}">
                                <input type="hidden" name="role_id" value="{{ $data['id'] }}">

                                <button type="submit"
                                    class="w-full h-full text-left flex items-center p-4 rounded-2xl border border-gray-100 shadow-sm hover:border-red-600 hover:bg-red-50 transition-all group">
                                    <div class="w-12 h-12 flex-shrink-0 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500 group-hover:bg-red-600 group-hover:text-white transition-colors mr-4">
                                        <iconify-icon icon="solar:user-id-bold-duotone" width="28"></iconify-icon>
                                    </div>
                                    <div class="overflow-hidden">
                                        <span class="block font-bold text-gray-800 truncate">{{ $data['role'] }}</span>
                                        <span class="block text-xs text-gray-400 truncate">Akses {{ $data['role'] }}</span>
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <div class="text-red-500 text-5xl mb-4">
                            <iconify-icon icon="solar:shield-warning-bold-duotone"></iconify-icon>
                        </div>
                        <p class="text-gray-500 font-medium">Data role tidak ditemukan</p>
                        <a href="{{ route('login') }}" class="text-red-600 text-sm hover:underline mt-4 inline-block font-semibold">
                            Kembali ke Login
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 text-center border-t border-gray-100">
                <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Basila Ticketing. All rights reserved.</p>
            </div>
        </div>
    </section>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
</html>
