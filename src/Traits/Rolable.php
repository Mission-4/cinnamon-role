<?php

namespace Mission4\CinnamonRole\Traits;

use Mission4\CinnamonRole\Models\Role;

trait Rolable {
	public function role()
	{
		return $this->belongsTo(Role::class);
	}

    public function getDataAttribute()
    {
    	return [
			"id" => $this->id,
			"attributes" => collect($this->attributes)->except($this->hidden),
			"relationships" => [
				"role" => [
					"data" => $this->role ? collect($this->role->data)->except('relationships', 'attributes') : null
				]
			]
		];
    }
}