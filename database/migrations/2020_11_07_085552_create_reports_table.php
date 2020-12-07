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
            $table->string('ticket_help_desk')->nullable();
            $table->string('severity_code');
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('worker_type')->nullable();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->string('branch_code');
            $table->longText('report_notes');
            $table->string('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->string('user');

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('branch_code')->references('code')->on('branches');
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('device_id')->references('id')->on('devices');
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
