<?php

namespace Grid\Data\Synth\Actions;

use Grid\Data\Actions\DeleteAction;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class DeleteActionSynth extends Synth
{
    public static string $key = 'delete-action';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof DeleteAction;
    }

    public function dehydrate(DeleteAction $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return DeleteAction
     */
    public function hydrate(mixed $value): DeleteAction
    {
        return DeleteAction::from($value);
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
