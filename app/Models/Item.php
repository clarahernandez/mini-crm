<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'items';

    public function properties()
    {
        return $this->belongsToMany(
            Property::class,
            'items_properties',
            'item_id',
            'property_id'
        );
    }
}
