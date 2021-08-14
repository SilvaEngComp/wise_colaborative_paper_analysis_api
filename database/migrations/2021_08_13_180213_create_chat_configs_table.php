<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('audio')->default(1);
            $table->boolean('favorite')->default(0);
                 $table->unsignedBigInteger('sender');
            $table->unsignedBigInteger('receiver');
            $table->timestamps();

            $table->foreign('sender')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('receiver')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_configs');
    }
}
