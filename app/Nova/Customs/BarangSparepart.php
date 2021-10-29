<?php

namespace App\Nova\Customs;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class BarangSparepart extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Customs\BarangSparepart::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = 'Customs';

    public function fieldsForIndex(Request $request)
    {
        return [
            Date::make(__('Mutation Date'))
                ->format('DD/MM/YYYY'),

            Text::make(__('Goods Code')),

            Text::make(__("Goods Name")),
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Date::make(__('Mutation Date'))
                ->format('DD/MM/YYYY'),

            Text::make(__('Goods Code')),

            Text::make(__("Goods Name")),

            Text::make(__('Unit')),

            Text::make(__('Beginning Balance')),

            Text::make(__('Entering')),

            Text::make(__('Spending')),

            Text::make(__('Compliance')),

            Text::make(__('Final Balance')),

            Text::make(__('Stock Opname')),

            Text::make(__('Difference')),

            Textarea::make(__('Annotation'))
                ->alwaysShow(),
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

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }
}
