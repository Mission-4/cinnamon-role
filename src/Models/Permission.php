<?php

namespace Mission4\CinnamonRole\Models;

class Permission extends Model
{
	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

	public function getDataAttribute()
	{
		return [
			"id" => $this->id,
			"type" => "permissions",
			"attributes" => $this->attributes,
			"relationships" => [
				"roles" => [
					"data" => $this->roles->map(function($r){
						return [
							"id" => $r->id,
							"type" => "roles",
						];
					})
				],
			]
		];
	}
}
