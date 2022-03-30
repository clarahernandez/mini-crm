<?php

use App\Models\Item;
use App\Models\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
            $table->foreignIdFor(Property::class);
            $table->unique(['property_id', 'item_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_properties');
    }
}
