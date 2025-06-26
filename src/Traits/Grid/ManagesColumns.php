<?php

namespace Grid\Traits\Grid;

use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;

trait ManagesColumns
{
    /** @var Collection<int, object> */
    #[Locked]
    public Collection $columns;

    /** @var array<int, bool> */
    public array $columnVisibility = [];

    public function sortColumns(mixed $item, int $position): void
    {
        $columns = $this->columns;

        $column = $columns->where('id', $item)->first();
        $current = $column->order;

        if ($current === $position) return;

        $column->order = -1;

        $block = $columns->whereBetween('order', [min($current, $position), max($current, $position)]);

        foreach ($block as $columnToUpdate) {
            $columnToUpdate->order = $current < $position ? $columnToUpdate->order - 1 : $columnToUpdate->order + 1;
        }

        $column->order = $position;

        $this->columns = $columns->sortBy('order')->keyBy('id');
    }

    /** @return Collection<int, object> */
    protected function transformColumns(): Collection
    {
        $columns = $this->getColumns();

        foreach ($columns as $key => $column) {
            $column->id = $key + 1;
            $column->order = $key;
        }

        return $columns;
    }
}
