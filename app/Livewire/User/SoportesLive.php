<?php

namespace App\Livewire\User;

use Livewire\Component;

class SoportesLive extends Component
{
    public $orders;
    public $orderId;
    public $pending = 0;
    public $request_acepted;
    public $request_pending;
    public $request_rejected;
    public $request_finished;

    protected $listeners = ['request' => 'mount'];

    public function mount()
    {
        /* pendiente graficas
        $this->request_acepted = Request::where('status', 1)->count();
        $this->request_pending = Request::where('status', 0)->count();
        $this->request_rejected = Request::where('status', 2)->count();
        $this->request_finished = Request::where('status', 5)->count();*/
    }

    

    public function clear()
    {
        $this->orderId = '';
        $this->pending = 0;
        $this->orders = [];
    }

    public function render()
    {
        return view('livewire.user.soportes-live');
    }
}
