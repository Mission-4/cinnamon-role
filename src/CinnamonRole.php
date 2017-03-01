<?php

namespace Mission4\CinnamonRole;

use Gate;
use Mission4\CinnamonRole\Models\Permission;

class CinnamonRole {
	public static function registerPermissions()
	{
		Permission::all()->each(function($permission){
            Gate::define($permission->slug, function($user) use ($permission) {
                return $user->hasAbility($permission->slug);
            });
        });
	}
}