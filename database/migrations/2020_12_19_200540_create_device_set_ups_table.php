<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceSetUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_set_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('kind_of_damage_type_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('kind_of_damage_type_id')->references('id')->on('kind_of_damage_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_set_ups');
    }
}
