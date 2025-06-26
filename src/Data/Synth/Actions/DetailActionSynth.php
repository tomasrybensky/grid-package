<?php

namespace Grid\Data\Synth\Actions;

use Grid\Data\Actions\DetailAction;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class DetailActionSynth extends Synth
{
    public static string $key = 'detail-action';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof DetailAction;
    }

    public function dehydrate(DetailAction $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return DetailAction
     */
    public function hydrate(mixed $value): DetailAction
    {
        return DetailAction::from($value);
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
