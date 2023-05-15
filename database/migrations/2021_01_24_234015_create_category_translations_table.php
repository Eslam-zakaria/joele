<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedInteger('category_id');

            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('description', 100)->nullable();

            $table->string('alt_image', 100)->nullable();
            $table->string('meta_title', 100)->nullable();
            $table->text('meta_description', 100)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical')->nullable();
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
        Schema::dropIfExists('category_translations');
    }
}
