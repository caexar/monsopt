<div>
    <button wire:click="showModal" class="w-full text-sm btn-confirm-modal" data-tip="Crear Solicitud">
        <span>Crear solicitud Manual</span>
    </button>

    <x-dialog-modal wire:model='open' maxWidth="2xl" title="Solicitudes nacional" >
        <x-slot name="content">
            <div class="gap-3 col lg:flex-row lg:gap-5">
                <div class="gap-3 col lg:w-1/2">
                    <div>
                        <span class="title-input">Tipo de soporte</span>
                        <select wire:model.live="tipo_soporte" class="input-simple max-w-[400px]">
                            <option value="">Seleccionar soporte</option>
                            @foreach ($providers as $nombre)
                                <option value="{{ $nombre }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_soporte')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Pc</span>
                        <input type="text" wire:model.live="id_pc" class="input-simple max-w-[400px] h-32"></input>
                        @error('id_pc')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">nombre_solicitante</span>
                        <input type="text" wire:model.live="nombre_solicitante" class="input-simple max-w-[400px] h-32"></input>
                        @error('nombre_solicitante')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">email_solicitante</span>
                        <input type="text" wire:model.live="email_solicitante" class="input-simple max-w-[400px] h-32"></input>
                        @error('email_solicitante')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">telefono_solicitante</span>
                        <input type="number" wire:model.live="telefono_solicitante" class="input-simple max-w-[400px] h-32"></input>
                        @error('telefono_solicitante')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Fecha de solicitud inicio</span>
                        <input type="date" wire:model.live="fecha_solicitud_inicio" class="input-simple max-w-[400px]">
                        @error('fecha_solicitud_inicio')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Fecha de solicitud fin</span>
                        <input type="date" wire:model.live="fecha_solicitud_fin" class="input-simple max-w-[400px]">
                        @error('fecha_solicitud_fin')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <span class="title-input">Descripción</span>
                        <textarea wire:model.live="description" class="input-simple max-w-[400px] h-32"></textarea>
                        @error('description')
                            <span class="err">
                                {{ $message }}
                            </span>
                        @enderror
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

