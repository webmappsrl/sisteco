<?php

namespace App\Nova\Actions;

use App\Models\Project;
use App\Models\Research;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Searchable;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class CreateProjectFromParcelsAction extends Action {
    public $name = 'Crea Progetto';
    private $researchId;
    use InteractsWithQueue, Queueable;

    public function __construct() {
    }

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection   $models
     *
     * @return array|string[]
     */
    public function handle(ActionFields $fields, Collection $models): array {
        $project = new Project();
        $project->title = $fields['title'];
        $project->description = $fields['description'];
        $project->user_id = auth()->user()->id;
        $project->research_id = $fields['research'] ?? $this->researchId;
        $project->save();
        foreach ($models as $parcel) {
            $project->cadastralParcels()->attach($parcel->id);
        }

        return Action::message("Project created!");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array {
        $fields = [
            Text::make('Titolo', 'title')->required(),
            Textarea::make('Descrizione', 'description')->required()->rows(10),
        ];

        if (request()->viaResource === 'research')
            $this->researchId = intval(request()->viaResourceId);
        else {
            $fields[] = Select::make('Ricerca', 'research')
                ->searchable()
                ->options(Research::all()->pluck('title', 'id'))
                ->required();
        }

        return $fields;
    }
}
