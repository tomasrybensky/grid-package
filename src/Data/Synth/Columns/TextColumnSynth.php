<?php

namespace Grid\Data\Synth\Columns;

use Grid\Data\Columns\TextColumn;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class TextColumnSynth extends Synth
{
    public static string $key = 'text-column';

    /**
     * @param mixed $target
     * @return bool
     */
    public static function match($target): bool
    {
        return $target instanceof TextColumn;
    }

    public function dehydrate(TextColumn $target): array
    {
        return [$target->toArray(), []];
    }

    /**
     * @param mixed $value
     * @return TextColumn
     */
    public function hydrate(mixed $value): TextColumn
    {
        return TextColumn::from($value);
    }
}
