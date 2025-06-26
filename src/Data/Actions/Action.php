<?php

namespace Grid\Data\Actions;

use Spatie\LaravelData\Data;

class Action extends Data
{
    public function __construct(
        public ?string $target = null,
        public ?string $icon = null,
        public ?string $label = null,
        public bool    $dropdown = false,
    )
    {
    }
}
