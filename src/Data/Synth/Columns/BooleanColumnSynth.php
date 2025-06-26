<?php

namespace Grid\Data\Synth\Columns;

use Grid\Data\Columns\BooleanColumn;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class BooleanColumnSynth extends Synth
{
    public static string $key = 'boolean-column';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof BooleanColumn;
    }

    public function dehydrate(BooleanColumn $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return BooleanColumn
     */
    public function hydrate(mixed $value): BooleanColumn
    {
        return BooleanColumn::from($value);
    }
}
