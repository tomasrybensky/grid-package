<?php

namespace Grid\Data\Synth\Columns;

use Grid\Data\Columns\DateColumn;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class DateColumnSynth extends Synth
{
    public static string $key = 'date-column';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof DateColumn;
    }

    public function dehydrate(DateColumn $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return DateColumn
     */
    public function hydrate(mixed $value): DateColumn
    {
        return DateColumn::from($value);
    }
}
