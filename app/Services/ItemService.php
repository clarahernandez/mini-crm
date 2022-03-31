<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemProperty;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ItemService
{
    /**
     * @param string $name
     * @param array|null $properties
     * @return Item
     */
    public function create(string $name, ?array $properties)
    {
        DB::beginTransaction();

        $item = new Item(['name' => $name]);

        $item->save();
        if (!is_null($properties)) {
            $item->properties()->sync($properties);
        }

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
     * @param int $id
     * @throws Exception
     */
    public function destroy(int $id): void
    {
        DB::beginTransaction();


        ItemProperty::deleteAllByItemId($id);

        $destroyed = Item::destroy($id);

        if (!$destroyed) {
            throw new Exception("Item doesn't exist");
        }
        DB::commit();
        Item::destroy($id);
    }
}
