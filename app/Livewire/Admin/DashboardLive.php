<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class DashboardLive extends Component
{
    public $users;

    protected $listeners = ['updated' => 'mount'];

    public function mount()
    {
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-live', [
            'users' => $this->users,
        ]);
    }
}
