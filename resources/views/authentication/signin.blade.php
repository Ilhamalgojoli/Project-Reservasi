<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<x-head />

<body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white overflow-hidden">
    @if (session('error'))
        <div class="alert alert-danger bg-red-200 text-danger-600 border border-danger-600 px-6 py-[11px] font-semibold text-lg rounded-lg flex items-center justify-between w-1/2 absolute translate-x-1/2 mt-2 animate-fade-in"
            role="alert">
            {{ session('error') }}
            <button class="remove-button text-danger-600 text-2xl line-height-1">
                <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
            </button>
        </div>
    @endif
    <section class="bg-white dark:bg-dark-2 flex flex-wrap min-h-[100vh] text-neutral-400">
        <div class="lg:w-1/2 lg:block hidden">
            <div class="flex items-center flex-col h-full justify-center bg-red-600">
                <img src="{{ asset('assets/basila_images/telu.png') }}" alt="telu" class="w-2/3 max-w-[500px] drop-shadow-2xl">
            </div>
        </div>

        <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
            <div class="lg:max-w-[464px] mx-auto w-full">
                <div>
                    <a href="{{ route('index') }}" class="mb-2.5 max-w-[290px]">
                        <img src="{{ asset('assets/basila_images/basila_color.png') }}" alt="" width="100px">
                    </a>
                    <h4 class="mb-3">Masuk ke akun anda</h4>
                    <p class="mb-8 text-secondary-light text-lg">Selamat datang kembali! Silakan masukkan detail Anda
                    </p>
                </div>

                @if ($errors->has('signIn'))
                    <div class="alert alert-danger bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 border-danger-100 px-6 py-[11px] mb-5 font-semibold text-lg rounded-lg"
                        role="alert">
                        <div class="flex items-start justify-between text-lg">
                            <div class="flex items-start gap-2">
                                <iconify-icon icon="ep:warn-triangle-filled"
                                    class="icon text-xl mt-1.5 shrink-0"></iconify-icon>
                                <div>
                                    <p class="font-medium text-danger-600 text-sm mt-2">{{ $errors->first('signIn') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="form flex flex-col gap-5">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Username SSO</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-gray-400 group-focus-within:text-red-600 transition-colors">
                                <iconify-icon icon="solar:user-bold" class="text-xl"></iconify-icon>
                            </span>
                            <input type="text" name="username"
                                class="w-full py-3.5 ps-11 pe-4 border border-neutral-200 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all
                                bg-neutral-50 dark:bg-dark-2 rounded-xl outline-none text-gray-900 dark:text-white"
                                placeholder="Masukkan username SSO Anda" autocomplete="username">
                        </div>
                        @error('username')
                            <p class="text-red-600 text-xs font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-gray-400 group-focus-within:text-red-600 transition-colors">
                                <iconify-icon icon="solar:lock-password-bold" class="text-xl"></iconify-icon>
                            </span>
                            <input type="password" name="password"
                                class="w-full py-3.5 ps-11 pe-12 border border-neutral-200 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all
                                bg-neutral-50 dark:bg-dark-2 rounded-xl outline-none text-gray-900 dark:text-white"
                                id="your-password" placeholder="••••••••" autocomplete="current-password">
                            <button type="button" 
                                class="toggle-password absolute inset-y-0 end-0 ps-3 pe-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                                data-toggle="#your-password">
                                <iconify-icon icon="solar:eye-bold" class="text-xl"></iconify-icon>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-600 text-xs font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-1">
                        <a href="https://satu.telkomuniversity.ac.id/auth/forgot-password"
                            class="text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">Lupa password?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-red-600/20 hover:shadow-red-600/40 transition-all transform active:scale-[0.98] mt-4 flex items-center justify-center gap-2">
                        <span>Masuk Sekarang</span>
                        <iconify-icon icon="solar:alt-arrow-right-bold" class="text-xl"></iconify-icon>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const alert = document.querySelector('.alert');

            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = 0;

                setTimeout(() =>
                    alert.remove(), 500);
            }, 2000);
        });
    </script>
</body>
</html>
