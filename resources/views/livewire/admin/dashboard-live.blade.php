<div class="p-6 bg-white rounded">
    <div class="flex justify-end">
        @livewire('admin.crear-usuario-live')
    </div>

    <table class="w-full mt-6">
        <thead>
            <tr>
                <th class="py-2 text-sm border-b border-gray-400 text-start">Nombre</th>
                <th class="py-2 text-sm border-b border-gray-400 text-start">Email</th>
                <th class="py-2 text-sm border-b border-gray-400 text-start">Rol</th>
                <th class="py-2 text-sm border-b border-gray-400 text-start">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($users as $user)
                <tr wire:key="user-{{ $user->id }}" class="text-sm">
                    <td class="w-1/4 py-2">
                        {{ $user->name }}
                    </td>

                    <td class="w-1/4 py-2">
                        {{ $user->email }}
                    </td>

                    <td class="w-1/4 py-2">
                        {{ $user->getRoleNames()->first() }}
                    </td>

                    <td class="w-1/4 py-2">
                        <div class="flex gap-2">
                            @livewire('admin.borrar-usuario-live', ['user' => $user], key('delete-user-'.$user->id))

                            @livewire('admin.editar-usuario-live', ['user' => $user], key('edit-user-'.$user->id))
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
