<?php

namespace App\Nova;

use App\Traits\Nova\CreateRedirectToIndex;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Date;
use Ramsey\Uuid\Uuid;

class Invite extends Resource
{
    use CreateRedirectToIndex;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Invite::class;

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

    public static $group = "System";

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make(__('Email'))
                ->rules('required', 'email', 'max:254', 'unique:users,email'),

            Text::make(__('Token'))
                ->onlyOnDetail(),

            Hidden::make(__('Token'))
                ->default(function () {
                    return Uuid::uuid4();
                }),

            Date::make(__('Expired At'))
                ->default(now()->addDays(5))
                ->format('DD MMMM Y')
                ->rules('required'),

            Date::make(__('Used At'))
                ->format('DD MMMM Y'),

            BelongsTo::make(__('Role'))
                ->nullable(),
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

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }
}
