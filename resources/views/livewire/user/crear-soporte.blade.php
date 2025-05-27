<div>
    <button wire:click="showModal" class="w-full text-sm btn-confirm-modal" data-tip="Crear Solicitud">
        <span>Crear solicitud Manual</span>
    </button>

    <x-dialog-modal wire:model='open' maxWidth="2xl" title="Solicitudes nacional" >
        <x-slot name="content">
            <div class="gap-3 col lg:flex-row lg:gap-5">
                <div class="gap-3 col lg:w-1/2">
                    <div>
                        <span class="title-input">Proveedor</span>
                        <select wire:model.live="provider" class="input-simple max-w-[400px]">
                            <option value="">Seleccionar Proveedor</option>
                            @foreach ($providers as $nombre)
                                <option value="{{ $nombre }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                        @error('provider')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Nombre del cliente</span>
                        <input wire:model.live="client_name" type="text" class="w-full input-simple"/>
                        @error('client_name')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Dirección del cliente</span>
                        <input wire:model.live="client_address" type="text" class="w-full input-simple"/>
                        @error('client_address')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Teléfono</span>
                        <input wire:model.live="client_phone" oninput="validateNumber(this)" type="text" class="w-full input-simple" />
                        @error('client_phone')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Tipo de vehiculo</span>
                        <select name="type_vehicle" id="type_vehicle" class="w-full input-simple" wire:model.live="type_vehicle">
                            <option value="0">Seleccionar tipo de vehiculo</option>
                            <option value="Camion">Camion</option>
                            <option value="Turbo">Turbo</option>
                            <option value="Tractomula">Tractomula</option>
                        </select>
                        @error('type_vehicle')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Tipo contenedor</span>
                        <select name="container_type" id="container_type" class="w-full input-simple" wire:model.live="container_type">
                            <option value="0">Seleccionar tipo de contenedor</option>
                            <option value="Contenedor de 40">Contenedor de 40</option>
                            <option value="Contenedor de 45">Contenedor de 45</option>=
                        </select>
                        @error('container_type')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Peso neto</span>
                        <input wire:model.live="order_weight" type="text" class="w-full input-simple"/>
                        @error('order_weight')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Peso bruto</span>
                        <input wire:model.live="gross_weight" type="text" class="w-full input-simple"/>
                        @error('gross_weight')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Fecha de la cita</span>
                        <input
                            type="date"
                            wire:model.live="date_quotation"
                            class="w-full input-simple"
                        />
                        @error('date_quotation')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="gap-3 col lg:w-1/2">
                    <div class="px-5 py-2 text-center bg-gray-100 dark:bg-zinc-800 rounded-xl">
                        <p class="font-light"><span class="font-semibold">Nota:</span> Los siguientes campos son opcionales</p>
                    </div>

                    <div>
                        <span class="title-input">Comentarios</span>
                        <textarea
                            class="w-full input-simple min-h-[80px]"
                            style="border-radius: 20px"
                            rows="5"
                            wire:model.live="comment"
                        ></textarea>
                        @error('comment')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Segunda Orden</span>
                        <input wire:model.live="searchOrderId" type="text" class="w-full input-simple"/>
                        @error('searchOrderId')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        @if ($orderSecond)
                            @livewire('user.national.details-second-order-live', [
                                'order_number' => $orderNumber2['order_number'],
                                'target_customer' => $orderNumber2['target_customer'],
                                'client_address' => $orderNumber2['client_address'],
                                'unit_load' => $orderNumber2['unit_load'],
                                'net_weight' => $orderNumber2['net_weight'],
                                'gross_weight' => $orderNumber2['gross_weight'],
                            ], key($orderNumber2['order_number'] . 'request'))
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="close" class="btn-close-modal">
                <p>Cancelar</p>
            </button>

            <button wire:click="store" class="btn-confirm-modal">
                <p>Crear solicitud</p>
            </button>
        </x-slot>
    </x-dialog-modal>
</div>

