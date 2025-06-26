<?php

namespace Grid\Traits\Grid;

use Grid\Data\Columns\BooleanColumn;
use Grid\Data\Columns\DateColumn;
use Grid\Data\Columns\TextColumn;
use Grid\Data\Filters\BooleanFilter;
use Grid\Data\Filters\DateFilter;
use Grid\Data\Filters\Filter;
use Grid\Data\Filters\SoftDeleteFilter;
use Grid\Data\Filters\SelectFilter;
use Grid\Data\Filters\TextFilter;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionMethod;

trait FilterModels
{
    public const FRONTEND_SEARCH_LIMIT = 100;

    /** @var Collection<int, Filter|SelectFilter> */
    public Collection $filters;

    public function getFilter(string $field): null|Filter|SelectFilter
    {
        return $this->filters->where('field', $field)->first();
    }

    public function isFilterDisabled(string $field): bool
    {
        return false;
    }

    /**
     * @param string $field
     * @param string $operator
     * @param array<int>|string|int|null $value
     * @throws Exception
     */
    public function addFilter(string $field, string $operator = '=', null|string|array|int $value = null): void
    {
        $column = $this->columns->where('field', $field)->first();

        $filterClass = match ($column::class) {
            TextColumn::class => TextFilter::class,
            BooleanColumn::class => BooleanFilter::class,
            DateColumn::class => DateFilter::class,
            default => null,
        };

        if (Str::contains($field, '.')) {
            $useServerSearch = $this->getOptionsFilterQuery($field)->count() > self::FRONTEND_SEARCH_LIMIT;
            $useSeparateComponent = true;

            /** @phpstan-ignore-next-line */
            if (method_exists(static::class, 'alterGetOptionsForFilter')) {
                $reflection = new ReflectionMethod(static::class, 'alterGetOptionsForFilter');
                if (!$reflection->isStatic()) {
                    $useSeparateComponent = false;
                }
            }

            $this->filters->push(
                new SelectFilter(
                    field: $column->filterBy,
                    operator: $operator,
                    label: $column->label,
                    value: $value,
                    useServerSearch: $useServerSearch,
                    useSeparateComponent: $useSeparateComponent,
                    isMultiple: $column->multipleSelect
                )
            );

            return;
        }

        if ($filterClass) {
            $this->filters->push(
                new $filterClass(
                    field: $column->filterBy,
                    operator: $operator,
                    label: $column->label,
                    value: $value
                )
            );
        }

        $this->resetPage();
    }

    public function removeFilter(int $key): void
    {
        $this->filters->forget($key);
        $this->filters = $this->filters->values();
    }

    /**
     * @return class-string<Model>
     * @throws Exception
     */
    public function getFilterOptionsModel(string $field): string
    {
        $parts = explode('.', $field);
        $modelClass = $this->getModelClass();
        $model = new $modelClass();

        array_pop($parts);

        foreach ($parts as $relation) {
            $relatedModel = $model->{$relation}()->getRelated();
            $model = $relatedModel;
        }

        return $model::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Model>
     * @throws Exception
     */
    public function getOptionsForFilter(SelectFilter $filter): \Illuminate\Database\Eloquent\Collection
    {
        $query = $this->getOptionsFilterQuery($filter->field);

        /** @phpstan-ignore-next-line */
        if (method_exists(static::class, 'alterGetOptionsForFilter')) {
            $reflection = new ReflectionMethod(static::class, 'alterGetOptionsForFilter');
            if ($reflection->isStatic()) {
                static::alterGetOptionsForFilter($filter->field, $query);
            } else {
                /** @phpstan-ignore-next-line */
                $this->alterGetOptionsForFilter($filter->field, $query);
            }
        }

        self::defaultAlterGetOptionsForFilter($filter->field, $query, $filter->search);

        if ($filter->useServerSearch) {
            return $query->limit(20)->get();
        }

        return $query->get();
    }

    /**
     * @return Builder<Model>
     * @throws Exception
     */
    public function getOptionsFilterQuery(string $field): Builder
    {
        return $this->getFilterOptionsModel($field)::query();
    }

    /** @param Builder<Model> $query */
    public function filterModels(Builder $query): void
    {
        foreach ($this->filters as $filter) {
            if ($filter->value !== null && $filter->value !== '' && $filter->value !== []) {
                $this->applyFilter($query, $filter);
            }
        }
    }

    /**
     * @param Builder<Model> $query
     * @param Filter|SelectFilter $filter
     */
    protected function applyFilter(Builder $query, Filter|SelectFilter $filter): void
    {
        if ($filter instanceof TextFilter) {
            $query->where($filter->field, $filter->operator, "%$filter->value%");
            return;
        }

        if ($filter instanceof DateFilter) {
            $query->whereDate($filter->field, $filter->operator, $filter->value);
            return;
        }

        if ($filter instanceof BooleanFilter) {
            $query->where($filter->field, $filter->operator, $filter->value);
            return;
        }

        if ($filter instanceof SoftDeleteFilter) {
            $operator = $filter->value ? 'whereNotNull' : 'whereNull';
            $query->{$operator}($filter->field);
        }

        if ($filter instanceof SelectFilter) {
            $parts = explode('.', $filter->field);
            array_pop($parts);
            $relation = implode('.', $parts);

            $query->whereHas($relation, function (Builder $query) use ($filter) {
                if ($filter->isMultiple) {
                    $query->whereIn('id', $filter->value);
                } else {
                    $query->where('id', $filter->operator, $filter->value);
                }
            });
        }
    }

    /** @throws Exception */
    protected function addDefaultFilters(): void
    {
        foreach ($this->columns->where('defaultFilter', true) as $column) {
            $this->addFilter($column->field);
        }

        foreach ($this->filters as $filter) {
            $filter->isDefault = true;
        }
    }

    /**
     * @param Builder<Model> $query
     * @return Collection<int, mixed>|null
     */
    public static function defaultAlterGetOptionsForFilter(string $field, Builder $query, string $search): ?Collection
    {
        $parts = explode('.', $field);
        $modelField = array_pop($parts);

        if ($modelField === 'full_name') {
            $query
                ->where(function (Builder $query) use ($search) {
                    $query
                        ->where('name', 'like', "%$search%")
                        ->orWhere('surname', 'like', "%$search%");
                });
        } else {
            $query
                ->where($modelField, 'like', "%$search%");
        }

        return null;
    }
}
