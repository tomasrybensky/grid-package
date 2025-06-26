<?php

namespace Grid\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Grid\Traits\Grid\ExportsGrid;
use Grid\Traits\Grid\FilterModels;
use Grid\Traits\Grid\HandlesModals;
use Grid\Traits\Grid\ManagesColumns;
use Grid\Traits\Grid\ManagesModels;
use Grid\Traits\Grid\SortsModels;
use Exception;

#[On('refresh-grid')]
abstract class Grid extends Component
{
    use WithPagination;
    use SortsModels;
    use FilterModels;
    use ManagesColumns;
    use HandlesModals;
    use ExportsGrid;
    use ManagesModels;

    #[Locked]
    public Collection $actions;

    abstract protected function getColumns(): Collection;

    abstract protected function getActions(): Collection;

    abstract protected function getQuery(): Builder;

    /** @throws Exception */
    protected function getModelClass(): string
    {
        throw new Exception('Please implement getModelClass() in your grid class');
    }

    /** @throws Exception */
    public function mount(): void
    {
        $this->columns = $this->transformColumns();
        $this->actions = $this->getActions();

        $this->columns->each(function ($column) {
            $this->columnVisibility[$column->id] = true;
        });

        if (request()->query('modelId')) {
            $modelId = request()->query('modelId');
            $this->modelId = is_numeric($modelId) ? (int)$modelId : null;
        }

        if (request()->query('modalName')) {
            $this->modalName = request()->query('modalName');
        }

        $this->filters = collect();
        $this->addDefaultFilters();
    }

    #[Computed]
    protected function bulkActions(): Collection
    {
        return collect();
    }

    public function render()
    {
        return view('grid::components.grid');
    }
}
