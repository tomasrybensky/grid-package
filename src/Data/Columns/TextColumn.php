<?php

namespace Grid\Data\Columns;

use Illuminate\Support\Str;

class TextColumn extends Column
{
    public function transformValue(string|null $value): string
    {
        return Str::limit($value ?? '', $this->limit);
    }
}
