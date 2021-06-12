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
            $table->string('title');
            $table->string('authors');
            $table->string('publication_title')->nullable();
            $table->string('publication_year')->nullable();
            $table->string('volume')->nullable();
            $table->string('start_page')->nullable();
            $table->string('end_page')->nullable();
            $table->string('abstract')->nullable();
            $table->string('issn')->nullable();
            $table->string('isbn')->nullable();
            $table->string('doi')->nullable();
            $table->string('link')->nullable();
            $table->string('keywords')->nullable();
            $table->string('search_terms')->nullable();
            $table->string('inspec_controlled_terms')->nullable();
            $table->string('not_inspec_controlled_terms')->nullable();
            $table->string('mesh_terms')->nullable();


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
