<?php

namespace Grid\Data\Actions;

class DeleteAction extends Action
{
    public function __construct(
        public bool $dropdown = false,
    )
    {
        parent::__construct(
            target: 'delete-record',
            icon: 'trash',
            label: 'Smazat',
            dropdown: $dropdown,
        );
    }
}
