<x-app-layout>
    @role('Admin')
        @livewire('admin.dashboard-live')
    @endrole

    @role('Support')
        @livewire('support.dashboard-live')
    @endrole

    @role('User')
        @livewire('user.dashboard-live')
    @endrole
</x-app-layout>
