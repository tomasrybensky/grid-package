<div class="flex flex-wrap gap-4">
    @foreach($this->filters as $key => $filter)
        @if($filter instanceof \Grid\Data\Filters\SelectFilter)
            @php
                $parts = explode('.', $filter->field);
                $field = array_pop($parts);
            @endphp

            <x-grid::select-filter :filter="$filter" :filter-key="$key" :field="$field" />
        @endif

        @if ($filter instanceof \Grid\Data\Filters\TextFilter)
            <x-grid::text-filter :filter="$filter" :filter-key="$key" />
        @endif

        @if ($filter instanceof \Grid\Data\Filters\BooleanFilter)
            <x-grid::boolean-filter :filter="$filter" :filter-key="$key" />
        @endif

        @if ($filter instanceof \Grid\Data\Filters\DateFilter)
            <x-grid::date-filter :filter="$filter" :filter-key="$key" />
        @endif

        @if ($filter instanceof \Grid\Data\Filters\SoftDeleteFilter)
            <x-grid::soft-delete-filter :filter="$filter" :filter-key="$key" />
        @endif

    @endforeach

    @if ($this->columns->where('filterable', true)->isNotEmpty())
        <flux:dropdown class="self-end">
            <flux:button icon="plus">Filtry</flux:button>
            <flux:menu>
                @foreach($this->columns->where('filterable', true)->where('defaultFilter', false) as $column)

                    @if ($column instanceof \Grid\Data\Columns\TextColumn)
                        @if (\Illuminate\Support\Str::contains($column->field, '.'))
                            <flux:menu.item
                                wire:click="addFilter('{{$column->field}}')">{{ $column->label }}</flux:menu.item>
                        @else
                            <flux:menu.submenu heading="{{ $column->label }}">
                                <flux:menu.item wire:click="addFilter('{{ $column->field }}', 'like')">Obsahuje
                                </flux:menu.item>
                                <flux:menu.item wire:click="addFilter('{{ $column->field }}', 'not like')">Neobsahuje
                                </flux:menu.item>
                            </flux:menu.submenu>
                        @endif
                    @endif

                    @if ($column instanceof \Grid\Data\Columns\BooleanColumn)
                        <flux:menu.submenu heading="{{ $column->label }}">
                            <flux:menu.item wire:click="addFilter('{{ $column->field }}', '=', '1')">Ano
                            </flux:menu.item>
                            <flux:menu.item wire:click="addFilter('{{ $column->field }}', '=', '0')">Ne</flux:menu.item>
                        </flux:menu.submenu>
                    @endif

                    @if ($column instanceof \Grid\Data\Columns\DateColumn)
                        <flux:menu.submenu heading="{{ $column->label }}">
                            <flux:menu.item wire:click="addFilter('{{ $column->field }}', '<')">Před</flux:menu.item>
                            <flux:menu.item wire:click="addFilter('{{ $column->field }}', '=')">Přesně</flux:menu.item>
                            <flux:menu.item wire:click="addFilter('{{ $column->field }}', '>')">Po</flux:menu.item>
                        </flux:menu.submenu>
                    @endif
                @endforeach
            </flux:menu>
        </flux:dropdown>
    @endif
</div>
