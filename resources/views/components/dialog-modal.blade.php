@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        @isset($title)
            <div class="text-lg font-medium text-gray-900">
                {{ $title }}
            </div>
        @endisset

        <div class="mt-4 text-sm text-gray-600">
            {{ $content }}
        </div>
    </div>

    @isset($footer)
        <div class="flex flex-row justify-end gap-2 px-6 py-4 bg-gray-100 text-end">
            {{ $footer }}
        </div>
    @endisset
</x-modal>
