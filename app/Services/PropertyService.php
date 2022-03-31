<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;

class PropertyService
{
    /**
     * @return Property[]|Collection
     */
    public function getAll()
    {
        return Property::all();
    }
}
