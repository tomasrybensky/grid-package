<div class="flex justify-between mb-12">
    <flux:heading size="xl">{{ $this->gridTitle }}</flux:heading>

    <div class="flex gap-3">
        <div>
            <flux:input
                wire:model.live.debounce="search"
                icon="magnifying-glass"
                placeholder="Hledaný výraz"
                :loading="false"
            />
        </div>
        @if (isset($this->createModalName))
            <flux:modal.trigger name="{{ $this->createModalName }}">
                <flux:button>Přidat záznam</flux:button>
            </flux:modal.trigger>
        @endif
        <flux:dropdown>
            <flux:button icon="arrow-down-tray"/>
            <flux:menu>
                <flux:menu.item wire:click="downloadExport('xlsx')" icon="table-cells">XLSX</flux:menu.item>
                <flux:menu.item wire:click="downloadExport('csv')" icon="circle-stack">CSV</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
        <flux:modal.trigger name="edit-columns-order">
            <flux:button icon="adjustments-horizontal"/>
        </flux:modal.trigger>
    </div>
</div>
