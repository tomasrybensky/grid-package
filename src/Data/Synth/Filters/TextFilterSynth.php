<?php

namespace Grid\Data\Synth\Filters;

use Grid\Data\Filters\TextFilter;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class TextFilterSynth extends Synth
{
    public static string $key = 'text-filter';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof TextFilter;
    }

    public function dehydrate(TextFilter $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return TextFilter
     */
    public function hydrate(mixed $value): TextFilter
    {
        return TextFilter::from($value);
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
