# Grid Package for Laravel

A reusable grid component for Laravel applications with filtering, sorting, and export capabilities.

## Installation

You can install the package via composer:

```bash
composer require translation-app/grid
```

The package will automatically register its service provider.

You can publish the config file with:

```bash
php artisan vendor:publish --tag="grid-config"
```

You can publish the views with:

```bash
php artisan vendor:publish --tag="grid-views"
```

## Usage

### Creating a Grid

To create a grid, extend the `Grid\Livewire\Grid` class:

```php
<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Grid\Data\Actions\DeleteAction;
use Grid\Data\Actions\DetailAction;
use Grid\Data\Columns\TextColumn;
use Grid\Data\Columns\DateColumn;
use Grid\Livewire\Grid;

class UsersGrid extends Grid
{
    public string $gridTitle = 'Users';

    protected function getModelClass(): string
    {
        return User::class;
    }

    protected function getQuery(): Builder
    {
        return User::query();
    }

    protected function getColumns(): Collection
    {
        return collect([
            new TextColumn(
                label: 'Name',
                field: 'name',
            ),
            new TextColumn(
                label: 'Email',
                field: 'email',
            ),
            new DateColumn(
                label: 'Created At',
                field: 'created_at',
            ),
        ]);
    }

    protected function getActions(): Collection
    {
        return collect([
            new DetailAction(),
            new DeleteAction(),
        ]);
    }
}
```

### Using the Grid in a View

```php
<livewire:users-grid />
```

## Features

- Filtering
- Sorting
- Pagination
- Export to CSV and XLSX
- Column visibility management
- Modal actions
- Soft delete support

## Dependencies

- Laravel 10+
- Livewire 3+
- Spatie Laravel Data
- Maatwebsite Excel

## License

The MIT License (MIT).
