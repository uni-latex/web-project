<?php


namespace App\Traits\Nova;


use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;

trait ResourceAuthorization
{
    public function checkGate($request, $ability, $default = true)
    {
        $user = $request->user();

        if ( $user->is_admin ) {
            return true;
        }

        try {
            Permission::findByName($ability);

            $default = Gate::check($ability, get_class(static::newModel()));
        }
        catch (\Exception $exception) {
        }

        return $default;
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeToViewAny(Request $request)
    {
        $ability = "viewAny " . self::uriKey();

        // Todo: allow view other resource if via resource

        return $this->checkGate($request, $ability);
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToViewAny(Request $request)
    {
        $user = $request->user();

        if ( $user->is_admin ) {
            return true;
        }

        $ability = "viewAny " . self::uriKey();

        try {
            Permission::findByName($ability);

            // Todo: allow view other resource if via resource

            return Gate::check($ability, get_class(static::newModel()));
        }
        catch (\Exception $exception) {
            return true;
        }
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToView(Request $request)
    {
        $ability = "view " . self::uriKey();

        return $this->authorizedTo($request, $ability)
            && $this->authorizeToViewAny($request);
    }

    /**
     * Determine if the current user can create new resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
    {
        $user = $request->user();

        if ( $user->is_admin ) {
            return true;
        }

        $ability = "create " . self::uriKey();

        try {
            Permission::findByName($ability);
            return Gate::check($ability, get_class(static::newModel()));
        }
        catch (\Exception $exception) {
            return true;
        }
    }

    /**
     * Determine if the current user can update the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
    {
        $ability = "update " . self::uriKey();

        return $this->checkGate($request, $ability);
    }

    /**
     * Determine if the current user can delete the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        $ability = "delete " . self::uriKey();

        return $this->checkGate($request, $ability, false);
    }

    /**
     * Determine if the current user can restore the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToRestore(Request $request)
    {
        $ability = "restore " . self::uriKey();

        return $this->checkGate($request, $ability);
    }

    /**
     * Determine if the current user can force delete the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToForceDelete(Request $request)
    {
        $ability = "forceDelete " . self::uriKey();

        return $this->checkGate($request, $ability, false);
    }

    /**
     * Determine if the user can add / associate models of the given type to the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @return bool
     */
    public function authorizedToAdd(NovaRequest $request, $model)
    {
        $ability = "add" .class_basename($model) . ' ' . self::uriKey();

        return $this->checkGate($request, $ability);
    }

    /**
     * Determine if the user can attach any models of the given type to the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @return bool
     */
    public function authorizedToAttachAny(NovaRequest $request, $model)
    {
        $ability = "attachAny" . Str::singular(class_basename($model)) . ' ' . self::uriKey();

        return $this->checkGate($request, $ability);
    }

    /**
     * Determine if the user can attach models of the given type to the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @return bool
     */
    public function authorizedToAttach(NovaRequest $request, $model)
    {
        $ability = "attach" . Str::singular(class_basename($model)) . ' ' . self::uriKey();

        return $this->checkGate($request, $ability);
    }

    /**
     * Determine if the user can detach models of the given type to the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @param  string  $relationship
     * @return bool
     */
    public function authorizedToDetach(NovaRequest $request, $model, $relationship)
    {
        $ability = "detach" . Str::singular(class_basename($model)) . ' ' . self::uriKey();

        return $this->checkGate($request, $ability);
    }
}
