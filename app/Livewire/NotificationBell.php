<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notifikasi;

class NotificationBell extends Component
{
    public $notifications = [];
    public $unread = 0;
    public $open = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $userId = session('user_identifier');
        if (!$userId) {
            $this->notifications = [];
            $this->unread = 0;
            return;
        }

        $items = Notifikasi::where('user_id', $userId)
            ->latest()
            ->limit(10)
            ->get();

        $this->notifications = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'pesan' => $item->pesan,
                'status' => $item->status,
                'waktu' => \Carbon\Carbon::parse($item->created_at)->locale('id')->diffForHumans(),
            ];
        })->toArray();

        $this->unread = Notifikasi::where('user_id', $userId)->where('status', 'Not Open')->count();
    }

    public function toggle()
    {
        $this->open = !$this->open;
        if ($this->open) {
            $this->markOpened();
        }
    }

    public function markOpened()
    {
        $userId = session('user_identifier');
        if (!$userId) return;

        Notifikasi::where('user_id', $userId)
            ->where('status', 'Not Open')
            ->update(['status' => 'Opened']);

        $this->loadNotifications();
        // Use Livewire v3 dispatch for browser events / inter-component events
        if (method_exists($this, 'dispatch')) {
            $this->dispatch('notificationsUpdated');
        }
    }

    protected $listeners = ['refreshNotifications' => 'loadNotifications'];

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
