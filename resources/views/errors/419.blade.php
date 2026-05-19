<!DOCTYPE html>
<html lang="en">

<x-head />

<body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white overflow-hidden">
    <section class="bg-white dark:bg-dark-2 flex flex-col items-center justify-center min-h-[100vh] text-neutral-400 p-6">
        <div class="max-w-md w-full text-center space-y-8 animate-fade-in">
            
            <div class="relative w-48 h-48 mx-auto">
                <div class="absolute inset-0 bg-red-100 dark:bg-red-900/30 rounded-full animate-ping opacity-75"></div>
                <div class="relative w-full h-full bg-white dark:bg-dark-2 rounded-full shadow-2xl flex items-center justify-center border-4 border-red-50 dark:border-red-900/20">
                    <iconify-icon icon="solar:clock-circle-bold-duotone" class="text-[90px] text-red-600"></iconify-icon>
                </div>
            </div>

            <div class="space-y-4 relative z-10 mt-8">
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight">Sesi Berakhir</h1>
                <p class="text-lg text-gray-500 dark:text-gray-400 font-medium px-4">
                    Mohon maaf, halaman Anda telah <span class="font-bold text-gray-700 dark:text-gray-300">Timeout</span> (kadaluarsa) karena terlalu lama tidak ada aktivitas atau membiarkan halaman terbuka.
                </p>
            </div>

            <div class="pt-6 relative z-10">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center justify-center gap-3 w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-xl shadow-[0_20px_40px_-15px_rgba(220,38,38,0.5)] hover:shadow-[0_20px_40px_-10px_rgba(220,38,38,0.7)] transition-all transform hover:-translate-y-1 active:scale-[0.98]">
                    <iconify-icon icon="solar:login-2-bold" class="text-2xl"></iconify-icon>
                    <span>Masuk Kembali</span>
                </a>
            </div>

            <div class="pt-8 flex justify-center">
                <img src="{{ asset('assets/basila_images/basila_color.png') }}" alt="Basila" class="h-6 opacity-40 hover:opacity-100 transition-opacity grayscale hover:grayscale-0">
            </div>
        </div>
    </section>
</body>
</html>
