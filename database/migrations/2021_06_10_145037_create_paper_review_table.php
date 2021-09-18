<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaperReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paper_id');
            $table->unsignedBigInteger('review_id');
            $table->integer('status')->default(0);
            $table->string('observation', 500)->nullable();
            $table->string('issue', 2000)->nullable();
            $table->integer('relevance')->nullable();
            $table->string('search_terms',500)->nullable();
            $table->string('techinique',500)->nullable();
            $table->string('approach',2000)->nullable();
            $table->string('features',500)->nullable();
            $table->string('goals',500)->nullable();
            $table->string('hypothesis',500)->nullable();
            $table->string('main_contribuition',500)->nullable();
            $table->string('evaluation_metrics',500)->nullable();
            $table->string('baselines',500)->nullable();
            $table->string('datasets',500)->nullable();
            $table->string('codelink')->nullable();
            $table->string('research_methodology',500)->nullable();
            $table->string('algorithm_complexity',500)->nullable();
            $table->string('future_work',2000)->nullable();
            $table->string('open_works',2000)->nullable();
            $table->boolean('star')->nullable();
            $table->boolean('discarded')->default(false);

            $table->foreign('paper_id')->references('id')->on('papers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('paper_reviews');
    }
}
