<flux:field wire:key="date-filter-{{ $filterKey }}" class="max-w-80 min-w-80 !gap-0.5">
    <x-grid::filter-label :label="$filter->label" :is-default="$filter->isDefault" :filter-key="$filterKey" />

    <flux:input.group>
        <flux:select wire:model.live="filters.{{$filterKey}}.operator" variant="listbox" class="min-w-28 max-w-28">
            <flux:select.option value="<">Před</flux:select.option>
            <flux:select.option value="=">Přesně</flux:select.option>
            <flux:select.option value=">">Po</flux:select.option>
        </flux:select>
        <flux:date-picker wire:model.live.debounce="filters.{{$filterKey}}.value" class="max-w-52 min-w-52" />
    </flux:input.group>
</flux:field>

@props([
    'filter',
    'filterKey',
])
