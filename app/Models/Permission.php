<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission as SpatiePermissionModel;
use Spatie\Permission\PermissionRegistrar;

class Permission extends SpatiePermissionModel
{
    use HasFactory;
}
