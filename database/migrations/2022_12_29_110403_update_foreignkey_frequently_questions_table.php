<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignkeyFrequentlyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frequently_questions', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->nullable()->change();
            $table->tinyInteger('where_show')->default(0)->comment('0 => FAQ Page| 1 => Services Page | 2 => Blog Page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frequently_questions', function (Blueprint $table) {
            //
        });
    }
}
