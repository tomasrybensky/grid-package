<?php

namespace Grid\Data\Synth\Columns;

use Grid\Data\Columns\DateTimeColumn;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class DateTimeColumnSynth extends Synth
{
    public static string $key = 'datetime-column';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof DateTimeColumn;
    }

    public function dehydrate(DateTimeColumn $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return DateTimeColumn
     */
    public function hydrate(mixed $value): DateTimeColumn
    {
        return DateTimeColumn::from($value);
    }
}
