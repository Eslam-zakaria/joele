<?php

use App\Constants\Statuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');

            $table->string('locale')->default('ar');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('new_slug')->nullable()->unique();
            $table->text('description');
            $table->longText('content')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('canonical')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('alt_image')->nullable();

            $table->tinyInteger('status')->default(\App\Constants\Statuses::ACTIVE)->comment('1 = DISABLED | 2 => ACTIVE');

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
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('blogs');
    }
}
