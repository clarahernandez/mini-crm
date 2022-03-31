<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemProperty extends Model
{
    protected $fillable = [
        'item_id',
        'property_id',
    ];

    protected $table = 'items_properties';

    static public function deleteAllByItemId($id)
    {
        self::where('item_id', '=',  $id)->delete();
    }
}
