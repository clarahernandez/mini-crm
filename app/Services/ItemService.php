<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemService
{
    public function create(string $name, array $properties)
    {
        DB::beginTransaction();

        $item = new Item(['name' => $name]);

        $item->save();
        $item->properties()->sync($properties);

        DB::commit();
        return $item;
    }

    public function update(Item $item, $name, $properties)
    {
        DB::beginTransaction();

        $item->update([
            'name' => $name
        ]);

        $item->properties()->sync($properties);

        $item->save();

        DB::commit();

        return $item->refresh();
    }

    public function getAll()
    {
        return Item::all();
    }

    public function destroy($id): void
    {
        $destroyed = Item::destroy($id);

        if (!$destroyed) {
            throw new \Exception("Item doesn't exist");
        }

        Item::destroy($id);
    }
}
