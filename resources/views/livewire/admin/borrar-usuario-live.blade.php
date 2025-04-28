<div>
    <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700" wire:click="$set('open', true)">
        Eliminar usuario
    </button>

    <x-dialog-modal maxWidth="md" wire:model="open">
        <x-slot name="title">
            <h2 class="text-lg font-semibold">
                Eliminar Usuario
            </h2>
        </x-slot>

        <x-slot name="content">
            <p>
                ¿Esta seguro de que desea eliminar el usuario {{ $user->name }}? <br>
                Esta acción no se puede deshacer.
            </p>
        </x-slot>

        <x-slot name="footer">
            <x-button class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700" wire:click="$set('open', false)">
                Cancelar
            </x-button>

            <x-button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700" wire:click="borrarUsuario">
                Eliminar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal maxWidth="md" wire:model="success">
        <x-slot name="content">
            <p>
                El usuario ha sido eliminado correctamente.
            </p>
        </x-slot>

        <x-slot name="footer">
            <x-button class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700" wire:click="closeSuccess">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
