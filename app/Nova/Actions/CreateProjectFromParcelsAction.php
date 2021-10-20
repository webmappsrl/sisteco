<?php

namespace App\Nova\Actions;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class CreateProjectFromParcelsAction extends Action
{
    public $name = 'Crea Progetto';

    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $title = $fields['title'];
        $description = $fields['description'];
        $p = new Project();
        $p->title = $fields['title'];
        $p->description = $fields['description'];
        $p->user_id = auth()->user()->id;
        $p->research_id = 1;
        $p->save();
        foreach ($models as $parcel) {
            $p->cadastralParcels()->attach($parcel->id);
        }
        return Action::message("Project created!");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('title')->required(),
            Textarea::make('description')->required()->rows(10),
        ];
    }
}
