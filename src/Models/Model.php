<?php

namespace Mission4\CinnamonRole\Models;

use Illuminate\Database\Eloquent\Model as LaravelModel;

class Model extends LaravelModel
{
    public function getAttributesAttribute()
    {
        return collect($this->attributes)->except('id');
    }

    public function getDataAttribute()
    {
        return [
            'id'         => $this->id,
            'attributes' => $this->attributes,
        ];
    }
}
