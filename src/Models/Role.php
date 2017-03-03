<?php

namespace Mission4\CinnamonRole\Models;

class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function getDataAttribute()
    {
        return [
            'id'            => $this->id,
            'type'          => 'roles',
            'attributes'    => $this->attributes,
            'relationships' => [
                'permissions' => [
                    'data' => $this->permissions->map(function ($p) {
                        return [
                            'id'   => $p->id,
                            'type' => 'permissions',
                        ];
                    }),
                ],
            ],
        ];
    }
}
