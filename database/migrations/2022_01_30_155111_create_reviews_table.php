<?php

use App\Constants\Statuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');

            # Personal Information's.
            $table->string('name');
            $table->string('phone', 20);
            $table->tinyInteger('status')->default(1)->comment('1 => Handled | 2 => Pending');

            # Service data.
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('doctor_id');
            $table->text('message');
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
