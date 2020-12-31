<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_data', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('parent')->nullable();
            $table->string('key');
            $table->string('value_type');
            $table->longText('value');
            $table->string('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent')->references('key')->on('master_data');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_data');
    }
}
