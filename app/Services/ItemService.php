<?php

namespace App\Services;

use App\Models\Item;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ItemService
{
    /**
     * @param string $name
     * @param array $properties
     * @return Item
     */
    public function create(string $name, array $properties)
    {
        DB::beginTransaction();

        $item = new Item(['name' => $name]);

        $item->save();
        $item->properties()->sync($properties);

        DB::commit();
        return $item;
    }

    /**
     * @param Item $item
     * @param $name
     * @param $properties
     * @return Item
     */
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

    /**
     * @return Item[]|Collection
     */
    public function getAll()
    {
        return Item::all();
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function destroy($id): void
    {
        $destroyed = Item::destroy($id);

        if (!$destroyed) {
            throw new Exception("Item doesn't exist");
        }

        Item::destroy($id);
    }
}
