<div class="relative flex items-center" x-data>
    <button wire:click="toggle" class="relative flex items-center justify-center w-10 h-10 bg-white/10 hover:bg-white/20 border border-white/15 rounded-full transition-all duration-300 group shadow-sm active:scale-95">
        <iconify-icon icon="solar:bell-bing-bold-duotone" class="text-white text-xl group-hover:scale-110 group-hover:rotate-12 transition-all duration-300"></iconify-icon>
        @if($unread > 0)
            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-yellow-400 text-[10px] font-black text-gray-900 border-2 border-[rgb(226,19,19)] animate-bounce">
                {{ $unread }}
            </span>
        @endif
    </button>

    <div @if(!$open) style="display:none;" @endif class="absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-neutral-100 dark:border-neutral-700 z-50 py-3 overflow-hidden text-left">
        <div class="px-4 py-2 border-b border-neutral-100 dark:border-neutral-700 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="font-bold text-sm text-neutral-800 dark:text-neutral-200">Notifikasi</span>
                @if($unread > 0)
                    <span class="bg-red-50 dark:bg-red-950/30 text-[#e51411] dark:text-red-400 text-[10px] font-bold px-2 py-0.5 rounded-full">
                        {{ $unread }} Baru
                    </span>
                @endif
            </div>
            <button wire:click="$set('open', false)" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 transition-colors">
                <iconify-icon icon="solar:close-circle-bold" class="text-lg"></iconify-icon>
            </button>
        </div>

        <div class="max-h-[300px] overflow-y-auto scrollbar-none py-1 px-2 space-y-1">
            @if(empty($notifications))
                <div class="flex flex-col items-center justify-center py-10 text-neutral-400 dark:text-neutral-500 gap-2">
                    <iconify-icon icon="solar:bell-broken-bold-duotone" class="text-4xl opacity-30"></iconify-icon>
                    <p class="text-xs font-bold">Belum ada notifikasi baru</p>
                </div>
            @else
                @foreach($notifications as $notif)
                    @php
                        $isApprove = str_contains($notif['pesan'], 'disetujui');
                        $isReject = str_contains($notif['pesan'], 'ditolak');
                        $isCancel = str_contains($notif['pesan'], 'dibatalkan');

                        $cardStyle = 'bg-transparent hover:bg-neutral-50 dark:hover:bg-neutral-700/50';
                        $badgeStyle = 'bg-neutral-100 text-neutral-500 dark:bg-neutral-700 dark:text-neutral-400';
                        $iconName = 'solar:info-circle-bold-duotone';

                        if ($isApprove) {
                            $cardStyle = 'bg-emerald-50/20 hover:bg-emerald-50/50 dark:bg-emerald-950/10 dark:hover:bg-emerald-950/20';
                            $badgeStyle = 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400';
                            $iconName = 'solar:check-circle-bold-duotone';
                        } elseif ($isReject) {
                            $cardStyle = 'bg-rose-50/20 hover:bg-rose-50/50 dark:bg-rose-950/10 dark:hover:bg-rose-950/20';
                            $badgeStyle = 'bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400';
                            $iconName = 'solar:close-circle-bold-duotone';
                        } elseif ($isCancel) {
                            $cardStyle = 'bg-amber-50/20 hover:bg-amber-50/50 dark:bg-amber-950/10 dark:hover:bg-amber-950/20';
                            $badgeStyle = 'bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-400';
                            $iconName = 'solar:clock-circle-bold-duotone';
                        }
                    @endphp
                    
                    <div class="p-3 rounded-xl flex items-start gap-3 transition-colors {{ $cardStyle }}">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 {{ $badgeStyle }}">
                            <iconify-icon icon="{{ $iconName }}" class="text-lg"></iconify-icon>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-neutral-700 dark:text-neutral-300 leading-snug break-words whitespace-normal text-left">{{ $notif['pesan'] }}</p>
                            <p class="text-[10px] text-neutral-400 dark:text-neutral-500 mt-1 flex items-center gap-1">
                                <iconify-icon icon="solar:clock-circle-linear" class="text-xs"></iconify-icon>
                                <span>{{ $notif['waktu'] }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
