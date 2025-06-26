<?php

namespace Grid\Data\Synth\Actions;

use Grid\Data\Actions\MethodAction;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class MethodActionSynth extends Synth
{
    public static string $key = 'method-action';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof MethodAction;
    }

    public function dehydrate(MethodAction $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return MethodAction
     */
    public function hydrate(mixed $value): MethodAction
    {
        return MethodAction::from($value);
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
