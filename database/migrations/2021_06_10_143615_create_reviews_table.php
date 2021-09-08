<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('question')->nullable();
            $table->string('description')->nullable();
            $table->string('include_criteria',500)->nullable();
            $table->string('exclude_criteria',500)->nullable();
            $table->unsignedBigInteger('instituition_id')->nullable();
            $table->timestamps();
            $table->foreign('instituition_id')->references('id')->on('instituitions')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
