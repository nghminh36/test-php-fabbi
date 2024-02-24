<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_meals', function (Blueprint $table) {
            $table->foreignId('dish_id')->constrained('dishes');
            $table->foreignId('meal_id')->constrained('meals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dish_meals', function (Blueprint $table) {
            //
        });
    }
}
