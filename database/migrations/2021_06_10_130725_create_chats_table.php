<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message',10000)->nulnullableable();
            $table->string('file_path')->nullable();
            $table->string('receiver_read')->nullable();
            $table->boolean('deleted')->default(0);
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
        Schema::dropIfExists('chats');
    }
}
