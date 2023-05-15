<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewQuestionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_question_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedInteger('review_question_id');
            $table->unique(['review_question_id', 'locale']);
            $table->foreign('review_question_id')->references('id')->on('review_questions')->onDelete('cascade');

            $table->string('question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revie_question_translations');
    }
}
