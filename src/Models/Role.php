<?php

namespace Mission4\CinnamonRole\Models;

class Role extends Model
{
	public function permissions()
	{
	    return $this->belongsToMany(Permissions::class);
	}
}
