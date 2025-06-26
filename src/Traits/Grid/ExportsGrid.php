<?php

namespace Grid\Traits\Grid;

use Grid\Exports\GridExport;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait ExportsGrid
{
    public function downloadExport(string $extension): Response|BinaryFileResponse
    {
        if (! in_array($extension, ['csv', 'xlsx'])) {
            throw new \InvalidArgumentException('Unsupported export format: ' . $extension);
        }

        return (new GridExport(
            query: $this->getQuery(),
            columns: $this->columns,
            columnVisibility: $this->columnVisibility
        ))->download("export.{$extension}");
    }
}
