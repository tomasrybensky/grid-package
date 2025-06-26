<?php

namespace Grid\Data\Filters;

use Spatie\LaravelData\Data;

class SelectFilter extends Data
{
    /**
     * @param string $field
     * @param string $operator
     * @param string $label
     * @param null|array<int, mixed>|int $value
     * @param bool $useServerSearch
     * @param string|null $search
     * @param bool $isDefault
     * @param bool $useSeparateComponent
     * @param bool $isMultiple
     */
    public function __construct(
        public string         $field,
        public string         $operator = '',
        public string         $label = '',
        public null|array|int $value = [],
        public bool           $useServerSearch = false,
        public ?string        $search = '',
        public bool           $isDefault = false,
        public bool           $useSeparateComponent = true,
        public bool           $isMultiple = true,
    )
    {
    }
}
