<?php

namespace Grid\Traits\Grid;

use Exception;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;

trait ManagesModels
{
    /** @return LengthAwarePaginator<int, Model> */
    #[Computed]
    protected function models(): LengthAwarePaginator
    {
        $query = $this->getQuery();
        $this->sortModels($query);
        $this->filterModels($query);

        return $query->paginate(15);
    }

    /** @throws Exception */
    #[Computed]
    protected function model(): ?Model
    {
        if (!$this->modelId) {
            return null;
        }

        if (method_exists($this->getModelClass(), 'restore')) {
            $model = $this->getModelClass()::withTrashed()->find($this->modelId);
        } else {
            $model = $this->getModelClass()::find($this->modelId);
        }

        if ($model && method_exists($this, 'transformModelForDetail')) {
            return $this->transformModelForDetail($model);
        }

        return $model;
    }

    /** @throws Exception */
    public function deleteModel(): void
    {
        //TODO: add permission check
        $this->getModelClass()::find($this->modelId)->delete();
        Flux::modal('delete-record')->close();
        Flux::toast('Záznam byl úspěšně smazán.');
        $this->dispatch('refresh-grid');
    }

    /** @throws Exception */
    public function restoreModel(): void
    {
        $this->getModelClass()::withTrashed()->find($this->modelId)->restore();
        Flux::modal('restore-record')->close();
        Flux::toast('Záznam byl úspěšně obnoven.');
        $this->dispatch('refresh-grid');
    }
}
