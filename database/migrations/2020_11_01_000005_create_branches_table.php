<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cities_id');
            $table->string('name');
            $table->string('code')->unique();
            $table->longText('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('eos')->nullable();
            $table->string('eos_number')->nullable();
            $table->string('pic')->nullable();
            $table->string('pic_number')->nullable();
            $table->string('pic_ga')->nullable();
            $table->string('pic_ga_number')->nullable();
            $table->string('note')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->string('user');

            $table->foreign('cities_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
