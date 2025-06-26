<flux:table :paginate="$this->models" wire:init="openModalBasedOnUrl" class="mt-8">
    <flux:table.columns>
        @if ($this->bulkActions->isNotEmpty())
            <flux:table.column></flux:table.column>
        @endif
        @if ($this->actions->isNotEmpty())
            <flux:table.column>Akce</flux:table.column>
        @endif
        @foreach($this->columns as $index => $column)
            @if ($this->columnVisibility[$column->id])
                @if ($column->sortable)
                    <flux:table.column wire:key="{{ $index }}" sortable :sorted="$this->sortBy === $column->sortBy" :direction="$this->sortDirection" wire:click="setSortConfig('{{ $column->sortBy }}')">{{ $column->label }}</flux:table.column>
                @else
                    <flux:table.column wire:key="{{ $index }}">{{ $column->label }}</flux:table.column>
                @endif
            @endif
        @endforeach
    </flux:table.columns>
    <flux:table.rows>
        @foreach($this->models as $model)
            <flux:table.row :key="$model->id . \Illuminate\Support\Str::random(10)">
                @if ($this->bulkActions->isNotEmpty())
                    <flux:table.cell>
                        <flux:checkbox />
                    </flux:table.cell>
                @endif
                @if ($this->actions->isNotEmpty())
                    <flux:table.cell>
                        @foreach($this->actions->where('dropdown', false) as $action)
                            @if ($model->deleted_at)
                                @if ($action instanceof \Grid\Data\Actions\DetailAction)
                                    <flux:button
                                        wire:click="openModalForModel('{{ $action->target }}', {{ $model->id }})"
                                        icon="{{ $action->icon }}"
                                        iconVariant="outline"
                                        size="sm"
                                        class="text-gray-500 hover:text-gray-700"
                                    />
                                @endif
                                @if ($action instanceof \Grid\Data\Actions\DeleteAction)
                                    <flux:button
                                        wire:click="openModalForModel('restore-record', {{ $model->id }})"
                                        icon="arrow-uturn-left"
                                        iconVariant="outline"
                                        size="sm"
                                        class="text-gray-500 hover:text-gray-700"
                                    />
                                @endif
                            @else
                                @if ($action instanceof \Grid\Data\Actions\MethodAction)
                                    <flux:button
                                        wire:click="{{ ((string) $action->target) . '(' . $model . ')' }}"
                                        icon="{{ $action->icon }}"
                                        iconVariant="outline"
                                        size="sm"
                                        class="text-gray-500 hover:text-gray-700"
                                    />
                                @else
                                    <flux:button
                                        wire:click="openModalForModel('{{ $action->target }}', {{ $model->id }})"
                                        icon="{{ $action->icon }}"
                                        iconVariant="outline"
                                        size="sm"
                                        class="text-gray-500 hover:text-gray-700"
                                    />
                                @endif
                            @endif
                        @endforeach
                        @if($this->actions->where('dropdown', true)->isNotEmpty())
                            <flux:dropdown>
                                <flux:button icon="ellipsis-horizontal" size="sm" iconVariant="outline" />
                                <flux:menu>
                                    @foreach($this->actions->where('dropdown', true) as $action)
                                        @if ($action instanceof \Grid\Data\Actions\MethodAction)
                                            <flux:menu.item wire:click="{{ ((string) $action->target) . '(' . $model . ')' }}">{{ $action->label }}</flux:menu.item>
                                        @else
                                            <flux:menu.item wire:click="openModalForModel('{{ $action->target }}', {{ $model->id }})" icon="{{ $action->icon }}">{{ $action->label }}</flux:menu.item>
                                        @endif
                                    @endforeach
                                </flux:menu>
                            </flux:dropdown>
                        @endif
                    </flux:table.cell>
                @endif
                @foreach($this->columns as $column)
                    @if ($this->columnVisibility[$column->id])
                        <flux:table.cell wire:key="{{ $column->id }}">
                            @if ($column instanceof \Grid\Data\Columns\BooleanColumn)
                                @if (data_get($model, $column->field))
                                    <flux:icon.check-circle/>
                                @else
                                    <flux:icon.x-circle/>
                                @endif
                            @elseif($column instanceof \Grid\Data\Columns\TextColumn && \Illuminate\Support\Str::length(data_get($model, $column->field)) > $column->limit)
                                <flux:tooltip content="{!! Str::limit(data_get($model, $column->field, 400)) !!}">
                                    <span>{{ method_exists($column, 'transformValue') ? $column->transformValue(data_get($model, $column->field)) : data_get($model, $column->field) }}</span>
                                </flux:tooltip>
                            @else
                                {{ method_exists($column, 'transformValue') ? $column->transformValue(data_get($model, $column->field)) : data_get($model, $column->field) }}
                            @endif
                        </flux:table.cell>
                    @endif
                @endforeach
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>

<flux:modal name="edit-columns-order" variant="flyout" class="min-w-xl">
    <div x-sort="$wire.sortColumns($item, $position)" class="flex flex-col gap-4 mt-4 cursor-pointer">
        @foreach($this->columns as $column)
            <div wire:key="{{ $column->id }}" x-sort:item="{{ $column->id }}" class="flex gap-3">
                <flux:checkbox wire:model.live="columnVisibility.{{ $column->id }}" />
                <h1>{{ $column->label }}</h1>
            </div>
        @endforeach
    </div>
</flux:modal>

<flux:modal name="delete-record">
    <div class="px-4 pt-8 py-2">
        <flux:heading>Opravdu si přejete tento záznam smazat?</flux:heading>
        <div class="pt-6 flex justify-between">
            <flux:button>Zrušit</flux:button>
            <flux:button wire:click="deleteModel" variant="danger">Smazat</flux:button>
        </div>
    </div>
</flux:modal>

<flux:modal name="restore-record">
    <div class="px-4 pt-8 py-2">
        <flux:heading>Opravdu si přejete tento záznam obnovit?</flux:heading>
        <div class="pt-6 flex justify-between">
            <flux:button>Zrušit</flux:button>
            <flux:button wire:click="restoreModel" variant="primary">Obnovit</flux:button>
        </div>
    </div>
</flux:modal>

<flux:modal variant="flyout" name="record-detail" class="min-w-md">
    <div class="px-4 pt-8 py-2">
        <div class="flex items-center mb-4 gap-2">
            <flux:heading size="xl">Detail záznamu</flux:heading>
            <flux:button
                variant="subtle"
                icon="link"
                size="sm"
                x-on:click="
                    const url = window.location.origin + window.location.pathname + '?modelId={{ $this->model?->id }}&modalName=record-detail';
                    navigator.clipboard.writeText(url);
                    $flux.toast('Odkaz byl zkopírován do schránky.');
                "
            />
        </div>

        @foreach($this->columns as $column)
            <flux:heading class="text-base">{{ $column->label }}</flux:heading>
            <flux:text class="pb-4">
                {{ method_exists($column, 'transformValue') ? $column->transformValue(data_get($this->model, $column->field)) : data_get($this->model, $column->field) }}
            </flux:text>
        @endforeach
    </div>
</flux:modal>
