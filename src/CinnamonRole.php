<?php

namespace Mission4\CinnamonRole;

use Gate;
use Mission4\CinnamonRole\Models\Permission;
use Schema;

class CinnamonRole
{
    public static function registerPermissions()
    {
        if (Schema::hasTable('permissions')) {
            Permission::all()->each(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasAbility($permission->slug);
                });
            });
        }
    }
}
