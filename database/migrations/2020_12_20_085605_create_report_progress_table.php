<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reports_id');
            $table->string('progress_code');
            $table->json('descriptions');
            $table->string('notes');
            $table->string('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->string('user');


            $table->foreign('reports_id')->references('id')->on('reports');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_progress');
    }
}
