<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Notifikasi;

class NotificationBell extends Component
{
    public $notifications = [];
    public $unread = 0;
    public $open = false;
    protected $listeners = [
        'refreshNotifications' => 'loadNotifications'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        # Ambil ID User yang sedang login
        $userId = session('user_identifier');
        if (!$userId) {
            $this->notifications = [];
            $this->unread = 0;
            return;
        }

        # Ambil semua data notifikasi dari User yang sedang login dengan urutan terbaru
        $items = Notifikasi::where('user_id', $userId)
            ->latest()
            ->limit(10)
            ->get();

        # Isi property variable unread dengan pesan user dengan kondisi belum dibuka dan dihitung jumlah nya
        $this->unread = Notifikasi::where('user_id', $userId)
            ->where('status', 'Not Open')->count();

        $this->notifications = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'pesan' => $item->pesan,
                'status' => $item->status,
                'waktu' => \Carbon\Carbon::parse($item->created_at)->locale('id')->diffForHumans(),
            ];
        })->toArray();
    }

    public function toggle()
    {
        $this->open = !$this->open;
        if ($this->open) {
            $this->readMsg();
        }
    }

    # Update jika notifikasi sudah di buka
    public function readMsg()
    {
        $userId = session('user_identifier');
        if (!$userId) return;

        Notifikasi::where('user_id', $userId)
            ->where('status', 'Not Open')
            ->update(['status' => 'Opened']);

        # Load data kembali
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.user.notification-bell');
    }
}
