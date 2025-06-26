<?php

namespace Grid\Data\Columns;

use Illuminate\Support\Carbon;

class DateTimeColumn extends Column
{
    public function transformValue(?Carbon $value): ?string
    {
        return $value?->format('j. n. Y H:i');
    }
}
