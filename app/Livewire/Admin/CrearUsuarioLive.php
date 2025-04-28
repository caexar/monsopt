<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CrearUsuarioLive extends Component
{
    public $open = false;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role;

    public function crearUsuario()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
            'role' => 'required',
        ],
        [
            'name.required' => 'Ingrese un nnombre',
            'email.required' => 'Ingrese un correo',
            'password.required' => 'Ingrese una contraseña',
            'password_confirmation.required' => 'Ingrese una contraseña',
            'role.required' => 'Seleccione un rol',
        ]);

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

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'email_verified_at' => Carbon::now(),
            'remember_token'    => Str::random(10),
        ]);

        if ($this->role == 1) {
            $user->assignRole('Admin');
        } elseif ($this->role == 2) {
            $user->assignRole('Support');
        } elseif ($this->role == 3) {
            $user->assignRole('User');
        }

        DB::commit();

        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);
        session()->flash('message', '¡Usuario creado correctamente!');
        $this->dispatch('updated');
    }

    public function close()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);
        $this->resetErrorBag();
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.admin.crear-usuario-live');
    }
}
