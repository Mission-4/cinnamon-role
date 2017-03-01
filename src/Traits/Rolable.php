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

    public function hasAbility($abilityName)
    {
    	if(!$this->role){
    		return false;
    	}
        $permissions = $this->role->permissions->pluck('slug');
        return $permissions->contains($abilityName);
    }
}