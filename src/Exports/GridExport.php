<?php

namespace Grid\Exports;

use Grid\Data\Columns\Column;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * @implements WithMapping<Model>
 */
class GridExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    /**
     * @param Builder<Model> $query
     * @param Collection<int, Column> $columns
     * @param array<int, bool> $columnVisibility
     */
    public function __construct(
        public Builder $query,
        public Collection $columns,
        public array $columnVisibility,
    )
    {
    }

    /** @return Builder<Model> */
    public function query(): Builder
    {
        return $this->query;
    }

    /**
     * @param Model $row
     * @return array<int, mixed>
     */
    public function map($row): array
    {
        $columns = [];

        foreach ($this->columns as $column) {
            if (! $this->columnVisibility[$column->id]) {
                continue;
            }

            $columns[] = method_exists($column, 'transformValue')
                ? $column->transformValue(data_get($row, $column->field))
                : data_get($row, $column->field);
        }

        return $columns;
    }

    /** @return array<int, string> */
    public function headings(): array
    {
        $headings = [];

        foreach ($this->columns as $column) {
            if (! $this->columnVisibility[$column->id]) {
                continue;
            }

            $headings[] = $column->label;
        }

        return $headings;
    }
}
