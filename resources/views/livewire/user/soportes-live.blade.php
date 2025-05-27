<div class="gap-3 col">
    {{-- Total de solicitudes por estado pendiente
    <x-utils.card-request-status
        :acepted="$request_acepted"
        :pending="$request_pending"
        :rejected="$request_rejected"
        :finished="$request_finished"
    />--}}

    <div class="gap-3 row">
        <div class="w-[28%] gap-3 p-4 card-theme col h-fit">
            <div class="relative col">
                @livewire('user.crear-soporte', key('soporte-'.auth()->user()->id))
            </div>
        </div>

        <div class="w-[72%]">
            <div
                x-data="{
                    typeRequest: 1,
                    activeClass: 'bg-[#ebecec] dark:bg-[#333333] font-semibold',
                    inactiveClass: '',
                    showFilter: false,
                }" class="relative p-8 col card-theme"
            >
                <div class="items-center justify-between row">
                    <div class="items-center row">
                        <a class="p-4 text-sm rounded-lg cursor-pointer" @click="typeRequest = 1" :class="typeRequest === 1 ? activeClass : inactiveClass">
                            {{ __('Solicitudes en Proceso')}}
                        </a>
                        <a class="p-4 text-sm rounded-lg cursor-pointer" @click="typeRequest = 2" :class="typeRequest === 2 ? activeClass : inactiveClass">
                            {{ __('Solicitudes por confirmar')}}
                        </a>
                        <a class="p-4 text-sm rounded-lg cursor-pointer" @click="typeRequest = 3" :class="typeRequest === 3 ? activeClass : inactiveClass">
                            {{ __('Historial de Soporte')}}
                        </a>
                    </div>
                </div>

                <div class="w-full">
                    <div x-show="typeRequest === 1" x-transition:enter.duration.500ms>
                        @livewire('user.pending-soporte', key('pending-'.auth()->user()->id))
                    </div>

                    <div x-show="typeRequest === 2" x-transition:enter.duration.500ms style="display: none">
                        @livewire('user.end-soporte', key('end-'.auth()->user()->id))
                    </div>

                    <div x-show="typeRequest === 3" x-transition:enter.duration.500ms style="display: none">
                        @livewire('user.history-soporte', key('history-'.auth()->user()->id))
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('message'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition:leave.duration.400ms
            wire:transition
            class="fixed z-40 items-center gap-3 px-4 py-2 text-sm font-light text-white rounded-lg bg-emerald-500 row bottom-4 right-4"
        >
            <x-icons.checked class="stroke-white size-5" />

            {{ session('message') }}
        </div>
    @endif
</div>
