<flux:field wire:key="select-filter-{{ $filterKey }}" class="max-w-60 min-w-60 !gap-0.5">
    <x-grid::filter-label :label="$filter->label" :is-default="$filter->isDefault" :filter-key="$filterKey" />

    @if ($filter->useServerSearch)
        @if ($filter->useSeparateComponent)
            <livewire:server-search-select
                wire:key="select-input-{{ $filterKey }}"
                wire:model.live="filters.{{$filterKey}}.value"
                model-class="{{ $this->getFilterOptionsModel($filter->field) }}"
                model-field="{{ $field }}"
                grid-class="{{ $this::class }}"
                field="{{ $filter->field }}"
                :is-multiple="$filter->isMultiple"
            />
        @else
            <flux:select
                wire:model.change="filters.{{$filterKey}}.value"
                variant="listbox"
                :filter="false"
                :multiple="$filter->isMultiple"
                searchable
                clearable
                :disabled="$this->isFilterDisabled($filter->field)"
            >
                <x-slot name="search">
                    <flux:select.search wire:model.live.debounce="filters.{{$filterKey}}.search" :loading="false"/>
                </x-slot>
                @foreach ($this->getOptionsForFilter($filter) as $optionModel)
                    <flux:select.option value="{{ $optionModel->id }}" wire:key="{{ $optionModel->id }}">
                        {{ $optionModel->$field }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        @endif
    @else
        <flux:select
            wire:model.live="filters.{{$filterKey}}.value"
            searchable
            :multiple="$filter->isMultiple"
            clearable variant="listbox"
            class="!w-full"
            :disabled="$this->isFilterDisabled($filter->field)"
        >
            @foreach($this->getOptionsForFilter($filter) as $optionModel)
                <flux:select.option value="{{ $optionModel->id }}" wire:key="{{ $optionModel->id }}">{{ $optionModel->$field }}</flux:select.option>
            @endforeach
        </flux:select>
    @endif
</flux:field>

@props([
    'filter',
    'filterKey',
    'field',
])
