<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_reference')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('doctor_id')->nullable();
            $table->unsignedInteger('offer_id')->nullable();
            $table->float('price')->nullable();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('payment_type')->nullable();
            $table->date('attendance_date')->nullable();
            $table->string('available_time')->nullable();
            $table->string('note')->nullable();
            $table->tinyInteger('status')->default(1)
                ->comment('1 => Pending | 2 => Confirmed | 3 => No Answer | 4 => Canceled | 5 => Not Confirmed');
            $table->tinyInteger('type')->comment('1 => For Doctor | 2 => For Offer');
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
        Schema::dropIfExists('bookings');
    }
}
