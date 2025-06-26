<flux:field wire:key="text-filter-{{ $filterKey }}" class="max-w-80 min-w-80 !gap-0.5">
    <x-grid::filter-label :label="$filter->label" :is-default="$filter->isDefault" :filter-key="$filterKey" />

    <flux:input.group>
        <flux:select wire:model.live="filters.{{$filterKey}}.operator" variant="listbox" class="!w-[40%]">
            <flux:select.option value="like">Obsahuje</flux:select.option>
            <flux:select.option value="not like">Neobsahuje</flux:select.option>
        </flux:select>
        <flux:input wire:key="text-filter-{{$filterKey}}" wire:model.live.debounce="filters.{{$filterKey}}.value" class="max-w-60" :loading="false"/>
    </flux:input.group>
</flux:field>

@props([
    'filter',
    'filterKey',
])
