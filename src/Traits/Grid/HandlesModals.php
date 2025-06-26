<?php

namespace Grid\Traits\Grid;

use Flux\Flux;
use Livewire\Attributes\Locked;

trait HandlesModals
{
    #[Locked]
    public ?int $modelId = null;

    #[Locked]
    public ?string $modalName = null;

    public function openModalBasedOnUrl(): void
    {
        if ($this->modelId && $this->modalName) {
            $this->openModalForModel($this->modalName, $this->modelId);
        }
    }

    public function openModalForModel(string $modal, int $modelId): void
    {
        $this->modelId = $modelId;
        $this->dispatch("modal-$modal-opened", $modelId);
        Flux::modal($modal)->show();
    }
}
