<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrequentlyQuestionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frequently_question_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedInteger('frequently_question_id');
            $table->foreign('frequently_question_id')->references('id')->on('frequently_questions')->onDelete('cascade');

            $table->string('question');
            $table->text('answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frequently_question_translations');
    }
}
