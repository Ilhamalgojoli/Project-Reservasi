<div>
    <main class="w-full h-auto space-y-5 mb-5">
        <section class="grid lg:grid-cols-12 sm:grid-cols-1 md:grid-cols-2 gap-5">
            @livewire('admin.card-dashboard-admin')
            <div class="lg:col-span-4 md:col-span-12 sm:col-span-12 space-y-5 ">
                @livewire('admin.kegiatan-terkini')
                @livewire('admin.aktif-tidak-aktif-ruangan')
            </div>
        </section>
        <section class="grid grid-cols-12">
            @livewire('admin.peminjaman-per-fakultas')
        </section>
        <section class="grid grid-cols-12">
            @livewire('admin.okkupansi-ruangan')
        </section>
        <section class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="bg-white p-5 rounded-[8px] flex flex-col shadow-md gap-5">
                    @livewire('admin.monitor-dashboard')
                </div>
            </div>
        </section>
    </main>

    @push('extra_scripts')
        <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
    @endpush
</div>
