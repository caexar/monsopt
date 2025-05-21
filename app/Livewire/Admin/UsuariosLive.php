<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;

class UsuariosLive extends Component
{
    public function render()
    {
        return view('livewire.admin.usuarios-live');
    }
}
