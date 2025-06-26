<?php

namespace Grid\Data\Actions;

class DetailAction extends Action
{
    public function __construct(
        public bool $dropdown = false,
        public ?string $target = 'record-detail',
    )
    {
        parent::__construct(
            target: $this->target,
            icon: 'eye',
            label: 'Detail',
            dropdown: $dropdown,
        );
    }
}
