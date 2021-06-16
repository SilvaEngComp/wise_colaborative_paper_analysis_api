<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('base_id');
            $table->string('title', 500);
            $table->string('authors', 500);
            $table->string('publication_title', 500)->nullable();
            $table->string('publication_year')->nullable();
            $table->string('volume')->nullable();
            $table->string('start_page')->nullable();
            $table->string('end_page')->nullable();
            $table->string('abstract',5000)->nullable();
            $table->string('issn')->nullable();
            $table->string('isbn')->nullable();
            $table->string('doi')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('keywords', 500)->nullable();

            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers');
    }
}
