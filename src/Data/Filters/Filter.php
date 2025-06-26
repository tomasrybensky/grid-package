<?php

namespace Grid\Data\Filters;
use Spatie\LaravelData\Data;

class Filter extends Data
{
    public function __construct(
        public string $field,
        public string $operator = '',
        public string $label = '',
        public ?string $value = null,
        public bool $isDefault = false,
    )
    {
    }
}
