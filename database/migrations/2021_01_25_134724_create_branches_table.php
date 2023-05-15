<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lat')->comment('lat for location latitude');
            $table->string('lng')->comment('lng for location longitude');;
            $table->string('phone');
            $table->string('another_phone')->nullable();
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
        Schema::dropIfExists('branches');
    }
}
