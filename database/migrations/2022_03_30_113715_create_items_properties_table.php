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

            $table->foreignId('property_id')->references('id')->on('properties');
            $table->foreignId('item_id')->references('id')->on('items');

            $table->unique(['property_id', 'item_id']);
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
