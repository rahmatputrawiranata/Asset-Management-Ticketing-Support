<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no');
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->unsignedBigInteger('kind_of_damage_type_id')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->longText('report_notes');
            $table->string('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->string('user');

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('kind_of_damage_type_id')->references('id')->on('kind_of_damage_types');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
