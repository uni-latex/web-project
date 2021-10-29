<?php

namespace App\Nova\Customs;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class DocumentItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Customs\DocumentItem::class;

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

    public function fieldsforIndex(Request $request)
    {
        return [
            BelongsTo::make(__('Document'), 'document', Document::class),

            Text::make(__('Receipt Number')),

            Date::make(__('Receipt Date')),

            Text::make(__('Goods Code')),

            Text::make(__('Goods Name'), function () {
                return $this->goods_name_1 . ' ' . $this->goods_name_2;
            }),
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
            BelongsTo::make(__('Document'), 'document', Document::class),

            Text::make(__('Receipt Number')),

            Date::make(__('Receipt Date')),

            Text::make(__('Goods Code')),

            Text::make(__('Goods Name'), function () {
                return $this->goods_name_1 . ' ' . $this->goods_name_2;
            }),

            Text::make(__("Unit")),

            Text::make(__('Quantity')),

            Text::make(__('Valas')),

            Text::make(__('Value')),

            Textarea::make(__('Annotation'), function () {
                return $this->annotation_1 . ' ' . $this->annotation_2;
            })->alwaysShow(),
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
