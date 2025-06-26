<?php

namespace Grid\Data\Synth\Filters;

use Grid\Data\Filters\SoftDeleteFilter;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class SoftDeleteFilterSynth extends Synth
{
    public static string $key = 'soft-delete-filter';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof SoftDeleteFilter;
    }

    public function dehydrate(SoftDeleteFilter $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return SoftDeleteFilter
     */
    public function hydrate(mixed $value): SoftDeleteFilter
    {
        return SoftDeleteFilter::from($value);
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
