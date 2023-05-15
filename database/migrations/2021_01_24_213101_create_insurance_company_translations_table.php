<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCompanyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_company_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();
            // Foreign key to the main model
            $table->unsignedInteger('insurance_company_id');
            $table->string('title');
            $table->text('content');
            $table->timestamps();

            $table->foreign('insurance_company_id')->references('id')->on('insurance_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_company_translations');
    }
}
