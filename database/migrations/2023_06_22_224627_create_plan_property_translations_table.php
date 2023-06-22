<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanPropertyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_property_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_property_id');
            $table->string('locale')->index();

            $table->string('name');
            $table->string('value');

            $table->unique(['plan_property_id', 'locale']);
            $table->foreign('plan_property_id')->references('id')->on('plan_properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_property_translations');
    }
}
