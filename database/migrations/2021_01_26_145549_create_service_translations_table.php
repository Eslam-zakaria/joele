<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedInteger('service_id');
            $table->unique(['service_id', 'locale']);
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('new_slug')->nullable()->unique();
            $table->text('description');
            $table->text('content');
            $table->text('alt_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('canonical')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
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
        Schema::dropIfExists('service_translations');
    }
}
