<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EditarUsuarioLive extends Component
{
    public User $user;
    public $open = false;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function editarUsuario()
    {
        if ($this->password !== $this->password_confirmation) {
            $this->addError('password_confirmation', 'Las contraseñas no coinciden');
            return;
        }

        $existingUser = User::where('email', $this->email)->first();

        if ($existingUser) {
            $this->addError('email', 'El correo ya está en uso');
            return;
        }

        DB::beginTransaction();

        if ($this->name != '') {
            $this->user->update(['name' => $this->name]);
        }

        if ($this->email != '') {
            $this->user->update(['email' => $this->email]);
        }

        if ($this->password != '') {
            $this->user->update(['password' => $this->password]);
        }

        DB::commit();

        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        $this->dispatch('updated');
        $this->open = false;
    }

    public function close()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        $this->resetErrorBag();
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.admin.editar-usuario-live');
    }
}
