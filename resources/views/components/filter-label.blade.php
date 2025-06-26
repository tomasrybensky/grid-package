<flux:label class="flex items-center">
    {{ $label }}
    @if (!$isDefault)
        <flux:button wire:click="removeFilter({{ $filterKey }})" icon="x-circle" size="xs" variant="ghost" :loading="false" class="ml-0.5"/>
    @else
        <span class="ml-0.5 w-6 h-6"></span>
    @endif
</flux:label>

@props([
    'label',
    'isDefault' => false,
    'filterKey',
])
