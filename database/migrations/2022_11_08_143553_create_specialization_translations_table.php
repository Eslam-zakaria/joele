<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecializationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialization_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedInteger('specialization_id');
            $table->unique(['specialization_id', 'locale']);
            $table->string('name');

            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialization_translations');
    }
}
