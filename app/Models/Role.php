<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRoleModel;
use Spatie\Permission\PermissionRegistrar;

class Role extends SpatieRoleModel
{
    use HasFactory;

    /**
     * adding using to catch attach and detach event
     *
     * A role may be given various permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            PermissionRegistrar::$pivotRole,
            PermissionRegistrar::$pivotPermission
        )->using(PermissionRole::class);
    }
}
