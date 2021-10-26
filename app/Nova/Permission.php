<?php

namespace App\Nova;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class Permission extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Permission::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public function title()
    {
        if (request()->viaResource) {
            return "{$this->name} ( {$this->group} )";
        }
        return $this->name;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'group'
    ];

    public static $group = "System";

    private function guards() {
        return collect(config('auth.guards'))->mapWithKeys(function ($value, $key) {
            return [$key => $key];
        });
    }

    private function novaResources(Request $request)
    {
        $resources = collect(Nova::$resources)->mapWithKeys(function($resource) {
            return [$resource::label() => $resource::label()];
        });

        $resources = $resources->merge(['System' => 'System']);

        return $resources->sort();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $guards = $this->guards();

        $resources = $this->novaResources($request);

        return [
            Text::make(__('Name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:' . config('permission.table_names.permissions'))
                ->updateRules('unique:' . config('permission.table_names.permissions') . ',name,{{resourceId}}'),

            Select::make(__('Group'))
                ->options($resources)
                ->searchable()
                ->rules(['required']),

            Select::make(__('Guard'), 'guard_name')
                ->options($guards)
                ->rules(['required', Rule::in($guards)])
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
