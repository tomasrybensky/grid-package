<?php

namespace Grid\Data\Synth\Filters;

use Grid\Data\Filters\DateFilter;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class DateFilterSynth extends Synth
{
    public static string $key = 'date-filter';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof DateFilter;
    }

    public function dehydrate(DateFilter $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return DateFilter
     */
    public function hydrate(mixed $value): DateFilter
    {
        return DateFilter::from($value);
    }

    /**
     * @param mixed $target
     * @param string $key
     * @return mixed
     */
    public function get(&$target, $key): mixed
    {
        return $target->{$key};
    }

    /**
     * @param mixed $target
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(mixed $target, string $key, mixed $value): void
    {
        $target->{$key} = $value;
    }
}
