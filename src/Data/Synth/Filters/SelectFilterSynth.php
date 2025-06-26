<?php

namespace Grid\Data\Synth\Filters;

use Grid\Data\Filters\SelectFilter;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class SelectFilterSynth extends Synth
{
    public static string $key = 'select-filter';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof SelectFilter;
    }

    public function dehydrate(SelectFilter $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return SelectFilter
     */
    public function hydrate(mixed $value): SelectFilter
    {
        return SelectFilter::from($value);
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
