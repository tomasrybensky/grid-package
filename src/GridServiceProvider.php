<?php

namespace Grid;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Grid\Data\Synth\Actions\DeleteActionSynth;
use Grid\Data\Synth\Actions\DetailActionSynth;
use Grid\Data\Synth\Actions\MethodActionSynth;
use Grid\Data\Synth\Actions\ModalActionSynth;
use Grid\Data\Synth\Columns\BooleanColumnSynth;
use Grid\Data\Synth\Columns\DateColumnSynth;
use Grid\Data\Synth\Columns\DateTimeColumnSynth;
use Grid\Data\Synth\Columns\TextColumnSynth;
use Grid\Data\Synth\Filters\BooleanFilterSynth;
use Grid\Data\Synth\Filters\DateFilterSynth;
use Grid\Data\Synth\Filters\SelectFilterSynth;
use Grid\Data\Synth\Filters\SoftDeleteFilterSynth;
use Grid\Data\Synth\Filters\TextFilterSynth;

class GridServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'grid');

        Livewire::propertySynthesizer(DeleteActionSynth::class);
        Livewire::propertySynthesizer(DetailActionSynth::class);
        Livewire::propertySynthesizer(MethodActionSynth::class);
        Livewire::propertySynthesizer(ModalActionSynth::class);

        Livewire::propertySynthesizer(BooleanColumnSynth::class);
        Livewire::propertySynthesizer(DateColumnSynth::class);
        Livewire::propertySynthesizer(DateTimeColumnSynth::class);
        Livewire::propertySynthesizer(TextColumnSynth::class);

        Livewire::propertySynthesizer(BooleanFilterSynth::class);
        Livewire::propertySynthesizer(DateFilterSynth::class);
        Livewire::propertySynthesizer(SelectFilterSynth::class);
        Livewire::propertySynthesizer(SoftDeleteFilterSynth::class);
        Livewire::propertySynthesizer(TextFilterSynth::class);
    }
}
