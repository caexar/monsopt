<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class BorrarUsuarioLive extends Component
{
    public User $user;

    public $open = false;
    public $success = false;

    public function borrarUsuario()
    {
        $this->user->delete();
        $this->open = false;
        $this->success = true;
    }

    public function closeSuccess()
    {
        $this->dispatch('updated');
        $this->success = false;
    }

    public function render()
    {
        return view('livewire.admin.borrar-usuario-live');
    }
}
