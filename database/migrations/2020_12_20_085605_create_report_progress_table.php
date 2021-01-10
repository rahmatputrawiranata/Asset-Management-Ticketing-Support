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
            $table->unsignedBigInteger('report_id');
            $table->string('progress_code');
            $table->json('descriptions')->nullable();
            $table->string('notes')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->string('user');


            $table->foreign('report_id')->references('id')->on('reports');

        });

        Schema::table('report_progress', function (Blueprint $table) {
            $table->foreign('progress_code')->references('key')->on('master_data');
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
