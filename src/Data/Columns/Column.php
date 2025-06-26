<?php

namespace Grid\Data\Columns;

use Spatie\LaravelData\Data;

class Column extends Data
{
    public function __construct(
        public string $label,
        public string $field,
        public ?int $id = null,
        public ?int $order = null,
        public bool $sortable = true,
        public ?string $sortBy = null,
        public bool $filterable = true,
        public ?string $filterBy = null,
        public bool $defaultFilter = false,
        public bool $multipleSelect = true,
        public ?int $limit = 30
    ) {
        $this->sortBy = $this->sortBy ?? $this->field;
        $this->filterBy = $this->filterBy ?? $this->field;
    }
}
