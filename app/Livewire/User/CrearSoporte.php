<?php

namespace App\Livewire\User;

use Soap\Sdl;
use Livewire\Component;
use App\Models\Inventario;
use App\Models\Solicitudes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CrearSoporte extends Component
{
    public $open = false;
    public $providers = [];
    public $id_pc;
    public $tipo_soporte;
    public $nombre_solicitante;
    public $email_solicitante;
    public $telefono_solicitante;
    public $descripcion;
    public $fecha_solicitud_inicio;
    public $fecha_solicitud_fin;
    public $fechaCita;

    public function showModal()
    {
        $this->open = true;
    }

    public function updated($field)
    {
        $this->resetErrorBag($field);
    }

    public function updatedFechaCita($value)
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        if ($value < $todayDate) {
            $this->addError('fechaCita', 'La fecha de la orden no puede ser menor a la fecha de hoy');
        } else {
            $this->resetErrorBag('fechaCita');
        }
    }

    public function store()
    {
        $this->validate([
            'id_pc' => 'required',
            'tipo_soporte' => 'required',
            'nombre_solicitante' => 'required',
            'email_solicitante' => 'required|email',
            'telefono_solicitante' => 'required',
            'descripcion' => 'required',
            'fecha_solicitud_inicio' => 'required|date|after_or_equal:today',
        ],
        [
            'id_pc.required' => 'Seleccione un equipo.',
            'tipo_soporte.required' => 'El tipo de soporte es obligatorio.',
            'nombre_solicitante.required' => 'El nombre del solicitante es obligatorio.',
            'email_solicitante.required' => 'El email del solicitante es obligatorio.',
            'email_solicitante.email' => 'El email debe ser una dirección de correo válida.',
            'telefono_solicitante.required' => 'El teléfono del solicitante es obligatorio.',
            'descripcion.required' => 'La descripción del problema es obligatoria.',
            'fecha_solicitud_inicio.required' => 'La fecha de inicio de la solicitud es obligatoria.',
            'fecha_solicitud_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_solicitud_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a hoy.',
        ]);

        DB::beginTransaction();

        $empresa = Inventario::where('referencia', $this->id_pc)->first()->empresa;

        Solicitudes::create([
            'empresa' => $empresa,
            'id_pc' => $this->id_pc,
            'tipo_soporte' => $this->tipo_soporte,
            'nombre_solicitante' => $this->nombre_solicitante,
            'email_solicitante' => $this->email_solicitante,
            'telefono_solicitante' => $this->telefono_solicitante,
            'descripcion' => $this->descripcion,
            'fecha_solicitud_inicio' => $this->fecha_solicitud_inicio,
            'fecha_solicitud_fin' => $this->fecha_solicitud_fin,
            'estado' => 1, // Estado 1: Pendiente
        ]);

        DB::commit();


        $this->resetRequest();
        $this->open = false;
        $this->dispatch('request');
        $this->dispatch('resetSearch');
        $this->dispatch('successful-toast', message: '¡Solicitud creada exitosamente!');
    }

    public function close()
    {
        $this->resetRequest();
        $this->open = false;
    }

    public function resetRequest()
    {
        $this->reset([
            'id_pc',
            'tipo_soporte',
            'nombre_solicitante',
            'email_solicitante',
            'telefono_solicitante',
            'descripcion',
            'fecha_solicitud_inicio',
            'fecha_solicitud_fin',
        ]);

        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.user.crear-soporte');
    }
}
