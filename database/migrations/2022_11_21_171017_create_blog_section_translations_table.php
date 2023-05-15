<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogSectionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_section_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedInteger('blog_section_id');
            $table->unique(['blog_section_id', 'locale']);
            $table->foreign('blog_section_id')->references('id')->on('blog_sections')->onDelete('cascade');

            $table->string('title');
            $table->longText('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_section_translations');
    }
}
