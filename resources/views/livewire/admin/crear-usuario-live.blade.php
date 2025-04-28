<div>
    <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="$set('open', true)">
        Crear usuario
    </button>

    <x-dialog-modal maxWidth="md" wire:model="open">
        <x-slot name="title">
            <h2 class="text-lg font-semibold">
                Crear Usuario
            </h2>
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col gap-4">
                @if (session()->has('message'))
                    <div class="p-4 bg-emerald-100 text-emerald-500" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="flex flex-col">
                    <label class="text-sm font-light">Nombre</label>
                    <input class="h-10" type="text" wire:model="name">
                    @error ('name')
                        <span class="text-xs font-light text-red-400">
                            {{ $message }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-light">Email</label>
                    <input class="h-10" type="email" wire:model="email">
                    @error ('email')
                        <span class="text-xs font-light text-red-400">
                            {{ $message }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-light">Contraseña</label>
                    <input class="h-10" type="password" wire:model="password">
                    @error ('password')
                        <span class="text-xs font-light text-red-400">
                            {{ $message }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-light">Confirmar Contraseña</label>
                    <input class="h-10" type="password" wire:model="password_confirmation">
                    @error ('password_confirmation')
                        <span class="text-xs font-light text-red-400">
                            {{ $message }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-light">Rol</label>
                    <select class="h-10" wire:model="role">
                        <option value="">Selecciona el rol</option>
                        <option value="1">Admin</option>
                        <option value="2">Soporte</option>
                        <option value="3">Usuario</option>
                    </select>
                    @error ('role')
                        <span class="text-xs font-light text-red-400">
                            {{ $message }}
                        </span>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700" wire:click="close">
                Cancelar
            </x-button>

            <x-button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="crearUsuario">
                Crear
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
