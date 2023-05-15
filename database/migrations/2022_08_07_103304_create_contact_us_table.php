<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('phone',25);
            $table->tinyInteger('subject')->comment('1 => Complaint | 2 => Suggestion | 3 => Payment problem | 4 => Other');
            $table->text('message');
            $table->text('notes')->nullable();
            $table->tinyInteger('status')->default(2)->comment('1 => Handled | 2 => Pending');
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
        Schema::dropIfExists('contact_us');
    }
}
