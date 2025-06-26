<flux:field wire:key="boolean-filter-{{ $filterKey }}" class="max-w-40 min-w-40 !gap-0.5">
    <x-grid::filter-label :label="$filter->label" :is-default="$filter->isDefault" :filter-key="$filterKey" />

    <flux:select wire:model.live="filters.{{$filterKey}}.value" variant="listbox" class="!w-full">
        <flux:select.option value="0">Aktivní</flux:select.option>
        <flux:select.option value="1">Smazaný</flux:select.option>
    </flux:select>
</flux:field>

@props([
    'filter',
    'filterKey',
])
