<?php

namespace Grid\Data\Synth\Actions;

use Grid\Data\Actions\ModalAction;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class ModalActionSynth extends Synth
{
    public static string $key = 'modal-action';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof ModalAction;
    }

    public function dehydrate(ModalAction $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return ModalAction
     */
    public function hydrate(mixed $value): ModalAction
    {
        return ModalAction::from($value);
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
