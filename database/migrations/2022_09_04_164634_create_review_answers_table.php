<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_answers', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('review_id')->nullable();
            $table->unsignedInteger('review_question_id')->nullable();
            $table->tinyInteger('answer')->comment('1 => Unsatisfactory | 2 => Satisfying | 3 => very satisfying');
            $table->timestamps();

            $table->foreign('review_question_id')->references('id')->on('review_questions')->onDelete('SET NULL');
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_answers');
    }
}
