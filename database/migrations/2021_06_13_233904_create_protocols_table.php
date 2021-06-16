<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('protocol_type_id');
            $table->string('question')->nullable();
            $table->string('answer')->nullable();
            $table->timestamps();

            $table->foreign('protocol_type_id')->references('id')->on('protocol_types')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protocols');
    }
}
