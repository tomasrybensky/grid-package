<?php

namespace Grid\Data\Synth\Filters;

use Grid\Data\Filters\BooleanFilter;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class BooleanFilterSynth extends Synth
{
    public static string $key = 'boolean-filter';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof BooleanFilter;
    }

    public function dehydrate(BooleanFilter $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return BooleanFilter
     */
    public function hydrate(mixed $value): BooleanFilter
    {
        return BooleanFilter::from($value);
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
