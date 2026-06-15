<x-filament-panels::page>
    <form wire:submit.prevent="duplicate">
        {{ $this->form }}

        <div style="margin-top: 50px; text-align: right;">
            <x-filament::button type="submit" icon="tabler-copy">
                Duplicate Server
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
