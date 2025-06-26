<?php

namespace Grid\Traits\Grid;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait SortsModels
{
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public string $baseTable = '';

    public function setSortConfig(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * @param Builder<Model> $query
     */
    public function sortModels(Builder $query): void
    {
        if (!$this->sortBy) {
            return;
        }

        if (!Str::contains($this->sortBy, '.')) {
            $this->applySortForSimpleColumn($query);
            return;
        }

        $parts = explode('.', $this->sortBy);
        $column = array_pop($parts);

        if (count($parts) > 1) {
            $this->applySortForNestedRelation($query, $parts, $column);
        } else {
            $this->applySortForSimpleRelation($query, $parts[0], $column);
        }
    }

    /**
     * @param Builder<Model> $query
     */
    private function applySortForSimpleColumn(Builder $query): void
    {
        $orderString = $this->sortBy;

        if ($this->sortBy === 'created_at') {
            $orderString = "$this->baseTable.$this->sortBy";
        }

        $query->orderBy($orderString, $this->sortDirection ?? 'asc');
    }

    /**
     * @param Builder<Model> $query
     * @param array<string> $parts
     */
    private function applySortForNestedRelation(Builder $query, array $parts, string $column): void
    {
        $modelTable = $query->getModel()->getTable();
        $currentTable = $modelTable;
        $aliases = [];

        foreach ($parts as $index => $relation) {
            $currentTable = $this->joinRelationTable($query, $parts, $index, $relation, $modelTable, $aliases);
            $aliases[$index] = $currentTable;
        }

        $query->orderBy($currentTable . '.' . $column, $this->sortDirection ?? 'asc');
    }

    /**
     * @param Builder<Model> $query
     * @param array<string> $parts
     * @param array<int, string> $aliases
     */
    private function joinRelationTable(Builder $query, array $parts, int $index, string $relation, string $modelTable, array $aliases): string
    {
        $relationTable = Str::plural(Str::snake($relation));
        $baseAlias = implode('_', array_slice($parts, 0, $index + 1));
        $uniqueSuffix = '_' . Str::random(8);
        $joinAlias = $baseAlias . $uniqueSuffix;

        $query->leftJoin(
            $relationTable . ' as ' . $joinAlias,
            function ($join) use ($joinAlias, $relation, $index, $modelTable, $aliases) {
                if ($index === 0) {
                    $join->on($joinAlias . '.id', '=', $modelTable . '.' . $relation . '_id');
                } else {
                    $previousAlias = $aliases[$index - 1];
                    $join->on($joinAlias . '.id', '=', $previousAlias . '.' . $relation . '_id');
                }
            }
        );

        return $joinAlias;
    }

    /**
     * @param Builder<Model> $query
     */
    private function applySortForSimpleRelation(Builder $query, string $relation, string $column): void
    {
        $relationSnakeCase = Str::snake($relation);

        $query
            ->withAggregate($relation, $column)
            ->orderBy("{$relationSnakeCase}_$column", $this->sortDirection ?? 'asc');
    }
}
