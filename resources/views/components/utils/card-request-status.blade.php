<div class="grid grid-cols-4 px-3 py-5 divide-x-theme card-theme">
    <div class="gap-2 center-content">
        <div class="bg-blue-100 rounded-full center-content size-10">
            <x-icons.message-check class="stroke-blue-500 size-5" />
        </div>

        <div class="col">
            <span class="text-xl leading-[25px] font-semibold">{{ $acepted }}</span>
            <div class="font-light col">
                <span class="text-[10px] leading-[10px]">Total</span>
                <span class="text-[13px] leading-[13px]">Aceptadas</span>
            </div>
        </div>
    </div>

    <div class="gap-2 center-content">
        <div class="bg-yellow-100 rounded-full center-content size-10">
            <x-icons.clock class="stroke-yellow-500 size-5" />
        </div>

        <div class="col">
            <span class="text-xl leading-[25px] font-semibold">{{ $pending }}</span>
            <div class="font-light col">
                <span class="text-[10px] leading-[10px]">Total</span>
                <span class="text-[13px] leading-[13px]">Pendiendtes</span>
            </div>
        </div>
    </div>

    <div class="gap-2 center-content">
        <div class="bg-red-100 rounded-full center-content size-10">
            <x-icons.x-mark class="stroke-red-500 size-5" />
        </div>

        <div class="col">
            <span class="text-xl leading-[25px] font-semibold">{{ $rejected }}</span>
            <div class="font-light col">
                <span class="text-[10px] leading-[10px]">Total</span>
                <span class="text-[13px] leading-[13px]">Rechazadas</span>
            </div>
        </div>
    </div>

    <div class="gap-2 center-content">
        <div class="rounded-full bg-emerald-100 center-content size-10">
            <x-icons.check-circle class="stroke-emerald-500 size-5" />
        </div>

        <div class="col">
            <span class="text-xl leading-[25px] font-semibold">{{ $finished }}</span>
            <div class="font-light col">
                <span class="text-[10px] leading-[10px]">Total</span>
                <span class="text-[13px] leading-[13px]">Finalizadas</span>
            </div>
        </div>
    </div>
</div>
