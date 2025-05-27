<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\On;

class DashboardLive extends Component
{
    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.user.dashboard-live');
    }
}
