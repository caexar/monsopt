<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;

class DashboardLive extends Component
{
    use WithPagination;

    public $numberOfPaginatorsRendered = [];

    protected $listeners = ['updated' => '$refresh']; // <-- aquí corregido

    public function render()
    {
        return view('livewire.admin.dashboard-live', [
            'users' => User::paginate(10),
        ]);
    }
}
